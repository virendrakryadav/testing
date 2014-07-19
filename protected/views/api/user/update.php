<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	//$model->{Globals::FLD_NAME_USER_ID}=>array('view','id'=>$model->{Globals::FLD_NAME_USER_ID}),
	'Update',
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i>Update User</div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>