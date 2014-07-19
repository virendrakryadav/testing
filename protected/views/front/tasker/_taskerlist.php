<style>
.invited{
	color:#000000;
	}
	
.tasker_list4 {
    border: 1px solid #E1E1E1;
    float: left;
    margin: 0 20px 0 0;
    position: relative;
    width: 48.5%;
}

.mrgn {
    margin: 0;
}
</style>

<?php
$latitude2 = $data->{Globals::FLD_NAME_LOCATION_LATITUDE} ;
$longitude2 = $data->{Globals::FLD_NAME_LOCATION_LONGITUDE} ;
$getDistance = 0;
if(isset($taskLocation))
{
$latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}


//                        $data->{Globals::FLD_NAME_USER_ID};

$youHired = TaskTasker::getTaskerHiredByUser($data->{Globals::FLD_NAME_USER_ID});
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_USER_ID});
$skills = empty($skills) ? CHtml::encode(Yii::t('poster_createtask','lbl_not_specified')) : $skills ;
$userinvited = TaskTasker::model()->findByAttributes(array( Globals::FLD_NAME_TASKER_ID =>$data->{Globals::FLD_NAME_USER_ID},Globals::FLD_NAME_TASK_ID=>$task->{Globals::FLD_NAME_TASK_ID}));
/*echo '<pre>'; 
print_r($youHired);echo '</pre>'; */
?>
<div class="tasker_list4 <?php if($index%2==1){?>mrgn<?php }?>">
  <div class="tasker_row1">
    <div class="tasker_imgcol"><img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
      <div class="tasker_invite" id="invitedbutton<?php echo $data->{Globals::FLD_NAME_USER_ID};?>">
	  
        <?php
			if(empty($userinvited))
			{
				echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask','lbl_invite')),
					Yii::app()->createUrl('tasker/invitenow'),
					array('data' => array(Globals::FLD_NAME_TASK_ID=>$task->{Globals::FLD_NAME_TASK_ID} ,
						Globals::FLD_NAME_USER_ID=>$data->{Globals::FLD_NAME_USER_ID},
						Globals::FLD_NAME_LOCATION_LONGITUDE=>$data->{Globals::FLD_NAME_LOCATION_LONGITUDE},
						Globals::FLD_NAME_LOCATION_LATITUDE=>$data->{Globals::FLD_NAME_LOCATION_LATITUDE},
						Globals::FLD_NAME_TASKER_IN_RANGE => $getDistance,
					),
					'type' => 'POST',
					'success' => 'function(data){ 
					$("#invitedbutton'.$data->{Globals::FLD_NAME_USER_ID}.'").html("'.CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')).'");
					}'), array('id' => 'invite_tasker_'.$data->{Globals::FLD_NAME_USER_ID}, 'live' => false)
				);
			}
			else
			{
				echo "<a href='javascript:void(0)'>".CHtml::encode(Yii::t('poster_createtask', 'lbl_reinvite'))."</a>";
			}
	 ?>
      </div>
    </div>
    <div class="tasker_col2new">
      <p class="tasker_name"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_USER_ID}); ?><span class="tasker_city"><?php echo " ".$data->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></a></p>
      <div class="tasker_skill"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_user_skills'))?>
	  &nbsp;
	  <?php  echo $skills; ?></div>
      <?php if($getDistance != 0)
      {
          ?>
      <div class="tasker_col4 "><?php echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));?></div>
      <?php } ?>
      <div class="tasker_col4"><a href="#">0 Reviews</a></div>
      <div class="tasker_col4">
          <?php
            echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_TASK_DONE_RANK});
          ?>
<!--          <img src="../images/star.png"><img src="../images/star.png"><img src="../images/star.png">-->
      </div>
    </div>
  </div>
  <div class="taskerlist_row1">
    <div class="taskerlist_col1 taskerlist_youhired"><span class="taskcount1">
	<?php
		if($youHired) echo count($youHired); else echo '0';
	?></span><?php echo " ".CHtml::encode(Yii::t('poster_createtask', 'lbl_you_hired'));?></div>
    <div class="taskerlist_col1 taskerlist_network"><span class="taskcount1">0</span> Networks</div>
    <div class="taskerlist_col1 taskerlist_total"><span class="taskcount1">0</span> Total</div>
  </div>
  <div class="tasker_row2">
    <div class="tasker_contact"><?php echo Yii::t('tasker_mytasks', 'Contact me')?> -</div>
    <div class="tasker_contact"> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("email-ic.png");?>"></a> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("phone-ic.png");?>"></a> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("chat-ic.png");?>"></a> </div>
    <div class="tasker_col5">
      <input type="button" class="invite_btn" value="Connect me" name="">
    </div>
  </div>
</div>
