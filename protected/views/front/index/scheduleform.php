<?php 
$setDisableAll = false;
$setDisableDays = false;
$setDisable = false;
$daysListDisplay = 'none';
$countSchedule=0;

$checkAllDays=false;
$checkSelectedDays=false;

$disableMonday = '';
$disableTuesday = '';
$disableWednesday = '';
$disableThursday = '';
$disableFriday = '';
$disableSaturday = '';
$disableSunday = '';

$checkedMonday = '';
$checkedTuesday = '';
$checkedWednesday = '';
$checkedThursday = '';
$checkedFriday = '';
$checkedSaturday = '';
$checkedSunday = '';
$vall='';
if(isset($model->prefereces_setting) && !empty($model->prefereces_setting))
{
    $vall = json_decode($model->prefereces_setting);
    if(isset($vall->work_hrs))
    {
            foreach ($vall->work_hrs as $index => $schedule)
            {
                if($index != $schedule_id )
                {
                    foreach($schedule as $day)
                    {
                       if($day->day=='mon')
                       {
                           $disableMonday = 'disabled';
                           $checkedMonday = 'checked';
                       }
                       if($day->day=='tue')
                       {
                           $disableTuesday = 'disabled';
                           $checkedTuesday = 'checked';
                       }
                       if($day->day=='wed')
                       {
                           $disableWednesday = 'disabled';
                           $checkedWednesday = 'checked';
                       }
                       if($day->day=='thu')
                       {
                           $disableThursday = 'disabled';
                            $checkedThursday = 'checked';
                       }
                       if($day->day=='fri')
                       {
                           $disableFriday = 'disabled';
                           $checkedFriday = 'checked';
                       }
                       if($day->day=='sat')
                       {
                           $disableSaturday = 'disabled';
                           $checkedSaturday = 'checked';
                       }
                       if($day->day=='sun')
                       {
                           $disableSunday = 'disabled';
                           $checkedSunday = 'checked';
                       }
                    }
                    
                    
                }
                else 
                {
                    $countSchedule =  count($schedule);
                    
                    foreach($schedule as $day)
                    {
                       $time = $day->hrs;
                       if($day->day=='mon')
                       {
                           $disableMonday = '';
                           $checkedMonday = 'checked';
                       }
                       if($day->day=='tue')
                       {
                           $disableTuesday = '';
                           $checkedTuesday = 'checked';
                       }
                       if($day->day=='wed')
                       {
                           $disableWednesday = '';
                           $checkedWednesday = 'checked';
                       }
                       if($day->day=='thu')
                       {
                           $disableThursday = '';
                            $checkedThursday = 'checked';
                       }
                       if($day->day=='fri')
                       {
                           $disableFriday = '';
                           $checkedFriday = 'checked';
                       }
                       if($day->day=='sat')
                       {
                           $disableSaturday = '';
                           $checkedSaturday = 'checked';
                       }
                       if($day->day=='sun')
                       {
                           $disableSunday = '';
                           $checkedSunday = 'checked';
                       }
                    }
                }
            }
            if($countSchedule==7)
            {
                $setDisableAll = true;
                $setDisableDays = true;
                $setDisable = true;
                $checkAllDays=true;
            }
            elseif($countSchedule>=1)
            {
                $setDisableAll = true;
                $setDisableDays = false;
                $daysListDisplay = 'block';
                $checkSelectedDays=true;
            }
            if( $disableMonday == true   && $disableTuesday == true && $disableWednesday == true &&
                $disableThursday == true && $disableFriday == true  && $disableSaturday == true  &&
                $disableSunday == true  )
            {
                  $setDisable = true;   
            }
    }
}
//echo '<pre>';
//echo $schedule_id;
//print_r($vall->work_hrs);
//$time = $vall->work_hrs[$schedule_id][0]->hrs;
$time = explode('-', $time);
$startTime= $time[0];
$endTime= $time[1];
?>
<div class="controls-row">
    <div class="span4 nopadding">
        <label><?php echo Yii::t('index_scheduleform','set_work_hours_text')?></label>
        <div class="span2 nopadding"><?php
                 $this->widget('application.extensions.timepicker.JTimePicker', array(
                        'model'=>$model,
                         'attribute'=>'start_time',
                         // additional javascript options for the date picker plugin
                         'options'=>array(
                                 'showPeriod'=>false,
                                 ),
                         'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'Start time','value'=>$startTime,'class'=>'span2','onblur'=>'checkRadio();'),
                 ));
                ?>
                <span id="User_start_time_em_" class="help-block error" style="display: none"></span>
        </div>
        <div class="span2 nopadding">
        <?php
         $this->widget('application.extensions.timepicker.JTimePicker', array(
                'model'=>$model,
                 'attribute'=>'end_time',
                 // additional javascript options for the date picker plugin
                 'options'=>array(
                         'showPeriod'=>false,
                         ),
                 'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'End time','value'=>$endTime,'class'=>'span2','onblur'=>'checkRadio();'),
         ));
        ?>
        <span id="User_end_time_em_" class="help-block error" style="display: none"></span>        </div>
    </div>
    <div class="span4 nopadding">
        <label for="User_select_days"><?php echo Yii::t('index_scheduleform','select_work_day_text')?></label>
       <div class="spanweek">  <label class="radio">
            <input type="radio" name="User[select_days]" value="all" id="User_select_days_0" onchange="weekDays(this.value);"  <?php  echo 'disabled' ?>    >
          	<?php echo Yii::t('index_scheduleform','all_work_day_text')?>
        </label></div>
       <div class="spanweek">  <label class="radio">
            <input type="radio" name="User[select_days]" value="days" id="User_select_days_1" onchange="weekDays(this.value);" <?php  echo 'checked' ?>   >
            <?php echo Yii::t('index_scheduleform','select_day_text')?>
        </label></div>

        <span id="User_select_days_em_" class="help-block error" style="display: none"></span>
    </div>
