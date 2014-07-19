<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs=array(
	Yii::t('admin_country_create','create_text')=>array('admin'),
	//$model->cou_id=>array('view','id'=>$model->cou_id),
	Yii::t('admin_country_create','update_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_country_create','update_country_text')?></div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>