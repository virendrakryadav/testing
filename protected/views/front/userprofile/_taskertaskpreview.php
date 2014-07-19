<div class="popup_head">
    <h2 class="heading"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></h2><button type="button" onclick="closepopup()" id="cboxClose"><?php echo CHtml::encode(Yii::t('poster_createtask', 'close')); ?></button>
</div>

<div class="box">


    <!--task detail  start here-->
    <div class="controls-row pdn">
        <div class="task_img">

            <?php
            if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                $images = CommonUtility::getPortfolioAttachmentUrlFromJson($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, Globals::DEFAULT_VAL_IMAGE_TYPE);
                $imageCount = 0;
                if (isset($images) && $images != '') {
                    ?><div class="connected-carousels">
                        <div class="stage">
                            <div class="carousel carousel-stage">
                                <ul>
                                    <?php
                                    foreach ($images as $index => $image) {
//                        if($imageCount==0)
//                        {
                                        $imageKey = str_replace($model->profile_folder_name . "/", '', $index);
                                        ?>

                                        <li> <img style="width: 400px;height: 340px"  src="<?php echo $image; ?>" /></li>

                                        <?php
//                        }
                                        $imageCount++;
                                    }
                                    ?>  </ul>
                            </div>

                            <a href="#" class="prev prev-stage"><span>&lsaquo;</span></a>
                            <a href="#" class="next next-stage"><span>&rsaquo;</span></a>
                        </div>
                        <div class="navigation">
                            <a href="#" class="prev prev-navigation">&lsaquo;</a>
                            <a href="#" class="next next-navigation">&rsaquo;</a>
                            <div class="carousel carousel-navigation">
                                <ul>
                                    <?php
                                    foreach ($images as $index => $image) {
//                        if($imageCount==0)
//                        {
                                        $imageKey = str_replace($model->profile_folder_name . "/", '', $index);
                                        ?>

                                        <li> <img  style="width: 50px;height: 50px"  src="<?php echo $image; ?>" /></li>

                                        <?php
//                        }
                                        $imageCount++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div></div>
                    <?php
                }
            }
            ?>

        </div>
        <div class=" <?php if(isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) echo 'task_detail_col'; else echo'task_detail_col1'; ?>">
            <h2 class="h4"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}); ?></h2>
            <div class="controls-row">
                <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_for')) ?></div>
                <div class="task_detail_col3"><?php echo CommonUtility::getUserFullName($task->{Globals::FLD_NAME_CREATER_USER_ID}); ?></div>
            </div>
            <div class="controls-row">
                <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_date')) ?></div>
                <div class="task_detail_col3"><?php 
                if($task->{Globals::FLD_NAME_TASK_FINISHED_ON})
                $endDate = $task->{Globals::FLD_NAME_TASK_FINISHED_ON};
                else
                  $endDate = $task->{Globals::FLD_NAME_TASK_END_DATE};  
                echo CommonUtility::formatedViewDate( $endDate ); ?></div>
            </div>
            <?php
            if($task->{Globals::FLD_NAME_WORK_HRS})
            {
                ?>
               <div class="controls-row">
                <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_hours')) ?></div>
                <div class="task_detail_col3"><?php echo $task->{Globals::FLD_NAME_WORK_HRS}; ?></div>
            </div>
            <?php
            }
            ?>
         
            <div class="controls-row">
                <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_price')) ?></div>
                <div class="task_detail_col3 blue_text"><?php echo   UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE}); ?></div>
            </div>
            <div class="controls-row">
                <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'Task type')) ?></div>
                <div class="task_detail_col3 "><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})) ?></div>
            </div>

            <div class="task_descrip">
                <h4><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_description')) ?></h4>
                <?php echo $task->description; ?>
            </div>
        </div>
    </div>



    <!--task detail ends here-->


</div>

<!--
////
<div class="controls-row pdn4">
    <div class="controls-row">
        Task title start here
        <div class="controls-row">
            <div class="controls-row">
                <div class="taskpreview_img">   
                    <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150"></div>
                <div class="taskpreview_title">
                    <h3 class="h3-1"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></h3>
                    <span class="postedby">Posted by <a href="<?php echo CommonUtility::getTaskerProfileURI($model->{Globals::FLD_NAME_USER_ID}) ?>"><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?></a></span>
                    <span class="postedby"><i class="icon-map-marker"></i><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span>
                    <span class="postedby"><?php echo CommonUtility::agoTiming($task->created_at); ?></span></div>
<?php
$daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
?>
                <div class="estimated">
                    <span>
                        <p>
<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_estimated')); ?>
                        </p>
                        <p class="priceit"><?php echo Globals::DEFAULT_CURRENCY . $task->{Globals::FLD_NAME_PRICE}; ?></p>
                    </span>
                    
                </div>
            </div>
            
        </div>
        Task title ends here


Skills needed ends here

        Description Start here
        <div class="controls-row">
            <h2 class="taskheading">
<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_description')); ?>
            </h2><?php echo $task->description; ?></div>
        Description Ends here

    </div>
</div>-->