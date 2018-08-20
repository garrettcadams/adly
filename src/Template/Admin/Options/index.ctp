<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->assign('title', __('Settings'));
$this->assign('description', '');
$this->assign('content_title', __('Settings'));
?>

<?= $this->Form->create($options, [
    'id' => 'form-settings',
    'onSubmit' => "save_settings.disabled=true; save_settings.innerHTML='" . __('Saving ...') . "'; return true;"
]); ?>

<div class="nav-tabs-custom">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#general" aria-controls="general" role="tab"
                                   data-toggle="tab"><?= __('General') ?></a></li>
        <li role="presentation"><a href="#language" aria-controls="language" role="tab"
                                   data-toggle="tab"><?= __('Language') ?></a></li>
        <li role="presentation"><a href="#design" aria-controls="design" role="tab"
                                   data-toggle="tab"><?= __('Design') ?></a></li>
        <li role="presentation"><a href="#links" aria-controls="links" role="tab"
                                   data-toggle="tab"><?= __('Links') ?></a></li>
        <li role="presentation"><a href="#earnings" aria-controls="earnings" role="tab"
                                   data-toggle="tab"><?= __('Earnings') ?></a></li>
        <li role="presentation"><a href="#users" aria-controls="users" role="tab"
                                   data-toggle="tab"><?= __('Users') ?></a></li>
        <li role="presentation"><a href="#integration" aria-controls="integration" role="tab"
                                   data-toggle="tab"><?= __('Integration') ?></a></li>
        <li role="presentation"><a href="#admin-ads" aria-controls="admin-ads" role="tab"
                                   data-toggle="tab"><?= __('Admin Ads') ?></a></li>
        <li role="presentation"><a href="#captcha" aria-controls="captcha" role="tab"
                                   data-toggle="tab"><?= __('Captcha') ?></a></li>
        <li role="presentation"><a href="#security" aria-controls="security" role="tab"
                                   data-toggle="tab"><?= __('Security') ?></a></li>
        <li role="presentation"><a href="#blog" aria-controls="blog" role="tab" data-toggle="tab"><?= __('Blog') ?></a>
        </li>
        <li role="presentation"><a href="#social" aria-controls="Social Media" role="tab"
                                   data-toggle="tab"><?= __('Social Media') ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" id="general" class="tab-pane fade in active">
            <p></p>
            <div class="row">
                <div class="col-sm-2"><?= __('Site Name') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['site_name']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['site_name']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('This is your site name.') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('SEO Site Meta Title') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['site_meta_title']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['site_meta_title']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('This is your site meta title. The recommended length is 50-60 ' .
                            'characters.') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Site Description') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['description']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['description']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Main Domain') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['main_domain']['id'] . '.value', [
                        'label' => false,
                        'placeholder' => env("HTTP_HOST", ""),
                        'required' => 'required',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['main_domain']['value']
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __('Main domain used for all pages expect the short link page. Make sure to ' .
                            'remove the "http" or "https" and the trailing slash (/)!. Example: <b>domain.com</b>') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Default Short URL Domain') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['default_short_domain']['id'] . '.value', [
                        'label' => false,
                        'placeholder' => __("Ex. domian.com"),
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['default_short_domain']['value']
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __('Add the default domain used for the short links. If it is empty, the main ' .
                            'domain will be used. Make sure to remove the "http" or "https" and the trailing slash ' .
                            '(/)!. Example: <b>domain.com</b>') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Multi Domains') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['multi_domains']['id'] . '.value', [
                        'label' => false,
                        'placeholder' => 'domain1.com,domain2.com',
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['multi_domains']['value']
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("Add the other domains(don't add the default short URL domain or the main " .
                            "domain) you want users to select between when short links. ex. " .
                            "<b>domain1.com,domain2.com</b> These domains should be parked/aliased to the main " .
                            "domain. Separate by comma, no spaces. Make sure to remove the 'http' or 'https' and " .
                            "the trailing slash (/)!") ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Prevent direct access to the multi domains') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['prevent_direct_access_multi_domains']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['prevent_direct_access_multi_domains']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("Display a warning message when directly access the multi domains.") ?>
                    </span>
                </div>
            </div>

            <div class="row hidden">
                <div class="col-sm-2"><?= __('Language Direction') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['language_direction']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'ltr' => __('LTR'),
                            'rtl' => __('RTL')
                        ],
                        'value' => $settings['language_direction']['value'],
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Time Zone') ?></div>
                <div class="col-sm-10">
                    <?php
                    $DateTimeZone = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                    echo $this->Form->input('Options.' . $settings['timezone']['id'] . '.value', [
                        'label' => false,
                        'options' => array_combine($DateTimeZone, $DateTimeZone),
                        'value' => $settings['timezone']['value'],
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Cache Administration Area Statistics') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['cache_admin_statistics']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Enable'),
                            0 => __('Disable')
                        ],
                        'value' => $settings['cache_admin_statistics']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("It's recommended to keep it disabled If you are starting new website. " .
                            "In the future, it is highly recommended to enable it.") ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Cache Member Area Statistics') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['cache_member_statistics']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Enable'),
                            0 => __('Disable')
                        ],
                        'value' => $settings['cache_member_statistics']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("It's recommended to keep it disabled If you are starting new website. " .
                            "In the future, it is highly recommended to enable it.") ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Cache Homepage Counters') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['cache_home_counters']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Enable'),
                            0 => __('Disable')
                        ],
                        'value' => $settings['cache_home_counters']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("It's recommended to keep it disabled If you are starting new website. " .
                            "In the future, it is highly recommended to enable it.") ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Display Cookie Notification Bar') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['cookie_notification_bar']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['cookie_notification_bar']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Fake Users Base') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['fake_users']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['fake_users']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Fake Links Base') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['fake_links']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['fake_links']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Fake Clicks base') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['fake_clicks']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['fake_clicks']['value']
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <div role="tabpanel" id="language" class="tab-pane fade in active">
            <p></p>

            <?php
            $locale = new \Cake\Filesystem\Folder(APP . 'Locale');
            $languages = $locale->subdirectories(null, false);
            ?>

            <div class="row">
                <div class="col-sm-2"><?= __('Default Language') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['language']['id'] . '.value', [
                        'label' => false,
                        'options' => array_combine($languages, $languages),
                        'value' => $settings['language']['value'],
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Site Languages') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['site_languages']['id'] . '.value', [
                        'label' => false,
                        'type' => 'select',
                        'multiple' => true,
                        'options' => array_combine($languages, $languages),
                        'value' => unserialize($settings['site_languages']['value']),
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Language Automatic Redirect') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['language_auto_redirect']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['language_auto_redirect']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("Automatically redirect the website visitors to browse the website based on " .
                            " their browser language if it is already available.") ?>
                    </span>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="design" class="tab-pane fade in active">
            <p></p>

            <?php
            $plugins_path = new \Cake\Filesystem\Folder(ROOT . '/plugins');
            $plugins = $plugins_path->subdirectories(null, false);
            $frontend_themes = $member_themes = $admin_themes = [];

            foreach ($plugins as $key => $value) {
                if (!(preg_match('/AdminTheme$/', $value) || preg_match('/MemberTheme$/', $value)) &&
                    preg_match('/Theme$/', $value)
                ) {
                    $frontend_themes[$value] = $value;
                } elseif (preg_match('/AdminTheme$/', $value)) {
                    $admin_themes[$value] = $value;
                } elseif (preg_match('/MemberTheme$/', $value)) {
                    $member_themes[$value] = $value;
                }
            }
            ?>

            <div class="row">
                <div class="col-sm-2"><?= __('Select Frontend Theme') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['theme']['id'] . '.value', [
                        'label' => false,
                        'options' => $frontend_themes,
                        'value' => $settings['theme']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-2"><?= __('Select Member Area Theme') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['member_theme']['id'] . '.value', [
                        'label' => false,
                        'options' => $member_themes,
                        'value' => $settings['member_theme']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Select Member Area Default Theme Skin') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['member_adminlte_theme_skin']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'skin-blue' => 'Blue',
                            'skin-blue-light' => 'Blue Light',
                            'skin-yellow' => 'Yellow',
                            'skin-yellow-light' => 'Yellow Light',
                            'skin-green' => 'Green',
                            'skin-green-light' => 'Green Light',
                            'skin-purple' => 'Purple',
                            'skin-purple-light' => 'Purple Light',
                            'skin-red' => 'Red',
                            'skin-red-light' => 'Red Light',
                            'skin-black' => 'Black',
                            'skin-black-light' => 'Black Light'
                        ],
                        'value' => $settings['member_adminlte_theme_skin']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-2"><?= __('Select Admin Area Theme') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['admin_theme']['id'] . '.value', [
                        'label' => false,
                        'options' => $admin_themes,
                        'value' => $settings['admin_theme']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Select Admin Area Default Theme Skin') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['admin_adminlte_theme_skin']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'skin-blue' => 'Blue',
                            'skin-blue-light' => 'Blue Light',
                            'skin-yellow' => 'Yellow',
                            'skin-yellow-light' => 'Yellow Light',
                            'skin-green' => 'Green',
                            'skin-green-light' => 'Green Light',
                            'skin-purple' => 'Purple',
                            'skin-purple-light' => 'Purple Light',
                            'skin-red' => 'Red',
                            'skin-red-light' => 'Red Light',
                            'skin-black' => 'Black',
                            'skin-black-light' => 'Black Light'
                        ],
                        'value' => $settings['admin_adminlte_theme_skin']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-2"><?= __('Logo URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['logo_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['logo_url']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Logo URL - Alternative') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['logo_url_alt']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['logo_url_alt']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Alternative logo used on the login page') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Favicon URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['favicon_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['favicon_url']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Combine & Minify CSS & JS files') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['combine_minify_css_js']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            0 => __('No'),
                            1 => __('Yes')
                        ],
                        'value' => $settings['combine_minify_css_js']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Assets CDN URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['assets_cdn_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['assets_cdn_url']['value']
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="links" class="tab-pane fade in active">
            <p></p>

            <legend><?= __("Advertisement Types") ?></legend>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Interstitial Advertisement') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_interstitial']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_interstitial']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Banner Advertisement') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_banner']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_banner']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Popup Advertisement') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_popup']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_popup']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable No Advert') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_noadvert']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_noadvert']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Random Ad Type') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_random_ad_type']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['enable_random_ad_type']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block"><?= __('You need to enable interstitial and banner to allow users to ' .
                            'select random ad type.') ?></span>
                </div>
            </div>

            <legend><?= __("Default Advertisement Types") ?></legend>

            <div class="row">
                <div class="col-sm-2"><?= __('Anonymous Default Advert') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['anonymous_default_advert']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            '1' => __('Interstitial Advertisement'),
                            '2' => __('Ad Banner'),
                            '0' => __('No Advert')
                        ],
                        'value' => $settings['anonymous_default_advert']['value'],
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Member Default Advert') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['member_default_advert']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            '1' => __('Interstitial Advertisement'),
                            '2' => __('Ad Banner'),
                            '0' => __('No Advert')
                        ],
                        'value' => $settings['member_default_advert']['value'],
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <legend><?= __("Metadata Fetching") ?></legend>
            <p><?= __("When shortening a URL, the URL page is downloaded and title, description & image " .
                    "are fetched from this page. If you have performance issues you can disable this behaviour from the " .
                    "below options.") ?></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Disable Metadata Fetching on Homepage') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['disable_meta_home']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['disable_meta_home']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Disable Metadata Fetching on Member Area') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['disable_meta_member']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['disable_meta_member']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Disable Metadata Fetching on API') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['disable_meta_api']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['disable_meta_api']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block"><?= __("This is applicable for Quick Tool, Mass Shrinker, " .
                            "Full Page Script & Developers API.") ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Display Short link content(title, description and image)') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['short_link_content']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['short_link_content']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block"><?= __("Useful if your ads are displayed based on page content.") ?></span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-2"><?= __('Make Link Info Available for Public') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['link_info_public']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['link_info_public']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Display Home URL Shortening Box') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['home_shortening']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['home_shortening']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Redirect Anonymous Users to Register') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['home_shortening_register']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['home_shortening_register']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Make Link Info Available for Members') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['link_info_member']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['link_info_member']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Mass Shrinker Limit') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['mass_shrinker_limit']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['mass_shrinker_limit']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Links Banned Words') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['links_banned_words']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['links_banned_words']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Disallow links with banned words from being shortened. ' .
                            'The System will check link title or description if they are contain the banned words. ' .
                            'Separate by comma, no spaces.') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Disallowed Domains') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['disallowed_domains']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['disallowed_domains']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Disallow links with certain domains from being shortened. ' .
                            'Separate by comma, no spaces.') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Reserved Aliases') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['reserved_aliases']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['reserved_aliases']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Disallow aliases from being used for short links. ' .
                            'Separate by comma, no spaces.') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Alias Min. Length') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['alias_min_length']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['alias_min_length']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Alias Max. Length') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['alias_max_length']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'max' => 30,
                        'value' => $settings['alias_max_length']['value']
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="earnings" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Allow Members Creating Campaigns') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_advertising']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_advertising']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Publisher Earnings') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_publisher_earnings']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['enable_publisher_earnings']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Unique Visitor Per') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['unique_visitor_per']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'campaign' => __('Campaign'),
                            'all' => __('All Campaigns')
                        ],
                        'value' => $settings['unique_visitor_per']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __('Campaign: Publishers will earn more based on number of Campaigns.') ?><br>
                        <?= __('All Campaigns: Publishers will earn less.') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Paid Views Per Day') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['paid_views_day']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'min' => 1,
                        'step' => 1,
                        'value' => $settings['paid_views_day']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Force Disable Adblock') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['force_disable_adblock']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['force_disable_adblock']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Counter Value') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['counter_value']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['counter_value']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Counter Start Counting After') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['counter_start']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'DOMContentLoaded' => __('Page loaded'),
                            'load' => __('Page fully loaded')
                        ],
                        'value' => $settings['counter_start']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Store Only The Paid Clicks Statistics') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['store_only_paid_clicks_statistics']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['store_only_paid_clicks_statistics']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Referrals') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_referrals']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['enable_referrals']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row conditional" data-cond-option="Options[<?= $settings['enable_referrals']['id'] ?>][value]"
                 data-cond-value="1"
            >
                <div class="col-sm-2"><?= __('Referral Percentage') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['referral_percentage']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'value' => $settings['referral_percentage']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Enter the referral earning percentage. Ex. 20') ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Referral Banners Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['referral_banners_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['referral_banners_code']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __("Here you can add your referral banners html code. You " .
                            "can use [referral_link] as a placeholder for member referral link.") ?></span>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="users" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Close Registration') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['close_registration']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['close_registration']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Premium Membership') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_premium_membership']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['enable_premium_membership']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row conditional"
                 data-cond-option="Options[<?= $settings['enable_premium_membership']['id'] ?>][value]"
                 data-cond-value="1">
                <div class="col-sm-2"><?= __('Trial Membership Plan') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['trial_plan']['id'] . '.value', [
                        'label' => false,
                        'options' => $plans,
                        'empty' => __('None'),
                        'value' => $settings['trial_plan']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row conditional"
                 data-cond-option="Options[<?= $settings['enable_premium_membership']['id'] ?>][value]"
                 data-cond-value="1">
                <div class="col-sm-2"><?= __('Trial Membership Period') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['trial_plan_period']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'm' => __('Month'),
                            'y' => __('Year')
                        ],
                        'value' => $settings['trial_plan_period']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Signup Bonus') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['signup_bonus']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'number',
                        'min' => 0,
                        'step' => 'any',
                        'value' => $settings['signup_bonus']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Account Activation by Email') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['account_activate_email']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['account_activate_email']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Reserved Usernames') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['reserved_usernames']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['reserved_usernames']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __('Separate by comma, no spaces.') ?></span>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="integration" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Front Head Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['head_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['head_code']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Auth Head Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['auth_head_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['auth_head_code']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Member Head Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['member_head_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['member_head_code']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Admin Head Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['admin_head_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['admin_head_code']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Footer Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['footer_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['footer_code']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('After Body Tag Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['after_body_tag_code']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['after_body_tag_code']['value']
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <div role="tabpanel" id="admin-ads" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Member Area Ad') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['ad_member']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['ad_member']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Captcha Ad') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['ad_captcha']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['ad_captcha']['value']
                    ]);
                    ?>
                </div>
            </div>

            <legend><?= __('Interstitial Ads') ?></legend>

            <p><?= __('This ad will be displayed between logo and counter.') ?></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Interstitial Page Ad Code') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['interstitial_ads']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['interstitial_ads']['value']
                    ]);
                    ?>
                </div>
            </div>

            <legend><?= __('Banner Ads') ?></legend>

            <p><?= __('Let say you have a campaign for 728×90 space then the other places 468×60 and 336×280 ' .
                    'will be populated with the below banner ads.') ?></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Banner 728x90') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['banner_728x90']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['banner_728x90']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Banner 468x60') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['banner_468x60']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['banner_468x60']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Banner 336x280') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['banner_336x280']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'value' => $settings['banner_336x280']['value']
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <div role="tabpanel" id="captcha" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Captcha') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Captcha Type') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['captcha_type']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'recaptcha' => __('reCAPTCHA'),
                            'invisible-recaptcha' => __('Invisible reCAPTCHA'),
                            'solvemedia' => __('Solve Media'),
                            'coinhive' => __('Coinhive')
                        ],
                        'value' => $settings['captcha_type']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="conditional" data-cond-option="Options[<?= $settings['captcha_type']['id'] ?>][value]"
                 data-cond-value="recaptcha">

                <legend><?= __('reCAPTCHA Settings') ?></legend>

                <div class="row">
                    <div class="col-sm-2"><?= __('reCAPTCHA Site key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['reCAPTCHA_site_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['reCAPTCHA_site_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('reCAPTCHA Secret key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['reCAPTCHA_secret_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['reCAPTCHA_secret_key']['value']
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <div class="conditional" data-cond-option="Options[<?= $settings['captcha_type']['id'] ?>][value]"
                 data-cond-value="invisible-recaptcha">

                <legend><?= __('Invisible reCAPTCHA Settings') ?></legend>

                <div class="row">
                    <div class="col-sm-2"><?= __('Invisible reCAPTCHA Site key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['invisible_reCAPTCHA_site_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['invisible_reCAPTCHA_site_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('Invisible reCAPTCHA Secret key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['invisible_reCAPTCHA_secret_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['invisible_reCAPTCHA_secret_key']['value']
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <div class="conditional" data-cond-option="Options[<?= $settings['captcha_type']['id'] ?>][value]"
                 data-cond-value="solvemedia">

                <legend><?= __('Solve Media Settings') ?></legend>

                <div class="row">
                    <div class="col-sm-2"><?= __('Solve Media Challenge Key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['solvemedia_challenge_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['solvemedia_challenge_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('Solve Media Verification Key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['solvemedia_verification_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['solvemedia_verification_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('Solve Media Authentication Hash Key') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['solvemedia_authentication_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['solvemedia_authentication_key']['value']
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <div class="conditional" data-cond-option="Options[<?= $settings['captcha_type']['id'] ?>][value]"
                 data-cond-value="coinhive">

                <legend><?= __('Coinhive Settings') ?></legend>

                <div class="row">
                    <div class="col-sm-2"><?= __('Coinhive Site Key (public)') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['coinhive_site_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['coinhive_site_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('Coinhive Secret Key (private)') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['coinhive_secret_key']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $settings['coinhive_secret_key']['value']
                        ]);
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"><?= __('Coinhive Hashes') ?></div>
                    <div class="col-sm-10">
                        <?=
                        $this->Form->input('Options.' . $settings['coinhive_hashes']['id'] . '.value', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'number',
                            'step' => '256',
                            'min' => '256',
                            'value' => $settings['coinhive_hashes']['value']
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Home Anonymous Short Link Box') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_shortlink_anonymous']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['enable_captcha_shortlink_anonymous']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Short Links Page') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_shortlink']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha_shortlink']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Signin Form') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_signin']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha_signin']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Signup Form') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_signup']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha_signup']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Forgot Password Form') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_forgot_password']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha_forgot_password']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable on Contact Form') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['enable_captcha_contact']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No')
                        ],
                        'value' => $settings['enable_captcha_contact']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <div role="tabpanel" id="security" class="tab-pane fade in">
            <p></p>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable SSL Integration') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['ssl_enable']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['ssl_enable']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __('You should install SSL into your website before enable ' .
                            'SSL integration. For more information about SSL, please ask your hosting company.') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable https for Short links') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['https_shortlinks']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['https_shortlinks']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __('You should install SSL into your website before enable this option.') ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Google Safe Browsing API Key') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['google_safe_browsing_key']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['google_safe_browsing_key']['value']
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __(
                            'You can get your key from <a href="{0}" target="_blank">here</a>.',
                            'https://developers.google.com/safe-browsing/v4/get-started'
                        ) ?>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('PhishTank API key') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['phishtank_key']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['phishtank_key']['value']
                    ]);
                    ?>
                    <span class="help-block"><?= __(
                            'You can get your key from <a href="{0}" target="_blank">here</a>.',
                            'https://www.phishtank.com/api_register.php'
                        ) ?></span>
                </div>
            </div>

        </div>

        <div role="tabpanel" id="blog" class="tab-pane fade in">
            <p></p>
            <div class="row">
                <div class="col-sm-2"><?= __('Enable Blog') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['blog_enable']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['blog_enable']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Display Blog Post into Shortlink Page') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['display_blog_post_shortlink']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'none' => __('None'),
                            'latest' => __('Latest Post'),
                            'random' => __('Random Post')
                        ],
                        'value' => $settings['display_blog_post_shortlink']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Comments') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['blog_comments_enable']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            1 => __('Yes'),
                            0 => __('No')
                        ],
                        'value' => $settings['blog_comments_enable']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Disqus Shortname') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['disqus_shortname']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['disqus_shortname']['value']
                    ]);
                    ?>
                    <span class="help-block">
                        <?= __("To display comment box, you must create an account at " .
                            "Disqus website by signing up from <a href='https://disqus.com/profile/signup/' " .
                            "target='_blank'>here</a> then add your website their from <a href='https://" .
                            "disqus.com/admin/create/' target='_blank'>here</a> and get your shortname.") ?>
                    </span>
                </div>
            </div>


        </div>

        <div role="tabpanel" id="social" class="tab-pane fade in">
            <p></p>
            <div class="row">
                <div class="col-sm-2"><?= __('Facebook Page URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['facebook_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'url',
                        'value' => $settings['facebook_url']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Twitter Profile URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['twitter_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'url',
                        'value' => $settings['twitter_url']['value']
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Google Plus URL') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['google_plus_url']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'url',
                        'value' => $settings['google_plus_url']['value']
                    ]);
                    ?>
                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->Form->button(__('Save'), ['name' => 'save_settings', 'class' => 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>

<?php $this->start('scriptBottom'); ?>
<script>
  $('.conditional').conditionize();
</script>
<?php $this->end(); ?>
