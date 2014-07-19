<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('admin_category_create','categories_text')=>array('admin'),
	Yii::t('admin_category_create','create_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_category_create','create_category_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>