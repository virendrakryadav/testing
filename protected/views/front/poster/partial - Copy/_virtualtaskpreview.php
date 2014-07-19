<style>
    .ancor1 {
    float: left;
    margin-left: 5px;
    padding: 7px 0 0;
}
</style>
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
$skills = UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID});
$locations = UtilityHtml::getTaskPreferedLocations( $task->{Globals::FLD_NAME_TASK_ID} );
 $is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
//print_r( $locations );
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
                    <h3 class="h3-1"><a href="<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>" ><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}); ?></a></h3>
                    <span class="postedby"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')); ?> 
                        <?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $model->{Globals::FLD_NAME_USER_ID}) ?>
                    </span>
                    <?php
                    if($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} != '')
                    {
                        ?>
                        <span class="postedby"><i class="icon-map-marker"></i><?php echo $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}; ?></span>
                        <?php
                    }
                    ?>
                    <span class="postedby"><?php echo CommonUtility::agoTiming($task->{Globals::FLD_NAME_CREATED_AT});  ?></span></div>
            </div>
            <div class="taskcount">
                <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?> </div>
                <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_INVITED_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')); ?></div>
                <div class="taskcount_col1"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                <div class="datecount_col1"><?php echo UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}); ?></div>
            </div>
        </div>
        <!--Task title ends here-->

        <!--Skills needed start here-->
        <?php
        
        if ($skills != '<ul></ul>') {
            ?>
            <div class="controls-row">
                <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')); ?></h2>
                <div class="skills">
    <?php echo $skills; ?>
                </div>
            </div>
            <?php
        }
        ?>
        <!--Skills needed ends here-->
<?php
        if ($locations != '') {
            ?>
            <div class="controls-row">
                <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_locations')); ?></h2>
                <div class="skills">
    <?php echo $locations; ?>
                </div>
            </div>
            <?php
        }
        ?>
        
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
<?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name , $task->{Globals::FLD_NAME_TASK_ID}); ?>

        </div>
        <!--Requirements & details Start here-->
        <?php
        $question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
        if ($question) {
            ?>
            <div class="controls-row">
                <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_question')); ?></h2>
                <div class="controls-row">
                    <?php
                    $i = 1;
                    foreach ($question as $questions) {
                        echo $i . '. ' . $questions->categoryquestionlocale->question_desc . "<br>";
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <!--Requirements & details Ends here-->
<?php
	    $invitedTaskers =   GetRequest::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
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
							<?php echo ucfirst(strtolower(CommonUtility::getUserFullName($tasker->{Globals::FLD_NAME_TASKER_ID}))); ?>
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
                                <?php echo ucfirst(strtolower(CommonUtility::getUserFullName($proposals->{Globals::FLD_NAME_TASKER_ID}))); ?>
                            </a>
                        </div>
                <?php
                }
                ?>
            </div>
            <?php
        }
?>
    </div>
    <div class="controls-row cnl_space">
    <div class="btn_cont">
        <?php echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID); ?>
        <input type="hidden" name="task_category_id" value="<?php echo $category[0]->categorylocale->category_id ?>" />
       <div class="ancor">
         <?php
          $editAction = "poster/loadcategoryformtoupdate";
//         if($is_public)
//         {
//             $editAction = "poster/edittask";
//         }
//        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl($editAction), array(
//            'beforeSend' => 'function(){
//                            $("#rootCategoryLoading").addClass("displayLoading");
//                            $("#loadpreviuosTask").addClass("displayLoading");
//                            $("#templateCategory").addClass("displayLoading");}',
//            'complete' => 'function(){       
//                            $("#rootCategoryLoading").removeClass("displayLoading");
//                            $("#loadpreviuosTask").removeClass("displayLoading");
//                            $("#templateCategory").removeClass("displayLoading");}',
//            'dataType' => 'json', 
//            'data' => array('taskId' => $task->{Globals::FLD_NAME_TASK_ID}, 'category_id' => $category[0]->categorylocale->category_id, 'formType' => 'virtual'), 
//            'type' => 'POST', 
//            'success' => 'function(data){
//                                            backForm();
//                                            $(\'#loadCategoryForm\').html(data.form);
//                                            $(\'#loadPreviewTask\').html(data.previusTask);
//                                            $(\'#loadTemplateCategory\').html(data.template);
//                                            $(\'#templateCategory\').show(); 
//                                        }'), 
//            array('id' => 'editVirtaultask', 'class' => 'ancor_bnt', 'live' => false));
        ?>
       </div>
        
        <?php
        if ( $task->{Globals::FLD_NAME_VALID_FROM_DT} != Globals::DEFAULT_VAL_VALID_FROM_DT ) 
        {
            if ( $task->{Globals::FLD_NAME_IS_PUBLIC} != Globals::DEFAULT_VAL_1 ) 
            {
                ?>
                <div class="ancor1">
                      <?php // echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite')), Yii::app()->createUrl('tasker/invitetasker') . "?taskId=" . $task->{Globals::FLD_NAME_TASK_ID} . "&category_id=" . $category[0]->categorylocale->category_id, array('id' => 'publishinpersontask', 'class' => 'ancor_bnt2')); ?>
                </div>
        <?php
            }
        } 
        else
        {
             ?>
        <div class="ancor">
              <?php
//                            $successUpdatePublish = '
//                                        if(data.status==="success")
//                                        {
//
//                                          
//
//                                        }
//                                        else
//                                        {
//                                            $.each(data, function(key, val) {
//                                            $("#virtualtask-form #"+key+"_em_").text(val);
//                                            $("#virtualtask-form #"+key+"_em_").show();
//                                            });
//                                        }
//                                    ';
//                        CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'Confirm')), Yii::app()->createUrl("poster/publishtask"), 'ancor_bnt2', 'useraddTask', $successUpdatePublish);
       ?>
        </div>
        <?php
            
        }
        ?>
    <div class="ancor">    
        <!--<input type="button" class="cnl_btn" onclick="window.location='<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>'; return false;" value = '<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_close')) ?>' /></div>-->
    </div>
</div>
</div>
<?php $this->endWidget(); ?>