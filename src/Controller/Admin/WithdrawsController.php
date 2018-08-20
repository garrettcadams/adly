<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;
use Cake\Network\Exception\NotFoundException;
use Cake\Mailer\MailerAwareTrait;

/**
 * @property \App\Model\Table\StatisticsTable $Statistics
 * @property \App\Model\Table\WithdrawsTable $Withdraws
 */
class WithdrawsController extends AppAdminController
{
    use MailerAwareTrait;

    public function index()
    {
        $conditions = [];

        $filter_fields = ['user_id', 'status', 'method'];

        //Transform POST into GET
        if ($this->request->is(['post', 'put']) && isset($this->request->data['Filter'])) {
            $filter_url = [];

            $filter_url['controller'] = $this->request->params['controller'];

            $filter_url['action'] = $this->request->params['action'];

            // We need to overwrite the page every time we change the parameters
            $filter_url['page'] = 1;

            // for each filter we will add a GET parameter for the generated url
            foreach ($this->request->data['Filter'] as $name => $value) {
                if (in_array($name, $filter_fields) && strlen($value)) {
                    // You might want to sanitize the $value here
                    // or even do a urlencode to be sure
                    $filter_url[$name] = urlencode($value);
                }
            }
            // now that we have generated an url with GET parameters,
            // we'll redirect to that page
            return $this->redirect($filter_url);
        } else {
            // Inspect all the named parameters to apply the filters
            foreach ($this->request->query as $param_name => $value) {
                $value = urldecode($value);
                if (in_array($param_name, $filter_fields)) {
                    $conditions['Withdraws.' . $param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $query = $this->Withdraws->find()
            ->contain(['Users'])
            ->where($conditions);
        /*
        ->where([
            'Users.status' => 1
        ]);
        */
        $withdraws = $this->paginate($query);
        $this->set('withdraws', $withdraws);

        $publishers_earnings = $this->Withdraws->Users->find()
            ->select(['total' => 'SUM(publisher_earnings)'])
            ->first();
        $this->set('publishers_earnings', $publishers_earnings->total);

        $referral_earnings = $this->Withdraws->Users->find()
            ->select(['total' => 'SUM(referral_earnings)'])
            ->first();
        $this->set('referral_earnings', $referral_earnings->total);

        $pending_withdrawn = $this->Withdraws->find()
            ->select(['total' => 'SUM(amount)'])
            ->where(['status' => 2])
            ->first();

        $this->set('pending_withdrawn', $pending_withdrawn->total);

        $tolal_withdrawn = $this->Withdraws->find()
            ->select(['total' => 'SUM(amount)'])
            ->where(['status' => 3])
            ->first();

        $this->set('tolal_withdrawn', $tolal_withdrawn->total);
    }

    public function export()
    {
        if ($this->request->is('post')) {
            $fields = $this->request->data['fields'];
            $conditions = $this->request->data['conditions'];
            if (empty($fields)) {
                $this->Flash->error(__('Please, select fields to export.'));

                return null;
            }
            $this->processExport($fields, $conditions);
        }
    }

    protected function processExport($fields, $conditions)
    {
        $this->autoRender = false;

        foreach ($conditions as $key => $value) {
            if (empty($value)) {
                unset($conditions[$key]);
            }
        }

        $response = $this->response;
        $response->type('csv');
        $response->download('export-' . date('Y-m-d') . '.csv');

        $users = $this->Withdraws->find()
            ->select($fields)
            ->where($conditions)
            ->order(['id' => 'ASC'])->toArray();

        $header_fields = array_map(function ($value) {
            return '"' . $value . '"';
        }, $fields);

        $content = implode(",", $header_fields) . "\n";

        foreach ($users as $user) {
            $user_data = [];
            foreach ($fields as $field) {
                $user_data[] = '"' . $user->$field . '"';
            }
            $content .= implode(",", $user_data) . "\n";
        }

        $response->body($content);

        return $response;
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Withdraw'));
        }

        $withdraw = $this->Withdraws->find()->contain(['Users'])->where(['Withdraws.id' => $id])->first();
        if (!$withdraw) {
            throw new NotFoundException(__('Invalid Withdraw'));
        }

        $this->set('withdraw', $withdraw);

        $pre_withdraw = $this->Withdraws->find()
            ->where([
                'created <' => $withdraw->created,
                'user_id' => $withdraw->user_id,
                'status !=' => 5
            ])
            ->order(['created' => 'DESC'])
            ->first();

        $this->set('pre_withdraw', $pre_withdraw);

        $this->loadModel('Statistics');

        $date1 = (!$pre_withdraw) ? '0000-00-00 00:00:00' : $pre_withdraw->created;
        $date2 = $withdraw->created;

        $countries = $this->Statistics->find()
            ->select([
                'country',
                'count' => 'COUNT(country)',
                'publisher_earnings' => 'SUM(publisher_earn)',
                //'referral_earnings' => 'SUM(referral_earn)'
            ])
            ->where([
                "Statistics.created BETWEEN :date1 AND :date2",
                'Statistics.publisher_earn >' => 0,
                'Statistics.user_id' => $withdraw->user_id
            ])
            ->bind(':date1', $date1, 'datetime')
            ->bind(':date2', $date2, 'datetime')
            ->order(['count' => 'DESC'])
            ->group(['country'])
            ->toArray();

        $this->set('countries', $countries);

        $reasons = $this->Statistics->find()
            ->select([
                'reason',
                'count' => 'COUNT(reason)'
            ])
            ->where([
                "Statistics.created BETWEEN :date1 AND :date2",
                'Statistics.user_id' => $withdraw->user_id
            ])
            ->bind(':date1', $date1, 'datetime')
            ->bind(':date2', $date2, 'datetime')
            ->order(['count' => 'DESC'])
            ->group(['reason'])
            ->toArray();

        $this->set('reasons', $reasons);

        $ips = $this->Statistics->find()
            ->select([
                'ip',
                'count' => 'COUNT(ip)',
                'publisher_earnings' => 'SUM(publisher_earn)',
                //'referral_earnings' => 'SUM(referral_earn)'
            ])
            ->where([
                "Statistics.created BETWEEN :date1 AND :date2",
                'Statistics.publisher_earn >' => 0,
                'Statistics.user_id' => $withdraw->user_id
            ])
            ->bind(':date1', $date1, 'datetime')
            ->bind(':date2', $date2, 'datetime')
            ->order(['count' => 'DESC'])
            ->group(['ip'])
            ->toArray();

        $this->set('ips', $ips);

        $referrers = $this->Statistics->find()
            ->select([
                'referer_domain',
                'count' => 'COUNT(referer_domain)',
                'publisher_earnings' => 'SUM(publisher_earn)',
                //'referral_earnings' => 'SUM(referral_earn)'
            ])
            ->where([
                "Statistics.created BETWEEN :date1 AND :date2",
                'Statistics.publisher_earn >' => 0,
                'Statistics.user_id' => $withdraw->user_id
            ])
            ->bind(':date1', $date1, 'datetime')
            ->bind(':date2', $date2, 'datetime')
            ->order(['count' => 'DESC'])
            ->group(['referer_domain'])
            ->toArray();

        $this->set('referrers', $referrers);

        $links = $this->Statistics->find()
            ->contain(['Links'])
            ->select([
                'Links.alias',
                'Links.url',
                'Links.title',
                'Links.domain',
                'count' => 'COUNT(Statistics.link_id)',
                'publisher_earnings' => 'SUM(Statistics.publisher_earn)'
            ])
            ->where([
                "Statistics.created BETWEEN :date1 AND :date2",
                'Statistics.publisher_earn >' => 0,
                'Statistics.user_id' => $withdraw->user_id
            ])
            ->order(['count' => 'DESC'])
            ->bind(':date1', $date1, 'datetime')
            ->bind(':date2', $date2, 'datetime')
            ->group('Statistics.link_id')
            ->toArray();

        $this->set('links', $links);
    }

    /*
    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Withdrawal Request'));
        }

        $withdraw = $this->Withdraws->find()->contain(['Users'])->where(['Withdraws.id' => $id])->first();
        if (!$withdraw) {
            throw new NotFoundException(__('Invalid Withdrawal Request'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['amount'] = $withdraw->amount;
            $withdraw = $this->Withdraws->patchEntity($withdraw, $this->request->data);
            if ($this->Withdraws->save($withdraw)) {
                $this->Flash->success(__('The withdrawal request has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                debug($withdraw->errors());
                $this->Flash->error(__('Oops! There are mistakes in the form. Please make the correction.'));
            }
        }
        $this->set('withdraw', $withdraw);
    }
    */

    public function cancel($id)
    {
        $this->request->allowMethod(['post', 'put']);

        $withdraw = $this->Withdraws->get($id);

        $withdraw->status = 4;

        if ($this->Withdraws->save($withdraw)) {
            if (!empty($user->email)) {
                if ((bool)get_option('alert_member_canceled_withdraw', 1)) {
                    $this->getMailer('Notification')->send('cancelWithdraw', [$withdraw, $user]);
                }
            }

            $this->Flash->success(__('The withdrawal request with id: {0} has been canceled.', $id));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function returned($id)
    {
        $this->request->allowMethod(['post', 'put']);

        $withdraw = $this->Withdraws->get($id);

        $user = $this->Withdraws->Users->get($withdraw->user_id);

        $user->publisher_earnings = price_database_format($user->publisher_earnings + $withdraw->publisher_earnings);
        $user->referral_earnings = price_database_format($user->referral_earnings + $withdraw->referral_earnings);

        $this->Withdraws->Users->save($user);

        $withdraw->status = 5;

        if ($this->Withdraws->save($withdraw)) {
            if (!empty($user->email)) {
                if ((bool)get_option('alert_member_returned_withdraw', 1)) {
                    $this->getMailer('Notification')->send('returnWithdraw', [$withdraw, $user]);
                }
            }

            $this->Flash->success(__('The withdrawal request money returned to the user account.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function approve($id)
    {
        $this->request->allowMethod(['post', 'put']);

        $withdraw = $this->Withdraws->get($id);
        $user = $this->Withdraws->Users->get($withdraw->user_id);

        $withdraw->status = 1;

        if ($this->Withdraws->save($withdraw)) {
            if (!empty($user->email)) {
                if ((bool)get_option('alert_member_approved_withdraw', 1)) {
                    $this->getMailer('Notification')->send('approveWithdraw', [$withdraw, $user]);
                }
            }

            $this->Flash->success(__('The withdrawal request with id: {0} has been approved.', $id));

            return $this->redirect(['action' => 'index']);
        }
    }

    public function complete($id)
    {
        $this->request->allowMethod(['post', 'put']);

        $withdraw = $this->Withdraws->get($id);
        $user = $this->Withdraws->Users->get($withdraw->user_id);

        $withdraw->status = 3;

        if ($this->Withdraws->save($withdraw)) {
            if ($withdraw->method == 'wallet') {
                $user->wallet_money += $withdraw->amount;
                $this->Withdraws->Users->save($user);
            }

            if (!empty($user->email)) {
                if ((bool)get_option('alert_member_completed_withdraw', 1)) {
                    $this->getMailer('Notification')->send('completeWithdraw', [$withdraw, $user]);
                }
            }

            $this->Flash->success(__('The withdrawal request with id: {0} has been completed.', $id));

            return $this->redirect(['action' => 'index']);
        }
    }
}
