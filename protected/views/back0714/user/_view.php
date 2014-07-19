<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php //echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->{Globals::FLD_NAME_USER_ID}), array('view', 'id'=>$data->{Globals::FLD_NAME_USER_ID})); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('state_id')); ?>:</b>
	<?php echo CHtml::encode($data->state_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->city_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zip_code')); ?>:</b>
	<?php echo CHtml::encode($data->zip_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_status')); ?>:</b>
	<?php echo CHtml::encode($data->user_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_verify')); ?>:</b>
	<?php echo CHtml::encode($data->is_verify); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_created_at')); ?>:</b>
	<?php echo CHtml::encode($data->user_created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->user_updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_image')); ?>:</b>
	<?php echo CHtml::encode($data->user_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_video')); ?>:</b>
	<?php echo CHtml::encode($data->user_video); ?>
	<br />

	*/ ?>

</div>