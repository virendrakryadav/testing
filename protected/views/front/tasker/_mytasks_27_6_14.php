<?php
//$user = User::model()->findByPk($data->{Globals::FLD_NAME_TASKER_ID});
//$latitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
//$longitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
//$getDistance = 0;
//if(isset($taskLocation))
//{
//$latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
//$longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
//$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
//}
//echo '<br /><br /><br />';
$taskStatusDate = CommonUtility::projectStatusDate($data);
$taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
$isOpenTask = CommonUtility::IsTaskStateOpen($data->{Globals::FLD_NAME_TASK_STATE});
$isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_CREATER_USER_ID} );
//CommonUtility::pre($data);
?> 
    <div class="<?php if($isPremium) echo 'proposal_list task_list margin-bottom-10'; else echo 'proposal_list task_list2 margin-bottom-10' ?>">
<!--        <div class="<?php //if($isPremium) echo 'task_list'; else echo 'task_list2' ?>">-->
            <?php echo $taskState ?>
            <div class="tasker_row1">
                <div class="proposal_col1">
                    <div class="proposal_prof"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>"></div>
                </div>
                <div class="proposal_col2">
                    <div class="proposal_row">
                        <p class="tasker_name"><a href="#"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}) ?></a>
                        <?php if($isPremium) echo '<span class="premium">'.Yii::t('tasker_mytasks', 'Premium').'</span>';  ?></p>
                        <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Posted by')?> : <span class="date"><?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $data->{Globals::FLD_NAME_CREATER_USER_ID} ) ?> </span></div>
                        <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', $taskStatusDate['label']); ?>: <span class="date"><?php echo $taskStatusDate['date']; ?></span></div>
                        <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Task type')?>: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($data->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
                        <div class="proposal_col4 "><?php echo Yii::t('tasker_mytasks', 'Category')?>: 
                            <span class="date">
                                <?php 
                                if(isset($data->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME}))
                                {
                                    echo $data->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME};
                                }else{
                                 echo Yii::t('tasker_mytasks', 'Not specified');
                                }
                                ?>
                            </span></div>                        
                        <!--<div class="proposal_col4 ">Location: <span class="date"><?php //echo UtilityHtml::getSelectedLocationsInComma($data->{Globals::FLD_NAME_TASK_ID}); ?></span></div>-->
                        <div class="publctask"><article><?php echo $data->{Globals::FLD_NAME_DESCRIPTION}; ?></article></div>
                    </div>                
                </div>

                <div class="proposal_row1">
                    <div class="total_task4"><span class="countbox"><?php echo UtilityHtml::isTaskerInvitedForTask($data->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id); ?></span></div>
                    
                    <div class="total_task4"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Rating')?></span> <span class="countbox">
                             <?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_RANK}); ?> </span></div>
                    <div class="total_task4"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Price')?></span> <span class="countbox"><?php echo Globals::DEFAULT_CURRENCY.intval($data->{Globals::FLD_NAME_PRICE}) ?></span></div> 
                    <div class="taskinvite">
                        <div class="total_task5"><a target="_blank" href="<?php echo Yii::app()->createUrl('tasker/proposaldetailtasker')."/task_id/".$data->{Globals::FLD_NAME_TASK_ID}."/task_tasker_id/".$data->taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID} ?>"><?php echo Yii::t('tasker_mytasks', 'View Proposal')?></a></div>
                        <!--<div class="total_task5"><a href="#"><?php echo Yii::t('tasker_mytasks', 'Milestone')?></a></div>-->
                        <div class="total_task5"><a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $data->{Globals::FLD_NAME_TASK_ID} ?>" ><?php echo Yii::t('tasker_mytasks', 'Share')?></a></div>
                        <div class="total_task5"><a href="#"><?php echo Yii::t('tasker_mytasks', 'Review')?></a></div>
                    </div>
                </div>
            </div>
            
<!--        </div> -->
        
    </div>
<div class="clr"></div>
