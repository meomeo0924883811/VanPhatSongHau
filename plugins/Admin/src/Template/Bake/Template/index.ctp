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
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);
%>
<div class="page-content <%= $pluralVar %>">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        <?php echo "<%= $singularHumanName %>"; ?>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <?php echo $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index'],['escape' => false]); ?>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#"><?php echo "<%= $singularHumanName %>"; ?></a>
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
                            <% foreach ($fields as $field): %>
                                <th><?php echo $this->Paginator->sort('<%= $field %>') ?></th>
                            <% endforeach; %>
                            <th class="actions" style="width:70px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                        <tr>
                            <%  foreach ($fields as $field) {
                                $isKey = false;
                                if (!empty($associations['BelongsTo'])) {
                                    foreach ($associations['BelongsTo'] as $alias => $details) {
                                        if ($field === $details['foreignKey']) {
                                            $isKey = true;
                                            %>
                                            <td><?php echo $<%= $singularVar %>-><%= $details['primaryKey'][0] %> ?></td>
                                            <%
                                            break;
                                        }
                                    }
                                }
                                if ($isKey !== true) {
                                    if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
                                        %>
                                        <td><?php echo h($<%= $singularVar %>-><%= $field %>) ?></td>
                                    <%
                                    } else {
                                        %>
                                        <td><?php echo $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                                    <%
                                    }
                                }
                            }
                            $pk = '$' . $singularVar . '->' . $primaryKey[0];
                            %>
                            <td class="actions">
                                <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), ['action' => 'view', <%= $pk %>],['escape' => false]) ?>
                                <?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), ['action' => 'edit', <%= $pk %>],['escape' => false]) ?>
                                <?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-trash"></span>'), ['action' => 'delete', <%= $pk %>], ['escape' => false,'confirm_delete' => true]) ?>
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
