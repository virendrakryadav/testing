<?php $isLogin = CommonUtility::isUserLogin(); ?>
<h4><?php echo CHtml::encode(Yii::t('userprofile', 'lbl_task_history')) ?>&nbsp<?php //echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp</h4>

    <div class="controls-row">   
        <?php
        $recentTasks = GetRequest::getTaskerRecentTasks($model->{Globals::FLD_NAME_USER_ID});
        if ($recentTasks) 
        {
            $i=1;
            foreach ($recentTasks as $recentTask) 
            {
                ?>
                <div class="portfolio_cont <?php if($i%3 == 0) echo ''; else echo 'port_rspce'; ?>" id="taskDetail<?php echo $recentTask->{Globals::FLD_NAME_TASK_ID} ?>" id="taskDetail<?php echo $recentTask->{Globals::FLD_NAME_TASK_ID} ?>" >
                    <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($recentTask->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_241_251) ?>"> 

                    <div class="over">

                        <div class="rec_over1">
                            <?php
                            $youHired = GetRequest::getTaskerHiredByUser($model->{Globals::FLD_NAME_USER_ID});
                            if ($youHired)
                            {
                                ?>
                                <div class="workinfo youhired"><span class="hired_count"><?php echo count($youHired); ?></span>
                                    <?php echo CHtml::encode(Yii::t('userprofile', 'lbl_you_hired')) ?>
                                    
                                    <span class="workdetail">
                                        <div class="controls-row">
                                            <?php
                                            foreach ($youHired as $hiredTask) 
                                            {
                                                ?>
                                                <div class="workdetail_row2">
                                                    <div class="workdetail_col1"><?php echo $hiredTask->task->{Globals::FLD_NAME_CREATED_AT} ?></div>
                                                    <div class="workdetail_col2"><a href="#"><?php echo $hiredTask->task->{Globals::FLD_NAME_TITLE} ?></a></div>
                                                    <div class="workdetail_col3"><?php echo Globals::DEFAULT_CURRENCY . intval($hiredTask->task->{Globals::FLD_NAME_PRICE}) ?></div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="workdetail_row3">
                                                <div class="workdetail_col4"><strong>
                                                        <?php echo CHtml::encode(Yii::t('userprofile', 'lbl_note')) ?>:
                             
                                                    </strong> <?php echo CHtml::encode(Yii::t('userprofile', 'you_hired_{n}_times_this_task', array(count($youHired)))) ?>
                                                </div>
                                                <div class="workdetail_col5"><a href="" class="requst_btn"><?php echo CHtml::encode(Yii::t('userprofile', 'lbl_send_request')) ?></a></div>
                                            </div>
                                        </div>
                                    </span>                        
                                </div>
                            <?php
                            }
                            
                            if($isLogin)
                            {
                            ?>
                            <div class="workinfo network"><span class="hired_count">0</span><?php echo CHtml::encode(Yii::t('userprofile', 'lbl_networks')) ?> </div>
                         <?php }   ?><div class="workinfo total"><span class="hired_count">0</span> <?php echo CHtml::encode(Yii::t('userprofile', 'lbl_total')) ?></div>
                        </div>
                    </div>

                    <div class="portfolio_title">
                        <?php  
                        $shortTitle = commonUtility::truncateText($recentTask->task->{Globals::FLD_NAME_TITLE}, Globals::DEFAULT_TASK_TITLE_LENGTH) ;
                                if( $shortTitle )
                                {
                                ?>

                                <?php
                                echo $shortTitle;
                                }
                                else
                                {
                                ?>
                            <?php echo $recentTask->task->{Globals::FLD_NAME_TITLE} ?>  
                        <?php
                            }
                        ?>
                    </div>
                    <div class="portfolio_detail">
                    <?php
                    echo CHtml::ajaxLink(CHtml::encode(Yii::t('userprofile', 'lbl_detail')), Yii::app()->createUrl('userprofile/loadtaskertaskpreview'), array(
                        'beforeSend' => 'function(){$("#loadtaskprasdaseview' . $recentTask->{Globals::FLD_NAME_TASK_ID} . '").addClass("loading");}',
                        'complete' => 'function(){$("#loadtaskprasdaseview' . $recentTask->{Globals::FLD_NAME_TASK_ID} . '").removeClass("loading");}',
                        'data' => array(
                        'taskId' => $recentTask->{Globals::FLD_NAME_TASK_ID}),
                        'type' => 'POST',
                        'success' => 'function(data){
                                                               jQuery("#loadtaskpreview").html(data); 
                                                               jQuery("#loadtaskpreview").css("display","block"); }'), 
                                    array('id' => 'loadtaskprasdaseview' . $recentTask->{Globals::FLD_NAME_TASK_ID},
                        'class' => 'btn-u rounded btn-u-sea push', 'live' => false));
                        ?>	
                    </div>
                </div>
        
                        <?php  $i++;
                    }
                }
                ?>
    </div> 
