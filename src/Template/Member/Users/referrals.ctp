<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->assign('title', __('Referrals'));
$this->assign('description', '');
$this->assign('content_title', __('Referrals'));
?>

<div class="box box-default box-solid">
    <div class="box-body">
        <p>
            <?= __(
                'The {0} referral program is a great way to spread the word of this great service and to ' .
                'earn even more money with your short links! Refer friends and receive {1}% of their earnings ' .
                'for life!',
                [h(get_option('site_name', '')), h(get_option('referral_percentage', '20'))]
            ) ?>
        </p>

        <?php $ref = $this->Url->build('/', true) . 'ref/' . $this->request->session()->read('Auth.User.username'); ?>

        <pre><?= $ref ?></pre>

        <?= str_replace('[referral_link]', $ref, get_option('referral_banners_code')); ?>

    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-exchange"></i> <?= __('My Referrals') ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">

        <table class="table table-hover table-striped">
            <tr>
                <th><?= __('Username'); ?></th>
                <th><?= __('Date'); ?></th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->
            <?php foreach ($referrals as $referral) : ?>
                <tr>
                    <td><?= h($referral->username); ?></td>
                    <td><?= display_date_timezone($referral->created) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($referral); ?>
        </table>

    </div><!-- /.box-body -->
</div>

<ul class="pagination">
    <!-- Shows the previous link -->
    <?php
    if ($this->Paginator->hasPrev()) {
        echo $this->Paginator->prev(
            '«',
            array('tag' => 'li'),
            null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')
        );
    }
    ?>

    <!-- Shows the page numbers -->
    <?php //echo $this->Paginator->numbers();    ?>
    <?php
    echo $this->Paginator->numbers(array(
        'modulus' => 4,
        'separator' => '',
        'ellipsis' => '<li><a href="javascript: return false;">...</a></li>',
        'tag' => 'li',
        'currentTag' => 'a',
        'first' => 2,
        'last' => 2
    ));
    ?>

    <!-- Shows the next link -->
    <?php
    if ($this->Paginator->hasNext()) {
        echo $this->Paginator->next(
            '»',
            array('tag' => 'li'),
            null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')
        );
    }
    ?>
</ul>
