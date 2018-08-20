<?php

namespace App\Controller;

use App\Controller\FrontController;
use Cake\Event\Event;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends FrontController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Cookie');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['ref']);
    }

    public function ref($username = null)
    {
        $this->autoRender = false;

        if (!$username) {
            return $this->redirect('/');
        }

        $user = $this->Users->find()->where(['username' => $username, 'status' => 1])->first();

        if (!$user) {
            return $this->redirect('/');
        }

        $this->Cookie->configKey('ref', [
            'expires' => '+3 month',
            'httpOnly' => true,
            'encryption' => false
        ]);
        $this->Cookie->write('ref', $username);

        return $this->redirect('/');
    }
}
