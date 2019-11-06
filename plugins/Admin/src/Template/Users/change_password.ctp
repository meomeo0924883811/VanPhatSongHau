<script>
    jQuery(document).ready(function() {
        jQuery('#new-password').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            //strengthButtonClass: 'button_strength',
            strengthButtonText: '',
            //strengthButtonTextToggle: 'Hide Password'
        });
    });
</script>
<div class="page-content tests">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo __('Change Password')  ?>
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
                <a href="#"><?= __('Change Password') ?></a>
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

                   <?php echo  $this->Form->create('', ['class' => 'form-horizontal']); ?>
                       <div class="form-body">
                           <div class="form-group">
                               <?php echo $this->Form->label('password', mb_convert_case('password', MB_CASE_TITLE, "UTF-8"), ['for' => 'password', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('password',['class'=>'form-control','placeholder' => 'Password', 'label' => false]); ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <?php echo $this->Form->label('new_password', mb_convert_case('new password', MB_CASE_TITLE, "UTF-8"), ['for' => 'new_password', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9 edit-password">
                                   <?php echo $this->Form->input('new_password',['type' => 'password', 'class'=>'form-control','placeholder' => 'New password', 'label' => false, 'class' => 'form-control strength']); ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <?php echo $this->Form->label('reenter_new_password', mb_convert_case('reenter new password', MB_CASE_TITLE, "UTF-8"), ['for' => 'reenter_new_password', 'class' => 'col-md-3 control-label']); ?>
                               <div class="col-md-9">
                                   <?php echo $this->Form->input('reenter_new_password',['type' => 'password', 'class'=>'form-control','placeholder' => 'Reenter new password', 'label' => false]); ?>
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
