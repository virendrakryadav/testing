<?php $isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task->{Globals::FLD_NAME_TASK_ID}, $model->user_id); ?>
<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadAttachmentHideShowScript('SlideAttachments', 'loadAttachment') ?>
<?php
//$getReviews = UtilityHtml::getReviews($task);
$taskerProposal = TaskTasker::getUserProposalForTask($task->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id);
$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});
$cancelStatus = CommonUtility::cancelStatus($task->{Globals::FLD_NAME_TASK_STATE});

$skills = UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID});
$skills = ($skills == '<ul></ul>') ? CHtml::encode(Yii::t('poster_createtask', 'lbl_not_specified')) : $skills;
$bidStatus = ($taskType == Globals::DEFAULT_VAL_I) ?
        UtilityHtml::getBidStatusInstant($task->{Globals::FLD_NAME_END_TIME}) :
        UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_FINISHED_ON});

$isInvited = TaskTasker::isTaskerInvitedForTask($task->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id);
echo $isTaskerSelected = TaskTasker::isTaskerSelectedForTask($task->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id);
$selectedTaskers = TaskTasker::getSelectedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});


//$maxPriceValue = isset($_GET[Globals::FLD_NAME_MAXPRICE]) ? $_GET[Globals::FLD_NAME_MAXPRICE] : $maxPrice;
//$minPriceValue = isset($_GET[Globals::FLD_NAME_MINPRICE]) ? $_GET[Globals::FLD_NAME_MINPRICE] : $minPrice;
$rating = (isset($_GET[Globals::FLD_NAME_RATING])) ? $_GET[Globals::FLD_NAME_RATING] : '' ;
$taskerName = (isset($_GET[Globals::FLD_NAME_USER_NAME])) ? $_GET[Globals::FLD_NAME_USER_NAME] : '' ;
$interest = isset($_GET[Globals::FLD_NAME_INTEREST]) ? $_GET[Globals::FLD_NAME_INTEREST] : '';
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;
$isFieldAccessByTaskTypeVirtual = CommonUtility::isFieldAccessByTaskTypeVirtual($task->{Globals::FLD_NAME_TASK_KIND});



//  $jo='[{"id":1,"name":"jack","age":10,"sex":"male"},{"id":2,"name":"jill","age":8,"sex":"female"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},
//        {"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"}]'; 
////$attachments=json_decode($attachments); //brings array of objects.
//$jo=json_decode($jo); //brings array of objects.
//echo '<pre>';
//print_r($attachments);print_r($jo);
//echo '</pre>';
//exit;
?>
<?php
$this->renderPartial('partial/_project_detail_common', array('task' => $task,
    'model' => $model,
    'question' => $question,
    'taskQuestionReply' => $taskQuestionReply,
    'key' => $key,
    'taskTasker' => $taskTasker,
    'taskLocation' => $taskLocation,
    'proposals' => $proposals,
    'relatedTask' => $relatedTask,
    'taskType' => $taskType,
    'proposalIds' => $proposalIds,
    'currentUser' => $currentUser,
    'message' => $message,
    'messagesOnTask' => $messagesOnTask,));
?>
<?php
Yii::app()->clientScript->registerScript('searchTaskers', "



     "
);
?>
<?php
$coundown = 0;
$parent = Category::getParentCategoryChild($task->categorylocale->{Globals::FLD_NAME_CATEGORY_ID});
?> 

<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->

