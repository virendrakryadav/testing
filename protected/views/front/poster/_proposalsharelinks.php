<?php $taskUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); 
    $taskImage = CommonUtility::getTaskImageForShare($task->{Globals::FLD_NAME_TASK_ID});
?>
<div class="panel panel-default margin-bottom-20 sky-form">
    <div class="panel-heading">
        <h3 class="panel-title"><a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse">
        <?php echo Yii::t('poster_createtask', 'txt_share_this_project')?>
        <span class="accordian-state"></span></a>
        </h3>
    </div>
    <div class="panel-collapse collapse in" id="collapseTwo">
        <div class="panel-body no-pdn">
            <div class="col-md-12 no-mrg">
                <div class="col-md-12 pdn-auto2">
                    <div class="col-md-12 no-mrg">
                        <div class="share_praposal"><i class="fa fa-link"></i><?php echo $taskUrl ?></div>
                    </div>
                    <div class="col-md-12 no-mrg">
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
        </div>
    </div>
</div>