<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?= $message; ?>
<?php if (empty($message)) : ?>
    <?=
    $this->Form->create(null, [
        'style' => 'display: none;',
        'id' => 'quick-link'
    ]);
    ?>
    <?=
    $this->Form->input('api', [
        'label' => false,
        'type' => 'text',
        'required' => 'required'
    ]);
    ?>
    <?=
    $this->Form->input('url', [
        'label' => false,
        'type' => 'text',
        'required' => 'required'
    ]);
    ?>
    <?= $this->Form->button(__("Submit")); ?>
    <?= $this->Form->end(); ?>
    <script>
      var current_url = window.location.href
      var api = current_url.split('?api=').slice(1).join('?api=').split('&url=')[0]
      var url = current_url.split('&url=').slice(1).join('&url=')
      if (api && url) {
        document.getElementById('api').value = api
        document.getElementById('url').value = url
        document.getElementById('quick-link').submit()
      }
    </script>
<?php endif; ?>

</body>
</html>
