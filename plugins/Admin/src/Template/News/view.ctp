
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">View News</h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <?php echo $this->Html->link(__('List News'), ['action' => 'index'],['escape' => false]) ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">View News</a>
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
                                            <td><?= $this->Number->format($news->id) ?></td>
                                        </tr>
                                                                                                                                                                                                                                                <tr>
                                            <th><?= __('Appear') ?></th>
                                            <td><?= $news->appear ? __('Yes') : __('No'); ?></td>
                                        </tr>
                                                                                                                                                                                <tr>
                                            <th><?= __('Title') ?></th>
                                            <td><?= $this->Text->autoParagraph(h($news->title)) ?></td>
                                        </tr>
                                                                            <tr>
                                            <th><?= __('Thumbnail') ?></th>
                                            <td><?= $this->Text->autoParagraph(h($news->thumbnail)) ?></td>
                                        </tr>
                                                                            <tr>
                                            <th><?= __('Content') ?></th>
                                            <td><?= $this->Text->autoParagraph(h($news->content)) ?></td>
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