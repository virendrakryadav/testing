<?php $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task->{Globals::FLD_NAME_TASK_ID}, $model->user_id); ?>
<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadRemainingCharScript('TaskTasker_poster_comments', 'wordcountPosterComments', Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH) ?>
<?php echo CommonScript::loadAttachmentHideShowScript('SlideAttachments', 'loadAttachment') ?>
<?php //$getReviews = UtilityHtml::getReviews($task);
$taskerProposal = TaskTasker::getUserProposalForTask( $task->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id  );
$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});
$skills = UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID});
$skills = ($skills== '<ul></ul>') ? CHtml::encode(Yii::t('poster_createtask','lbl_not_specified')) : $skills ; 
$bidStatus = ($taskType == Globals::DEFAULT_VAL_I) ? 
                UtilityHtml::getBidStatusInstant($task->{Globals::FLD_NAME_END_TIME}) :                       
                UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_FINISHED_ON});
                
 $isInvited =   TaskTasker::isTaskerInvitedForTask( $task->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id);
  $isTaskerSelected =  TaskTasker::isTaskerSelectedForTask ($task->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id);
?>

<script>
$(document).ready(function(){
        currentUserParts('<?php echo Yii::app()->user->id ?>');
    });
</script>
<?php $this->renderPartial('partial/_project_detail_common', array('task'=>$task,
                            'model'=>$model,
                            'question'=>$question,
                            'taskQuestionReply'=>$taskQuestionReply,
                            'key'=>$key,
                            'taskTasker'=>$taskTasker,
                            'taskLocation' => $taskLocation,
                            'proposals'=>$proposals,
                            'relatedTask'=>$relatedTask,
                            'taskType'=>$taskType,
                            'proposalIds' => $proposalIds,
                            'currentUser'=>$currentUser,
                            'message' => $message,
                            'messagesOnTask' => $messagesOnTask)); ?>

<?php
$coundown = 0;
//$task->{Globals::FLD_NAME_TASK_MIN_PRICE} == 'p' ? 'Apply' : '';
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
$parent = Category::getParentCategoryChild($task->categorylocale->{Globals::FLD_NAME_CATEGORY_ID});
?> 

<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->

<div class="container content">
    <!--Left side content start here-->
    <div class="col-md-3 leftbar-fix">
        <!-- Dashboard (erandoo) starts here -->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!-- Dashboard (erandoo) ends here -->
        
        <!--Top search start here-->
        
                <?php 
               
                            ?>
          
        <!--Top search Ends here-->
        
        
        <div id="leftSideBarScroll">
        
        <!--Instant Navigations Starts here-->
      
                <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', 'a', array('id' => 'taskStateValue')); ?>
                    
        <?php 
        
//                     $this->renderPartial('//tasker/_task_search_box_sidebar');
//                     
//                    $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
//                    array(
//                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_applied_to')) =>  CommonUtility::getTaskerApplyProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_saved_projects')) => CommonUtility::getTaskerSavedProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_active_projects')) => CommonUtility::getTaskerActiveProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_completed_projects')) => CommonUtility::getTaskerCompletedProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')) => Yii::app()->createUrl('tasker/mytasks'),
//                        )
//                    ));
                    ?>
        <div class="margin-bottom-30">
              
                        <a class="btn-u rounded btn-u-red display-b text-16" href="<?php echo Yii::app()->request->urlReferrer ?>"><?php echo CHtml::encode(yii::t('poster_projectdetail', 'lbl_back')); ?></a>

                </div>
                                <!--Budget Start here-->
                                <div class="">
                                    <div class="grad-box align-left sky-form">
                                        <div class="col-md-12">
                                        <h3>Budget</h3>
                                            <section class="mrg-botton-13 overflow-h">
                                                <div class="col-md-12 no-mrg">
                                                    <div class="col-md-55">
                                                        <div class="budget-box text-align-right"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_MIN_PRICE});?></div>
                                                    </div>
                                                    <div class="col-md-22">To</div>
                                                    <div class="col-md-55">
                                                        <div class="budget-box text-align-right"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_MAX_PRICE});?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 no-mrg right-align"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                                            </section>

                                            <section class="mrg-botton-13 overflow-h">
                                                <div class="col-md-12 no-mrg">
                                                    <div class="col-md-5 no-mrg">Time Left</div>
                                                    <div class="col-md-7 no-mrg">
                                                        <div class="budget-box text-align-right"><?php 
                                                       // echo $task->{Globals::FLD_NAME_TASK_KIND};
                                                        if( $task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON )
                                                        {
                                                            $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_FINISHED_ON});
                                                        }
                                                        else 
                                                        {
                                                            $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                                                        }

                                                         if($daysleft['m'] >= 1 )
                                                            echo $daysleft['m'].'m,'.$daysleft['d'].'d';
                                                         else
                                                            echo $daysleft['d'].'d';

                                                        // print_r($daysleft['time']);
                                                        ?></div>
                                                    </div>
                                                </div>
                                            </section>

                                            

                                        </div>
                                    <div class="clr"></div>
                                    </div>
                                </div>
               
            
        <!--Instant Navigations Ends here-->
        <?php //  print_r($task);
                //echo Yii::app()->user->id;
        ?>
        </div>
    </div>
    <!--Left side content ends here-->
    
    <!--Right side bar start here-->
    <div class="col-md-9 right-cont">
        <div class="sky-form"> 
        <div class="h-tab flat">
        <a href="<?php echo CommonUtility::getTaskListURI(); ?>">All Tasks</a>
