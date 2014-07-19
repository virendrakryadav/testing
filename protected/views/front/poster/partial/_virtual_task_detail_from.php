<script>
$(document).ready(function(){
$('.controls .form-control').on('keyup',function(){
    $('#pageleavevalidation').val("done");
  });

});
</script> 
    <?php echo CommonScript::errorMsgDisplay() ?>
<?php echo CommonScript::errorMsgDisplay(".input-group .form-control") ?>
<?php Yii::import('ext.chosen.Chosen'); ?>
<?php
$repeat = empty($repeat) ? 0 : $repeat;
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlengthafter = $totelstringlength - $srtlength; 
$category_id ='';
if(isset($editTaskPartials['category_id']))
        $category_id = $editTaskPartials['category_id'];
?>
<?php echo CommonScript::loadRemainingCharScript('Task_description', 'wordcountPosterComments', $totelstringlength) ?>

<input id="categoryIdHidden" type="hidden" name="category_id_value" value="<?php echo $category_id ?>" >

<div onclick="$('#validationErrorMsg').parent().fadeOut();" style="display: none" class="alert alert-danger fade fade-in-alert">
    <button onclick="$('#validationErrorMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
    <div id="validationErrorMsg" >

    </div>
    
</div>
<!--Project details Start here-->
  <div class="panel panel-default margin-bottom-20 sky-form">
    <div class="panel-heading">
      <h4 class="panel-title1">
          <a data-toggle="collapse" class="collapsed2" data-parent="#accordion" 
          href="#collapseOne">
          <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_projects_details')); ?><span class="color-red">*</span>
          <span class="accordian-state"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in sky-form ">
      <div class="panel-body">

<div class="col-md-6 no-mrg">

<div class="col-md-11 no-mrg3">
<div class="inline-group">
<label class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_visibility')); ?><span class="required">*</span></label>
<?php //$payment_mode = array('1' => CHtml::encode(Yii::t('poster_createtask', 'txt_public_visible_to_everyone')), '0' => CHtml::encode(Yii::t('poster_createtask', 'txt_private_only_candidates_i_invite_can_respond'))); ?>
                 
<?php //echo $form->radioButtonControlGroup($task, Globals::FLD_NAME_IS_PUBLIC, $payment_mode); ?>                   
<?php // echo CHtml::error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
                  

<label class="radio"><input type="radio" tabindex="0" id="Task_is_public" <?php if($task->{Globals::FLD_NAME_IS_PUBLIC} == 1) echo 'checked' ?> name="<?php echo Globals::FLD_NAME_TASK ?>[<?php echo Globals::FLD_NAME_IS_PUBLIC ?>]" value="1"><i class="rounded-x"></i><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_public')); ?></label>
<label class="radio"><input type="radio" id="Task_is_private" <?php if($task->{Globals::FLD_NAME_IS_PUBLIC} == 0) echo 'checked' ?> name="<?php echo Globals::FLD_NAME_TASK ?>[<?php echo Globals::FLD_NAME_IS_PUBLIC ?>]" value="0"><i class="rounded-x"></i><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_private')); ?></label>
<?php echo $form->error($task, Globals::FLD_NAME_IS_PUBLIC,array('class' => 'invalid')); ?>
</div>
</div>
    
<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posting_type')); ?></label>
<div class="col-md-12 no-mrg">
<div class="col-md-3 no-mrg">
    <?php 
    $isPremiumName = Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_IS_PREMIUM_TASK."]";
    $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
'name' => $isPremiumName,
        'value' => $task->{Globals::FLD_NAME_IS_PREMIUM_TASK}
));?>
</div>
<!--    <button class="btn btn-lg btn-default">Basic</button>
    <button class="btn btn-lg active btn-primary">Premium</button>-->
<div class="no-mrg switch-label">
   
    <label class="radio"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_premium_posting')); ?></label>
    
</div>
</div>
</div>
    <div class="col-md-11 no-mrg2">
<div class="col-md-12 no-mrg">
<div class="col-md-3 no-mrg">
    <?php 
    $isHihglight = Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_IS_HIGHLIGHTED."]";
    $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
'name' => $isHihglight,
        'value' => $task->{Globals::FLD_NAME_IS_HIGHLIGHTED}
));?>
</div>
<div class="no-mrg switch-label">
   
    <label class="radio"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_highlighted_search_result')); ?></label>
    
