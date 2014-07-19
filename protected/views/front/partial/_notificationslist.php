<div class="notify_cont <?php if( $data[Globals::FLD_NAME_IS_SEEN] == Globals::DEFAULT_VAL_NOTIFICATION_NOTSEEN) echo 'notSeen' ?>  " 
     id="notify_cont_<?php echo  $data[Globals::FLD_NAME_ALERT_ID] ?>"  >
    <div class="getSeen" ><span class="<?php echo $data[Globals::FLD_NAME_IS_SEEN]  ?>"></span></div>
    <div class="getAlertId" ><span class="<?php echo $data[Globals::FLD_NAME_ALERT_ID]  ?>"></span></div>
   
    <div class="notify_img"><img width="46px" height="40" src="<?php echo CommonUtility::getThumbnailMediaURI($data["userbyuser"][Globals::FLD_NAME_USER_ID], Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50) ?>"></div>
    <div class="notify_content"><a href="#"><?php echo CommonUtility::getUserFullName($data["userbyuser"][Globals::FLD_NAME_USER_ID]); ?></a>
        <?php echo $data[Globals::FLD_NAME_ALERT_DESC] ?> 
        <a href="<?php echo  CommonUtility::getTaskDetailURI( $data["task"][Globals::FLD_NAME_TASK_ID] ); ?>">
            <?php echo $data["task"][Globals::FLD_NAME_TITLE] ?>
        </a>
    </div>
    <div class="ntf_cont_over" style="display: none"> 
        <div class="item_label">
        <span class="item_label_text">You hired</span>
    </div>
        <div class="ntf_cont_col1"> 
            <p> 
                <?php
                        $milesAway = CommonUtility::calDistance($data["userforuser"][Globals::FLD_NAME_LOCATION_LONGITUDE],$data["userforuser"][Globals::FLD_NAME_LOCATION_LATITUDE],
                        $data["tasktasker"][Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE],$data["tasktasker"][Globals::FLD_NAME_TASKER_LOCATION_LATITUDE]);
                        if($milesAway)
                        {
                            ?>
                            <span class="mile"> <?php echo $milesAway ?> mile away</span>
                            <?php
                        }
                        ?>
                <span class="mile">Price: <?php echo Globals::DEFAULT_CURRENCY.$data["tasktasker"][Globals::FLD_NAME_TASKER_PROPOSED_COST] ?></span>
                <span class="mile"><?php echo CommonUtility::agoTiming( $data["tasktasker"][Globals::FLD_NAME_CREATED_AT] ); ?> ago</span>
            </p>
            <p class="ntf_descrip">
                 <?php echo substr( $data["tasktasker"][Globals::FLD_NAME_TASKER_POSTER_COMMENTS], 0, Globals::DEFAULT_VAL_NOTIFICATION_DESCRIPTION_LIMIT);
                    if (strlen($data["tasktasker"][Globals::FLD_NAME_TASKER_POSTER_COMMENTS]) > Globals::DEFAULT_VAL_NOTIFICATION_DESCRIPTION_LIMIT) { ?> 
                <?php echo CHtml::ajaxLink(' View More',Yii::app()->createUrl('poster/viewtaskpopup'),array(
//                        'beforeSend' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
//                        'complete' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
			'data' => array(Globals::FLD_NAME_TASK_ID => $data["task"][Globals::FLD_NAME_TASK_ID]), 'type' => 'POST',
			'success' => 'function(data){ $(\'#loadtaskpreview\').html(data); $(\'#loadtaskpreview\').css("display","block");}'),
                        array('id' => 'viewmore'.$data["task"][Globals::FLD_NAME_TASK_ID],  'live' => false));?>
                <?php } ?>
                    <?php echo $data["tasktasker"][Globals::FLD_NAME_TASKER_POSTER_COMMENTS] ?></p></div>
        <div class="ntf_cont_col2" id="proposalAccept<?php echo $data["tasktasker"][Globals::FLD_NAME_TASK_TASKER_ID] ?>" >
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
                                    'class' => 'accept_btn', 'live' => false));
                          
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
                                    'class' => 'decline_btn', 'live' => false));
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
                                    'class' => 'decline_btn', 'live' => false));
                break;
                }
            default:
                break;
        }
            
            
                                    ?>
        </div>
    </div>
    <div class="notify_time" style="display: block"><?php echo CommonUtility::agoTiming( $data[Globals::FLD_NAME_CREATED_AT] ); ?></div>
</div>       