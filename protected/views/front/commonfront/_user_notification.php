<?php
//echo $recordcount;
$tasker_name = CommonUtility::getUserFullName($data->{Globals::FLD_NAME_BY_USER_ID});
$taskTasker = TaskTasker::model()->with('task')->findByPk($data->{Globals::FLD_NAME_TASK_TASKER_ID});$inactiveClass = ($data->{Globals::FLD_NAME_IS_SEEN} == 0) ? '': 'seen_notification';

 $link = CommonUtility::getLinkOfNotification($data->{Globals::FLD_NAME_TASK_TASKER_ID} , $data->{Globals::FLD_NAME_ALERT_DESC});
//echo $link;
//echo $data->{Globals::FLD_NAME_ALERT_DESC};
?>
<script>
    function Seennotification(alert_id)
    {
        var link = document.getElementById('link').value;
         $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('commonfront/isseennotification');?>',
            dataType: 'json',
            data: {alert_id: alert_id},
            success: function (data) {
                   $('#user_noti_'+alert_id).removeClass('border-bot1');
                   $('#user_noti_'+alert_id).html('');
                   window.location= link;
            }
        });
    }        
</script>
<div class="col-md-12 margin-bottom-10 border-bot1 <?php echo $inactiveClass;?>" id="user_noti_<?php echo $data->{Globals::FLD_NAME_ALERT_ID}?>">
    <input type="hidden" id="alert_id" name="alert_id" value="<?php echo $data->{Globals::FLD_NAME_ALERT_ID}?>">
    <input type="hidden" id="link" name="link" value="<?php echo $link?>">
<?php    
if($data->{Globals::FLD_NAME_ALERT_DESC} == Globals::ALERT_DESC_TASK_CANCELED && $taskTasker->{Globals::FLD_NAME_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED)
{
    ?><div class="col-md-12 align-center mrg10">
        <!--    <img id="" src="<?php // echo $img;?>">-->
            <a href="#" onclick="Seennotification(<?php echo $data->{Globals::FLD_NAME_ALERT_ID}?>)"><?php echo $taskTasker[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE]." has been requested for cancellation";?></a></div>
    <div class="col-md-12 align-center" id="proposal_status">
        <a>
            <span style="cursor: pointer" onclick="cancelacceptedbydoer('<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_ID}; ?>','<?php echo $taskTasker[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE]; ?>')">Cancel project</span>|            
            <span style="cursor: pointer">Partial Completion </span>|
            <span style="cursor: pointer" onclick="window.location.href='<?php echo Yii::app()->createUrl('tasker/projectcompletion/task_id/'.$taskTasker->{Globals::FLD_NAME_TASK_ID});?>'" >Complete Project </span>
        </a>
    </div>
                <?php
}
else
{
    ?>
        <div class="col-md-12 align-center mrg10">
        <!--    <img id="" src="<?php // echo $img;?>">-->
            <a href="#" onclick="Seennotification(<?php echo $data->{Globals::FLD_NAME_ALERT_ID}?>)"><?php echo $tasker_name." ".Yii::t('user_alert',$data->{Globals::FLD_NAME_ALERT_DESC})." ".$taskTasker['task']['title'];?></a></div>
        <?php
        if($data->{Globals::FLD_NAME_ALERT_DESC} == Globals::ALERT_DESC_CREATE_PROPOSAL)
        {
        ?>
        <div class="col-md-12 align-center" id="proposal_status">
        <?php
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accept')), 
            Yii::app()->createUrl('index/proposalaccept'),
            array(
                    'beforeSend' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").addClass("loading");}',
                    'complete' => 'function(){$("#proposalAccept'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").removeClass("loading");}',
                    'data' => array(
                            'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                            'alert_id' => $data->{Globals::FLD_NAME_ALERT_ID}, 
                            ),
                    'dataType'=>'json',
                    'type' => 'POST', 
                    'success' => 'js:function(data){
                                    if(data.status==="success")
                                    {
    //                                                        jQuery("#proposalAccept'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accepted')).'");
                                            jQuery("#proposal_status").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_accepted')).'");
                                            jQuery("#user_noti'.$data->{Globals::FLD_NAME_ALERT_ID}.'").html("");

                                    }
                                    else
                                    {
                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                    }
                                                }'), 
                    array('id' => 'proposalAccept'.$data->{Globals::FLD_NAME_TASK_TASKER_ID},
                    ));
        ?>
            | 
        <?php

        echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_reject')), 
                                    Yii::app()->createUrl('index/proposalreject'),
                                    array(
                                            'beforeSend' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").addClass("loading");}',
                                            'complete' => 'function(){$("#proposalReject'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").removeClass("loading");}',
                                            'data' => array(
                                                    'task_tasker_id' => $data->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                                        'alert_id' => $data->{Globals::FLD_NAME_ALERT_ID}, 
                                                    ),
                                            'dataType'=>'json',
                                            'type' => 'POST', 
                                            'success' => 'js:function(data){alert('.$data->{Globals::FLD_NAME_ALERT_ID}.')
                                                            if(data.status==="success")
                                                            {
        //                                                            jQuery("#proposalReject'.$data->{Globals::FLD_NAME_TASK_TASKER_ID}.'").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'");
                                                                    jQuery("#proposal_status").html("'.CHtml::encode(Yii::t('poster_taskdetail', 'lbl_rejected')).'");
                                                                    jQuery("#user_noti'.$data->{Globals::FLD_NAME_ALERT_ID}.'").html("");
                                                            }
                                                            else
                                                            {
                                                                alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                            }
                                        }'), 
                                            array('id' => 'proposalReject'.$data->{Globals::FLD_NAME_TASK_TASKER_ID},
                                            ));
        ?>
        </div>
        <?php
        }
}
?>

</div>