<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Full Page Script'));
$this->assign('description', '');
$this->assign('content_title', __('Full Page Script'));
?>

<div class="box box-primary">
    <div class="box-body">

        <?php if ($notice) : ?>
            <div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i><?= $notice ?></div>
        <?php endif; ?>

        <p><?= __(
            "If you have a website with 100's or 1000's of links you want to change over to {0} ".
                "then please use the script below.",
            get_option('site_name')
        ) ?></p>

        <p><?= __("Simply copy-and-paste the code below on to your webpage or blog and the links will be ".
                "updated automatically!") ?></p>

        <p><?= __("You can add or remove any domains for the code that you use on your website.") ?></p>

        <?php
        $script_url = str_replace(['http://', 'https://'], ['//', '//'], $this->Url->build('/', true));
        ?>

        <?php
        ob_start();
        ?>
        <script type="text/javascript">
            var adlinkfly_url = '<?= $this->Url->build('/', true); ?>';
            var adlinkfly_api_token = '<?= $logged_user->api_token ?>';
            var adlinkfly_advert = <?= get_option('member_default_advert', 1) ?>;
            var adlinkfly_domains = ['depositfiles.com', '*.zippyshare.com', 'uploadable.ch'];
        </script>
        <script src='<?= $script_url; ?>js/full-page-script.js'></script>
        <?php
        $code1 = ob_get_contents();
        ob_end_clean();
        ?>

        <pre><?= htmlentities($code1); ?></pre>

        <p><?= __(
            "Or if you wish to change every link to {0} on your website (without stating exactly ".
                "which domains) please use the following code.",
            get_option('site_name')
        ) ?></p>

        <?php
        ob_start();
        ?>
        <script type="text/javascript">
            var adlinkfly_url = '<?= $this->Url->build('/', true); ?>';
            var adlinkfly_api_token = '<?= $logged_user->api_token ?>';
            var adlinkfly_advert = <?= get_option('member_default_advert', 1) ?>;
            var adlinkfly_exclude_domains = ['example.com', 'yoursite.com'];
        </script>
        <script src='<?= $script_url; ?>js/full-page-script.js'></script>
        <?php
        $code2 = ob_get_contents();
        ob_end_clean();
        ?>

        <pre><?= htmlentities($code2); ?></pre>

        <hr>

        <?php
        $allowed_ads = get_allowed_ads();
        unset($allowed_ads[get_option('member_default_advert', 1)]);
        ?>

        <?php if (array_key_exists(1, $allowed_ads)) : ?>
            <p><?= __("If you want to use Full Page Script with the interstitial advertising replace this code") ?></p>
            <pre>var adlinkfly_advert = <?= get_option('member_default_advert', 1) ?>;</pre>
            <p><?= __("With") ?></p>
            <pre>var adlinkfly_advert = 1;</pre>
        <?php endif; ?>

        <?php if (array_key_exists(2, $allowed_ads)) : ?>
            <p><?= __("If you want to use Full Page Script with the banner advertising replace this code") ?></p>
            <pre>var adlinkfly_advert = <?= get_option('member_default_advert', 1) ?>;</pre>
            <p><?= __("With") ?></p>
            <pre>var adlinkfly_advert = 2;</pre>
        <?php endif; ?>

        <?php if (array_key_exists(0, $allowed_ads)) : ?>
            <p><?= __("If you want to use Full Page Script without advertising replace this code") ?></p>
            <pre>var adlinkfly_advert = <?= get_option('member_default_advert', 1) ?>;</pre>
            <p><?= __("With") ?></p>
            <pre>var adlinkfly_advert = 0;</pre>
        <?php endif; ?>

    </div>
</div>
