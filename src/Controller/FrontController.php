<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\I18n;

class FrontController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Check if SSL is enabled.
        if ($this->setLanguage()) {
            $protocol = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") ? "http://" : "https://";
            $request_url = str_replace('lang=' . $this->request->query['lang'], '', env('REQUEST_URI'));
            return $this->redirect($protocol . env('HTTP_HOST') . $request_url, 307);
        }

        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], get_site_languages(true))) {
            I18n::locale($_COOKIE['lang']);
        }
    }
}
