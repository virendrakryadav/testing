<style>
    .datecount_col2 {
    background: none repeat scroll 0 0 #E55040;
    color: #FFFFFF;
    float: right;
    padding:  15px;
    text-align: center;
}
    </style>
<?php
$coundown = 0;
if (isset($task->{Globals::FLD_NAME_END_TIME}) && isset($task->{Globals::FLD_NAME_TASK_END_DATE})) 
{
    $time = $task->{Globals::FLD_NAME_END_TIME};
    $hours = substr($time, 0, 2);
    $minutes = substr($time, 2);
    $timeFormated = substr($time, 0, 2) . ':' . substr($time, 2);
    $endDate = $task->{Globals::FLD_NAME_TASK_END_DATE};
    $timeNew = $endDate." ".$timeFormated;
    $year = CommonUtility::getYearFromDate($endDate);
    $month = CommonUtility::getMonthFromDate($endDate);
    $day = CommonUtility::getDayFromDate($endDate);
    $currentTime = CommonUtility::getCurrentDate();
    if( $timeNew > $currentTime )
    {
        $coundown = 1;
       echo  CommonScript::loadCoundownScript("defaultCountdown",$task->{Globals::FLD_NAME_END_TIME},$task->{Globals::FLD_NAME_TASK_END_DATE});
    }
}
?>

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

 

?>

  

<div class="controls-row pdn6">
    <!--Task step start here-->
    <div class="step_row">
        <div class="step1 active">
            <span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_1')); ?></span><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_create_your_task')); ?>
        </div>
        <div class="step1 active"><span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_2')); ?></span><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_preview')); ?></div>
    </div>
    <!--Task step ends here-->
    <div class="controls-row">
        <!--Task title start here-->
        <div class="controls-row">

            <div class="controls-row">
                <div class="taskpreview_img"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150"></div>

                <div class="taskpreview_title">
                    <h3 class="h3-1"><a href="<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>" ><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a></h3>
                    <span class="postedby"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')); ?> 
                        <?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $model->{Globals::FLD_NAME_USER_ID}) ?>
                    </span>
                     <?php
                    if($model->{Globals::FLD_NAME_COUNTRY_CODE} != '')
                    {
                        ?>
                        <span class="postedby"><i class="icon-map-marker"></i><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span>
                        <?php
                    }
                    ?>
                    <span class="postedby"><?php echo CommonUtility::agoTiming($task->{Globals::FLD_NAME_CREATED_AT}); ?></span></div>
            </div>
            <div class="taskcount">
            <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?> </div>
                <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_INVITED_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')); ?></div>
                <div class="taskcount_col1"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                <div class="datecount_col1" id="defaultCountdown">
                <?php
                if($coundown==0)
                {
                    $returnData= '<span class="">';
                    $returnData .= CHtml::encode(Yii::t('poster_createtask', 'txt_task_closed'));
                    $returnData .= '</span>';
                    echo $returnData;
                }
                      
                ?>
                </div>
                <div class="datecount_col2" style="float: right" >
                <?php
               if($coundown==1)
                {
                    $returnData= '<span class="">';
                    $returnData .= CHtml::encode(Yii::t('poster_createtask', 'Time Left: '));
                    $returnData .= '</span>';
                    echo $returnData;
                  }
                ?>
                </div>
            </div>
        </div>
        <!--Task title ends here-->

        <!--Skills needed start here-->

        <!--Skills needed ends here-->

        <!--Description Start here-->
        <div class="controls-row">
            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_description')); ?></h2><?php echo $task->description; ?></div>
        <!--Description Ends here-->

        <!--Requirements & details Start here-->
        <div class="controls-row">
            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_req_and_detail')); ?></h2>
            <div class="controls-row"><div class="name_ic"><img src="../images/vis-ic.png"></div>
                <?php echo CommonUtility::getPublicDetail($task->is_public); ?></div>
        </div>
        <div class="controls-row">
            <?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name,$task->{Globals::FLD_NAME_TASK_ID}); ?>
        </div>
        <!--Requirements & details Ends here-->