</div>
<div class="controls-row">

    <div class="span6  nopadding weekdays" style="display: block">  
        <table width="100%" class="">
            <tr>
                <td>
                     <input id="User_hidden_schedule" type="hidden" name="User[schedule_id]" value="<?php echo $schedule_id ?>">
                    <label for="User_mon"><?php echo Yii::t('index_scheduleform','monday_text')?></label>
                    <input id="ytUser_mon" type="hidden" name="User[mon]" value="0">
                    <input id="User_mon" type="checkbox" value="1" name="User[mon]" <?php echo $checkedMonday ?> <?php echo $disableMonday ?>>
                </td>
                <td>
                    <label for="User_tue"><?php echo Yii::t('index_scheduleform','tuesday_text')?></label>
                    <input id="ytUser_tue" type="hidden" name="User[tue]" value="0">
                    <input id="User_tue" type="checkbox" value="1" name="User[tue]" <?php echo $disableTuesday ?> <?php echo $checkedTuesday ?>>
                </td>
                <td>
                    <label for="User_wed"><?php echo Yii::t('index_scheduleform','wednesday_text')?></label>
                    <input id="ytUser_wed" type="hidden" name="User[wed]" value="0">
                    <input id="User_wed" type="checkbox" value="1" name="User[wed]" <?php echo $disableWednesday ?> <?php echo $checkedWednesday ?> >
                </td>
                <td>
                    <label for="User_thu"><?php echo Yii::t('index_scheduleform','thursday_text')?></label>
                    <input id="ytUser_thu" type="hidden" name="User[thu]" value="0">
                    <input id="User_thu" type="checkbox" value="1" name="User[thu]" <?php echo $disableThursday ?> <?php echo $checkedThursday ?> >
                <td>
                    <label for="User_fri"><?php echo Yii::t('index_scheduleform','friday_text')?></label>
                    <input id="ytUser_fri" type="hidden" name="User[fri]" value="0">
                    <input id="User_fri" type="checkbox" value="1" name="User[fri]" <?php echo $disableFriday ?> <?php echo $checkedFriday ?> >
                </td>
                <td>
                    <label for="User_sat"><?php echo Yii::t('index_scheduleform','saturday_text')?></label>
                    <input id="ytUser_sat" type="hidden" name="User[sat]" value="0">
                    <input id="User_sat" type="checkbox" value="1" name="User[sat]" <?php echo $disableSaturday ?> <?php echo $checkedSaturday ?> >
                </td>
                <td>
                    <label for="User_sun"><?php echo Yii::t('index_scheduleform','sunday_text')?></label>
                    <input id="ytUser_sun" type="hidden" name="User[sun]" value="0">
                    <input id="User_sun" type="checkbox" value="1" name="User[sun]" <?php echo $disableSunday ?> <?php echo $checkedSunday ?> >
                </td>
            </tr>
        </table>
        
    </div>
    <div class="span2  nopadding " >  
                                               <span id="User_mon_em_" class="help-block error" style="display: none"></span>
                                            </div>
</div>