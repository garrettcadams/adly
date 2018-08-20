<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language(null) ?>">
<head>
    <?= $this->element('front_head'); ?>
</head>
<body class="<?= ($this->request->here == $this->request->webroot) ? 'home' : 'inner-page' ?>">
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
                <?php if ((bool)get_option('blog_enable', false)) : ?>
                    <li>
                        <a href="<?= build_main_domain_url('/blog'); ?>"><?= __('Blog') ?></a>
                    </li>
                <?php endif; ?>
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
                <?php if (count(get_site_languages(true)) > 1) : ?>
                    <li class="dropdown language-selector">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><i class="fa fa-language"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach (get_site_languages(true) as $lang) : ?>
                                <li>
                                    <?= $this->Html->link(
                                        locale_get_display_name($lang, $lang),
                                        '/' . $this->request->url . '?lang=' . $lang
                                    ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<?= $this->element('front_footer'); ?>

</body>

</html>
