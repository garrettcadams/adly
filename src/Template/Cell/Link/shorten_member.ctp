<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Links', 'action' => 'shorten', 'prefix' => false],
    'id' => 'shorten'
]);
?>

<?php
$this->Form->templates([
    'inputContainer' => '{{content}}',
    'error' => '{{content}}',
    'inputContainerError' => '{{content}}'
]);
?>
<div class="form-group">
    <?=
    $this->Form->input('url', [
        'label' => false,
        'type' => 'text',
        'placeholder' => __('Your URL Here'),
        'required' => 'required',
        'class' => 'form-control'
    ]);
    ?>
</div>

<div class="advanced-div" style="display: none; overflow: hidden;">

    <div class="row">

        <?php if ($custom_alias) : ?>
            <div class="col-sm-4">
                <div class="form-group">
                    <?=
                    $this->Form->input('alias', [
                        'label' => __('Alias'),
                        'type' => 'text',
                        'placeholder' => __('Alias'),
                        'class' => 'form-control input-sm'
                    ]);
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-sm-4">
            <div class="form-group">
                <?php
                $ads_options = get_allowed_ads();

                if (count($ads_options) > 1) {
                    echo $this->Form->input('ad_type', [
                        'label' => __('Advertising Type'),
                        'options' => $ads_options,
                        'default' => get_option('member_default_advert', 1),
                        //'empty'   => __( 'Choose' ),
                        'class' => 'form-control input-sm'
                    ]);
                } else {
                    echo $this->Form->hidden('ad_type', ['value' => get_option('member_default_advert', 1)]);
                }
                ?>
            </div>
        </div>
        <?php if ($multi_domains) : ?>
            <div class="col-sm-4">
                <?php if (count(get_multi_domains_list())) : ?>
                    <div class="form-group">
                        <?=
                        $this->Form->input('domain', [
                            'label' => __('Domain'),
                            'options' => get_multi_domains_list(),
                            'default' => '',
                            'empty' => get_default_short_domain(),
                            'class' => 'form-control input-sm'
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->Form->button(__('Shorten'), ['class' => 'btn btn-submit btn-primary btn-xs']); ?>
<button type="button" class="btn btn-default btn-xs advanced"><?= __('Advanced Options') ?></button>

<?= $this->Form->end(); ?>

<div class="shorten add-link-result"></div>
