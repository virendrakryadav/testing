<?php
/* @var $this BlockedIpController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blocked Ips',
);

$this->menu=array(
	array('label'=>'Create BlockedIp', 'url'=>array('create')),
	array('label'=>'Manage BlockedIp', 'url'=>array('admin')),
);
?>

<h1>Blocked Ips</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
