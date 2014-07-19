<?php
/* @var $this RegionController */
/* @var $model Region */

$this->breadcrumbs=array(
	Yii::t('admin_region_create','region_text')=>array('admin'),
	Yii::t('admin_region_create','create_text'),
);
?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_region_create','create_region_text'); ?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale,)); ?>