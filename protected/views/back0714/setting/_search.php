<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'search-form',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model,'setting_id'); ?>
		<?php echo $form->textField($model,'setting_id'); ?>
	</div>-->
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,Globals::FLD_NAME_SETTING_TYPE,array('class'=>'control-label','label'=>Yii::t('admin_setting_search','setting_type_txt'))); ?>
                <div class="controls"> 
                <?php 
//                $fillFields = '';
//                CommonUtility::autocomplete(Globals::FLD_NAME_SETTING_TYPE,'setting/autocompletesettingtype',10,$fillFields,'span12',60,250);?>
                <?php 
                $fillFields = '';
                echo UtilityHtml::getSettingDropdownSettingType($model,Globals::FLD_NAME_SETTING_TYPE, CommonUtility::createValue($fillFields,Globals::FLD_NAME_SETTING_TYPE)); ?>
		<?php //echo $form->textField($model,Globals::FLD_NAME_SETTING_TYPE,array('size'=>50,'maxlength'=>50, 'class' => 'span12')); ?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,Globals::FLD_NAME_SETTING_KEY, array('class'=>'control-label','label'=>Yii::t('admin_setting_search','setting_key_txt'))); ?>
                <div class="controls"> 
                <?php 
                $fillFields = '';
                CommonUtility::autocomplete(Globals::FLD_NAME_SETTING_KEY,'setting/autocompletesettingkey',10,$fillFields,'span12',60,250);?>
		<?php //echo $form->textField($model,Globals::FLD_NAME_SETTING_KEY,array('size'=>60,'maxlength'=>500, 'class' => 'span12')); ?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,Globals::FLD_NAME_SETTING_VALUE, array('class'=>'control-label','label'=>Yii::t('admin_setting_search','setting_value_txt'))); ?>
                <div class="controls"> 
                <?php 
                $fillFields = '';
                CommonUtility::autocomplete(Globals::FLD_NAME_SETTING_VALUE,'setting/autocompletesettingvalue',10,$fillFields,'span12',60,250);?>
		<?php //echo $form->textField($model,Globals::FLD_NAME_SETTING_VALUE,array('size'=>60,'maxlength'=>1000, 'class' => 'span12')); ?>
                </div>
            </div>
        </div>
<!--       <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,Globals::FLD_NAME_SETTING_LABEL, array('class'=>'control-label','label'=>Yii::t('admin_setting_search','setting_label_text'))); ?>
		<?php echo $form->textField($model,Globals::FLD_NAME_SETTING_LABEL,array('size'=>60,'maxlength'=>500, 'class' => 'span12')); ?>
            </div>
        </div>
	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>-->

	<div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_setting_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_setting_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->