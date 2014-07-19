
    <div class="popup_head">
        <h2 class="heading"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></h2><button type="button" onclick="document.getElementById('loadtaskpreview').style.display='none';" id="cboxClose">Close</button>
      </div>    
        <div class="controls-row pdn4">
            <div class="controls-row">
                <!--Task title start here-->
                <div class="controls-row">
                    <div class="controls-row">
                        <div class="taskpreview_img">   
                            <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150"></div>
                        <div class="taskpreview_title">
                            <h3 class="h3-1"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></h3>
                            <span class="postedby"><?php echo Yii::t('poster_createtask', 'lbl_posted_by')?> <a href="<?php echo CommonUtility::getTaskerProfileURI($model->{Globals::FLD_NAME_USER_ID}) ?>"><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?></a></span>
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
                    <div class="taskcount">
                        <div class="taskcount_col1"><span class="point">0</span><br/>
                            <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?>
                        </div>
                        <div class="taskcount_col1"><span class="point">0</span><br/>
                            <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')); ?>
                        </div>
                        <div class="taskcount_col1"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
                        
                    <div class="datecount_col1"><?php //
                    //
//                        if($taskType == Globals::DEFAULT_VAL_I)
//                        {
//                            echo UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_END_TIME});
//                        }
//                        else 
//                        {
//                            echo UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
//                        }
                     ?></div>
                    </div>
                </div>
                <!--Task title ends here-->

                <!--Skills needed start here-->
        <?php
        $skills = UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID});
        if ($skills != '<ul></ul>') 
        {
            ?>
            <div class="controls-row">
                <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')); ?></h2>
                <div class="skills">
    <?php echo $skills; ?>
                </div>
            </div>
            <?php
        }
        ?>
        <!--Skills needed ends here-->

                <!--Description Start here-->
                <div class="controls-row">
                    <h2 class="taskheading">
                        <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_description')); ?>
                    </h2><?php echo $task->description; ?></div>
                <!--Description Ends here-->

                <!--Requirements & details Start here-->
                <div class="controls-row">
                    <h2 class="taskheading">
                        <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_req_and_detail')); ?>
                    </h2>
                    <div class="controls-row"><div class="name_ic"><img src="../images/vis-ic.png"></div>
                        <?php echo CommonUtility::getPublicDetail($task->is_public); ?></div>
                </div>
                <div class="controls-row">
                    <?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name,$task->{Globals::FLD_NAME_TASK_ID}); ?>

                </div>
                <!--Requirements & details Ends here-->

                <!--Requirements & details Start here-->
        <?php
//        if ($question) 
//        {
//            ?>
            <div class="controls-row">
                <h2 class="taskheading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_question')); ?></h2>
                <div class="controls-row">
                    <?php
                    $i = 1;
//                    foreach ($question as $questions) 
//                    {
//                        echo $i . '. ' . $questions->categoryquestionlocale->question_desc . "<br>";
//                        $i++;
//                    }
                    ?>
                </div>
            </div>
            <?php
//        }
        ?>

            </div>
        </div>



    