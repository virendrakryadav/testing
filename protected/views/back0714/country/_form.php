<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */
?>
<div class="search-form">
<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'country-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	///'enableAjaxValidation'=>true,
	//'enableClientValidation'=>true,
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true
	),
)); ?>
<div class="row-fluid form-horizontal">
    <?php echo $form->errorSummary($model); ?>

	<div class="control-group">
            <?php echo $form->labelEx($model,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_country_form','country_code_text'))); ?>
		<div class="controls">
		<?php echo $form->textField($model,'country_code',array('class'=>'span6','style' => 'text-transform: uppercase')); ?>
                <span class="help-inline">
                   <?php echo $form->error($model,'country_code'); ?>
                </span>
                </div>
	</div>
      
            <!--<div class="control-group">
		<?php //echo $form->labelEx($locale,'language_code',array('class'=>'control-label')); ?>
		<div class="controls">
                    <?php  
//                  $list = CHtml::listData(Language::getLanguageList(),'language_code', 'language_name');
//                  echo $form->dropDownList($locale, 'language_code',$list,
//                  array('class'=>'span6'));?>
                    <span class="help-inline">
                    <?php //echo $form->error($locale,'language_code'); ?>
                    </span>
                </div>
            </div>-->

	<div class="control-group">
		<?php echo $form->labelEx($locale,'country_name',array('class'=>'control-label','label'=>Yii::t('admin_country_form','country_name_text'))); ?>
		<div class="controls">
                <?php echo $form->textField($locale,'country_name',array('class'=>'span6')); ?>
                <span class="help-inline">
                    <?php echo $form->error($locale,'country_name'); ?>
                </span>
                </div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($locale,'country_priority',array('class'=>'control-label','label'=>Yii::t('admin_country_form','country_priority_text'))); ?>
                <div class="controls">
		<?php echo $form->textField($locale,'country_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
                <span class="help-inline">
                    <?php echo $form->error($locale,'country_priority'); ?>
                </span>
                </div>
	</div>
	
	<div class="control-group">
		<?php echo $form->label($locale,'country_status',array('label'=>Yii::t('admin_country_form','country_status_text'))); ?>
                <div class="controls">
		<?php echo $form->radioButtonList($locale, 'country_status',array('1'=>Yii::t('admin_country_form','active_text'),'0'=>Yii::t('admin_country_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<?php //echo $form->dropdownList($model,'country_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
		<span class="help-inline">
                    <?php echo $form->error($locale,'country_status'); ?>
                </span>
                </div>
	</div>
        <div class="controls">
                <div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_country_form','create_text') : Yii::t('admin_country_form','update_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::button(Yii::t('admin_country_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
                </div>
        </div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->
</div>