<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Payment Settings'));
$this->assign('description', '');
$this->assign('content_title', __('Payment Settings'));
?>

<div class="box box-primary">
    <div class="box-body">
        <?= $this->Form->create($options, [
            'id' => 'form-settings',
            'onSubmit' => "save_settings.disabled=true; save_settings.innerHTML='" . __('Saving ...') . "'; return true;"
        ]); ?>

        <div class="row">
            <div class="col-sm-2"><?= __('Currency Code') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['currency_code']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['currency_code']['value']
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Currency Symbol') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['currency_symbol']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['currency_symbol']['value']
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Currency Position') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['currency_position']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'before' => __('Before Price'),
                        'after' => __('After Price')
                    ],
                    'value' => $settings['currency_position']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Price Number of Decimals') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['price_decimals']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'number',
                    'step' => 1,
                    'min' => 0,
                    'max' => 9,
                    'value' => $settings['price_decimals']['value']
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Wallet Settings') ?></legend>

        <p><?= __("Your users will be able to withdraw money to their wallet then use it to pay campaigns.") ?></p>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Wallet') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['wallet_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['wallet_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('PayPal Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738312-paypal-setup") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable PayPal') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['paypal_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'no' => __('No'),
                        'yes' => __('Yes')
                    ],
                    'value' => $settings['paypal_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payment Business Email') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['paypal_email']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'email',
                    'value' => $settings['paypal_email']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable PayPal Sandbox') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['paypal_sandbox']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'no' => __('No'),
                        'yes' => __('Yes')
                    ],
                    'value' => $settings['paypal_sandbox']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Stripe Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738313-stripe-setup") ?></span>
        <div class="row">
            <div class="col-sm-2"><?= __('Enable Stripe') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['stripe_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['stripe_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Stripe Secret Key') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['stripe_secret_key']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['stripe_secret_key']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Stripe Publishable Key') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['stripe_publishable_key']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['stripe_publishable_key']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Payza Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738314-payza-setup") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Payza') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payza_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'no' => __('No'),
                        'yes' => __('Yes')
                    ],
                    'value' => $settings['payza_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payza Merchant Email') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payza_email']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'email',
                    'value' => $settings['payza_email']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Payza Test Mode') ?></div>
            <div class="col-sm-10">
                <p class="form-group"><?= __('You can enable Payza sandbox from your Payza account settings.') ?></p>
            </div>
        </div>

        <legend><?= __('Skrill Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738315-skrill-setup") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Skrill') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['skrill_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['skrill_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Skrill Merchant Email') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['skrill_email']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'email',
                    'value' => $settings['skrill_email']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Skrill Secret Word') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['skrill_secret_word']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['skrill_secret_word']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Bitcoin Processor') ?></legend>
        <?=
        $this->Form->input('Options.' . $settings['bitcoin_processor']['id'] . '.value', [
            'label' => false,
            'options' => [
                'coinbase' => __('Coinbase'),
                'coinpayments' => __('CoinPayments')
            ],
            'value' => $settings['bitcoin_processor']['value'],
            'class' => 'form-control'
        ]);
        ?>

        <div class="conditional" data-cond-option="Options[<?= $settings['bitcoin_processor']['id'] ?>][value]"
             data-cond-value="coinpayments">
            <legend><?= __('CoinPayments Settings') ?></legend>

            <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                    "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738316-coinpayments-setup") ?></span>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable CoinPayments') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinpayments_enable']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            0 => __('No'),
                            1 => __('Yes')
                        ],
                        'value' => $settings['coinpayments_enable']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('CoinPayments Public Key') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinpayments_public_key']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinpayments_public_key']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('CoinPayments Private Key') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinpayments_private_key']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinpayments_private_key']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('CoinPayments Merchant Id') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinpayments_merchant_id']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinpayments_merchant_id']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('CoinPayments IPN Secret') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinpayments_ipn_secret']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinpayments_ipn_secret']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="conditional" data-cond-option="Options[<?= $settings['bitcoin_processor']['id'] ?>][value]"
             data-cond-value="coinbase">
            <legend><?= __('Coinbase Settings') ?></legend>

            <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                    "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738317-coinbase-settings") ?></span>

            <div class="row">
                <div class="col-sm-2"><?= __('Enable Coinbase') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinbase_enable']['id'] . '.value', [
                        'label' => false,
                        'options' => [
                            'no' => __('No'),
                            'yes' => __('Yes')
                        ],
                        'value' => $settings['coinbase_enable']['value'],
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Coinbase API Key') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinbase_api_key']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinbase_api_key']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"><?= __('Coinbase API Secret') ?></div>
                <div class="col-sm-10">
                    <?=
                    $this->Form->input('Options.' . $settings['coinbase_api_secret']['id'] . '.value', [
                        'label' => false,
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $settings['coinbase_api_secret']['value'],
                        'autocomplete' => 'off'
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <legend><?= __('Webmoney Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738318-webmoney-settings") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Webmoney') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['webmoney_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'no' => __('No'),
                        'yes' => __('Yes')
                    ],
                    'value' => $settings['webmoney_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Webmoney Merchant Purse') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['webmoney_merchant_purse']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['webmoney_merchant_purse']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Perfect Money Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738319-perfect-money-settings") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Perfect Money') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['perfectmoney_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['perfectmoney_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Perfect Money Payee Account') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['perfectmoney_account']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['perfectmoney_account']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Perfect Money Alternate Passphrase') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['perfectmoney_passphrase']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['perfectmoney_passphrase']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Payeer Settings') ?></legend>

        <span class="help-block"><?= __('For setup instructions click <a href="{0}" target="_blank">here</a>.',
                "https://mightyscripts.freshdesk.com/support/solutions/articles/5000738320-payeer-settings") ?></span>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Payeer') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        0 => __('No'),
                        1 => __('Yes')
                    ],
                    'value' => $settings['payeer_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payeer Merchant Id') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_merchant_id']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['payeer_merchant_id']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payeer Secret Key') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_secret_key']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['payeer_secret_key']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Payeer Encryption Key') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['payeer_encryption_key']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'text',
                    'value' => $settings['payeer_encryption_key']['value'],
                    'autocomplete' => 'off'
                ]);
                ?>
            </div>
        </div>

        <legend><?= __('Bank Transfer Settings') ?></legend>

        <div class="row">
            <div class="col-sm-2"><?= __('Enable Bank Transfer') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['banktransfer_enable']['id'] . '.value', [
                    'label' => false,
                    'options' => [
                        'no' => __('No'),
                        'yes' => __('Yes')
                    ],
                    'value' => $settings['banktransfer_enable']['value'],
                    'class' => 'form-control'
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?= __('Bank Transfer Instructions') ?></div>
            <div class="col-sm-10">
                <?=
                $this->Form->input('Options.' . $settings['banktransfer_instructions']['id'] . '.value', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'value' => $settings['banktransfer_instructions']['value']
                ]);
                ?>
                <span class="help-block"><?= __("You can use these placeholders [invoice_id], ".
                        "[invoice_amount], [invoice_description]") ?></span>
            </div>
        </div>


        <?= $this->Form->button(__('Save'), ['name' => 'save_settings', 'class' => 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>
<script>
  $('.conditional').conditionize();
</script>
<?php $this->end(); ?>
