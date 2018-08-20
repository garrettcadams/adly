<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('All Referrals'));
$this->assign('description', '');
$this->assign('content_title', __('All Referrals'));

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-exchange"></i> <?= __('All Referrals') ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">

        <table class="table table-hover table-striped">
            <tr>
                <th><?= __('Username'); ?></th>
                <th><?= __('Referred By'); ?></th>
                <th><?= __('Date'); ?></th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->
            <?php foreach ($referrals as $referral): ?>
                <tr>
                    <td><?= $this->Html->link($referral->username,
                            ['controller' => 'Users', 'action' => 'view', $referral->id]); ?></td>
                    <td><?= $this->Html->link($referral->referred_by_username,
                            ['controller' => 'Users', 'action' => 'view', $referral->referred_by]); ?></td>
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
        echo $this->Paginator->prev('«', array('tag' => 'li'), null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    }

    ?>
    <!-- Shows the page numbers -->
    <?php //echo $this->Paginator->numbers();    ?>
    <?php
    echo $this->Paginator->numbers(array(
        'modulus' => 4,
        'separator' => '',
        'ellipsis' => '<li><a>...</a></li>',
        'tag' => 'li',
        'currentTag' => 'a',
        'first' => 2,
        'last' => 2
    ));

    ?>
    <!-- Shows the next link -->
    <?php
    if ($this->Paginator->hasNext()) {
        echo $this->Paginator->next('»', array('tag' => 'li'), null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    }

    ?>
</ul>
