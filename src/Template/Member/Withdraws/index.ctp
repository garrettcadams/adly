<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Withdraw[]|\Cake\Collection\CollectionInterface $withdraws
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('Withdraw Funds'));
$this->assign('description', '');
$this->assign('content_title', __('Withdraw Funds'));
?>

<?php
$statuses = [
    1 => __('Approved'),
    2 => __('Pending'),
    3 => __('Complete'),
    4 => __('Cancelled'),
    5 => __('Returned')
];

$withdrawal_methods = array_column(get_withdrawal_methods(), 'name', 'id');
?>

<div class="row">
    <div class="col-sm-4">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= display_price_currency($user->publisher_earnings + $user->referral_earnings); ?></h3>
                <p><?= __('Available Balance') ?></p>
            </div>
            <div class="icon"><i class="fa fa-money"></i></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= display_price_currency($pending_withdrawn); ?></h3>
                <p><?= __('Pending Withdrawn') ?></p>
            </div>
            <div class="icon"><i class="fa fa-share"></i></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= display_price_currency($total_withdrawn); ?></h3>
                <p><?= __('Total Withdraw') ?></p>
            </div>
            <div class="icon"><i class="fa fa-usd"></i></div>
        </div>
    </div>
</div>


<div class="box box-primary">
    <div class="box-body table-responsive">
        <div class="text-center">
            <?= $this->Form->postLink(
                __('Withdraw'),
                ['action' => 'request'],
                ['confirm' => __('Are you sure?'), 'class' => 'btn btn-success btn-lg']
            ); ?>
        </div>
        <hr>

        <p><?= __(
                "When your account reaches the minimum amount or more, you may request your " .
                "earnings by clicking the above button. The payment is then sent to your withdraw account during " .
                "business days no longer than 4 days after requesting. Please do not contact us regarding " .
                "payments before due dates."
            ) ?></p>

        <p>
            <?= __(
                'In order to receive your payments you need to fill your payment method and payment ID ' .
                '<a href="{0}">here</a> if you haven\'t done so. You are also requested to fill all the required ' .
                'fields in the Account Details section with accurate data.',
                $this->Url->build(['controller' => 'Users', 'action' => 'profile', 'prefix' => 'member'])
            ) ?>
        </p>

        <hr>

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', __('ID')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Date')) ?></th>
                <th><?= __('Status') ?></th>
                <th><?= $this->Paginator->sort('publisher_earnings', __('Publisher Earnings')) ?></th>
                <?php if ((bool)get_option('enable_referrals', 1)) : ?>
                    <th><?= $this->Paginator->sort('referral_earnings', __('Referral Earnings')) ?></th>
                <?php endif; ?>
                <th><?= __('Total Amount') ?></th>
                <th><?= __('Withdrawal Method') ?></th>
                <th><?= __('Withdrawal Account') ?></th>
            </tr>
            </thead>
            <?php foreach ($withdraws as $withdraw) : ?>
                <tr>
                    <td><?= $withdraw->id ?></td>
                    <td><?= display_date_timezone($withdraw->created); ?></td>
                    <td><?= $statuses[$withdraw->status] ?></td>
                    <td><?= display_price_currency($withdraw->publisher_earnings); ?></td>
                    <?php if ((bool)get_option('enable_referrals', 1)) : ?>
                        <td><?= display_price_currency($withdraw->referral_earnings); ?></td>
                    <?php endif; ?>
                    <td><?= display_price_currency($withdraw->amount); ?></td>
                    <td><?= (isset($withdrawal_methods[$withdraw->method])) ?
                            $withdrawal_methods[$withdraw->method] : $withdraw->method ?></td>
                    <td><?= nl2br(h($withdraw->account)); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($withdraw); ?>
        </table>

        <hr>

        <ul>
            <li><?= __("Pending: The payment is being checked by our team.") ?></li>
            <li><?= __("Approved: The payment has been approved and is waiting to be sent.") ?></li>
            <li><?= __("Complete: The payment has been successfully sent to your payment account.") ?></li>
            <li><?= __("Cancelled: The payment has been cancelled.") ?></li>
            <li><?= __("Returned: The payment has been returned to your account.") ?></li>
        </ul>
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
        echo $this->Paginator->next(
            '»',
            array('tag' => 'li'),
            null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')
        );
    }
    ?>
</ul>