</div>
</div>

</div>

    
    
<div class="col-md-11 no-mrg2">

<?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_TITLE, 
        array('class' => 'form-control','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_title')), 
            'label' => 'Project Title','labelOptions' => array('class' => 'text-size-18' ), )); ?>
<!--<input type="email" placeholder="Organizing my contacts" class="form-control ">-->
</div>
<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_completion')); ?><span class="required">*</span></label>
<!--<div class="col-md-6 no-mrg">
   
   
       <?php
//                        $date = '';
//                        $minDate = Globals::DEFAULT_VAL_DATE_START_FROM;
//                        if (isset($task->{Globals::FLD_NAME_TASK_START_DATE})) {
//                            $date = $task->{Globals::FLD_NAME_TASK_START_DATE};
//                           // $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
//                         //   $minDate = $date;
//                        }
                        ?>
    <div class="control-group ">
          
           <div class="controls">
                <?php 
                
//                $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
//                'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_START_DATE.']',
//                    'value' => $date,
//                'pluginOptions' => array(
//                'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
//                        'startDate' => $minDate,
//                ),
//                    'htmlOptions' => array(
//                                        'class' => 'form-control',
//                                            'onkeydown' => 'return false',
//                                        'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_start')),
//                                        'readonly' => false,
//                                         //  'disabled'=>$is_public, 
//                                        ),
//                ));
                ?>
                <?php echo $form->error($task, Globals::FLD_NAME_TASK_START_DATE,array('class' => 'invalid')); ?>
           </div>
       </div>
   
</div>-->
<div class="col-md-12 no-mrg">
    <?php
        $date = '';
        $minDateEnd =  Globals::DEFAULT_VAL_DATE_START_FROM;
        if (isset($task->{Globals::FLD_NAME_TASK_END_DATE})  && $repeat == 0) {
            $date = $task->{Globals::FLD_NAME_TASK_END_DATE};
          //  $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
           // $minDateEnd = $date;
//            if( $is_public == true)
//            {
//                $minDateEnd = $date;
//            }
        }
        ?>
       <div class="control-group ">
          
           <div class="controls">
               <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                        'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_END_DATE.']',
                        'value' => $date,
                        'pluginOptions' => array(
                        'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
                        'startDate' => $minDateEnd,
                      ),
                          'htmlOptions' => array(
                                              'class' => 'form-control',
                                           'onkeydown' => 'return false',
                                              'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_date')),
                                              //'readonly' => true,
                              // 'onclick' => ' $("#accordion").addClass("nottoperform");',
                              'onchange' => 'resetBidCloseDate();',
                               
                                               //  'disabled'=>$is_public, 
                                              ),
                      ));
                ?>
    <?php echo $form->error($task, Globals::FLD_NAME_TASK_END_DATE,array('class' => 'invalid')); ?>
           </div>
       </div>
    
<?php
//$this->widget(
//'yiiwheels.widgets.timepicker.WhTimePicker',
//array(
//'htmlOptions' => array('class' => 'form-control',
//                                'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'End Time')),
//                        ),
//    'pluginOptions' => array('showMeridian' => false),
//'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_END_TIME.']',
//'value' => Globals::DEFAULT_VAL_TASK_END_TIME,
//
//)
//);
?>
   </div>
</div>


<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_bid_duration')); ?><span class="required">*</span></label>
<div class="col-md-12 no-mrg">
   
   
       
    <div class="control-group ">
          
        <div class="controls" id="task_bid_close_date_droop_down">
               <?php
//                        $date = '';
//                        $minDate = Globals::DEFAULT_VAL_DATE_START_FROM;
//                        if (isset($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE})) 
//                        {
//                            $date = $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE};
//                            $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH, $date);
//                         //   $minDate = $date;
//                        }
                        ?>
                <?php 
