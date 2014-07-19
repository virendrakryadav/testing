<?php
$this->breadcrumbs=array(
	Yii::t('admin_category_admin','category_text'),
	Yii::t('admin_category_admin','manage_text'),
);
?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_category_admin','manage_categories_text')?></div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('category/create')?>">
<i class="icon-plus"></i><?php echo Yii::t('admin_category_admin','add_new_text')?></a></div>
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
	'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'categoryDataSession', //sesseion name for current page size dropdown
	'statusField'=>'category_status', //Filed Name to change status with multi select
        'clildTable'=>array('CategoryQuestionLocale','TaskCategory','Skill'),
//        'clildTable'=>'CategoryQuestionLocale',
        'actionClassName'=>'CategoryLocale',
        'pkName'=>'category_id',
	'dataProvider'=>$model->search(),
        'rowCssClass'=>array('odd','even'),
        'rowCssClassExpression'=>'($data["categorylocale"]["parent_id"]==0)?"parent":"child child_".$data["categorylocale"]["parent_id"]',
	'ajaxUpdate'=>true,
	'pager'=>array(
            'maxButtonCount'=>4,
	),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumnUniform',
			'selectableRows' => 1000,
			'id'=>'autoId',
		),
            array(
                    'type'=> 'raw',
                    'value'=> 'CHtml::hiddenField("language[]", $data["categorylocale"]["language_code"])', 
                    'htmlOptions'=>array('style'=>'width:0%; display:none'),
                    'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                ),
		array(
			'header'=>Yii::t('admin_category_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                    ),
		array(
			'header'=>Yii::t('admin_category_admin','category_name_text'),
			'name'=>'category_name',
                        'value'=>'$data["categorylocale"]["category_name"]',
                    
		),
                
                array(
			'header'=>Yii::t('admin_category_admin','parent_name_text'),
			'name'=>'parent_name',
                        //'value'=>'$data["parentName"]["category_name"]',
                        'value'=>'(($data["categorylocale"]["parent_id"]==0)?"-" :$data["parentName"]["category_name"])',
                    
		),
//                array(
//			'header'=>Yii::t('admin_category_admin','sub_category_name_text'),
//			'name'=>'subcategory_name',
//                        'value'=>'Category::getChildren($data["categorylocale"]["category_id"],1)',
//
//		),
		array(
			'header'=>Yii::t('admin_category_admin','category_priority_text'),
			'name'=>'category_priority',
                        'value'=>'$data["categorylocale"]["category_priority"]',
			'headerHtmlOptions'=>array(
                            'class' => 'grid_priority'
                        ),
			'htmlOptions' => array(
                            'class' => 'grid_priority',
			),			
		),
		array(
			'name'=>Yii::t('admin_category_admin','status_text'),
			'type'=>'html',
                        'value'=>'UtilityHtml::getStatusImage($data["categorylocale"]["category_status"], "CategoryLocale", $data->category_id, "category_status",$data["categorylocale"]["language_code"],"category_id")',
			'htmlOptions' => array(
                            'class' => 'grid_status'
			),
                        'headerHtmlOptions'=>array(
                             'class' => 'grid_status'
                        ),
                ),
		array(
			'header'=> Yii::t('admin_category_admin','edit_text'),
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> Yii::t('admin_category_admin','delete_text'),
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
   
<?php $this->endWidget(); ?>