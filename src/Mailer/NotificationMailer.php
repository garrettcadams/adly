<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;

class NotificationMailer extends Mailer
{
    public function newRegistration($user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to(get_option('admin_email'))
            ->subject(__("{0}: New User Registration", h(get_option('site_name'))))
            ->viewVars([
                'user' => $user
            ])
            ->template('admin_register')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function newWithdrawal($withdraw, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to(get_option('admin_email'))
            ->subject(__("{0}: New Withdrawal Request", h(get_option('site_name'))))
            ->viewVars([
                'withdraw' => $withdraw,
                'user' => $user
            ])
            ->template('admin_withdrawal')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function newInvoice($invoice, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to(get_option('admin_email'))
            ->subject(__("{0}: New Invoice", h(get_option('site_name'))))
            ->viewVars([
                'invoice' => $invoice,
                'user' => $user
            ])
            ->template('admin_invoice')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function newPaidInvoice($invoice, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to(get_option('admin_email'))
            ->subject(__("{0}: Paid Invoice", h(get_option('site_name'))))
            ->viewVars([
                'invoice' => $invoice,
                'user' => $user
            ])
            ->template('admin_paid_invoice')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function approveWithdraw($withdraw, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: Your Request for Withdrawal has been Approved", h(get_option('site_name'))))
            ->viewVars([
                'withdraw' => $withdraw,
                'user' => $user
            ])
            ->template('approve_withdraw')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function completeWithdraw($withdraw, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: Your Request for Withdrawal has been Processed", h(get_option('site_name'))))
            ->viewVars([
                'withdraw' => $withdraw,
                'user' => $user
            ])
            ->template('complete_withdraw')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function cancelWithdraw($withdraw, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: Your Request for Withdrawal has been Canceled", h(get_option('site_name'))))
            ->viewVars([
                'withdraw' => $withdraw,
                'user' => $user
            ])
            ->template('cancel_withdraw')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }

    public function returnWithdraw($withdraw, $user)
    {
        $this
            ->profile(get_option('email_method', 'default'))
            ->from([get_option('email_from', 'no_reply@localhost') => get_option('site_name')])
            ->to($user->email)
            ->subject(__("{0}: Your Request for Withdrawal has been Returned", h(get_option('site_name'))))
            ->viewVars([
                'withdraw' => $withdraw,
                'user' => $user
            ])
            ->template('return_withdraw')// By default template with same name as method name is used.
            ->layout('app')
            ->emailFormat('both');
    }
}
