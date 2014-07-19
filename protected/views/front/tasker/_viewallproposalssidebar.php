<?php
$user = User::model()->findByPk($data->{Globals::FLD_NAME_TASKER_ID});
$latitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
$longitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
$getDistance = 0;
if(isset($taskLocation))
{
$latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}
?>
<div class="prvlist_box"> 
    <a href="#"><img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>"></a>
    <div class="proposalname"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID} ) ?> <span class="tasker_city"><?php echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></div>
    <div class="pro_col"><span class="date"> <?php echo Yii::t('tasker_mytasks', 'Date')?>: 
        <?php echo CommonUtility::formatedViewDate( $data->{Globals::FLD_NAME_CREATED_AT}) ?>
        </span></div>
    <div class="pro_col2"><span class="mile_away">
            <?php if($getDistance != 0)
      {
          echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away')); } ?>
            </span> </div>
    <div class="pro_col3"><?php CommonUtility::DisplayRating(Globals::FLD_NAME_TASK_DONE_RANK.$data->{Globals::FLD_NAME_TASKER_ID} ,$user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></div>
    <div class="pro_col2"><span class="proposal_price2"><?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span> </div>
</div>  
