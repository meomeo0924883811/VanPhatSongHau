<div class="page-content news">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo "News"; ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'], ['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?php echo "News"; ?></a>
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
                                    <?php echo $this->Html->link(__('Add New <i class="fa fa-plus"></i>'), ['action' => 'add'], ['escape' => false, 'class' => 'btn green']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover" id="table_slides">
                            <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('id') ?></th>
                                <th><?php echo $this->Paginator->sort('title') ?></th>
                                <th><?php echo $this->Paginator->sort('thumbnail') ?></th>
                                <th><?php echo $this->Paginator->sort('appear') ?></th>
                                <th class="actions" style="width:70px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($news as $news): ?>
                                <tr>
                                    <td><?php echo $this->Number->format($news->id) ?></td>
                                    <td><h1><?php echo $news->title ?></h1></td>
                                    <td><img style="width: auto; max-height: 200px;" src="<?php echo h($this->request->webroot.$news->thumbnail) ?>"/></td>
                                    <td><?php echo $boolean_status[$news->appear] ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['action' => 'view', $news->id], ['escape' => false]) ?>
                                        <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), ['action' => 'edit', $news->id], ['escape' => false]) ?>
                                        <?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-trash"></span>'), ['action' => 'delete', $news->id], ['escape' => false, 'confirm_delete' => true]) ?>
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
                    if ($params['pageCount'] > 1):
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
