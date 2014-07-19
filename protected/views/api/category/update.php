<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('admin_category_update','categories_text')=>array('admin'),
	//$model->category_id=>array('view','id'=>$model->category_id),
	Yii::t('admin_category_update','update_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_category_update','update_category_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>