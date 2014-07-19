<?php
    $taskDetailUrl = CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
    $taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
    $taskCategory = UtilityHtml::getTaskCategory($data->{Globals::FLD_NAME_TASK_STATE}, $data);
    $isLogin = CommonUtility::isUserLogin();
    $isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_CREATER_USER_ID} );
    
?> 
<div class="<?php if($isPremium) echo 'proposal_list task_list margin-bottom-10'; else echo 'proposal_list task_list2 margin-bottom-10' ?>">
<!--<div class="item_labelgreen">
<span class="task_label_text2">Network</span>
</div>-->
<div class="tasker_row1">
<!--<div class="proposal_col1">
<div class="taskimg"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>"></div>

</div>-->
<div class="proposal_col3">
<div class="proposal_row">
<p class="task_name"><a href="<?php echo $taskDetailUrl ?>"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}); ?></a>
<?php if($isPremium) echo '<span class="premium">'.Yii::t('tasker_mytasks', 'Premium').'</span>';  ?>
</p>
<div class="proposal_col4 "><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_date')) ?>: <span class="date"><?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}) ; ?></span></div>
<div class="proposal_col4 "> <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')) ?><?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $data->{Globals::FLD_NAME_CREATER_USER_ID} ) ?></div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Task type')?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($data->{Globals::FLD_NAME_TASK_KIND})) ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Category')?>: <span class="date"> <?php echo $data["categorylocale"][Globals::FLD_NAME_CATEGORY_NAME] ?></span></div>
<div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Location')?>: <span class="date"><?php  echo  $taskLocations = UtilityHtml::getSelectedLocationsInComma($data->{Globals::FLD_NAME_TASK_ID}); ?></span></div>
<div class="publctask">
<article><?php echo $data->{Globals::FLD_NAME_DESCRIPTION}; ?></article>
        <?php  //echo $description = CommonUtility::truncateText( $data->{Globals::FLD_NAME_DESCRIPTION} , Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT ); ?></div>
</div>                
</div>

<div class="proposal_row1">
<?php if($isLogin)
{
?>
    <div class="iconbox2" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>">

        <?php echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK,$data->{Globals::FLD_NAME_TASK_ID});
        //<img src="'.CommonUtility::getPublicImageUri( "fevorite.png" ).'">
//                $isBookMark = UserBookmark::isBookMarkByUser(array(Globals::FLD_NAME_TASK_ID => $data->{Globals::FLD_NAME_TASK_ID} , Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE ));
//                if($isBookMark)
//                {
//                    $this->renderPartial('//tasker/_unsetpotential',array('bookmark_type' => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK,'id'=> $data->{Globals::FLD_NAME_TASK_ID} ));
//                }
//                else
//                {
//                    $this->renderPartial('//tasker/_setpotential',array('bookmark_type' => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK,'id'=> $data->{Globals::FLD_NAME_TASK_ID} ));
//                }
                ?>

       </div> 
    <?php if(TaskTasker::isUserProposedForTask( $data->{Globals::FLD_NAME_TASK_ID}  ))
    {
        ?>
    <div class="iconbox2">
            <a target="_blank"  title="<?php echo Yii::t('tasklist','View Proposal') ?>" href="<?php echo Yii::app()->createUrl('tasker/proposaldetailtasker')."/task_id/".$data->{Globals::FLD_NAME_TASK_ID}."/task_tasker_id/".$data->taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID} ?>"><img src="<?php echo CommonUtility::getPublicImageUri( "view-portfolio.png" ) ?>"></a>

     </div>
    <?php
    }
    ?>
   

       <?php $isInvited = TaskTasker::isTaskerInvitedForTask( $data->{Globals::FLD_NAME_TASK_ID} , Yii::app()->user->id );
       if($isInvited)
       {
        ?><div class="iconbox2 orange"><?php echo CHtml::encode(Yii::t('tasklist', 'lbl_invited')) ?></div><?php
       }
?>
        <?php
}
?>
   <div class="iconbox2"><?php echo   UtilityHtml::displayPrice($data->{Globals::FLD_NAME_PRICE}); ?></div>
   <div class="total_task"><?php echo Yii::t('tasker_mytasks', 'Total Proposal')?>: 
     <?php
            if( $data->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
            {
                ?>
       <span style="cursor: pointer;" class="mile_away popovercontent" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  title='' data-placement='bottom'  data-poload='<?php echo Yii::app()->createUrl('commonfront/taskproposalspopover')."?".Globals::FLD_NAME_TASK_ID."=".$data->{Globals::FLD_NAME_TASK_ID} ?>' ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                <?php
            }
            else
            {
                ?>
                <span style="cursor: pointer;" class="mile_away" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                <?php
            }
                 ?>  
<?php if($isLogin)
{
?>
    <div class="tasker_col5" id="markReadfor_<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>">
    <?php
    $isRead = UserBookmark::isBookMarkByUser(array(Globals::FLD_NAME_TASK_ID => $data->{Globals::FLD_NAME_TASK_ID} , Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_MARK_READ ));
    if($isRead)
    {
        $this->renderPartial('_markunread',array('taskId'=> $data->{Globals::FLD_NAME_TASK_ID} ));
    }
    else
    {
        $this->renderPartial('_markread',array('taskId'=> $data->{Globals::FLD_NAME_TASK_ID} ));
    }
                
                
    ?>
    </div>
    <?php
    }
    ?>  
</div>
</div>
</div>              