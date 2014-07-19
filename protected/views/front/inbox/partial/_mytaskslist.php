<?php 
//echo $data->inboxuser->{Globals::FLD_NAME_MSG_FLOW};
//if($data->inboxuser->{Globals::FLD_NAME_MSG_FLOW} == Globals::DEFAULT_VAL_MSG_FLOW_SENT)
//{
//    //$userName = CommonUtility::getUsersNameByMultipleIds($data->{Globals::FLD_NAME_TO_USER_IDS});
//     $userName = UtilityHtml::getUserFullNameWithPopover($data->{Globals::FLD_NAME_TO_USER_IDS} ,'bottom' ,'javascript:void(0)');
//}
//else
//{
    $userName = UtilityHtml::getUserFullNameWithPopover($data->{Globals::FLD_NAME_FROM_USER_ID} ,'bottom' ,'javascript:void(0)');
//}
//  echo $currentTask;
//    echo '<br>';
//    echo $toUserIds;
//     echo '<br>';
//    echo $fromUserId;
//    echo $index;
$taskName = CommonUtility::getTaskName($data->{Globals::FLD_NAME_TASK_ID});
$description = CommonUtility::truncateText($data->{Globals::FLD_NAME_BODY},100);
$postedDate = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
?>

<!--<div class="inbox_row1">
    <div class="inbox_col1"><?php //echo $i;?>
        <a href="#"><?php echo $taskName ?></a>
    </div>
    
    <div class="proposal_col4"><span class="date" style="margin-left: 5px;"><?php echo $postedDate ?></span></div>
    <div class="proposal_col4"><a href="#"><?php echo $userName ?></a></div>
    <div class="publctask">
        <div class="inbox_col2"><input type="checkbox" name="" value="" class="checkbox1"> </div>
        <div class="inbox_col3"><?php echo $description ?></div>
    </div>
</div>-->
<div class="rowselector">
<div id="tm_<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?><?php echo $data->{Globals::FLD_NAME_TO_USER_IDS} ?><?php echo $data->{Globals::FLD_NAME_FROM_USER_ID} ?>" class="inbox_row1 
    <?php
    
    if($currentTask == $data->{Globals::FLD_NAME_TASK_ID} && $toUserIds == $data->{Globals::FLD_NAME_TO_USER_IDS} && $fromUserId == $data->{Globals::FLD_NAME_FROM_USER_ID} )
    {
        echo 'active';
    }
//    if($index == 0)
//    {
//        echo 'active';
//    }
    ?> " 
    onclick="selectTaskForMessages('<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>' , '<?php echo $data->{Globals::FLD_NAME_FROM_USER_ID} ?>', '<?php echo $data->{Globals::FLD_NAME_TO_USER_IDS} ?>' )">
<div class="inbox_col">
<a href="javascript:void(0)"><?php echo $taskName ?></a></div>
<div class="proposal_col4 "><span class="date"><?php echo $postedDate ?></span></div>
<div class="proposal_col4 "><?php echo $userName ?></div>
<div class="publctask">
<div class="inbox_col3"><?php echo $description ?></div></div>
</div>
</div>