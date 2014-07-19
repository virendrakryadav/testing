<?php $taskUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); 
    $taskImage = CommonUtility::getTaskImageForShare($task->{Globals::FLD_NAME_TASK_ID});
?>
<div class="box">
    <div class="box_topheading"><h3 class="h3"><?php echo Yii::t('poster_createtask', 'Share this task')?></h3></div>
    <div class="box2">
        <div class="controls-row">
            <div class="share_praposal"><i class="icon-link"></i><?php echo $taskUrl ?></div>
            <div class="share_link"> 
                <?php
                $this->widget('ext.Social.SocialShareWidget', array(
                                'url' => $taskUrl,
                                'media' => $taskImage,
                                'description' => $task->{Globals::FLD_NAME_DESCRIPTION},//required
                                'services' => array('facebook','google', 'twitter','pinterest', 'linkedin'),		//optional
                                'htmlOptions' => array('class' => 'share_link'),	//optional
                                'popup' => true,								//optional
                        ));
                ?>
            </div>
        </div>
    </div>
</div>