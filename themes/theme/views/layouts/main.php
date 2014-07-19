<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
        <!-- for Facebook -->          

<meta property="og:image" content="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg" />


<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="" />


   <meta name="robots" content="noindex" />
	<meta name="language" content="en" />
	<!-- Css here -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/stylegc.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/colorbox.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/front/scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" /><link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/hover.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/bootstrap-theme.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/app.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/sky-forms.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/component.css" rel="stylesheet" type="text/css" />  
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/owl.carousel.css" rel="stylesheet" type="text/css" />  
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/h-tab.css" rel="stylesheet" type="text/css" />  
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/alerts.css">
  
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); 
        Yii::app()->session['controller'] = Yii::app()->controller->id;
        ?>
</head>
    <?php $class = UtilityHtml::getControllerandAction();?>
    <body class="<?php echo $class ?>">
<!-- for date picker start-->
<?php
$this->widget('ext.EJsScroll.EJsScroll',
    array(
        'selector' => '.categoryScroll',
        'showArrowsBar'=>false
    )
);
?>
<?php

//print_r(Yii::app()->user->getState('permission'));


?>
      <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/daterangepicker-bs3.css" />
      <link href="<?php echo Yii::app()->request->baseUrl ?>/js/bxslider/jquery.bxslider.css" rel="stylesheet"/>
      <script src="<?php echo Yii::app()->request->baseUrl ?>/js/bxslider/jquery.bxslider.min.js"></script>

      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/moment.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/daterangepicker.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/readmore/readmore.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.formatDateTime.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/classie.js"></script>
     
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/uiProgressButton.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/owl2-carousel.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/owl.carousel.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.appear.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/waypoints.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js"></script>

<!--       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/facebox.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dirtyforms.js"></script>-->
      
             <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-collapse.js"></script>-->
      
      <!-- for date picker end-->
<script> 
    function reloadGrid(data,id)
    {
            //$.fn.yiiGridView.update('portfolio-grid-task');
            $.fn.yiiGridView.update(id);
            $("#msgPortfolio").html("");
            $("#msgPortfolio").css("display","block");
            $("#msgPortfolio").append(data);
            return false;
    }
