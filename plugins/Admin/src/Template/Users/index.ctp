<div class="page-content tests">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo "Users"; ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?php echo "Users"; ?></a>
            </li>
        </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Flash->render(); ?>
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i><?php echo __('Managed Table') ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add New <i class="fa fa-plus"></i>'), ['action' => 'add'],['escape' => false, 'class' => 'btn green']); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="">Export</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover" id="table_slides">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('firstname') ?></th>
                                <th><?= $this->Paginator->sort('lastname') ?></th>
                                <th><?= $this->Paginator->sort('email') ?></th>
                                <th><?= $this->Paginator->sort('is_active') ?></th>
                                <th><?= $this->Paginator->sort('role') ?></th>
                                <th width="90" class="actions"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $this->Number->format($user->id) ?></td>
                                    <td><?= h($user->firstname) ?></td>
                                    <td><?= h($user->lastname) ?></td>
                                    <td><?= h($user->email) ?></td>
                                    <td><?= h( ($user->is_active) == 1 ? "Yes" : "No" ) ?></td>
                                    <td><?= h($user->role) ?></td>
                                    <td class="actions">
                                        <?php
                                        if($user['id'] == $current_user['id'])
                                        {
                                            echo $this->Html->link('<span title="Change password" class="glyphicon glyphicon-pencil"></span>', ['action' => 'change_password'], ['escape' => false]);
                                        }
                                        ?>
                                        <?= $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['action' => 'view', $user->id],['escape' => false]) ?>
                                        <?= $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), ['action' => 'edit', $user->id],['escape' => false]) ?>
                                        <?php if ($user->role != 'admin') : ?> <?php $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), ['action' => 'delete', $user->id], ['escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?><?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                    </table>
                    </div>
                    <p>
                        <small><?= $this->Paginator->counter() ?></small>
                    </p>

                    <?php
                    $params = $this->Paginator->params();
                    if($params['pageCount'] > 1):
                        ?>
                        <ul class="pagination pagination-sm">
                            <?php
                            echo $this->Paginator->prev(__('Previous'));
                            echo $this->Paginator->numbers();
                            echo $this->Paginator->next(__('Next'));
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
