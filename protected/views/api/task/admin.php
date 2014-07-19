<?php
/* @var $this SkillController */
/* @var $model Skill */

$this->breadcrumbs=array(
	'Task',
	'Manage',
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i>Manage Task</div>
</div></div>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
     'fillFields'=>$fillFields,
)); ?>
</div><!-- search-form -->
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'id'=>'grid-form'
)); ?>



<?php

//print_r($fillFields);
$this->widget('GridView', array(
	'id'=>'data-grid',
	'formActions'=>'', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'taskDataSession', //sesseion name for current page size dropdown
//	'statusField'=>'status', //Filed Name to change status with multi select
//         'clildTable'=>'User',
//         'statusAandN'=>'statusAandN',

        'actionClassName'=>'Task',
        'pkName'=>'task_id',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
//		array(
//			'class'=>'CCheckBoxColumnUniform',
//			'selectableRows' => 1000,
//			'id'=>'autoId',
//		),
                array(
                    'type'=> 'raw',
                    'value'=> 'CHtml::hiddenField("language[]", $data["language_code"])',
//                    'value'=> '',
                    'htmlOptions'=>array('style'=>'width:0%; display:none'),
                    'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                ),
		array(
			'header'=>'S.No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),               
                array(
			'header'=>'Task',
			'name'=>'title',                        
                        'value'=>'$data["title"]',
		),
                array(
			'header'=>'Description',
			'name'=>'description',
                        'value'=>'UtilityHtml::setStrlength($data["description"],30)',

		),
                array(
			'header'=>'Creator',
			'name'=>'creator_user_id',
                        'value'=>'UtilityHtml::getUserName($data["creator_user_id"])',

		),
                array(
			'header'=>'State',
			'name'=>'state',
                        'value'=>'UtilityHtml::getTaskStatus($data["state"])',

		),
                array(
			'header'=>'Payment',
			'name'=>'payment_mode',
                        'value'=>'UtilityHtml::getPaymentMode($data["payment_mode"])',

		),
                array(
			'header'=>'Visibility',
			'name'=>'is_public',
                        'value'=>'UtilityHtml::getPublicMode($data["is_public"])',

		),
//		array(
//			'name'=>'Status',
//			'type'=>'html',
////                        'value'=>'UtilityHtml::getStatusImageForAandN($data["categoryquestionlocale"]["status"], "CategoryQuestionLocale", $data->question_id, "status",$data["categoryquestionlocale"]["language_code"],"question_id")',
//			'htmlOptions' => array(
//                            'class' => 'grid_status',
//			),
//                        'headerHtmlOptions'=>array(
//                             'class' => 'grid_status'
//                        ),
//                ),
		array(
			'header'=> 'view',
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
//		array(
//			'header'=> 'Delete',
//			'class'=>'CButtonColumn',
//			'template'=>'{delete}',
//			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
//		),
	),
)); ?>
<?php $this->endWidget(); ?>