<div class="container content  ">
    <!--Left side content start here-->
    <div class="col-md-3 leftbar-fix">
        <!-- Dashboard (erandoo) starts here -->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!-- Dashboard (erandoo) ends here -->
        <!--Top search start here-->
        <?php ?>
        <!--Top search Ends here-->

        <div id="leftSideBarScroll">
            <!--Instant Navigations Starts here-->

            <?php echo CHtml::hiddenField(Globals::FLD_NAME_QUICK_FILTER, "", array('id' => 'quickFilterValue')); ?>      
            <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', 'a', array('id' => 'taskStateValue')); ?>

            <?php
            if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
            {
                ?>
                <div class="margin-bottom-30">
                    <input type="button" value="Back" onclick="window.location.href = '<?php echo Yii::app()->request->urlReferrer ?>'" class="btn-u btn-u-lg rounded btn-u-red push">
                    <input type="button" value="Repeat Project"  onclick="window.location.href = '<?php echo CommonUtility::getTaskRepeatUrl($task->{Globals::FLD_NAME_TASK_ID}); ?>'" style="display: inline" class="btn-u btn-u-lg rounded btn-u-sea push">
                </div>
                <?php
                if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                {
                        
                ?>
          
               <!--Filter start here-->
                <div  id="proposalsFilters" class="margin-bottom-30">
                <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                <div class="panel-heading">
                    <h3 class="panel-title no-mrg">
                    <?php echo Yii::t('poster_createtask', 'Filter By')?>  
                        <span class="btn-u rounded btn-u-blue reset-right" id="resetLeftBar">Reset</span>
                        <div class="clr"></div>
                    </h3>
                </div>

                <div class="panel-collapse collapse in sky-form" id="collapseOne">

                <div class="panel-body no-pdn">
                <div class="col-md-12 no-mrg">

                <div class="message-filter">
                   <?php
                    $hired = ($quickFilter == Globals::FLD_NAME_TASKER_STATUS) ? 'active' : '' ;
                    $mostexperienced = ($quickFilter == Globals::FLD_NAME_TASK_DONE_CNT) ? 'active' : '' ;
                    $nearby = ($quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE) ? 'active' : '' ;
                    $rated = ($quickFilter == Globals::FLD_NAME_TASK_DONE_RANK) ? 'active' : '' ;
                    $bookmark = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'active' : '' ;
                    $mostvalued = ($quickFilter == Globals::FLD_NAME_TASKER_PROPOSED_COST) ? 'active' : '' ;
                    $invited = ($quickFilter == Globals::FLD_NAME_SELECTION_TYPE) ? 'active' : '' ;
                    echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); 
                   ?>
                <ul>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Highly Rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most Value')), 'javascript:void(0)', array('id' => 'loadMostValued' , 'class' => $mostvalued)); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most Experienced')), 'javascript:void(0)', array('id' => 'loadMostExperienced' , 'class' => '')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Near Me')), 'javascript:void(0)', array('id' => 'loadNearby' , 'class' => $nearby)); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $bookmark)); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previously Hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired)); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Invited')), 'javascript:void(0)', array('id' => 'loadInvited' , 'class' => $invited)); ?></li>
                </ul>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="clr"></div>
                </div>
               <?php
                }
                ?>
                <!--                    <div class="margin-bottom-30">
                                        <input class="btn-u btn-u-lg rounded btn-u-red push" type="button" value="Cancel" onclick="window.location.href = '/greencometdev/index/dashboard'">
                                        <a class="btn-u btn-u-lg rounded btn-u-red push" href="<?php echo CommonUtility::getCreateTaskUrl(); ?>">Back</a>
                
                                        <a class="btn-u rounded btn-u-sea display-b" href="<?php echo CommonUtility::getCreateTaskUrl(); ?>">Repeat Project</a>
                                        <a class="btn-u rounded btn-u-sea display-b text-16" href="<?php echo CommonUtility::getCreateTaskUrl(); ?>">Post a New Project</a>
                                    </div>-->
    <?php
//                    $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER  , 'menusLinks' => 
//                          array(
////                                CHtml::encode(Yii::t('poster_projectdetail', 'Bid Proposals')) => CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID}) ,
//                                CHtml::encode(Yii::t('poster_projectdetail', 'Search Members')) => CommonUtility::getPosterSearchMembersUrl() ,
//                                CHtml::encode(Yii::t('poster_projectdetail', 'Currently Hiring')) => CommonUtility::getPosterCurrentryHiringUrl(),
//
//                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_active_projects')) => CommonUtility::getPosterActiveProjectsUrl(),
//                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_completed_projects')) => CommonUtility::getPosterCompletedProjectsUrl(),
//                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')) => CommonUtility::getPosterAllProjectsUrl(),
//                          )
//                      )); 
    ?>
<!--                <div class="notifi-set margin-bottom-30">
                    <ul>
                        <li><a href="<?php echo CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_view_proposals')); ?></a></li>

                        <?php
//                        if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} <= 0)
//                        {
//                            ?>
                            <li><a href="//<?php echo CommonUtility::getTaskEditUrl($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_edit_project')); ?></a></li>
                            //<?php
//                        }
                        ?>
                <li id="doerTermsPayment" onclick="modifyTermsPayment('<?php //echo $task->{Globals::FLD_NAME_TASK_ID} ?>')" style="display: none"><a href="javascript:void(0)"><?php //echo Yii::t('poster_projectdetail', 'Modify Terms & Payment') ?></a></li>
                        <li>
                            <?php
