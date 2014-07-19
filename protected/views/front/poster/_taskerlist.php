<?php 
$skills = UtilityHtml::userSkillsCommaSeprated($data->{Globals::FLD_NAME_USER_ID});
$skills = $skills ? $skills : CHtml::encode(Yii::t('poster_findtasker', 'No Skills Specified'));
$work_location = CommonUtility::getUserCurrentWorkLocations($data->{Globals::FLD_NAME_USER_ID});
$work_location = $work_location ? $work_location : CHtml::encode(Yii::t('components_utilityhtml', 'txt_anywhere'));
$join_date = CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT});
$img = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);

$hired = GetRequest::getTaskerHiredCount($data->{Globals::FLD_NAME_USER_ID}); 
  $isPremium = CommonUtility::isPremium( $data->{Globals::FLD_NAME_USER_ID} );

$latitude1 = $model->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude1 = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$latitude2 = $data->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude2 = $data->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);

$youHired = TaskTasker::getTaskerHiredByUser($data->{Globals::FLD_NAME_USER_ID});

if($index%2 == 0)
{
?>
<div class="col-md-12 no-mrg no-overflow">
<?php
}
//echo $data->created_at." = Start Date<br>";
//echo $data->end_date." = End Date<br>";
?> 

<div class="doerlist search_row task_list2 float-shadow" id="_<?php echo $data->{Globals::FLD_NAME_USER_ID};?>">
                        <div class="proposal_col1">
                            <div class="proposal_prof">
                                <img src="<?php echo $img ?>">
                                <?php
                                if($isPremium)
                                {
                                ?>
                                <div class="premiumtag2"><img src="../images/premium-item.png"></div>
                                <?php
                                }
                                ?>
                                <div class="doer-rank"><?php echo UtilityHtml::getDisplayRating($data->{Globals::FLD_NAME_RATING_AVG_AS_TASKER}); ?></div>
                                <div class="proposal_rating">
                                    <?php
                                    if($youHired > 0)
                                    {
                                        $class = 'iconbox';
                                        ?>
                                        <div class="iconbox3"><img src="../images/yes.png"></div> 
                                        <?php
                                    }
                                    else {
                                        $class = 'iconbox3';
                                    }
                                    ?>
                                    <div class="<?php echo $class;?>" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_USER_ID} ?>">
                                        <?php echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER,$data->{Globals::FLD_NAME_USER_ID},true); ?>
                                    </div>
                                </div>
                                </div>
                            <div class="pro-icon-cont">
                                
                                <!--<div class="total_task"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_task_completed'));?>: <span class="mile_away"><?php echo $data->{Globals::FLD_NAME_TASK_DONE_CNT} ?></span></div>-->
                                <div class="total_task"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_location'));?>: <span class="mile_away"><?php echo $work_location ?></span></div>
                                <div class="proposal_btn">
                                    <a class="btn-u rounded btn-u-sea display-b popovercontent" 
                                       data-poload="<?php echo Yii::app()->createUrl('commonfront/postertasklistpopover?doer_id='.$data->{Globals::FLD_NAME_USER_ID}); ?>"
                                       data-placement="bottom"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_invite'));?></a>                                                                           
                                </div>
                                <div class="proposal_btn">
                                    <a class="btn-u rounded btn-u-blue display-b popovercontent" data-poload="<?php echo Yii::app()->createUrl('commonfront/connectmepopover');?>" data-placement="bottom"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_message'));?></a>                                    
                                </div>
                                <div class="proposal_btn">
                                    <a class="btn-u rounded btn-u-default display-b" ><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_connect'));?></a>                                    
                                </div>
                            </div>
                        </div>

                        <div class="proposal_col2">
                            <div class="proposal_row">
                                <div class="col-md-12 no-mrg">
                                    <div class="col-80"><a target="_blank" href="<?php echo CommonUtility::getTaskerProfileURI( $data->{Globals::FLD_NAME_USER_ID} )?>" class="tasker_name"><?php  echo CommonUtility::getUserFullName($data->{Globals::FLD_NAME_USER_ID}); ?><span class="tasker_city"><?php echo $data->{Globals::FLD_NAME_COUNTRY_CODE}?></span></a></div>                                    
                                </div>
                            </div> 
                            <div class="invite-row3-proposal">
                                <div class="invite-col3" <?php  if ($youHired) echo 'data-poload="'.Yii::app()->createUrl('commonfront/hiredpopover').'?'.Globals::FLD_NAME_USER_ID.'='.$data->{Globals::FLD_NAME_USER_ID}.'" data-placement="bottom"' ?>>
                                    <div class="invite-count"><?php if ($youHired) echo count($youHired); else echo '0' ?></div>
                                    Hired
                                </div>
                                <div class="invite-col3" data-poload="<?php echo Yii::app()->createUrl('commonfront/networkpopover').'?'.Globals::FLD_NAME_USER_ID.'='.$data->{Globals::FLD_NAME_USER_ID} ;?>" data-placement="bottom">
                                    <div class="invite-count2">5</div>
                                    Network
                                </div>
                                <div class="invite-col3" 
                                     <?php  if ($data->{Globals::FLD_NAME_TASK_DONE_CNT} > 0) echo 'data-poload="'.Yii::app()->createUrl('commonfront/jobspopover').'?'.Globals::FLD_NAME_USER_ID.'='.$data->{Globals::FLD_NAME_USER_ID}.'" data-placement="bottom"' ?>
                                     >
                                    <div class="invite-count3"><?php echo $data->{Globals::FLD_NAME_TASK_DONE_CNT} ?></div>
                                    Jobs
                                </div>
                            </div>                              
                            <div class="proposal_row2 margin-bottom-10 description-b"><article><?php echo CommonUtility::getUserDescription($data->{Globals::FLD_NAME_USER_ID}); ?></article></div>            
                            <div class="proposal_row1">
                                <div class="total_task"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_skills'));?><span class="graytext"><?php echo $skills; ?></span></div>

                            </div> 
                        </div>
                        
                        
                       
                        
                            <div class="pro-icon-doer" style="display:none">
                            <div class="col-md-12 no-mrg">
                                <!--<div class="proposal_col4"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_task_completed'));?>: <span class="mile_away"><?php // echo $data->{Globals::FLD_NAME_TASK_DONE_CNT} ?></span></div>-->
                                <div class="proposal_col4"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'Location'));?>: <span class="mile_away"><?php echo $work_location ?></span></div><div class="clr"></div></div>
                                <div class="col-md-12 no-mrg">
                                <div class="pro-btn-doer">
                                    <a class="btn-u rounded btn-u-sea display-b popovercontent" 
                                       data-poload="<?php echo Yii::app()->createUrl('commonfront/postertasklistpopover?doer_id='.$data->{Globals::FLD_NAME_USER_ID}); ?>"
                                       data-placement="bottom"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_invite'));?></a>                                                                           
                                </div>
                                <div class="pro-btn-doer">
                                    <a class="btn-u rounded btn-u-blue display-b popovercontent" data-poload="<?php echo Yii::app()->createUrl('commonfront/connectmepopover');?>" data-placement="bottom"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_message'));?></a>                                    
                                </div>
                                    <div class="pro-btn-doer">
                                    <a class="btn-u rounded btn-u-default display-b "><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_connect'));?></a>                                    
                                </div>
                                    
                                    <div class="clr"></div></div>                         
                            </div>
                             
        </div>
<?php 
if($index%2 != 0)
{
?>
</div>
<?php
}
?>