<?php
if ($user) 
{
    $name = CommonUtility::getUserFullName($user->{Globals::FLD_NAME_USER_ID});
    $youHired = TaskTasker::getTaskerHiredByUser($user->{Globals::FLD_NAME_USER_ID});
    ?>

    <div class="over_list" id="userPopoverDetail<?php echo $user->{Globals::FLD_NAME_USER_ID} ?>">
        <div class="tasker_row1">
            <div class="tasker_col1">
                <img src="<?php echo CommonUtility::getThumbnailMediaURI($user->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50); ?>">
                <?php if($user->{Globals::FLD_NAME_ACCOUNT_TYPE} == Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM)
                {
                    ?>
                    <div class="premiumtag3"><img src="<?php echo CommonUtility::getPublicImageUri("premium-item.png") ?>"></div>
                    <?php
                }
                ?>
                <div class="tasker_col3"> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("email-ic.png") ?>"></a>
                    <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("phone-ic.png") ?>"></a>
                    <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("chat-ic.png") ?>"></a>
                </div>
            </div>
            <div class="mini_pro">
                <p class="tasker_name"><a target="_blank" href="<?php echo CommonUtility::getTaskerProfileURI($user->{Globals::FLD_NAME_USER_ID}) ?>"><?php echo $name; ?></a><span class="tasker_city">
                    </span></p>
                <?php
                if (isset($model)) 
                {
                    ?>
                    <p class="tasker_mile">
                    <?php
                    $getDistance = CommonUtility::calDistance($user->{Globals::FLD_NAME_LOCATION_LONGITUDE}, $user->{Globals::FLD_NAME_LOCATION_LATITUDE}, $model->{Globals::FLD_NAME_LOCATION_LONGITUDE}, $model->{Globals::FLD_NAME_LOCATION_LATITUDE});
                    echo round($getDistance, 2);
                    echo "&nbsp;";
                    echo CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));
                    ?>
                    </p>
                        <?php
                }
                    ?>
<div class="mini_pro">Total project posted: <span class="date"><?php echo $user->{Globals::FLD_NAME_TASK_POST_CNT} ?></span></div>
<div class="mini_pro">Total budget: <span class="date"><?php echo Globals::DEFAULT_CURRENCY.$user->{Globals::FLD_NAME_TASK_POST_TOTAL_PRICE} ?></span></div>
            </div>
        </div>
        <div class="taskerlist_row1">
            <div class="taskerlist_col1 taskerlist_youhired"><span class="taskcount1">
    <?php if ($youHired) echo count($youHired); else echo '0' ?></span><br><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_you_hired')); ?></div>
            <div class="taskerlist_col1 taskerlist_network"><span class="taskcount1">5</span><br> Networks</div>
            <div class="taskerlist_col1 taskerlist_total"><span class="taskcount1">10</span><br> Total</div>
        </div>
        <div class="tasker_row2">
            <div class="tasker_col4"><a>10 <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_reviews')) ?></a></div><div class="tasker_col4"> <?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_RATING_AVG_AS_POSTER});?></div>
        </div>
<!--<div class="tasker_row1">        
<div class="mini_pro3">Budget distribution-</div>
<div class="mini_pro">Category 1: <span class="date">$100</span></div>  
<div class="mini_pro">Category 2: <span class="date">$100</span></div>  
</div> -->
<div class="lostlogin_row1">  
<div class="mini_pro">Last  login on: <span class="date">15 Apr 2014</span></div>
<div class="mini_pro">Last  project posted on: <span class="date">14 Apr 2014</span></div> </div>       
    </div>
    <?php
}
?>