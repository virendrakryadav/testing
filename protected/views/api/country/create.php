<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs=array(
	Yii::t('admin_country_create','country_text')=>array('admin'),
	Yii::t('admin_country_create','create_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_country_create','create_country_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>