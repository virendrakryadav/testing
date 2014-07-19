<?php
/* @var $this StateController */
/* @var $model State */
/* @var $form CActiveForm */
?>
<script>
    $(document).ready(function()
    {
        $('#StateLocale_country_code').on('change', function()
        {
            if($('#StateLocale_state_name').val() != '')
                                    {
                $('#StateLocale_state_name').parent().removeClass("error");
                document.getElementById("StateLocale_state_name_em_").style.display='none';
                                    }
        });  
    });
	
</script>
<div class="wide form" style="padding:10px;">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'state-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		//'enableAjaxValidation'=>true,
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
<!--		<p class="note">Fields with <span class="required">*</span> are required.</p>-->
		<?php echo $form->errorSummary($model); ?>
                
                <?php 
                if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,'state_id',array('class'=>'span6','size'=>60,'maxlength'=>250,)); 
                }
                ?>
		<div class="control-group">
			<?php echo $form->labelEx($locale,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_state_form','country_code_text'))); ?>
			<div class="controls">
			<?php  
                               
                            $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                            echo $form->dropDownList($locale, 'country_code', $list, array('empty' => '--Select Country--','class' => 'span6'));
                        ?>
                        <?php //echo $form->dropdownList($model,'cou_id', CHtml::listData(Country::model()->findAll(), 'cou_id', 'cou_name'), array('empty'=>'--Select Country--','class'=>'span6')); ?>
                        <span class="help-inline"><?php echo $form->error($locale,'country_code'); ?></span>
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($locale,'state_name',array('class'=>'control-label','label'=>Yii::t('admin_state_form','state_name_text'))); ?>
			<div class="controls">
				<?php echo $form->textField($locale,'state_name',array('class'=>'span6','size'=>60,'maxlength'=>250,)); ?>
			
                                <span class="help-inline"><?php echo $form->error($locale,'state_name'); ?></span>
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($locale,'state_priority',array('class'=>'control-label','label'=>Yii::t('admin_state_form','state_priority_text'))); ?>
			<div class="controls">
				<?php echo $form->textField($locale,'state_priority',array('class'=>'span6','size'=>5,'maxlength'=>50 , 'value'=>$this->maxPriority)); ?>
				<span class="help-inline"><?php echo $form->error($locale,'state_priority'); ?></span>
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->label($locale,'state_status',array('label'=>Yii::t('admin_state_form','state_status_text'))); ?>
			<div class="controls">
				<?php echo $form->radioButtonList($locale, 'state_status',array('1'=>Yii::t('admin_state_form','active_text'),'0'=>Yii::t('admin_state_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
				
				

				<?php //echo $form->dropdownList($model,'state_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
				<span class="help-inline"><?php echo $form->error($locale,'state_status'); ?></span>
			</div>
		</div>
		
		<div class="controls">
			<div class="span2">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_state_form','create_text') : Yii::t('admin_state_form','update_text'),array('class'=>'btn blue')); ?>
				<?php echo CHtml::button(Yii::t('admin_state_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
			</div>
		</div>
	<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->

