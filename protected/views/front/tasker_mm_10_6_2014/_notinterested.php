<?php
if( $tasker_status == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
{
   ?>
    <a id="proposalReject<?php echo $tasker_id ?>"  onclick = "ShowInterest('<?php  echo $tasker_id ?>' , ' <?php echo $task_tasker_id ?>')" class="connect_btn" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Show interest') ?> </a>
    <?php
}
elseif( $tasker_status != Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
{
    ?>
    <a id="proposalReject<?php echo $tasker_id ?>" onclick = "NotInterested('<?php  echo $tasker_id ?>' , ' <?php echo $task_tasker_id ?>')" class="connect_btn" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Not interested') ?> </a>
    <?php
}  
?>
