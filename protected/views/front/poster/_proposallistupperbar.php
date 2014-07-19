<?php
$taskDetailUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID});
$isOpenTask = CommonUtility::IsTaskStateOpen($task->{Globals::FLD_NAME_TASK_STATE});
?>
<div class="proposal_cont">
<div class="proposal_list">
<div class="tasker_row3">
<div class="proposal_row">
<div class="col-md-12 no-mrg">
<div class="col-md-7 no-mrg"><h3 class="pro-title"><a target="_blank" href="<?php echo $taskDetailUrl;?>"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a></h3></div>
<div class="col-md-5 f-right no-mrg">
<?php if($isOpenTask)
{ 
?>
<div class="proposal_link"><a href="#" onclick="cancelTask(<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>)">Cancel</a></div>
<!--<div class="proposal_link"><a href="<?php echo CommonUtility::getTaskUpdateUrl($task->{Globals::FLD_NAME_TASK_ID});?>">Edit</a></div>-->
<!--<div class="proposal_link"><a href="<?php // echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID});?>">View</a></div>-->
<?php
}
?>

<div class="proposal_link"><a href="#" style="overflow:hidden;" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>">Share</a>
</div>
<div class="proposal_link"><a target="_blank" href="<?php echo $taskDetailUrl;?>" style="overflow:hidden;">View</a></div>
</div>
</div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_proposaldetail','Posted');?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_proposaldetail','Start Date');?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_BID_START_DATE}) ?> </span></div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_proposaldetail','Type');?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Category')?>: <span class="date"> <?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></span></div>
</div>              
<div class="proposal_row3">
  <div class="total_task2">
      <span class="counttext"><?php echo Yii::t('poster_createtask', 'Total Proposal')?></span> 
      <?php
    
    if( $task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
            {
                ?>
       <span style="cursor: pointer;" class="countbox popovercontent" id="lbl_invited<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>"  title='' data-placement='bottom'  data-poload='<?php echo Yii::app()->createUrl('commonfront/taskproposalspopover')."?".Globals::FLD_NAME_TASK_ID."=".$task->{Globals::FLD_NAME_TASK_ID} ?>' ><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>
                <?php
            }
            else
            {
                ?>
                <span style="cursor: pointer;" class="countbox" id="lbl_invited<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>"  ><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>
                <?php
            }
    ?>

  </div>
  <div class="total_task2">
      <span class="counttext"><?php echo Yii::t('poster_createtask', 'Average rating')?></span> 
      <span class="countbox"><?php echo UtilityHtml::getDisplayRating($task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?></span>
  </div>
  <div class="total_task2">
      <span class="counttext"><?php echo Yii::t('tasker_proposaldetail','Average Exp');?></span>
      <span class="countbox"><?php echo intval($task->{Globals::FLD_NAME_PROPOSALS_AVG_EXPERIENCE}) ?></span>
  </div>
  <div class="total_task2">
      <span class="counttext"><?php echo Yii::t('poster_createtask', 'Average price')?></span> 
      <span class="countbox"><?php echo Globals::DEFAULT_CURRENCY.intval($task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}) ?></span>
  </div>

</div>
</div>
</div>
</div>