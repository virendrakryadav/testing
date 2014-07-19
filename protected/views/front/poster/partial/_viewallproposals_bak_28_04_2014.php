<?php
$user = User::model()->findByPk($data->{Globals::FLD_NAME_TASKER_ID});
$latitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
$longitude2 = $data->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
$getDistance = 0;
$isInvited = TaskTasker::isTaskerInvitedForTask( $data->{Globals::FLD_NAME_TASK_ID} , $data->{Globals::FLD_NAME_TASKER_ID} );
if(isset($taskLocation))
{
$latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
$longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}
?>
<div class="rowselector">
    
<div class="controls-row pdn6"> 
<div class="proposal_list">
<div class="item_labelblue">
<span class="proposal_label_blue"><?php echo Yii::t('poster_createtask', 'New')?></span>
</div>
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>">
<!--<div class="tasker_invite"><a href="#">Invited</a></div>-->
</div>
<div class="proposal_rating">
    <?php CommonUtility::DisplayRating(Globals::FLD_NAME_TASK_DONE_RANK.$data->{Globals::FLD_NAME_TASKER_ID} ,$user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></div>
<div class="proposal_btn" id="acceptProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
    <?php
    if( $isTaskCancel )
    {
        $ifAcceptAction = '<a id=\"proposalhaired'.$data->{Globals::FLD_NAME_TASKER_ID}.'\" class=\"hire_btn\" href=\"#\">Hired</a>';
        if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
        {
            echo '<a id="proposalhaired'.$data->{Globals::FLD_NAME_TASKER_ID}.'" class="hire_btn" href="#">Hired</a>' ;
        }
        elseif( $data->{Globals::FLD_NAME_TASKER_STATUS} != Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
        {
                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'Hire me')), 
                            Yii::app()->createUrl('poster/proposalaccept'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                             
                                              ),
                               
                                    'type' => 'POST', 
                                    'dataType'=>'json',
                                    'success' => 'js:function(data){
                                        //jQuery("#loadProposalDiv").html(data); 
                                        if(data.status==="success")
                                        {
                                            jQuery("#acceptProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifAcceptAction.'");
                                                jQuery("#rejectProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("");
                                        }
                                        else
                                        {
                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                        }
                                                                }'), 
                                    array('id' => 'proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'hire_btn', 'live' => false));
        }
    }
                            ?>
                            
<!--<input type="button" class="hire_btn" value="Hire me" name="">-->
</div>
<div class="proposal_btn">
<input type="button" class="connect_btn" value="Connect me" name="">
</div>
</div>
<div class="proposal_col2">
<div class="proposal_row">
    <p class="tasker_name"><?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID} ) ?> <span class="tasker_city"><?php echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></p>
<div class="tasker_col4 "><span class="date"><?php echo  CommonUtility::agoTiming( $data->{Globals::FLD_NAME_CREATED_AT} ); ?> 
            <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_ago')) ?></span></div>

<?php if($getDistance != 0)
      {
          ?>
      <div class="tasker_col4 "><span class="mile_away"><?php echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));?></span> </div>
          <?php } ?>
      
      

<div class="tasker_col4"><a href="#">10 Reviews</a></div>
<div class="tasker_col4"><span class="mile_away">
                <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/userskillspopover').'?'.Globals::FLD_NAME_USER_ID.'='.$data->{Globals::FLD_NAME_TASKER_ID} ?>">Skills</a>

                </span></div>
