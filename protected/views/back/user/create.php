<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Create',
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>Create User</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>