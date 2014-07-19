<?php

$model = User::model()->findByPk($data->{Globals::FLD_NAME_CREATER_USER_ID});

$isProposed = TaskTasker::isUserProposed(Yii::app()->user->id, $data->{Globals::FLD_NAME_TASK_ID}, $model->user_id);

$taskerProposal = TaskTasker::getUserProposalForTask( $data->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id  );

$taskDetailUrl = CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
$taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
$taskCategory = UtilityHtml::getTaskCategory($data->{Globals::FLD_NAME_TASK_STATE}, $data);
$isLogin = CommonUtility::isUserLogin();
$isPremium = CommonUtility::isPremium($data->{Globals::FLD_NAME_CREATER_USER_ID});
$isPremiumTask = CommonUtility::isPremiumTask($data->{Globals::FLD_NAME_TASK_ID});
$is_Highlighted = $data->is_highlighted;
//echo $data->{Globals::FLD_NAME_TASK_KIND};
if($index%2 == 0)
{
?>
<div class="col-md-12 no-mrg no-overflow">
<?php
}
//echo $data->created_at." = Start Date<br>";
//echo $data->end_date." = End Date<br>";
?>    
    <div class="search_row float-shadow  <?php if ($isPremiumTask){ echo 'task_list ';} else if($is_Highlighted == 1){ echo 'task_list highlights '; } else { echo 'task_list2 '; } ?>">
       
            <div class="proposal_row">
                <div class="col-md-12 no-mrg">
                    <div  class="col-md-10 no-mrg tasker_name ">
                        <a class="taskTitlePublicSearchList" target="_blank" href="<?php echo $taskDetailUrl ?>"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}); ?></a>
                        <a class="taskTitlePublicSearchGrid" style="display: none" target="_blank" title='<?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}); ?>' href="<?php echo $taskDetailUrl ?>"><?php echo commonUtility::truncateText(ucfirst($data->{Globals::FLD_NAME_TITLE}),Globals::DEFAULT_TASK_TITLE_LENGTH); ?></a>
                    </div>
                    <div class="premium-tag"><?php if ($isPremiumTask) echo Yii::t('tasker_mytasks', 'Premium'); ?>
                    </div>
                </div>
                
                
                <div class="proposal_col4 "> <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')) ?>: <?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster($data->{Globals::FLD_NAME_CREATER_USER_ID}) ?></div>
                <div class="proposal_col4 "><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_date')) ?>: <span class="date"><?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}); ?></span></div>
                <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Start Date') ?>: <span class="date"><?php  echo  CommonUtility::projectStartDate($data->{Globals::FLD_NAME_TASK_ID}) ?></span></div>
                <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Category') ?>: <span class="date"> <?php echo $data["categorylocale"][Globals::FLD_NAME_CATEGORY_NAME] ?></span></div>
                <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Location') ?>: <span class="date"><?php echo $taskLocations = UtilityHtml::getSelectedLocationsInComma($data->{Globals::FLD_NAME_TASK_ID}); ?></span></div>                                
            </div>

            <div class="proposal_row">                               
                <div class="total_task4"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Total Proposal') ?></span>
                <?php
                if ($data->{Globals::FLD_NAME_PROPOSALS_CNT} > 0) {
                    ?>
                    <span style="cursor: pointer;" class="countbox popovercontent" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  title='' data-placement='bottom'  data-poload='<?php echo Yii::app()->createUrl('commonfront/taskproposalspopover') . "?" . Globals::FLD_NAME_TASK_ID . "=" . $data->{Globals::FLD_NAME_TASK_ID} ?>' ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                    <?php
                } else {
                    ?>
                <span style="cursor: pointer;" class="countbox" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                <?php
            }
            ?> 
                
                
                
            <div class="total_task4"><span class="counttext">Average price</span> <span class="countbox"><?php echo UtilityHtml::displayPrice($data->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}) ?></span></div>
            </div> 
            <?php 
            $taskSkillCommaSeparated = UtilityHtml::taskSkillsCommaSeparated($data->{Globals::FLD_NAME_TASK_ID});
            if(!empty($taskSkillCommaSeparated))
            {
            ?>
            <div class="proposal_row1 margin-bottom-10"><?php echo UtilityHtml::taskSkillsCommaSeparated($data->{Globals::FLD_NAME_TASK_ID}) ?></div>
            <?php
            }
            else
            {
              ?>
            <div class="proposal_row1 margin-bottom-10">No skill specified</div>
            <?php  
            }
            ?>
            <div class="publctask margin-bottom-10 description-b">
                <article><?php echo $data->{Globals::FLD_NAME_DESCRIPTION}; ?></article></div>

            <div class="proposal_row">
                <a target="_blank" id="saveFilter" class="btn-u rounded btn-u-blue" href="<?php echo $taskDetailUrl ?>">View</a>
                <a href="#" class="btn-u rounded btn-u-default" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $data->{Globals::FLD_NAME_TASK_ID} ?>">Share</a>
               <?php // echo UtilityHtml::taskSharePopover($data->{Globals::FLD_NAME_TASK_ID} , 'share' ,'btn-u rounded btn-u-default');?>
                <div class="btn-u rounded btn-u-sea" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>">
                <?php echo CommonUtility::createorSaveProject(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK,$data->{Globals::FLD_NAME_TASK_ID});?>
                </div>
                <?php
//                echo $data->{Globals::FLD_NAME_TASK_KIND};
                if($data->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id)
                {
                    if(!$data->{Globals::FLD_NAME_HIRING_CLOSED})
                    {
                        if ($isProposed)
                        {
                            ?>
                            <a id="saveFilter" class="btn-u rounded btn-u-aqua" onclick="applyOnClick(<?php echo $data->{Globals::FLD_NAME_TASK_ID}?>);" >Apply</a>
                            <?php
                        }
                        else
                        {
                            if(isset($taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID] ))
                            {
                                ?>
                                <a href="<?php echo CommonUtility::getProposalDetailPageForTaskerUrl($data->{Globals::FLD_NAME_TASK_ID} ,$taskerProposal[Globals::FLD_NAME_TASK_TASKER_ID] ) ?>"  class="btn-u rounded btn-u-sea">View Proposal</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <a href="javascript:void(0)"  class="btn-u rounded btn-u-sea">Only for invited users</a>
                                <?php
                            }
                        }
                    }
                    else
                    {
                        ?>
                        <a href="javascript:void(0)"  class="btn-u rounded btn-u-sea">Hiring Closed</a>
                            <?php
                    } 
                }
                    ?>                                
            </div></div>
<!-- Start for Social Popup -->
    <div style="display: none"  id="social<?php echo $data->{Globals::FLD_NAME_TASK_ID}; ?>" >
        <div class="popup_head margin-bottom-30">
                <h2 class="heading">Share</h2><button type="button" onclick="closepopup();" id="cboxClose">Close</button>
        </div>
        <?php
            $this->renderPartial('//commonfront/tasksharepopover', array('task_id' => $data->{Globals::FLD_NAME_TASK_ID}));
        ?>
    </div>
<!-- end for Social Popup -->
<?php 
if($index%2 != 0)
{
?>
</div>
<?php
}
?>