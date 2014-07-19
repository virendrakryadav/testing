<?php
$taskDetailUrl = CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
$taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
$isOpenTask = CommonUtility::IsTaskStateOpen($data->{Globals::FLD_NAME_TASK_STATE});
$isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_CREATER_USER_ID} );
 //$taskPreferredLocations=CommonUtility::getTaskPreferredLocations($data->{Globals::FLD_NAME_TASK_ID});
//CommonUtility::pre($taskPreferredLocations);
?>
<div class="<?php if($isPremium) echo 'proposal_list task_list margin-bottom-10'; else echo 'proposal_list task_list2 margin-bottom-10' ?>">
<!--<div class="proposal_list task_list2 margin-bottom-10"> -->
       
            <?php echo $taskState ?>
   
        <div class="tasker_row1">
            <div class="proposal_col1">
                <div class="proposal_prof">
                    <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>">                    
                <div class="ratingtsk">
                    <?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_RANK}); ?>
                </div>
                </div>
<!--                <span style="margin-top:-0.7em;padding:2px;"><?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_RANK}); ?></span>-->
            </div>
            <div class="proposal_col2">
                <div class="proposal_row">
                    <p class="task_name"><a href="<?php echo $taskDetailUrl; ?>"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}) ?></a>
                    <?php if($isPremium) echo '<span class="premium">'.Yii::t('tasker_mytasks', 'Premium').'</span>';  ?></p>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Post date')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}); ?> </span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Bid end date')?>: <span class="date"><?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_TASK_END_DATE}); ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Task type')?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($data->{Globals::FLD_NAME_TASK_KIND})) ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Category')?>: 
                        <span class="date">
                            <?php 
                            if(isset($data->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME}))
                            {
                                echo $data->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME};
                            }
                            ?>
                        </span>
                    </div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_createtask', 'Estimated price')?>: <span class="date"><?php echo   UtilityHtml::displayPrice($data->{Globals::FLD_NAME_PRICE}); ?></span></div>
                    <div class="proposal_col5 "><?php echo Yii::t('poster_createtask', 'Location')?>: <span class="date"><?php echo UtilityHtml::getSelectedLocationsInComma($data->{Globals::FLD_NAME_TASK_ID}); ?></span></div>
                    <div class="publctask"><article><?php echo $data->{Globals::FLD_NAME_DESCRIPTION}; ?></article></div>
                </div>                
            </div>

            <div class="proposal_row1">
                <div class="total_task4"><span class="counttext"><?php echo Yii::t('poster_createtask', 'Average rating')?></span> <span class="countbox"> <?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?> </span></div>
                <div class="total_task4"><span class="counttext"><?php echo Yii::t('poster_createtask', 'Average price')?></span> <span class="countbox"><?php echo   UtilityHtml::displayPrice($data->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}); ?></span></div>
                <div class="total_task4">
                    <span class="counttext"><?php echo Yii::t('poster_createtask', 'Total Proposals')?></span>
                <?php    if( $data->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
            {
                ?>
                <span style="cursor: pointer;" class="countbox popovercontent" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  title='' data-placement='bottom'  data-poload='<?php echo Yii::app()->createUrl('commonfront/taskproposalspopover')."?".Globals::FLD_NAME_TASK_ID."=".$data->{Globals::FLD_NAME_TASK_ID} ?>' ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                <?php
            }
            else
            {
                ?>
                <span style="cursor: pointer;" class="countbox" id="lbl_invited<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>"  ><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                <?php
            }
                 ?>  
<!--                    <span class="countbox"><?php echo $data->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>-->
<div class="invite-cont">  

<?php if($isOpenTask)
{ 
    ?>
    <div class="total_task3"><input onclick="cancelTask(<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>)" type="button" name="" value="Cancel" class="btn"></div>
    <div class="total_task3"><input type="button" name="" onclick="editTask('<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>' , '<?php echo $data->categorylocale->category_id ?>' , '<?php echo  UtilityHtml::getTaskType($data->{Globals::FLD_NAME_TASK_KIND}) ?>')" value="<?php echo CHtml::encode(Yii::t('poster_createtask', 'Edit')) ?>" class="btn"></div>
    <div class="total_task3">
    <?php echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite')), Yii::app()->createUrl('tasker/invitetasker') . "/taskId/" . $data->{Globals::FLD_NAME_TASK_ID} . "/category_id/" .$data->categorylocale->{Globals::FLD_NAME_CATEGORY_ID}, array('id' => 'publishinpersontask', 'class' => 'btn')); ?>
    </div>
    
<?php
}
?>
    <div class="total_task3"><input type="button" class="btn popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $data->{Globals::FLD_NAME_TASK_ID} ?>" name="" value="Share"></div>
</div>
            </div>
        </div>
</div>