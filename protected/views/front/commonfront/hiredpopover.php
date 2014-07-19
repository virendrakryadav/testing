<div class="col-md-4-doerlist">
<?php if($tasks)
{
     $i= 0;
    foreach ($tasks as $task)
    {
        ?>
        <div class="col-md-12 margin-bottom-10 border-bot1">
            <div class="col-md-12 align-center mrg10"><?php  echo $task->task->{Globals::FLD_NAME_TITLE}; ?></div>
        </div>
    <?php
         $i++;
    }
  
     if($i >= Globals::DEFAULT_VAL_LIMIT_IN_POPOVER )
    {
        ?>
    <div class="col-md-12 margin-bottom-10 align-center"><a target="_blank" href="<?php echo CommonUtility::getTaskSearchUrlByUserHired($user_id) ?>" class="color-orange">View All</a></div>
        <?php
    }
}
?>

</div>