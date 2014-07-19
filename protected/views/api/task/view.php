<?php
/* @var $this StateController */
/* @var $model State */

$this->breadcrumbs=array(
	'Admin'=>array('admin'),
);
?>


<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>View</div>
</div>

 <div class="wide form" style="padding:10px;">
     <div class="row-fluid form-horizontal">
    
<div class="control-group">
	<label><?php echo CHtml::encode($model->getAttributeLabel('title')); ?>:</label>
	<div class="controls"><?php echo $model->{Globals::FLD_NAME_TITLE}; ?></div>
</div>
<div class="control-group">
	<label>Image:</label>
	<div class="controls"> <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($model->{Globals::FLD_NAME_TASK_ID},  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150">   </div>
</div>
<div class="control-group">
	<label>Skills:</label>
	<div class="controls"><?php echo UtilityHtml::taskSkills($model->{Globals::FLD_NAME_TASK_ID}); ?></div>
</div>
<div class="control-group">
	<label>Requirements & details:</label>
	<div class="controls"><?php echo CommonUtility::getPublicDetail($model->is_public);  ?></div>
</div>
<div class="control-group">
	<label><?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:</label>
	<div class="controls"><?php echo $model->description; ?></div>
</div>
<div class="control-group">

	<label><?php echo CHtml::encode($model->getAttributeLabel('user')); ?>:</label>
	<div class="controls"><?php echo UtilityHtml::getUserName($model->{Globals::FLD_NAME_CREATER_USER_ID}) ?></div>
</div>
<div class="control-group">

	<label><?php echo CHtml::encode($model->getAttributeLabel('state')); ?>:</label>
	<div class="controls"><?php echo UtilityHtml::getTaskStatus($model->state) ?></div>
</div>
         
<div class="control-group">

	<label><?php echo CHtml::encode($model->getAttributeLabel('Payment')); ?>:</label>
	<div class="controls"><?php echo UtilityHtml::getPaymentMode($model->{Globals::FLD_NAME_PAYMENT_MODE}) ?></div>
</div>
<div class="control-group">
	<label>Invited Taskers:</label>
	<div class="controls"><?php echo UtilityHtml::invitedTaskers($model->{Globals::FLD_NAME_TASK_ID}); ?></div>
</div>
     </div>
</div><!-- form -->