function applyOnClick(taskId)
{   
    jQuery.ajax({
        'dataType':'json',
        'data':{'taskId':taskId},
        'type':'POST',
        'success':function(data)
        {
            $('#applyProposal').html(data.html);  
            forscrollonload();
            $('#bidFor').html(data.title);
            //loaduoloaderOnAjax();
            applyForTask();
        },
        'url':'<?php echo Yii::app()->createUrl('poster/applyForTask'); ?>','cache':false});        
        return false; 
}
function editAppliedProposal(taskId , taskTaskerID )
{   
    jQuery.ajax({
        'dataType':'json',
        'data':{'taskId':taskId ,task_tasker_id:taskTaskerID,taskList:false },
        'type':'POST',
        'success':function(data)
        {
            $('#applyProposal').html(data.html);  
            forscrollonload();
            $('#bidFor').html(data.title);
            //loaduoloaderOnAjax();
            applyForTask();
        },
        'url':'<?php echo Yii::app()->createUrl('poster/applyForTask'); ?>','cache':false});        
        return false; 
}
function girdView()
{
    $('#currentView').val('grid');
    $('.search_row').addClass('list-col');
    $('#listView').show();
    $('#gridView').hide();
    $('.taskTitlePublicSearchGrid').show();
    $('.taskTitlePublicSearchList').hide();
   setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','grid');  
}
function listView()
{
    $('#currentView').val('list');
    $('.search_row').removeClass('list-col');
    $('#listView').hide();
    $('#gridView').show();
    $('.taskTitlePublicSearchGrid').hide();
    $('.taskTitlePublicSearchList').show();
    setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','list'); 
}
    function setUserPrimation(type,status)
    {   
        jQuery.ajax({
            'dataType':'json',
            'data':{'type':type,'status':status},
            'type':'POST',
            'success':function(data)
            {
                if(data == 1)
                {
                    if(status == 0)
                    {
                        $("#"+type).addClass('active');
                    }
                    else
                    {
                        $("#"+type).removeClass('active');
                    }
//                    jAlert("licence set successfully.");
                    location.reload();
                }
                else
                {
                    jConfirm('<?php echo Yii::t('tasker_mytasks','You do not have permission for this licence.Do you want to purchase this') ?>', 'Licence Confirm', function(r) 
                    {
                            if( r == true)
                            {
                                window.location.href='<?php echo Yii::app()->createUrl('index'); ?>';
                            }
                            else
                            {
                                return false;
                            }
                    });      
//                    jAlert("You do not have permission for this licence.");
                }
            },
            'url':'<?php echo Yii::app()->createUrl('commonfront/setuserprimation'); ?>','cache':false});        
            return false; 
    }
    function alertErrorMessage(msg , id)
   {
       if(!id)
       {
           id = "errorMsg";
       }
       $('#'+id).show();
       $('#'+id).parent().show();
       $('#'+id).html(msg);
        setTimeout(function() {
            $('#'+id).parent().hide();
        }, 10000);
   }
    function loadpopup(data , id , className , scroll)
    {
        if(!id)
        {
            id = 'loadpopupForAllTasks';
        }
        if(!scroll)
        {
            scroll = true;
        }
        jQuery("#"+id).html(data);
        
       
        jQuery("#"+id).fadeTo("slow", 1.0); 
         jQuery("#"+id).addClass(className);
        jQuery("#overlay").fadeTo("slow", 0.3);  
        //$("#"+id).mCustomScrollbar();
        if(scroll == true)
        {
            $("#"+id).jScrollPane({
                    showArrows: false,
                    autoReinitialise: true
            });
        }
       
    }
    
    
    function loadpopupUserProfile(data , id)
    {
        if(!id)
        {
            id = 'loadpopupForProfileAddress';
        }
        jQuery("#"+id).html(data);
        
        jQuery("#"+id).addClass("profile_popup");
        jQuery("#"+id).fadeTo("slow", 1.0); 
      
        jQuery("#overlayProfile").fadeTo("slow", 0.3);  
        $("#"+id).jScrollPane({
		showArrows: false,
		autoReinitialise: true
	});
    }
    
    function closepopup(id)
    {
        if(!id)
        {
            id = 'loadpopupForAllTasks';
        }
        jQuery("#"+id).fadeOut("slow"); 
        jQuery("#overlay").fadeOut("slow"); 
    }
    
function unsetpotential(bookmark_type,id , saveText , removeText , saveClass , removeClass )
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'bookmark_type':bookmark_type,'id':id,'saveText':saveText,'removeText':removeText,'saveClass':saveClass,'removeClass':removeClass},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
            $('#potentialFor_'+id).html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/unsetpotential') ?>','cache':false});return false; 
}
function setpotential(bookmark_type,id , saveText , removeText, saveClass , removeClass )
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'bookmark_type':bookmark_type,'id':id,'saveText':saveText,'removeText':removeText,'saveClass':saveClass,'removeClass':removeClass},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#potentialFor_'+id).html(data.html);
        }
        else
        {
        alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/setpotential') ?>','cache':false});return false; 
}


// Start page hover popup

function minimizePopup(popupid)
    {
        $('#'+popupid+'-minimize').hide();
        //$('#'+popupid+'-minimize').css( "overflow" , 'visible' );
        $('#'+popupid+' .maximize-btn').show();
        $('#'+popupid+' .minimize-btn').hide();
         $('#'+popupid).addClass('w-300');
        
    }
    function maximizePopup(popupid)
    {
        
        $('#'+popupid+'-minimize').show();
        //$('#'+popupid+'-minimize').css( "overflow" , 'visible' );
        $('#'+popupid+' .maximize-btn').hide();
        $('#'+popupid+' .minimize-btn').show();
        $('#'+popupid).removeClass('w-300');
      
    }
    function applyForTask()
    {
        $('#applyProposal').show();
         maximizePopup('applyProposal');
//         $(".categoryScroll").mCustomScrollbar();
    }
    function closeApplyForTask()
    {
        $('#applyProposal').hide();
    }
    function setApproverCost()
    {
        var serviceFeesPer = '<?php echo LoadSetting::serviceFees() ?>';
        var totalApprovedCost = 0;
        if($.isNumeric($('#TaskTasker_proposed_cost').val()))
        {
            if(parseInt($('#TaskTasker_proposed_cost').val()) > 0)
            {
                var servicefees = ( parseFloat(serviceFeesPer) / 100) * Math.round($('#TaskTasker_proposed_cost').val()) ;
               // alert(servicefees);
                totalApprovedCost = Math.round($('#TaskTasker_proposed_cost').val()) + servicefees;
            }
        }
        $('#TaskTasker_approved_cost').val(Math.round(totalApprovedCost));
        //$('#TaskTasker_approved_cost_view').html(totalApprovedCost);
    }
    function setMyPayCost()
    {
        var serviceFeesPer = '<?php echo LoadSetting::serviceFees() ?>';
       var totalApprovedCost = 0;
        if($.isNumeric($('#TaskTasker_approved_cost').val()))
        {
            if(parseInt($('#TaskTasker_approved_cost').val()) > 0)
            {
                totalApprovedCost = ( Math.round($('#TaskTasker_approved_cost').val()) * 100 ) / ( 100 + parseFloat(serviceFeesPer) )
            }
        }
        $('#TaskTasker_proposed_cost').val(Math.round(totalApprovedCost));
        //$('#TaskTasker_approved_cost_view').html(totalApprovedCost);
    }

