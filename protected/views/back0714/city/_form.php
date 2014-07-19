<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>

<script>
    $(document).ready(function()
    {
        $('#CityLocale_country_code').on('change', function()
        {
            if($('#CityLocale_city_name').val() != '')
                                    {
                $('#CityLocale_city_name').parent().removeClass("error");
                document.getElementById("CityLocale_city_name_em_").style.display='none';
                                    }
        });
        $('#CityLocale_state_id').on('change', function()
        {
            if($('#CityLocale_city_name').val() != '')
                                    {
                $('#CityLocale_city_name').parent().removeClass("error");
                document.getElementById("CityLocale_city_name_em_").style.display='none';
                                    }
        });
        $('#CityLocale_region_id').on('change', function()
        {
            if($('#CityLocale_city_name').val() != '')
                                    {
                $('#CityLocale_city_name').parent().removeClass("error");
                document.getElementById("CityLocale_city_name_em_").style.display='none';
                                    }
        });
    });
	
</script>
<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
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
)); 

?>
<div class="row-fluid form-horizontal">
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
        <?php 
                if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,'city_id',array('class'=>'span6','size'=>60,'maxlength'=>250,)); 
                }
                ?>
            <?php 
                        $ids["country_code"] = NULL;
                        $ids["state_id"] = NULL;
                        if(isset($locale->{Globals::FLD_NAME_REGION_ID}))
                        {
                             $ids = RegionLocale::getStateIdCountryIdByRegionId($locale->{Globals::FLD_NAME_REGION_ID});
                        }
            ?>
        <div class="control-group">
                <?php echo $form->labelEx($locale,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_city_form','country_code_text'))); ?>
                <div class="controls">
                <?php  

                    $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                    echo $form->dropDownList($locale, 'country_code', $list, 
                             array('prompt'=>'--Select Country--',
                                                   'ajax' => array(
                                                   'type' => 'POST',
                                                   'url' => CController::createUrl('state/ajaxgetstate'),
                                                   'success' => "function(data){
                                                   $('#CityLocale_state_id').html(data);
                                                   $('#CityLocale_region_id').html('<option value=\"\">--Select Region--</option>');
                                                    }",
                                                   'data' => array('country_code'=>'js:this.value')),'options' => array($ids["country_code"]=>array('selected'=>true)),'class' => 'span6'));
                ?>
                <?php //echo $form->dropdownList($model,'cou_id', CHtml::listData(Country::model()->findAll(), 'cou_id', 'cou_name'), array('empty'=>'--Select Country--','class'=>'span6')); ?>
                <span class="help-inline"><?php echo $form->error($locale,'country_code'); ?></span>
                </div>
        </div>
        <div class="control-group">
             <?php 
                $statelist = array();
                if(isset($locale->{Globals::FLD_NAME_REGION_ID}))
                {
                   $statelist = CHtml::listData(StateLocale::getStateList($ids["country_code"]),'state_id', 'state_name');
                }
                ?>
            
		<?php echo $form->labelEx($locale,'state_id',array('class'=>'control-label','label'=>Yii::t('admin_city_form','state_id_text'))); ?>
		<div class="controls"><?php echo $form->dropDownList($locale,'state_id',$statelist,
                        
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('region/ajaxgetregion'),
                            'update' => '#CityLocale_region_id',
                            'data' => array('state_id'=>'js:this.value')),
                            'options' => array($ids["state_id"]=>array('selected'=>true)),'class' => 'span6')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($locale,'state_id'); ?>
                    </span>
                </div>
	</div>
        
        <div class="control-group">
             <?php 
                $regionlist = array();
                if(isset($locale->{Globals::FLD_NAME_REGION_ID}))
                {
                   $regionlist = CHtml::listData(RegionLocale::getRegionList($ids["state_id"]),'region_id', 'region_name');
                }
                ?>
            
		<?php echo $form->labelEx($locale,'region_id',array('class'=>'control-label','label'=>Yii::t('admin_city_form','region_id_text'))); ?>
		<div class="controls"><?php echo $form->dropDownList($locale,'region_id',$regionlist,array('prompt'=>'--Select Region--','class' => 'span6')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($locale,'region_id'); ?>
                    </span>
                </div>
	</div>
    
        <div class="control-group">
		<?php echo $form->labelEx($locale,'city_name',array('class'=>'control-label','label'=>Yii::t('admin_city_form','city_name_text'))); ?>
		<div class="controls"><?php echo $form->textField($locale,'city_name',array('size'=>60,'maxlength'=>100,'class'=>'span6'));?>
                    <span class="help-inline">
                    <?php echo $form->error($locale,'city_name'); ?>
                    </span>
                </div>
	</div>
    
    
        <div class="control-group">
		<?php echo $form->labelEx($locale,'city_priority',array('class'=>'control-label','label'=>Yii::t('admin_city_form','city_priority_text'))); ?>
        <div class="controls">
		<?php echo $form->textField($locale,'city_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
            <span class="help-inline"><?php echo $form->error($locale,'city_priority'); ?></span></div>
	</div>
	
	<div class="control-group">
		<?php echo $form->label($locale,'city_status',array('label'=>Yii::t('admin_city_form','city_status_text'))); ?>
            <div class="controls">
		<?php echo $form->radioButtonList($locale, 'city_status',array('1'=>Yii::t('admin_city_form','active_text'),'0'=>Yii::t('admin_city_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<?php //echo $form->dropdownList($model,'country_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
		<span class="help-inline">
                    <?php echo $form->error($locale,'city_status'); ?>
                </span>
            </div>
	</div>
	

	 <div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_city_form','create_text') : Yii::t('admin_city_form','update_text'),array('class'=>'btn blue')); ?>
			<?php echo CHtml::button(Yii::t('admin_city_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->
