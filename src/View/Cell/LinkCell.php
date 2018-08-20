<?php

namespace App\View\Cell;

use Cake\View\Cell;

class LinkCell extends Cell
{
    public function shortenMember()
    {
        $this->loadModel('Users');

        $user = $this->Users->find()->contain('Plans')->where([
            'Users.id' => $this->request->session()->read('Auth.User.id'),
            'Users.status' => 1
        ])->first();

        $custom_alias = true;
        $multi_domains = true;

        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->alias) {
                $custom_alias = false;
            }
            if (!get_user_plan($user)->multi_domains) {
                $multi_domains = false;
            }
        }
        $this->set('custom_alias', $custom_alias);
        $this->set('multi_domains', $multi_domains);
    }
}