<?php      $invitedTaskers =   GetRequest::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
        if( $invitedTaskers )
        {
            ?>
<!--        Invited tasker start here-->
            <div class="controls-row">
            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited_tasker')); ?></h2>
            <?php
                foreach ($invitedTaskers as $tasker) 
                {
                ?>
                        <div class="postedby">
                            <a href="<?php echo CommonUtility::getTaskerProfileURI($tasker->{Globals::FLD_NAME_TASKER_ID}) ?>" target="_blank">
                                <img class="image80by80" height="80px" width="80px"  src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
                            </a>
                            <br/>
                            <a href="<?php echo CommonUtility::getTaskerProfileURI($tasker->{Globals::FLD_NAME_TASKER_ID}) ?>" target="_blank">
                                <?php echo CommonUtility::getUserFullName($tasker->{Globals::FLD_NAME_TASKER_ID}); ?>
                            </a>
                        </div>
                <?php
                }
                ?>
            </div>
            <?php
        }
		$taskerProposals =   TaskTasker::getAllProposalsOfTask($task->{Globals::FLD_NAME_TASK_ID});
        if( $taskerProposals )
        {
            ?>
<!--        Invited tasker start here-->
            <div class="controls-row">
            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_bidders')); ?></h2>
            <?php
                foreach ($taskerProposals as $proposals) 
                {
                ?>
                        <div class="postedby">
                            <a href="<?php echo CommonUtility::getTaskerProfileURI($proposals->{Globals::FLD_NAME_TASKER_ID}) ?>" target="_blank">
                                <img class="image80by80" height="80px" width="80px" src="<?php echo CommonUtility::getThumbnailMediaURI($proposals->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
                            </a>
                            <br/>
                            <a href="<?php echo CommonUtility::getTaskerProfileURI($proposals->{Globals::FLD_NAME_TASKER_ID}) ?>" target="_blank">
                                <?php echo CommonUtility::getUserFullName($proposals->{Globals::FLD_NAME_TASKER_ID}); ?>
                            </a>
                        </div>
                <?php
                }
                ?>
            </div>
            <?php
        }
