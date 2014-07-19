<?php
/* @var $this LanguageController */
/* @var $model Language */

$this->breadcrumbs=array(
	'Languages'=>array('admin'),
	'Manage',
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_language_admin','manage_language_text');?></div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('language/create')?>">
<i class="icon-plus"></i><?php echo Yii::t('admin_language_admin','add_new_text');?></a></div>
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
<?php $this->widget('GridView', array(
	'id'=>'data-grid',
	'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'languageDataSession', //sesseion name for current page size dropdown
	'statusField'=>'language_status', //Filed Name to change status with multi select
        'actionClassName'=>'Language',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumnUniform',
			'selectableRows' => 1000,
			'id'=>'autoId',
		),
                array(
			'header'=>Yii::t('admin_language_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),
		array(
			'header'=> Yii::t('admin_language_admin','language_code_text'),
			'name'=>'language_code',
		),
		array(
			'header'=> Yii::t('admin_language_admin','language_name_text'),
			'name'=>'language_name',
		),
		array(
			'header'=> Yii::t('admin_language_admin','language_priority_text'),
			'name'=>'language_priority',
                        'value'=>'$data->language_priority',
			'headerHtmlOptions'=>array(
                            'class' => 'grid_priority'
                        ),
			'htmlOptions' => array(
                            'class' => 'grid_priority',
			),
		),
		array(
			'name'=>Yii::t('admin_language_admin','status_text'),
			'type'=>'html',
                        'value'=>'UtilityHtml::getStatusImage($data->language_status, "Language", $data->{Globals::FLD_NAME_LANGUAGE_CODE}, "language_status",$data->{Globals::FLD_NAME_LANGUAGE_CODE},"language_code")',
			'htmlOptions' => array(
                            'class' => 'grid_status',
			),
                        'headerHtmlOptions'=>array(
                             'class' => 'grid_status'
                        ),
	    ),
		array(
			'header'=> Yii::t('admin_language_admin','edit_text'),
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> Yii::t('admin_language_admin','delete_text'),
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
<?php $this->endWidget(); ?>