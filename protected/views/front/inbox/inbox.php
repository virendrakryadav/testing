<?php
$currentPageUrl = Yii::app()->createUrl('inbox/index');
?>

<script text="text/javascript">
  $(function(){
    $(".reply_col2").click(function(){
         
      $("#loadAttachment").toggle();
     // e.preventDefault();
    });
    $(".inbox_index #Inbox_body").keyup(function()
    {
        showSendButton();
    });
  });
  function showSendButton()
  {
       var newMsg = $('#newMessage').val();
        var validation = 0;
        if(newMsg == 1)
        {
            if($('#to_user_ids').val() && $("#Inbox_body").val())
            {
                validation = 1;
            }
        }
        else
        {
           // alert($("#Inbox_body").val());
            if($("#Inbox_body").val())
            {
                validation = 1;
            }
            else
            {
                validation = 0;
            }
            //alert(validation);
        }
        if(validation == 1)
        {
            $("#enableSendMsgBtn").show();
            $("#disableSendMsgBtn").hide();
        }
        else
        {
            $("#enableSendMsgBtn").hide();
            $("#disableSendMsgBtn").show();
        }
  }
</script>

<script>
    $(document).ready(function() {
    $('#selectall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
    
    var windWidth = $(window).height();
    var width = $(window).width();
        
        if(width > 1023)
        {
            $("#listScrollTask").height(windWidth*.77);
            $("#listScrollTask").jScrollPane({
		showArrows: false,
		autoReinitialise: true
                }).bind(
                            'mousewheel',
                            function(e)
                            {
                                e.preventDefault();
                            }
                        );
                
           msgListHeight();
            $("#messagesListOfTask").jScrollPane({
		showArrows: false,
		autoReinitialise: true
                }).bind(
                            'mousewheel',
                            function(e)
                            {
                                e.preventDefault();
                            }
                        );
        }
        else
        {
            $("#listScrollTask").height('auto');
        }
        
  
//    $("#messagesListOfTask").jScrollPane({
//		showArrows: false,
//		autoReinitialise: true
//    });
   
});
function selectTaskForMessages(taskId , fromUserIds , toUserIds)
{
    $('#messagesTask .inbox_row1').removeClass('active');
    $('#messagesTask #tm_'+taskId+toUserIds+fromUserIds).addClass('active');
    $('#currentTask').val(taskId);
    $('#currentToUserIds').val(toUserIds);
    
    $('#Task_task_id').val(taskId);
    $('#Inbox_to_user_ids').val(fromUserIds);
    
    
    $("#replyTo").hide();
    $("#replyDiv").hide();
    $('#to_user_ids').val('');
    $('#to_user_ids').trigger("chosen:updated");
    $("#Inbox_body").val('');
    $('#newMessage').val(0);
    $('#replyBtn').show();
    $('#deleteBtn').show();
    showSendButton();
    hideDeleteChkBok();
    msgListHeight();
    var taskState = $('#taskStateValue').val();
    var type = $('#messageTypeValue').val();
     if(taskState != '')
    {
        //taskState = '/<?php echo Globals::FLD_NAME_TASK_STATE ?>/'+taskState;
    }
    if(type != '')
    {
       // type = '/<?php echo Globals::FLD_NAME_MSG_TYPE ?>/'+type;
    }

    var data = '<?php echo Globals::FLD_NAME_TO_USER_IDS ?>='+toUserIds+'&<?php echo Globals::FLD_NAME_FROM_USER_ID ?>='+fromUserIds+'&<?php echo Globals::FLD_NAME_TASK ?>='+taskId+taskState+type;  
    
      var url = '<?php echo $currentPageUrl ?>?'+data;
//        var params = $.param(data);
//       // alert(params);
//       // url = url.substr(0, url.indexOf('?'));
//        
          //  window.History.pushState('messagesList', document.title,url);
    $.fn.yiiListView.update('messagesList', {data: data});
    //window.History.pushState(null, document.title,$.param.querystring(url, data));
    //setCurrentTaskUsers(taskId);
}
function setCurrentTaskUsers(task_id)
{
    $.ajax(
    {
        url: '<?php echo Yii::app()->createUrl('inbox/taskusers') ?>',
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
                $('#replyTo').html(data.html);
                $('#Task_creator_user_id').val(data.task_creator_user_id);
                
                
            }
            else
            {
                alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
            }
        }
    });
    return false;
} 
function removeActiveMenu(id)
{
   // alert();
    if(id)
    $('#'+id + ' ul li a').removeClass('active');
    else
    $('.active').removeClass('active');
    
} 
function dispalyReplyDiv()
{
        $("#Inbox_body").val('');
        $("#replyDiv").show();
          msgListHeight('true');
        
     
     
      
}
function msgListHeight(small)
{
      var windWidth = $(window).height();
    if(small)
    {
       
         $("#messagesListOfTask").height(windWidth*.48);
    }
    else
    {
         $("#messagesListOfTask").height(windWidth*.73);
    }
    
}
function newMessage()
{
    $("#replyTo").show();
    $("#replyDiv").show();
    //$("#Inbox_to_user_ids").val('');
    $('#newMessage').val(1);
    $('#replyBtn').hide();
    $('#deleteBtn').hide();
    showSendButton();
    
}
function showDeleteChkBok()
{
    $('.msgchkbox').show();
    $('#deleteRow').show();
}
function hideDeleteChkBok()
{
    $('.msgchkbox').hide();
    $('#deleteRow').hide();
}
</script>

