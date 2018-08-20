<?php

namespace App\Controller\Auth;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;
use Cake\I18n\I18n;
use Cake\I18n\Time;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    use MailerAwareTrait;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Captcha');

        if (in_array($this->request->action, ['multidomainsAuth'])) {
            $this->eventManager()->off($this->Csrf);
            $this->eventManager()->off($this->Security);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['multidomainsAuth', 'signup', 'logout', 'activateAccount', 'forgotPassword']);
        $this->viewBuilder()->layout('auth');

        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], get_site_languages(true))) {
            I18n::locale($_COOKIE['lang']);
        }
    }

    public function signin()
    {
        if ($this->Auth->user('id')) {
            return $this->redirect('/');
        }

        $user = $this->Users->newEntity();
        $this->set('user', $user);

        if ($this->request->is('post')) {
            if ((get_option('enable_captcha_signin', 'no') == 'yes') &&
                isset_captcha() &&
                !$this->Captcha->verify($this->request->data)
            ) {
                $this->Flash->error(__('The CAPTCHA was incorrect. Try again'));
                return null;
            }
        }

        if ($this->request->is('post') || $this->request->query('provider')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                $_SESSION['Auth']['domains_auth'] = 'none';
                $multi_domains = get_all_multi_domains_list();
                $main_domain = get_option('main_domain', '');
                unset($multi_domains[$main_domain]);
                if (count($multi_domains)) {
                    $_SESSION['Auth']['User']['domains_auth'] = 'required';
                }

                if ('admin' == $user['role']) {
                    return $this->redirect([
                        'plugin' => false,
                        'controller' => 'Users',
                        'action' => 'dashboard',
                        'prefix' => 'admin'
                    ]);
                }
                return $this->redirect([
                    'plugin' => false,
                    'controller' => 'Users',
                    'action' => 'dashboard',
                    'prefix' => 'member'
                ]);
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function multidomainsAuth()
    {
        $this->autoRender = false;

        $this->response->type('gif');

        $this->response->body(base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='));

        if (!$this->request->is('get')) {
            return $this->response;
        }

        try {
            if (isset($this->request->query['auth']) && !empty($this->request->query['auth'])) {
                $auth = data_decrypt($this->request->query['auth']);

                if ((time() - $auth['time']) > 60) {
                    return $this->response;
                }

                session_write_close();

                session_name($auth['session_name']);
                session_id($auth['session_id']);

                session_start();
            }
        } catch (\Exception $ex) {
        }
        return $this->response;
    }

    public function signup()
    {
        if ($this->Auth->user('id')) {
            return $this->redirect('/');
        }

        if ((bool)get_option('close_registration', false)) {
            return $this->redirect('/');
        }

        $user = $this->Users->newEntity();

        $this->set('user', $user);

        if ($this->request->is('post')) {
            if ((get_option('enable_captcha_signup') == 'yes') &&
                isset_captcha() &&
                !$this->Captcha->verify($this->request->data)
            ) {
                $this->Flash->error(__('The CAPTCHA was incorrect. Try again'));
                return null;
            }

            $user = $this->Users->patchEntity($user, $this->request->data);

            $referred_by_id = 0;
            if (isset($_COOKIE['ref']) && !empty($_COOKIE['ref'])) {
                $user_referred_by = $this->Users->find()
                    ->where([
                        'username' => $_COOKIE['ref'],
                        'status' => 1
                    ])
                    ->first();

                if ($user_referred_by) {
                    $referred_by_id = $user_referred_by->id;
                }
            }
            $user->referred_by = $referred_by_id;

            $user->api_token = \Cake\Utility\Security::hash(\Cake\Utility\Text::uuid(), 'sha1', true);
            $user->activation_key = \Cake\Utility\Security::hash(\Cake\Utility\Text::uuid(), 'sha1', true);

            $user->plan_id = 1;
            $user->role = 'member';
            $user->status = 1;
            $user->register_ip = get_ip();

            $user->publisher_earnings = price_database_format(get_option('signup_bonus', 0));

            $trial_plan = (int)get_option('trial_plan', '');
            if ($trial_plan > 1) {
                $plan_expiration = Time::now();
                $expiration = $plan_expiration->addYear();
                if (get_option('trial_plan_period', 'm') === 'm') {
                    $expiration = $plan_expiration->addMonth();
                }
                $user->plan_id = $trial_plan;
                $user->expiration = $expiration;
            }

            if (get_option('account_activate_email', 'yes') == 'yes') {
                $user->status = 2;
            }

            if ($this->Users->save($user)) {
                if ((bool)get_option('alert_admin_new_user_register', 0)) {
                    $this->getMailer('Notification')->send('newRegistration', [$user]);
                }

                if (get_option('account_activate_email', 'yes') == 'yes') {
                    // Send activation email
                    $this->getMailer('User')->send('activation', [$user]);

                    $this->Flash->success(__('Your account has been created. Please check your email inbox ' .
                        'or spam folder to activate your account.'));
                    return $this->redirect(['action' => 'signin']);
                }

                $this->Flash->success(__('Your account has been created.'));
                return $this->redirect(['action' => 'signin']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function activateAccount($username = null, $key = null)
    {
        if (!$username && !$key) {
            $this->Flash->error(__('Invalid Activation.'));
            return $this->redirect(['action' => 'signin']);
        }
        $user = $this->Users->find()
            ->contain(['Plans'])
            ->where([
                'Users.status' => 2,
                'Users.username' => $username,
                'Users.activation_key' => $key
            ])
            ->first();

        if (!$user) {
            $this->Flash->error(__('Invalid Activation.'));
            return $this->redirect(['action' => 'signin']);
        }

        $user->status = 1;
        $user->activation_key = '';


        if ($this->Users->save($user)) {
            $this->Flash->success(__('Your account has been activated.'));
            $this->Auth->setUser($user->toArray());
            return $this->redirect(['controller' => 'users', 'action' => 'dashboard', 'prefix' => 'member']);
        } else {
            $this->Flash->error(__('Unable to activate your account.'));
            return $this->redirect(['action' => 'signin', 'prefix' => 'auth']);
        }
    }

    public function forgotPassword($username = null, $key = null)
    {
        if ($this->Auth->user('id')) {
            return $this->redirect('/');
        }

        if (!$username && !$key) {
            $user = $this->Users->newEntity();
            $this->set('user', $user);

            if ($this->request->is(['post', 'put'])) {
                if ((get_option('enable_captcha_forgot_password') == 'yes') &&
                    isset_captcha() &&
                    !$this->Captcha->verify($this->request->data)
                ) {
                    $this->Flash->error(__('The CAPTCHA was incorrect. Try again'));
                    return null;
                }

                $user = $this->Users->findByEmail($this->request->data['email'])->first();

                if (!$user) {
                    $this->Flash->error(__('Invalid User.'));
                    return $this->redirect(['action' => 'forgotPassword', 'prefix' => 'auth']);
                }

                $user->activation_key = \Cake\Utility\Security::hash(\Cake\Utility\Text::uuid(), 'sha1', true);

                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'forgotPassword']);

                if ($this->Users->save($user)) {
                    // Send rest email
                    $this->getMailer('User')->send('forgotPassword', [$user]);

                    $this->Flash->success(__('Kindly check your email for reset password link.'));

                    return $this->redirect(['action' => 'forgotPassword', 'prefix' => 'auth']);
                } else {
                    $this->Flash->error(__('Unable to reset password.'));

                    return $this->redirect(['action' => 'forgotPassword', 'prefix' => 'auth']);
                }
            }
        } else {
            $user = $this->Users->find('all')
                ->where([
                    'status' => 1,
                    'username' => $username,
                    'activation_key' => $key
                ])
                ->first();
            if (!$user) {
                $this->Flash->error(__('Invalid Request.'));
                return $this->redirect(['action' => 'forgotPassword', 'prefix' => 'auth']);
            }

            if ($this->request->is(['post', 'put'])) {
                $user->activation_key = '';

                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'forgotPassword']);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your password has been changed.'));
                    return $this->redirect(['action' => 'signin', 'prefix' => 'auth']);
                } else {
                    $this->Flash->error(__('Unable to change your password.'));
                }
            }

            unset($user->password);

            $this->set('user', $user);
        }
    }
}
