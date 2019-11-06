
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">View User</h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <?php echo $this->Html->link(__('List Users'), ['action' => 'index'],['escape' => false]) ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">View User</a>
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
                                        <td><?= $this->Number->format($user->id) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Firstname') ?></th>
                                        <td><?= h($user->firstname) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Lastname') ?></th>
                                        <td><?= h($user->lastname) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Email') ?></th>
                                        <td><?= h($user->email) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Role') ?></th>
                                        <td><?= h($user->role) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Username') ?></th>
                                        <td><?= h($user->username) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Last Login') ?></th>
                                        <td><?= h($user->last_login) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Created') ?></th>
                                        <td><?= h($user->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Modified') ?></th>
                                        <td><?= h($user->modified) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Is Active') ?></th>
                                        <td><?= $user->is_active ? __('Yes') : __('No'); ?></td>
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