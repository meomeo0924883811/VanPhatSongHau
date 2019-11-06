<div class="page-content samples">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo "Sample"; ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?php echo "Sample"; ?></a>
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
                            <th><?php echo $this->Paginator->sort('id') ?></th>
                            <th><?php echo $this->Paginator->sort('title') ?></th>
                            <th><?php echo $this->Paginator->sort('image') ?></th>
                            <th><?php echo $this->Paginator->sort('active') ?></th>
                            <th><?php echo $this->Paginator->sort('modified') ?></th>
                            <th><?php echo $this->Paginator->sort('created') ?></th>
                            <th class="actions" style="width:70px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($samples as $sample): ?>
                            <tr>
                                <td><?php echo $this->Number->format($sample->id) ?></td>
                                <td><?php echo h($sample->title) ?></td>
                                <td class="ct_center"><?php echo $this->General->facyboxImage($sample->image) ?></td>
                                <td class="ct_center"><?php echo $sample->active == 1 ? '<a class="change_status" field="active" id="'.$sample->id.'" href=""><i class="icon-check"></i></a>' : '<a class="change_status" field="active" id="'.$sample->id.'" href=""><i class="icon-ban"></i></a>' ?></td>
                                <td><?php echo h($sample->modified) ?></td>
                                <td><?php echo h($sample->created) ?></td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['action' => 'view', $sample->id],['escape' => false]) ?>
                                    <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), ['action' => 'edit', $sample->id],['escape' => false]) ?>
                                    <?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-trash"></span>'), ['action' => 'delete', $sample->id], ['escape' => false,'confirm_delete' => true]) ?>
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

<script>
    $(document).ready(function(){
        $(document).on('click','.change_status',function(){
            var id = $(this).attr('id');
            var field = $(this).attr('field');
            console.log(field);
            var csrfToken = $('input[name=_csrfToken]').val();
            var $this = $(this);
            $.ajax({
                url:'<?php echo $this->Url->build(array('controller' => 'Samples', 'action' => 'change_status')) ?>',
                type:'post',
                data:{id:id, field:field},
                beforeSend: function(xhr){
                    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                },
                success:function(response){
                    if(response.status == 1){
                        var status = response.data.status;
                        if(status == 1){
                            $this.find('i').removeClass('icon-check').removeClass('icon-ban');
                            $this.find('i').addClass('icon-check');
                        }
                        else{
                            $this.find('i').removeClass('icon-check').removeClass('icon-ban');
                            $this.find('i').addClass('icon-ban');
                        }
                    }
                    else{
                        alert(response.status);
                    }
                },
                error: function (data) {
                    alert('ajax failed');
                }
            });
            return false;
        });
    });
</script>
