<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$this->assign('title', __('Edit Link: {0}', $link->alias));
$this->assign('description', '');
$this->assign('content_title', __('Edit Link: {0}', $link->alias));
?>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create($link); ?>

        <?= $this->Form->hidden('id'); ?>

        <?=
        $this->Form->input('status', [
            'label' => __('Status'),
            'options' => [
                1 => __('Active'),
                2 => __('Hidden'),
                3 => __('Inactive')
            ],
            'class' => 'form-control'
        ]);
        ?>

        <?=
        $this->Form->input('url', [
            'label' => __('Long URL'),
            'class' => 'form-control',
            'type' => 'url'
        ]);
        ?>

        <?=
        $this->Form->input('title', [
            'label' => __('Title'),
            'class' => 'form-control',
            'type' => 'text'
        ]);
        ?>

        <?=
        $this->Form->input('description', [
            'label' => __('Description'),
            'class' => 'form-control',
            'type' => 'textarea'
        ]);
        ?>

        <?php
        $ads_options = get_allowed_ads();

        if (count($ads_options) > 1) {
            echo $this->Form->input('ad_type', [
                'label' => __('Advertising Type'),
                'options' => $ads_options,
                //'empty'   => __( 'Choose' ),
                'class' => 'form-control input-sm'
            ]);
        }
        ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>
