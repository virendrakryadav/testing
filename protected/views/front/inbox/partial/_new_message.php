<div class="inboxreply_cont">
    <div class="reply_row1">
        <a id="replyBtn" onclick="dispalyReplyDiv();" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_reply'))?></a>
        <!--<a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_archive'))?></a>-->
        <a id="deleteBtn" onclick="showDeleteChkBok()" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_delete'))?></a>
        <!--<a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mrak_unread'))?></a>-->
        <!--<a onclick="newMessage();" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('inbox_index', 'New message'))?></a>-->
    </div>
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
     'id' => 'sendmessage-form',
     'enableAjaxValidation' => false,
     'enableClientValidation' => true,
     'clientOptions' => array(
        // 'validateOnSubmit' => true,
     //'validateOnChange' => true,
     //'validateOnType' => true,
     ),
         ));
    ?>
    <div  class="reply_row2" id="replyDiv" style="display: none">
        <div id="replyTo" style="display: none" class="reply_col1-noover">
            <?php 

//                        $userDetail = array();
//                        if($currentTaskList)
//                        {
//                            if($currentTaskList->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
//                            {
//                                $taskUsers =  TaskTasker::getAllProposalsOfTask($currentTask);
//                                if($taskUsers)
//                                {
//                                    foreach ( $taskUsers as $taskUser )
//                                    {
//                                        $userDetail[$taskUser->{Globals::FLD_NAME_TASKER_ID}] = CommonUtility::getUserFullName($taskUser->{Globals::FLD_NAME_TASKER_ID});
//                                    }
//                                }
//                            }
//                            else
//                            {
//                                $userDetail[$currentTaskList->{Globals::FLD_NAME_CREATER_USER_ID}] = CommonUtility::getUserFullName($currentTaskList->{Globals::FLD_NAME_CREATER_USER_ID});
//                            }
//                        }



            $this->renderPartial('partial/_task_users', array( 'userDetail' => $retatedUsers  ));?>
        </div>
        <div class="reply_col1">
            <?php //echo $form->error($inbox, Globals::FLD_NAME_TO_USER_IDS,array('class' => 'invalid')); ?>
        <?php 
                echo $form->textArea($inbox, Globals::FLD_NAME_BODY, array('class' => '', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => '','style' =>'resize:none' ));  ?>
        <?php //echo $form->error($inbox, Globals::FLD_NAME_BODY,array('class' => 'invalid')); ?>
        </div>
<!--                        <div class="reply_row3 controls fileupload-messages" id="loadAttachment"  style="display : none;">
            <button class="close2" data-dismiss="alert"  type="button">×</button>
           <?php
//                           $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
//                           $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
//                           CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
           ?>
               <?php //echo $form->error($task,'image'); ?>
           <div id="takeImagesPortfolio" class="upload-img2" style="display: none"></div>
           <div class="clr"></div>
    </div>  -->

        <div class="reply_row3">
            <div class="reply_col2"><a class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_attach_file'));?></a></div>
            <div id="enableSendMsgBtn" style="display: none" class="reply_col3">
                <?php 
                        echo $form->hiddenField($inbox, Globals::FLD_NAME_MSG_TYPE , array( 'value' => Globals::DEFAULT_VAL_MSG_TYPR_PROPOSAL ));
                        echo $form->hiddenField($currentTaskList, Globals::FLD_NAME_TASK_ID);
                        echo $form->hiddenField($inbox, Globals::FLD_NAME_SUBJECT , array( 'value' => Globals::DEFAULT_VAL_MSG_SUBJECT_PROPOSAL ) );
                        echo CHtml::hiddenField('replyMsg', '1' ,array( 'id' => 'replyMsg')); 
                        echo CHtml::hiddenField('newMessage', '0' ,array( 'id' => 'newMessage')); 

                        echo $form->hiddenField($inbox, Globals::FLD_NAME_IS_PUBLIC , array( 'value' => Globals::DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE)); 
                        echo $form->hiddenField($currentTaskList, Globals::FLD_NAME_CREATER_USER_ID , array( 'value' => $currentTaskList->{Globals::FLD_NAME_CREATER_USER_ID}));
                        echo $form->hiddenField($inbox, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => $fromUserId));
            
