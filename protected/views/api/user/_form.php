<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
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
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model,'firstname',array('class'=>'span6','size'=>60,'maxlength'=>100,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'firstname'); ?></span>

            </div>
        </div>
    
        <div class="control-group">
            <?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model,'lastname',array('class'=>'span6','size'=>60,'maxlength'=>100,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'lastname'); ?></span>

            </div>
        </div>
	
        <div class="control-group">
            <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model,'email',array('class'=>'span6','size'=>60,'maxlength'=>100,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'email'); ?></span>

            </div>
        </div>
	<?php
        if ($model->isNewRecord) 
        {
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->passwordField($model,'password',array('class'=>'span6','size'=>60,'maxlength'=>255,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'password'); ?></span>

            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'repeatpassword',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->passwordField($model,'repeatpassword',array('class'=>'span6','size'=>60,'maxlength'=>255,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'repeatpassword'); ?></span>

            </div>
        </div>
	
       <?php
        }
        ?>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'mobile',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model,'mobile',array('class'=>'span6','size'=>20,'maxlength'=>20,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'mobile'); ?></span>

            </div>
        </div>
       <?php 
                $ids["country_code"] = NULL;
                $ids["state_id"] = NULL;
                if(isset($locale->{Globals::FLD_NAME_REGION_ID}))
                {
                     $ids = RegionLocale::getStateIdCountryIdByRegionId($locale->{Globals::FLD_NAME_REGION_ID});
                }
        ?>
        <div class="control-group">
                <?php echo $form->labelEx($model,'country_code',array('class'=>'control-label')); ?>
                <div class="controls">
                <?php  

                    $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                    echo $form->dropDownList($model, 'country_code', $list, 
                             array('prompt'=>'--Select Country--',
                                                   'ajax' => array(
                                                   'type' => 'POST',
                                                   'url' => CController::createUrl('state/ajaxgetstate'),
                                                   'success' => "function(data){
                                                       $('#User_state_id').html(data);
                                                       $('#User_region_id').html('<option value=\"\">--Select Region--</option>');
                                                        $('#User_city_id').html('<option value=\"\">--Select City--</option>');

                                                    }",
                                                   'data' => array('country_code'=>'js:this.value')),'options' => array($ids["country_code"]=>array('selected'=>true)),'class' => 'span6'));
                ?>
                <?php //echo $form->dropdownList($model,'cou_id', CHtml::listData(Country::model()->findAll(), 'cou_id', 'cou_name'), array('empty'=>'--Select Country--','class'=>'span6')); ?>
                <span class="help-inline"><?php echo $form->error($model,'country_code'); ?></span>
                </div>
        </div>
        <div class="control-group">
             <?php 
                $statelist = array();
                if(isset($model->{Globals::FLD_NAME_COUNTRY_CODE}))
                {
                   $statelist = CHtml::listData(StateLocale::getStateList($model->{Globals::FLD_NAME_COUNTRY_CODE}),'state_id', 'state_name');
                }
                ?>
            
		<?php echo $form->labelEx($model,'state_id',array('class'=>'control-label')); ?>
		<div class="controls"><?php echo $form->dropDownList($model,'state_id',$statelist,
                        
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('region/ajaxgetregion'),
                            'success' => "function(data){
                                                       $('#User_region_id').html(data);
                                                        $('#User_city_id').html('<option value=\"\">--Select City--</option>');

                                                    }",
                            'data' => array('state_id'=>'js:this.value')),
                            'options' => array($ids["state_id"]=>array('selected'=>true)),'class' => 'span6')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'state_id'); ?>
                    </span>
                </div>
	</div>
        
        <div class="control-group">
             <?php 
                $regionlist = array();
                if(isset($model->state_id))
                {
                   $regionlist = CHtml::listData(RegionLocale::getRegionList($model->state_id),'region_id', 'region_name');
                }
                ?>
            
		<?php echo $form->labelEx($model,'region_id',array('class'=>'control-label')); ?>
		<div class="controls"><?php echo $form->dropDownList($model,'region_id',$regionlist,array('prompt'=>'--Select Region--',
                     'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('city/ajaxgetcity'),
                            'update' => '#User_city_id',
                            'data' => array('region_id'=>'js:this.value')),
                    'options' => array($ids["state_id"]=>array('selected'=>true)),'class' => 'span6')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'region_id'); ?>
                    </span>
                </div>
	</div>

        <div class="control-group">
            <?php 
                $citylist = array();
                if(isset($model->{Globals::FLD_NAME_REGION_ID}))
                {
                   $citylist = CHtml::listData(City::getCityList($model->{Globals::FLD_NAME_REGION_ID}),'city_id', 'city_name');
                }
            ?>
            
		<?php echo $form->labelEx($model,'city_id',array('class'=>'control-label')); ?>
		<div class="controls"><?php echo $form->dropDownList($model,'city_id',$citylist,array('prompt'=>'--Select City--','class' => 'span6')); ?>
                    <span class="help-inline">
                        <?php echo $form->error($model,'city_id'); ?>
                    </span>
                </div>
	</div>
	
        
	
        <div class="control-group">
            <?php echo $form->labelEx($model,'zip_code',array('class'=>'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model,'zip_code',array('class'=>'span6','size'=>20,'maxlength'=>20,)); ?>
                    <span class="help-inline"><?php echo $form->error($model,'zip_code'); ?></span>

            </div>
        </div>
    
	<div class="control-group">
			<?php echo $form->label($model,'user_status'); ?>
			<div class="controls">
				<?php echo $form->radioButtonList($model, 'user_status',array('1'=>'Active','0'=>'In-Active'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
				
				

				<?php //echo $form->dropdownList($model,'state_status',array('0'=>'InActive','1'=>'Active'),array('class'=>'span6')); ?>
				<span class="help-inline"><?php echo $form->error($model,'user_status'); ?></span>
			</div>
		</div>

	
<!--	<div class="row">
		<?php echo $form->labelEx($model,'user_image'); ?>
		<?php echo $form->textField($model,'user_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_video'); ?>
		<?php echo $form->textField($model,'user_video',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_video'); ?>
	</div>-->

	<div class="controls">
			<div class="span2">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'btn blue')); ?>
				<?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
			</div>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>