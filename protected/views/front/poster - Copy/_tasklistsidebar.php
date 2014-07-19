<?php
    $taskDetailUrl = CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
    $taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
    $taskCategory = UtilityHtml::getTaskCategory($data->{Globals::FLD_NAME_TASK_STATE}, $data);
?>     
<div class="prvlist_box"> <a href="<?php echo $taskDetailUrl ?>"><img width="71" height="52" src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>"></a>
                    <p class="title"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}); ?></p>
<!--                    <p class="date">Done by : <?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_CREATER_USER_ID} ) ?>     <?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}) ?></p>-->
                    <p><a href="<?php echo $taskDetailUrl ?>" id="loadinstantcategories_542"><?php echo Yii::t('poster_createtask', 'View')?></a></p>
</div>