//                $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
//                'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_BID_CLOSE_DATE.']',
//                    'value' => $date,
//                'pluginOptions' => array(
//                'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
//                        'startDate' => $minDate,
//                ),
//                    'htmlOptions' => array(
//                                        'class' => 'form-control',
//                                           // 'onkeydown' => 'return false',
//                                        'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Bid Close Date')),
//                                        'readonly' => false,
//                                         //  'disabled'=>$is_public, 
//                                        ),
//                ));
                ?>
                <?php
                        $date = '';
                        $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        if ($task->{Globals::FLD_NAME_BID_DURATION} && $repeat == 0) 
                        {
                            $date = $task->{Globals::FLD_NAME_BID_DURATION};
                            $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
                        }
                            
                        $bidDuration = array();
                        //$bidDuration = Globals::getbidDurationArray();
                        if($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE} && $repeat == 0)
                        {
                            $timeDifference = CommonUtility::differenceBitweenTwoDates($task->{Globals::FLD_NAME_CREATED_AT},  $task->{Globals::FLD_NAME_TASK_END_DATE});
                            if( $timeDifference['days'] < 7 && $timeDifference['months'] == 0 )
                            {
                                $bidDuration = Globals::getbidDurationArray('day');
                            }
                            elseif( $timeDifference['days'] < 15 && $timeDifference['months'] == 0  )
                            {
                                $bidDuration = Globals::getbidDurationArray('week');
                            }
                            elseif( $timeDifference['days'] < 30 && $timeDifference['months'] == 0  )
                            {
                                $bidDuration = Globals::getbidDurationArray('hmonth');
                            }
                            elseif( $timeDifference['months'] >= 1  )
                            {
                               // $bidDuration = Globals::getbidDurationArray('hmonth');
                                $bidDuration = Globals::getbidDurationArray();
                            }
                        }

                        echo $form->dropDownList($task, Globals::FLD_NAME_BID_DURATION, $bidDuration, array(
                           // 'disabled'=>$is_public,
                            'empty' => Yii::t('poster_createtask','txt_task_select_bid_duration'),
                               //'options' => array('1 day' => array('disabled' => true),'15 days' => array('disabled' => true)),
                            'onchange'=>'getBidCloseDate(this.value , "#taskBidCloseDate")',
                            'class' => 'form-control'));
                        ?>
                <?php echo $form->error($task, Globals::FLD_NAME_BID_DURATION); ?>
                <?php //echo $form->error($task, Globals::FLD_NAME_TASK_BID_CLOSE_DATE,array('class' => 'invalid')); ?>
           </div>
        <div class="col-md-9 mrg text-size-12" id="taskBidCloseDateContainer" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID}) && $repeat == 0 ) echo 'block'; else echo 'none' ?>">Bid close date   
           <input type="hidden" name="dateselected" id="dateselected" value='<?php 
            if(isset($task->{Globals::FLD_NAME_TASK_ID}) && $repeat == 0) 
                { 
                echo date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime($task->{Globals::FLD_NAME_CREATED_AT}));
                
                }  ?>' >
            <span id="taskBidCloseDate" ><?php if($repeat == 0) echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}); ?> <?php if($repeat == 0) echo CommonUtility::formatedViewTime($task->{Globals::FLD_NAME_END_TIME}); ?></span>
</div>
       </div>
   
</div>

</div>

</div>

<div class="col-md-6 no-mrg">

<div class="col-md-11 no-mrg4">
<div class="inline-group">
<label class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_project_description')); ?><span class="required">*</span></label>
<div id="categoryTemplates">
<?php 
if(isset($editTaskPartials['template']))
{
    echo $editTaskPartials['template'];
}
?>
</div>
<?php
echo $form->textAreaControlGroup($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 7, 
                                'labelOptions' => array('label' => false ), 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 

?>

<div id="wordcountPosterComments" class="col-md-12 no-mrg right-align"><?php
				
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                
                                echo $totelstringlengthafter;
				
				?></div>

</div>
</div>
<div class="col-md-12 no-mrg2">
<label for="exampleInputEmail1" class="text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_estimated_project_price')); ?></label>
<div class="col-md-12 estimated-cont">
<div class="grad-box margin-top-bottom-30 vtabprice no-border">
<div id="selectPriceMode" class="vtab2">
<ul>
    <li><a id="selectPriceModeHourly" class="<?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} != Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'active' ?>" href="javascript:void(0)" onclick="setPriceMode('<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY ?>')"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_hourly')); ?></a></li> 
<li><a id="selectPriceModeFixed" href="javascript:void(0)" class="<?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'active' ?>" onclick="setPriceMode('<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE ?>')"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_fixed')); ?></a></li>
</ul>
</div>
<div class="clr"></div>
</div>
    <?php 
    if(!isset($task->{Globals::FLD_NAME_PAYMENT_MODE}))
    {
        $task->{Globals::FLD_NAME_PAYMENT_MODE} = Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY;
    }
    else 
    {
        $task->{Globals::FLD_NAME_PAYMENT_MODE} = $task->{Globals::FLD_NAME_PAYMENT_MODE};
    }
?>
<?php echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE); ?>
    <section class="mrg-botton-13">