// End page hover popup

function unsetpotentialSave(bookmark_type,id)
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'bookmark_type':bookmark_type,'id':id,'savebutton':'savebutton'},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
            $('#potentialFor_'+id).html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/unsetpotentialsave') ?>','cache':false});return false; 
}
function setpotentialSave(bookmark_type,id)
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'bookmark_type':bookmark_type,'id':id,'savebutton':'savebutton'},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#potentialFor_'+id).html(data.html);
        }
        else
        {
        alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/setpotentialsave') ?>','cache':false});return false; 
}



function cancelTask(taskId , refresh ,taskStatus)
{
    
    
    jConfirm('<?php echo Yii::t('tasker_mytasks','Are you sure to cancel this project !!!') ?>', 'Confirm cancellation', function(r) 
    {
            if( r == true)
            {
                jQuery.ajax({
                        'dataType':'json',
                        'data':{'taskId':taskId , 'refresh' : refresh , 'taskStatus' : taskStatus},
                        'beforeSend':function(){$("#canceltask"+taskId).addClass("loading");},
                        'complete':function(){$("#canceltask"+taskId).removeClass("loading");},
                        'type':'POST',
                        'success':function(data)
                        {
                            if(data.status==='success')
                            {
                                // $.fn.yiiListView.update( 'loadmypostedtask');
                                loadpopup(data.html , '' , 'task-cancel-popup');
                            }
                            else
                            {
                                alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
                            }
                        },
                        'url':'<?php echo Yii::app()->createUrl('poster/canceltaskform') ?>','cache':false});return false;
            }
            else
            {
                return false;
            }

        });                        
}
function HireMe(tasker_id , task_tasker_id)
    {
        jQuery.ajax({
                        'beforeSend':function(){$("#proposalAccept"+tasker_id).addClass("loading");},
                        'complete':function(){$("#proposalAccept"+tasker_id).removeClass("loading");},
                        'data':{'task_tasker_id': task_tasker_id},'type':'POST','dataType':'json',
                        'success':function(data){
                                                    if(data.status==="success")
                                                    {
                                                        jQuery("#acceptProposalButton"+tasker_id).html(data.html);
                                                        jQuery("#rejectProposalButton"+tasker_id).html("");
                                                        jQuery("#hiredFor_"+tasker_id).css("display","block");
                                                        jQuery("#notHired_"+tasker_id).css("display","none");
                                                    }
                                                    else
                                                    {
                                                        alert("<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) ?>");
                                                    }
                                                },
                        'url':'<?php echo Yii::app()->createUrl('poster/proposalaccept') ?>','cache':false});return false;
        
    }
    function HireMeTermsPopup(tasker_id ,task_tasker_id)
    {
        
        jQuery("#doerHireMePopup").fadeTo("slow", 1.0); 
        jQuery("#overlaytaskDetail").fadeTo("slow", 0.3); 
        jQuery("#popupMsgToUserId").val(tasker_id); 
        jQuery("#popupTaskTaskerID").val(task_tasker_id); 
        
        
       // loadpopup($('#doerHireMePopup').html() , '' , 'doerHireByPosterPopup');
//        jQuery.ajax(
//        {
//            'beforeSend':function(){$("#proposalAccept"+tasker_id).addClass("loading");},
//            'complete':function(){$("#proposalAccept"+tasker_id).removeClass("loading");},
//            'data':{'task_tasker_id': task_tasker_id},'type':'POST','dataType':'json',
//            'success':function(data)
//                {
//                if(data.status==="success")
//                {
//                        loadpopup(data.html , '' , 'doerHireByPosterPopup');
//                        $("hiring_closed").bootstrapSwitch();
//                }
//                else
//                {
//                    alert("<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) ?>");
//                }
//            },
//            'url':'<?php echo Yii::app()->createUrl('tasker/hiremepopup') ?>','cache':false
//        });return false;
        
    }
    function NotInterested(tasker_id , task_tasker_id)
    {
      jQuery.ajax({
                    'beforeSend':function(){$("#proposalReject"+tasker_id).addClass("loading");},
                    'complete':function(){$("#proposalReject"+tasker_id).removeClass("loading");},
                    'data':{'task_tasker_id': task_tasker_id},
                    'dataType':'json','type':'POST',
                    'success':function(data)
                    {
                        if(data.status==="success")
                        {
                            jQuery("#rejectProposalButton"+tasker_id).html(data.html);
                            jQuery("#acceptProposalButton"+tasker_id).html("");
                        }
                        else
                        {
                            alert("<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) ?>");
                        }
                    },
                    'url':'<?php echo Yii::app()->createUrl('poster/proposalreject') ?>','cache':false});return false;
    }
    function ShowInterest(tasker_id , task_tasker_id)
    {
      jQuery.ajax({
                    'beforeSend':function(){$("#proposalReject"+tasker_id).addClass("loading");},
                    'complete':function(){$("#proposalReject"+tasker_id).removeClass("loading");},
                    'data':{'task_tasker_id': task_tasker_id},
                    'dataType':'json','type':'POST',
                    'success':function(data)
                    {
                        if(data.status==="success")
                        {
                            jQuery("#rejectProposalButton"+tasker_id).html(data.html);
                            jQuery("#acceptProposalButton"+tasker_id).html(data.accept);
                        }
                        else
                        {
                            alert("<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) ?>");
                        }
                    },
                    'url':'<?php echo Yii::app()->createUrl('poster/proposalshowinterest') ?>','cache':false});return false;
    }
    function searchByChildCategory( parent , id )
{
    var setnull = 0;
    var url = '';
    $('input:checkbox.subcategory').each(function () {
        if(this.checked)
        {
            url += $(this).val()+"-";
            setnull = 1;
        }
    });
    var data = "/<?php echo Globals::URL_SUBCATEGORY_TYPE_SLUG ?>"+url;
    data = data.substring(0, data.length - 1);
    if(setnull == 0)
    {
        var data = "";
    }
    var parentUrl = "<?php echo Globals::URL_CATEGORY_TYPE_SLUG ?>"+parent;
    var taskType = $('#taskType').val();
    var params = $.param(data);
    var newUrl = '<?php echo CommonUtility::getTaskListURI() ?>';
    var  newUrl = newUrl +taskType+'/'+ parentUrl+ data;
    window.History.pushState(null, document.title,newUrl);
    //loadaftercategoriesfilter(  '<?php echo Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK ?>' , ' ' , ' ');
   
}
function deleteFilter(attrib_type , attrib_desc , user_id , row )
{
   
    jQuery.ajax({
        'dataType':'json',
        'data':{'<?php echo Globals::FLD_NAME_ATTRIB_TYPE ?>':attrib_type,'<?php echo Globals::FLD_NAME_ATTRIB_DESC ?>':attrib_desc,'<?php echo Globals::FLD_NAME_USER_ID ?>':user_id},
        'type':'POST',
        'success':function(data)
        {
            $("#filter_"+row).css("display","none")
        },
        'url':'<?php echo Yii::app()->createUrl("tasker/deletesearchfilter") ?>','cache':false});return false;
}
function activeMenu(id)
{
    $(id).addClass('active');
}
function removeActiveMenu(id)
{
   // alert();
    if(id)
    $(id).removeClass('active');
    else
    $('.active').removeClass('active');
    
}
function removeImage(divId , uploaderId)
{
    var usedSize = $('#'+uploaderId+'_totalFileSizeUsed').val();
    var totalSize = $('#'+uploaderId+'_totalFileSize').val();
    var fileSize =  $('#'+divId+'_size').val();
        usedSize =  parseInt(usedSize) - parseInt(fileSize);
         $('#'+uploaderId+'_totalFileSizeUsed').val(usedSize);
            
   
    $('#'+divId).remove();
    
}
function loadcategoryfiltes(taskType , maxPrice , minPrice)
{
        jQuery.ajax({
        //'dataType':'json',
        'data':{'taskType':taskType , 'maxPrice' : maxPrice ,'minPrice' : minPrice},
        'type':'POST',
        'success':function(data)
        {
            $('#loadcategory').html(data);
            $('.categoryScroll .advnc_row3 a').removeClass('activeCategory');
            //$(\".categoryScroll\").mCustomScrollbar();
            $('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});
        },
        'url':'<?php echo Yii::app()->createUrl('tasker/getcategories') ?>','cache':false});
        return false;
}
function loadaftercategoriesfilter(filterType , maxPrice , minPrice , taskName)
{
        jQuery.ajax({
                'dataType':'json',
                'data':{'maxPrice' : maxPrice ,'minPrice' : minPrice,'filter_type' :filterType,'taskName' :taskName},
                'type':'POST',
                'success':function(data)
                {
                if(data.status==='success')
                {
                    $('#aftercategoryfilter').html(data.html);
                    $('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});
                }
                else
                {
                    alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
                }
                },
                'url':'<?php echo  Yii::app()->createUrl('tasker/getcategoriesfilter') ?>','cache':false});
        return false;
}
function loadfilters(filterType , reset)
{
        jQuery.ajax({
    'dataType':'json',
    'data':{'filter_type': filterType , 'reset' : reset},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#loadactionfilter').html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/getactionfilter') ?>','cache':false});return false; 
}

function sendProposal()
{
    jQuery.ajax({
        'type':'POST',
        'dataType':'json',
        'success':function(data)
        {
            $("#taskerSendProposal").removeClass("loading");

            if(data.status==="save_success_message")
            {
                $("#pageleavevalidation").val("");
                $.fn.yiiListView.update('loadmytasksdata');
                $("#successNotiMsg").val("");
                alertErrorMessage('<?php echo Yii::t('flashmessages', 'txt_bid_success'); ?>' , 'successNotiMsg' );
                closeApplyForTask();
            }                                  
            else
            {
                if(data.status==="error")
                {
                    //alert(data.msg);
                    jAlert("Oops!!! an unexpected error has occurred.", 'Oops!!! an error.');
                    //alert("Oops!!! an unexpected error has occurred.");
                }
                else
                {
                    $.each(data, function(key, val) 
                    {
                                $("#"+key+"_em_").text(val);                                                    
                                $("#"+key+"_em_").show();
                    });
                }
            }

        },
        'beforeSend':function()
        {   
            $("#taskerSendProposal").addClass("loading");
            $(".help-block").css("display", "none");

        },
        'url':'<?php echo Yii::app()->createUrl('poster/saveproposal') ?>',
        'cache':false,
        'data':jQuery("#taskerSendProposal").parents("form").serialize()});
    return false;
}


function cancelacceptedbydoer(task_tasker_id,taskTitle)
{

    jConfirm('Are you sure you want to accepte for project cancellation?', 'Confirm cancellation', function(r) 
    {
            if( r == true)
            {
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createUrl('poster/cancelacceptedbydoer');?>',
                    dataType: 'json',
                    data: {task_tasker_id: task_tasker_id},
                    success: function (data) {
                        jAlert(taskTitle+" has been accepted for cancellation");
                    }
                });
            }
            else
            {
                return false;
            }

        });        
}

function  loaduoloaderOnAjax( id , action)
{
    if(!id)
    {
        id = 'uploadProposalAttachments';
    }
    if(!action)
    {
        action = '<?php echo Yii::app()->createUrl('poster/uploadtaskfiles'); ?>';
    }
    //alert(id);
    var FileUploader_uploadProposalAttachments = new qq.FileUploader({
        'element':document.getElementById(id),
        'debug':false,
        'multiple':false,
        'action':action,
        'allowedExtensions': ['<?php echo implode("','", array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]) );?>'],
        'sizeLimit':<?php echo LoadSetting::getMaxUploadFileSize()?>,
        'minSizeLimit':'<?php echo LoadSetting::getSettingValue(Globals::SETTING_KEY_MIN_UPLOAD_FILE_SIZE)?>',
        'dataType':'json',
        'onComplete':function(id, fileName, responseJSON)
        { 
           <?php echo  CommonScript::loadAttachmentSuccess('uploadProposalAttachments','getAttachmentsPropsal','proposalAttachments'); ?>
        },
       'params':{'PHPSESSID':'<?php echo session_id() ?>','YII_CSRF_TOKEN':'<?php echo Yii::app()->request->csrfToken ?>'}}); 
}
function afterValidateAttribute(form, attribute, data, hasError)
{
    var field = (attribute.hasOwnProperty('id')) ? attribute['id'] : '';
  
    if(field !== '')
    {
        var text = (data.hasOwnProperty(field)) ? data[field] : '';
        field = '#' + field;
 
        if(hasError && (text !== ''))
        {
            var
                tTemp = '',
                dotTemp = '';
 
            /**
             * We use a trick with temporary disabling title, if user is also 
             * using tooltip for this field. Our popover would share title used 
             * in that tooltip, which is rather unwanted effect, right?
             */
            if($(field).attr('rel') == 'tooltip')
            {
                tTemp = $(field).attr('title');
                dotTemp = $(field).attr('data-original-title');
 
                $(field).attr('title', '');
                $(field).attr('data-original-title', '');
            }
 
            /**
             * 'destroy' is necessary here, if your field can have more than one
             * validation error text, for example, if e-mail field can't be empty
             * and entered value must be a valid e-mail; in such cases, not using
             * .popover('destroy') here would result in incorrect validation errors
             * being displayed for such field.
             */    
            $(field)
                .popover('destroy')
                .popover
                ({
                    trigger : 'manual',
                    content : text
                })
                .popover('show');
 
            if($(field).attr('rel') == 'tooltip')
            {
                $(field).attr('title', tTemp);
                $(field).attr('data-original-title', dotTemp);
            }
        }
        else $(field).popover('destroy');
    }
}

function afterAjaxSubmit(field, data)
{
  
  
    if(field !== '')
    {
        var text =data;
        field = '#' + field;
 
        if((text !== ''))
        {
            var
                tTemp = '',
                dotTemp = '';
 
            /**
             * We use a trick with temporary disabling title, if user is also 
             * using tooltip for this field. Our popover would share title used 
             * in that tooltip, which is rather unwanted effect, right?
             */
            if($(field).attr('rel') == 'tooltip')
            {
                tTemp = $(field).attr('title');
                dotTemp = $(field).attr('data-original-title');
 
                $(field).attr('title', '');
                $(field).attr('data-original-title', '');
            }
 
            /**
             * 'destroy' is necessary here, if your field can have more than one
             * validation error text, for example, if e-mail field can't be empty
             * and entered value must be a valid e-mail; in such cases, not using
             * .popover('destroy') here would result in incorrect validation errors
             * being displayed for such field.
             */    
            $(field)
                .popover('destroy')
                .popover
                ({
                    trigger : 'manual',
                    content : text
                })
                .popover('show');
 
            if($(field).attr('rel') == 'tooltip')
            {
                $(field).attr('title', tTemp);
                $(field).attr('data-original-title', dotTemp);
            }
        }
        else $(field).popover('destroy');
    }
}

$( document ).ready(function()
{
    setTimeout(function() 
    {
            $('#successNotiMsg').parent().hide();
    }, 10000);    
    jQuery('#cboxClose').on('click', closepopup());
    $( ".fortooltip" ).hover(function() {   
        $('#'+$(this).attr('id')).tooltip('show');
    });       
});

function setCurrentViewForUser(actionname,currentView)
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'actionname': actionname , 'currentView' : currentView},
    'type':'POST',
    'success':function(data)
    {},
    'url':'<?php echo Yii::app()->createUrl('commonfront/setcurrentview') ?>','cache':false});return false;  
}



