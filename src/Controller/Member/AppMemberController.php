<?php

namespace App\Controller\Member;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class AppMemberController extends AppController
{
    public $logged_user;

    public $logged_user_plan;

    public $paginate = [
        'limit' => 10,
        'order' => ['id' => 'DESC']
    ];

    public function isAuthorized($user)
    {
        // Admin can access every action
        if (in_array($user['role'], ['member', 'admin'])) {
            return true;
        }

        // Default deny
        return false;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->layout('member');

        // Check if SSL is enabled.
        if ($this->setLanguage()) {
            $protocol = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") ? "http://" : "https://";
            $request_url = str_replace('lang=' . $this->request->query['lang'], '', env('REQUEST_URI'));
            return $this->redirect($protocol . env('HTTP_HOST') . $request_url, 307);
        }

        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], get_site_languages(true))) {
            I18n::locale($_COOKIE['lang']);
        }

        if ($this->Auth->user('id')) {
            $this->loadModel('Users');
            $user = $this->Users->find()->contain(['Plans'])
                ->where(['Users.id' => $this->Auth->user('id')])->first();

            $this->logged_user = $user;
            $this->set('logged_user', $user);

            $user_plan = get_user_plan($user);
            $this->logged_user_plan = $user_plan;
            $this->set('logged_user_plan', $user_plan);
        }

    }
}
