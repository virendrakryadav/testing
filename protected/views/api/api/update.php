<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	Yii::t('admin_admin_update','admin_user_text')=>array('admin'),
	//$model->name=>array('view','id'=>$model->admin_id),
	Yii::t('admin_admin_update','update_text')=>array('admin'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_admin_update','update_admin_user_text');?></div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>