<?php 
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_USER_ID});
$skills = $skills ? $skills : CHtml::encode(Yii::t('poster_findtasker', 'No Skills Specified'));
$work_location = CommonUtility::getUserWorkLocations($data->{Globals::FLD_NAME_USER_ID});
$work_location = $work_location ? $work_location : CHtml::encode(Yii::t('components_utilityhtml', 'Anywhere'));
$join_date = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
$img = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);

$hired = GetRequest::getTaskerHiredCount($data->{Globals::FLD_NAME_USER_ID}); 
  $isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_USER_ID} );

$latitude1 = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude1 = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$latitude2 = $data->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude2 = $data->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);


?>
<!--<div class="controls-row pdn6 "> -->
    <div class="proposal_list task_list margin-bottom-10 <?php if($isPremium) echo 'task_list'; else echo 'task_list2' ?>">
        <?php
        if($hired > 0)
        {
            ?>
        <div class="item_label">
        <span class="proposal_label_text"><?php echo $hired ; ?><br><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_hired'));?></span>
        </div>
        <?php
        }
        ?>
        
        <div class="tasker_row1">
            <div class="proposal_col1">
                <div class="proposal_prof">
                    <img src="<?php echo $img ?>">
                    <div class="ratingtsk">
                    <?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_RATING_AVG_AS_TASKER}); ?>
                    </div>
                </div>
            </div>
            <div class="proposal_col2">
                <div class="proposal_row">
                    <p class="tasker_name">
                        <a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover($data->{Globals::FLD_NAME_USER_ID}) ?><span class="tasker_city"><?php $data->{Globals::FLD_NAME_COUNTRY_CODE}?></span></a> 
                        <?php if($isPremium) echo '<span class="premium">'.Yii::t('tasker_mytasks', 'Premium').'</span>';  ?>
<!--                        <span class="online"><img src="<?php echo CommonUtility::getPublicImageUri("online.png") ?>"></span>-->
                    </p>
                    <div class="proposal_col4"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_join_date'));?>: <span class="date"><?php echo $join_date;?></span></div>
                    <div class="tasker_col4"><span class="mile_away"><?php echo $getDistance ?><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_miles_away'));?></span> </div>
                    <div class="tasker_col4"><a href="#">0 <?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_reviews'));?></a></div>
                    <div class="proposal_col4"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_work_location'));?>: <span class="date"><?php echo $work_location; ?></span></div>
                    <div class="proposal_col4"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_skills'));?>: <span class="date"><?php echo $skills;?></span></div>
                </div>  
                <div class="proposal_row1">
                    <div class="total_task"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_task_completed'));?>: <span class="mile_away"><?php echo $data->{Globals::FLD_NAME_TASK_DONE_CNT} ?></span></div>
                    <div class="iconbox"><a title="<?php echo CHtml::encode(Yii::t('tasklist', 'view portfolio'));?>" href="#"><img  src="<?php echo CommonUtility::getPublicImageUri("portfolio-ic.png") ?>"></a></div>
                    <div class="iconbox" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_USER_ID} ?>">
                    <?php echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER,$data->{Globals::FLD_NAME_USER_ID},true); ?>
                    </div>
                    <div class="iconbox"><?php echo UtilityHtml::getConnectMePopover() ?></div>
                    <div class="tasker_col5">
                        <?php

    //                          echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('poster_findtasker', 'txt_save')), 
    //                              Yii::app()->createUrl('poster/savetasker'),
    //                              array(
    //                                        'data' => array('user_id'=>$data->{Globals::FLD_NAME_USER_ID}),
    //                                        'type' => 'POST', 
    //                                        'success' => 'function(data){}'), 
    //                                        array('id' => 'savetasker'.$data->{Globals::FLD_NAME_USER_ID},
    //                                        'class' => 'interested_btn', 'live' => false));
                                        ?>
                    </div>
                    <div style="margin-right:5px;" class="tasker_col5">
                        <input class="btn-u rounded btn-u-sea" type="submit" value="<?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_connect_me'));?>">
                        <?php

    //                          echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('poster_findtasker', 'txt_connect_me')), 
    //                              Yii::app()->createUrl('poster/connectme'),
    //                              array(
    //                                        'data' => array('user_id'=>$data->{Globals::FLD_NAME_USER_ID}),
    //                                        'type' => 'POST', 
    //                                        'success' => 'function(data){}'), 
    //                                        array('id' => 'connecttotasker'.$data->{Globals::FLD_NAME_USER_ID},
    //                                        'class' => 'interested_btn', 'live' => false));
                    ?>
                    </div>
                </div>  
            </div>
<!--        <div class="publctask">
                 <article><?php echo CommonUtility::getUserDescription($data->{Globals::FLD_NAME_USER_ID}); ?></article>
            </div>-->
        </div>
    </div>              
<!--</div>-->
