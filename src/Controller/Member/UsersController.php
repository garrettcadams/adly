<?php

namespace App\Controller\Member;

use App\Controller\Member\AppMemberController;
use Cake\Mailer\MailerAwareTrait;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\AnnouncementsTable $Announcements
 */
class UsersController extends AppMemberController
{
    use MailerAwareTrait;

    public function dashboard()
    {
        $domains_auth_urls = [];
        $multi_domains = get_all_multi_domains_list();
        $main_domain = get_option('main_domain', '');
        unset($multi_domains[$main_domain]);

        if (isset($_SESSION['Auth']['User']['domains_auth']) &&
            $_SESSION['Auth']['User']['domains_auth'] == 'required' &&
            count($multi_domains)
        ) {
            $data = urlencode(data_encrypt([
                'session_name' => session_name(),
                'session_id' => session_id(),
                'time' => time()
            ]));

            foreach ($multi_domains as $key => $value) {
                $domains_auth_urls[] = '//' . $value . $this->request->base . '/auth/users/multidomains-auth' .
                    '?auth=' . $data;
            }
        }
        $this->set('domains_auth_urls', $domains_auth_urls);

        $auth_user_id = $this->Auth->user('id');

        /**
         * @var \App\Model\Entity\Statistic $last_record
         */
        $last_record = $this->Users->Statistics->find()
            ->select('created')
            ->where(['user_id' => $auth_user_id])
            ->order(['created' => 'DESC'])
            ->first();

        if (!$last_record) {
            $last_record = Time::now();
        } else {
            $last_record = $last_record->created;
        }

        /**
         * @var \App\Model\Entity\Statistic $first_record
         */
        $first_record = $this->Users->Statistics->find()
            ->select('created')
            ->where(['user_id' => $auth_user_id])
            ->order(['created' => 'ASC'])
            ->first();

        if (!$first_record) {
            $first_record = Time::now()->modify('-1 second');
        } else {
            $first_record = $first_record->created;
        }

        $year_month = [];

        $last_month = Time::now()->year($last_record->year)->month($last_record->month)->startOfMonth();
        $first_month = Time::now()->year($first_record->year)->month($first_record->month)->startOfMonth();

        while ($first_month <= $last_month) {
            $year_month[$last_month->format('Y-m')] = $last_month->i18nFormat('LLLL Y');

            $last_month->modify('-1 month');
        }

        $this->set('year_month', $year_month);

        $to_month = Time::now()->format('Y-m');
        if (isset($this->request->query['month']) &&
            array_key_exists($this->request->query['month'], $year_month)
        ) {
            $to_month = explode('-', $this->request->query['month']);
            $year = (int)$to_month[0];
            $month = (int)$to_month[1];
        } else {
            $time = new Time($to_month);
            $current_time = $time->startOfMonth();

            $year = (int)$current_time->format('Y');
            $month = (int)$current_time->format('m');
        }

        $date1 = Time::createFromDate($year, $month, 01)->startOfMonth()->format('Y-m-d H:i:s');
        $date2 = Time::createFromDate($year, $month, 01)->endOfMonth()->format('Y-m-d H:i:s');

        $connection = ConnectionManager::get('default');

        $CurrentMonthDays = Cache::read('currentMonthDays_' . $auth_user_id . '_' . $date1 . '_' . $date2, '15min');
        if ($CurrentMonthDays === false) {
            $sql = "SELECT 
                  CASE
                    WHEN Statistics.publisher_earn > 0
                    THEN
                      DATE_FORMAT(Statistics.created, '%d-%m-%Y')
                  END  AS `day`,
                  CASE
                    WHEN Statistics.publisher_earn > 0
                    THEN
                      COUNT(Statistics.id)
                  END AS `count`,
                  CASE
                    WHEN Statistics.publisher_earn > 0
                    THEN
                      SUM(Statistics.publisher_earn)
                  END AS `publisher_earnings`
                FROM 
                  statistics Statistics 
                WHERE 
                  (
                    Statistics.created BETWEEN :date1 
                    AND :date2 
                    AND Statistics.user_id = {$auth_user_id}
                  ) 
                GROUP BY 
                  day";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue('date1', $date1, 'datetime');
            $stmt->bindValue('date2', $date2, 'datetime');
            $stmt->execute();
            $views_publisher = $stmt->fetchAll('assoc');

            $sql = "SELECT 
                  CASE
                    WHEN Statistics.referral_earn > 0
                    THEN
                      DATE_FORMAT(Statistics.created, '%d-%m-%Y')
                  END  AS `day`,
                  CASE
                    WHEN Statistics.referral_earn > 0
                    THEN
                      SUM(Statistics.referral_earn)
                  END AS `referral_earnings`
                FROM 
                  statistics Statistics 
                WHERE 
                  (
                    Statistics.created BETWEEN :date1 
                    AND :date2 
                    AND Statistics.referral_id = {$auth_user_id}
                  ) 
                GROUP BY 
                  day";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue('date1', $date1, 'datetime');
            $stmt->bindValue('date2', $date2, 'datetime');
            $stmt->execute();
            $views_referral = $stmt->fetchAll('assoc');

            $CurrentMonthDays = [];

            $targetTime = Time::createFromDate($year, $month, 01)->startOfMonth();

            for ($i = 1; $i <= $targetTime->format('t'); $i++) {
                $CurrentMonthDays[$i . "-" . $month . "-" . $year] = [
                    'view' => 0,
                    'publisher_earnings' => 0,
                    'referral_earnings' => 0,
                ];
            }
            foreach ($views_publisher as $view) {
                if (!$view['day']) {
                    continue;
                }
                $day = Time::now()->modify($view['day'])->format('j-n-Y');
                $CurrentMonthDays[$day]['view'] = $view['count'];
                $CurrentMonthDays[$day]['publisher_earnings'] = $view['publisher_earnings'];
            }
            unset($view);
            foreach ($views_referral as $view) {
                if (!$view['day']) {
                    continue;
                }
                $day = Time::now()->modify($view['day'])->format('j-n-Y');
                $CurrentMonthDays[$day]['referral_earnings'] = $view['referral_earnings'];
            }
            unset($view);

            if (get_option('cache_member_statistics', 1)) {
                Cache::write(
                    'currentMonthDays_' . $auth_user_id . '_' . $date1 . '_' . $date2,
                    $CurrentMonthDays,
                    '15min'
                );
            }
        }
        $this->set('CurrentMonthDays', $CurrentMonthDays);

        $this->set('total_views', array_sum(array_column($CurrentMonthDays, 'view')));
        $this->set('total_earnings', array_sum(array_column($CurrentMonthDays, 'publisher_earnings')));
        $this->set('referral_earnings', array_sum(array_column($CurrentMonthDays, 'referral_earnings')));

        /*
        $popularLinks = Cache::read('popularLinks_' . $this->Auth->user('id').'_'.$date1.'_'.$date2, '15min');
        if ($popularLinks === false) {
            $popularLinks = $this->Users->Statistics->find()
                ->contain(['Links'])
                ->select([
                    'Links.alias',
                    'Links.url',
                    'Links.title',
                    'Links.domain',
                    'Links.created',
                    'views' => "count(case when Statistics.publisher_earn > 0 then Statistics.publisher_earn end)",
                    'publisher_earnings' => 'SUM(Statistics.publisher_earn)'
                ])
                ->where([
                    "Statistics.created BETWEEN :date1 AND :date2",
                    'Statistics.user_id' => $this->Auth->user('id')
                ])
                ->order(['views' => 'DESC'])
                ->bind(':date1', $date1, 'datetime')
                ->bind(':date2', $date2, 'datetime')
                ->limit(10)
                ->group('Statistics.link_id')
                ->toArray();
            Cache::write('popularLinks_' . $this->Auth->user('id').'_'.$date1.'_'.$date2, $popularLinks, '15min');
        }

        $this->set('popularLinks', $popularLinks);
        */

        $this->loadModel('Announcements');

        $announcements = $this->Announcements->find()
            ->where(['Announcements.published' => 1])
            ->order(['Announcements.id DESC'])
            ->limit(3)
            ->toArray();
        $this->set('announcements', $announcements);
    }

