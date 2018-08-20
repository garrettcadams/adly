<?php
/**
 * @var \App\View\AppView $this
 */
$app_vars = [
    'base_url' => build_main_domain_url('/'),
    'language' => h(locale_get_default()),
    'copy' => h(__("Copy")),
    'copied' => h(__("Copied!")),
    'user_id' => h($this->request->session()->read('Auth.User.id')),
    'home_shortening_register' => (get_option('home_shortening_register') == 'yes') ? 'yes' : 'no',
    'enable_captcha' => get_option('enable_captcha', 'no'),
    'captcha_type' => h(get_option('captcha_type', "recaptcha")),
    'reCAPTCHA_site_key' => h(get_option('reCAPTCHA_site_key')),
    'invisible_reCAPTCHA_site_key' => h(get_option('invisible_reCAPTCHA_site_key')),
    'solvemedia_challenge_key' => h(get_option('solvemedia_challenge_key')),
    'coinhive_site_key' => h(get_option('coinhive_site_key')),
    'coinhive_hashes' => h(get_option('coinhive_hashes', '1024')),
    'captcha_short_anonymous' => h(get_option('enable_captcha_shortlink_anonymous', 0)),
    'captcha_shortlink' => h(get_option('enable_captcha_shortlink', 'no')),
    'captcha_signin' => h(get_option('enable_captcha_signin', 'no')),
    'captcha_signup' => h(get_option('enable_captcha_signup', 'no')),
    'captcha_forgot_password' => h(get_option('enable_captcha_forgot_password', 'no')),
    'captcha_contact' => h(get_option('enable_captcha_contact', 'no')),
    'counter_value' => h(get_option('counter_value', 5)),
    'counter_start' => h(get_option('counter_start', 'DOMContentLoaded')),
    'get_link' => h(__('Get Link')),
    'getting_link' => h(__('Getting link...')),
    'skip_ad' => h(__('Skip Ad')),
    'force_disable_adblock' => h(get_option('force_disable_adblock', 0)),
    'please_disable_adblock' => h(__("Please disable Adblock to proceed to the destination page.")),
    'cookie_notification_bar' => (bool)get_option('cookie_notification_bar', 1),
    'cookie_message' => __('This website uses cookies to ensure you get the best experience on our website. {0}',
        "<a href='" . build_main_domain_url('/pages/privacy') . "' target='_blank'><b>" .
        __('Learn more') . "</b></a>"),
    'cookie_button' => h(__('Got it!')),
];
?>
<script type='text/javascript'>
  /* <![CDATA[ */
  var app_vars = <?= json_encode($app_vars) ?>;
  /* ]]> */
</script>
