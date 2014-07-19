<style>
    .privacy_span{
        width:20px;
    }
    .label_new{
        color: #686868;
        display: block;
        font-family: OpenSansRegular;
        font-size: 12px;
        font-weight: normal;
        margin-bottom: 5px;
    }
</style>

<div class="pro_tab">
<h2 class="h2"><?php echo Yii::t('index_setting','account_setting_text');?></h2>
<div id="yw2" class="tabs-above">
<div class="tab-content">
<div id="yw2_tab_1" class="tab-pane fade active in">
    <script>
        function weekDays(val)
        {
            //alert(val);
            if(val=='all')
            {
                $(".weekdays").css("display", "none");
            }
            else
            {
                $(".weekdays").css("display", "block");
            }
        }
        function checkRadio()
        {
            if($('#User_select_days_0').is(':checked')) 
            { 
                
                
            }
            else
            {
                $('#User_select_days_1').attr('checked', 'checked');
                $(".weekdays").css("display", "block");
            }
            $('.help-block').css('display', 'none');
            
            
        }
     
    </script>
    <script>
//         $('#User_start_time_em_').mouseover(function() {
//             
//             $('.help-block').css("display", "none");
//         });
        </script>
	<?php 
	/** @var BootActiveForm $form */
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'setting-form',
					'enableAjaxValidation' => false,
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
						//'validateOnChange' => true,
						//'validateOnType' => true,
					),
				));
				
				//$var = '{"contact_by":""c",'e','p'", "ref_check_by":"'c','e','p'", 
