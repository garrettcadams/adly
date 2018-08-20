<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Cache\Cache;
use Cake\Network\Exception\NotFoundException;

/**
 * @property \App\Model\Table\StatisticsTable $Statistics
 */
class StatisticsController extends FrontController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('go_banner');
        $this->Auth->allow(['viewInfo']);
    }

    public function viewInfo($alias = null)
    {
        if (!$alias) {
            throw new NotFoundException(__('Invalid link'));
        }

        if (null !== $this->Auth->user('id')) {
            if (get_option('link_info_member', 'yes') == 'no') {
                throw new NotFoundException(__('Invalid link'));
            }
        } else {
            if (get_option('link_info_public', 'yes') == 'no') {
                throw new NotFoundException(__('Invalid link'));
            }
        }

        /**
         * @var \App\Model\Entity\Link $link
         */
        $link = $this->Statistics->Links->find()->where(['alias' => $alias, 'status <>' => 3])->first();
        if (!$link) {
            throw new NotFoundException(__('404 Not Found'));
        }
        $this->set('link', $link);

        /**
         * @var \App\Model\Entity\User $user
         */
        $user = $this->Statistics->Links->Users->find()->contain('Plans')->where([
            'Users.id' => $link->user_id,
            'Users.status' => 1
        ])->first();
        if (!$user) {
            throw new NotFoundException(__('404 Not Found'));
        }

        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->stats) {
                //$this->Flash->error(__('You must upgrade your plan so you can use this tool.'));
                return $this->redirect('/');
            }
        }

        $now = Time::now()->format('Y-m-d H:i:s');
        $last30 = Time::now()->modify('-30 day')->format('Y-m-d H:i:s');

        if (($stats = Cache::read('info_stats_' . $alias, '1hour')) === false) {
            $stats = $this->Statistics->find()
                ->select([
                    'statDate' => 'DATE_FORMAT(created,"%d-%m-%Y")',
                    'statDateCount' => 'COUNT(DATE_FORMAT(created,"%d-%m-%Y"))'
                ])
                ->where([
                    'link_id' => $link->id,
                    'user_id' => $link->user_id,
                    'created BETWEEN :last30 AND :now'
                ])
                ->bind(':last30', $last30, 'datetime')
                ->bind(':now', $now, 'datetime')
                ->order(['created' => 'DESC'])
                ->group('statDate')
                ->toArray();
            Cache::write('info_stats_' . $alias, $stats, '1hour');
        }

        $this->set('stats', $stats);

        if (($countries = Cache::read('info_countries_' . $alias, '1hour')) === false) {
            $countries = $this->Statistics->find()
                ->select([
                    'country',
                    'clicks' => 'COUNT(country)'
                ])
                ->where([
                    'link_id' => $link->id,
                    'user_id' => $link->user_id,
                    'created BETWEEN :last30 AND :now'
                ])
                ->bind(':last30', $last30, 'datetime')
                ->bind(':now', $now, 'datetime')
                ->order(['clicks' => 'DESC'])
                ->group('country')
                ->toArray();
            Cache::write('info_countries_' . $alias, $countries, '1hour');
        }

        $this->set('countries', $countries);

        if (($referrers = Cache::read('info_referrers_' . $alias, '1hour')) === false) {
            $referrers = $this->Statistics->find()
                ->select([
                    'referer_domain',
                    'clicks' => 'COUNT(referer)'
                ])
                ->where([
                    'link_id' => $link->id,
                    'user_id' => $link->user_id,
                    'created BETWEEN :last30 AND :now'
                ])
                ->bind(':last30', $last30, 'datetime')
                ->bind(':now', $now, 'datetime')
                ->order(['clicks' => 'DESC'])
                ->group('referer_domain')
                ->toArray();
            Cache::write('info_referrers_' . $alias, $referrers, '1hour');
        }

        $this->set('referrers', $referrers);
    }
}
