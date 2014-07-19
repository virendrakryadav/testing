<?php
if ($proposals) 
{
    
    $i = 1;
    foreach ($proposals as $tasker)
    {
        $user = User::model()->findByPk($tasker->{Globals::FLD_NAME_TASKER_ID});
        $latitude2 = $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
        $longitude2 = $tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
        $getDistance = 0;
        $taskLocation = TaskLocation::model()->findByAttributes(array(Globals::FLD_NAME_TASK_ID => $tasker->{Globals::FLD_NAME_TASK_ID}));
        if(isset($taskLocation))
        {
            $latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
            $longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
            $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
        }

        $isPremium = CommonUtility::isPremium($tasker->{Globals::FLD_NAME_TASKER_ID});
        ?>
        <div class="prvlist_box">
           <?php /*?> <p><?php echo CommonUtility::getUserFullName($tasker->{Globals::FLD_NAME_TASKER_ID}); ?></p>
            <p class="invt_done">

                <a href="<?php echo CommonUtility::getTaskerProfileURI($tasker->{Globals::FLD_NAME_TASKER_ID}) ?>" title="<?php echo CommonUtility::getUserFullName($tasker->{Globals::FLD_NAME_TASKER_ID}); ?>">
                    <img class="<?php if ($i % 4 == 0) echo 'invt_tasker' ?>" src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>" width="60px" height="60px">
                </a> 
            </p><?php */?>
            
            <div class="proposal_mini">
<img src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>">
<?php
if($isPremium==1)
{
?>
<div class="premiumtag2"><img src="<?php echo CommonUtility::getPublicImageUri("premium-item.png") ?> "></div>
<?php
}
?>
<!--<div class="ratingtsk"><?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></div>-->
</div>

<div class="proposal_minicol">
<p class="tasker_name"><a href="<?php echo CommonUtility::getTaskerProfileURI($tasker->{Globals::FLD_NAME_TASKER_ID}) ?>"><?php echo CommonUtility::getUserFullName($tasker->{Globals::FLD_NAME_TASKER_ID}); ?>
<!--        <span class="tasker_city">NYK</span>-->
    </a></p>
    <div class="tasker_col4 "><span class="date"><?php echo Yii::t('poster_createtask', 'Date')?>: <?php echo CommonUtility::formatedViewDate($tasker->{Globals::FLD_NAME_CREATED_AT}) ?></span></div><div class="tasker_col4 "><span class="date"><?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></span></div>
<?php if($getDistance > 0)
{
        ?>
        <div class="tasker_col4 "><span class="mile_away"><?php echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));?></span> </div>
        <?php
}
?>
<!--<div class="tasker_col4"><span class="proposal_price"><?php echo UtilityHtml::displayPrice( $tasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ) ?></span></div>-->
</div>
            
        </div>
        
        <?php
        $i++;
    }
}
?>
                        

