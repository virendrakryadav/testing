<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	Yii::t('admin_setting_create','setting_text')=>array('admin'),
	Yii::t('admin_setting_create','create_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_setting_create','create_setting_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>