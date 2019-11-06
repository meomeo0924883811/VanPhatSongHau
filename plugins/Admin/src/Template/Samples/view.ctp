
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">View Sample</h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <?php echo $this->Html->link(__('List Samples'), ['action' => 'index'],['escape' => false]) ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">View Sample</a>
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
                    <div id="table_slides_wrapper" class="dataTables_wrapper no-footer">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <td><?= $this->Number->format($sample->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Title') ?></th>
                                    <td><?= h($sample->title) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Image') ?></th>
                                    <td><?= h($sample->image) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Modified') ?></th>
                                    <td><?= h($sample->modified) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Created') ?></th>
                                    <td><?= h($sample->created) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Active') ?></th>
                                    <td><?= $sample->active ? __('Yes') : __('No'); ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Description') ?></th>
                                    <td><?= $this->Text->autoParagraph(h($sample->description)) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Content') ?></th>
                                    <td><?= $this->Text->autoParagraph(h($sample->content)) ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>