<?php
$state = (isset($_GET[Globals::FLD_NAME_TASK_STATE])) ? $_GET[Globals::FLD_NAME_TASK_STATE] : '';
$msgType = (isset($_GET[Globals::FLD_NAME_MSG_TYPE])) ? $_GET[Globals::FLD_NAME_MSG_TYPE] : '';

$taskType = (isset($_GET["taskType"])) ? $_GET["taskType"] : Globals::DEFAULT_VAL_TASK_TYPE ;
Yii::app()->clientScript->registerScript('searchMytasks', "
                            
    var ajaxUpdateTimeout;
    var ajaxRequest;
    var val;
    var hasToRun = 0;

function reloadFilterGrid()
{ 
    var taskState = $('#taskStateValue').val();
    //var type = $('#messageTypeValue').val();
    if(taskState != '')
    {
        taskState = '/".Globals::FLD_NAME_TASK_STATE."/'+taskState;
    }
//    if(type != '')
//    {
//        type = '/".Globals::FLD_NAME_MSG_TYPE."/'+type;
//    }
    var taskId = $('#currentTask').val();
    if(taskId != '')
    {
        taskId = '/".Globals::FLD_NAME_TASK."/'+taskId;
    }
    var fromUserIds = $('#Inbox_to_user_ids').val();
    var toUserIds = $('#currentToUserIds').val();
    if(fromUserIds != '' && toUserIds != '')
    {
        fromUserIds = '/".Globals::FLD_NAME_FROM_USER_ID."/'+fromUserIds;
        toUserIds = '/".Globals::FLD_NAME_TO_USER_IDS."/'+toUserIds;
    }
    else
    {
        toUserIds = '';
        fromUserIds = '';
    }
   
    var data = toUserIds+fromUserIds+taskId+taskState;  
    var url = '".$currentPageUrl."'+data;
 
    window.History.pushState(null, document.title,url);
    //return false; 
}
function reloadFilterGridMessages()
{ 
    
    var fromUserIds = $('#Inbox_to_user_ids').val();
    var toUserIds = $('#currentToUserIds').val();
    var type = $('#messageTypeValue').val();
    
        type = '&".Globals::FLD_NAME_MSG_TYPE."='+type;
    
    var taskId = $('#currentTask').val();
//    if(taskId != '')
//    {
//        taskId = '&".Globals::FLD_NAME_TASK."='+taskId;
//    }
    var data = '". Globals::FLD_NAME_TO_USER_IDS ."='+toUserIds+'&".Globals::FLD_NAME_FROM_USER_ID ."='+fromUserIds+'&".Globals::FLD_NAME_TASK."='+taskId+type;  
    var url = '".$currentPageUrl."?'+data;
    $.fn.yiiListView.update('messagesList', {data: data});
}


$('body').delegate('#taskname','keyup',function()
{

var timer = null;
    clearTimeout(timer);

timer = setTimeout(function(){
      
    var taskState = $('#taskStateValue').val();

    var title = $.trim($(\"#taskname\").val());
    if(taskState != '')
    {
        taskState = '/".Globals::FLD_NAME_TASK_STATE."/'+taskState;
    }
  
    if(title != '')
    {
        title = '/".Globals::FLD_NAME_TITLE."/'+title;
    }
  
    var fromUserIds = $('#Inbox_to_user_ids').val();
    var toUserIds = $('#currentToUserIds').val();
    if(fromUserIds != '' && toUserIds != '')
    {
        fromUserIds = '/".Globals::FLD_NAME_FROM_USER_ID."/'+fromUserIds;
        toUserIds = '/".Globals::FLD_NAME_TO_USER_IDS."/'+toUserIds;
    }
    else
    {
        toUserIds = '';
        fromUserIds = '';
    }
   
    var data = toUserIds+fromUserIds+taskState+title;  
    var url = '".$currentPageUrl."'+data;
 
    window.History.pushState(null, document.title,url);
        
   }, 1000);
});

    $('a#loadmytasksAll').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_NULL."'); removeActiveMenu('filterMsgTasks');activeMenu(this);reloadFilterGrid(); });
    $('a#loadmytasksOpen').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_OPEN."'); removeActiveMenu('filterMsgTasks');activeMenu(this);reloadFilterGrid(); });
    $('a#loadmytasksClose').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_FINISHED."'); removeActiveMenu('filterMsgTasks');activeMenu(this);reloadFilterGrid(); });
    $('a#loadmytasksAwarded').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE."'); removeActiveMenu('filterMsgTasks');activeMenu(this);reloadFilterGrid(); });
    $('a#loadmytasksCancel').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_CANCELED."'); removeActiveMenu('filterMsgTasks');activeMenu(this);reloadFilterGrid(); });


//for messages
    $('a#messagesTypeAll').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_NULL."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeMessages').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_MESSAGES."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeProposal').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_PROPOSAL."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypePayment').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_PAYMENT."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeTerms').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_TERMS."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeInvites').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_INVITES."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeFeedback').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_FEEDBACK."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
    $('a#messagesTypeDrafts').click(function(){ $('#messageTypeValue').val('".Globals::DEFAULT_VAL_MSG_TYPR_DRAFTS."'); removeActiveMenu('filterMsgOnly');activeMenu(this);reloadFilterGridMessages(); });
                                                                                                                                                            
    "
);
?>


