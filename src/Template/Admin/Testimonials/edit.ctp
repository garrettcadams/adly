<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Add Testimonial'));
$this->assign('description', '');
$this->assign('content_title', __('Add Testimonial'));
?>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create($testimonial); ?>

        <?= $this->Form->hidden('id'); ?>

        <?=
        $this->Form->input('name', [
            'label' => __('Name'),
            'class' => 'form-control',
            'type' => 'text'
        ]);

        ?>

        <?=
        $this->Form->input('position', [
            'label' => __('Position'),
            'class' => 'form-control',
            'type' => 'text'
        ]);

        ?>

        <?=
        $this->Form->input('image', [
            'label' => __('Image'),
            'class' => 'form-control',
            'type' => 'text'
        ]);

        ?>

        <?=
        $this->Form->input('published', [
            'label' => __('Published'),
            'options' => [
                '1' => __('Yes'),
                '0' => __('No')
            ],
            'class' => 'form-control'
        ]);

        ?>

        <?=
        $this->Form->input('content', [
            'label' => __('Content'),
            'class' => 'form-control text-editor',
            'type' => 'textarea'
        ]);

        ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>

<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replaceClass = 'text-editor';
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    });
</script>

<?php $this->end(); ?>
