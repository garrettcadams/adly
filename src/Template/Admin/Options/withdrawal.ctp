<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Withdrawal Methods'));
$this->assign('description', '');
$this->assign('content_title', __('Withdrawal Methods'));
?>

<div class="box box-primary">
    <div class="box-body">
        <?= $this->Form->create($options, [
            'id' => 'form-settings',
            'onSubmit' =>
                "save_settings.disabled=true; save_settings.innerHTML='" . __('Saving ...') . "'; return true;"
        ]); ?>

        <div class="row">
            <div class="col-sm-2"><?= __('Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['minimum_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['minimum_withdrawal_amount']['value']
                ]);
                ?>
                <span class="help-block">
                    <?= __('This amount will be displayed only on home page.') ?>
                </span>
            </div>
        </div>

        <legend><?= __('Money Wallet Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Wallet Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['wallet_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['wallet_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('PayPal Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable PayPal') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['paypal_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['paypal_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('PayPal Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['paypal_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['paypal_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Payza Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Payza') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payza_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['payza_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payza Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payza_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['payza_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Skrill Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Skrill') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['skrill_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['skrill_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Skrill Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['skrill_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['skrill_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Bitcoin Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Bitcoin') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['bitcoin_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['bitcoin_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Bitcoin Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['bitcoin_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['bitcoin_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>


        <legend><?= __('Webmoney Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Webmoney') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['webmoney_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['webmoney_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Webmoney Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['webmoney_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['webmoney_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Perfect Money Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Perfect Money') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['perfectmoney_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['perfectmoney_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Perfect Money Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['perfectmoney_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['perfectmoney_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Payeer Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Payeer') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['payeer_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payeer Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['payeer_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Bank Transfer Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Bank Transfer') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['banktransfer_withdrawal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['banktransfer_withdrawal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Bank Transfer Minimum Withdrawal Amount') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['banktransfer_withdrawal_amount']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['banktransfer_withdrawal_amount']['value']
                ]);
                ?>
            </div>
        </div>

        <hr>

        <legend><?= __('Custom Withdrawal Methods') ?></legend>

        <?=
        $this->Form->input('Options.' . $settings['custom_withdrawal_methods']['id'] . '.value', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'textarea',
            'value' => $settings['custom_withdrawal_methods']['value']
        ]);
        ?>
        <p class="help-block">
            <?= __('You can add custom withdrawal methods like the following example:') ?><br>
            <b>method_id | Method Name | Minimum Amount,method_id_2 | Method Name 2 | Minimum Amount 2</b><br>
            <?= __('</b> Please note: Each method separated by "," and for each method parts separated by "|"') ?>
        </p>

        <?= $this->Form->button(__('Save'), ['name' => 'save_settings', 'class' => 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>
<?php $this->end(); ?>
