<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppAdminController;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class ReportsController extends AppAdminController
{
    public function campaigns()
    {
        $this->loadModel('Users');

        $plain_users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'username'
        ])
            ->toArray();

        $users = [];
        foreach ($plain_users as $key => $value) {
            $users[$key] = '#' . $key . ' - ' . $value;
        }

        $this->set('users', $users);

        $plain_campaigns = $this->Users->Campaigns->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->toArray();

        $campaigns = [];
        foreach ($plain_campaigns as $key => $value) {
            $campaigns[$key] = '#' . $key . ' - ' . $value;
        }

        $this->set('campaigns', $campaigns);

        if (isset($this->request->query['Filter'])) {
            $campaign_where = [];

            if (!empty($this->request->query['Filter']['campaign_id'])) {
                $campaign_where['campaign_id'] = (int)$this->request->query['Filter']['campaign_id'];
            }

            if (!empty($this->request->query['Filter']['user_id'])) {
                $campaign_where['user_id'] = (int)$this->request->query['Filter']['user_id'];
            }

            $campaign_earnings = $this->Users->Statistics->find()
                ->select([
                    'reason',
                    'count' => 'COUNT(reason)',
                    'earnings' => 'SUM(publisher_earn)',
                ])
                ->where($campaign_where)
                ->order(['earnings' => 'DESC'])
                ->group(['reason'])
                ->toArray();

            $this->set('campaign_earnings', $campaign_earnings);

            $campaign_countries = $this->Users->Statistics->find()
                ->select([
                    'country',
                    'count' => 'COUNT(country)',
                    'earnings' => 'SUM(publisher_earn)',
                ])
                ->where($campaign_where)
                ->order(['earnings' => 'DESC'])
                ->group(['country'])
                ->toArray();

            $this->set('campaign_countries', $campaign_countries);

            $campaign_referers = $this->Users->Statistics->find()
                ->select([
                    'referer_domain',
                    'count' => 'COUNT(referer_domain)',
                    'earnings' => 'SUM(publisher_earn)',
                ])
                ->where($campaign_where)
                ->order(['earnings' => 'DESC'])
                ->group(['referer_domain'])
                ->toArray();

            $this->set('campaign_referers', $campaign_referers);
        }
    }
}
