<?php

namespace App\Controller\Member;

use App\Controller\Member\AppMemberController;

/**
 * @property \App\Model\Table\LinksTable $Links
 */
class ToolsController extends AppMemberController
{
    public function quick()
    {
        $notice = '';
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->api_quick) {
                $notice = __('You must upgrade your plan so you can use this tool.');
            }
        }
        $this->set('notice', $notice);
    }

    public function massShrinker()
    {
        $this->loadModel('Links');

        $notice = '';
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->api_mass) {
                $notice = __('You must upgrade your plan so you can use this tool.');
            }
        }
        $this->set('notice', $notice);

        $link = $this->Links->newEntity();
        if ($this->request->is('post')) {
            if ($notice) {
                $this->Flash->error($notice);
                return $this->redirect(['action' => 'massShrinker']);
            }

            $urls = explode("\n", str_replace("\r", "\n", $this->request->data['urls']));
            $urls = array_unique(array_filter($urls));
            $urls = array_slice($urls, 0, get_option('mass_shrinker_limit', 20));
            $urls = array_map('trim', $urls);

            $ad_type = get_option('member_default_advert', 1);
            if (isset($this->request->data['ad_type'])) {
                if (array_key_exists($this->request->data['ad_type'], get_allowed_ads())) {
                    $ad_type = $this->request->data['ad_type'];
                }
            }

            $results = [];
            foreach ($urls as $url) {
                $results[] = $this->addMassShrinker($url, $ad_type);
            }

            $this->set('results', $results);
        }
        $this->set('link', $link);
    }

    public function api()
    {
        $notice = '';
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->api_developer) {
                $notice = __('You must upgrade your plan so you can use this tool.');
            }
        }
        $this->set('notice', $notice);
    }

    public function full()
    {
        $notice = '';
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->api_full) {
                $notice = __('You must upgrade your plan so you can use this tool.');
            }
        }
        $this->set('notice', $notice);
    }

    public function bookmarklet()
    {
        $notice = '';
        if ((bool)get_option('enable_premium_membership')) {
            if (!$this->logged_user_plan->bookmarklet) {
                $notice = __('You must upgrade your plan so you can use this tool.');
            }
        }
        $this->set('notice', $notice);
    }

    protected function addMassShrinker($url, $ad_type = 1)
    {
        $this->loadModel('Links');

        $url = parse_url($url, PHP_URL_SCHEME) === null ? 'http://' . $url : $url;

        $link = $this->Links->find()->where([
            'user_id' => $this->Auth->user('id'),
            'status' => 1,
            'ad_type' => $ad_type,
            'url' => $url
        ])->first();

        if ($link) {
            return ['url' => $url, 'short' => $link->alias, 'domain' => $link->domain];
        }

        $link = $this->Links->newEntity();
        $data = [];

        $data['user_id'] = $this->Auth->user('id');
        $data['url'] = $url;
        $data['alias'] = $this->Links->geturl();
        $data['ad_type'] = $ad_type;
        $link->status = 1;
        $link->hits = 0;
        $link->method = 3;

        $linkMeta = [
            'title' => '',
            'description' => '',
            'image' => ''
        ];

        if (get_option('disable_meta_api') === 'no') {
            $linkMeta = $this->Links->getLinkMeta($url);
        }

        $link->title = $linkMeta['title'];
        $link->description = $linkMeta['description'];
        $link->image = $linkMeta['image'];

        $link = $this->Links->patchEntity($link, $data);
        if ($this->Links->save($link)) {
            return ['url' => $url, 'short' => $link->alias, 'domain' => $link->domain];
        }
        return ['url' => $url, 'short' => 'error', 'domain' => ''];
    }
}