function forscrollonload()
{
    var windWidth = $(window).height();
        var width = $(window).width();
        
        if(width > 1023)
        {
            $("#leftSideBarScroll").height(windWidth*.67);
            var leftscroll = $("#leftSideBarScroll").jScrollPane({
		showArrows: false,
		autoReinitialise: true
                }).bind(
                            'mousewheel',
                            function(e)
                            {
                                e.preventDefault();
                            }
                        );
             $(".applyPopupProjectLive").jScrollPane({
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
            $("#leftSideBarScroll").height('auto');
            $(".applyPopupProjectLive").css('height' , 'auto');
            
            //$(".categoryScroll").css('height' , '100%');
        }
}

    $(document).ready(function()
    {
        
        forscrollonload();
    });
    $(window).resize(function(){
        forscrollonload();
    });
</script>
<!--      <script>
			[].slice.call( document.querySelectorAll( '.progress-button' ) ).forEach( function( bttn, pos ) {
				new UIProgressButton( bttn, {
					callback : function( instance ) {
						var progress = 0,
							interval = setInterval( function() {
								progress = Math.min( progress + Math.random() * 0.1, 1 );
								instance.setProgress( progress );

								if( progress === 1 ) {
									instance.stop( pos === 1 || pos === 3 ? -1 : 1 );
									clearInterval( interval );
								}
							}, 150 );
					}
				} );
			} );
		</script>-->
   <?php CommonScript::loadAjaxPopover();
   // Start for tooltipster
//   $this->widget('ext.tooltipster.tooltipster');
   // End for tooltipster
   ?>

     <?php
//$user=Yii::app()->user;
//echo $user->getState(CWebUser::AUTH_TIMEOUT_VAR);
//if(!$user->getIsGuest())
//{
//   $time= (Yii::app()->getSession()->getTimeout() - 60)*1000;//converting to millisecs
//   Yii::app()->clientScript->registerSCript('timeoutAlert','
//     setTimeout(function()
//    {
//          var n=10;
//            setInterval(function()
//            {
//                  if(n>0)$("#timeout").addClass("flash-error").text("Your session will expire in "+n+" seconds");
//                  
//                  if(n==0) {
//                        $("#timeout").text("Your session has expired!");clearInterval();
//                             }
//                --n;    
//                },1000) 
//        }, 
//                
//        '.$time.')
//',CClientScript::POS_END);
//}
?>
      <div id="timeout"></div> 
<div class="wrapper">
  <!--Header Start Here-->
<!--  <header class="header">
    <div class="content_wrap">
      <div class="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="green comet"></div>
       <div class="signin_cont">
	  <?php
	  if(empty($userid))
	  {
	  ?>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_in')), Yii::app()->createUrl('index/login'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?></div>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_up')), Yii::app()->createUrl('index/register'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?>
		</div>
		<?php } 
		else
		{ ?> 
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/dashboard'); ?>"><?php 
			if(isset(Yii::app()->user->fullname) && !empty(Yii::app()->user->fullname))
			{ echo 'Welcome '.Yii::app()->user->fullname; }
			else if(isset(Yii::app()->user->name))
			{ echo 'Welcome '.Yii::app()->user->name; }?></a></div>
		
	 <?php }
		?>
      </div>
    </div>
  </header>-->
  <!--This div for Light Box only-->
<div id="dialog"></div>
<!--This div for Light Box only-->
  <!--Content Start Here-->
 <?php echo $content; ?>
 
   <?php          echo      UtilityHtml::getPopup(); ?>
     <?php          echo      UtilityHtml::getPopupNotClose(); ?>
  
    <?php
    if(Yii::app()->user->id)
    {
         $timeout = Yii::app()->getSession()->getTimeout() - 60;
        $this->widget('ext.timeout-dialog.ETimeoutDialog', array(
            // Get timeout settings from session settings.
            'timeout' => $timeout,
            // Uncomment to test.
            // Dialog should appear 20 sec after page load.
            //'timeout' => 5,
            'keep_alive_url' => $this->createUrl('/index/keepalive'),
            'logout_redirect_url' => $this->createUrl('/index/logout'),
        ));
    }
?>
  
 </div>
  

<?php /*?><div class="container" id="page">
<div  id="language-selector" style="float:right; margin:5px;">
    <?php 
       // $this->widget('application.components.widgets.LanguageSelector');
    ?>
</div>
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Go To Admin', 'url'=>array('admin/index/login')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page --><?php */?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/jquery.placeholder.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/minified/jquery-1.9.1.min.js"%3E%3C/script%3E'))</script>
	<!-- custom scrollbars plugin -->	
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function($){
        $(window).load(function(){
            $(".wrapperewrwerwe").mCustomScrollbar();
        });
    })(jQuery);
</script>

</body>
</html>
