<?php
$user = User::model()->findByPk($data->{Globals::FLD_NAME_TASKER_ID});
$latitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
$longitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
$getDistance = 0;
$page = array_search($data->{Globals::FLD_NAME_TASK_TASKER_ID}, $proposalIds);
$page = $page + 1; 
$taskDetailUrl =  Yii::app()->createUrl('tasker/proposaldetail')."/task_id/".$data->{Globals::FLD_NAME_TASK_ID}."/task_tasker_id/".$data->{Globals::FLD_NAME_TASK_TASKER_ID}."?TaskTasker_page=".$page;
//$isInvited = TaskTasker::isTaskerInvitedForTask( $data->{Globals::FLD_NAME_TASK_ID} , $data->{Globals::FLD_NAME_TASKER_ID} );
if(isset($taskLocation))
{
    $latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
    $longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
    $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}
$isPremium = CommonUtility::isPremium($data->{Globals::FLD_NAME_TASKER_ID});

//echo '<pre>';
//print_r($data);
//exit;
//echo $isTaskCancel;
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_TASKER_ID});
$skills = $skills ? $skills : 'No Skills Given';
$youHired = GetRequest::getTaskerHiredCount($data->{Globals::FLD_NAME_TASKER_ID} , $data->task->{Globals::FLD_NAME_CREATER_USER_ID}); 

?>
<!--<div class="controls-row pdn6"> -->
<div class="proposal_list margin-bottom-10">
<div class="tasker_row3">
<div class="p-col">
<div class="p-col2">
<img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_200); ?>">
<?php
if($isPremium==1)
{
?>
    <div class="premiumtag2"><img src="<?php echo CommonUtility::getPublicImageUri("premium-item.png") ?> "></div>
<?php
}
?>
<div class="ratingtsk">
    <?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?>
</div>

</div>
<div class="p-icon-cont">
<div class="proposal_rating">

    <div class="iconbox3"  
         accesskey=""style="display : <?php if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED ) echo 'block'; else echo 'none';?>" id="hiredFor_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
    <a href="#" title="<?php echo Yii::t('tasklist', 'You hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes.png") ?>"></a>
</div>
<div class="iconbox3" style="display : <?php if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED ) echo 'none'; else echo 'block';?>" id="notHired_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
    <a href="#" title="<?php echo Yii::t('tasklist', 'You not hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes-gray.png") ?>"></a>
</div>
<div class="iconbox4"><?php echo UtilityHtml::isTaskerInvitedForTask($data->{Globals::FLD_NAME_TASK_ID} , $data->{Globals::FLD_NAME_TASKER_ID}); ?></div>

</div>
<!--<div class="total_task"><?php echo Yii::t('poster_createtask', 'Task completed')?>: <span class="mile_away"><?php echo $user->{Globals::FLD_NAME_TASK_DONE_CNT} ?></span></div>-->
<div class="proposal_btn" id="acceptProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
<?php
    if( $isTaskCancel )
        $this->renderPartial('//tasker/_hireme',array('tasker_status' => $data->{Globals::FLD_NAME_TASKER_STATUS} ,'tasker_id' => $data->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $data->{Globals::FLD_NAME_TASK_TASKER_ID} ,'task_id'=> $data->{Globals::FLD_NAME_TASK_ID} ));
?>
</div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" data-poload="<?php echo Yii::app()->createUrl('commonfront/connectmepopover');?>" data-placement="bottom"><?php echo Yii::t('poster_createtask', 'Message')?></a></div>
<!--<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b"><?php echo Yii::t('poster_createtask', 'Potential')?></a></div>-->
<!--<div class="proposal_btn"><a href="#" class="connect_btn">Potential</a></div>-->
<!--<div class="proposal_btn"><a href="#" class="connect_btn">Not interested</a></div>-->
<div class="proposal_btn" id="rejectProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
    <?php
    if( $isTaskCancel )
            $this->renderPartial('//tasker/_notinterested',array('tasker_status' => $data->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $data->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $data->{Globals::FLD_NAME_TASK_TASKER_ID} ));
    ?>
</div>
<div class="proposal_btn" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
    <?php
    if( $isTaskCancel )
        echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER,$data->{Globals::FLD_NAME_TASKER_ID},true , array('saveText' => 'Potential' , 'removeText' => 'Unpotential' , 'saveClass' => 'btn-u rounded btn-u-default display-b' , 'removeClass' => 'btn-u rounded btn-u-red display-b')); 
    ?>
</div>

</div>
</div>
<div class="p-col-right">
<div class="proposal_row">
    <div class="col-md-12 no-mrg">
<div class="col-80"><p class="tasker_name">
        <a href="<?php echo CommonUtility::getTaskerProfileURI( $data->{Globals::FLD_NAME_TASKER_ID} ) ?>" target="_blank"><?php echo CommonUtility::getUserFullName( $data->{Globals::FLD_NAME_TASKER_ID} ) ?></a>
    <?php //echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID} ,'bottom' ,  $taskDetailUrl ) ?><span class="tasker_city"> <?php echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></p></div>
<!--<div class="newcol1">
<p class="tasker_name"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID} ,'bottom' ,  $taskDetailUrl ) ?> <span class="tasker_city"><?php echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></a></p>-->
<div class="col-20"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>
<!--<div class=" "><span class="date"><?php echo Yii::t('poster_createtask', 'Date')?>: <?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<?php 
if($getDistance != 0)
{
?>
<div class="tasker_col4"><span class="mile_away"><?php echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));?></span> </div>
<?php
}
?>
<div class="tasker_col4"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>-->
</div>
</div> 
<div class="invite-row3-proposal">
<div class="invite-col3"  <?php  if ($youHired) echo 'data-poload="'.Yii::app()->createUrl('commonfront/hiredpopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user->{Globals::FLD_NAME_USER_ID}.'" data-placement="bottom"' ?>>
<div class="invite-count"><?php echo $youHired; ?></div>
<?php echo Yii::t('poster_createtask', 'Hired');?>
</div>
<div class="invite-col3" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/networkpopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user->{Globals::FLD_NAME_USER_ID} ;?>"  >
<div class="invite-count2">0</div>
<?php echo Yii::t('poster_createtask', 'Network');?>
</div>
<div class="invite-col3"  <?php  if ($user->{Globals::FLD_NAME_TASK_DONE_CNT} > 0) echo 'data-poload="'.Yii::app()->createUrl('commonfront/jobspopover').'?'.Globals::FLD_NAME_USER_ID.'='.$user->{Globals::FLD_NAME_USER_ID}.'" data-placement="bottom"' ?> >
<div class="invite-count3"><?php echo $user->{Globals::FLD_NAME_TASK_DONE_CNT} ?></div>
<?php echo Yii::t('poster_createtask', 'Jobs');?>
</div>
</div> 
 
<div class="proposal_row1">
  <div class="total_task"><?php echo Yii::t('poster_createtask', 'lbl_task_user_skills')?> <span class="graytext"><?php echo $skills?></span></div>

</div>  

<div class="proposal_row2"><h4><?php echo Yii::t('poster_createtask', 'Why Me?')?></h4>
    <article>
        
        <?php echo commonUtility::truncateText($data->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS},Globals::DEFAULT_VAL_PROPOSAL_DESCRIPTION_LENGTH);?>
        <?php //  echo  $data->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} ?><br/>
    <a target="_blank"  style="width: 11%;margin: 10px 0 0;" href="<?php echo $taskDetailUrl ?>"><?php echo Yii::t('poster_createtask', 'Read More')?></a></article>
</div>   
    
</div>
    <div class="clr"></div>
</div>
</div>              
<!--</div>-->