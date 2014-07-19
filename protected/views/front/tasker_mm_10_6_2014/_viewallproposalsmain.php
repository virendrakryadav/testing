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
?><div class="rowselector">
<div class="message_cont">
    <div class="messege_thumb"><img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>"></div>
    <div class="message_area">
        <p class="tasker_name"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID} ) ?></a> <span class="date"><?php echo CommonUtility::formatedViewDate( $data->{Globals::FLD_NAME_CREATED_AT}) ?></span></p>
        <p class="message_text">Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and trimming and edging around flower beds, walks, and walls. Plant seeds, bulbs, foliage, flowering plants, grass, ground covers, trees, and shrubs, and apply mulch for protection</p>
        <div class="reply_text "><span class="mile_away"><a href="#"><?php echo Yii::t('tasker_mytasks', 'Reply')?></a></span> </div><div class="reply_text "><a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("like.png") ?>"></a></div>
    </div>
</div>
    </div>
