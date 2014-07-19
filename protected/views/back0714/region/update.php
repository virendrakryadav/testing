<?php
/* @var $this RegionController */
/* @var $model Region */

$this->breadcrumbs=array(
	Yii::t('admin_region_update','region_text')=>array('admin'),
//	$model->{Globals::FLD_NAME_REGION_ID}=>array('view','id'=>$model->{Globals::FLD_NAME_REGION_ID}),
	Yii::t('admin_region_update','update_text'),
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_region_update','update_region_text')?></div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>