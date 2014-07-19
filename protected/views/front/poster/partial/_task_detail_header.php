
<!--<div class="col-md-12 mrg-auto overflow-h no-pdn">
<div class="project-col">
<span class="project-col2">Posted By</span>
<img src="<?php 
echo CommonUtility::getThumbnailMediaURI($task->{Globals::FLD_NAME_CREATER_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80);?>">
<span class="project-col2"><a href="#"><?php echo UtilityHtml::getUserNameWithPopover( $task->{Globals::FLD_NAME_CREATER_USER_ID}) ?></a></span>
</div>
<div class="project-cont2">
<div class="tasker_row1">
<div class="proposal_row no-mrg">
<div class="col-md-10 no-mrg">
<span class="proposal_title">
<a href="<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a></span></div>
     <div class="project-price"><span class="proposal_price"><?php echo UtilityHtml::displayPrice( $task->{Globals::FLD_NAME_PRICE} ) ?></span></div>
</div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_post_date')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_bid_start_date')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Task type')?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_category')?>: <span class="date"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></span></div>
</div>  
</div>

</div>-->
<div class="col-md-12 mrg-auto overflow-h no-pdn">
<div class="proposal_cont">
<div class="col-md-12 no-mrg overflow-h">
<!--<div class="project-col">
<span class="project-col2">Posted By</span>
<img src="<?php // echo CommonUtility::getThumbnailMediaURI($task->{Globals::FLD_NAME_CREATER_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80);?>">
<span class="project-col2"><a href="#"><?php // echo UtilityHtml::getUserNameWithPopover( $task->{Globals::FLD_NAME_CREATER_USER_ID}) ?></a></span>
</div>-->
<div class="project-cont-d">
<div class="tasker_row1">
<div class="proposal_row no-mrg">
<div class="col-md-12 no-mrg">
<div class="col-md-10 no-mrg"><h3 class="pro-title"><a href="<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a></h3></div>
<!--<div class="col-md-5 f-right no-mrg">
<div class="proposal_link"><a href="#">Edit</a></div>
<div class="proposal_link"><a href="#">Cancel</a></div>
<div class="proposal_link"><a href="#">Share</a></div>
</div>-->
</div>
</div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Posted')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?> </span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Start Date')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?> </span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Type')?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?> </span></div>
<div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'lbl_category')?>: <span class="date"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?> </span></div>
</div>  
</div>
<div class="project-col5">
<span class="project-col2">Working</span>
<img src="<?php echo CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
<span class="project-col2"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster($model->{Globals::FLD_NAME_USER_ID}) ?></a></span>
</div>
</div>
</div>
</div>