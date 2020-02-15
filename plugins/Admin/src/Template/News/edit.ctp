<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $news
 */
?>
<div class="page-content news">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo __('Edit News') ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'], ['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <?php echo $this->Html->link(__('List News'), ['action' => 'index'], ['escape' => false]) ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?= __('Edit News') ?></a>
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

                    <?php echo $this->Form->create($news, ['class' => 'form-horizontal']); ?>
                    <div class="form-body">
                        <div
                            ><?php echo $this->Form->input('title', ['class' => 'form-control', 'placeholder' => 'Title']); ?></div>
                        <div id="group-image">
                            <label for="image">Thumbnail</label>
                            <?php echo $this->JqueryUpload->upload('thumbnail', 'upload'); ?>
                        </div>
                        <div
                            ><?php echo $this->Form->input('content', ['class' => 'form-control', 'placeholder' => 'Content']); ?></div>
                        <div
                            ><?php echo $this->Form->input('appear', ['class' => 'form-control', 'placeholder' => 'Appear']); ?></div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <?php echo $this->Form->button(__('Submit'), ['class' => 'btn green']) ?>
                                <?php echo $this->Html->link(__('Cancel'), ['action' => 'index'], ['escape' => false, 'class' => 'btn default']) ?>
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
<script>
    $(document).ready(function () {

        tinymce.init({
            selector: "#content",
            paste_data_images: true,
            paste_as_text: true,
            height: "500",
            menubar: false,
            plugins: [
                "advlist lists link image media code",
                "paste textcolor colorpicker"
            ],
            toolbar1: "undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ",
            toolbar2: "| responsivefilemanager | link unlink | image | code",
            block_formats: 'Header2=h2;Header3=h3;Header=h4;Paragraph=p;',
            image_advtab: true,
            external_filemanager_path: window_app.webroot_full + "plugins/ResponsiveFilemanager/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : window_app.webroot_full + "plugins/ResponsiveFilemanager/filemanager/plugin.min.js"}
        });
    });
</script>
