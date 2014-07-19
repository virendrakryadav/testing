
<script>
    function setTaskHiring(task_id)
    {
        $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('poster/sethiringoff') ?>',
            data: { task_id: task_id },
            type: "POST",
            dataType : "json",
           
            error: function () 
            {
               alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
            },
            success: function (data) 
            {
               if(data.status==='success')
                {
                    $('#Task_hiring_closed_switch').addClass('deactivate');
                    $('#Task_hiring_closed').prop('disabled' , true);
                    $('#hiring_closed_switch').addClass('deactivate');
                    $('#hiring_closed').prop('disabled' , true);
                  //  window.location.href = '<?php echo  CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>';
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
    }
    function hireDoerClosePopup()
    {
        jQuery("#doerHireMePopup").fadeOut("slow"); 
        jQuery("#overlaytaskDetail").fadeOut("slow"); 
    }
    function makeMsgPublic(msgId)
    {
        jConfirm('Are you sure you want to mark this message public?', 'Mark message public', function(r) 
        {
                if( r == true)
                {
                    $.ajax(
                    {
                        url: '<?php echo Yii::app()->createUrl('inbox/makemsgpublic') ?>',
                        data: { msg_id: msgId },
                        type: "POST",
                        dataType : "json",

                        error: function () 
                        {
                           alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                        },
                        success: function (data) 
                        {
                           if(data.status==='success')
                            {
                                $('#publicMsgId'+msgId).attr('onclick' , 'return false');
                                $('#publicMsgId'+msgId+' a').html('Marked as Public');
                            }
                            else
                            {
                                alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                            }

                        }
                    });

                }
                else
                {
                    return false;
                }

            });
        
       
    }
     function markUnread(msgId , userId)
    {
        $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('inbox/makemsgunread') ?>',
            data: { msg_id: msgId,user_id:userId},
            type: "POST",
            dataType : "json",
           
            error: function () 
            {
               alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
            },
            success: function (data) 
            {
               if(data.status==='success')
                {
                     $('#markRead'+msgId).html('<a href="javascript:void(0)" onclick="markRead( '+msgId+' ,'+userId+' )" >Mark Read</a>');
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
    }
    
    
    function deleteFileProjectLive(file ,task_id , tasker_id)
    {
        jConfirm('Are you sure you want to delete this file?', 'Confirm delete file', function(r) 
        {
                if( r == true)
                {
                    $.ajax(
                    {
                        url: '<?php echo Yii::app()->createUrl('poster/deleteuploadedfile') ?>',
                        data: { file: file,task_id:task_id,tasker_id:tasker_id},
                        type: "GET",
                        dataType : "json",

                        error: function () 
                        {
                           alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                        },
                        success: function (data) 
                        {
                           if(data.status==='success')
                            {
                                var msgSuccess = '<p><i class=\"fa fa-hand-o-right\"></i> File deleted successfully.</p>';


                                alertErrorMessage(msgSuccess, 'validationSuccessMsg');
                                selectUserFiles();
                                getTaskerDetails();
                            }
                            else
                            {
                                alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                            }

                        }
                    });

                }
                else
                {
                    return false;
                }

            });
            
        
    }
    
     function markRead(msgId , userId)
    {
        $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('inbox/makemsgread') ?>',
            data: { msg_id: msgId,user_id:userId},
            type: "POST",
            dataType : "json",
           
            error: function () 
            {
               alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
            },
            success: function (data) 
            {
               if(data.status==='success')
                {
                    $('#markRead'+msgId).html('<a href="javascript:void(0)" onclick="markUnread( '+msgId+' ,'+userId+' )" >Mark Unread</a>');
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
    }
    function setJobType(task_id , payment_mode)
    {
        if(payment_mode == '<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY ?>')
        {
            $.ajax(
            {
                url: '<?php echo Yii::app()->createUrl('poster/switchjobtypepopup') ?>',
                data: { task_id: task_id,payment_mode:payment_mode},
                type: "POST",
                dataType : "json",

                error: function () 
                {
                   alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                },
                success: function (data) 
                {
                    if(data.status==='success')
                    {
                        loadpopup(data.html, '' , 'switch-job-type-hourly');  
                    }
                    else
                    {
                        alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                    }

                }
            });
        }
        else
        {
            alert('You can not switch houry to fixed');
        }
        return false;
    }
    function postQuestion()
    {
        loadpopup($('#postQuestionsTaskDetail').html(), '' , 'post-question-task-detail') ;
    }    
    
    function viewMessage()
    
    {
        //alert();
        $('#taskDetailHeader ul li a').removeClass('active');
        $('#viewMessageTitle').addClass('active');
        $('#viewDescription').hide();
        $('#viewmasseges').show();
        $('#viewFiles').hide();
        $('#viewProposals').hide();
        $('#proposalsFilters').hide();
        
        var user_id = $('#currentaskers').val();
        selectUserMessage(user_id);
        
    }
    function viewDescription()
    {
        $('#taskDetailHeader ul li a').removeClass('active');
        $('#viewDescriptionTitle').addClass('active');
        $('#viewDescription').show();
        $('#viewmasseges').hide();
        $('#viewFiles').hide();
        $('#viewProposals').hide();
        $('#proposalsFilters').hide();
        
    }
    function viewFiles()
    {
        $('#taskDetailHeader ul li a').removeClass('active');
        $('#viewFilesTitle a').addClass('active');
        $('#viewDescription').hide();
        $('#viewmasseges').hide();
        $('#viewFiles').show();
        $('#proposalsFilters').hide();
        $('#viewProposals').hide();
        selectUserFiles();
        
    }
    function viewProposals()
    {
        $('#taskDetailHeader ul li a').removeClass('active');
        $('#viewProposalsTitle').addClass('active');
        $('#viewDescription').hide();
        $('#viewmasseges').hide();
        $('#viewFiles').hide();
        $('#proposalsFilters').show();
        $('#viewProposals').show();
    }
    
    function replyMessage( toUserId , taskId , userName , userImg)
    {
        var toUserHtml = '<label>Reply to :</label><a href="#">'+userName+'</a>';
        $('#msgToUser').html(toUserHtml);
        $('#Inbox_to_user_ids').val(toUserId);
        //$('#Inbox_is_public').val('<?php echo Globals::DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE ?>');
        $( "#viewDescriptionTitle" ).scrollTop( 300 );
        $('#replyMsg').val(1);
        $( "#Inbox_body" ).focus();
        $( "#isPublicChk" ).css('visibility' , 'visible');
        $('#Inbox_is_public').prop('checked',false);
        
        
//        $.ajax(
//        {
//            url: '<?php echo Yii::app()->createUrl('inbox/loadsendmessageform') ?>',
//            data: { toUserId: toUserId , taskId : taskId},
//            type: "POST",
//            dataType : "json",
//           
//            error: function () 
//            {
//               alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
//            },
//            success: function (data) 
//            {
//               if(data.status==='success')
//                {
//                    loadpopup(data.html, '' , 'post-message-reply-popup');  
//                }
//                else
//                {
//                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
//                }
//                
//            }
//        });
//        return false;
        
        
        
    }
    function sendMessage(id)
    {
        alert();
//        jQuery.ajax({
//            'type':'POST',
//            'dataType':'json',
//            'success':function(data)
//            {
//                $("#"+id).removeClass("loading");
//                if(data.status==="success")
//                {
//                    $("#loadAllProposals").prepend(data.newMsg);
//                }
//                else
//                {
//                    var msg = "";
//                    $.each(data, function(key, val)
//                    {
//                        $('#'+id).parents("form #"+key+"_em_").text(val);
//                        $('#'+id).parents("form #"+key).addClass("state-error");
//                        $('#'+id).parents("form #"+key).parent().addClass("state-error");
//                        $('#'+id).parents("form #"+key+"_em_").show();
//                    });
//                }
//                    
//            },'beforeSend':function(){   
//                $("#"+id).addClass("loading");
//                $(".help-block").css("display", "none");
//                },
//            'url':'<?php echo Yii::app()->createUrl('inbox/messagesave') ?>',
//            'cache':false,
//            'data':jQuery('#'+id).parents("form").serialize()});
//            return false;
    }
    function currentUserParts(user_id)
    {
        if(user_id)
        {
            <?php if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
            {
            ?>
            $('#Inbox_to_user_ids').val(user_id);
            <?php
            }
            ?>
            $('#replyMsg').val(1);
            $('#currentaskers2').val(user_id);
            $( "#isPublicChk" ).css('visibility' , 'visible');
            $('#Inbox_is_public').prop('checked',false);
            
            $( "#doerTermsPayment" ).css('display' , 'block');
            $( "#doerJobType" ).css('display' , 'block');
            $( "#viewFilesTitle" ).css('display' , 'block');
            $( "#tabStractureForPoster" ).addClass('vtab3');
            $( "#tabStractureForPoster" ).removeClass('vtab');
            getTaskerDetails()
            
        }
        else
        {
            $('#Inbox_to_user_ids').val("");
            $('#replyMsg').val("");
            
            $( "#isPublicChk" ).css('visibility' , 'hidden');
            $('#Inbox_is_public').prop('checked',true);
            $('#projectDetailUpperBar').removeClass('project-cont-d');
            $( "#projectDetailUpperUserInfo" ).css('display' , 'none');
            $( "#doerTermsPayment" ).css('display' , 'none');
            $( "#doerJobType" ).css('display' , 'none');
            $( "#viewFilesTitle" ).css('display' , 'none');
            $( "#tabStractureForPoster" ).removeClass('vtab3');
            $( "#tabStractureForPoster" ).addClass('vtab');
        }
    }
    function getTaskerDetails()
    {
        var user_id = $('#currentaskers').val();
        $.ajax(
            {
                url: '<?php echo Yii::app()->createUrl('poster/gettaskerdetails') ?>',
                data: { tasker_id : user_id  , task_id : '<?php echo $task->{Globals::FLD_NAME_TASK_ID} ?>'},
                type: "POST",
                dataType : "json",

                error: function () 
                {
                    jAlert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>', 'Oops!!! an error.');
                  
                },
                success: function (data) 
                {
                   if(data.status==='success')
                    {
                        $( "#doerImage" ).attr('src' , data.image);
                        $( "#doerName" ).attr('href' , data.taskerprofile);
                        
                        $( "#doerName" ).html( data.firstname);
                        $( "#spaceQuotaUsed" ).html( data.spacequota);
                        $( "#uploadProposalAttachments_totalFileSizeLimit" ).val( data.spacequotainbites );
                        
                        $( "#spaceQuotaUsedBar" ).css('width' , data.spacequotabar+'%' );
                        $('#projectDetailUpperBar').addClass('project-cont-d');
                        $( "#projectDetailUpperUserInfo" ).css('display' , 'block');
                    }
                    else
                    {
                        alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                    }

                }
            });
    }
    function selectCurrentUser(user_id)
    {
        ///alert(user_id);
        
       // $.fn.yiiListView.update('fileslist', {data: data});
        if($('#currentaskers').val() == '')
        {
            viewDescription();
        }
        currentUserParts(user_id);
        selectUserMessage(user_id);
        selectUserFiles();
        //selectUserFiles();
        
    }
    function selectUserMessage()
    {
        //alert(user_id);
        var data = $('#currentaskers').serialize();  
        $.fn.yiiListView.update('loadAllMessages', {data: data});
        
    }
    function selectUserFiles()
    {
        //alert(user_id);
        var data = $('#currentaskers').serialize();    
       // $.fn.yiiListView.update('loadAllMessages', {data: data});
        $.fn.yiiGridView.update('files-grid-project-live', {data: data});
       // currentUserParts(user_id);
        $('#currentaskers2').val($('#currentaskers').val());
        
    }
//    function selectCurrentUser(user_id)
//    {
//        ///alert(user_id);
//        var data = $('#currentaskers').serialize();    
//        $.fn.yiiListView.update('loadAllMessages', {data: data});
//        currentUserParts(user_id);
//        
//    }
    
    function modifyTermsPayment(task_id)
    {
        var user_id = $('#currentaskers').val();
       // alert(user_id);
       
            $.ajax(
            {
                url: '<?php echo Yii::app()->createUrl('poster/modifytermsandpayment') ?>',
                data: { task_id: task_id , user_id : user_id},
                type: "POST",
                dataType : "json",

                error: function () 
                {
                   alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                },
                success: function (data) 
                {
                    if(data.status==='success')
                    {
                        loadpopup(data.html, '' , 'poster-detail-modify-terms-payment');  
                    }
                    else
                    {
                        alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                    }

                }
            });
        
        return false;
    }
    function displayAddFilesController()
    {
         $("#taskDetailAddFiles").show();
    }
    function removeImage(divId , uploaderId)
    {
        var usedSize = $('#'+uploaderId+'_totalFileSizeUsed').val();
        var totalSize = $('#'+uploaderId+'_totalFileSize').val();
        var fileSize =  $('#'+divId+'_size').val();
            usedSize =  parseInt(usedSize) - parseInt(fileSize);
             $('#'+uploaderId+'_totalFileSizeUsed').val(usedSize);


        $('#'+divId).remove();
        var vals = $('.totalfilecountuse').map(function(){
               return $(this).val();
            }).get();
            //alert(vals.length);
            if(vals.length <= 0)
            {
                $("#fileUploadBtn").hide();
                
            }

    }
    
    function ischeckedFiles()
    {
             var atLeastOneIsChecked = $('input[name=\"file[]\"]:checked').length > 0;

            if (!atLeastOneIsChecked)
            {
                        var msgError  = '<h4 class="error-h4">Oops!! You got an error!</h4><p><i class=\"fa fa-hand-o-right\"></i> Please select atleast one file.</p>';
                        alertErrorMessage(msgError, 'validationErrorMsg');
                    
                   // alert('<?php echo Yii::t('commonutlity','select_atleast_one_rec_msg_text') ?>');
                    $('#filesAction').val('');
                    return false;
            }
            else
            {
                    return true;
            }
    }
                    
    
//       $('.second-sidebar').appear(function() {
//            alert('I am here!');
//        });
        
        $('.second-sidebar').on('appear', function(event, $all_appeared_elements) {
      // this element is now inside browser viewport
       alert('I am here!');
    });
  
  
 $(function() {
 
//  $(document.body).on('appear', '#appearDiv', function(e, $affected) {
//    // this code is executed for each appeared element
//    alert();
//  });
$('#appearDiv').waypoint(function() {
   alert('The element is appeared on the screen.');
});
  
});
$(".categoryScroll").jScrollPane({
		showArrows: false,
		autoReinitialise: true
	});


</script>
<style>

.categoryScroll {
    height: 260px;
}
</style>
<?php
//$this->widget('ext.EJsScroll.EJsScroll',
//    array(
//        'selector' => '.categoryScroll',
//        'showArrowsBar'=>false
//    )
//);
//?>
<?php echo  CHtml::hiddenField('pageleavevalidation', '' , array('id' => 'pageleavevalidation' )) ?>
<?php echo  CHtml::hiddenField('pageleavevalidationonsubmit', '' , array('id' => 'pageleavevalidationonsubmit' )) ?>