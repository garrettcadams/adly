<?php

namespace App\Controller;

use App\Controller\FrontController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Cache\Cache;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends FrontController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['home', 'view', 'contact']);
    }

    public function contact()
    {
    }

    public function home()
    {
        $this->loadModel('Users');

        /*
          $todayClicks = $this->Users->Statistics->find()
          ->where([
          'DATE(Statistics.created) = CURDATE()'
          ])
          ->count();
          $this->set('todayClicks', $todayClicks);
         */

        $lang = locale_get_default();

        if (($totalLinks = Cache::read('home_totalLinks_' . $lang, '1hour')) === false) {
            $totalLinks = $this->Users->Links->find()
                ->count();

            $totalLinks += (int)get_option('fake_links', 0);

            $totalLinks = display_price_currency($totalLinks, [
                'places' => 0,
                'before' => '',
                'after' => '',
            ]);

            if (get_option('cache_home_counters', 1)) {
                Cache::write('home_totalLinks_' . $lang, $totalLinks, '1hour');
            }
        }
        $this->set('totalLinks', $totalLinks);

        if (($totalClicks = Cache::read('home_totalClicks_' . $lang, '1hour')) === false) {
            $totalClicks = $this->Users->Statistics->find()
                ->where([
                    'ad_type <>' => 3
                ])
                ->count();

            $totalClicks += (int)get_option('fake_clicks', 0);

            $totalClicks = display_price_currency($totalClicks, [
                'places' => 0,
                'before' => '',
                'after' => '',
            ]);

            if (get_option('cache_home_counters', 1)) {
                Cache::write('home_totalClicks_' . $lang, $totalClicks, '1hour');
            }
        }
        $this->set('totalClicks', $totalClicks);

        if (($totalUsers = Cache::read('home_totalUsers_' . $lang, '1hour')) === false) {
            $totalUsers = $this->Users->find()
                ->where(['id > 1'])
                ->count();

            $totalUsers += (int)get_option('fake_users', 0);

            $totalUsers = display_price_currency($totalUsers, [
                'places' => 0,
                'before' => '',
                'after' => '',
            ]);

            if (get_option('cache_home_counters', 1)) {
                Cache::write('home_totalUsers_' . $lang, $totalUsers, '1hour');
            }
        }
        $this->set('totalUsers', $totalUsers);
    }

    public function view($slug = null)
    {
        if (!$slug) {
            throw new NotFoundException(__('Invalid Page.'));
        }

        $page = $this->Pages->find()->where(['slug' => $slug, 'published' => 1])->first();

        if (!$page) {
            throw new NotFoundException(__('Invalid Page.'));
        }

        if (strpos($page->content, '[advertising_rates]') !== false) {
            $page->content = str_replace('[advertising_rates]', $this->advertisingRates(), $page->content);
        }

        if (strpos($page->content, '[payout_rates]') !== false) {
            $page->content = str_replace('[payout_rates]', $this->payoutRates(), $page->content);
        }

        $this->set('page', $page);
    }

    protected function advertisingRates()
    {
        $lang = locale_get_default();

        if (($advertisingRates = Cache::read('advertising_rates_' . $lang, '1day')) === false) {
            $countries = get_countries(true);
            ob_start(); ?>
            <link rel="stylesheet" href="//cdn.rawgit.com/lipis/flag-icon-css/2.8.0/css/flag-icon.min.css"/>

            <div class="advertising-rates">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php if (get_option('enable_banner', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#ban-ner-ads" aria-controls="ban-ner-ads" role="tab"
                                                   data-toggle="tab"><?= __('Banner') ?></a></li>
                    <?php endif; ?>
                    <?php if (get_option('enable_interstitial', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#interstitial" aria-controls="interstitial" role="tab"
                                                   data-toggle="tab"><?= __('Interstitial') ?></a></li>
                    <?php endif; ?>
                    <?php if (get_option('enable_popup', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#popup-ads" aria-controls="popup-ads" role="tab"
                                                   data-toggle="tab"><?= __('Popup') ?></a></li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php if (get_option('enable_banner', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="ban-ner-ads">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="3"><?= __('Cost per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Both") ?>
                                    </td>
                                </tr>
                                <?php
                                $banner_price = get_option('banner_price'); ?>
                                <?php foreach ($banner_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[1]['advertiser']) &&
                                        empty($value[2]['advertiser']) &&
                                        empty($value[3]['advertiser'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[1]['advertiser']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php if (get_option('enable_interstitial', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="interstitial">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="3"><?= __('Cost per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Both") ?>
                                    </td>
                                </tr>
                                <?php
                                $interstitial_price = get_option('interstitial_price', []); ?>
                                <?php foreach ($interstitial_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[1]['advertiser']) &&
                                        empty($value[2]['advertiser']) &&
                                        empty($value[3]['advertiser'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[1]['advertiser']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php if (get_option('enable_popup', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="popup-ads">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="3"><?= __('Cost per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Both") ?>
                                    </td>
                                </tr>
                                <?php
                                $popup_price = get_option('popup_price'); ?>
                                <?php foreach ($popup_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[1]['advertiser']) &&
                                        empty($value[2]['advertiser']) &&
                                        empty($value[3]['advertiser'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['advertiser']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[1]['advertiser']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <?php
            $advertisingRates = ob_get_contents();
            ob_end_clean();

            Cache::write('advertising_rates_' . $lang, $advertisingRates, '1day');
        }

        return $advertisingRates;
    }

    protected function payoutRates()
    {
        $lang = locale_get_default();

        if (($payoutRates = Cache::read('payout_rates_' . $lang, '1day')) === false) {
            $countries = get_countries(true);
            ob_start(); ?>
            <link rel="stylesheet" href="//cdn.rawgit.com/lipis/flag-icon-css/2.8.0/css/flag-icon.min.css"/>

            <div class="payout-rates">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php if (get_option('enable_banner', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#ban-ner-ads" aria-controls="ban-ner-ads" role="tab"
                                                   data-toggle="tab"><?= __('Banner') ?></a></li>
                    <?php endif; ?>
                    <?php if (get_option('enable_interstitial', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#interstitial" aria-controls="interstitial" role="tab"
                                                   data-toggle="tab"><?= __('Interstitial') ?></a></li>
                    <?php endif; ?>
                    <?php if (get_option('enable_popup', 'yes') == 'yes') : ?>
                        <li role="presentation"><a href="#popup-ads" aria-controls="popup-ads" role="tab"
                                                   data-toggle="tab"><?= __('Popup') ?></a></li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php if (get_option('enable_banner', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="ban-ner-ads">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                </tr>
                                <?php
                                $banner_price = get_option('banner_price');
                                uasort($banner_price, function ($a, $b) {
                                    if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) {
                                        return 0;
                                    }
                                    if ($a[3]['publisher'] == $b[3]['publisher']) {
                                        return 0;
                                    }

                                    return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                                });
                                ?>
                                <?php foreach ($banner_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[2]['publisher']) &&
                                        empty($value[3]['publisher'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['publisher']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['publisher']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php if (get_option('enable_interstitial', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="interstitial">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                </tr>
                                <?php
                                $interstitial_price = get_option('interstitial_price', []);
                                uasort($interstitial_price, function ($a, $b) {
                                    if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) {
                                        return 0;
                                    }
                                    if ($a[3]['publisher'] == $b[3]['publisher']) {
                                        return 0;
                                    }

                                    return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                                });
                                ?>
                                <?php foreach ($interstitial_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[2]['publisher']) &&
                                        empty($value[3]['publisher'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['publisher']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['publisher']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php if (get_option('enable_popup', 'yes') == 'yes') : ?>
                        <div role="tabpanel" class="tab-pane" id="popup-ads">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th rowspan="2"><?= __('Package Description / Country') ?></th>
                                    <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Desktop") ?>
                                    </td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?= __("Mobile / Tablet") ?>
                                    </td>
                                </tr>
                                <?php
                                $popup_price = get_option('popup_price');
                                uasort($popup_price, function ($a, $b) {
                                    if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) {
                                        return 0;
                                    }
                                    if ($a[3]['publisher'] == $b[3]['publisher']) {
                                        return 0;
                                    }

                                    return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                                });
                                ?>
                                <?php foreach ($popup_price as $key => $value) : ?>
                                    <?php
                                    if (empty($value[2]['publisher']) &&
                                        empty($value[3]['publisher'])
                                    ) {
                                        continue;
                                    } ?>
                                    <tr>
                                        <td>
                                            <span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span>
                                            <?= $countries[$key] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[2]['publisher']) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= display_price_currency($value[3]['publisher']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <?php
            $payoutRates = ob_get_contents();
            ob_end_clean();

            Cache::write('payout_rates_' . $lang, $payoutRates, '1day');
        }

        return $payoutRates;
    }
}
