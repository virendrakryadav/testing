<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	Yii::t('admin_setting_update','setting_text')=>array('admin'),
	Yii::t('admin_setting_update','update_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_setting_update','update_setting_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>