//                            if ($cancelStatus)
//                            {
//    //                                        echo '<a id="canceledtask'.$task->{Globals::FLD_NAME_TASK_ID}.'" onclick="cancelTask('.$task->{Globals::FLD_NAME_TASK_ID}.' , "refresh","'.$task->{Globals::FLD_NAME_TASK_STATE}.'")" class="" href="javascript:void(0)">Cancel Project</a>';
//                                ?><a id="canceledtask<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>" onclick="cancelTask('<?php echo $task->{Globals::FLD_NAME_TASK_ID}; ?>', 'refresh', '<?php echo $task->{Globals::FLD_NAME_TASK_STATE}; ?>')" class="" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_cancel_project')); ?></a><?php
//                            } 
//                            else 
//                            {
//                                echo '<a id="canceledtask' . $task->{Globals::FLD_NAME_TASK_ID} . '" class="" href="javascript:void(0)">Canceled</a>';
//                            }
                            ?>
                        </li>
                        <?php
//                        $selectedTaskers = TaskTasker::getSelectedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
//                        if ($selectedTaskers) 
//                        {
//                            if (count($selectedTaskers) > 1) 
//                            {
//                            ?>
                                <li><a href="//<?php echo CommonUtility::getPosterTaskRequestUrl($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_request_job_complete')); ?></a></li>
                            //<?php
