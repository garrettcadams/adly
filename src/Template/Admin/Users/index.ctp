<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php
$this->assign('title', __('Manage Users'));
$this->assign('description', '');
$this->assign('content_title', __('Manage Users'));
?>

<?php

$yes_no = [
    1 => __('Yes'),
    0 => __('No')
];

$statuses = [
    1 => __('Active'),
    2 => __('Pending'),
    3 => __('Inactive')
]

?>

<div class="box box-solid">
    <div class="box-body">
        <?php
        // The base url is the url where we'll pass the filter parameters
        $base_url = ['controller' => 'Users', 'action' => 'index'];

        echo $this->Form->create(null, [
            'url' => $base_url,
            'class' => 'form-inline'
        ]);
        ?>

        <?=
        $this->Form->input('Filter.id', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Id')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.status', [
            'label' => false,
            'options' => $statuses,
            'empty' => __('Status'),
            'class' => 'form-control'
        ]);
        ?>

        <?=
        $this->Form->input('Filter.disable_earnings', [
            'label' => false,
            'options' => $yes_no,
            'empty' => __('Disable Earnings'),
            'class' => 'form-control'
        ]);
        ?>

        <?=
        $this->Form->input('Filter.username', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Username')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.email', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Email')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.country', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Country')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.login_ip', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Login IP')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.register_ip', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('Register IP')
        ]);
        ?>

        <?=
        $this->Form->input('Filter.other_fields', [
            'label' => false,
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => __('First name, last name, address')
        ]);
        ?>

        <?= $this->Form->button(__('Filter'), ['class' => 'btn btn-default btn-sm']); ?>

        <?= $this->Html->link(__('Reset'), $base_url, ['class' => 'btn btn-link btn-sm']); ?>

        <?= $this->Form->end(); ?>

    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-align-center"></i> <?= __('All Users') ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding table-responsive">

        <table class="table table-hover table-striped">
            <tr>
                <th><?= $this->Paginator->sort('id', __('Id')); ?></th>
                <th><?= $this->Paginator->sort('username', __('Username')); ?></th>
                <th><?= $this->Paginator->sort('status', __('Status')); ?></th>
                <th><?= $this->Paginator->sort('disable_earnings', __('Disable Earnings')); ?></th>
                <th><?= $this->Paginator->sort('email', __('Email')); ?></th>
                <th><?= $this->Paginator->sort('login_ip', __('Login IP')); ?></th>
                <th><?= $this->Paginator->sort('register_ip', __('Register IP')); ?></th>
                <th><?= $this->Paginator->sort('modified', __('modified')); ?></th>
                <th><?= $this->Paginator->sort('created', __('Created')); ?></th>
                <th><?php echo __('Actions') ?></th>
            </tr>

            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php
            /**
             * @var \Cake\ORM\ResultSet $users
             * @var \App\Model\Entity\User $user
             */
            ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td>
                        <?= $this->Html->link($user->username,
                            ['controller' => 'users', 'action' => 'view', $user->id, 'prefix' => 'admin']);
                        ?>
                    </td>
                    <td><?= $statuses[$user->status]; ?></td>
                    <td><?= $yes_no[$user->disable_earnings]; ?></td>
                    <td><?= $user->email; ?></td>
                    <td><?= $user->login_ip; ?></td>
                    <td><?= $user->register_ip; ?></td>
                    <td><?= display_date_timezone($user->modified); ?></td>
                    <td><?= display_date_timezone($user->created); ?></td>
                    <td>
                        <?= $this->Html->link(__('Message'), ['action' => 'message', $user->id],
                            ['class' => 'btn btn-default btn-xs']); ?>

                        <?php if ($user->status === 2) : ?>
                            <?= $this->Form->postLink(__('Resend Activation Email'),
                                ['action' => 'resendActivation', $user->id],
                                ['confirm' => __('Are you sure?'), 'class' => 'btn btn-info btn-xs']);
                            ?>
                        <?php endif; ?>

                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id],
                            ['class' => 'btn btn-primary btn-xs']); ?>

                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id],
                            ['class' => 'btn btn-info btn-xs']); ?>

                        <?php if ($user->status === 1) : ?>
                            <?= $this->Form->postLink(
                                __('Deactivate'),
                                ['action' => 'deactivate', $user->id],
                                ['confirm' => __('Are you sure?'), 'class' => 'btn btn-danger btn-xs']
                            );
                            ?>
                        <?php endif; ?>

                        <?= $this->Form->postLink(
                            __('Export'),
                            ['action' => 'dataExport', $user->id],
                            ['confirm' => __('Are you sure?'), 'class' => 'btn btn-primary btn-xs']
                        );
                        ?>

                        <?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id],
                            ['class' => 'btn btn-danger btn-xs']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php unset($user); ?>
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
