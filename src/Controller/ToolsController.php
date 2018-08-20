<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * @property \App\Model\Table\LinksTable $Links
 */
class ToolsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['st', 'full', 'api', 'bookmarklet']);
    }

    public function bookmarklet()
    {
        $this->viewBuilder()->layout('blank');

        $this->loadModel('Links');

        $valid_bookmarklet = false;

        if (isset($this->request->query) &&
            isset($this->request->query['api']) &&
            isset($this->request->query['url'])
        ) {
            $valid_bookmarklet = true;
        }

        $this->set('valid_bookmarklet', $valid_bookmarklet);

        if (!$valid_bookmarklet) {
            $this->Flash->error(__('Bad Request.'));
            return null;
        }

        $api = $this->request->query['api'];

        $user = $this->Links->Users->find()->contain('Plans')->where([
            'Users.api_token' => $api,
            'Users.status' => 1
        ])->first();

        if (!$user) {
            $this->Flash->error(__('Invalid API token.'));
            $valid_bookmarklet = false;
            $this->set('valid_bookmarklet', $valid_bookmarklet);
            return null;
        }

        $custom_alias = true;
        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->alias) {
                $custom_alias = false;
            }
        }
        $this->set('custom_alias', $custom_alias);

        $link = $this->Links->newEntity();

        if ($this->request->is('post')) {
            $url = $this->request->data['url'];

            $ad_type = get_option('member_default_advert', 1);
            if (isset($this->request->data['ad_type'])) {
                if (array_key_exists($this->request->data['ad_type'], get_allowed_ads())) {
                    $ad_type = $this->request->data['ad_type'];
                }
            }

            if ((bool)get_option('enable_premium_membership')) {
                if (!get_user_plan($user)->bookmarklet) {
                    $this->Flash->error(__('You must upgrade your plan so you can use this tool.'));
                    $this->set('link', $link);
                    return null;
                }
            }

            $url = trim($url);
            $url = str_replace(" ", "%20", $url);
            $url = parse_url($url, PHP_URL_SCHEME) === null ? 'http://' . $url : $url;

            $domain = '';
            if (isset($this->request->data['domain'])) {
                $domain = $this->request->data['domain'];
            }
            if (!in_array($domain, get_multi_domains_list())) {
                $domain = '';
            }

            $linkWhere = [
                'user_id' => $user->id,
                'status' => 1,
                'ad_type' => $ad_type,
                'url' => $url
            ];

            if (isset($this->request->data['alias']) && strlen($this->request->data['alias']) > 0) {
                $linkWhere['alias'] = $this->request->data['alias'];
            }

            $link = $this->Links->find()->where($linkWhere)->first();

            if ($link) {
                $this->set('short_link', get_short_url($link->alias, $domain));
                return null;
            }

            $link = $this->Links->newEntity();
            $data = [];

            $data['user_id'] = $user->id;
            $data['url'] = $url;
            $data['domain'] = $domain;
            if (empty($this->request->data['alias'])) {
                $data['alias'] = $this->Links->geturl();
            } else {
                $data['alias'] = $this->request->data['alias'];
            }
            $data['ad_type'] = $ad_type;

            $link->status = 1;
            $link->hits = 0;
            $link->method = 6;

            $linkMeta = [
                'title' => '',
                'description' => '',
                'image' => ''
            ];

            if (get_option('disable_meta_api') === 'no') {
                $linkMeta = $this->Links->getLinkMeta($url);
            }

            $data['title'] = $linkMeta['title'];
            $data['description'] = $linkMeta['description'];
            $link->image = $linkMeta['image'];

            $link = $this->Links->patchEntity($link, $data);
            if ($this->Links->save($link)) {
                $this->set('short_link', get_short_url($link->alias, $domain));
                return null;
            } else {
                $this->Flash->error(__('Check the below errors.'));
            }
        }
        $this->set('link', $link);
    }

    public function st()
    {
        $this->viewBuilder()->layout('blank');

        $this->loadModel('Links');

        $message = '';
        $this->set('message', $message);

        if (!$this->request->is(['post'])) {
            return null;
        }

        if (!isset($this->request->data['api']) ||
            !isset($this->request->data['url'])
        ) {
            $message = __('Invalid Request.');
            $this->set('message', $message);
            return null;
        }

        $api = $this->request->data['api'];
        $url = $this->request->data['url'];

        $ad_type = get_option('member_default_advert', 1);

        $user = $this->Links->Users->find()->contain('Plans')->where([
            'Users.api_token' => $api,
            'Users.status' => 1
        ])->first();

        if (!$user) {
            $message = __('Invalid API token.');
            $this->set('message', $message);
            return null;
        }

        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->api_quick) {
                $message = __('You must upgrade your plan so you can use this tool.');
                $this->set('message', $message);
                return null;
            }
        }

        $url = trim($url);
        $url = str_replace(" ", "%20", $url);
        $url = parse_url($url, PHP_URL_SCHEME) === null ? 'http://' . $url : $url;

        $link = $this->Links->find()->where([
            'user_id' => $user->id,
            'status' => 1,
            'ad_type' => $ad_type,
            'url' => $url
        ])->first();

        if ($link) {
            return $this->redirect(get_short_url($link->alias), 301);
        }

        $link = $this->Links->newEntity();
        $data = [];

        $data['user_id'] = $user->id;
        $data['url'] = $url;
        $data['alias'] = $this->Links->geturl();
        $data['ad_type'] = $ad_type;

        $link->status = 1;
        $link->hits = 0;
        $link->method = 2;

        $linkMeta = [
            'title' => '',
            'description' => '',
            'image' => ''
        ];

        if (get_option('disable_meta_api') === 'no') {
            $linkMeta = $this->Links->getLinkMeta($url);
        }

        $data['title'] = $linkMeta['title'];
        $data['description'] = $linkMeta['description'];
        $link->image = $linkMeta['image'];

        $link = $this->Links->patchEntity($link, $data);
        if ($this->Links->save($link)) {
            return $this->redirect(get_short_url($link->alias), 301);
        }

        $error_msg = [];
        if ($link->errors()) {
            foreach ($link->errors() as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $error_msg[] = h($error);
                    }
                } else {
                    $error_msg[] = h($errors);
                }
            }
        }
        $this->set('message', implode('<br>', $error_msg));
        return null;
    }

    public function full()
    {
        $this->viewBuilder()->layout('blank');

        $this->loadModel('Links');

        $message = '';
        $this->set('message', $message);

        if (!isset($this->request->query) ||
            !isset($this->request->query['api']) ||
            !isset($this->request->query['url'])
        ) {
            $message = __('Invalid Request.');
            $this->set('message', $message);
            return null;
        }

        $api = $this->request->query['api'];
        $url = urldecode(base64_decode($this->request->query['url']));

        $ad_type = get_option('member_default_advert', 1);
        if (isset($this->request->query['type'])) {
            if (array_key_exists($this->request->query['type'], get_allowed_ads())) {
                $ad_type = $this->request->query['type'];
            }
        }

        $user = $this->Links->Users->find()->contain('Plans')->where([
            'Users.api_token' => $api,
            'Users.status' => 1
        ])->first();

        if (!$user) {
            $message = __('Invalid API token.');
            $this->set('message', $message);
            return null;
        }

        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->api_full) {
                $message = __('You must upgrade your plan so you can use this tool.');
                $this->set('message', $message);
                return null;
            }
        }

        $url = trim($url);
        $url = str_replace(" ", "%20", $url);
        $url = parse_url($url, PHP_URL_SCHEME) === null ? 'http://' . $url : $url;

        $linkWhere = [
            'user_id' => $user->id,
            'status' => 1,
            'ad_type' => $ad_type,
            'url' => $url
        ];

        $link = $this->Links->find()->where($linkWhere)->first();

        if ($link) {
            return $this->redirect(get_short_url($link->alias), 301);
        }

        $link = $this->Links->newEntity();
        $data = [];

        $data['user_id'] = $user->id;
        $data['url'] = $url;
        $data['alias'] = $this->Links->geturl();
        $data['ad_type'] = $ad_type;

        $link->status = 1;
        $link->hits = 0;
        $link->method = 4;

        $linkMeta = [
            'title' => '',
            'description' => '',
            'image' => ''
        ];

        if (get_option('disable_meta_api') === 'no') {
            $linkMeta = $this->Links->getLinkMeta($url);
        }

        $data['title'] = $linkMeta['title'];
        $data['description'] = $linkMeta['description'];
        $link->image = $linkMeta['image'];

        $link = $this->Links->patchEntity($link, $data);
        if ($this->Links->save($link)) {
            return $this->redirect(get_short_url($link->alias), 301);
        }

        $error_msg = [];
        if ($link->errors()) {
            foreach ($link->errors() as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $error_msg[] = h($error);
                    }
                } else {
                    $error_msg[] = h($errors);
                }
            }
        }
        $this->set('message', implode('<br>', $error_msg));
        return null;
    }

    public function api()
    {
        $this->autoRender = false;

        $this->response->header('Access-Control-Allow-Origin', '*');

        $this->loadModel('Links');

        $format = 'json';
        if (isset($this->request->query['format']) && strtolower($this->request->query['format']) === 'text') {
            $format = 'text';
        }
        $this->response->type($format);

        if (!isset($this->request->query) ||
            !isset($this->request->query['api']) ||
            !isset($this->request->query['url'])
        ) {
            $content = [
                'status' => 'error',
                'message' => 'Invalid API call',
                'shortenedUrl' => ''
            ];
            $this->response->body($this->apiContent($content, $format));
            return $this->response;
        }

        $api = $this->request->query['api'];
        $url = urldecode($this->request->query['url']);

        $ad_type = get_option('member_default_advert', 1);
        if (isset($this->request->query['type'])) {
            if (array_key_exists($this->request->query['type'], get_allowed_ads())) {
                $ad_type = $this->request->query['type'];
            }
        }

        $user = $this->Links->Users->find()->contain('Plans')->where([
            'Users.api_token' => $api,
            'Users.status' => 1
        ])->first();

        if (!$user) {
            $content = [
                'status' => 'error',
                'message' => 'Invalid API token',
                'shortenedUrl' => ''
            ];
            $this->response->body($this->apiContent($content, $format));
            return $this->response;
        }

        if ((bool)get_option('enable_premium_membership')) {
            if (!get_user_plan($user)->api_developer) {
                $content = [
                    'status' => 'error',
                    'message' => 'You must upgrade your plan so you can use this tool.',
                    'shortenedUrl' => ''
                ];
                $this->response->body($this->apiContent($content, $format));
                return $this->response;
            }
        }

        $url = trim($url);
        $url = str_replace(" ", "%20", $url);
        $url = parse_url($url, PHP_URL_SCHEME) === null ? 'http://' . $url : $url;

        $linkWhere = [
            'user_id' => $user->id,
            'status' => 1,
            'ad_type' => $ad_type,
            'url' => $url
        ];

        if (isset($this->request->query['alias']) && strlen($this->request->query['alias']) > 0) {
            $linkWhere['alias'] = $this->request->query['alias'];
        }

        $link = $this->Links->find()->where($linkWhere)->first();

        if ($link) {
            $content = [
                'status' => 'success',
                'shortenedUrl' => get_short_url($link->alias, $link->domain)
            ];
            $this->response->body($this->apiContent($content, $format));
            return $this->response;
        }

        $link = $this->Links->newEntity();
        $data = [];

        $data['user_id'] = $user->id;
        $data['url'] = $url;
        if (empty($this->request->query['alias'])) {
            $data['alias'] = $this->Links->geturl();
        } else {
            $data['alias'] = $this->request->query['alias'];
        }
        $data['ad_type'] = $ad_type;

        $link->status = 1;
        $link->hits = 0;
        $link->method = 5;

        $linkMeta = [
            'title' => '',
            'description' => '',
            'image' => ''
        ];

        if (get_option('disable_meta_api') === 'no') {
            $linkMeta = $this->Links->getLinkMeta($url);
        }

        $data['title'] = $linkMeta['title'];
        $data['description'] = $linkMeta['description'];
        $link->image = $linkMeta['image'];

        $link = $this->Links->patchEntity($link, $data);

        if ($this->Links->save($link)) {
            $content = [
                'status' => 'success',
                'message' => '',
                'shortenedUrl' => get_short_url($link->alias, $link->domain)
            ];
            $this->response->body($this->apiContent($content, $format));
            return $this->response;
        }

        $error_msg = [];
        if ($link->errors()) {
            foreach ($link->errors() as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $error_msg[] = $error;
                    }
                } else {
                    $error_msg[] = $errors;
                }
            }
        }

        $content = [
            'status' => 'error',
            'message' => $error_msg,
            'shortenedUrl' => ''
        ];
        $this->response->body($this->apiContent($content, $format));
        return $this->response;
    }

    protected function apiContent($content = [], $format = 'json')
    {
        $body = json_encode($content);
        if ($format === 'text') {
            $body = $content['shortenedUrl'];
        }
        return $body;
    }
}
