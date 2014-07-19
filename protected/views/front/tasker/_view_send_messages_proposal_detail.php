<div  id="write-message"  class="tasker_row1 sky-form">
<?php
$toUserId = empty($toUserId) ? '' : $toUserId;
$userid  = Yii::app()->user->id;

$img = CommonUtility::getThumbnailMediaURI($userid,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);
            
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
   // 'id' => 'sendmessage-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>
    
    
<div class="writeheadbg"><img src="<?php echo CommonUtility::getPublicImageUri('write-bg.jpg') ?>"></div>
<div class="writemess_cont">
<div class="write_thumb"><img src="<?php echo $img ?>"></div>
<div class="write_area ">
    <div id="msgToUser">
        
        
    </div>
    <?php 
    echo $form->textArea($message, Globals::FLD_NAME_BODY, array('class' => '', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => '', ));  ?>
    <?php echo $form->error($message, Globals::FLD_NAME_BODY,array('class' => 'invalid')); ?>
    
    <?php 
            
        echo $form->hiddenField($message, Globals::FLD_NAME_MSG_TYPE , array( 'value' => Globals::DEFAULT_VAL_MSG_TYPR_PROPOSAL ));
        echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
        echo $form->hiddenField($message, Globals::FLD_NAME_SUBJECT , array( 'value' => Globals::DEFAULT_VAL_MSG_SUBJECT_PROPOSAL ) );
        if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
        {
           // echo $form->hiddenField($message, Globals::FLD_NAME_IS_PUBLIC , array( 'value' => Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE ));   
            echo $form->hiddenField($message, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => $toUserId));
             echo CHtml::hiddenField('replyMsg', '1' ,array( 'id' => 'replyMsg')); 
            
        }
        else 
        {
            echo $form->hiddenField($message, Globals::FLD_NAME_IS_PUBLIC , array( 'value' => Globals::DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE)); 
            echo $form->hiddenField($message, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID}));
        }
       echo $form->hiddenField($task, Globals::FLD_NAME_CREATER_USER_ID , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID}));
        
    ?>
    
   </div>
<div class="write_but">
<div class="messagesend">
    <div id="isPublicChk" >
    
    <?php
    if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
    {
        ?>
        <label>
        Make Public
        </label>
        <?php
        echo $form->checkBox($message,Globals::FLD_NAME_IS_PUBLIC  );
    }
    ?>
    </div>
<?php 
$ifPoster = '';
if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
{
    $ifPoster = '   //$("#Inbox_to_user_ids").val("");
                    //$("#replyMsg").val("");
                    //$("#Inbox_is_public").val("1");
                    
                    //$("#msgToUser").html(""); 
                    
//        $( "#isPublicChk" ).css("visibility" , "hidden");
//        $("#Inbox_is_public").prop("checked",true);
            
                ';
    
}
$successUpdate = '
if(data.status==="success")
{
    $("#loadAllMessages").prepend(data.newMsg);
     $("#Inbox_body").val("");
     
     
    '.$ifPoster.'
    
}
else
{
    var msg = "";
    $.each(data, function(key, val)
    {
        $("#"+key+"_em_").text(val);
        //$("#"+key).addClass("state-error");
        //$("#"+key).parent().addClass("state-error");
        $("#"+key+"_em_").show();
    });
}
';
CommonUtility::getAjaxSubmitButton('Send',Yii::app()->createUrl('inbox/messagesave'), 'btn-u rounded btn-u-sea', 'sendMessage', $successUpdate);
?>
    <!--<input id="sendMessage" class="btn-u rounded btn-u-sea" onclick="return sendMessage('sendMessage')" type="button" value="Send" name="yt1">-->
  </div></div>
</div>
<?php $this->endWidget(); ?>
</div>