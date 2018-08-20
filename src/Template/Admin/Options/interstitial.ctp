<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Interstitial Advertisement Price'));
$this->assign('description', '');
$this->assign('content_title', __('Interstitial Advertisement Price'));
?>

<?php
$traffic_source = [
    '1' => __('Desktop, Mobile and Tablet'),
    '2' => __('Desktop Only'),
    '3' => __('Mobile / Tablet Only')
];
?>

<div class="box box-primary">
    <div class="box-body">

        <?php if (isset($this->request->query['source']) &&
            in_array($this->request->query['source'], [1, 2, 3])
        ) : ?>

            <?php
            $source = $this->request->query['source'];
            ?>

            <legend><?= __("Set Prices For {0}", $traffic_source[$source]) ?></legend>

            <?= $this->Form->create($option); ?>

            <?= $this->Form->hidden('id'); ?>

            <?php $i = 1; ?>

            <div class="row">
                <?php foreach (get_countries(true) as $key => $value) : ?>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4"><?= $value ?></div>
                            <div class="col-sm-4">
                                <?=
                                $this->Form->input('value[' . $key . '][' . $source . '][advertiser]', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'type' => 'text',
                                    'placeholder' => 'Advertiser Price',
                                    'value' => $option->value[$key][$source]['advertiser']
                                ]);

                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?=
                                $this->Form->input('value[' . $key . '][' . $source . '][publisher]', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'type' => 'text',
                                    'placeholder' => 'Publisher Price',
                                    'value' => $option->value[$key][$source]['publisher']
                                ]);

                                ?>
                            </div>
                        </div>
                    </div>
                    <?= (0 == $i % 2) ? '</div><div class="row">' : ''; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>

            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']); ?>

            <?= $this->Form->end(); ?>

        <?php else : ?>

            <?= $this->Form->create(null, ['type' => 'get']); ?>

            <?=
            $this->Form->input('source', [
                'label' => __('Set Price For'),
                'options' => $traffic_source,
                'empty' => __('Choose'),
                'class' => 'form-control'
            ]);
            ?>

            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg']); ?>

            <?= $this->Form->end(); ?>

        <?php endif; ?>

    </div><!-- /.box-body -->
</div>