//                            }
//                        }
                        ?>
                    </ul>
                </div>-->
              

                <!--        <div id="doerJobType" style="display: none" class="margin-bottom-30">
                                        <h3 class="quest">Job Type</h3>
                                        <div class="grad-box vtableft">
                                        <div class="vtab2">
                                        <ul><?php //echo $task->{Globals::FLD_NAME_PAYMENT_MODE}; ?>
                                            <li><a id="paymentModeHourly" class="<?php if ($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY) echo 'active' ?>" onclick="setJobType( '<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>' ,'<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY ?>')" href="javascript:void(0)">Hourly</a></li>
                                            <li><a id="paymentModeFixed" class="<?php if ($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE) echo 'active' ?>"  onclick="setJobType('<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>' ,'<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE ?>')" href="javascript:void(0)">Fixed</a></li>
                                        </ul>
                                        </div>
                                        <div class="clr"></div> 
                                        </div>
                                        </div>-->
            <?php
            }
            else 
            {
    // $this->renderPartial('//tasker/_task_search_box_sidebar');
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
                <?php
                if (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID]) && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS]))
                {
                    ?>
                        <input type="button" value="Back" onclick="window.location.href = '<?php echo Yii::app()->request->urlReferrer ?>'" class="btn-u btn-u-lg rounded btn-u-red push">
                        <input type="button" value="Edit Proposal"  onclick="editAppliedProposal('<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>','<?php echo $taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID]; ?>')" class="btn-u btn-u-lg rounded btn-u-sea push">
                    <?php
                } 
                else 
                {
                    ?>
                        <a class="btn-u rounded btn-u-red display-b text-16" href="<?php echo Yii::app()->request->urlReferrer ?>"><?php echo CHtml::encode(yii::t('poster_projectdetail', 'lbl_back')); ?></a>
                        <!--<input type="button" value="Back" onclick="window.location.href = '<?php echo Yii::app()->request->urlReferrer ?>'" class="btn-u rounded btn-u-sea display-b text-16">-->
                    <?php
                }
                ?>
                </div>
           
                <!--Budget Start here-->
                <div class="clr"></div>
                <div class="">
                    <div class="grad-box align-left sky-form ">
                        <div class="col-md-12">
                            <h3><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_budget')); ?></h3>
                            <section class="mrg-botton-13 overflow-h">
                                <div class="col-md-12 no-mrg">
                                    <div class="col-md-55">
                                        <div class="budget-box text-align-right"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_MIN_PRICE}); ?></div>
                                    </div>
                                    <div class="col-md-22">To</div>
                                    <div class="col-md-55">
                                        <div class="budget-box text-align-right"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_MAX_PRICE}); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12 no-mrg right-align text-align-right"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                            </section>

                            <section class="mrg-botton-13 overflow-h">
                                <div class="col-md-12 no-mrg">
                                    <div class="col-md-5 no-mrg">Time Left</div>
                                    <div class="col-md-7 no-mrg">
                                        <div class="budget-box text-align-right"><?php
                                            // echo $task->{Globals::FLD_NAME_TASK_KIND};
                                            if ($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON) 
                                            {
                                                $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_END_DATE});
                                            } 
                                            else 
                                            {
                                                $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                                            }
                                            if ($daysleft['m'] >= 1)
                                                echo $daysleft['m'] . 'm,' . $daysleft['d'] . 'd';
                                            else
                                                echo $daysleft['d'] . 'd';

                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="mrg-botton-13 overflow-h">
                                <div class="col-md-12 no-mrg">
                                <?php
                                if ($task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id && $task->{Globals::FLD_NAME_CREATOR_ROLE} == Globals::DEFAULT_VAL_CREATOR_ROLE_POSTER)
                                {
                                    if (!$task->{Globals::FLD_NAME_HIRING_CLOSED}) 
                                    {
                                        if ($isProposed)
                                        {
                                            ?>
                                            <a href="javascript:void(0)" onclick="applyForTask()"  class="btn-u btn-u-lg rounded btn-u-sea display-b"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_apply')); ?></a>
                                            <?php
                                        } 
                                        else 
                                        {
                                            if (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID]) && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS])) {
                                            ?>
                                        <!--<a href="<?php //echo CommonUtility::getProposalDetailPageForTaskerUrl($task->{Globals::FLD_NAME_TASK_ID}, $taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID]) ?>"  class="btn-u btn-u-lg rounded btn-u-sea display-b"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_view_proposal')); ?></a>-->
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="javascript:void(0)"  class="btn-u btn-u-lg rounded btn-u-red display-b"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_only_for_invited_users')); ?></a>
                                                <?php
                                            }
                                        }
                                    } 
                                    else 
                                    {
                                        ?>
                                        <a href="javascript:void(0)"  class="btn-u btn-u-lg rounded btn-u-sea display-b"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_hiring_closed')); ?></a>
                                        <?php
                                    }
                                } 
                                else 
                                {
                                    if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                                    {
                                        ?>
                                        <a href="<?php echo CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID}) ?>"  class="btn-u btn-u-lg rounded btn-u-sea display-b"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_view_proposal')); ?></a>
                                        <?php
                                    }
                                    else
                                    {
                                        echo UtilityHtml::getTaskUpdateUrl($task->{Globals::FLD_NAME_TASK_ID});
                                    }
                                }
                                    ?>
                                </div>
                            </section>

                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <!--Budget Ends here-->
                                    <?php
            }
                                ?>
        </div>
    </div>
     <?php   
    if ($task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id) 
    { ?>
        <!--Left side content ends here-->
        <div id="applyProposal"  style="display: none" class="col-md-7 sky-form apply-popup" >
        <?php
        $this->renderPartial('_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals, 'currentUser' => $currentUser, 'bidStatus' => $bidStatus, 'isInvited' => $isInvited));
        ?>
        </div>
    <?php
    }
    ?>
    <!--Right side bar start here-->
    <div class="col-md-9 right-cont ">
        <div class="sky-form"> 
            <div class="h-tab flat">
            <?php   
            if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id) 
            { ?>
                <a href="<?php echo CommonUtility::getPosterAllProjectsUrl(); ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')); ?></a>
                <?php
            } 
            else 
            {
                ?>
                <a href="<?php echo CommonUtility::getTaskListURI(); ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')); ?></a>
                <?php
            }
            ?>
