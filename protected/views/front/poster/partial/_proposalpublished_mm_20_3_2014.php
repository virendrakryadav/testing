  <?php
  if($proposals)
  {
      ?>
<!--Invited tasker start here-->
<div class="controls-row" style="padding: 10px">
  <div class="span7 nopadding">
  <h2 class="h4"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_proposals')); ?>
</h2>
  <?php
      foreach($proposals as $proposal)
      {
         ?>
         <div class="controls-row pdn">
                          <div class=" profile_img">
                           <?php $img = CommonUtility::getThumbnailMediaURI($proposal->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                           <img src="<?php echo $img ?>" />
                          </div>
                          <div class="task_detail_col">
                              <h2 class="h4"><?php echo CommonUtility::getUserFullName($proposal->{Globals::FLD_NAME_TASKER_ID}); ?></h2>
                             
                              <div class="controls-row">
                                  <div class="task_detail_col2">Price:</div>
                                  <div class="task_detail_col3 blue_text"><?php echo  Globals::DEFAULT_CURRENCY . $proposal->{Globals::FLD_NAME_TASKER_PROPOSED_COST}; ?></div>
                              </div>
      
                              <div class="task_descrip">
                                  <h4><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_proposal')); ?>:</h4>
                                 <?php echo  $proposal->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?>
                                 </div>
                              <?php
                                if( $model->{Globals::FLD_NAME_USER_ID} == Yii::app()->user->id    )
                                {
                                    ?>
                              <div class="controls-row cnl_space">
        <div class="span5 nopad" >
       <div id="acceptProposalButton<?php echo $proposal->{Globals::FLD_NAME_TASKER_ID} ?>" >
               
<?php 
if( ($task->{Globals::FLD_NAME_TASK_STATE} == Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED) )
{
    if( ($proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED) )
        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_assigned'));
}
else
{
  
    if( $proposal->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
    {
        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
    }
    else
    {
                            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accept')), 
                            Yii::app()->createUrl('poster/proposalaccept'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                             
                                              ),
                               
                                    'type' => 'POST', 
                                    'success' => 'js:function(data){
                                        jQuery("#postedporposal").html(data); 
                                                                }'), 
                                    array('id' => 'proposalAccept'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'sign_bnt', 'live' => false));
                                    
                                    ?>
      
            &nbsp;
            
                      
<?php 

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
                                    'success' => 'js:function(data){
                                                    if(data.status==="success")
                                                    {
                                                        jQuery("#acceptProposalButton'.$proposal->{Globals::FLD_NAME_TASKER_ID}.'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'");
                                                    }
                                                    else
                                                    {
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                                
                                                                }'), 
                                    array('id' => 'proposalReject'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'cnl_btn', 'live' => false));
}  }
                                    ?>
            </div>
        </div>
    </div>
                              
                                    
                                    <?php
                                
                                }
                              ?>
                              
                          </div>
                      </div>
                      <?php
                          echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_view_more')), 
                              Yii::app()->createUrl('poster/loadproposalpreview'),
                              array(
                                    'beforeSend' => 'function(){$("#loadproposalpreview").addClass("displayLoading");}',
                                    'complete' => 'function(){$("#loadproposalpreview").removeClass("displayLoading");}',
                                    'data' => array(
                                              'task_tasker_id' => $proposal->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                              'taskId' =>$proposal->{Globals::FLD_NAME_TASK_ID} , 
                                              'is_pubilshed' =>1  ),
                                     'type' => 'POST', 
                                     'success' => 'function(data){
                                                               jQuery("#loadproposalpreview").html(data); 
                                                               jQuery("#loadproposalpreview").css("display","block"); }'), 
                                    array('id' => 'edituserproposal'.$proposal->{Globals::FLD_NAME_TASKER_ID},
                                    'class' => 'sign_bnt', 'live' => false));
      }
      ?>
      
  </div>
 
</div>
<?php
      }
 

 ?>
            
        
      
 
      
<!--Invited tasker ends here-->