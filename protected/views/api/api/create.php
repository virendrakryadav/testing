<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	Yii::t('admin_admin_create','admin_user_text')=>array('admin'),
	'Create',
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_admin_create','create_admin_user_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>