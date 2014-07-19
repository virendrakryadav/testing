<?php
$getNotificationTypeClass = UtilityHtml::getNotificationTypeClass($data[Globals::FLD_NAME_ALERT_DESC]);

//if(isset($array[$data[Globals::FLD_NAME_ALERT_ID]])
?>
<h4 class="panel-title">
    <?php if(isset($array[$data[Globals::FLD_NAME_ALERT_ID]]))
    {
         echo  CommonUtility::formatedViewDate($data[Globals::FLD_NAME_CREATED_AT]);
    }     
    ?>
</h4>
<div class="alert-notify alert-<?php echo $getNotificationTypeClass; ?> fade in overflow-h">
    
<div class="col-md-9 no-mrg <?php if( $data[Globals::FLD_NAME_IS_SEEN] == Globals::DEFAULT_VAL_NOTIFICATION_NOTSEEN) echo 'notSeen' ?>  " 
     id="notify_cont_<?php echo  $data[Globals::FLD_NAME_ALERT_ID] ?>"  >
    <div class="getSeen" ><span class="<?php echo $data[Globals::FLD_NAME_IS_SEEN]  ?>"></span></div>
    <div class="getAlertId" ><span class="<?php echo $data[Globals::FLD_NAME_ALERT_ID]  ?>"></span></div>
   
    <div class="notify_img"><img width="46px" height="40" src="<?php echo CommonUtility::getThumbnailMediaURI($data["userbyuser"][Globals::FLD_NAME_USER_ID], Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50) ?>"></div>
    <div class="notify_content"><a target="_blank" href="<?php echo CommonUtility::getTaskerProfileURI( $data["userbyuser"][Globals::FLD_NAME_USER_ID] )?>" ><?php echo CommonUtility::getUserFullName($data["userbyuser"][Globals::FLD_NAME_USER_ID]); ?></a>
        <?php echo Yii::t('notifications', $data[Globals::FLD_NAME_ALERT_DESC]) ?> 
        <a title="<?php echo $data["task"][Globals::FLD_NAME_TITLE] ?>" target="_blank" href="<?php echo  CommonUtility::getTaskDetailURI( $data["task"][Globals::FLD_NAME_TASK_ID] ); ?>">
            <?php echo commonUtility::truncateText(ucfirst($data["task"][Globals::FLD_NAME_TITLE]),Globals::DEFAULT_TASK_TITLE_LENGTH); ?>
            <?php // echo $data["task"][Globals::FLD_NAME_TITLE] ?>
        </a>
    </div>
    
<!--    <div class="notify_time" style="display: block"><?php echo CommonUtility::agoTiming( $data[Globals::FLD_NAME_CREATED_AT] ); ?></div>-->
</div>       
  
  
  <div class="col-md-3 no-mrg align-right" >        
        <div class="accepte-col" id="proposalAccept<?php echo $data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID] ?>" >
            <?php
      
        switch ($data[Globals::FLD_NAME_ALERT_DESC]) {
            case Globals::ALERT_DESC_CREATE_PROPOSAL:
                switch ($data["tasktasker"][Globals::FLD_NAME_TASKER_STATUS]) 
                {
                    case Globals::DEFAULT_VAL_TASK_STATUS_SELECTED:
                        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accepted'));
                        break;
                    
                    case Globals::DEFAULT_VAL_TASK_STATUS_REJECTED :
                        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
                        break;

                    default:
                        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accept')), 
                            Yii::app()->createUrl('index/proposalaccept'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalAcceptButton'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalAcceptButton'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID], 
                                              ),
                                    'type' => 'POST', 
                                    'dataType'=>'json',
                                    'success' => 'js:function(data){
                                                    if(data.status==="success")
                                                    {
                                                        $("#proposalAccept'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accepted')).'");
                                                    }
                                                    else
                                                    {
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                                }'),
                                    array('id' => 'proposalAcceptButton'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID],
                                    'class' => 'btn-u rounded btn-u-sea push', 'live' => false));
                          
                        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_reject')), 
                            Yii::app()->createUrl('index/proposalreject'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID], 
                                              ),
                                    'dataType'=>'json',
                                    'type' => 'POST', 
                                    'success' => 'js:function(data){
                                                    if(data.status==="success")
                                                    {
                                                        jQuery("#proposalAccept'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'");
                                                    }
                                                    else
                                                    {
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                                }'), 
                                    array('id' => 'proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID],
                                    'class' => 'btn-u rounded btn-u-red push mrg-l', 'live' => false));
                        break;
                }

                break;
            case Globals::ALERT_DESC_ACCEPT_PROPOSAL:
              //  echo $data->tasktasker->{Globals::FLD_NAME_TASKER_STATUS};
                switch ($data["tasktasker"][Globals::FLD_NAME_TASKER_STATUS]) 
                {
                   
                    
                    case Globals::DEFAULT_VAL_TASK_STATUS_REJECTED :
                        echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected'));
                        break;
                    default:
                    echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_reject')), 
                            Yii::app()->createUrl('index/proposalrejectbyuser'),
                              array(
                                    'beforeSend' => 'function(){$("#proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").addClass("loading");}',
                                    'complete' => 'function(){$("#proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").removeClass("loading");}',
                                    'data' => array(
                                              'task_tasker_id' => $data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID], 
                                              ),
                                    'dataType'=>'json',
                                    'type' => 'POST', 
                                    'success' => 'js:function(data){
                                                    if(data.status==="success")
                                                    {
                                                        jQuery("#proposalAccept'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID].'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'");
                                                    }
                                                    else
                                                    {
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                                }'), 
                                    array('id' => 'proposalReject'.$data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID],
                                    'class' => 'btn-u rounded btn-u-red push mrg-l', 'live' => false));
                break;
                }
            default:
                break;
        }
            
            
                                    ?>
        </div>
    </div>
    
</div> 