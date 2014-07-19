<?php
if ($invited) 
{
    $i = 1;
    foreach ($invited as $tasker) 
    {
            $user = User::getUsersByID( $tasker->{Globals::FLD_NAME_TASKER_ID} );
            $name = CommonUtility::getUserFullName( $user->{Globals::FLD_NAME_USER_ID} );
            $youHired = TaskTasker::getTaskerHiredByUser( $user->{Globals::FLD_NAME_USER_ID});
        ?>
        <div class="over_list" id="userPopoverDetail<?php echo $user->{Globals::FLD_NAME_USER_ID} ?>">
                            <!--                                <div class="item_label">
                                    <span class="item_label_text"></span>
                                </div>-->
                                                            <div class="tasker_row1">
                                
                                <div class="tasker_col1">
                                   <img src="<?php echo CommonUtility::getThumbnailMediaURI($user->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50); ?>">
                                    <div class="tasker_col3"> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "email-ic.png" ) ?>"></a>
                                        <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "phone-ic.png" ) ?>"></a>
                                        <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "chat-ic.png" ) ?>"></a>
                                    </div>
                                </div>
                               
                                <div class="tasker_col2">
                                    <p class="tasker_name"><a href="<?php echo CommonUtility::getTaskerProfileURI( $user->{Globals::FLD_NAME_USER_ID} ) ?>"><?php echo $name; ?></a><span class="tasker_city">
                                                </span></p>
                                    <p class="tasker_mile"><?php
                                    $getDistance = CommonUtility::calDistance($user->{Globals::FLD_NAME_LOCATION_LONGITUDE}, $user->{Globals::FLD_NAME_LOCATION_LATITUDE},$model->{Globals::FLD_NAME_LOCATION_LONGITUDE}, $model->{Globals::FLD_NAME_LOCATION_LATITUDE});
                                    echo round($getDistance, 2) ?>
                                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away')) ?></p>
                                    <p class="tasker_skill"> 
                                        <?php
                                         $skills =  UtilityHtml::userSkillsCommaSeprated($user->{Globals::FLD_NAME_USER_ID}); 
                                        if ($skills )
                                        {
                                            ?>
                                            <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_user_skills')) ?>
                                            <?php echo $skills; ?>
                                            <?php
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="taskerlist_row1">
    <div class="taskerlist_col1 taskerlist_youhired"><span class="taskcount1">
            <?php if($youHired) echo count($youHired); else echo '0'?></span><br><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_you_hired'));?></div>
    <div class="taskerlist_col1 taskerlist_network"><span class="taskcount1">5</span><br> Networks</div>
    <div class="taskerlist_col1 taskerlist_total"><span class="taskcount1">10</span><br> Total</div>
  </div>
                            <div class="tasker_row2">
                                <div class="tasker_col4"><a href="#">10 <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_reviews')) ?></a></div><div class="tasker_col4"><img src="<?php echo CommonUtility::getPublicImageUri( "star.png" ) ?>"><img src="<?php echo CommonUtility::getPublicImageUri( "star.png" ) ?>"><img src="<?php echo CommonUtility::getPublicImageUri( "star.png" ) ?>"></div>
                            </div>
                        </div>
        <?php
        $i++;
    }
}
?>