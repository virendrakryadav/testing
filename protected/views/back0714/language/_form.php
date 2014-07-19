<?php
/* @var $this LanguageController */
/* @var $model Language */
/* @var $form CActiveForm */
?>

<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'language-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true
	),
)); ?>
<div class="row-fluid form-horizontal">
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
        <div class="control-group">
		<?php echo $form->labelEx($model,'language_code',array('class'=>'control-label','label'=>Yii::t('admin_language_form','language_code_text'))); ?>
		<div class="controls"><?php echo $form->textField($model,'language_code',array('size'=>5,'maxlength'=>5,'class'=>'span6'));?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'language_code'); ?>
                    </span>
                </div>
	</div>
	
        <div class="control-group">
		<?php echo $form->labelEx($model,'language_name',array('class'=>'control-label','label'=>Yii::t('admin_language_form','language_name_text'))); ?>
		<div class="controls"><?php echo $form->textField($model,'language_name',array('size'=>60,'maxlength'=>75,'class'=>'span6'));?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'language_name'); ?>
                    </span>
                </div>
	</div>
        <div class="control-group">
		<?php  echo $form->labelEx($model,'language_priority',array('class'=>'control-label','label'=>Yii::t('admin_language_form','language_priority_text'))); ?>
            <div class="controls">
		<?php echo $form->textField($model,'language_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
                <span class="help-inline">
                    <?php echo $form->error($model,'language_priority'); ?>
                </span>
            </div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'language_status',array('label'=>Yii::t('admin_language_form','language_status_text'))); ?>
            <div class="controls">
		<?php echo $form->radioButtonList($model, 'language_status',array('1'=>Yii::t('admin_language_form','active_text'),'0'=>Yii::t('admin_language_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<?php //echo $form->dropdownList($model,'country_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
		<span class="help-inline">
                    <?php echo $form->error($model,'language_status'); ?>
                </span>
            </div>
	</div>
         <div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_language_form','create_text') : Yii::t('admin_language_form','update_text'),array('class'=>'btn blue')); ?>
			<?php echo CHtml::button(Yii::t('admin_language_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->