<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Add Post'));
$this->assign('description', '');
$this->assign('content_title', __('Add Post'));
?>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create($post); ?>

        <?=
        $this->Form->input('title', [
            'label' => __('Title'),
            'class' => 'form-control',
            'type' => 'text'
        ]);
        ?>

        <?=
        $this->Form->input('slug', [
            'label' => __('Slug'),
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
        $this->Form->input('short_description', [
            'label' => __('Short Description'),
            'class' => 'form-control text-editor',
            'type' => 'textarea'
        ]);
        ?>

        <?=
        $this->Form->input('description', [
            'label' => __('Description'),
            'class' => 'form-control text-editor',
            'type' => 'textarea'
        ]);
        ?>

        <?=
        $this->Form->input('meta_title', [
            'label' => __('Meta Title'),
            'class' => 'form-control',
            'type' => 'text'
        ]);
        ?>
        <span class="help-block"><?= __('The recommended length is 50-60 characters.') ?></span>

        <?=
        $this->Form->input('meta_description', [
            'label' => __('Meta Description'),
            'class' => 'form-control',
            'type' => 'textarea'
        ]);
        ?>
        <span class="help-block"><?= __('The recommended length is 160 characters.') ?></span>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>

<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script>
  $(document).ready(function () {
    CKEDITOR.replaceClass = 'text-editor'
    CKEDITOR.config.allowedContent = true
    CKEDITOR.dtd.$removeEmpty['span'] = false
    CKEDITOR.dtd.$removeEmpty['i'] = false
  })
</script>

<?php $this->end(); ?>
