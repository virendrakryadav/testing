<?php Yii::import('ext.chosen.Chosen'); ?>
<script>
$(document).ready(function(){
$('.controls .form-control').on('keyup',function(){
    $('#pageleavevalidation').val("done");
  });
                                   
});
</script> 
<?php echo CommonScript::errorMsgDisplay() ?>
<?php // echo CommonScript::errorMsgDisplay(".row .help-block") ?>

<?php
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlength = $totelstringlength-$srtlength;       
$category_id ='';
if(isset($editTaskPartials['category_id']))
            $category_id = $editTaskPartials['category_id'];
?>
<?php echo CommonScript::loadRemainingCharScript('Task_description', 'wordcountPosterComments', $totelstringlength) ?>
<input id="categoryIdHidden" type="hidden" name="category_id_value" value="<?php echo $category_id ?>" >
<div style="display: none" onclick="$('#validationErrorMsg').parent().fadeOut();" class="alert alert-danger fade in">
   <button onclick="$('#validationErrorMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
    <div id="validationErrorMsg" >

    </div>
    
</div>
<!--Choose a Category and Subcategory Start here-->
<div class="margin-bottom-30 <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo ' mrg-auto5' ?>">
<!--Instant Project details Start here-->
  <div class="panel panel-default margin-bottom-20 sky-form">
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">

<div class="col-md-6 no-mrg sky-form">

<div class="col-md-11 no-mrg3">
<label for="exampleInputEmail1" class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_completion')); ?><span class="required">*</span></label>
<div class="col-md-6 no-mrg">
    <?php 
    if(!isset($task->{Globals::FLD_NAME_END_TIME}))
    {
        $hoursSelected = '';
    }
    else 
    {
        $hoursSelected = $task->{Globals::FLD_NAME_WORK_HRS};
      
    }
?>
    <?php
    $taskCompleteHours = Globals::taskCompleteHours();
      echo Chosen::dropDownList(Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_END_TIME.']', $hoursSelected, $taskCompleteHours,
            array('prompt'=>'Select Hours',
                'onchange'=>'getTaskCompleteTime(this.value , "#taskCompleteDateTime")','class' => 'form-control mrg5' ,'id'=>'Task_end_time'));
             ?>
       <?php echo $form->error($task, Globals::FLD_NAME_END_TIME,array('class' => 'invalid')); ?>
            <input type="hidden" name="dateselected" id="dateselected" value='<?php 
            if(isset($task->{Globals::FLD_NAME_TASK_ID})) 
                { 
                echo date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime($task->{Globals::FLD_NAME_CREATED_AT}));
                
                }  ?>' >
</div>
<div class="col-md-9 mrg text-size-12" id="taskCompleteDateTimeContainer" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>">Task Completed By  
    <span id="taskCompleteDateTime" ><?php 
  
    echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_END_DATE}); ?> <?php echo CommonUtility::formatedViewTime($task->{Globals::FLD_NAME_END_TIME}); ?></span>
</div>
</div>

<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_projects_notes')); ?><span class="required">*</span></label>
<div class="col-md-12 no-mrg">
<?php
echo $form->textAreaControlGroup($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 
                                'labelOptions' => array('label' => false ))); 

?>
<div id="wordcountPosterComments" class="col-md-12 no-mrg right-align"><?php
				
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                
                                echo $totelstringlength;
				
				?></div>
</div>
</div>


</div>

<div class="col-md-6 no-mrg sky-form">

  <div class="col-md-12 no-mrg2">
  <label for="exampleInputEmail1" class="text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_price')); ?></label>
<div class="col-md-12 estimated-cont pdn-top">
  <section>
  <div class="row">
<label class="label colsspace col-5"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_project_price')); ?><span class="required">*</span></label>
<div class="col col-7">
<div class="input-group col-md-12 f-left">
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_TASK_MIN_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_MIN_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_MIN_PRICE} = intval($task->{Globals::FLD_NAME_TASK_MIN_PRICE});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_MIN_PRICE, array('class'=>'form-control text-align-right' , 'onkeyup' => 'instantTaskTotalCost();' )); ?>

</div>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_MIN_PRICE,array('class' => 'invalid')); ?>
</div>
</div>
</section>



<section class="mrg-bottom">
<div class="row">
<label class="label colsspace2 col-5"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_required_expenses')); ?> <br/>
    <span class="text-size-11"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_stamps_tickets')); ?></span></label>
<div class="col col-7">
<div class="input-group col-md-12 f-left" >
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_CASH_REQUIRED} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_CASH_REQUIRED} = intval($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_CASH_REQUIRED, array('class'=>'form-control text-align-right' , 'onkeyup' => 'instantTaskTotalCost();')); ?>
</div>
    <?php echo $form->error($task, Globals::FLD_NAME_TASK_CASH_REQUIRED,array('class' => 'invalid')); ?>
</div>
</div>
</section>


<section>
  <div class="row">
