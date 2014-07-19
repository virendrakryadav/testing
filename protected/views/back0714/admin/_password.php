<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<?php CommonUtility::passwordValidationFormScript(); ?>
<div class="search-form">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		'validateOnType' => true,
		//'validateOnClick' => true
	),
)); ?>

	<div class="row-fluid form-horizontal">
<!--                <p class="note">Fields with <span class="required">*</span> are required.</p>-->

                <?php echo $form->errorSummary($model); ?>

                <div class="control-group">
                        <?php echo $form->labelEx($model,'oldpassword',array('class'=>'control-label','label'=>Yii::t('admin_admin_password','oldpassword_text'))); ?>
                        <div class="controls">
                        <?php echo $form->passwordField($model,'oldpassword',array('maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
                        <?php echo $form->error($model,'oldpassword'); ?></span></div>
                </div>

                <div class="control-group">
                        <?php echo $form->labelEx($model,'newpassword',array('class'=>'control-label','label'=>Yii::t('admin_admin_password','newpassword_text'))); ?>
                        <div class="controls">
                        <?php 
                        $this->widget('ext.EStrongPassword.EStrongPassword',array('form'=>$form, 'model'=>$model, 'attribute'=>'newpassword','htmlOptions'=>array('class'=>'span6 left_password'),));
                        //echo $form->passwordField($model,'newpassword',array('maxlength'=>100,'class'=>'span6')); ?><span class="help-inline">
                        <?php echo $form->error($model,'newpassword'); ?></span></div>
                </div>

                <div class="control-group">
                        <?php echo $form->labelEx($model,'repeatpassword',array('class'=>'control-label','label'=>Yii::t('admin_admin_password','repeatpassword_text'))); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'repeatpassword',array('maxlength'=>100,'class'=>'span6')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model,'repeatpassword'); ?>
                            </span>
                        </div>
                </div>

                <div class="controls">
                        <div class="span2">
                            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_admin_password','create_text') : Yii::t('admin_admin_password','save_text'),array('class'=>'btn blue')); ?>
                            <?php echo CHtml::button(Yii::t('admin_admin_password','cancel_text'), array('onClick' => 'backUrlReferer()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
                        </div>
                </div>
        </div><!-- form -->
<?php $this->endWidget(); ?>


</div>
</div>