<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->{Globals::FLD_NAME_USER_ID},
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->{Globals::FLD_NAME_USER_ID})),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->{Globals::FLD_NAME_USER_ID}),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->{Globals::FLD_NAME_USER_ID}; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'firstname',
		'lastname',
		'email',
		'password',
		'mobile',
		'country_id',
		'state_id',
		'city_name',
		'zip_code',
		'user_status',
		'is_verify',
		'user_created_at',
		'user_updated_at',
		'user_image',
		'user_video',
	),
)); ?>