<div class="tasker_col4"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>
</div>  
<div class="proposal_row1">
  <div class="total_task"><?php echo Yii::t('poster_createtask', 'Task completed')?>: <span class="mile_away">10</span></div><div class="iconbox">
      <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/taskqueansweroftasker') . '?' . Globals::FLD_NAME_TASKER_ID . '=' . $data->{Globals::FLD_NAME_TASKER_ID} . "&" . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>"><img src="../images/ask-question.png"></a>

      </div>
  <div class="iconbox" id="potentialFor_<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>">
       
        <?php
        //<img src="'.CommonUtility::getPublicImageUri( "fevorite.png" ).'">
                $isBookMark = UserBookmark::isBookMarkByUser(array(Globals::FLD_NAME_TASK_ID => $data->{Globals::FLD_NAME_TASK_ID} , Globals::FLD_NAME_USER_ID => Yii::app()->user->id ,Globals::FLD_NAME_BOOKMARK_TYPE => Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK , Globals::FLD_NAME_BOOKMARK_SUBTYPE => Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE ));
                if($isBookMark)
                {
                    $this->renderPartial('_unsetpotential',array('taskId'=> $data->{Globals::FLD_NAME_TASK_ID} ));
                }
                else
                {
                    $this->renderPartial('_setpotential',array('taskId'=> $data->{Globals::FLD_NAME_TASK_ID} ));
                }
                ?>
       
       </div> 
<!--  <div class="iconbox"><img src="../images/potential.png"></div>-->
  <?php if($isInvited)
  {
    ?>
    <div class="iconbox"><img src="../images/bell.png"></div>
    <?php
  }
  ?>
  
  <div class="iconbox">
      <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/connectmepopover');?>">
      <img src="../images/connect.png">
      </a>
  </div>
  <div class="tasker_col5" id="rejectProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID}?>">
    <?php
    if( $isTaskCancel )
    {
        $ifRejectAction = '<a id=\"proposalhaired'.$data->{Globals::FLD_NAME_TASKER_ID}.'\" class=\"interested_btn\" href=\"#\">Rejected</a>';
        if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
        {
            echo '<a id="proposalhaired'.$data->{Globals::FLD_NAME_TASKER_ID}.'" class="interested_btn" href="#">Rejected</a>' ;
        }
        elseif( $data->{Globals::FLD_NAME_TASKER_STATUS} != Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
        {

        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'Not interested')), 
                            Yii::app()->createUrl('poster/proposalreject'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                              ),
                                    'dataType'=>'json',
                                    'type' => 'POST', 
                                    'success' => 'js:function(data)
                                    {
                                        if(data.status==="success")
                                        {
                                            jQuery("#rejectProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifRejectAction.'");
                                            jQuery("#acceptProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("");
                                        }
                                        else
                                        {
                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                        }
                                    }'), 
                                    array('id' => 'proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'interested_btn', 'live' => false));
        }  
    }
    
    
    
//}
                                    ?>
                                  </div>
</div>  

<div class="proposal_row2"><strong>Description:</strong> <?php  echo CommonUtility::truncateText( $data->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} , Globals::DEFAULT_VAL_MY_PROPOSAL_LIST_DESCRIPTION_LIMIT ); ?> 
    <?php 
     $page = array_search($data->{Globals::FLD_NAME_TASK_TASKER_ID}, $proposalIds);
    $page = $page + 1; ?>
    <a target="_blank" href="<?php echo Yii::app()->createUrl('tasker/proposaldetail')."?task_id=".$data->{Globals::FLD_NAME_TASK_ID}."&task_tasker_id=".$data->{Globals::FLD_NAME_TASK_TASKER_ID}."&TaskTasker_page=".$page ?>">view detail</a>

</div>            
</div>
</div>
</div>              
</div>
    
</div>
    
<!--    //
    <div class="controls-row  tasker_list3 box3">
<div class="praposal_pfl"><?php $img = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                           <img src="<?php echo $img ?>" /></div>
<div class="praposal_dtal">
 <div class="controls-row">
<div class="praposal_price"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_your_bid_price')); ?>:
<span class="prpl_price"> <?php echo  Globals::DEFAULT_CURRENCY . intval( $data->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span>
</div>
<div class="praposal_descrp">
    <p class="date"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_bid_by')); ?>
        <?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_TASKER_ID}) ?><span class="date"> <?php echo  CommonUtility::agoTiming( $data->{Globals::FLD_NAME_CREATED_AT} ); ?> 
            <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_ago')) ?> </span></p>
<strong><?php //echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_proposal')); ?>: </strong>
    <?php  echo CommonUtility::truncateText( $data->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} , Globals::DEFAULT_VAL_MY_TASK_DETAIL_PROPOSAL_LIMIT ); ?>
