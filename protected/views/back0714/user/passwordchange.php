<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	//$model->name=>array('view','id'=>$model->admin_id),
	'Change Password',
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-lock"></i>Change Password : <span style="color:#0088CC"><?php echo ucfirst($model->firstname)." ".ucfirst($model->lastname); ?></span></div>
</div>
<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>
<?php  CommonUtility::passwordValidationFormScript(); ?>
<div class="wide form" style="padding:10px;" >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-changepassword',
	'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
                'validateOnSubmit' => true,
                ),
)); 
?>
<div class="row-fluid form-horizontal">
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

        <div class="control-group">
		<?php echo $form->labelEx($model,'newpassword',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
			$this->widget('ext.EStrongPassword.EStrongPassword',array('form'=>$form, 'model'=>$model, 'attribute'=>'newpassword','htmlOptions'=>array('class'=>'span6 left_password')));
			//echo $form->passwordField($model,'newpassword',array('maxlength'=>40,'class'=>'span6')); ?>
			<span class="help-inline"><?php echo $form->error($model,'newpassword'); ?></span>
		</div>
		</div>
        
        <div class="control-group">
		<?php echo $form->labelEx($model,'repeatpassword',array('class'=>'control-label')); ?>
		<div class="controls">
			 <?php echo $form->passwordField($model,'repeatpassword',array('maxlength'=>40,'class'=>'span6')); ?>
			<span class="help-inline"><?php echo $form->error($model,'repeatpassword'); ?></span>
		</div>
		</div>

	  	<div class="controls">
			<div class="span2">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('id'=>'form-user','class'=>'btn blue')); ?>
                            <?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
			</div>
		</div>

<?php $this->endWidget(); ?>

</div>
</div><!-- form -->