    public function referrals()
    {
        if ((bool)get_option('enable_referrals', 1) === false) {
            throw new NotFoundException(__('Invalid request'));
        }
        $query = $this->Users->find()
            ->where(['referred_by' => $this->Auth->user('id')]);
        $referrals = $this->paginate($query);

        $this->set('referrals', $referrals);
    }

    public function profile()
    {
        $user = $this->Users->find()->contain(['Plans'])->where(['Users.id' => $this->Auth->user('id')])->first();

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            //debug($user->errors());
            if ($this->Users->save($user)) {
                if ($this->Auth->user('id') === $user->id) {
                    $data = $user->toArray();
                    unset($data['password']);

                    $this->Auth->setUser($data);
                }
                $this->Flash->success(__('Profile has been updated'));
                $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }
        unset($user->password);
        $this->set('user', $user);
    }

    public function plans()
    {
        if ((bool)get_option('enable_premium_membership') === false) {
            throw new NotFoundException(__('Invalid request'));
        }

        $user = $this->Users->findById($this->Auth->user('id'))->contain(['Plans'])->first();
        $this->set('user', $user);

        $plans = $this->Users->plans->find()->where(['enable' => 1, 'hidden' => 0]);
        $this->set('plans', $plans);
    }

    public function payPlan($id = null, $period = null)
    {
        if ((bool)get_option('enable_premium_membership') === false) {
            throw new NotFoundException(__('Invalid request'));
        }

        $this->request->allowMethod(['post']);

        if (!$id || !$period) {
            throw new NotFoundException(__('Invalid request'));
        }

        $plan = $this->Users->Plans->findById($id)->first();

        $amount = $plan->yearly_price;
        $period_name = __("Yearly");
        if ($period === 'm') {
            $amount = $plan->monthly_price;
            $period_name = __("Monthly");
        }

        $data = [
            'status' => 2, //Unpaid Invoice
            'user_id' => $this->Auth->user('id'),
            'description' => __("{0} Premium Membership: {1}", [$period_name, $plan->title]),
            'type' => 1, //Plan Invoice
            'rel_id' => $plan->id, //Plan Id
            'payment_method' => '',
            'amount' => price_database_format($amount),
            'data' => serialize([
                'payment_period' => $period
            ]),
        ];

        $invoice = $this->Users->Invoices->newEntity($data);

        if ($this->Users->Invoices->save($invoice)) {
            if ((bool)get_option('alert_admin_created_invoice', 0)) {
                $this->getMailer('Notification')->send('newInvoice', [$invoice, $this->logged_user]);
            }

            $this->Flash->success(__('An invoice with id: {0} has been generated.', $invoice->id));

            return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
        }
    }