#     "create_team":"y","tax":"{"id":"123", "form":"1099","apply":"n"}", "work_hrs":"[{"day":"mon","hrs":"9-10,16-18"},{"day":"tue","hrs":"9-10,16-18"}]"}';
				//echo'<pre>';
				//print_r(json_decode($var));
				
				//{"contact_by":["c","e","p"],"ref_check_by":["c","e","p"],"work_hrs":{"day":"mon","hrs":"9-10"}}
				
				/*$contact_by[]='c';
				$contact_by[]='e';
				$contact_by[]='p';
				$work['day']='mon';
				$work['hrs']='9-10';
				$newarray['contact_by'] = $contact_by;
				$newarray['ref_check_by'] = $contact_by;
				$newarray['work_hrs'] = $work;*/
				//echo'<pre>';
				//print_r(json_encode($newarray));
				
				
				$contactbychat = '';
				$contactbyemail = '';
				$contactbyphone = '';
				$day = '';
				$starttime = '';
				$endtime = '';
                                $vall='';
				if(isset($model->{Globals::FLD_NAME_PREFERECES_SETTING}) && !empty($model->{Globals::FLD_NAME_PREFERECES_SETTING}))
				{
					$vall = json_decode($model->{Globals::FLD_NAME_PREFERECES_SETTING});
					
					
					//echo'<pre>';
					//print_r($vall);
//					$day = $vall->work_hrs->day;
//					$time = $vall->work_hrs->hrs;
//					$time = explode("-", $time);
//					$starttime = $time[0];
//					$endtime = $time[1];
					//echo $vall->contact_by[0];
					//echo count($vall->contact_by);
					/*
					if(isset($vall->contact_by[0]) && $vall->contact_by[0] == 'c')
					{
						$contactbychat = '1';
					}
					if(isset($vall->contact_by[1]) && $vall->contact_by[1] == 'e')
					{
						$contactbyemail = '1';
					}
					if(isset($vall->contact_by[2]) && $vall->contact_by[2] == 'p')
					{
						$contactbyphone = '1';
					}*/
					$totelPrivacy =  count($vall->contact_by);
					for($im=0;$im<$totelPrivacy;$im++)
					{
                                            if(isset($vall->contact_by[$im]))
                                            {
                                                if($vall->contact_by[$im] == 'c')
						{
							$contactbychat = '1';
						}
						if($vall->contact_by[$im] == 'e')
						{
							$contactbyemail = '1';
						}
						if($vall->contact_by[$im] == 'p')
						{
							$contactbyphone = '1';
						}
                                            }
					}
					
				}
				?>
				<div id="msgSetting" style="display:none" class="flash-success"></div>
                                <h4 class="bottom_border nomargin2"><?php echo Yii::t('index_setting','start_up_page_setting_text');?></h4>
				<div class="controls-row">
						<div class="span4 nopadding">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_STARTUP_PAGE,array('label'=>Yii::t('index_setting','startup_page_text'))); ?>
							<?php echo $form->dropDownList($model, Globals::FLD_NAME_STARTUP_PAGE,array(''=>'Select Page','dashboard' => 'Dashboard'),array('class' => 'span3')); ?>
							<?php echo $form->error($model,Globals::FLD_NAME_STARTUP_PAGE); ?>
						</div>
				</div>
				<h4  class="bottom_border"><?php echo Yii::t('index_setting','time_zone_setting_text');?></h4>
				<div class="controls-row">
						<div class="span4 nopadding">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_TIMEZONE,array('label'=>Yii::t('index_setting','timezone_text'))); ?>
							<?php
							$list=CHtml::listData(Timezone::getTimeZone(), Globals::FLD_NAME_TIMEZONE, 'timezone_display');
							//$list=CommonUtility::timezoneList();
							//print_r($list);
							echo $form->dropDownList($model, Globals::FLD_NAME_TIMEZONE, $list,array('class' => 'span3'));?>
							
							<?php echo $form->error($model,Globals::FLD_NAME_TIMEZONE); ?>
						</div>
				</div>
				<h4 class="bottom_border"><?php echo Yii::t('index_setting','privacy_setting_text');?></h4>
				<div class="controls-row">
					<div class="span3 nopadding">
						<div class="span1 topmargin privacy_span"><?php echo $form->checkBox($model,Globals::FLD_NAME_CONTACT_BY_CHAT, array('disabled'=>false,'checked'=>$contactbychat)); ?></div>
						<div class="span2 nopadding"><?php echo $form->labelEx($model,Globals::FLD_NAME_CONTACT_BY_CHAT,array('label'=>Yii::t('index_setting','contactbychat_text'),'class' =>'label_new')); ?></div>
                                                    <?php //echo $form->error($model,'weburl'); ?>
					</div>
					<div class="span3 nopadding">
						<div class="span1 topmargin privacy_span"><?php echo $form->checkBox($model,Globals::FLD_NAME_CONTACT_BY_EMAIL, array('disabled'=>false,'checked'=>$contactbyemail)); ?></div>
						<div class="span2 nopadding"><?php echo $form->labelEx($model,Globals::FLD_NAME_CONTACT_BY_EMAIL,array('label'=>Yii::t('index_setting','contactbyemail_text'),'class' =>'label_new')); ?></div>
                                                    <?php //echo $form->error($model,'weburl'); ?>
					</div>
					<div class="span3 nopadding">
						<div class="span1 topmargin privacy_span"><?php echo $form->checkBox($model,Globals::FLD_NAME_CONTACT_BY_PHONE, array('disabled'=>false,'checked'=>$contactbyphone)); ?></div>
						<div class="span2 nopadding"><?php echo $form->labelEx($model,Globals::FLD_NAME_CONTACT_BY_PHONE,array('label'=>Yii::t('index_setting','contactbyphone_text'),'class' =>'label_new' )); ?></div>
                                                    <?php //echo $form->error($model,'weburl'); ?>
					</div>
				</div>
				<h4 class="bottom_border"><?php echo Yii::t('index_setting','notification_setting_text');?></h4>
				<div class="controls-row">
						<div class="span4 nopadding">
						<div class="span2 nopadding"><?php echo Yii::t('index_setting','notification_text');?></div>
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_EMAIL, array('disabled'=>false)); ?></div>
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_CHAT, array('disabled'=>false)); ?></div>
						<?php //echo $form->error($model,'weburl'); ?>
					</div>
						<div class="span4 nopadding">
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_SMS, array('disabled'=>false)); ?></div>
						<?php //echo $form->error($model,'weburl'); ?>
					</div>
				</div>
				<div class="controls-row">
						<div class="span4 nopadding">
						<div class="span2 nopadding"><?php echo Yii::t('index_setting','contact_for_references_text');?></div>
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_FB, array('disabled'=>false)); ?></div>
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_TW, array('disabled'=>false)); ?></div>
						<?php //echo $form->error($model,'weburl'); ?>
					</div>
						<div class="span4 nopadding">
						<div class="span1"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_NOTIFY_BY_GPLUS, array('disabled'=>false)); ?></div>
						<?php //echo $form->error($model,'weburl'); ?>
					</div>
				</div>
				<?php /*?><h4 style="color:#0088CC">Billing Tax Setting</h4>
				<div class="controls-row">
						<div class="span4 nopadding">
							<?php echo $form->labelEx($model,'Text Id'); ?>
							<?php echo $form->textField($model,'tagline',array('class'=>'span3')); ?>
							<?php echo $form->error($model,'tagline'); ?>
						</div>
						<div class="span4 nopadding"><?php echo $form->labelEx($model,'1099 form',array('style'=>'float: left;')); ?>
						<div class="span1 nopadding" style="float:right"><?php echo $form->checkBoxControlGroup($model,'weburl_ispublic', array('disabled'=>false,'checked'=>'')); ?></div>
						<div class="span1 nopadding" style="float:right"><?php echo $form->checkBoxControlGroup($model,'weburl_ispublic', array('disabled'=>false,'checked'=>'')); ?></div>
						</div>
						<div class="span4 nopadding"><?php echo $form->labelEx($model,'W-9 information',array('style'=>'float: left;')); ?>
						<div class="span1 nopadding" style="float:right"><?php echo $form->checkBoxControlGroup($model,'weburl_ispublic', array('disabled'=>false,'checked'=>'')); ?></div>
						<div class="span1 nopadding" style="float:right"><?php echo $form->checkBoxControlGroup($model,'weburl_ispublic', array('disabled'=>false,'checked'=>'')); ?></div>
				</div></div><?php */?>
				<h4 class="bottom_border"><?php echo Yii::t('index_setting','work_preference_setting_text');?></h4>
				<div class="controls-row">
						<div class="span4 nopadding">
							<?php //echo $form->labelEx($model,'Show work week as',array('style'=>'float: left;')); ?>
						</div>
							<?php /*?><div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'sun', array('disabled'=>false,'checked'=>'')); ?></div>
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'mon', array('disabled'=>false,'checked'=>'')); ?></div>
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'tue', array('disabled'=>false,'checked'=>'')); ?></div>						
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'wed', array('disabled'=>false,'checked'=>'')); ?></div>
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'thu', array('disabled'=>false,'checked'=>'')); ?></div>
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'fri', array('disabled'=>false,'checked'=>'')); ?></div>
							<div class="span1 nopadding" style="float:left"><?php echo $form->checkBoxControlGroup($model,'sat', array('disabled'=>false,'checked'=>'')); ?></div><?php */?>

				</div>
                                <div id="setScheduleForm">
				<div class="controls-row">
                                    
                                    <?php 
                                    $setDisableAll = false;
                                    $setDisableDays = false;
                                    $setDisable = false;
                                    $daysListDisplay = 'none';
                                    $countSchedule=0;
                                    
                                    $checkAllDays=false;
                                    $checkSelectedDays=false;
                                     
                                    $disableMonday = false;
                                    $disableTuesday = false;
                                    $disableWednesday = false;
                                    $disableThursday = false;
                                    $disableFriday = false;
                                    $disableSaturday = false;
                                    $disableSunday = false;
                                    
                                    $checkedMonday = false;
                                    $checkedTuesday = false;
                                    $checkedWednesday = false;
                                    $checkedThursday = false;
                                    $checkedFriday = false;
                                    $checkedSaturday = false;
                                    $checkedSunday = false;
                                    $submitHandle ='';
                                                           
                                        if(isset($vall->work_hrs))
                                        {
                                            $submitHandle = 'checkRadio();';
                                                foreach ($vall->work_hrs as $schedule)
                                                {
                                                    $countSchedule =  count($schedule);
                                                    
                                                    foreach($schedule as $day)
                                                    {
                                                       
                                                      // echo  $day->day;
                                                       if($day->day=='mon')
                                                       {
                                                           $disableMonday = true;
                                                           $checkedMonday = true;
                                                       }
                                                       if($day->day=='tue')
                                                       {
                                                           $disableTuesday = true;
                                                           $checkedTuesday = true;
                                                       }
                                                       if($day->day=='wed')
                                                       {
                                                           $disableWednesday = true;
                                                           $checkedWednesday = true;
                                                       }
                                                       if($day->day=='thu')
                                                       {
                                                           $disableThursday = true;
                                                            $checkedThursday = true;
                                                       }
                                                       if($day->day=='fri')
                                                       {
                                                           $disableFriday = true;
                                                           $checkedFriday = true;
                                                       }
                                                       if($day->day=='sat')
                                                       {
                                                           $disableSaturday = true;
                                                           $checkedSaturday = true;
                                                       }
                                                       if($day->day=='sun')
                                                       {
                                                           $disableSunday = true;
                                                           $checkedSunday = true;
                                                       }
                                                        ?>
                                    
                                                        <?php
                                                    }
                                              
                                                }
                                                if($countSchedule==7)
                                                {
                                                    $setDisableAll = true;
                                                    $setDisableDays = true;
                                                    $setDisable = true;
                                                     $checkAllDays=true;
                                                     $setDisableDays = true;
                                                     $checkSelectedDays=false;
                                   
                                                }
                                                elseif($countSchedule>=1 && $countSchedule<7 )
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
                                                      $setDisableAll = true;
                                                    $setDisableDays = true;
                                                }
                                        }
                                        
                                        ?>
                                    
                                    
                                    <div class="span4 nopadding">
                                            <label><?php echo Yii::t('index_setting','set_your_working_hours_text');?></label>
                                            <div class="span2 nopadding"><?php
                                                     $this->widget('application.extensions.timepicker.JTimePicker', array(
                                                            'model'=>$model,
                                                             'attribute'=>'start_time',
                                                             // additional javascript options for the date picker plugin
                                                             'options'=>array(
                                                                     'showPeriod'=>false,
                                                                     ),
                                                             'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'Start time','value'=>$starttime,'class'=>'span2','disabled'=>$setDisable,'onblur'=>$submitHandle),
                                                     ));
                                                    ?>
                                            <?php echo $form->error($model,Globals::FLD_NAME_START_TIME); ?></div>
                                                    <div class="span2 nopadding">
                                                    <?php
                                                     $this->widget('application.extensions.timepicker.JTimePicker', array(
                                                            'model'=>$model,
                                                             'attribute'=>'end_time',
                                                             // additional javascript options for the date picker plugin
                                                             'options'=>array(
                                                                     'showPeriod'=>false,
                                                                     ),
                                                             'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'End time','value'=>$endtime,'class'=>'span2','disabled'=>$setDisable,'onblur'=>$submitHandle),
                                                     ));
                                                    ?>
                                                        <?php echo $form->error($model,Globals::FLD_NAME_END_TIME); ?>
                                                    </div>
                                            
                                    </div>
                                    <div class="span4 nopadding">
                                        <?php echo $form->labelEx($model,Globals::FLD_NAME_SELECT_DAYS); ?>
                                  <div class="spanweek">      <label class="radio">
                                            <input type="radio" name="User[select_days]" value="all" id="User_select_days_0" onchange="weekDays(this.value);" <?php if($checkAllDays==true) echo 'checked' ?> <?php if($setDisableAll==true) echo 'disabled' ?>    >
                                           All week days
                                        </label></div>
                                       <div class="spanweek"> <label class="radio">
                                            <input type="radio" name="User[select_days]" value="days" id="User_select_days_1" onchange="weekDays(this.value);"  <?php if($setDisableDays==true) echo 'disabled' ?>  >
                                           Select days
                                        </label></div>
                                        <?php echo $form->error($model,Globals::FLD_NAME_SELECT_DAYS); ?>
                                    </div>
