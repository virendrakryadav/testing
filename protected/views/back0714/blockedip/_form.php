<?php
/* @var $this BlockedIpController */
/* @var $model BlockedIp */
/* @var $form CActiveForm */
?>


<div class="wide form" style="padding:10px;">
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blocked-ip-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
            'validateOnChange' => true,
            ),
)); ?>
<div class="row-fluid form-horizontal">	
	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_BLOCKED_IP_ADDRESS,array('class'=>'control-label')); ?>
            <div class="controls">
		<?php echo $form->textField($model,Globals::FLD_NAME_BLOCKED_IP_ADDRESS,array('size'=>40,'maxlength'=>40,'class'=>'span6')); ?>
                <span class="help-inline">
		<?php echo $form->error($model,Globals::FLD_NAME_BLOCKED_IP_ADDRESS); ?>
                </span>
            </div>
	</div>      
        <div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_BLOCKED_IP_START_DATE,array('class'=>'control-label')); ?>
            <div class="controls">                    
                <?php  
                $start_dt = '';
                $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);  
                if(isset($model->{Globals::FLD_NAME_BLOCKED_IP_START_DATE}))
                {
                    $start_dt = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH ,strtotime($model->{Globals::FLD_NAME_BLOCKED_IP_START_DATE}));                    
                    $minDate = $start_dt;   
                }
                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'name' => 'Blockedip['.Globals::FLD_NAME_BLOCKED_IP_START_DATE.']',
                        'value'=>$start_dt,
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'showAnim'=>'fold',
                             'changeMonth'=>true,
                             'changeYear'=>true,
                              'minDate' => $minDate,
                                'onSelect'=> 'js:function( selectedDate ) {
                                        $( "#' . CHtml::activeId($model, Globals::FLD_NAME_BLOCKED_IP_END_DATE) . '" ).datepicker("option", "minDate", selectedDate); //set the end date cjuidatepiker minDate and its working fine
                                }',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'span6',
                            'onkeypress'=>'return false',
                            'onkeydown'=>'return false',
                            
                        ),
                    ));                                         
                    ?>
                <span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_BLOCKED_IP_START_DATE); ?></span>
            </div>
        </div> 
        
        <div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_BLOCKED_IP_END_DATE,array('class'=>'control-label')); ?>
            <div class="controls">                    
                <?php  
                
                $end_dt = '';
                $minDateEnd = $start_dt;  
                if(isset($model->{Globals::FLD_NAME_BLOCKED_IP_END_DATE}))
                {
                    $end_dt = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH ,strtotime($model->{Globals::FLD_NAME_BLOCKED_IP_END_DATE}));;   
//                    $minDateEnd = $end_dt;   
                }                               
                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(                        
                        'name' => 'Blockedip['.Globals::FLD_NAME_BLOCKED_IP_END_DATE.']',                         
                        'value'=>$end_dt,
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'showAnim'=>'fold',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                            'minDate' => $minDateEnd,
                            'onSelect'=> 'js:function( selectedDate ) {
                                    if($("#end_dt").val(selectedDate) > $("#start_dt").val())
                                    {
                                        return false;
                                    }
                                }',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'span6',
                            'onkeypress'=>'return false',
                            'onkeydown'=>'return false',
                            
                        ),
                    )); 
                    ?>
                <span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_BLOCKED_IP_END_DATE); ?></span>

            </div>
        </div>         	

	<div class="control-group">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_BLOCKED_IP_REASON,array('class'=>'control-label')); ?>
            <div class="controls">
		<?php echo $form->textField($model,Globals::FLD_NAME_BLOCKED_IP_REASON,array('size'=>60,'maxlength'=>2000,'class'=>'span6')); ?>
                <span class="help-inline">
		<?php echo $form->error($model,Globals::FLD_NAME_BLOCKED_IP_REASON); ?>
                </span>
            </div>
	</div>		      
        <div class="control-group">
            <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_STATUS,array('class'=>'control-label')); ?>
            <div class="controls">
		<?php echo $form->radioButtonList($model, Globals::FLD_NAME_BLOCKED_IP_STATUS,array('a'=>'Blocked','n'=>'Un-Blocked'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<span class="help-inline">
                    <?php echo $form->error($model,Globals::FLD_NAME_BLOCKED_IP_STATUS); ?>
                </span>
            </div>
	</div>
	<div class="controls">
            <div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'btn blue')); ?>
		<?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
            </div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->