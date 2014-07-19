<?php
/* @var $this RegionController */
/* @var $model Region */
/* @var $form CActiveForm */
?>
<script>
    $(document).ready(function()
    {
        $('#RegionLocale_country_code').on('change', function()
        {
            if($('#RegionLocale_region_name').val() != '')
                                    {
                $('#RegionLocale_region_name').parent().removeClass("error");
                document.getElementById("RegionLocale_region_name_em_").style.display='none';
                                    }
        });
        $('#RegionLocale_state_id').on('change', function()
        {
            if($('#RegionLocale_region_name').val() != '')
                                    {
                $('#RegionLocale_region_name').parent().removeClass("error");
                document.getElementById("RegionLocale_region_name_em_").style.display='none';
                                    }
        });
    });
	
</script>
<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'region-form',
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

	<?php echo $form->errorSummary($locale); ?>

	<?php 
                $country_code = NULL;
                if(isset($locale->state_id))
                {
                    $country_code = StateLocale::getStateCountryId($locale->state_id);
                }
                       
        ?>
        <div class="control-group">
                <?php echo $form->labelEx($locale,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_region_form','country_code_text'))); ?>
                <div class="controls">
                <?php  

                    $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                    echo $form->dropDownList($locale, 'country_code', $list, 
                             array('prompt'=>'Select Country',
                                                   'ajax' => array(
                                                   'type' => 'POST',
                                                   'url' => CController::createUrl('state/ajaxgetstate'),
                                                   'update' => '#RegionLocale_state_id',
                                                   'data' => array('country_code'=>'js:this.value')),'options' => array($country_code=>array('selected'=>true)),'class' => 'span6'));
                ?>
                <?php //echo $form->dropdownList($model,'cou_id', CHtml::listData(Country::model()->findAll(), 'cou_id', 'cou_name'), array('empty'=>'--Select Country--','class'=>'span6')); ?>
                <span class="help-inline"><?php echo $form->error($locale,'country_code'); ?></span>
                </div>
        </div>
        <div class="control-group">
             <?php 
                $statelist = array();
               if(isset($locale->state_id))
               {
                   $statelist = CHtml::listData(StateLocale::getStateList($country_code),'state_id', 'state_name');
               }
                ?>
            
		<?php echo $form->labelEx($locale,'state_id',array('class'=>'control-label','label'=>Yii::t('admin_region_form','state_id_text'))); ?>
		<div class="controls"><?php echo $form->dropDownList($locale,'state_id',$statelist,array('prompt'=>'--Select State--','class' => 'span6')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($locale,'state_id'); ?>
                    </span>
                </div>
	</div>
    
        <div class="control-group">
		<?php echo $form->labelEx($locale,'region_name',array('class'=>'control-label','label'=>Yii::t('admin_region_form','region_name_text'))); ?>
		<div class="controls"><?php echo $form->textField($locale,'region_name',array('size'=>60,'maxlength'=>100,'class'=>'span6'));?>
                    <span class="help-inline">
                    <?php echo $form->error($locale,'region_name'); ?>
                    </span>
                </div>
	</div>
    
    
        <div class="control-group">
		<?php echo $form->labelEx($locale,'region_priority',array('class'=>'control-label','label'=>Yii::t('admin_region_form','region_priority_text'))); ?>
        <div class="controls">
		<?php echo $form->textField($locale,'region_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
            <span class="help-inline"><?php echo $form->error($locale,'region_priority'); ?></span></div>
	</div>
	
	<div class="control-group">
		<?php echo $form->label($locale,'region_status',array('label'=>Yii::t('admin_region_form','region_status_text'))); ?>
        <div class="controls">
		<?php echo $form->radioButtonList($locale, 'region_status',array('1'=>Yii::t('admin_region_form','active_text'),'0'=>Yii::t('admin_region_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<?php //echo $form->dropdownList($model,'country_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'region_status'); ?></span></div>
	</div>
	

	 <div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_region_form','create_text') : Yii::t('admin_region_form','update_text'),array('class'=>'btn blue')); ?>
			<?php echo CHtml::button(Yii::t('admin_region_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->