$ifPoster = '';

$successUpdate = '
if(data.status==="success")
{
    $("#messagesList").prepend(data.newMsg);
     $("#Inbox_body").val("");
    '.$ifPoster.'
    $("#takeImagesPortfolio").html("");
    $("#loadAttachment").hide();
    $("#replyTo").hide();
    $("#uploadPortfolioImage_totalFileSizeUsed").val(0);
    $(\'#to_user_ids\').val(\'\');
    $(\'#to_user_ids\').trigger("chosen:updated");
      showSendButton();                                           
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
CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('inbox_index', 'Send')),Yii::app()->createUrl('inbox/messagesaveinmsgbox'), 'btn-u rounded btn-u-sea', 'sendMessage', $successUpdate);
?>
                                
                            </div> 
                            <div id="disableSendMsgBtn" class="reply_col3">
                            <input  class="btn-u rounded servive-block-yellow" style="display: block" type="button" value="Send">
                            </div>
            </div>
                     <div class="reply_row3 controls" id="loadAttachment"  style="display : none;">
                           <?php
                           $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                           $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                           CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                           ?>
                               <?php //echo $form->error($task,'image'); ?>
                           <div id="takeImagesPortfolio" class="upload-img2" style="display: none"></div>
                    </div>  
            </div>

    <div class="reply_col1" id="deleteRow" style="display: none">
        <input class="btn-u btn-u-lg rounded btn-u-red push" onclick="hideDeleteChkBok()" type="button" value="Cancel" >
        
        <?php 
                $successUpdate = '
                                    if(data.status==="success")
                                    {
                                        hideDeleteChkBok();
                                         $.fn.yiiListView.update("messagesList");
                                    }
                                    else
                                    {
                                        var msg = "";
                                        msg += "<p><i class=\"fa fa-hand-o-right\"></i> Please select atleast one message to delete.</p>";
                                          
                                        $("html, body").animate({ scrollTop: 0 }, "slow");
                                         alertErrorMessage(msg , "validationErrorMsg");
                                      
                                    }
                                    ';
                
                                    CommonUtility::getAjaxSubmitButton('Delete',Yii::app()->createUrl('inbox/deletemessages'), 'btn-u btn-u-lg rounded btn-u-sea push', 'deleteusermessages', $successUpdate);
                                                ?>
</div>
<div id="messagesListOfTask" class="replymess">
                    
                    <?php
                  
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'messagesList',
                        'dataProvider' => $taskMessages,
                     
                        'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">No messages.</div></div>',
                        'emptyTagName' => 'div class="box2"',
                        //'emptyTagName' => 'div class="box2"',
                        //'enableHistory' => true,
                        'itemView' => 'partial/_task_messages_list',
                        'template' => '{items}{pager}',
                        'afterAjaxUpdate' => "function(id, data) {
                                    $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                    jQuery.ias({
                                          'history':false,
                                          'triggerPageTreshold':0,
                                          'trigger':'Show more',
                                          'container':'#messagesList.list-view',
                                          'item':'.replymess1',
                                          'pagination':'#messagesList .pager',
                                          'next':'#messagesList .next:not(.disabled):not(.hidden) a',
                                          'loader':'Loading...'});              

                        }",
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.replymess1',
                        'itemsSelector' => '.list-view',
                        'listViewId' => 'messagesList',
                        'header' => '',
                        'loaderText' => 'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 0, 'trigger' => 'Show more'),
                    ),
           
                    ));
                  
                ?>
                </div>

            <!--reply ends here-->           
        </div>
<?php $this->endWidget(); ?>