<label class="label colsspace col-5"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_total_cost')); ?></label>
<div class="col col-7">
<div class="total-cast">
    <?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_PRICE} = intval($task->{Globals::FLD_NAME_PRICE});
    }
?>
<?php echo $form->hiddenField($task, Globals::FLD_NAME_PRICE, array('class'=>'form-control' )); ?>
    <?php 
    if(!isset($task->{Globals::FLD_NAME_TASK_MAX_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = intval($task->{Globals::FLD_NAME_TASK_MAX_PRICE});
    }
?>
<?php echo $form->hiddenField($task, Globals::FLD_NAME_TASK_MAX_PRICE, array('class'=>'form-control')); ?>
   <?php echo Globals::DEFAULT_CURRENCY ?><span id="instantTotalPrice" class="total-cast"><?php echo $task->{Globals::FLD_NAME_PRICE}  ?></span>

</div>
</div>
</div>
</section>

</div>
</div>


</div>

<div class="col-md-12 no-mrg sky-form">
<label class="label text-size-18" for="exampleInputEmail1"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_select_a_doer')); ?></label>


<div class="col-md-2 no-mrg">
    <?php 
    $isHasAuto = '0';
    if(isset($task->{Globals::FLD_NAME_SELECTION_TYPE}))
    {
        if($task->{Globals::FLD_NAME_SELECTION_TYPE} == Globals::FLD_NAME_AUTO )
        {
            $isHasAuto = '1';
        }
    }
    $isAuto = Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_AUTO."]";
    $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
        'name' => $isAuto,
        'value' => $isHasAuto,
        'events' => array( 'switch-change'=> 'function (e, data) { 
                                var $el = $(data.el) , value = data.value;
                                if(value)
                                {//this is true if the switch is on
                                    $(\'#view-map-instant\').hide();
                                }
                                else
                                {
                                    $(\'#view-map-instant\').show();
                                }
                            }'  )
      //  'switchChange'=> 'function (e, data) { alert(); }'
));?>
</div>
<div class="no-mrg switch-label">
   
    <label class="radio"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_auto_choice')); ?></label>
    
</div>




<div class="col-md-10 no-mrg3 text-size-12"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_allow_system_to_choose_doer')); ?></div>
</div>
          <div id="view-map-instant" style="display: <?php if($isHasAuto == 1 ) echo 'none'; else echo 'block'; ?> " >       
<?php $this->renderPartial('partial/_taskers_map_view' , array( 'users' => $users, 'model' => $model ,'task' => $task )); ?>
</div>
<?php  if(!isset($task->{Globals::FLD_NAME_TASK_ID})) 
{ 
    ?>
          <div class="col-md-12 no-mrg"><a href="javascript:void(0)" onclick="goToInperson()"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_switch_to_inperson_task')); ?></a></div>
    <?php
}
          ?>

</div>

      </div>
    </div>
  </div>
  <!--Instant Project details Ends here-->
  
  

<script type="text/javascript">
/*<![CDATA[*/
jQuery('#create-task-form').yiiactiveform({'attributes':[{'id':'Task_end_time','inputID':'Task_end_time','errorID':'Task_end_time_em_','model':'Task','name':'end_time','enableAjaxValidation':false,'inputContainer':'div.control-group','status':1,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)=='') {
	messages.push("Task completion time cannot be blank.");
}

}},{'id':'Task_description','inputID':'Task_description','errorID':'Task_description_em_','model':'Task','name':'description','enableAjaxValidation':false,'inputContainer':'div.control-group','status':1,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='') {
	
if(value.length<10) {
	messages.push(" Project description is too short (minimum is 10 characters).");
}

if(value.length>4000) {
	messages.push(" Project description is too long (maximum is 4000 characters).");
}

}


if(jQuery.trim(value)=='') {
	messages.push("Project description cannot be blank.");
}

}},{'id':'Task_min_price','inputID':'Task_min_price','errorID':'Task_min_price_em_','model':'Task','name':'min_price','enableAjaxValidation':false,'inputContainer':'div.control-group','status':1,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='') {
	
if(value.length>12) {
	messages.push(" Min price is too long (maximum is 12 characters).");
}

}


if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/)) {
	messages.push("Min price must be a number.");
}

if(value<0) {
	messages.push("Min price is too small (minimum is 0).");
}

}


if(jQuery.trim(value)=='') {
	messages.push("Min price cannot be blank.");
}

}},{'id':'Task_cash_required','inputID':'Task_cash_required','errorID':'Task_cash_required_em_','model':'Task','name':'cash_required','enableAjaxValidation':false,'inputContainer':'div.control-group','status':1,'clientValidation':function(value, messages, attribute) {

if(jQuery.trim(value)!='') {
	
if(value.length>12) {
	messages.push(" Expected expenses  is too long (maximum is 12 characters).");
}

}


if(jQuery.trim(value)!='') {
	
if(!value.match(/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/)) {
	messages.push("Expected expenses  must be a number.");
}

if(value<0) {
	messages.push("Expected expenses  is too small (minimum is 0).");
}

}

}}],'errorCss':'error'});
/*]]>*/
</script>