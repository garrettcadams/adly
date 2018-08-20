<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Forms', 'action' => 'contact', 'prefix' => false],
    'id' => 'contact-form'
]);
?>

<?php
$this->Form->templates([
    'inputContainer' => '{{content}}',
    'error' => '{{content}}',
    'inputContainerError' => '{{content}}'
]);
?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?=
            $this->Form->input('name', [
                'label' => __('Your Name *'),
                'type' => 'text',
                'required' => 'required',
                'class' => 'form-control'
            ]);
            ?>
            <p class="help-block text-danger"></p>
        </div>
        <div class="form-group">
            <?=
            $this->Form->input('email', [
                'label' => __('Your Email *'),
                'type' => 'text',
                'required' => 'required',
                'class' => 'form-control'
            ]);
            ?>
            <p class="help-block text-danger"></p>
        </div>
        <div class="form-group">
            <?=
            $this->Form->input('subject', [
                'label' => __('Your Subject *'),
                'type' => 'text',
                'required' => 'required',
                'class' => 'form-control'
            ]);
            ?>
            <p class="help-block text-danger"></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?=
            $this->Form->input('message', [
                'label' => __('Your Message *'),
                'type' => 'textarea',
                'required' => 'required',
                'class' => 'form-control'
            ]);
            ?>
            <p class="help-block text-danger"></p>
        </div>
    </div>

</div>

<div>
    <div class="form-group">
        <?= $this->Form->input('accept', [
            'type' => 'checkbox',
            'label' => "<b>" . __(
                    "I consent to collect my name and email. For more details check our {0}.",
                    "<a href='" . $this->Url->build('/') . 'pages/privacy' . "' target='_blank'>" .
                    __('Privacy Policy') . "</a>"
                ) . "</b>",
            'escape' => false,
            'required' => true
        ]) ?>
    </div>

    <?php if ((get_option('enable_captcha_contact') == 'yes') && isset_captcha()) : ?>
        <div class="form-group captcha">
            <div id="captchaContact" style="display: inline-block;"></div>
        </div>
        <?php
        $this->Form->unlockField('g-recaptcha-response');
        $this->Form->unlockField('adcopy_challenge');
        $this->Form->unlockField('adcopy_response');
        $this->Form->unlockField('coinhive-captcha-token');
        ?>
    <?php endif; ?>
</div>

<div class="text-center">
    <div id="success"></div>
    <?= $this->Form->button(__('Send Message'), [
        'class' => 'btn btn-contact btn-captcha',
        'id' => 'invisibleCaptchaContact'
    ]); ?>
</div>

<?= $this->Form->end(); ?>

<div class="contact-result"></div>
