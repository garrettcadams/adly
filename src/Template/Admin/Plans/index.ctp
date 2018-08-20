<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Plan[]|\Cake\Collection\CollectionInterface $plans
 */
$this->assign('title', __('Manage Plans'));
$this->assign('description', '');
$this->assign('content_title', __('Manage Plans'));
?>

<div class="box box-primary">
    <div class="box-body no-padding table-responsive">

        <table class="table table-hover table-striped">
            <tr>
                <th><?= $this->Paginator->sort('id', __('Id')); ?></th>
                <th><?= $this->Paginator->sort('title', __('Title')); ?></th>
                <th><?= $this->Paginator->sort('published', __('Published')); ?></th>
                <th><?= $this->Paginator->sort('modified', __('Modified')); ?></th>
                <th><?= $this->Paginator->sort('created', __('Created')); ?></th>
                <th><?php echo __('Actions') ?></th>
            </tr>

            <?php foreach ($plans as $plan) : ?>
                <tr>
                    <td><?= $plan->id ?></td>
                    <td>
                        <?= $this->Html->link($plan->title, ['action' => 'edit', $plan->id]); ?> <?= $this->Html->link(
                            get_option('language', 'en_US'),
                            ['action' => 'edit', $plan->id, '?' => ['lang' => get_option('language', 'en_US')]],
                            ['class' => 'label label-primary']
                        ); ?><br>
                        <p>
                            <?php foreach (get_site_languages() as $lang) : ?>
                                <?= $this->Html->link(
                                    $lang,
                                    ['action' => 'edit', $plan->id, '?' => ['lang' => $lang]],
                                    ['class' => 'label label-default']
                                ); ?>
                            <?php endforeach; ?>
                        </p>
                        <?php if ($plan->hidden) : ?>
                            <span class="label label-default"><?= __('Hidden') ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= ($plan->enable) ? __('Yes') : __('No') ?></td>
                    <td><?= display_date_timezone($plan->modified) ?></td>
                    <td><?= display_date_timezone($plan->created) ?></td>
                    <td>
                        <?= $this->Html->link(
                            __('Edit'),
                            ['action' => 'edit', $plan->id],
                            ['class' => 'btn btn-primary btn-xs']
                        ); ?>

                        <?= $this->Html->link(
                            __('Delete'),
                            ['action' => 'delete', $plan->id],
                            ['class' => 'btn btn-danger btn-xs']
                        );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php unset($plan); ?>
        </table>

    </div><!-- /.box-body -->
</div>

<ul class="pagination">
    <!-- Shows the previous link -->
    <?php
    if ($this->Paginator->hasPrev()) {
        echo $this->Paginator->prev(
            '«',
            array('tag' => 'li'),
            null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')
        );
    }
    ?>

    <!-- Shows the page numbers -->
    <?php //echo $this->Paginator->numbers();?>

    <?php
    echo $this->Paginator->numbers(array(
        'modulus' => 4,
        'separator' => '',
        'ellipsis' => '<li><a>...</a></li>',
        'tag' => 'li',
        'currentTag' => 'a',
        'first' => 2,
        'last' => 2
    ));
    ?>

    <!-- Shows the next link -->
    <?php
    if ($this->Paginator->hasNext()) {
        echo $this->Paginator->next(
            '»',
            array('tag' => 'li'),
            null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')
        );
    }
    ?>
</ul>
