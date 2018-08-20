<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Manage Posts'));
$this->assign('description', '');
$this->assign('content_title', __('Manage Posts'));
?>

<div class="box box-primary">
    <div class="box-body no-padding table-responsive">

        <table class="table table-hover table-striped">
            <tr>
                <th><?= $this->Paginator->sort('id', __('Id')); ?></th>
                <th><?= $this->Paginator->sort('title', __('Title')); ?></th>
                <th><?= $this->Paginator->sort('slug', __('Slug')); ?></th>
                <th><?= $this->Paginator->sort('published', __('Published')); ?></th>
                <th><?= $this->Paginator->sort('modified', __('modified')); ?></th>
                <th><?= $this->Paginator->sort('created', __('Created')); ?></th>
                <th><?php echo __('Actions') ?></th>
            </tr>

            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= $post->id ?></td>
                    <td>
                        <?= $this->Html->link($post->title, [
                            'action' => 'edit',
                            $post->id,
                            '?' => ['lang' => get_option('language', 'en_US')]
                        ]); ?> <?= $this->Html->link(get_option('language', 'en_US'),
                            ['action' => 'edit', $post->id, '?' => ['lang' => get_option('language', 'en_US')]],
                            ['class' => 'label label-primary']); ?><br>
                        <p>
                            <?php foreach (get_site_languages() as $lang) : ?>
                                <?= $this->Html->link($lang, ['action' => 'edit', $post->id, '?' => ['lang' => $lang]],
                                    ['class' => 'label label-default']); ?>
                            <?php endforeach; ?>
                        </p>
                    </td>
                    <td><?= $post->slug ?></td>
                    <td><?= ($post->published) ? __('Yes') : __('No') ?></td>
                    <td><?= display_date_timezone($post->modified) ?></td>
                    <td><?= display_date_timezone($post->created) ?></td>
                    <td>
                        <?= $this->Html->link(__('View'),
                            ['action' => 'view', 'id' => $post->id, 'slug' => $post->slug, 'prefix' => false],
                            ['class' => 'btn btn-primary btn-xs', 'target' => '_blank']); ?>

                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $post->id],
                            ['confirm' => __('Are you sure?'), 'class' => 'btn btn-danger btn-xs']);

                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php unset($post); ?>
        </table>

    </div><!-- /.box-body -->
</div>

<ul class="pagination">
    <!-- Shows the previous link -->
    <?php
    if ($this->Paginator->hasPrev()) {
        echo $this->Paginator->prev('«', array('tag' => 'li'), null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    }

    ?>
    <!-- Shows the page numbers -->
    <?php //echo $this->Paginator->numbers();    ?>
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
        echo $this->Paginator->next('»', array('tag' => 'li'), null,
            array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    }

    ?>
</ul>
