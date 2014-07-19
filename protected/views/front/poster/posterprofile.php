

<div class="controls-row pagetopbg"> 

    <div class="page-container page_padding">
        <div id="msgConfirmTask" style="display:none" class="flash-success"></div>
        <!--about profile Start here-->
        <div class="controls-row">
            <div class="profile_img">
                <?php $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                <img src="<?php echo $img ?>"></div>
            <div class="profile_name"><h1><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp<span class="tagline"><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></h1>
                <span class="tagline"><?php echo $model->{Globals::FLD_NAME_TAGLINE}; ?></span></div>
        </div>
        <!--about profile Ends here-->

        <!--Left side bar start here-->
        <div class="leftbar">
            <!--Previoue tast start here-->
            <div class="box">
                <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_new_user')) ?></h3></div>
                <div class="box2">
                <!--<div class="prvlist_box"> <i class="icon-map-marker"></i>1.5 miles away</div>-->
                    <?php $mobile = CommonUtility::getUserPhoneNumber($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($mobile) && $mobile != '' && $mobile != Array()) 
                    {
                        ?>
                        <div class="prvlist_box"><i class="icon-bell"></i><?php echo $mobile; ?></div>
                        <?php
                    }
                    ?>
                    <?php $email = CommonUtility::getUserEmail($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($email) && $email != '' && $email != Array()) {
                        ?>
                        <div class="prvlist_box"><i class="icon-envelope"></i> <?php echo $email ?></div>
                        <?php
                    }
                    ?>
                    <?php $workPreferences = CommonUtility::getUserWorkPreferences($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($workPreferences) && $workPreferences != '' && $workPreferences != Array()) {
                        ?>
                        <div class="prvlist_box"><i class="icon-time"></i> 
                            <table width="91%" style="float: right;">
                        <?php
                        foreach ($workPreferences as $index => $schedule) {
                            ?>
                                    <tr>
                                        <td><label><?php echo $schedule[0][Globals::FLD_NAME_HRS]; ?> </label><?php
                                    $i = 1;
                                    foreach ($schedule as $day) {
                                        if ($i == count($schedule)) {
                                            echo ucfirst($day[Globals::FLD_NAME_DAYS]);
                                        } else {
                                            echo ucfirst($day[Globals::FLD_NAME_DAYS]) . ',';
                                        }
                                        $i++;
                                    }
                                    ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>
                            </table>
                        </div>
    <?php
}
?>
                </div>
            </div>
            <!--Previoue tast Ends here-->


        </div>
        <!--Left side bar ends here-->

        <!--Right side content start here-->
        <div class="rightbar2">
            <div class="box">
                <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_name_prepand')) ?>&nbsp<?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp</h3></div>
                <!--tasker specialties start here-->
                <div class="controls-row pdn">
                    <h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_specialties')) ?></h3>

                    <?php echo UtilityHtml::userSkills($model->{Globals::FLD_NAME_USER_ID} ,"span4 nopadding specialties", Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN ) ?>
                </div>
                <!--tasker specialties ends here-->

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
                    <div class="task_detail_col">
                        <h2 class="h4"><?php echo $task->{Globals::FLD_NAME_TITLE}; ?></h2>
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_for')) ?></div>
                            <div class="task_detail_col3"><?php echo $task->{Globals::FLD_NAME_REF_DONE_BY_NAME}; ?></div>
                        </div>
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_date')) ?></div>
                            <div class="task_detail_col3"><?php echo $task->{Globals::FLD_NAME_TASK_FINISHED_ON}; ?></div>
                        </div>
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_hours')) ?></div>
                            <div class="task_detail_col3"><?php echo $task->{Globals::FLD_NAME_WORK_HRS}; ?></div>
                        </div>
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_price')) ?></div>
                            <div class="task_detail_col3 blue_text"><?php echo Globals::DEFAULT_CURRENCY . $task->{Globals::FLD_NAME_PRICE}; ?></div>
                        </div>

                        <div class="task_descrip">
                            <h4><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_task_description')) ?></h4>
<?php echo $task->description; ?>
                        </div>
                    </div>
                </div>


                <div class="controls-row pdn" id="ratingtab">
<?php $this->renderPartial('_confirmtask', array(
    'task' => $task));
?>


                </div>
                <!--task detail ends here-->


            </div>
        </div>
        <!--Right side content ends here-->
    </div>
</div>
