<?php
/* @var $this BlockedIpController */
/* @var $model BlockedIp */

$this->breadcrumbs=array(
	'Blocked Ips',
	'Update',
);
?>


<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i>Update Blocked Ip</div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>