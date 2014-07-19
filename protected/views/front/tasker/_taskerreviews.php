<div class="r-cont">
<div class="review-own"><img src="<?php echo CommonUtility::getThumbnailMediaURI($data->task->{Globals::FLD_NAME_CREATER_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80); ?>"></div>
<div class="r-row">
<div class="review-title-row1"><?php echo $data->task->{Globals::FLD_NAME_TITLE} ?></div>
<div class="r-row2-reviews">
    <div class="r-col">
    <a  id="readMoreLink<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID} ?>" href="javascript:void(0)" onclick="displayReviewForTasker('<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID} ?>')">More</a>
    <a style="display: none" id="readLessLink<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID} ?>" href="javascript:void(0)" onclick="hideReviewForTasker('<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID} ?>')">Less</a>
    </div>
<div class="r-col"><?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASKER_REVIEW_DT}) ?></div>
<div class="r-col2">    <?php echo UtilityHtml::getDisplayRating(2); ?></div>
<div class="r-col text-16a"><?php echo  UtilityHtml::displayPrice($data->{Globals::FLD_NAME_TASKER_PROPOSED_COST}) ?></div>
</div>
<div id="reviewDtl<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID}  ?>" style="display: none" class="r-cont-in margin-bottom-10">
    <?php echo $data->{Globals::FLD_NAME_TASKER_REVIEW_COMMENTS} ?>
    
</div>
</div>
</div>