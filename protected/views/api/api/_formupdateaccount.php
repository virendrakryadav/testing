<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>
<script>
   $(function () {
    $('#Admin_is_admin').on('change', function () {
        var checked = $(this).prop('checked');
        $('#Admin_user_roleid').val('');
        $('#Admin_user_roleid').prop('disabled', checked);
    });
});
</script>
<script>
function backUrl()
{
	window.location.href='admin';
}
</script>

<div class="search-form">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<div class="row-fluid form-horizontal">
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
	
        
<?php /*?>	<div class="control-group">
		<?php echo $form->labelEx($model,'login_name',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'login_name',array('size'=>20,'maxlength'=>20,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'login_name'); ?></span></div>
	</div>
<?php */?>
        <div class="control-group">
		<?php echo $form->labelEx($model,'login_name',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','login_name_text'))); ?>
		<div class="controls">
		<?php echo $form->textField($model,'login_name',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'login_name'); ?></span></div>
	</div>
        
         <div class="control-group"> 
  
  <?php echo $form->labelEx($model,'firstname',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','firstname_text'))); ?>
          <?php /*?><div class="controls"><div class="span1 margin_right" style="width:67px;"> <?php UtilityHtml::getSalutionDropdown($model,'user_salutation',$model->user_salutation); ?>  <?php echo $form->error($model,'user_salutation'); ?>  </div></div><?php */?>
    
          <div class="controls"> <div class="span3 new_span3"><?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>100,'class'=>'span12')); ?>  <?php echo $form->error($model,'firstname'); ?>  </div></div>
  
    <div class="controls"> <div class="span3 new_span3"><?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>100,'class'=>'span12')); ?>  <?php echo $form->error($model,'lastname'); ?>  </div></div>

  
  </div>
<!--	<div class="control-group">
		<?php echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'firstname'); ?></span></div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'lastname'); ?></span></div>
	</div>-->
	<div class="control-group">
		<?php echo $form->labelEx($contactEmail,'contact_id',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','user_email_text'))); ?>
		<div class="controls">
		<?php echo $form->textField($contactEmail,'contact_id',array('size'=>20,'maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($contactEmail,'contact_id'); ?></span></div>
	</div>
        <?php
        if ($model->isNewRecord) 
        {
        ?>

     <div class="control-group">
		<?php echo $form->labelEx($model,'Password',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','password_text'))); ?>
		<div class="controls">
		<?php echo $form->passwordField($model,'password',array('class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'password'); ?></span></div>
	</div>
	
    <div class="control-group">
		<?php echo $form->labelEx($model,'repeatpassword',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','repeatpassword_text'))); ?>
		<div class="controls">
		<?php echo $form->passwordField($model,'repeatpassword',array('class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'repeatpassword'); ?></span></div>
	</div>
        <?php
        }
        ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'phone',array('class'=>'control-label','label'=>Yii::t('admin_admin_formupdateaccount','user_phone_text'))); ?>
		<div class="controls">
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20,'class'=>'span6')); ?><span class="help-inline">
		<?php echo $form->error($model,'phone'); ?></span></div>
	</div>

	
        
	 <div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_admin_formupdateaccount','create_text') : Yii::t('admin_admin_formupdateaccount','save_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::button(Yii::t('admin_admin_formupdateaccount','cancel_text'), array('onClick' => 'backUrlReferer()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>