<!--        <a href="<?php echo CommonUtility::getTaskListURI(); ?>"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></a>
        <a href="<?php echo CommonUtility::getParentCategoryURL($parent->parentName->{Globals::FLD_NAME_CATEGORY_ID} , $task->{Globals::FLD_NAME_TASK_KIND}); ?>"><?php echo $parent->parentName->{Globals::FLD_NAME_CATEGORY_NAME} ?></a>-->
        <a href="<?php echo CommonUtility::getChildCategoryURL($task->categorylocale->{Globals::FLD_NAME_CATEGORY_ID}, $task->{Globals::FLD_NAME_TASK_KIND}); ?>"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></a>
        <a href="#" class="active"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></a>
	
        </div>
        <div class="margin-bottom-30">
            <!--Top proposal start here-->
        <?php   $this->renderPartial('//tasker/_projectdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel , 'isProposed' => $isProposed)); ?>
        <!--Top proposal ends here--> 
        </div>
     <?php  echo   CHtml::hiddenField('currentaskers', Yii::app()->user->id,array('id' => 'currentaskers')); ?>
                <div class="clr"></div>
                <div id="taskDetailHeader" class="grad-box margin-top-bottom-20 no-border">
                <div class="vtab3">
                <ul>
                <li><a id="viewDescriptionTitle" onclick="viewDescription()" class="" href="javascript:void(0)">Description</a></li>
                <li><a id="viewMessageTitle" onclick="viewMessage()" href="javascript:void(0)">Messages</a></li>
                <li  id="viewFilesTitle"><a  onclick="viewFiles()" href="javascript:void(0)">Files</a></li>
                <li><a id="viewProposalsTitle" onclick="viewProposals()" class="active" href="javascript:void(0)">Proposal</a></li>

                </ul>
                </div>
                <div class="clr"></div> 
                </div>
  
        
        <div  class="margin-bottom-30">

            <div class="col-md-12 no-mrg">
                
                <div id="viewDescription" style="display: none"  >
                 <?php   $this->renderPartial('partial/_view_project_description',array('task' => $task ,'model' =>$model )); ?>    
                </div>
                    
                <!--Questions ends here-->
                <div id="viewmasseges" style="display: none" class="margin-bottom-20">
                 <?php   $this->renderPartial('partial/_view_project_messages',array('task' => $task ,'model' =>$model , 'message' => $message , 'messagesOnTask' => $messagesOnTask)); ?>    
                </div>
                
                <div id="viewFiles" style="display: none" class="col-md-12 no-mrg">
                   <?php   $this->renderPartial('partial/_view_project_files',array('task' => $task ,'model' =>$model , 'attachments' => $attachments )); ?>     
                </div>
                
                <div id="viewProposals" class="margin-bottom-30">
                 <?php  $this->renderPartial('partial/_view_doer_proposal',array('task' => $task ,'model' =>$model , 'proposals'=>$proposals,'taskLocation' => $taskLocation, 'isTaskCancel' => $isTaskCancel , 'taskerProposal' => $taskerProposal)); ?>    
              
                </div>
                
                <!--Questions ends here-->
            </div>
        </div>
    </div>
    </div>
    <!--Right side bar ends here-->
</div>
<div id="postQuestionsTaskDetail" style="display: none">
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'post-question-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>
        <div class="col-md-12 sky-form">

        <!--Project live apply start-->
        <div class="col-md-12 overflow-h project-live-apply">
        <h3><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_post_a_question')); ?></h3>
        <div class="col-md-12 no-mrg">
        <textarea rows="7" class="form-control margin-bottom-20"></textarea>
        </div>
        <div class="col-md-12 no-mrg">


        <div class="col-md-12 no-mrg border-top">
        <div class="f-right mrg-auto">
        <button onclick="closepopup();" type="button" class="btn-u btn-u-lg rounded btn-u-red push">Cancel</button>
        <button type="button" class="btn-u btn-u-lg rounded btn-u-sea push">Submit</button>
        </div>
        </div>

        </div>
        </div>
        <!--Project live apply start-->


        </div>
<?php $this->endWidget(); ?>
</div>

<div id="applyProposal"  style="display: none" class="col-md-7 sky-form apply-popup" >
  <?php
  //$this->renderPartial('_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals,   'currentUser'=>$currentUser,'bidStatus' => $bidStatus , 'isInvited' => $isInvited));
?>


</div>