<!--                                    <div class="span4 nopadding">
                                    <label>Show work week as</label>
                                            <div class="span2 nopadding" >
                                                <?php // UtilityHtml::getWeakDropdown($model,'[weekas]',$day,'span2') ?>
                                            </div>
                                    </div>-->
                                </div>
                                <div class="controls-row">
                                    
                                    <div class="span6  nopadding weekdays" style="display: <?php echo $daysListDisplay ?>">  
                                        <table width="100%" class="">
                                            <tr>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_MON,array('label'=>Yii::t('index_setting','mon_text'))); ?><?php echo $form->checkBox($model,'mon',  array('checked'=>$checkedMonday,'disabled'=>$disableMonday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_TUE,array('label'=>Yii::t('index_setting','tue_text'))); ?><?php echo $form->checkBox($model,'tue',  array('checked'=>$checkedTuesday,'disabled'=>$disableTuesday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_WED,array('label'=>Yii::t('index_setting','wed_text'))); ?><?php echo $form->checkBox($model,'wed',  array('checked'=>$checkedWednesday,'disabled'=>$disableWednesday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_THU,array('label'=>Yii::t('index_setting','thu_text'))); ?><?php echo $form->checkBox($model,'thu',  array('checked'=>$checkedThursday,'disabled'=>$disableThursday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_FRI,array('label'=>Yii::t('index_setting','fri_text'))); ?><?php echo $form->checkBox($model,'fri',  array('checked'=>$checkedFriday,'disabled'=>$disableFriday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_SAT,array('label'=>Yii::t('index_setting','sat_text'))); ?><?php echo $form->checkBox($model,'sat',  array('checked'=>$checkedSaturday,'disabled'=>$disableSaturday,'onclick'=>$submitHandle)); ?></td>
                                                <td><?php echo $form->label($model,Globals::FLD_NAME_SUN,array('label'=>Yii::t('index_setting','sun_text'))); ?><?php echo $form->checkBox($model,'sun',  array('checked'=>$checkedSunday,'disabled'=>$disableSunday,'onclick'=>$submitHandle)); ?></td>
                                            </tr>
                                        </table>
                                            
                                    </div>
                                    <div class="span2  nopadding" style="display: <?php echo $daysListDisplay ?>">  
                                                <?php echo $form->error($model,Globals::FLD_NAME_MON); ?>
                                            </div>
                                    
                                </div>
                                </div>
                                
                                        <?php 
                                        if(isset($vall->work_hrs) && $vall->work_hrs != '')
                                        {
                                            ?>
                                            <div class="controls-row">

                                            <div class="span6 nopadding weekdetail">
                                            <table width="100%" class="schrduleRow">
                                            <?php
                                            foreach ($vall->work_hrs as $index => $schedule)
                                            {
                                                ?>
                                        
                                                <tr >
                                                    <td><?php echo $schedule[0]->hrs; ?> | <?php
                                                            $i=1;
                                                            foreach($schedule as $day)
                                                            {
                                                                
                                                                if($i==count($schedule))
                                                                {
                                                                    echo $form->label($model,$day->day);
                                                                }
                                                                else
                                                                {
                                                                   echo $form->label($model,$day->day).', ';
                                                                }
                                                                $i++;
                                                            }
                                                            ?>
                                                    </td>
                                                <td><?php echo CHtml::ajaxLink('<img src="'.Yii::app()->request->baseUrl.'/images/remove-btn.png"></img>', Yii::app()->createUrl('index/deleteschedule?schedule_id='.$index),
                                                                array('success'=>'function(data){ 
                                                                    $.ajax({
                                                                    url      : "'.Yii::app()->createUrl('user/userupdatesetting').'",
                                                                    type     : "POST",
                                                                    dataType : "html",
                                                                    cache    : false,
                                                                    success  : function(html)
                                                                    {
                                                                        jQuery("#tabs_tab_3").html(html);
                                                                        $("#msgSetting").html("'.Yii::t('index_setting','work_preference_setting_text').'");
                                                                        $("#msgSetting").css("display","block");
                                                                    },
                                                                    error:function(){
                                                                        alert("Request failed");
                                                                    }
                                                                });
                                                                }'),array('id' => 'deleteSchedule-'.uniqid().$index));?>
                                          
                                                <?php echo CHtml::ajaxLink('edit', Yii::app()->createUrl('index/editschedule?schedule_id='.$index),
                                                                array('update'=>'#setScheduleForm'),array('id' => 'editSchedule'.uniqid().$index));?></td>
                                            </tr>
                                        
                                        <?php
                                                }
                                                ?>
                                              </table>
                                    </div>
                                </div>
                                            <?php
                                        }
                                        
                                        ?>
                                      
                <div class="controls-row">
					<div class="span7 nopadding">
					<?php
                        $successUpdate = '
                                            if(data.status==="success")
                                            {
                                                         $.ajax({
                                                                    url      : "'.Yii::app()->createUrl('user/userupdatesetting').'",
                                                                    type     : "POST",
                                                                    dataType : "html",
                                                                    cache    : false,
                                                                    success  : function(html)
                                                                    {
                                                                        jQuery("#tabs_tab_3").html(html);
                                                                        $("#msgSetting").html("'.Yii::t('index_setting','success_msg_text').'");
                                                                        $("#msgSetting").css("display","block");
                                                                    },
                                                                    error:function(){
                                                                        alert("Request failed");
                                                                    }
                                                                });
                                               }
                                               else
                                               {
                                                    $.each(data, function(key, val) {
                                                    $("#setting-form #"+key+"_em_").text(val);                                                    
                                                    $("#setting-form #"+key+"_em_").show();
                                                    });
                                               }
                                                        '; 
      
                CommonUtility::getAjaxSubmitButton(Yii::t('index_setting','update_text'),Yii::app()->createUrl('index/setting'),'changepas_bnt btn_space','settingLink',$successUpdate);
        
                
					?>
					<?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
					</div></div>
				 <?php $this->endWidget(); ?>

</div>
</div>
</div>
</div>