<div class="container content">
<!--Left side bar start here-->
    <div class="col-md-3 leftbar-fix">
        <!--erandoo start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--erandoo end here-->
        <div id="leftSideBarScroll">
        <!--Top search start here-->
        <div class="left_search margin-bottom-30">
            <div class="left_searchcol1">
            <img src="<?php  echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>" />
            </div>
            <div class="left_searchcol2"><input name="taskname" type="text" placeholder="<?php echo CHtml::encode(Yii::t('inbox_index', 'txt_show_all'))?>" id="taskname"/></div>
            <div class="left_searchcol3">
            <img src="<?php  echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>" />
            </div>
        </div>
        <!--Top search Ends here-->
  
        <!--Smart search start here-->
        <div class="margin-bottom-30">
            <div id="filterMsgTasks" class="notifi-set">
                <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
                <?php echo CHtml::hiddenField( Globals::FLD_NAME_TASK_STATE , '', array('id' => 'taskStateValue')); ?>
                <?php echo CHtml::hiddenField( 'taskType' , $taskType, array('id' => 'taskType')); ?>        
                 <?php
                        $all = ($state == Globals::DEFAULT_VAL_NULL) ? 'active' : '' ;
                        $statusOpen = ($state == Globals::DEFAULT_VAL_TASK_STATUS_OPEN) ? 'active' : '' ;
                        $statusFinished = ($state == Globals::DEFAULT_VAL_TASK_STATUS_FINISHED) ? 'active' : '' ;
                        $statusAwarded = ($state == Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE) ? 'active' : '' ;
                        $statusCancel = ($state == Globals::DEFAULT_VAL_TASK_STATUS_CANCELED) ? 'active' : '' ;
                        $statusArchive = '' ;
                                    
                    ?>
                    <ul>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_all_messages')), 'javascript:void(0)', array('id' => 'loadmytasksAll',  'class' => $all)); ?></li>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_current')), 'javascript:void(0)', array('id' => 'loadmytasksAwarded' , 'class' => $statusAwarded)); ?></li>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_open')), 'javascript:void(0)', array('id' => 'loadmytasksOpen' , 'class' => $statusOpen)); ?></li>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_close')), 'javascript:void(0)', array('id' => 'loadmytasksClose' , 'class' => $statusFinished)); ?></li>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_cancel')), 'javascript:void(0)', array('id' => 'loadmytasksCancel' , 'class' => $statusCancel)); ?></li>
                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_archived')), 'javascript:void(0)', array('id' => 'loadmytasksArchived' , 'class' => $statusArchive)); ?></li>
                    </ul>
            </div>
            <div class="clr"></div> 
        </div>
        <!--Smart search ends here-->
        
        <!--filter start here-->
        <div class="">
            <div id="accordion" class="panel-group no-mrg">
                <div class="panel panel-default  sky-form">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
                            <?php echo CHtml::encode(Yii::t('inbox_index', 'txt_filter'))?>
                            <span class="accordian-state"></span>
                            </a>
                        </h2>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">
                        <div class="panel-body no-pdn">
                            <div class="col-md-12 no-mrg">
                                <div id="filterMsgOnly" class="message-filter">
                                    <?php
                                        $messageTyeAll = ($msgType == Globals::DEFAULT_VAL_NULL) ? 'active' : '' ;
                                        $messagesTypeMessages = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_MESSAGES) ? 'active' : '' ;
                                        $messagesTypeProposal = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_PROPOSAL) ? 'active' : '' ;
                                        $messagesTypePayment = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_PAYMENT) ? 'active' : '' ;
                                        $messagesTypeTerms = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_TERMS) ? 'active' : '' ;
                                        $messagesTypeInvites = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_INVITES) ? 'active' : '' ;
                                        $messagesTypeFeedback = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_FEEDBACK) ? 'active' : '' ;
                                        $messagesTypeDrafts = ($msgType == Globals::DEFAULT_VAL_MSG_TYPR_DRAFTS) ? 'active' : '' ;
                                    ?>
                                    
                                    <?php echo CHtml::hiddenField( Globals::FLD_NAME_MSG_TYPE , '', array('id' => 'messageTypeValue')); ?>
                                    <ul>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_all')), 'javascript:void(0)', array('id' => 'messagesTypeAll',  'class' => $messageTyeAll)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_messages')), 'javascript:void(0)', array('id' => 'messagesTypeMessages',  'class' => $messagesTypeMessages)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_proposals')), 'javascript:void(0)', array('id' => 'messagesTypeProposal',  'class' => $messagesTypeProposal)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_payment')), 'javascript:void(0)', array('id' => 'messagesTypePayment',  'class' => $messagesTypePayment)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_terms')), 'javascript:void(0)', array('id' => 'messagesTypeTerms',  'class' => $messagesTypeTerms)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_invites')), 'javascript:void(0)', array('id' => 'messagesTypeInvites',  'class' => $messagesTypeInvites)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_feedback')), 'javascript:void(0)', array('id' => 'messagesTypeFeedback',  'class' => $messagesTypeFeedback)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_drafts')), 'javascript:void(0)', array('id' => 'messagesTypeDrafts',  'class' => $messagesTypeDrafts)); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>  
        </div>
        <!--filter ends here-->
    </div>
    <!--Left side bar ends here-->

    <!--Right side content start here-->
    <div class="col-md-9 right-cont">
        <div class="sky-form" >
        
    <h3 class="h2 text-30a"><?php echo Yii::t('inbox_index', 'Inbox') ?></h3>
    
        <!--top head sort by start here-->
        <div class="margin-bottom-20">
            <div class="sortby-row"> 
                 <div class="col-md-1 mrg10"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_select_all'))?></div>
                <div class="col-md-1 no-mrg">
                    <ul>
                        <a href="#" class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_archive'))?></a>
                    </ul>
                </div>
                <div class="col-md-2">
                    <select class="form-control mrg3">
                        <option><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark'))?></option>
                    </select>
                </div>  
