<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	Yii::t('admin_city_create','city_name_text') =>array('admin'),
	Yii::t('admin_city_create','create_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_city_create','create_city_text');?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale,)); ?>