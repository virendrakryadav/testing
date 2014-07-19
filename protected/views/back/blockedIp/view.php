<?php
/* @var $this BlockedIpController */
/* @var $model BlockedIp */

$this->breadcrumbs=array(
	'Blocked Ips'=>array('index'),
	$model->blocked_ip_id,
);

$this->menu=array(
	array('label'=>'List BlockedIp', 'url'=>array('index')),
	array('label'=>'Create BlockedIp', 'url'=>array('create')),
	array('label'=>'Update BlockedIp', 'url'=>array('update', 'id'=>$model->blocked_ip_id)),
	array('label'=>'Delete BlockedIp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->blocked_ip_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BlockedIp', 'url'=>array('admin')),
);
?>

<h1>View BlockedIp #<?php echo $model->blocked_ip_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'blocked_ip_id',
		'ip_address',
		'start_dt',
		'end_dt',
		'reason',
		'status',
		'create_at',
		'created_by',
		'update_at',
		'updated_by',
	),
)); ?>
