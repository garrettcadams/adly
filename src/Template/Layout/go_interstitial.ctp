<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php $user = $this->request->session()->read('Auth.User'); ?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language(null) ?>">
<head>
    <?= $this->Html->charset(); ?>
    <title><?= h($this->fetch('title')); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= h($this->fetch('description')); ?>">
    <meta name="og:title" content="<?= h($this->fetch('og_title')); ?>">
    <meta name="og:description" content="<?= h($this->fetch('og_description')); ?>">
    <meta property="og:image" content="<?= h($this->fetch('og_image')); ?>"/>

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
          rel="stylesheet">

    <?php
    echo $this->Html->meta('icon');

    echo $this->Assets->css('/vendor/bootstrap/css/bootstrap.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/font-awesome/css/font-awesome.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/dashboard/css/AdminLTE.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/dashboard/css/skins/_all-skins.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('app.css?ver=' . APP_VERSION);

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    ?>

    <?= get_option('head_code'); ?>

    <?= $this->fetch('scriptTop') ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="interstitial-page frame layout-top-nav skin-blue">
<?= get_option('after_body_tag_code'); ?>

<div class="wrapper">


    <header class="main-header">
        <!-- Fixed navbar -->
        <nav class="navbar">
            <div class="container">

                <div class="row is-table-row">
                    <div class="col-xs-6 col-sm-3">
                        <div class="navbar-header pull-left">
                            <?php
                            $logo = get_logo();
                            $class = '';
                            if ($logo['type'] == 'image') {
                                $class = 'logo-image';
                            }
                            ?>
                            <a class="navbar-brand <?= $class ?>"
                               href="<?= build_main_domain_url('/'); ?>"><?= $logo['content'] ?></a>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-6">
                        <?php if (!empty($interstitial_ads)) : ?>
                            <div class="banner banner-468x60">
                                <div class="banner-inner">
                                    <?= $interstitial_ads; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="pull-right">
                            <div class="skip-ad">
                                <div class="text-center">
                                    <span><?= __('Please Wait') ?></span><br>
                                    <span class="counter"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
    </header>

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

</div>

<?= $this->element('js_vars'); ?>

<?= $this->Assets->script('/js/ads.js'); ?>

<?= $this->Assets->script('/vendor/jquery.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/bootstrap/js/bootstrap.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/clipboard.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/js/app.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/dashboard/js/app.min.js?ver=' . APP_VERSION); ?>

<?php if (in_array(get_option('captcha_type', 'recaptcha'), ['recaptcha', 'invisible-recaptcha'])) : ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadRecaptchaCallback&render=explicit"
            async defer></script>
<?php endif; ?>

<?php if (get_option('captcha_type') == 'solvemedia') : ?>
    <script language="javascript" type="text/javascript">
      var script = document.createElement('script');
      script.type = 'text/javascript';

      if (location.protocol === 'https:') {
        script.src = 'https://api-secure.solvemedia.com/papi/challenge.ajax';
      } else {
        script.src = 'http://api.solvemedia.com/papi/challenge.ajax';
      }
      document.body.appendChild(script);
    </script>
<?php endif; ?>

<?php if (get_option('captcha_type') == 'coinhive') : ?>
    <script language="javascript" type="text/javascript">
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'htt' + 'ps://' + 'aut' + 'hedm' + 'ine' + '.com/lib/ca' + 'ptcha' + '.min.js';
      document.body.appendChild(script);
    </script>
<?php endif; ?>

<?= $this->fetch('scriptBottom') ?>
<?= get_option('footer_code'); ?>
</body>
</html>
