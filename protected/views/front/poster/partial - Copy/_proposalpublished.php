<style>
    .new_box {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #E1E1E1;
    box-shadow: 0 0 4px -2px #636363;
    float: left;
    height: auto;
    margin-bottom: 20px;
    width: 100%;
}
.praposal_dta2{
    float: left;
}
</style>
<?php
  if($proposals)
  {
      ?>
<div class="box">
            <div class="box_topheading ">
                <div class="controls-row">
                    <h3 class="h3 pull-left"><?php  echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?></h3>
                    <?php
                    if( $model->{Globals::FLD_NAME_USER_ID} == Yii::app()->user->id )
                    {
                        ?>
                    <div class="pull-right"><?php echo CHtml::link(Yii::t('poster_taskdetail', 'lbl_view_more'), CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID})) ?></div>
                        <?php 
                    }
                    ?>
                </div>
            </div>  
   
            <div class="box3">
<?php
      foreach($proposals as $proposal)
      {
         ?>
           <div class="controls-row  tasker_list3 box3 ">
<div class="praposal_pfl"><?php $img = CommonUtility::getThumbnailMediaURI($proposal->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                           <img src="<?php echo $img ?>" /></div>
<div class="praposal_dtal">
 <div class="controls-row">
<div class="praposal_price"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_your_bid_price')); ?>:
<span class="prpl_price"> <?php echo  Globals::DEFAULT_CURRENCY . intval( $proposal->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span>
</div>
<div class="praposal_descrp">
    <p class="date"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_bid_by')); ?>
        <?php echo UtilityHtml::getUserFullNameWithPopover( $proposal->{Globals::FLD_NAME_TASKER_ID}) ?><span class="date"> <?php echo  CommonUtility::agoTiming( $proposal->{Globals::FLD_NAME_CREATED_AT} ); ?> 
            <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_ago')) ?> </span></p>
<!--<strong><?php //echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_proposal')); ?>: </strong>-->
    <?php  echo CommonUtility::truncateText( $proposal->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} , Globals::DEFAULT_VAL_MY_TASK_DETAIL_PROPOSAL_LIMIT ); ?>
<br/>
<?php
           
                          echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_view_detail')), 
                              Yii::app()->createUrl('poster/loadproposalpreview'),
                              array(
                                        'beforeSend' => 'function(){$("#loadproposalpreview").addClass("displayLoading");}',
                                        'complete' => 'function(){$("#loadproposalpreview").removeClass("displayLoading");}',
                                        'data' => array(
                                              'task_tasker_id' => $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                              'taskId' =>$proposal->{Globals::FLD_NAME_TASK_ID} , 
                                              'is_published' =>1  ),
                                        'type' => 'POST', 
                                        'success' => 'function(data){
                                                               jQuery("#loadproposalpreview").html(data); 
                                                               jQuery("#loadproposalpreview").css("display","block"); }'), 
                                        array('id' => 'edituserproposal'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                        'class' => '', 'live' => false));
                                    ?>
</div>
</div>
     <?php
    
    if( $model->{Globals::FLD_NAME_USER_ID} == Yii::app()->user->id    )
    {
                                    ?>
    <div class="praposal_btn btn_cont" id="acceptProposalButton<?php echo $proposal->{Globals::FLD_NAME_TASKER_ID} ?>" >
        <div class="ancor">
<?php 
//echo $task->{Globals::FLD_NAME_TASK_STATE};
//if( ($task->{Globals::FLD_NAME_TASK_STATE} == Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED) )
//{
////    echo $proposal->{Globals::FLD_NAME_TASKER_STATUS};
////    echo Globals::DEFAULT_VAL_TASK_STATUS_SELECTED;
//    if( ($proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED) )
//        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned'));
//    elseif( $proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
//    {
//        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
//    }
//}
//else
//{
    if( $proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
    {
        //echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
       ?>
            <div class="item_label">
                <span class="item_label_text"><?php  echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')) ?></span>
            </div>
            <?php
    }
    elseif( $proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
    {
       // echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned'));
         ?>
            <div class="item_label_green">
                <span class="item_label_text"><?php  echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned')) ?></span>
            </div>
            <?php
    }
    else
    {                       $ifAcceptAction = '<div class=\"item_label_green\"><span class=\"item_label_text\">'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned')).'</span></div>';
                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accept')), 
                            Yii::app()->createUrl('poster/proposalaccept'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                             
                                              ),
                               
                                    'type' => 'POST', 
                                    'dataType'=>'json',
                                    'success' => 'js:function(data){
                                        //jQuery("#loadProposalDiv").html(data); 
                                        if(data.status==="success")
                                        {
                                            jQuery("#acceptProposalButton'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifAcceptAction.'");
                                        }
                                        else
                                        {
                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                        }
                                                                }'), 
                                    array('id' => 'proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'ancor_bnt2', 'live' => false));
                            ?>
        </div>
                            <div class="ancor">
                        <?php 
                        $ifRejectAction = '<div class=\"item_label\"><span class=\"item_label_text\">'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'</span></div>';
                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_reject')), 
                            Yii::app()->createUrl('poster/proposalreject'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalReject'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalReject'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                              ),
                                    'dataType'=>'json',
                                    'type' => 'POST', 
                                    'success' => 'js:function(data)
                                    {
                                        if(data.status==="success")
                                        {
                                            jQuery("#acceptProposalButton'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifRejectAction.'");
                                        }
                                        else
                                        {
                                            alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                        }
                                    }'), 
                                    array('id' => 'proposalReject'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'ancor_bnt_red', 'live' => false));
    }  
//}
                                    ?>
            </div></div>
    <?php } ?>
</div>
     
  

            </div>
        <?php
        
    }
      ?>
        </div>
</div>
<?php
      }
      else
      {
      ?>
            <div class="new_box">
            <div class="box_topheading ">
                <div class="controls-row">
                    <h3 class="h3 pull-left"><?php  echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?></h3>
                </div>
            </div>
            <div class="box3">
                    <div class="controls-row  tasker_list3 box3 ">
                        <div class="praposal_dta2">
                            <?php  
                            if($bidStatus == '<span class="">Bid Not Started</span>') 
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_can_not_receive_proposals'));
                            else if($bidStatus == '<span class="">Closed</span>') 
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_no_proposals_for_new_taskers'));
                            else
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_no_proposals_received'));
                            ?>
                        </div>
                        <?php //echo $bidStatus;exit;
                        if(($bidStatus!='<span class="">Bid Not Started</span>') && ($bidStatus!='<span class="">Closed</span>'))
                        {
                        ?>
                        <div id="acceptProposalButton194" class="praposal_btn btn_cont">
<!--                            <div class="ancor">
                                <a href="#" class="ancor_bnt2" id="proposalAccept194">Invite</a>        
                            </div>-->
                            <?php // print_r($task);exit;
                            echo CHtml::Link(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite')), Yii::app()->createUrl('tasker/invitetasker') . "?taskId=" . $task->{Globals::FLD_NAME_TASK_ID} . "&category_id=" . $task->category->category_id, 
                            array('id' => 'publishinpersontask', 'class' => 'ancor_bnt2'));
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
            </div>
            
      <?php
      }
 ?>
