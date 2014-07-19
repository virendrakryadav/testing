<?php
/* @var $this RegionController */
/* @var $model Region */

$this->breadcrumbs=array(
	'Region',
	'Manage',
);


?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_region_admin','manage_region_text'); ?></div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('region/create')?>">
<i class="icon-plus"></i><?php echo Yii::t('admin_region_admin','add_new_text'); ?></a></div>
</div></div>


<div class="search-form" >
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
	'dataSession'=>'regionDataSession', //sesseion name for current page size dropdown
	'statusField'=>'region_status', //Filed Name to change status with multi select
        'clildTable'=>'CityLocale',
        'actionClassName'=>'RegionLocale',
        'pkName'=>'region_id',
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
                    'value'=> 'CHtml::hiddenField("language[]", $data["regionlocale"]["language_code"])', 
                    'htmlOptions'=>array('style'=>'width:0%; display:none'),
                    'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                ),
		array(
			'header'=>Yii::t('admin_region_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),
            array(
			'header'=>Yii::t('admin_region_admin','region_name_text'),
			'name'=>'region_name',
                        'value'=>'$data["regionlocale"]["region_name"]',
                    
		),
		array(
			'header'=>Yii::t('admin_region_admin','state_name_text'),
			'name'=>'state_name',
                        'value'=>'$data["statelocale"]["state_name"]',
                    
		),
		array(
			'header'=>Yii::t('admin_region_admin','country_name_text'),
                        'name'=>'country_name',
			'value'=>'$data["countrylocale"]["country_name"]',
		),
            array(
			'header'=>Yii::t('admin_region_admin','region_priority_text'),
			'name'=>'region_priority',
                        'value'=>'$data["regionlocale"]["region_priority"]',
			'headerHtmlOptions'=>array(
                            'class' => 'grid_priority'
                        ),
			'htmlOptions' => array(
                            'class' => 'grid_priority',
			),
		),
		array(
			'name'=>Yii::t('admin_region_admin','status_text'),
			'type'=>'html',
			'value'=>'UtilityHtml::getStatusImage($data["regionlocale"]["region_status"], "RegionLocale", $data->{Globals::FLD_NAME_REGION_ID}, "region_status",$data["regionlocale"]["language_code"],"region_id")',
			'htmlOptions' => array(
                            'class' => 'grid_status',
			),
                        'headerHtmlOptions'=>array(
                             'class' => 'grid_status'
                        ),
	    ),
		array(
			'header'=>Yii::t('admin_region_admin','edit_text'),
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=>Yii::t('admin_region_admin','delete_text'),
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
<?php $this->endWidget(); ?>