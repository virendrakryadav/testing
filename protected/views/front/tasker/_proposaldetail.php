<?php
//$data = TaskTasker::model()->findByPk($data->{Globals::FLD_NAME_TASKER_ID});

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
$youHired = GetRequest::getTaskerHiredCount($data->{Globals::FLD_NAME_TASKER_ID} , $data->task->{Globals::FLD_NAME_CREATER_USER_ID}); 
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_TASKER_ID});
$skills = $skills ? $skills : 'No Skills Given';
$isPremium = CommonUtility::isPremium($data->{Globals::FLD_NAME_TASKER_ID});
echo CHtml::hiddenField('currentaskers', $data->{Globals::FLD_NAME_TASKER_ID});
?>

    
<!--                  <div class="item_labelblue">
<span class="proposal_label_blue">New</span>
</div>-->
<div class="tasker_row1">

<div class="proposal_col1">
<div class="proposal_prof">
<img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>">
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

<div class="pro-icon-cont">                          
<div class="proposal_rating">
<div class="iconbox3" style="display : <?php if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED ) echo 'block'; else echo 'none';?>" id="hiredFor_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
    <a href="#" title="<?php echo Yii::t('tasklist', 'You hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes.png") ?>"></a>
</div>
<div class="iconbox3" style="display : <?php if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED ) echo 'none'; else echo 'block';?>" id="notHired_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
    <a href="#" title="<?php echo Yii::t('tasklist', 'You not hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes-gray.png") ?>"></a>
</div>
<div class="iconbox4"><?php echo UtilityHtml::isTaskerInvitedForTask($data->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id); ?></div>
<div class="iconbox4" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>">
<?php echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER,$data->{Globals::FLD_NAME_TASKER_ID},true); ?>
</div>
</div>
</div>   
<div class="total_task"><?php echo Yii::t('tasker_proposaldetail', 'Task completed')?>: <span class="mile_away"><?php echo $user->{Globals::FLD_NAME_TASK_DONE_CNT} ?></span>
</div>

<div class="proposal_btn" id="acceptProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
<?php
    if( $isTaskCancel )
        $this->renderPartial('//tasker/_hireme',array('tasker_status' => $data->{Globals::FLD_NAME_TASKER_STATUS} ,'tasker_id' => $data->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $data->{Globals::FLD_NAME_TASK_TASKER_ID} ));
?>
</div>
<div class="proposal_btn"><a href="#" class="btn-u rounded btn-u-blue display-b"><?php echo Yii::t('tasker_mytasks', 'Message')?></a>
</div>
<!--<div class="proposal_btn"><a href="#" class="connect_btn"><?php echo Yii::t('tasker_mytasks', 'Potential')?></a></div>-->
<!--<div class="proposal_btn" id="rejectProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
    <?php
//    if( $isTaskCancel )
//            $this->renderPartial('//tasker/_notinterested',array('tasker_status' => $data->{Globals::FLD_NAME_TASKER_STATUS} , 'tasker_id' => $data->{Globals::FLD_NAME_TASKER_ID} ,'task_tasker_id'=> $data->{Globals::FLD_NAME_TASK_TASKER_ID} ));
    ?>
</div>-->
</div>
<div class="proposal_col2">
<div class="proposal_row">
<div class="proposal_row">
<div class="col-md-12 no-mrg">
<div class="col-80"><a class="tasker_name" href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID}); ?> <span class="tasker_city"><?php echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></a></div>
<div class="col-20"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>
</div>
</div>
<div class="invite-row3-proposal">
<div class="invite-col3">
<div class="invite-count"><?php echo $youHired; ?></div>
<?php echo CHtml::encode(Yii::t('tasker_proposaldetail', 'Hired'));?>
</div>
<div class="invite-col3">
<div class="invite-count2">0</div>
<?php echo CHtml::encode(Yii::t('tasker_proposaldetail', 'Network'));?>
</div>
<div class="invite-col3">
<div class="invite-count3"><?php echo $user->{Globals::FLD_NAME_TASK_DONE_CNT} ?></div>
<?php echo CHtml::encode(Yii::t('tasker_proposaldetail', 'Jobs'));?>
</div>
</div>
</div>  
<div class="proposal_row1">
  <div class="total_task"><?php echo Yii::t('tasker_mytasks', 'Skills')?>: <span class="graytext"><?php echo $skills?></span>
      <span class="graytext"></span></div>

</div>  

<div class="proposal_row2"><h2 class="text-30b"><?php echo CHtml::encode(Yii::t('tasker_proposaldetail', 'Why Me?'));?></h2> <?php  echo $data->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?></div>   
 
    <?php
                $question = TaskQuestion::getTaskQuestion($data->{Globals::FLD_NAME_TASKER_ID});
                $i = 1;
                if($question)
                {
                    ?>
<div class="proposal_row2">
<h3 class="quest"><?php echo Yii::t('tasker_mytasks', 'Question answer')?></h3>
<div class="quest_cont">
<ul>
<?php
    $answers =  CommonUtility::getQuestionAnswerByTasker($task_id, $taskTasker->tasker_id );
    if($answers)
    {
        foreach ($question as $questions)
        {
        ?>
            <li><span class="quescoler"><?php echo Yii::t('tasker_mytasks', 'Q.')?></span><?php echo $questions->categoryquestionlocale->question_desc; ?></li>
            <li><span class="quescoler"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?></span>  <?php echo $answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}]; ?></li>                                    
            <?php
            $i++;
        }
    }
?>
</ul>
</div>
<?php } ?>
    
    <?php $attachments =  UtilityHtml::getProposalAttachments($data->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $user->profile_folder_name,$data->task_tasker_id); 
 if($attachments)
 {?>
<div class="proposal_row2">
<h3 class="quest"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Attachments'));?></h3>
<div class="attachrow">
    <div class="clr-padding-upload"></div>
    <?php echo $attachments ?>
    <div class="clr-padding-upload"></div>
</div>
</div>   
<?php
 }
?>
</div>
 </div>         
    <div class="tasker_row1">
<h3 class="h3 bot_border"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Review'));?></h3>
<div class="proposal_row3 botmrgn">
<div class="reviewcol"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Total Reviews')?></span> <span class="countbox">0</span></div>
<div class="reviewcol"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Average rating')?></span> <span class="countbox"><?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></span></div>
<div class="reviewcol2"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Average price')?></span> <span class="countbox">$200</span></div>
</div>
</div>
 
  
         