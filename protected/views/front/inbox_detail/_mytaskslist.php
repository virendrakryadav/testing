<?php 
    $userName = UtilityHtml::getUserFullNameWithPopover($data->{Globals::FLD_NAME_CREATER_USER_ID});
    $taskName = CommonUtility::getTaskName($data->{Globals::FLD_NAME_TASK_ID});
    $description = CommonUtility::truncateText($data->{Globals::FLD_NAME_DESCRIPTION},100);
    $postedDate = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT},'d-m-y');
?>

<div class="inbox_row1">
    <div class="inbox_col1"><?php //echo $i;?>
        <a href="#"><?php echo $taskName ?></a>
    </div>
    <div class="proposal_col4"><span class="date"><?php echo $postedDate ?></span></div>
    <div class="proposal_col4"><a href="#"><?php echo $userName ?></a></div>
    <div class="publctask">
        <div class="inbox_col3"><?php echo $description ?></div>
    </div>
    <div class="reply_col3"><a class="interested_btn" href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark_as_read'))?></a></div>
</div>