<div class="row">
<label class="label colsspace col-4"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_price_range')); ?><span class="required">*</span></label>
<div class="col col-8">
<div class="input-group col-md-5 f-left " >
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
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_MIN_PRICE, array('class'=>'form-control text-align-right' , 'onkeyup' => 'estimatedCost();')); ?>
<!--<b class="tooltip tooltip-bottom-right">Min Price</b>-->
</div>
<div class="col-md-2 f-left2">To</div>
<div class="input-group col-md-5 f-left ">
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = intval($task->{Globals::FLD_NAME_TASK_MAX_PRICE});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_MAX_PRICE, array('class'=>'form-control text-align-right','onkeyup' => 'estimatedCost();')); ?>
<!--<b class="tooltip tooltip-bottom-right">Max Price</b>-->
</div>

</div>
<div class="col-md-13 no-mrg right-align"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_minimum_of')); ?> $<span id="min_price_msg">0</span></div>
</div>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_MIN_PRICE,array('class' => 'invalid')); ?>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_MAX_PRICE,array('class' => 'invalid')); ?>
</section>


    <section id="for_fixed_price_mode" style="display : <?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'none' ?>">
<div class="row">
<label class="label colsspace col-7"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_extimated_hours_per_week')); ?> </label>
<div class="col col-5">
<div class="input-group col-md-12 f-right" >
    <?php 
    if(!isset($task->{Globals::FLD_NAME_WORK_HRS}))
    {
        $task->{Globals::FLD_NAME_WORK_HRS} = Globals::DEFAULT_VAL_WORK_HRS;
    }
    else if($task->{Globals::FLD_NAME_WORK_HRS} > Globals::DEFAULT_VAL_MIN_WORK_HRS)
    {
        $task->{Globals::FLD_NAME_WORK_HRS} = intval($task->{Globals::FLD_NAME_WORK_HRS});
    }
    else
    {
         $task->{Globals::FLD_NAME_WORK_HRS} = Globals::DEFAULT_VAL_MIN_WORK_HRS;
    }
?>
    <?php echo $form->textField($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'form-control rounded text-align-right', 'max' => 2, 'onkeyup' => 'estimatedCost();',)); ?>
<?php //echo $form->textFieldControlGroup($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'form-control rounded ', 'max' => 2, 'onkeyup' => 'estimatedCost();','labelOptions' => array('label' => false ))); ?>

<!--<input type="text" class="form-control">-->
</div>
</div>
</div>
        <?php echo $form->error($task, Globals::FLD_NAME_WORK_HRS,array('class' => 'invalid')); ?>
</section>

    <section class="mrg-botton-5">
<div class="row">
<label class="label colsspace2 col-7"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_expected_expenses')); ?> <br/><span class="text-size-11"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_stamps_tickets')); ?></span></label>
<div class="col col-5">
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
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_CASH_REQUIRED, array('class'=>'form-control text-align-right','onkeyup' => 'estimatedCost();')); ?>

</div>
</div>
</div>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_CASH_REQUIRED,array('class' => 'invalid')); ?>
</section>


<section>
<div class="row">
<label class="label colsspace col-4"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_estimated_cost')); ?></label>
<div class="col col-8">
<div class="input-group col-md-12 f-left" >
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>

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
<div id="task_price_display_total" class="budget-box form-control text-align-right"><?php echo $task->{Globals::FLD_NAME_PRICE}; ?></div>
<?php echo $form->hiddenField($task, Globals::FLD_NAME_PRICE, array('class'=>'form-control text-align-right' , 'onkeyup' => 'estimatedCost();' , 'readonly' => true)); ?>

</div>
</div>
</div>
</section>

</div>
</div>


</div>

      </div>
    </div>
  </div>
  
  <!--Doer details Start here-->
  <div class="panel panel-default margin-bottom-20 sky-form">
    <div class="panel-heading">
      <h4 class="panel-title1">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseTwo" class="collapsed" >
          <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_doer_details')); ?>
          <span class="accordian-state"></span>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse sky-form">
      <div class="panel-body">
    <div class="col-md-5 no-mrg">

