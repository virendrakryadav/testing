<style>
    .windowpoposal 
    {
        background: none repeat scroll 0 0 #FFFFFF;
			box-shadow: 0 0 15px #000000;
        height: 70%;
        min-height: 160px !important;
        overflow: auto;
        position: fixed;
        top: 12%;
        z-index: 10000;
    }
	
	.write_review
	{
		background: none repeat scroll 0 0 #F3F1F1;
		border-radius: 5px;
		color: #666666;
		height: 100px;
		width: 50%;
		margin: 15px 0;
	}
	#review_text
	{
		background: none repeat scroll 0 0 #FFFFFF;
		border-radius: 3px;
		
		height: 70px;
		margin:10px 10px;
		width: 50%;
	}
	
	.taskreview {
    	border-bottom: 1px solid #DDDDDD;
	}
        .back_btn{
            float: right;
            min-height: 30px;
            padding: 10px;
        }

</style>
<script>
	$(document).ready(function()
        {
		$("#review").click(function()
                {
                    $("#write_review").show();
		});
               
                
	});
        $("#TaskTasker_poster_comments").click(function() {
             
        });
//if( $("#TaskTasker_poster_comments").val().length > 0 )
//{
    var myEvent = window.attachEvent || window.addEventListener;
    var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compitable
    myEvent(chkevent, function(e) 
    { // For >=IE7, Chrome, Firefox
        if( $("#TaskTasker_poster_comments").val().length > 0 )
        {
            var confirmationMessage = '<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_are_you_sure_to_leave')); ?>';  // a msg
                (e || window.event).returnValue = confirmationMessage;
                // check();
            return confirmationMessage;
        }
        return true;
    });  
//}
    function check()
    {
        alert( $("#TaskTasker_poster_comments").val().length );
    }
</script>

<?php $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task->{Globals::FLD_NAME_TASK_ID}, $model->user_id); ?>
<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadRemainingCharScript('TaskTasker_poster_comments', 'wordcountPosterComments', Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH) ?>
<?php echo CommonScript::loadAttachmentHideShowScript('SlideAttachments', 'loadAttachment') ?>
<?php //$getReviews = UtilityHtml::getReviews($task);
$skills = UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID});
$skills = ($skills== '<ul></ul>') ? CHtml::encode(Yii::t('poster_createtask','lbl_not_specified')) : $skills ; 
$bidStatus = ($taskType == Globals::DEFAULT_VAL_I) ? 
                UtilityHtml::getBidStatusInstant($task->{Globals::FLD_NAME_END_TIME}) :                       
                UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_FINISHED_ON});
?>

<?php
$coundown = 0;
if (isset($task->{Globals::FLD_NAME_END_TIME}) && isset($task->{Globals::FLD_NAME_TASK_END_DATE})) {
//    $time = $task->{Globals::FLD_NAME_END_TIME};
//    $hours = substr($time, 0, 2);
//    $minutes = substr($time, 2);
//    $timeFormated = substr($time, 0, 2) . ':' . substr($time, 2);
//    $endDate = $task->{Globals::FLD_NAME_TASK_END_DATE};
//    $timeNew = $endDate . " " . $timeFormated;
//    $year = CommonUtility::getYearFromDate($endDate);
//    $month = CommonUtility::getMonthFromDate($endDate);
//    $day = CommonUtility::getDayFromDate($endDate);
//    $currentTime = CommonUtility::getCurrentDate();
//    if ($timeNew > $currentTime) {
//        $coundown = 1;
//        echo CommonScript::loadCoundownScript("defaultCountdown1", $task->{Globals::FLD_NAME_END_TIME}, $task->{Globals::FLD_NAME_TASK_END_DATE});
//    }
}
//echo $this->createAbsoluteUrl(Yii::app()->request->url)

?> 

<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->

<div class="container content">
    <!--Left side content start here-->
    <div class="col-md-3">
        <!-- Dashboard (erandoo) starts here -->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!-- Dashboard (erandoo) ends here -->
        <div class="margin-bottom-30"></div>
        <div class="margin-bottom-30">
            <!--Make an Proposal start here-->
            <div id="accordion" class="panel-group">
            <?php 
