<div class="proposal_cont">
<div class="proposal_list">
<div class="tasker_row1">
<div class="proposal_prof2"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>"></div>
<div class="proposal_col">
<div class="proposal_row">
<p class="proposal_title"><a href="#"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a></p>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_post_date')?>: <span class="date"> <?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_bid_start_date')?>: <span class="date"> <?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_BID_START_DATE}) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Task type')?>: <span class="date"> <?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Category')?>:<span class="date"> <?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Estimated price')?>:<span class="date"> <?php echo Globals::DEFAULT_CURRENCY . intval($task->{Globals::FLD_NAME_PRICE}); ?></span></div>

<div class="controls-row">
<div class="proposal_col4">
    <span class="mile_away">
        <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/taskskillspopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>">Skills</a>
    </span>
</div>
<div class="proposal_col4">
    <span class="mile_away">
        <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasklocationspopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>">Location</a>
    </span>
</div>
<?php
//if( $isTaskCancel )
//{
    ?>
<!--    <div class="proposal_col4">
        <span class="mile_away">

            <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>">Share</a>
        </span>
    </div>-->
<?php
//}
?>
</div>
</div>  
</div>
<div class="proposal_row3">
<div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_createtask', 'Total Proposal')?></span> 
<!--    <span class="countbox"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>-->
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
<div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_createtask', 'Average rating')?></span> <span class="countbox">
            <?php echo UtilityHtml::getDisplayRating($task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?>
        </span>
</div>
<div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_createtask', 'Average price')?></span> <span class="countbox"><?php echo Globals::DEFAULT_CURRENCY.intval($task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}) ?></span></div>
<?php if(!isset($noControl))
{
    ?>
<!--<div class="total_task3">-->
    <?php
//    if( $isTaskCancel )
//    {
//        echo '<a id="canceledtask'.$task->{Globals::FLD_NAME_TASK_ID}.'" onclick="cancelTask('.$task->{Globals::FLD_NAME_TASK_ID}.' , \'refresh\')" class="btn" href="#">Cancel</a>';
//            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Cancel')), Yii::app()->createUrl('poster/canceltask'), array(
//            'beforeSend' => 'function(){$("#canceltask'.$task->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
//            'complete' => 'function(){$("#canceltask'.$task->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
//            'dataType' => 'json', 
//            'data' => array('taskId' => $task->{Globals::FLD_NAME_TASK_ID}), 
//            'type' => 'POST', 
//            'success' => 'function(data){ 
//                                            if(data.status==="success")
//                                            {
//                                                window.location.reload(true);
//                                            }
//                                        }'), 
//            array('id' => 'canceltask'.$task->{Globals::FLD_NAME_TASK_ID}, 'class' => 'btn',                       
//            "onclick"=>"return confirm('".Yii::t('tasker_mytasks','Are you sure to cancel this task !!!')."')",
//            'live' => false));
//    }
//    else
//    {
//        echo '<a id="canceledtask'.$task->{Globals::FLD_NAME_TASK_ID}.'" class="btn" href="#">Canceled</a>';
//
//    }
    ?>

<!--</div>-->
<!--                        <div class="total_task3"><input type="button" name="" value="Share" class="btn"></div>-->
<!--<div class="total_task3">
    <?php
//    if( $isTaskCancel )
//    {
//        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/edittask'), array(
//        'beforeSend' => 'function(){$("#edittask'.$task->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
//        'complete' => 'function(){$("#edittask'.$task->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
//        'dataType' => 'json', 
//        'data' => array('taskId' => $task->{Globals::FLD_NAME_TASK_ID}, 'category_id' => $task->categorylocale->category_id, 'formType' => 'virtual','onlyform' => '1'), 
//        'type' => 'POST', 
//        'success' => 'function(data){ loadpopup(data.form , "" , "formedit"); }'), 
//        array('id' => 'edittask'.$task->{Globals::FLD_NAME_TASK_ID}, 'class' => 'btn', 'live' => false));
//    }
    ?>
</div>-->
<?php
}
?>

<!--<div class="total_task3"><input type="button" name="" value="View" onclick="window.location = '<?php echo CommonUtility::getTaskDetailURI( $task->{Globals::FLD_NAME_TASK_ID} ) ?>'" class="btn"></div>
<div class="total_task3"><input type="button" name="" value="Cancel" onclick="window.location = ''" class="btn"></div>-->
</div>            

</div>
</div>
</div>