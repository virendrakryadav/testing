 <!--Description Start here-->
<h3><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'lbl_description')); ?></h3>
<div class="margin-bottom-20"><?php echo $task->description; ?></div>
<!--Description ends here-->
<?php $attachments =  UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name, $task->{Globals::FLD_NAME_TASK_ID});
if($attachments)
{
 ?>
<!--Attachment Start here-->
<div class="margin-bottom-20">
<h3 class="quest">Attachments</h3>
    <div class="attachrow2">
            <?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name, $task->{Globals::FLD_NAME_TASK_ID}); ?>
    </div>
</div>
<!--Attachment ends here-->
<?php
}
?>