    public function changeEmail($username = null, $key = null)
    {
        if (!$username && !$key) {
            $user = $this->Users->findById($this->Auth->user('id'))->first();

            if ($this->request->is(['post', 'put'])) {
                $uuid = \Cake\Utility\Text::uuid();

                $user->activation_key = \Cake\Utility\Security::hash($uuid, 'sha1', true);

                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'changEemail']);

                if ($this->Users->save($user)) {
                    // Send rest email
                    $this->getMailer('User')->send('changeEmail', [$user]);

                    $this->Flash->success(__('Kindly check your email to confirm it.'));

                    $this->redirect(['action' => 'changeEmail']);
                } else {
                    $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
                }
            }
            $this->set('user', $user);
        } else {
            $user = $this->Users->find('all')
                ->contain(['Plans'])
                ->where([
                    'Users.status' => 1,
                    'Users.username' => $username,
                    'Users.activation_key' => $key
                ])
                ->first();

            if (!$user) {
                $this->Flash->error(__('Invalid Activation.'));

                return $this->redirect(['action' => 'changeEmail']);
            }

            $user->email = $user->temp_email;
            $user->temp_email = '';
            $user->activation_key = '';

            if ($this->Users->save($user)) {
                if ($this->Auth->user('id') === $user->id) {
                    $data = $user->toArray();
                    unset($data['password']);

                    $this->Auth->setUser($data);
                }
                $this->Flash->success(__('Your email has been confirmed.'));

                return $this->redirect(['action' => 'signin', 'prefix' => 'auth']);
            } else {
                $this->Flash->error(__('Unable to confirm your email.'));

                return $this->redirect(['action' => 'changeEmail']);
            }
        }
    }

    public function changePassword()
    {
        $user = $this->Users->findById($this->Auth->user('id'))->first();

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'changePassword']);
            //debug($user->errors());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Password has been updated'));
                $this->redirect(['action' => 'changePassword']);
            } else {
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }
        unset($user->password);
        $this->set('user', $user);
    }
}
