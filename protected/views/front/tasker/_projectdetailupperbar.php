<div class="col-md-12  no-mrg3">
            <div class="project-col">
                <span class="project-col2"><?php echo Yii::t('poster_projectdetail', 'lbl_posted_by')?></span>
                <img src="<?php echo CommonUtility::getThumbnailMediaURI($task->{Globals::FLD_NAME_CREATER_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_100) ?>">
                <span class="project-col2"><a href="<?php echo CommonUtility::getTaskerProfileURI( $task->{Globals::FLD_NAME_CREATER_USER_ID} ) ?>" target="_blank" ><?php echo CommonUtility::getLoginUserName($task->{Globals::FLD_NAME_CREATER_USER_ID})?></a></span>
            </div>
            
            <div id="projectDetailUpperBar" class="project-cont2">
                <div class="pdn-10">
                    <div class="proposal_row no-mrg">
                        <div class="col-md-12 no-mrg">
                            <div class="col-md-7 no-mrg">
                                <h3 class="pro-title">
                                    <a href="#"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a>
                                </h3>
                            </div>
                            <div class="f-right">
                                <?php
                                if($task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id && $task->{Globals::FLD_NAME_CREATOR_ROLE} == Globals::DEFAULT_VAL_CREATOR_ROLE_POSTER)
                                {
                                    if ($isProposed)
                                    {
                                        ?>
                                        <!--<div class="proposal_link"><a  onclick="applyForTask()" href="#">Apply</a></div>-->
                                        <?php
                                    }
                                    ?>
                                    <div class="proposal_link" id="potentialFor_<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>"><?php echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK,$task->{Globals::FLD_NAME_TASK_ID}, false ,array('saveText' => 'Save' , 'removeText' => 'Saved'));?></div>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id)
                                {
                                    ?>
                                    <!--<div class="proposal_link"><a href="<?php echo CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_view_proposals')); ?></a></div>-->
                                    <?php
                                    if ($task->{Globals::FLD_NAME_PROPOSALS_CNT} <= 0)
                                    {
                                        ?>
                                        <div class="proposal_link"><a  href="<?php echo CommonUtility::getTaskEditUrl($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_edit_project')); ?></a></div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($cancelStatus)
                                    {
                                        ?>
                                        <div class="proposal_link"><a id="canceledtask<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>" onclick="cancelTask('<?php echo $task->{Globals::FLD_NAME_TASK_ID}; ?>', 'refresh', '<?php echo $task->{Globals::FLD_NAME_TASK_STATE}; ?>')" class="" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'Cancel')); ?></a></div>
                                        <?php
                                    } 
                                    else 
                                    {
                                        echo '<div class="proposal_link"><a id="canceledtask' . $task->{Globals::FLD_NAME_TASK_ID} . '" class="" href="javascript:void(0)">Canceled</a></div>';
                                    }
                                    ?>
                                   <?php
                                    $selectedTaskers = TaskTasker::getSelectedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
                                    if ($selectedTaskers) 
                                    {
                                        if (count($selectedTaskers) > 1) 
                                        {
                                            ?>
                                            <div class="proposal_link"><a href="<?php echo CommonUtility::getPosterTaskRequestUrl($task->{Globals::FLD_NAME_TASK_ID}) ?>"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_request_job_complete')); ?></a></div>
                                            <?php
                                        }
                                    }
                                    ?>                                             

                                    <?php
                                }
                                ?>
                                <div class="proposal_link"><a href="#" style="overflow:hidden;" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>">Share</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_projectdetail', 'lbl_posted')?>: <span class="date"> <?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_projectdetail', 'lbl_start_date')?>: <span class="date"> <?php  echo  CommonUtility::projectStartDate($task->{Globals::FLD_NAME_TASK_ID}) ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_projectdetail', 'lbl_type')?>: <span class="date"> <?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_projectdetail', 'lbl_category')?>:<span class="date"> <?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></span></div>
                    <div class="proposal_col4 "><?php echo Yii::t('poster_projectdetail', 'lbl_budget')?>:
                        <span class="date color-red"> <?php echo Globals::DEFAULT_CURRENCY . intval($task->{Globals::FLD_NAME_PRICE}); ?> 
                            <?php
                            if($task->{Globals::FLD_NAME_TASK_KIND} != Globals::DEFAULT_VAL_TASK_KIND_INSTANT)
                            {
                                ?>
                                (<?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?>)
                                <?php
                            }
                            ?>
                        </span>
                    </div>
                    <!--<div class="proposal_col4 "><?php // echo Yii::t('poster_projectdetail', 'Payment Mode')?>:<span class="date"> </span></div>-->

                </div>
            </div>
    <div id="projectDetailUpperUserInfo" style="display: none" class="project-col5">

<span class="project-col2"><?php echo Yii::t('poster_projectdetail', 'Doer')?></span>
<img id="doerImage" src="">
<span class="project-col2"><a href="#"  target="_blank" id="doerName" ></a></span>
</div>
<?php 
if($task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
{
?>
            <div class="proposal_row3">
                <div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_projectdetail', 'txt_total_proposal')?></span> 
                <!--    <span class="countbox"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>-->
                    <?php
                    if( $task->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                    {
                        ?>
                        <span style="cursor: pointer;" class="countbox popovercontent" id="lbl_invited<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>"  title='' data-placement='bottom'  data-poload='<?php echo Yii::app()->createUrl('commonfront/taskproposalspopover')."?".Globals::FLD_NAME_TASK_ID."=".$task->{Globals::FLD_NAME_TASK_ID} ?>' ><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span style="cursor: pointer;" class="countbox" id="lbl_invited<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>"  ><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span>
                        <?php
                    }
                    ?>
                </div>
                <div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_projectdetail', 'txt_average_rating')?></span> 
                    <span class="countbox"><?php echo UtilityHtml::getDisplayRating($task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?></span>
                </div>
<!--                <div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_projectdetail', 'txt_average_exp')?></span>
                    <span class="countbox">15</span>
                </div>-->
                <div class="total_task2"><span class="counttext"><?php echo Yii::t('poster_projectdetail', 'txt_average_price')?></span> 
                    <span class="countbox"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE})  ?></span>
                </div>
            </div> 
<?php
}
?>
</div>