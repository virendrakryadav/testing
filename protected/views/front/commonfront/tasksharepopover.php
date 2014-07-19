<?php $taskUrl = CommonUtility::getTaskDetailURI($task_id);
$taskImage = CommonUtility::getTaskImageForShare($task_id);
         $task = Task::model()->findByPk($task_id);
?>

            <div class="social_share social_share_popover"> 
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

 