<br/>
<?php
           
                          echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_view_detail')), 
                              Yii::app()->createUrl('poster/loadproposalpreview'),
                              array(
                                        'beforeSend' => 'function(){$("#loadproposalpreview").addClass("displayLoading");}',
                                        'complete' => 'function(){$("#loadproposalpreview").removeClass("displayLoading");}',
                                        'data' => array(
                                              'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                              'taskId' =>$data->{Globals::FLD_NAME_TASK_ID} , 
                                              'is_pubilshed' =>1  ),
                                        'type' => 'POST', 
                                        'success' => 'function(data){
                                                               jQuery("#loadproposalpreview").html(data); 
                                                               jQuery("#loadproposalpreview").css("display","block"); }'), 
                                        array('id' => 'edituserproposal'.$data->{Globals::FLD_NAME_TASKER_ID},
                                        'class' => '', 'live' => false));
                                    ?>
</div>
</div>
     <?php
    
    if( $task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id    )
    {
                                    ?>
    <div class="praposal_btn btn_cont" id="acceptProposalButton<?php echo $data->{Globals::FLD_NAME_TASKER_ID} ?>" >
        <div class="ancor">
<?php 
//echo $task->{Globals::FLD_NAME_TASK_STATE};
//if( ($task->{Globals::FLD_NAME_TASK_STATE} == Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED) )
//{
////    echo $data->{Globals::FLD_NAME_TASKER_STATUS};
////    echo Globals::DEFAULT_VAL_TASK_STATUS_SELECTED;
//    if( ($data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED) )
//        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned'));
//    elseif( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
//    {
//        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
//    }
//}
//else
//{
    if( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
    {
        //echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
       ?>
            <div class="item_label">
                <span class="item_label_text"><?php  echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')) ?></span>
            </div>
            <?php
    }
    elseif( $data->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
    {
       // echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned'));
         ?>
            <div class="item_label_green">
                <span class="item_label_text"><?php  echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned')) ?></span>
            </div>
            <?php
    }
    else
//    {                       $ifAcceptAction = '<div class=\"item_label_green\"><span class=\"item_label_text\">'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned')).'</span></div>';
//                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accept')), 
//                            Yii::app()->createUrl('poster/proposalaccept'),
//                              array(
//                                    'beforeSend' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
//                                    'complete' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
//                                    'data' => array(
//                                              'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
//                                             
//                                              ),
//                               
//                                    'type' => 'POST', 
//                                    'dataType'=>'json',
//                                    'success' => 'js:function(data){
//                                        //jQuery("#loadProposalDiv").html(data); 
//                                        if(data.status==="success")
//                                        {
//                                            jQuery("#acceptProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifAcceptAction.'");
//                                        }
//                                        else
//                                        {
//                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
//                                        }
//                                                                }'), 
//                                    array('id' => 'proposalAccept'.$data->{Globals::FLD_NAME_TASKER_ID},
//                                    'class' => 'ancor_bnt2', 'live' => false));
                            ?>
        </div>
                            <div class="ancor">
                        <?php 
//                        $ifRejectAction = '<div class=\"item_label\"><span class=\"item_label_text\">'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'</span></div>';
//                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_reject')), 
//                            Yii::app()->createUrl('poster/proposalreject'),
//                              array(
//                                    'beforeSend' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
//                                    'complete' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
//                                    'data' => array(
//                                              'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
//                                              ),
//                                    'dataType'=>'json',
//                                    'type' => 'POST', 
//                                    'success' => 'js:function(data)
//                                    {
//                                        if(data.status==="success")
//                                     $ifRejectAction   {
//                                            jQuery("#acceptProposalButton'.$data->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifRejectAction.'");
//                                        }
//                                        else
//                                        {
//                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
//                                        }
//                                    }'), 
//                                    array('id' => 'proposalReject'.$data->{Globals::FLD_NAME_TASKER_ID},
//                                    'class' => 'ancor_bnt_red', 'live' => false));
//    }  
//}
                                    ?>
            </div></div>
    <?php } ?>
</div>
     
  

            </div>  </div>-->