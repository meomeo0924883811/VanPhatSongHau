<div class="page-content tests">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo __('Add Home')  ?>
    </h3>
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
                <a href="#"><?= __('Edit User') ?></a>
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
                <div class="portlet-body form">

                   <?php echo  $this->Form->create($user, ['class' => 'form-horizontal']); ?>
                       <div class="form-body">
                           <div class="form-group">
                               <?php echo $this->Form->label('firstname', mb_convert_case('firstname', MB_CASE_TITLE, "UTF-8"), ['for' => 'firstname', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('firstname',['class'=>'form-control','placeholder' => 'Firstname', 'label' => false]); ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <?php echo $this->Form->label('lastname', mb_convert_case('lastname', MB_CASE_TITLE, "UTF-8"), ['for' => 'lastname', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('lastname',['class'=>'form-control','placeholder' => 'Lastname', 'label' => false]); ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <?php echo $this->Form->label('email', mb_convert_case('email', MB_CASE_TITLE, "UTF-8"), ['for' => 'email', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('email',['class'=>'form-control','placeholder' => 'Email', 'label' => false]); ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <?php echo $this->Form->label('role', mb_convert_case('role', MB_CASE_TITLE, "UTF-8"), ['for' => 'password', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->select('role', array('admin' => 'Admin', 'editor' => 'Editor', 'user' => 'User'), array('class' => 'form-control', 'required' => 'true'));?>
                               </div>
                           </div>

                           <div class="form-group">
                               <?php echo $this->Form->label('is_active', '', ['for' => 'is_active', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('is_active',['class'=>'form-control','placeholder' => 'Active']); ?>
                               </div>
                           </div>
                       </div>
                       <div class="form-actions">
                           <div class="row">
                               <div class="col-md-offset-3 col-md-9">
                                   <?php echo $this->Form->button(__('Submit'), ['class' => 'btn green']) ?>
                                   <?php echo $this->Html->link(__('Cancel'), ['action' => 'index'],['escape' => false, 'class' => 'btn default']) ?>
                               </div>
                           </div>
                       </div>
                       <?php echo $this->Form->end() ?>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
