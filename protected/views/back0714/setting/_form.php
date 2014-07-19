<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>
<script>
    $(document).ready(function()
    {
        $('#Setting_setting_type').on('change', function()
        {
            if($('#Setting_setting_key').val() != '')
                                    {
                $('#Setting_setting_key').parent().removeClass("error");
                document.getElementById("Setting_setting_key_em_").style.display='none';
                                    }
        });  
    });
</script>
<div class="search-form">
<div class="wide form" style="padding:10px;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		//'validateOnType' => true,
		'validateOnClick' => true 
            ),
)); ?>
<div class="row-fluid form-horizontal">	

	<?php //echo $form->errorSummary($model); ?>
        <?php if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,Globals::FLD_NAME_SETTING_ID, array('class'=>'span6','size'=>60,'maxlength'=>250,)); 
                }
        ?>
            
	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_SETTING_TYPE, array('class'=>'control-label','label'=>Yii::t('admin_setting_form','setting_type_txt'))); ?>
            <div class="controls">
                <?php if(!$model->isNewRecord)
                {
                    echo $model->{Globals::FLD_NAME_SETTING_TYPE}; 
                }
                else
                {
                ?>
                <div class="span6">
                    <?php
                   echo UtilityHtml::getSettingDropdownSettingType($model,Globals::FLD_NAME_SETTING_TYPE, $model->{Globals::FLD_NAME_SETTING_TYPE}); 
                    ?>
                </div>
                <?php 
                }
                ?>
		<span class="help-inline">
                    <?php echo $form->error($model,Globals::FLD_NAME_SETTING_TYPE); ?>
                </span>
            </div>
	</div>
	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_SETTING_KEY, array('class'=>'control-label','label'=>Yii::t('admin_setting_form','setting_key_txt'))); ?>
            <div class="controls">
                <?php if(!$model->isNewRecord)
                {
                    echo $model->{Globals::FLD_NAME_SETTING_KEY}; 
                }
                else
                {
                   echo $form->textField($model,Globals::FLD_NAME_SETTING_KEY, array('size'=>60,'maxlength'=>500,'class'=>'span6'));  
                }
                ?>
		<span class="help-inline">
                    <?php echo $form->error($model,Globals::FLD_NAME_SETTING_KEY); ?>
                </span>
            </div>
	</div>

	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_SETTING_VALUE, array('class'=>'control-label','label'=>Yii::t('admin_setting_form','setting_value_txt'))); ?>
            <div class="controls">
                    <?php echo $form->textField($model,Globals::FLD_NAME_SETTING_VALUE, array('size'=>60,'maxlength'=>1000,'class'=>'span6')); ?>
		<span class="help-inline">
                    <?php echo $form->error($model,Globals::FLD_NAME_SETTING_VALUE); ?>
                </span>
            </div>
	</div>

	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_SETTING_LABEL, array('class'=>'control-label','label'=>Yii::t('admin_setting_form','setting_label_txt'))); ?>
            <div class="controls">
                <?php if(!$model->isNewRecord)
                {
                    echo $model->{Globals::FLD_NAME_SETTING_LABEL}; 
                }
                else
                {
                   echo $form->textField($model,Globals::FLD_NAME_SETTING_LABEL, array('size'=>60,'maxlength'=>500,'class'=>'span6'));  
                }
                ?>
                <span class="help-inline">
		<?php echo $form->error($model,Globals::FLD_NAME_SETTING_LABEL); ?>
                </span>
            </div>
	</div>

        <div class="controls">
                <div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_setting_form','create_text') : Yii::t('admin_setting_form','update_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::button(Yii::t('admin_setting_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
                </div>
        </div>

<?php $this->endWidget(); ?>
</div></div>
</div><!-- form -->