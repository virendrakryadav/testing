<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	Yii::t('admin_city_admin','city_name_text'),
	Yii::t('admin_city_admin','manage_text'),
);


?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_city_admin','manage_cities_text')?></div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('city/create')?>">
<i class="icon-plus"></i><?php echo Yii::t('admin_city_admin','add_new_text')?></a></div>
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

<?php
//print_r($fillFields);
$this->widget('GridView', array(
	'id'=>'data-grid',
	'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'cityDataSession', //sesseion name for current page size dropdown
	'statusField'=>'city_status', //Filed Name to change status with multi select
         'clildTable'=>'User',
     
        'actionClassName'=>'CityLocale',
        'pkName'=>'city_id',
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
			'header'=>Yii::t('admin_city_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),
            array(
			'header'=>Yii::t('admin_city_admin','city_name_text'),
			'name'=>'city_name',
                        'value'=>'$data["citylocale"]["city_name"]',
                    
		),
                array(
			'header'=>Yii::t('admin_city_admin','region_name_text'),
			'name'=>'region_name',
                        'value'=>'$data["regionlocale"]["region_name"]',
                    
		),
		array(
			'header'=>Yii::t('admin_city_admin','state_name_text'),
			'name'=>'state_name',
                        'value'=>'$data["statelocale"]["state_name"]',
                    
		),
		array(
			'header'=>Yii::t('admin_city_admin','country_name_text'),
                        'name'=>'country_name',
			'value'=>'$data["countrylocale"]["country_name"]',
		),
            array(
			'header'=>Yii::t('admin_city_admin','city_priority_text'),
			'name'=>'city_priority',
                        'value'=>'$data["citylocale"]["city_priority"]',
			'headerHtmlOptions'=>array(
                            'class' => 'grid_priority'
                        ),
			'htmlOptions' => array(
                            'class' => 'grid_priority',
			),
		),
		array(
			'name'=>Yii::t('admin_city_admin','status_text'),
			'type'=>'html',
                        'value'=>'UtilityHtml::getStatusImage($data["citylocale"]["city_status"], "CityLocale", $data->city_id, "city_status",$data["citylocale"]["language_code"],"city_id")',
			'htmlOptions' => array(
                            'class' => 'grid_status',
			),
                        'headerHtmlOptions'=>array(
                             'class' => 'grid_status'
                        ),
	    ),
		array(
			'header'=> Yii::t('admin_city_admin','edit_text'),
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> Yii::t('admin_city_admin','delete_text'),
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
<?php $this->endWidget(); ?>