<?php
if( $tasker_status == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
{
    ?>
    <a id="proposalhaired<?php echo $tasker_id ?>" class="btn-u rounded btn-u-sea display-b" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Hired') ?> </a>
    <?php
}
elseif( $tasker_status != Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
{
    ?>
    <a id="proposalAccept<?php echo $tasker_id ?>" onclick = "HireMe('<?php  echo $tasker_id ?>' , ' <?php echo $task_tasker_id ?>')" class="btn-u rounded btn-u-sea display-b" href="javascript:void(0)"> <?php echo Yii::t('poster_taskdetail', 'Hire me') ?> </a>
    <?php
}
?>
