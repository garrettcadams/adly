<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('Edit User #{0}', $user->id));
$this->assign('description', '');
$this->assign('content_title', __('Edit User #{0}', $user->id));
?>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create($user); ?>

        <?= $this->Form->hidden('id') ?>

        <?=
        $this->Form->input('role', [
            'label' => __('Role'),
            'options' => [
                'member' => __('Member'),
                'admin' => __('Admin')
            ],
            'class' => 'form-control'
        ]);
        ?>

        <?=
        $this->Form->input('status', [
            'label' => __('Status'),
            'options' => [
                1 => __('Active'),
                2 => __('Pending'),
                3 => __('Inactive')
            ],
            'class' => 'form-control'
        ]);
        ?>

        <?=
        $this->Form->input('disable_earnings', [
            'label' => __('Disable User Future Earnings'),
            'options' => [
                0 => __('No'),
                1 => __('Yes')
            ],
            'class' => 'form-control'
        ]);
        ?>

        <div class="row">
            <div class="col-sm-6">
                <?=
                $this->Form->input('plan_id', [
                    'label' => __('Plan'),
                    'options' => $plans,
                    'empty' => __('Choose Plan'),
                    'class' => 'form-control'
                ]);
                ?>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?= __('Plan Expiration Date') ?></label>
                    <div><?= $this->Form->date('expiration'); ?></div>
                </div>
            </div>
        </div>

        <?=
        $this->Form->input('username', [
            'label' => __('Username'),
            'class' => 'form-control'
        ])
        ?>

        <?=
        $this->Form->input('email', [
            'label' => __('Email'),
            'type' => 'email',
            'class' => 'form-control'
        ])
        ?>

        <?=
        $this->Form->input('wallet_money', [
            'label' => __('Money Wallet'),
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control'
        ])
        ?>

        <?=
        $this->Form->input('publisher_earnings', [
            'label' => __('Publisher Earnings'),
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control'
        ])
        ?>

        <?=
        $this->Form->input('referral_earnings', [
            'label' => __('Referral Earnings'),
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control'
        ])
        ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>