<!--        <a href="<?php echo CommonUtility::getTaskListURI(); ?>"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></a>
        <a href="<?php //echo CommonUtility::getParentCategoryURL($parent->parentName->{Globals::FLD_NAME_CATEGORY_ID} , $task->{Globals::FLD_NAME_TASK_KIND});  ?>"><?php //echo $parent->parentName->{Globals::FLD_NAME_CATEGORY_NAME}  ?></a>-->
                <a href="<?php echo CommonUtility::getChildCategoryURL($task->categorylocale->{Globals::FLD_NAME_CATEGORY_ID}, $task->{Globals::FLD_NAME_TASK_KIND}); ?>"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></a>
                <a href="#" class="active"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></a>

            </div>

            <?php
            if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
            {
                if ($selectedTaskers)
                {
                    // print_r($selectedTaskers);
                    if (count($selectedTaskers) > 1)
                    {
                        ?>
                        <div class="margin-bottom-30">
                            <div class="col-md-12 no-mrg">
                                <div class="col-md-2 overflow-h no-mrg3">
                                    <label class="label text-size-18" for="exampleInputEmail1"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_select_doer')); ?></label> 
                                </div>
                                <div class="col-md-10 overflow-h no-mrg3">
                                <?php
                                $listUsers = CHtml::listData($selectedTaskers, Globals::FLD_NAME_TASKER_ID, "user.firstname");
                                echo CHtml::dropDownList('currentaskers', '', $listUsers, array('class' => 'form-control mrg3', 'empty' => 'All',
                                    'onchange' => 'selectCurrentUser(this.value);'));
                                ?>
                                </div>


                            </div>
                        </div> 
                            <?php
                    } 
                    else 
                    {
                        ?>
                        <script>
                            $(document).ready(function() 
                            {
                                currentUserParts('<?php echo $selectedTaskers[0]->{Globals::FLD_NAME_TASKER_ID} ?>');
                            });
                        </script>
                        <?php
                        echo CHtml::hiddenField('currentaskers', $selectedTaskers[0]->{Globals::FLD_NAME_TASKER_ID}, array('id' => 'currentaskers'));
                    }
                }
            }
            ?>
            <?php
            if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
            {
                ?>
                <div class="margin-bottom-30">
                <div class="col-md-12 nopad">
                <div class="col-md-10 nopad">
                    <h3 class="quest">Hiring</h3>
                </div>
                <div class="col-md-2 nopad">
                        <?php
                        if ($task->{Globals::FLD_NAME_HIRING_CLOSED} == 0) 
                        {
                            $switch = 1;
                            $disabled = false;
                        }
                        else
                        {
                            $switch = 0;
                            $disabled = true;
                        }
                        $isHihglight = Globals::FLD_NAME_TASK . "[" . Globals::FLD_NAME_HIRING_CLOSED . "]";
                        $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
                            'name' => $isHihglight,
                            'value' => $switch,
                            'events' => array('switch-change' => 'function (e, data) { 
                                    
                                                jConfirm(\'Are you sure you want to close hiring for this project?\', \'Confirmation Hiring\', function(r) {
                                                    if( r == true)
                                                    {
                                                        var $el = $(data.el) , value = data.value;
                                                        if(!value)
                                                        {
                                                             setTaskHiring("' . $task->{Globals::FLD_NAME_TASK_ID} . '");
                                                        }

                                                    }
                                                    else
                                                    {
                                                        $(\'#Task_hiring_closed\').parent().removeClass(\'switch-off\');
                                                        $(\'#Task_hiring_closed\').parent().addClass(\'switch-on\');
                                                        $(\'#Task_hiring_closed\').prop(\'disabled\', false);
                                                        $(\'#Task_hiring_closed\').prop(\'checked\', true);
                                                    }
                                                    
                                                });

                                                       
                                                        
                                                    }'
                            ),
                            'htmlOptions' => array('disabled' => $disabled, 'onclick' => 'alert();')
                        ));
                        ?>

                        <div class="clr"></div>
                    </div>
                </div>
                    
                    
                </div>
            <?php
            }
            ?>
            <div class="margin-bottom-30">
                <!--Top proposal start here-->
            <?php $this->renderPartial('//tasker/_projectdetailupperbar', array('task' => $task, 'isTaskCancel' => $isTaskCancel, 'isProposed' => $isProposed ,'cancelStatus' => $cancelStatus)); ?>
                <!--Top proposal ends here--> 
            </div>
        <?php 
        if(Yii::app()->user->hasFlash('success')):?>
            <div class="clr"></div>
            <div onclick="$('#successNotiMsg').parent().fadeOut();" class="alert alert-success fade fade-in-alert">
                <button onclick="$('#successNotiMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
                <div id="successNotiMsg" >
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            </div>
        <?php endif; ?>
         

        <?php
                if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
                {
                    if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                    {
                        ?>
                        <div class="clr"></div>
                        <div id="taskDetailHeader" class="grad-box margin-top-bottom-20 no-border">
                            <div id="tabStractureForPoster" class="vtab">
                                <ul>
                                    <li><a id="viewDescriptionTitle" onclick="viewDescription()"  href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_description')); ?></a></li>
                                    <li><a id="viewMessageTitle" onclick="viewMessage()" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_messages')); ?></a></li>
                                    <li style="display: none"  id="viewFilesTitle"  ><a  onclick="viewFiles()" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_files')); ?></a></li>
                                    <li><a id="viewProposalsTitle" onclick="viewProposals()" class="active" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_proposals')); ?></a></li>
                                </ul>
                            </div>
                            <div class="clr"></div> 
                        </div>
                <?php
                    }
                }
                ?>
            <?php
            if ($task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id) 
            {
                if (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID]) && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS]) )
                {
                            ?>
                    <div class="clr"></div>
                    <div id="taskDetailHeader" class="grad-box margin-top-bottom-20 no-border">
                        <div id="tabStractureForPoster" class="vtab">
                            <ul>
                                <li><a id="viewDescriptionTitle" onclick="viewDescription()"  href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_description')); ?></a></li>
                                <li><a id="viewMessageTitle" onclick="viewMessage()" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_messages')); ?></a></li>
                                <li><a id="viewProposalsTitle" onclick="viewProposals()" class="active" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'Proposal')); ?></a></li>
                            </ul>
                        </div>
                        <div class="clr"></div> 
                    </div>            
                <?php
                } 
            }
            ?>

            <div  class="margin-bottom-30">
                <div class="col-md-12 no-mrg">
                    <div style="display: 
                    <?php 
                    if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0 && $task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id ) 
                    {
                        echo 'none';
                    }
                    elseif (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID])  && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS])) 
                    {
                        echo 'none';
                    }
                    else
                    {
                         echo 'block';
                    } 
                    ?>"  id="viewDescription" >
                        <?php $this->renderPartial('partial/_view_project_description', array('task' => $task, 'model' => $model)); ?>    
                    </div>

                    <!--Questions ends here-->
                    <div id="viewmasseges" style="display: <?php 
                        if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id) 
                        {
                            if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                            {
                                echo 'none';
                            } else 
                            {
                                echo 'block';
                            }
                        } 
                        elseif (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID])  && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS]))
                        {
                            echo 'none';
                        }
                        else
                        {
                             echo 'block';
                        }
                        ?>" 
                        class="margin-bottom-20">
                            <?php $this->renderPartial('partial/_view_project_messages', array('task' => $task, 'model' => $model, 'message' => $message, 'messagesOnTask' => $messagesOnTask)); ?>    
                    </div>

                    <?php
                    if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id) 
                    {
                        ?>
                        <div id="viewFiles" style="display: none" class="col-md-12 no-mrg">
                        <?php $this->renderPartial('partial/_view_project_files', array('task' => $task, 'model' => $model, 'attachments' => $attachments)); ?>    
                        </div>

                        <div id="viewProposals" style="display: <?php if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0) {
                                echo 'block';
                            } else {
                                echo 'none';
                            } ?>"  class="margin-bottom-30">
                            <?php $this->renderPartial('partial/_view_project_proposals', array('task' => $task, 'model' => $model, 'proposals' => $proposals, 'taskLocation' => $taskLocation, 'isTaskCancel' => $isTaskCancel, 'proposalIds' => $proposalIds)); ?>    

                            <?php  //$this->renderPartial('partial/_view_doer_proposal',array('task' => $task ,'model' =>$model , 'proposals'=>$proposals,'taskLocation' => $taskLocation, 'isTaskCancel' => $isTaskCancel , 'taskerProposal' => $taskerProposal)); ?>    

                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id) 
                    {
                        if (isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID])  && isset($taskerProposal[Globals::FLD_NAME_TASKER_POSTER_COMMENTS])) 
                        {
                                    ?>
                                       <div id="viewProposals" class="margin-bottom-30">
                                     <?php  $this->renderPartial('partial/_view_doer_proposal',array('task' => $task ,'model' =>$model , 'proposals'=>$proposals,'taskLocation' => $taskLocation, 'isTaskCancel' => $isTaskCancel , 'taskerProposal' => $taskerProposal)); ?>    

                                    </div>           
                        <?php
                        } 
                    }
                    ?>
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
                        <button onclick="closepopup();" type="button" class="btn-u btn-u-lg rounded btn-u-red push"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_cancel')); ?></button>
                        <button type="button" class="btn-u btn-u-lg rounded btn-u-sea push"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_submit')); ?></button>
                    </div>
                </div>

            </div>
        </div>
        <!--Project live apply start-->


    </div>
<?php $this->endWidget(); ?>
</div>
 <div id="overlaytaskDetail" onclick="hireDoerClosePopup();" class="overlayPopup " style="display: none" ></div>
<div id="doerHireMePopup" class="windowpoposal taskdetailpopup doerHireByPosterPopup"  style="display: none">
    <?php  $this->renderPartial('//tasker/partial/_tasker_hireme_popup_before',array('task' => $task ,'model' =>$model , 'message'=>$message)); ?>    
</div>

