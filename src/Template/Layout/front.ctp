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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= h($this->fetch('description')); ?>">

    <?= $this->Html->meta('icon'); ?>

    <?= $this->Assets->css('/vendor/bootstrap/css/bootstrap.min.css?ver=' . APP_VERSION); ?>
    <?= $this->Assets->css('/vendor/font-awesome/css/font-awesome.min.css?ver=' . APP_VERSION); ?>
    <?= $this->Assets->css('/vendor/animate.min.css?ver=' . APP_VERSION); ?>

    <link href="//fonts.googleapis.com/css?family=Droid+Serif:400,400i,700,700i%7CMontserrat:400,700%7CRoboto+Slab:100,300,400,700"
          rel="stylesheet">

    <?= $this->Assets->css('front.css?ver=' . APP_VERSION); ?>
    <?= $this->Assets->css('app.css?ver=' . APP_VERSION); ?>

    <?php
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    ?>

    <?= get_option('head_code'); ?>

    <?= $this->fetch('scriptTop') ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index <?= ($this->request->here == $this->request->webroot) ? '' : 'inner-page' ?>">
<?= get_option('after_body_tag_code'); ?>
<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php
            $logo = get_logo();
            $class = '';
            if ($logo['type'] == 'image') {
                $class = 'logo-image';
            }
            ?>
            <a class="navbar-brand <?= $class ?>" href="<?= build_main_domain_url('/'); ?>"><?= $logo['content'] ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li>
                    <a href="<?= build_main_domain_url('/'); ?>"><?= __('Home') ?></a>
                </li>
                <?php if (get_option('enable_advertising', 'yes') == 'yes') : ?>
                    <li>
                        <a href="<?= build_main_domain_url('/advertising-rates'); ?>"><?= __('Advertising') ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?= build_main_domain_url('/payout-rates'); ?>"><?= __('Payout Rates') ?></a>
                </li>
                <?php
                if (null !== $this->request->session()->read('Auth.User.id')) {
                    ?>
                    <li>
                        <a href="<?= build_main_domain_url('/member/dashboard'); ?>"><?= __('Dashboard') ?></a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                        <a href="<?= build_main_domain_url('/auth/signin'); ?>"><?= __('Login') ?></a>
                    </li>
                    <li>
                        <a href="<?= build_main_domain_url('/auth/signup'); ?>"><?= __('Sign Up') ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright"><?= __('Copyright &copy;') ?> <?= h(get_option('site_name')) ?> <?= date("Y") ?></span>
            </div>
            <div class="col-md-4">
                <ul class="list-inline social-buttons">
                    <?php if (get_option('facebook_url')) : ?>
                        <li><a href="<?= h(get_option('facebook_url')) ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_option('twitter_url')) : ?>
                        <li><a href="<?= h(get_option('twitter_url')) ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php endif; ?>
                    <?php if (get_option('google_plus_url')) : ?>
                        <li><a href="<?= h(get_option('google_plus_url')) ?>"><i class="fa fa-google-plus"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
                    <li><a href="<?= build_main_domain_url('/pages/privacy'); ?>"><?= __('Privacy Policy') ?></a>
                    </li>
                    <li><a href="<?= build_main_domain_url('/pages/terms'); ?>"><?= __('Terms of Use') ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?= $this->Assets->script('/js/ads.js'); ?>

<?= $this->Assets->script('/vendor/jquery.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/bootstrap/js/bootstrap.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/wow.min.js?ver=' . APP_VERSION); ?>
<?= $this->Assets->script('/vendor/clipboard.min.js?ver=' . APP_VERSION); ?>

<?= $this->element('js_vars'); ?>

<!-- Custom Theme JavaScript -->
<?= $this->Assets->script('front'); ?>
<?= $this->Assets->script('app.js?ver=' . APP_VERSION); ?>

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
