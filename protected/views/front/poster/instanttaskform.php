<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadTaskFormScriptFixedPrice(); ?>
<?php echo CommonScript::loadAddressScript("TaskLocation_location_geo_area", "TaskLocation_location_latitude", "TaskLocation_location_longitude"); ?>
<?php echo CommonScript::loadTaskFormScript($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION},$task->{Globals::FLD_NAME_TASK_ATTACHMENTS}) ?>
<?php
    /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'virtualtask-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        //'validateOnChange' => true,
        //'validateOnType' => true,
        ),
            ));
    
    $is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
//    $is_public = true;
?>
<div class="controls-row pdn2">
    <div class="cat_border">
    <div class="cat_type">
        <i class="task_icon2 instant2"></i><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_instant_task')) ?>
    </div>
    <div class="cat_heading"><img src="<?php echo CommonUtility::getCategoryImageURI($category[0]->categorylocale->category_id)?>"><?php echo $category[0]->categorylocale->category_name ?>
        <input type="hidden" name="category_id_value" value="<?php echo $category[0]->categorylocale->category_id ?>" >
    </div>

    <div class="change_cat">
     <?php
        if(!isset($task->{Globals::FLD_NAME_TASK_ID})) 
        {
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadinstanttask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.instant);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInstantTaskShort");
                                                                }'), 
                                   array('id' => 'loadInstantTaskCategory','class'=>'cat_btn', 'live'=>false ));
        }
        else 
        {
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadinstanttask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'data'=>array(Globals::FLD_NAME_TASKID => $task->{Globals::FLD_NAME_TASK_ID},Globals::FLD_NAME_CATEGORY_ID =>$category[0]->categorylocale->category_id),'type'=>'POST',
                                    'success' => 'function(data){
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.instant);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInstantTaskShort");
                                                                }'), 
                                   array('id' => 'loadInstantTaskCategory','class'=>'cat_btn', 'live'=>false ));
        }
     ?>
    </div>
    </div>
    <div class="controls-row pdn3">
        <div class="step_row">
            <div class="step1 active">
                <span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_1')) ?></span><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_create_your_task')) ?>
            </div>
            <div class="step1"><span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_2')) ?></span>
                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_preview')) ?>
            </div>
        </div>
        <!--Instant task left form part start here-->
        <div class="task_boxleft">
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("title-ic.png") ?>"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_TITLE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_title')))); ?>
                   <div class="span5 nopadding">
                     <?php echo $form->textField($task, Globals::FLD_NAME_TITLE, array('class' => 'span5', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_title')),'readonly'=>$is_public)); ?>
                    <?php echo $form->error($task, Globals::FLD_NAME_TITLE); ?>
                     </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"> <?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_msg')) ?></span>
                </div>
            </div>

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("dic-ic.png") ?>"></div>
                <div class="span5 nopadding">
                    <div class="span2  nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_description')))); ?>
                    </div>
                    <div class="span3 rightalign ">
                        <span >
                        <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_browse_template')),Yii::app()->createUrl('poster/browsetemplatecategory'),array('data'=>array('category_id'=>$category[0]->categorylocale->category_id ,'formType'=>  Globals::DEFAULT_VAL_I),'type'=>'POST','success' => 'function(data){$(\'#templatdiv\').html(data);showPopup();}'), array('id'=>'templateDetailBrowse','live'=>false)); ?>
                        </span>
                    </div>
                    <div class="span5 nopadding">
                    
                    <?php 
                        if( $is_public == true )
                        {
                            ?>
                        <div class="partfix">
                            <?php
                             echo '<textarea id="Task_description_nonedit" class="span5" name="Task[description_nonedit]" readonly="readonly">'.$task->{Globals::FLD_NAME_DESCRIPTION}.'</textarea>';
                            echo '<textarea id="Task_description_editable" name="Task[description_editable]" placeholder="'.CHtml::encode(Yii::t('poster_createtask', 'txt_task_description_update')).'" rows="4" maxlength="'.Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.'" class="span5 var"></textarea>';
                            echo $form->hiddenField($task, Globals::FLD_NAME_DESCRIPTION ); 
                            ?>
                        </div>
                           <?php
                        }
                        else
                        {
                            echo $form->textArea($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'span5', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 
                        }
                    ?>
                    <?php echo $form->error($task, Globals::FLD_NAME_DESCRIPTION); ?>
                  
                        </div>
                    <div class="span3  nopadding">
                        <div  id="addAttachmentHead" onclick="slideImages();" class="span3 adattach">
                            <a>
                                <i class="icon-plus-sign"></i>
                                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_add_attachment')) ?>
                            </a>
                        </div>
                    </div>
                     <div class="span2 rightalign" style="float: right">
                         <span id="wordcount">
                            <?php
				$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                $srtlength = strlen($task->description);
                                $totelstringlength = $totelstringlength-$srtlength;
                                echo $totelstringlength;
                            ?>
                        </span>
                    </div>


                      <div class="span5 nopadding">

                    <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $images = json_encode(Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES]);
                        $video = json_encode(Yii::app()->params[Globals::FLD_NAME_ALLOW_VIDEOS]);

                        $success = "
                            $('#takeImagesPortfolio').css('display','block');
                            var divId = fileName.split('.')[0];
                            var fileExtension = fileName.split('.')[1];
                            var images = '" . $images . "';
                            var imagesobj = $.parseJSON(images);
                            $('#takeImagesPortfolio').append( '<div class=\"imagesPreview '+divId+' postedby \"></div>' );
                            if(imagesobj.indexOf(fileExtension) !== -1)
                            {
                                $('#takeImagesPortfolio .'+divId ).append( '<img style=\"height: 80px; width: 80px;\" src=\"" . Globals::FRONT_USER_VIEW_TEMP_PATH . "'+fileName+'\" /><p>".Globals::DEFAULT_VAL_IMAGE_TYPE."</p>' );
                            }
                            else
                            {
                                $('#takeImagesPortfolio .'+divId ).append( '<img style=\"height: 80px; width: 80px;\" src=\"".Globals::IMAGE_DOWNLOAD."\" ><p>'+fileExtension+'</p>' );
                            }
                            $('#takeImagesPortfolio .'+divId ).append( '<input type=\"hidden\" name=\"portfolioimages[]\" value=\"'+fileName+'\" />' );
                            $('#takeImagesPortfolio .'+divId ).append( '<a title=\"click here to remove file\" class=\"removeAttachment\" onclick=\"$(this).parent().remove();\"><img src=\"".Globals::IMAGE_REMOVE."\"></a> ' );
                            $('#uploadPortfolioImage .qq-upload-list').html('');

                        ";
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params['maxfileSize'], Yii::app()->params['minfileSize'], $success);
                        ?>
                        <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio"  style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo CHtml::encode(Yii::t('poster_createtask', 'block')); else
                            echo CHtml::encode(Yii::t('poster_createtask', 'none'));
                        ?> ">
                        <?php
                            if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            {
                                echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name,$task->{Globals::FLD_NAME_TASK_ID});
                            }
                        ?>
                        </div>
                    </div>
                </div>


                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_description_msg')) ?></span>
                </div>
            </div>            

            <div class="controls-row cnl_space" >
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("map-ic.png") ?>"></div>
                <div class="span5 nopadding">
                    <label class="required"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_need_tasker_at')); ?></label>
                    <div class="span3 nopadding yui3-skin-sam">
                        <?php echo $form->textField($taskLocation, Globals::FLD_NAME_LOCATION_GEO_AREA, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_enter_address')),'readonly'=>$is_public)); ?>
                        <?php echo $form->error($taskLocation, Globals::FLD_NAME_LOCATION_GEO_AREA); ?>
                        <?php echo $form->hiddenField($taskLocation,Globals::FLD_NAME_LOCATION_LATITUDE); ?>
                        <?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LONGITUDE); ?>
                    </div>
                    <div class="startby span1">
                        
                        <?php 
                        if(isset($task->{Globals::FLD_NAME_TASKER_IN_RANGE}))
                        {
                            $range = $task->{Globals::FLD_NAME_TASKER_IN_RANGE};
                                    
                        }
                        else 
                        {
                            $range = Globals::DEFAULT_VAL_MILES;
                        }
                        echo $form->textFieldControlGroup($task, Globals::FLD_NAME_TASKER_IN_RANGE, array('labelOptions' => array("label" => false),'class'=>'priceininper','value'=>$range, 'append' => 'Miles','onblur'=>'callMap(TaskLocation_location_latitude.value,TaskLocation_location_longitude.value,this.value);','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_enter_range')))); ?>
                        <?php //echo $form->textField($task, 'tasker_in_range', array('class' => 'span1 startby nomargin','onblur'=>'callMap(TaskLocation_location_latitude.value,TaskLocation_location_longitude.value,this.value);', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter Range')))); ?>
                        <?php echo $form->error($task,Globals::FLD_NAME_TASKER_IN_RANGE); ?>
                    </div> 
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_tasker_range')); ?></span>
                </div>
            </div>

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/time_ic.png"></div>
                <div class="span5 nopadding">
                    <div class="span3 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_END_TIME, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_finish_my_task_till')))); ?>
                   <div class="span nopadding">
                       <?php
                           $timeNew = '';
                           $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME);
                           if (isset($task->{Globals::FLD_NAME_END_TIME}) && isset($task->{Globals::FLD_NAME_TASK_END_DATE})) {
                                
                                $timeNew =  CommonUtility::getInstantFielEndTime($task->{Globals::FLD_NAME_END_TIME},$task->{Globals::FLD_NAME_TASK_END_DATE});
                               // echo substr($time,2) ;
                                                            
                           }

                                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                                $this->widget('CJuiDateTimePicker',array(
                                                'name' => 'Task['.Globals::FLD_NAME_END_TIME.']',
                                                
                                                'mode'=>'datetime', //use "time","date" or "datetime" (default)
                                                'value' => $timeNew,
                                                'language' => '',
                                                'options'=>array(
                                                            'dateFormat' => Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH,     // format of "2012-12-25"
                                                            'yearRange' => Globals::DEFAULT_VAL_DATE_YEAR_RANGE,     // range of year
                                                            'minDate' =>  $minDate, // minimum date        // minimum date
                                                            'maxDate' => date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH),   // maximum date
                                                            'showOtherMonths' => true,      // show dates in other months
                                                            'selectOtherMonths' => true,    // can seelect dates in other months
                                                            'changeYear' => true,           // can change year
                                                            'changeMonth' => true, 
                                                            'timeFormat'=>  Globals::DEFAULT_VAL_TIME_FORMATE_TIMEPICKER,
                                                            'disabled'=> $is_public ,
                                                           // 'showSecond'=>true,
                                                    'minDateTime'=>'js:new Date(' . date(Globals::DEFAULT_VAL_DATE_MIN_DATE_TIME) . ')',
                                                    'maxDateTime'=>'js:new Date(' . date(Globals::DEFAULT_VAL_DATE_MIN_DATE_TIME, strtotime(Globals::DEFAULT_VAL_DATE_MAX_DATE_TIME)) . ')'
                                                                ),
                                      'htmlOptions'=>array('placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_select_time')),
                                              'class'=>'span3','onkeydown'=>'return false',)// jquery plugin options
                                ));