<div class="col-md-11 no-mrg3">
    <div class="inline-group">
<label class="label text-size-18"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_doer_location')); ?></label>
<div class="col col-4 no-mrg">
      <?php
      $locationList = "";
$locations = array();
$taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] = '';
$taskSelectedLocations = CommonUtility::getTaskPreferredLocations($task->{Globals::FLD_NAME_TASK_ID});

//print_r($taskSelectedLocations);
if($taskSelectedLocations)
{
    if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
    {
        $locations = CommonUtility::getCountryList();

        $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
    }
    
    $locationList = $taskSelectedLocations[Globals::FLD_NAME_LOCATIONS];
}
else
{
    $taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] = '';
}
$locations = CommonUtility::getCountryList();
   
?>
<label class="radio"><input type="radio" <?php 
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{
    if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] != Globals::DEFAULT_VAL_C) echo 'checked';
}
else
{
    echo 'checked';
}
?>  onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>');" value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Anywhere</label>
<label class="radio"><input type="radio" <?php 
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{
    if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C) echo 'checked';
}
?> value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>"  onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>');" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Country</label>
</div>
<div id="selectCountryLocation" class="col-md-10 no-mrg3" style="display: <?php 
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{
   if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C) echo 'block'; else echo 'none';
}
else 
{
    echo 'none';
}
 ?>">
<?php
                                 
$placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS, $locationList, $locations, array(
                            'data-placeholder' => $placeholder,
                            'options' => array(
                                'displaySelectedOptions' => false,
                                ),
                                'class'=>'form-control'
                        ));
?>
</div>
</div>
<!--<div class="inline-group">
<label class="label text-size-18">Doer Location</label>
<div class="col col-4 no-mrg">
                
<label class="radio"><input type="radio" <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] != Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'checked' ?> onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>');" value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Anywhere</label>
<label class="radio"><input type="radio" value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>" <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'checked' ?> onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>');" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Country</label>
</div>
<div id="selectCountryLocation" class="col-md-10 no-mrg3" style="display: <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'block'; else echo 'none'; ?>">
<?php
//$locationList = "";
//$locations = array();
//
//$taskSelectedLocations = CommonUtility::getTaskPreferredLocations($task->{Globals::FLD_NAME_TASK_ID});
////print_r($taskSelectedLocations);
//if($taskSelectedLocations)
//{
//    if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
//    {
//        $locations = CommonUtility::getCountryList();
//
//        $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
//    }
//    
//    $locationList = $taskSelectedLocations[Globals::FLD_NAME_LOCATIONS];
//}
//$locations = CommonUtility::getCountryList();
//                                    
//$placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
//echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS, $locationList, $locations, array(
//                            'data-placeholder' => $placeholder,
//                            'options' => array(
//                                'displaySelectedOptions' => false,
//                                ),
//                                'class'=>'form-control'
//                        ));
?>
</div>
</div>-->
</div>

</div>
          
         

<div  id="getskills">
<?php 
if(isset($editTaskPartials['skills']))
{
    echo $editTaskPartials['skills'];
}
?>
              
</div>

<div id="getQuestions" class="col-md-12 no-mrg">
<?php 
if(isset($editTaskPartials['questions']))
{
    echo $editTaskPartials['questions'];
}
?>
</div>
    </div>
    </div>
    </div>
  <!--Doer details Ends here-->
  
  <!--Project details Ends here-->
    <div class="panel panel-default margin-bottom-20 sky-form">
    <div class="panel-heading">
      <h4 class="panel-title1">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseFour"  class="collapsed">
          <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_attachments')); ?>
          <span class="accordian-state"></span>
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse sky-form">
    <div class="panel-body">
    <div class="col-md-12 no-mrg">

      <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                            <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio" class="upload-img2" style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; else
                            echo 'none';
                        ?> ">
                                 <?php
                                 if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                                     echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name ,$task->{Globals::FLD_NAME_TASK_ID});
                                 }
                                 ?>
                        </div>
          <div class="clr-padding-upload"></div>

                    </div>
</div>

          
         
    </div>
    </div>
    </div>
  

    

<?php //$this->endWidget(); ?>
