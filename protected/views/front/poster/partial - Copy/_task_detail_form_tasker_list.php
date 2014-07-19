<?php 
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_USER_ID});
$skills = $skills ? $skills : CHtml::encode(Yii::t('poster_findtasker', 'No Skills Specified'));
$work_location = CommonUtility::getUserWorkLocations($data->{Globals::FLD_NAME_USER_ID});
$work_location = $work_location ? $work_location : CHtml::encode(Yii::t('components_utilityhtml', 'Anywhere'));
$join_date = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
$img = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80);

$hired = GetRequest::getTaskerHiredCount($data->{Globals::FLD_NAME_USER_ID}); 
$isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_USER_ID} );




?>
<input type="hidden" class="current_taskers_display" name="currentTaskers[]" value="<?php echo $data->{Globals::FLD_NAME_USER_ID}."[,,]".CommonUtility::getUserFullName( $data->{Globals::FLD_NAME_USER_ID} )."[,,]".$img ?>" >
<div class="invite-row" onclick="addTaskerToInvite('<?php echo $data->{Globals::FLD_NAME_USER_ID} ?>','<?php echo CommonUtility::getUserFullName( $data->{Globals::FLD_NAME_USER_ID} ); ?>' , '<?php echo $img ?>' , 'invitedTaskers' )">
<div class="invite-col"><?php echo UtilityHtml::getUserFullNameWithPopover($data->{Globals::FLD_NAME_USER_ID}) ?><?php if($isPremium) echo '<span class="premium">'.Yii::t('tasker_mytasks', 'Premium').'</span>';  ?></div>
<div class="invite-row2">
<div class="invite-col2"><img src="<?php echo $img ?>"></div>
<div class="invite-row3">
<div class="invite-col3">
<div class="invite-count"><?php echo $hired ; ?></div>
Hired
</div>
<div class="invite-col3">
<div class="invite-count2">0</div>
Network
</div>
<div class="invite-col3">
<div class="invite-count3">0</div>
Jobs
</div>
</div>
<div class="invite-row2"><?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></div>
<div class="invite-row4"><button id="userInviteBtn<?php echo $data->{Globals::FLD_NAME_USER_ID} ?>" type="button" onclick="addTaskerToInvite('<?php echo $data->{Globals::FLD_NAME_USER_ID} ?>','<?php echo CommonUtility::getUserFullName( $data->{Globals::FLD_NAME_USER_ID} ); ?>' , '<?php echo $img ?>' , 'invitedTaskers' )" class="btn-u btn-u-sm rounded btn-u-sea">Invite</button></div>
</div>
</div>