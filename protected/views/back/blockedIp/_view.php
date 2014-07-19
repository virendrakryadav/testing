<?php
/* @var $this BlockedIpController */
/* @var $data BlockedIp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('blocked_ip_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->blocked_ip_id), array('view', 'id'=>$data->blocked_ip_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_dt')); ?>:</b>
	<?php echo CHtml::encode($data->start_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_dt')); ?>:</b>
	<?php echo CHtml::encode($data->end_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_at')); ?>:</b>
	<?php echo CHtml::encode($data->create_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_at')); ?>:</b>
	<?php echo CHtml::encode($data->update_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	*/ ?>

</div>