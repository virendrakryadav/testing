<?php
/* @var $this BlockedIpController */
/* @var $model BlockedIp */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'search-form',
        
)); ?>
        <div class="span2">
            <div class="control-group">
                <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_ADDRESS,array('class'=>'control-label')); ?>
                <div class="controls"> 
                <?php CommonUtility::autocomplete(Globals::FLD_NAME_BLOCKED_IP_ADDRESS,'blockedip/autocompleteipaddress',10,$fillFields,'span12',60,250);?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_START_DATE,array('class'=>'control-label')); ?>
                <div class="controls"> 
                <?php 
//                $start_dt = CommonUtility::createValue($fillFields,Globals::FLD_NAME_BLOCKED_IP_START_DATE);
//                $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'name' => 'Blockedip['.Globals::FLD_NAME_BLOCKED_IP_START_DATE.']',
//                        'value'=>$start_dt,
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'showAnim'=>'fold',
                             'changeMonth'=>true,
                             'changeYear'=>true,
//                              'minDate' => $minDate,
                                'onSelect'=> 'js:function( selectedDate ) {
                                        $( "#' . CHtml::activeId($model, Globals::FLD_NAME_BLOCKED_IP_END_DATE) . '" ).datepicker("option", "minDate", selectedDate); //set the end date cjuidatepiker minDate and its working fine
                                }',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'span12',
                            'onkeypress'=>'return false',
                            'onkeydown'=>'return false',
                            
                        ),
                    )); ?>
                </div>
            </div>
        </div>
    
        <div class="span2">
            <div class="control-group">
                <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_END_DATE,array('class'=>'control-label')); ?>
                <div class="controls"> 
                <?php 
//                $end_dt = CommonUtility::createValue($fillFields,Globals::FLD_NAME_BLOCKED_IP_END_DATE);
//                $minDateEnd = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH); 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'name' => 'Blockedip['.Globals::FLD_NAME_BLOCKED_IP_END_DATE.']',
//                        'value'=>$end_dt,
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'showAnim'=>'fold',
                             'changeMonth'=>true,
                             'changeYear'=>true,
//                              'minDate' => $minDateEnd,
                                'onSelect'=> 'js:function( selectedDate ) {
                                        $( "#' . CHtml::activeId($model, Globals::FLD_NAME_BLOCKED_IP_END_DATE) . '" ).datepicker("option", "minDate", selectedDate); //set the end date cjuidatepiker minDate and its working fine
                                }',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'span12',
                            'onkeypress'=>'return false',
                            'onkeydown'=>'return false',
                            
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_REASON,array('class'=>'control-label')); ?>
                    <div class="controls"> 
                    <?php echo $form->textField($model,Globals::FLD_NAME_BLOCKED_IP_REASON,array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,Globals::FLD_NAME_BLOCKED_IP_REASON))); ?>
                    </div>
            </div>            
        </div>
        <div class="span2">
                <div class="control-group">
                        <?php echo $form->label($model,Globals::FLD_NAME_BLOCKED_IP_STATUS,array('class'=>'control-label','label'=>'Status')); ?>
                        <div class="controls"> 
                        <?php echo UtilityHtml::getStatusDropdownAandN($model,Globals::FLD_NAME_BLOCKED_IP_STATUS, CommonUtility::createValue($fillFields,Globals::FLD_NAME_BLOCKED_IP_STATUS)); ?>
                        </div>
                </div>
         </div>
	<div class="span2 topspace">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton('Reset', array('id'=>'form-reset-button','class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->