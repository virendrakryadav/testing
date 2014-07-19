<?php
/* @var $this SettingController */
/* @var $data Setting */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('setting_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->setting_id), array('view', 'id'=>$data->setting_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('setting_type')); ?>:</b>
	<?php echo CHtml::encode($data->setting_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('setting_key')); ?>:</b>
	<?php echo CHtml::encode($data->setting_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('setting_value')); ?>:</b>
	<?php echo CHtml::encode($data->setting_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('setting_label')); ?>:</b>
	<?php echo CHtml::encode($data->setting_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

</div>