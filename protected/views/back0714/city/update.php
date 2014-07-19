<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	Yii::t('admin_city_update','city_name_text') =>array('admin'),
//	$model->city_id=>array('view','id'=>$model->city_id),
	Yii::t('admin_city_update','update_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_city_update','update_city_text')?></div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>