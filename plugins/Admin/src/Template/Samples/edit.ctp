<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sample
 */
?>
<div class="page-content samples">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo __('Edit Sample')  ?>
    </h3>
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
                <a href="#"><?= __('Edit Sample') ?></a>
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

                    <?php echo  $this->Form->create($sample, ['class' => 'form-horizontal']); ?>
                    <div class="form-body">
                        <div class="form-group">
                            <?php echo $this->Form->label('title', mb_convert_case('title', MB_CASE_TITLE, "UTF-8"), ['for' => 'title', 'class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('title',['class'=>'form-control','placeholder' => 'Title', 'label' => false]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->label('description', mb_convert_case('description', MB_CASE_TITLE, "UTF-8"), ['for' => 'description', 'class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('description',['class'=>'form-control','placeholder' => 'Description', 'label' => false]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->label('content', mb_convert_case('content', MB_CASE_TITLE, "UTF-8"), ['for' => 'content', 'class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('content',['class'=>'form-control tinymce','placeholder' => 'Content', 'label' => false]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->label('image', mb_convert_case('image', MB_CASE_TITLE, "UTF-8"), ['for' => 'image', 'class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?php echo $this->JqueryUpload->upload('image', 'Upload image', $sample->image) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->label('active', '', ['for' => 'active', 'class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('active',['class'=>'form-control','placeholder' => 'Active']); ?>
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
