<div class="page-content images">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo "Image"; ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'], ['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?php echo "Image"; ?></a>
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
                                <th>Preview</th>
                                <th class="actions" style="width:70px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($images as $image): ?>
                                <tr>
                                    <td><?php echo $this->Number->format($image->id) ?></td>
                                    <td align="center">
                                        <img src="<?php echo $this->request->webroot.$image->path ?>" style="width: auto; max-height: 250px;" />
                                    </td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['action' => 'view', $image->id], ['escape' => false]) ?>
                                        <?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-trash"></span>'), ['action' => 'delete', $image->id], ['escape' => false, 'confirm_delete' => true]) ?>
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
