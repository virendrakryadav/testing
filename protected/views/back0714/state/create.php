<?php
/* @var $this StateController */
/* @var $model State */

$this->breadcrumbs=array(
	Yii::t('admin_state_create','state_text')=>array('admin'),
	Yii::t('admin_state_create','create_text'),
);
?>


<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_state_create','create_state_text')?></div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>