<!--                <div class="col-md-3 no-mrg">
                    <select class="form-control mrg3" name="archive">
                        <option><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_show_all_task'))?></option>
                    </select>
                </div>-->
                <div class="col-md-3 sortby-noti no-mrg">
                    <select class="form-control mrg3" name="archive">
                        <option><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_sort_by'))?></option>
                    </select>
                </div>
            </div>
<!--            <div class="select-row">
            <div class="col-md-1 mrg10"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_select_all'))?></div>
                <div class="col-md-1 no-mrg">
                    <ul>
                        <a href="#" class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_archive'))?></a>
                    </ul>
                </div>
                <div class="col-md-2">
                    <select class="form-control mrg3">
                        <option><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark'))?></option>
                    </select>
                </div>                     
            </div>-->
        </div>
        <!--top head sort by ends here-->
        <div onclick="$('#validationErrorMsg').parent().fadeOut();" style="display: none" class="alert alert-danger fade fade-in-alert">
            <button onclick="$('#validationErrorMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
            <div id="validationErrorMsg" ></div>
        </div>
        <!--right message start here-->
        <div class="col-md-12 no-mrg"> 
            <!--message start here--> 
            <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK, '' , array('id' => 'currentTask')) ?>
            <?php echo CHtml::hiddenField(Globals::FLD_NAME_TO_USER_IDS, '' , array('id' => 'currentToUserIds')) ?>
            <div id="listScrollTask" class="inboxmess_cont">

                <?php
                  
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'messagesTask',
                        'dataProvider' => $taskList,
                        'viewData' => array( 'fromUserId' => $fromUserId ,'toUserIds' => $toUserIds,'currentTask' => $currentTask ,),
                        'itemView' => 'partial/_mytaskslist',
                        'template' => '{items}{pager}',
                        'enableHistory' => true,
                         'afterAjaxUpdate' => "function(id, data) {
                                    $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                    jQuery.ias({
                                          'history':false,
                                          'triggerPageTreshold':0,
                                          'trigger':'Show more',
                                          'container':'#messagesTask.list-view',
                                          'item':'.rowselector',
                                          'pagination':'#messagesTask .pager',
                                          'next':'#messagesTask .next:not(.disabled):not(.hidden) a',
                                          'loader':'Loading...'});   
                                  

                        }",
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.rowselector',
                        'itemsSelector' => '.list-view',
                        'listViewId' => 'messagesTask',
                        'header' => '',
                        'loaderText' => 'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 2, 'trigger' => 'Show more'),
                    ),
                    ));
                  
                ?>
            </div>
            <!--message ends here-->  

            <!--reply start here-->  
                <?php  $this->renderPartial('//inbox/partial/_new_message', array( 'retatedUsers' => $retatedUsers , 'inbox' => $inbox,
                    'currentTaskList' => $currentTaskList,
                    'fromUserId' => $fromUserId,
                    'taskMessages' => $taskMessages));?>
        <!--right message ends here-->
    </div>
    </div>
    <!--Right side content ends here-->
</div>