<?php
if( $tasker_status == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
{
   ?>
    <a id="proposalReject<?php echo $tasker_id ?>"  onclick = "ShowInterest('<?php  echo $tasker_id ?>' , ' <?php echo $task_tasker_id ?>')" class="btn-u rounded btn-u-blue display-b" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Allow Bid') ?> </a>
    <?php
}
elseif( $tasker_status != Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
{
    ?>
    <a id="proposalReject<?php echo $tasker_id ?>" onclick = "NotInterested('<?php  echo $tasker_id ?>' , ' <?php echo $task_tasker_id ?>')" class="btn-u rounded btn-u-blue display-b" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Remove Bid') ?> </a>
    <?php
}  
?>
