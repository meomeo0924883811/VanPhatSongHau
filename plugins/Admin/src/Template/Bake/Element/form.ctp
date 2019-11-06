<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
%>
<div class="page-content <%= $pluralVar %>">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>')  ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <?php echo $this->Html->link(__('List <%= $pluralHumanName %>'), ['action' => 'index'],['escape' => false]) ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></a>
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

                    <?php echo  $this->Form->create($<%= $singularVar %>, ['class' => 'form-horizontal']); ?>
                    <div class="form-body">
                        <%
                        foreach ($fields as $field) {
                            if (in_array($field, $primaryKey)) {
                                continue;
                            }
                            if (isset($keyFields[$field])) {
                                $fieldData = $schema->column($field);
                                if (!empty($fieldData['null'])) {
                                    %>
                                    <div class="form-group"><?php echo "<?php echo \$this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true,'class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>']);?>"; ?></div>
                                <%
                                } else {
                                    %>
                                    <div class="form-group"><?php echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>,'class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>']); ?></div>
                                <%
                                }
                                continue;
                            }
                            if (!in_array($field, ['created', 'modified', 'updated'])) {
                                $fieldData = $schema->column($field);
                                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
                                    %>
                                    <div class="form-group"><?php echo $this->Form->input('<%= $field %>', ['empty' => true, 'default' => '','class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>']);?>"; ?></div>
                                <%
                                } else {
                                    if (empty($fieldData['null'])) {
                                        %>
                                        <div class="form-group"><?php echo $this->Form->input('<%= $field %>',['class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>']); <% // Required fields %> ?></div>
                                    <%
                                    } else {
                                        if(in_array($field, ['active'])){
                                            %>
                                            <div class="form-group">
                                                <?php echo $this->Form->label('<%= $field %>', '', ['for' => '<%= $field %>', 'class' => 'col-md-3 control-label']); ?>
                                                <div class="col-md-9">
                                                    <?php echo $this->Form->input('<%= $field %>',['class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>']); ?>
                                                </div>
                                            </div>
                                        <%
                                        }
                                        else{
                                            %>
                                            <div class="form-group">
                                                <?php echo $this->Form->label('<%= $field %>', mb_convert_case('<%= $field %>', MB_CASE_TITLE, "UTF-8"), ['for' => '<%= $field %>', 'class' => 'col-md-3 control-label']); ?>
                                                <div class="col-md-9">
                                                    <?php echo $this->Form->input('<%= $field %>',['class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>', 'label' => false]); ?>
                                                </div>
                                            </div>
                                        <%
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($associations['BelongsToMany'])) {
                            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
                                %>
                                <div class="form-group"><?php echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>,'class'=>'form-control','placeholder' => '<%= Inflector::humanize($field) %>'); ?></div>
                            <%
                            }
                        }
                        %>
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