//                          $this->widget('application.extensions.timepicker.JTimePicker', array(
//                                    'model'=>$task,
//                                    'attribute'=>Globals::FLD_NAME_END_TIME,
//                                    'value'=>$timeNew,
////                                    'readonly'=>$is_public,
//                                  // additional javascript options for the date picker plugin
//                                  'options'=>array(
//                                          'showPeriod'=>false,
//                                          'hoursMin'=>8
//                                          ),
//                                  'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>CHtml::encode(Yii::t('poster_createtask', 'txt_select_time')),'class'=>'span3'
//                                      ,'onkeydown'=>'return false', 'readonly'=>$is_public,),
//                          ));
                         ?>
                <?php echo $form->error($task, Globals::FLD_NAME_END_TIME); ?>
                    </div></div>                    
                </div>




                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_finish_time')); ?></span>
                </div>
            </div>

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/card-ic.png"></div>
                <div class="span5 nopadding">
                   <?php echo $form->labelEx($task, Globals::FLD_NAME_PRICE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_i_am_willing_to_pay')))); ?>
                   <div class="span3 nopadding">
                   <?php //echo $form->textField($task, 'price', array('prepend' => '$', 'class' => 'span2', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', '$0')))); ?>
                   <?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_PRICE, array('labelOptions' => array("label" => false),'class'=>'pricein', 'prepend' => '$','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_bid_enter_amount')),'readonly'=>$is_public)); ?>
                   <?php echo $form->error($task, Globals::FLD_NAME_PRICE); ?>
                       </div>
                    <div class="span2" style="display: none;">
                        <?php $payment_mode = array(Globals::DEFAULT_VAL_F => CHtml::encode(Yii::t('poster_createtask', 'txt_fixed_price'))); ?>
                        <?php 
                        $task->{Globals::FLD_NAME_PAYMENT_MODE} = Globals::DEFAULT_VAL_F ;
                        echo $form->radioButtonList($task, Globals::FLD_NAME_PAYMENT_MODE, $payment_mode, array('class' => '','disabled'=>$is_public)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_PAYMENT_MODE); ?>
                    </div>
                    <div class="span5 nopadding" id="pricetext" style="display: none"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_this_task_requires')); ?> <span class="blue_text" id="fixeprice1"><?php echo Globals::DEFAULT_CURRENCY.Globals::DEFULT_FIXED_PRICE; ?></span>&ndash; <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_do_you_have')); ?> <span class="blue_text" id="fixeprice2"><?php echo Globals::DEFAULT_CURRENCY.Globals::DEFULT_FIXED_PRICE; ?></span> <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_to_use_on_this_task')); ?></div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_enter_offer_amount')); ?></span>
                </div>
            </div>

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/vis-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task,Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_posting_visibility')))); ?>
                    <?php $payment_mode = array(Globals::DEFAULT_VAL_1 => CHtml::encode(Yii::t('poster_createtask', 'txt_public_visible_to_everyone')), Globals::DEFAULT_VAL_0 => CHtml::encode(Yii::t('poster_createtask', 'txt_private_only_candidates_i_invite_can_respond'))); ?>
                    <div class="span5 nopadding">
                    <?php echo $form->radioButtonList($task, Globals::FLD_NAME_IS_PUBLIC, $payment_mode, array('checkValue' => '1','class' => '','disabled'=>$is_public)); ?>
                    <?php echo $form->error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
                     </div> </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_visible_to')); ?></span>
                </div>
            </div>
        </div>
        
        <div class="task_boxright">
                    <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_need_tasker')); ?></h3>
                    </div>
            <div class="boxright_in">
                <div class="span3 nopadding">

        <?php
                            $payment_mode = array(Globals::DEFAULT_VAL_1 => CHtml::encode(Yii::t('poster_createtask', 'lbl_do_you_want_to_select_tasker')), Globals::DEFAULT_VAL_0 =>CHtml::encode(Yii::t('poster_createtask', 'lbl_auto_select_by_system')));
                            if($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::FLD_NAME_USER_SMALL)
                            {
                                $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_1;
                            }
                            else if($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::FLD_NAME_AUTO)
                            {
                                $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_0;
                            }
                            else
                            {
                                $task->{Globals::FLD_NAME_TASKER_ID_SOURCE} = Globals::DEFAULT_VAL_0;
                            }
        ?>
        <?php echo $form->radioButtonList($task, Globals::FLD_NAME_TASKER_ID_SOURCE, $payment_mode, array('checkValue' => '1', 'class' => '' ,'disabled'=>$is_public)); ?>
    </div>
                <div id="loadmap" class="">
                <?php 
                $location = '';
                $locationRange ='';
                if(isset($taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} ) && isset($taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE} ))
                {
                   $lat = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
                   $lng = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                   $range = $task->{Globals::FLD_NAME_TASKER_IN_RANGE};
                }
                else 
                {
                    $addtess = CommonUtility::getAddressAndLatLngFromIp();
                    if($addtess)
                    {
                        $lat = $addtess[Globals::FLD_NAME_LAT];
                        $lng = $addtess[Globals::FLD_NAME_LNG];
                    }
                }
                if(!isset($task->{Globals::FLD_NAME_TASKER_IN_RANGE}))
                {
                    $range = Globals::DEFAULT_VAL_MILES;
                }
                $locationRange = CommonUtility::geologicalPlaces($lat,$lng,$range);
                $users=User::getUsersByLatLng($locationRange);
                if($users)
                {
                    
                    foreach ($users as $user) 
                    {   
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_USER_ID] = $user->{Globals::FLD_NAME_USER_ID};
                         $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LNG] = $user->{Globals::FLD_NAME_LOCATION_LONGITUDE};
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_LAT] = $user->{Globals::FLD_NAME_LOCATION_LATITUDE};
                        $location[$user->{Globals::FLD_NAME_USER_ID}][Globals::FLD_NAME_COUNTRY_CODE] = $user->{Globals::FLD_NAME_COUNTRY_CODE};
                    }
                }
                
                $this->renderPartial('_map',array(
                    'lat'=>$lat,'lng'=>$lng,
                    'task'=>$task,'form'=>$form,'model'=>$model,'location'=>$location,), false, true) ?>
                <?php //$this->render('_map',array('task'=>$task,'form'=>$form,'model'=>$model)); ?>
            </div>
                     </div>
                </div>
        

    </div>
    <div class="controls-row cnl_space">
        <div class="btn_cont">
            <div class="ancor">
            <?php
            if(isset($task->{Globals::FLD_NAME_TASK_ID}))
            {
                $action = "poster/editinstanttask";
                echo $form->hiddenField($task,Globals::FLD_NAME_TASK_ID);
            }
            else
            {
                $action ="poster/saveinstanttask";
            }
            $successUpdate = '
                                if(data.status==="success"){

                                    $.ajax({
                                            url      : "' . Yii::app()->createUrl('poster/loadinstanttaskpreview') . '",
                                            data     : { '.Globals::FLD_NAME_TASKID.': data.tack_id , '.Globals::FLD_NAME_CATEGORY_ID.': data.category_id },
                                            type     : "POST",
                                            dataType : "html",
                                            cache    : false,
                                            success  : function(html)
                                            {
                                                
                                                jQuery("#loadpreview").html(html);
                                                jQuery("#templateCategory").hide();
                                                loadPreview();

                                            },
                                            error:function(){
                                                jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                               // alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                            }
                                        });

                                   }else{
                                   $.each(data, function(key, val) {
                                                $("#virtualtask-form #"+key+"_em_").text(val);
                                                $("#virtualtask-form #"+key+"_em_").show();
                                                });
                                   }
                                ';
            CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_save')), Yii::app()->createUrl($action), 'sign_bnt', 'useraddTask', $successUpdate);
            ?>
</div>
        <div class="ancor">
            <?php
            $successUpdatePublish = '
                                        if(data.status==="success"){

                                            $.ajax({
                                                    url      : "' . Yii::app()->createUrl('poster/loadinstanttaskpreview') . '",
                                                    data     : { '.Globals::FLD_NAME_TASKID.': data.tack_id , '.Globals::FLD_NAME_CATEGORY_ID.': data.category_id },
                                                    type     : "POST",
                                                    dataType : "html",
                                                    cache    : false,
                                                    success  : function(html)
                                                    {
                                                        
                                                        jQuery("#loadpreview").html(html);
                                                        loadPreview();
                                                    },
                                                    error:function(){
                                                        //alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                        jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                });

                                           }else{
                                           $.each(data, function(key, val) {
                                                        $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                        $("#virtualtask-form #"+key+"_em_").show();
                                                        });
                                           }
                                    ';

            if ($task->{Globals::FLD_NAME_VALID_FROM_DT} == Globals::DEFAULT_VAL_VALID_FROM_DT ) {
                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_publish')), Yii::app()->createUrl($action) . "?publish=1", 'ancor_bnt2', 'userinstantPublishTask', $successUpdatePublish);
            }
            ?>          </div></div>
    </div></div>
<?php $this->endWidget(); ?>