//                if($bidStatus == '<span class="">Bid Not Started</span>')
//                {
//                    $this->renderPartial('_noproposals');
//                }
//                else
//                {
                    $this->renderPartial('_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals,   'currentUser'=>$currentUser,'bidStatus' => $bidStatus));
                //}
             ?>
            <!--Make an Proposal Ends here-->

            <!--Share task start here-->
                <?php $this->renderPartial('_proposalsharelinks', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals)); ?>
            <!--Share task Ends here-->

            <!--Invited tasker start here-->
                <?php $this->renderPartial('_invitedtaskers', array('task' => $task )); ?>
            <!--Invited tasker Ends here-->

            <!--Related task start here-->
            <?php if(Yii::app()->user->id)
            {
                ?>
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <?php $this->renderPartial('//partial/_relatedtask', array( 'task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'relatedTask' => $relatedTask, 'taskQuestionReply' => $taskQuestionReply,)); ?>
                </div>
            <?php
            }
            ?>
            <!--Related task Ends here-->
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <!--Left side content ends here-->
    
    <!--Right side bar start here-->
    <div class="col-md-9 sky-form">
        <h2 class="h2 text-30a">Proposal Detail</h2>
        <div class="margin-bottom-30">

            <!--Instant task start here-->
            <div class="col-md-12 no-mrg">

                <!--Task title start here-->
                <div class="col-md-12 no-mrg">
                    <div class="col-md-12 no-mrg">
                        <div class="taskpreview_img">   
                            <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150">
                        </div>
                        <div class="taskpreview_title">
                            <h3 class="h3-1"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></h3>
                            <span class="postedby"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')); ?> 
                                <?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $model->{Globals::FLD_NAME_USER_ID}) ?>
                            </span>
                            <?php
                                if($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE})
                                {
                                    echo UtilityHtml::getUserLocationWithPopover( $model->{Globals::FLD_NAME_USER_ID}, $model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} , 'bottom' , 'postedby popovercontent');
                                }
                            ?>
                            <span class="postedby"><?php echo CommonUtility::agoTiming($task->created_at); ?></span>
                        </div>
                        <?php $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}); ?>
                        <div class="estimated">
                            <span>
                                <p> <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_estimated')); ?>  </p>
                                <p class="priceit"><?php echo Globals::DEFAULT_CURRENCY . intval( $task->{Globals::FLD_NAME_PRICE} ); ?></p>
                            </span>

                            <!--                                 <div  id="sendProposal" class="send_proposal" onclick="viewProposal()">
                            <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_send_proposal')); ?>
                                                             </div>-->

                        </div>
                    </div>
                    <div class="taskcount col-md-12 mrg-auto2">
                        <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?> </div>
                        <div class="taskcount_col1"><span class="point"><?php echo $task->{Globals::FLD_NAME_INVITED_CNT} ?></span><br/><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')); ?></div>
                        <div class="taskcount_col1"><span class="point"></span><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?><br/></div>
                        <?php //echo CommonUtility::getAvgRating( 500 , 5 , 300  ); ?>
                        <div class="datecount_col1">
                            <?php  
                                echo $bidStatus;
//                            echo  CommonUtility::getInstantFielEndTime($task->{Globals::FLD_NAME_END_TIME},$task->{Globals::FLD_NAME_TASK_END_DATE});
                            ?>
                        </div>
                    </div>
                </div>
                <!--Task title ends here-->


                <!--Skills needed start here-->
                <div class="col-md-12 mrg-auto2">
                    <div class="row_half">
                        <?php
                        
                        //if ($skills != '<ul></ul>') 
                        //{
                            ?>
                            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')); ?></h2>
                            <div class="skill">
                            <?php echo $skills; ?>
                            </div>
                            <?php
                       // }
                        ?>
                    </div>
                    <!--Skills needed ends here-->

                    <!--Requirements & details Start here-->
                    <div class="row_half2">
                        <div class="col-md-12 no-mrg">
                            <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_req_and_detail')); ?></h2>
                            <div class="controls-row"><div class="name_ic">
                                    <img src="<?php echo CommonUtility::getPublicImageUri( "vis-ic.png" ) ?>"></div><?php echo CommonUtility::getPublicDetail($task->is_public); ?></div>
                        </div>
                        <div class="col-md-12 no-mrg">
                            <?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name, $task->{Globals::FLD_NAME_TASK_ID}); ?>
                        </div>
                    </div>

                </div>
                <!--Requirements & details Ends here-->

                <!--Description Start here-->
                <div class="col-md-12 mrg-auto2">
                    <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_description')); ?></h2>
                    <?php echo $task->description; ?>
                </div>
				<?php
				 /*?>if($task->state=='f')
				{
				?>
				<div class="controls-row">
                    <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_review')); ?></h2>
					<div id="review_box">
                    	<?php //echo $getReviews?>
					</div>
                </div>
                <!--Description Ends here-->
                <?php
				}<?php */
                if ($question)
                {
                    ?>
                    <!--Invited tasker start here-->
                    <div class="col-md-12 mrg-auto2">
                        <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_question')); ?></h2>
                        <div class="col-md-12 no-mrg">
                    <?php
                    $i = 1;
                    foreach ($question as $questions) 
                    {
//                        echo $i . '. ' . $questions->categoryquestionlocale->question_desc . "<br>";
//                        $i++;
                    }
                    ?>
                        </div>
                    </div>
                    <!--Invited tasker ends here-->
                <?php
                }
                ?>
            </div>
            <div class="col-lg-3 mrg-auto2">
                <a href="<?php echo CHttpRequest::getUrlReferrer() ?>" class="btn-u btn-u-lg rounded btn-u-sea">
                <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_back_to_task_list')); ?>
                </a>
            </div>
            <!--Instant task ends here-->
        </div>
    </div>
    <!--Right side bar ends here-->

    
</div>

<div id="loadproposalpreview" class="windowpoposal " style="display: none" ></div>
