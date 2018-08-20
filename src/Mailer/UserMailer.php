<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function activation($user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: New Account", h(get_option('site_name'))))
            ->viewVars([
                'username' => $user->username,
                'activation_key' => $user->activation_key
            ])
            ->template('register')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function changeEmail($user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->temp_email)
            ->subject(__("{0}: Change Email", h(get_option('site_name'))))
            ->viewVars([
                'username' => $user->username,
                'activation_key' => $user->activation_key
            ])
            ->template('change_email')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function forgotPassword($user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: Password Reset", h(get_option('site_name'))))
            ->viewVars([
                'username' => $user->username,
                'activation_key' => $user->activation_key
            ])
            ->template('reset_password')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }
}