?>
        <!--Invited tasker ends here-->

    </div>

    <div class="controls-row cnl_space">
        <div class="btn_cont">
            <?php echo $form->hiddenField($task,  Globals::FLD_NAME_TASK_ID); ?>
            <input type="hidden" name="task_category_id" value="<?php echo $category[0]->categorylocale->category_id ?>" />
            <div class="ancor">
            <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/loadcategoryformtoupdate'), array(
               'beforeSend' => 'function(){
                            $("#rootCategoryLoading").addClass("displayLoading");
                            $("#loadpreviuosTask").addClass("displayLoading");
                            $("#templateCategory").addClass("displayLoading");}',
                'complete' => 'function(){       
                            $("#rootCategoryLoading").removeClass("displayLoading");
                            $("#loadpreviuosTask").removeClass("displayLoading");
                            $("#templateCategory").removeClass("displayLoading");}',
                'dataType' => 'json', 
                'data' => array(Globals::FLD_NAME_TASKID => $task->{Globals::FLD_NAME_TASK_ID}, Globals::FLD_NAME_CATEGORY_ID => $category[0]->categorylocale->category_id, 'formType' => 'instant'),
                        'type' => 'POST',
                        'success' => 'function(data){
                                                        backForm();
                                                        $(\'#loadCategoryForm\').html(data.form);
                                                        $(\'#loadPreviewTask\').html(data.previusTask);
                                                        $(\'#loadTemplateCategory\').html(data.template);
                                                        $(\'#templateCategory\').show(); 
                                                    }'), 
                        array('id' => 'editVirtaultask', 'class' => 'ancor_bnt', 'live' => false)); ?>

          </div>        
            <?php //
            
        //    if ( $task->{Globals::FLD_NAME_VALID_FROM_DT} != Globals::DEFAULT_VAL_VALID_FROM_DT ) 
//        {
//            if ( $task->{Globals::FLD_NAME_IS_PUBLIC} != Globals::DEFAULT_VAL_1 ) 
//            {
//                echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite')), Yii::app()->createUrl('tasker/invitetasker') . "?taskId=" . $task->{Globals::FLD_NAME_TASK_ID} . "&category_id=" . $category[0]->categorylocale->category_id, array('id' => 'publishinpersontask', 'class' => 'cnl_btn'));
//            }
//        }            
            if ($task->{Globals::FLD_NAME_VALID_FROM_DT} != Globals::DEFAULT_VAL_VALID_FROM_DT ) 
            {
                ?>
                    <div class="ancor">
              <?php
//                 echo CHtml::ajaxLink('Invite', Yii::app()->createUrl('poster/loadcategoryformtoupdate'), array('data'=>array('taskId'=>$task->{Globals::FLD_NAME_TASK_ID},'category_id'=>$category[0]->categorylocale->category_id,'formType'=>'inperson'),'type'=>'POST','success' => 'function(data){backForm();$(\'#loadCategoryForm\').html(data);}'), array('id' => 'publishinpersontask','class' =>'cnl_btn'));               
                if ($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::FLD_NAME_USER_SMALL) 
                {                    
                    echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite')), Yii::app()->createUrl('tasker/invitetasker') . "?taskId=" . $task->{Globals::FLD_NAME_TASK_ID} . "&category_id=" . $category[0]->categorylocale->category_id, 
                            array('id' => 'publishinpersontask', 'class' => 'ancor_bnt2'));
                    
                }
                else if ($task->{Globals::FLD_NAME_TASKER_ID_SOURCE} == Globals::DEFAULT_VAL_AUTO ) 
                {                          
//                    echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'auto invite')), Yii::app()->createUrl('tasker/invitetasker') . "?taskId=" . $task->{Globals::FLD_NAME_TASK_ID} . "&category_id=" . $category[0]->categorylocale->category_id, 
//                            array('id' => 'publishinpersontask', 'class' => 'ancor_bnt2'));
                    $successUpdatePublish = '
                                                if(data.status==="success"){
                                                    $.ajax({
                                                            url      : "' . Yii::app()->createUrl('poster/loadinstanttaskpreview') . '",
                                                            data     : { "taskId":'.$task->{Globals::FLD_NAME_TASK_ID}.' , "category_id": '.$category[0]->categorylocale->category_id.' },
                                                            type     : "POST",
                                                            dataType : "html",
                                                            cache    : false,
                                                            success  : function(html)
                                                            {
                                                                loadPreview();
                                                                jQuery("#loadpreview").html(html);

                                                            },
                                                            error:function(){
        //                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                                    jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                            }
                                                        });
                                                    }
                                                    else
                                                    {
                                                        alert("User not available");
                                                    }
                                    ';
                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'auto invite')), Yii::app()->createUrl("poster/autoinvite"), 'ancor_bnt2', 'autoinviteinpersontask', $successUpdatePublish);
                                
                }
                ?></div>
        <?php
            } 
            else 
            {
                ?>
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
                                                        loadPreview();
                                                        jQuery("#loadpreview").html(html);

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
                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_publish')), Yii::app()->createUrl("poster/publishtask"), 'ancor_bnt2', 'useraddTaskPublish', $successUpdatePublish);
            ?>
        </div>
        <?php
                
            }
            ?>
    <div class="ancor">    
        <input type="button" class="cnl_btn" onclick="window.location='<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>'; return false;" value = '<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_close')) ?>' /></div>
    </div></div>

</div>
<?php $this->endWidget(); ?>