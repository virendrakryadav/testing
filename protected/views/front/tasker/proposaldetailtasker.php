<style>

    </style>
<?php echo CommonScript::loadCreateTaskScript() ?>
<?php
$taskType = (isset($_GET["taskType"])) ? $_GET["taskType"] : '' ;


$user = User::model()->findByPk($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$latitude2 = $task_tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
$longitude2 = $task_tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
$getDistance = 0;

$isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $task->{Globals::FLD_NAME_TASK_ID}, $user->user_id);

if(isset($taskLocation))
{
    $latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
    $longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
    $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}
$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});
$isPremium = CommonUtility::isPremium($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$skills = UtilityHtml::userSkillsCommaSeprated($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$skills = $skills ? $skills : 'No Skills Given';
$task_id = $task->{Globals::FLD_NAME_TASK_ID};
?>
<script>    
$( document ).ready(function() {
  $("#proposalssidebar").mCustomScrollbar();
});
</script>
<div class="container content">

<!--Left side bar start here-->

   <div class="col-md-3">
       <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>

        <!--task type start here-->
        <?php // $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER ));
        /*
        $this->renderPartial('//tasker/_task_search_box_sidebar');
                     
                    $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
                    array(
                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_applied_to')) =>  CommonUtility::getTaskerApplyProjectsUrl(),
                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_saved_projects')) => CommonUtility::getTaskerSavedProjectsUrl(),
                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_active_projects')) => CommonUtility::getTaskerActiveProjectsUrl(),
                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_completed_projects')) => CommonUtility::getTaskerCompletedProjectsUrl(),
                            CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')) => Yii::app()->createUrl('tasker/mytasks'),
                        )
                    ));
        */
        ?>
        
                                <div class="">
                                    <div class="grad-box align-left sky-form ">
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
                                                <div class="col-md-12 no-mrg right-align text-align-right"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                                            </section>

                                            <section class="mrg-botton-13 overflow-h">
                                                <div class="col-md-12 no-mrg">
                                                    <div class="col-md-5 no-mrg">Time Left</div>
                                                    <div class="col-md-7 no-mrg">
                                                        <div class="budget-box text-align-right"><?php 
                                                       // echo $task->{Globals::FLD_NAME_TASK_KIND};
                                                        if( $task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON )
                                                        {
                                                            $daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_END_DATE});
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
        
        <!--task type ends here-->

        <!--Proposal start here-->
        <!--      <div class="box">
                <div class="box_topheading"><h3 class="h3">My Proposals</h3></div>
                <div id="proposalssidebar" class="box2" style="height: 300px">

                    <?php
        //                $this->widget('ListViewWithLoader', array(
        //                    'id' => 'loadAllProposalsSidebar',
        //                    'dataProvider' => $proposals,
        //                    'itemView' => '_viewallproposalssidebar',
        //                    'template'=>'{items}',
        //                    ));
                        ?>
                </div>
            </div>-->
        <!--Proposal Ends here-->
        <?php // $this->renderPartial('//tasker/proposaldetailfilter',array('maxPrice' => $maxPrice ,'minPrice' => $minPrice ,'task' => $task,'proposals' => $proposals));?>
    </div>
    <!--Left side bar ends here-->
    
    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
        <div class="h-tab flat">
        <a href="<?php echo CommonUtility::getTaskListURI(); ?>">All Tasks</a>
        <a href="<?php echo CommonUtility::getChildCategoryURL($task->categorylocale->{Globals::FLD_NAME_CATEGORY_ID}, $task->{Globals::FLD_NAME_TASK_KIND}); ?>"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></a>
        <a href="#" class="active"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></a>
	
        </div>
        <!--Top proposal start here-->
        <?php   $this->renderPartial('//tasker/_projectdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel , 'isProposed' => $isProposed)); ?>
        <?php //   $this->renderPartial('//tasker/_taskdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel , 'noControl' => 1)); ?>
        <!--Top proposal ends here-->       
        <div class="margin-bottom-30">

        <div class="margin-bottom-30">
            <div class="col-md-12 no-mrg">
                <div class="col-md-12 no-mrg">
                    <div class="tasker_row1">                        
                        <div class="proposal_col3">
                             <h3 class=""><?php echo Yii::t('tasker_mytasks', 'Proposal detail')?></h3>
                            <div class="proposal_row2"><strong><?php echo Yii::t('tasker_mytasks', 'Description')?>:</strong> <?php  echo $task_tasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?></div>   
                            <?php
                            $question = TaskQuestion::getTaskQuestion($task_id);
                            
                            $i = 1;                            
                            if($question)
                            {
                            ?>
                            <div class="proposal_row2">
                                <h3><?php echo Yii::t('tasker_mytasks', 'Question answer:')?></h3>
                                <div class="quest_cont">
                                    <ul>
<!--                                    <h2 class="h4"><?php // echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_answers')) ?></h2>-->
                                        <?php
                                        $answers =  CommonUtility::getQuestionAnswerByTasker($task_id, $task_tasker->tasker_id );
                                        if($answers)
                                        {
                                            foreach ($question as $questions)
                                            {
                                            ?>
                                        <li><span class="quescoler">Q.</span><?php echo $i . '. ' . $questions[Globals::FLD_NAME_TASK_QUESTION_DESC]; ?></li>
                                                <li><span class="quescoler"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?></span>  <?php echo $answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}]; ?></li>                                    
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                        <!--    </li>-->

                        <?php $attachments =  UtilityHtml::getProposalAttachments($task_tasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $user->profile_folder_name,$task_tasker->task_tasker_id); 
                        if($attachments)
                        {?>
                        <div class="proposal_row2">
                        <h3 class="quest"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Attachments'));?></h3>
                        <div class="attachrow">
                            <div class="clr-padding-upload"></div>
                            <?php echo $attachments ?>
                            <div class="clr-padding-upload"></div>
                        </div>
                        </div>   
                        <?php
                        }
                        ?>
                        
                        </div>
                    </div>                                                    
               </div>              
<!--            </div>-->
<!--         </div>        -->
            </div>
        </div>
    </div>
    <!--Right side content ends here-->
</div>