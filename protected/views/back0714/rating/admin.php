<?php
/* @var $this RatingController */
/* @var $model Rating */

$this->breadcrumbs=array(
	Yii::t('admin_rating_admin','rating_text'),
	Yii::t('admin_rating_admin','manage_text'),
);
?>
<div class="portlet box blue">
    <div class="portlet-title">
    <div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_rating_admin','manage_ratings_text')?></div>
        <div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('rating/create')?>">
        <i class="icon-plus"></i><?php echo Yii::t('admin_rating_admin','Add New')?></a>
        </div>
    </div>
</div>

<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
        'fillFields'=>$fillFields,
)); ?>
    
</div>
<?php $form=$this->beginWidget('CActiveForm', 
    array(
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'id'=>'grid-form'
));
?>
<?php $this->widget('GridView', array(
	'id'=>'data-grid',
        'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
        'dataSession'=>'ratingDataSession', //sesseion name for current page size dropdown
        'statusAandN'=>'statusAandN',
        'statusField'=>'status',
	'actionClassName'=>'RatingLocale',
        'pkName'=>'rating_id',
        //'ajaxUpdate'=>true,
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
                        'value'=> 'CHtml::hiddenField("language[]", $data["ratinglocale"]["language_code"])', 
                        'htmlOptions'=>array('style'=>'width:0%; display:none'),
                        'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                ),
                array(
                        'header'=>Yii::t('admin_rating_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                                                'class' => 'grid_srno'
                                                ),
                ),
                array(
			'header'=>Yii::t('admin_rating_admin','rating_for_text'),
			'name'=>'rating_for',
                        'value'=>'UtilityHtml::getRatingFor($data->rating_for ,"rating", $data->rating_id, "rating_for"  , "" , "rating_id")',
		),
                array(
                        'header'=>Yii::t('admin_rating_admin','rating_desc_text'),
                        'name'=>'rating_desc',
                        'value'=>'$data["ratinglocale"]["rating_desc"]',
                ),
                array(
			'header'=>Yii::t('admin_rating_admin','rating_priority_text'),
			'name'=>'rating_priority',
                        'value'=>'$data["ratinglocale"]["rating_priority"]',
			'headerHtmlOptions'=>array(
                            'class' => 'grid_priority'
                        ),
			'htmlOptions' => array(
                            'class' => 'grid_priority',
			),
		),
                array(
                            'name'=>Yii::t('admin_rating_admin','status_text'),
                            'type'=>'html',
                            'value'=>'UtilityHtml::getStatusImageForAandN($data["ratinglocale"]["status"], "RatingLocale", $data->rating_id, "status", $data["ratinglocale"]["language_code"], "rating_id")',
                            'htmlOptions' => array(
                                'class' => 'grid_status',
                            ),
                            'headerHtmlOptions'=>array(
                                'class' => 'grid_status'
                            ),
                ),
                array(
                            'header'=> Yii::t('admin_rating_admin','edit_text'),
                            'class'=>'CButtonColumn',
                            'template'=>'{update}',
                ),
                array(
                            'header'=> Yii::t('admin_rating_admin','delete_text'),
                            'class'=>'CButtonColumn',
                            'template'=>'{delete}',
                            'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
                ),
         ),
)); ?>
<?php $this->endWidget(); ?>