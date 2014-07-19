<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	//$model->name=>array('view','id'=>$model->admin_id),
	'Change Password',
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-lock"></i>Change Password : <span style="color:#0088CC"><?php echo ucfirst($model->firstname)." ".ucfirst($model->lastname); ?></span></div>
</div>

<?php $this->renderPartial('_userpassword', array('model'=>$model)); ?>