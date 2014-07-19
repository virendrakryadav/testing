<?php
/* @var $this SkillController */
/* @var $model Skill */

$this->breadcrumbs=array(
	'Skills',
	'Manage',
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i>Manage Skill</div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('skill/create')?>">
<i class="icon-plus"></i>Add New</a></div>
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
$this->widget('GridView', array(
	'id'=>'data-grid',
	'formActions'=>'delete', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'skillDataSession', //sesseion name for current page size dropdown
	'statusField'=>'status', //Filed Name to change status with multi select
         'clildTable'=>'TaskSkill',
//         'statusAandN'=>'statusAandN',

        'actionClassName'=>'Skill',
        'pkName'=>'skill_id',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumnUniform',
			'selectableRows' => 1000,
			'id'=>'autoId',
		),
                array(
                    'type'=> 'raw',
                    'value'=> 'CHtml::hiddenField("language[]", $data["skilllocale"]["language_code"])',
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
			'header'=>'Skill',
			'name'=>'skill_desc',
                        'value'=>'$data["skilllocale"]["skill_desc"]',

		),
                array(
			'header'=>'Category',
			'name'=>'category_id',
                        'value'=>'$data["categorylocale"]["category_name"]',

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
			'header'=> 'Edit',
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> 'Delete',
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
<?php $this->endWidget(); ?>
