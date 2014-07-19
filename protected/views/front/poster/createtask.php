<?php echo CommonScript::loadCreateTaskScript() ?>
<?php //CommonUtility::validateUser(); ?>
<?php Yii::import('ext.chosen.Chosen'); ?>

<!--   d-block
      d-none    -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/createtask.min.js"></script>
<script>

    function confirmBeforeUnload(e) {
        var e = e || window.event;
        if( parseInt($("#pageleavevalidation").val().length) > 1 )
        {
            if($("#pageleavevalidationonsubmit").val().length == 0 )
            {
                if (e) 
                {
                    e.returnValue = '<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_are_you_sure_to_leave')); ?>';
                }
                // For Safari
                return '<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_are_you_sure_to_leave')); ?>';
            }
        }
    }
    window.onbeforeunload = confirmBeforeUnload;
    
  function selectCategory(category_id , returnid)
   {
       $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('poster/selectcategory') ?>',
            data: { category_id: category_id},
            type: "POST",
            dataType : "json",
            beforeSend : function(){
                                    $(returnid).addClass("loading-select");
                                                 
                                    },
            complete : function(){
                                    $(returnid).removeClass("loading-select");
                                },
            error: function () 
            {
               alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
            },
            success: function (data) 
            {
               if(data.status==='success')
                {
                    closepopup();
                    selectCategoryByTaskType(category_id);
                    getFormDataByCategory(category_id);
                    formProcess();
                    $(returnid).html(data.html);
                }
                else
                {
                     alertErrorMessage("<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>");
                    //alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
            }
        });
       // formProcess();
        return false;
       
   }
function loadtaskform(taskType)
   {
       var form = $('#createTaskform').val();
      // alert(form);
       $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('poster/loadtaskdetailfrom') ?>',
            data: { <?php echo Globals::FLD_NAME_FORM_TYPE ?>: taskType , form : form},
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
                    closepopup();
                    
                    $("#taskDetailFrom").html(data.form);
                    
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
       
   }
    function getFormDataByCategory(category_id)
   {
      var  taskType = $('#selectTaskType').val();
       $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('poster/loadtaskformdatabycategory') ?>',
            data: { category_id: category_id , taskType:taskType },
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
                    
                    $("#getskills").html(data.skills);
                    $("#categoryTemplates").html(data.template);
                   
                    $("#getQuestions").html(data.questions);
                    $("#categoryIdHidden").val(data.category_id);
                    if($('#chooseCategory'+taskType).find("option:selected").text() != '')
                    {
                        $("#categoryNameDetailForm").css('display','inline-block');
                         $("#categoryNameParentDetailForm").html($('#chooseCategory'+taskType).find("option:selected").text());
                         $("#categoryNameDetailForm").html(data.category_name);
                    }
                    else
                    {
                         $("#categoryNameParentDetailForm").html(data.category_name);
                         $("#categoryNameDetailForm").css('display','none');
                    }
//                    $("#categoryNameDetailForm").html(data.category_name);
//                    $("#categoryNameParentDetailForm").html($('#chooseCategory'+taskType).find("option:selected").text());
                    if(taskType == 'instant')
                    {
                         $("#recentTasksTemplates").html("");
                    }
                    else
                    {
                         $("#recentTasksTemplates").html(data.previusTask);
                    }
                     <?php   
                        if(!isset($task->{Globals::FLD_NAME_TASK_ID}))
                        {
                            ?>
                            $("#Task_min_price").val(data.default_min_price);
                            $("#min_price_msg").html(data.default_min_price);
                            $("#Task_max_price").val(data.default_max_price);
                            $("#Task_work_hrs").val(data.default_estimated_hours);
                            
                            $("#default_max_price").val(data.default_max_price);
                            $("#default_estimated_hours").val(data.default_estimated_hours);
                            $("#default_min_price").val(data.default_min_price);
                            
                            if(taskType == 'inperson')
                            {
                                if($('#switch_to_person').val() == '1')
                                {
                                    if($('#task_description_instant_hidden').val() != '')
                                    {
                                        $('#Task_description').val($('#task_description_instant_hidden').val()); 
                                        $('#Task_title').val($('#task_description_instant_hidden').val().substring('0' , '40')); 
                                        setInvitedUser();
                                    }
                                    if($('#task_min_price_instant_hidden').val() != '')
                                    {
                                       $('#Task_min_price').val($('#task_min_price_instant_hidden').val());
                                       $('#Task_max_price').val($('#task_min_price_instant_hidden').val());
                                       $('#min_price_msg').val($('#task_min_price_instant_hidden').val());

                                    }
                                    if($('#task_cash_required_instant_hidden').val() != '')
                                    {
                                       $('#Task_cash_required').val($('#task_cash_required_instant_hidden').val());
                                    }
                                    if($('#task_price_hidden').val() != '')
                                    {
                                       $('#Task_price').val($('#task_price_hidden').val());
                                    }
                                    $('#switch_to_person').val('');
                                }
                            }
        
                            if(taskType == 'instant')
                            {
                                instantTaskTotalCost();
                            }
                            else
                            {
                                estimatedCost();
                            }
                             <?php
                        }
                    ?>
                    
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
       
   }
    function setPriceMode(mode)
   {
       $('#selectPriceMode ul li a').removeClass('active');
       $('#Task_payment_mode').val(mode);
       if(mode == '<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY ?>')
       {
           $('#Task_work_hrs').val($("#default_estimated_hours").val());
           $('#selectPriceModeHourly').addClass('active');
           $('#for_fixed_price_mode').show();
          
       }
       else if(mode == '<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE ?>')
       {
           
           $('#Task_work_hrs').val("<?php echo Globals::DEFAULT_VAL_MIN_WORK_HRS ?>");
           $('#selectPriceModeFixed').addClass('active');
           $('#for_fixed_price_mode').hide();
       }
        estimatedCost();
       
   }
   function setLocation(isLocation)
   {
       if(isLocation == '<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>')
       {
           $('#selectCountryLocation').hide();
       }
       else if(isLocation == '<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>')
       {
           $('#selectCountryLocation').show();
       }
    }
     function addQuestionToForm(queId , queText , dropDownId , actionDivId  )
    {
        var setHeddenQueId = '<input type="hidden" name="<?php echo Globals::FLD_NAME_MULTI_CAT_QUESTION ?>[]" value="'+queId+'--'+queText+'" >';
        $('#'+actionDivId).append("<div style=\"overflow:hidden;\" class=\"alert3 alert-block alert-warning fade in q-mrg\"><button onclick=\"resetQuetionsDropdown( '"+dropDownId+"' ,'"+queId+"')\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><div class=\"col-lg-2 mrg\">"+queText+setHeddenQueId+"</div></div>");
    }
    
   
    function resetBidCloseDate()
    {
        $('#Task_bid_duration').val('');
        $('#taskBidCloseDateContainer').css('display','none');
        var end_date = $('#Task_end_date').val();
        
        $.ajax(
        {
            url: '<?php echo Yii::app()->createUrl('poster/bidenddatedroopdown') ?>',
            data: { <?php echo Globals::FLD_NAME_TASK_END_DATE ?> : end_date },
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
                    $("#task_bid_close_date_droop_down").html(data.duration);
                }
                else
                {
                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                }
                
            }
        });
        return false;
        
        
    }
    function addTaskerToInvite( userId , userName , userImage , targetDivId , inviteBtnTarget , taskerInvitedDivTitle , takerInfoOwter,invitedTaskersRemove)
    {
         
        if(!targetDivId)
        {
            targetDivId = 'invitedTaskers';
        }
        if(!inviteBtnTarget)
        {
            inviteBtnTarget = 'userInviteBtn';
        }
        if(!taskerInvitedDivTitle)
        {
            taskerInvitedDivTitle = 'invitedTaskersTitle';
        }
        if(!takerInfoOwter)
        {
            takerInfoOwter = 'takerInfoOwter';
        }
        if(!invitedTaskersRemove)
        {
            invitedTaskersRemove = 'invitedTaskersRemove';
        }
        
        
        var doNotAdd = 0;
        if(!$("#"+inviteBtnTarget+userId).hasClass('invitedtasker'))
        {
            
            var vals = $('.taskers_hidden').map(function(){
                var userIdAdded = $(this).val();
            if(userIdAdded == userId )
            {
                $("#"+inviteBtnTarget+userId).text('Invited');
                doNotAdd = 1;
            }
            }).get();
            
            if(doNotAdd == 0)
            {
                $("#"+taskerInvitedDivTitle).show();
               // if(takerInfoOwter == 'takerInfoOwter' )
              //  {
                    $("#"+invitedTaskersRemove).show();
               // }

                var name = userName.split(" ");
               if(name[0] && name[1] )
               {
                    if(name[0].length < 8)
                    {
                       var userName = name[0]+" "+name[1].substring(0, 1); 
                    }
                    else
                    {
                      var  userName = name[0]; 
                    }
                }
                else
                {
                    var userName = userName.substring(0, 10); 
                }
               // 
                 var setHeddenQueId = '<input type="hidden"  class="taskers_hidden" name="invitedtaskers[]" value="'+userId+'" >';
                 $('#'+targetDivId).show();
                $('#'+targetDivId).append("<div class=\"alert2 invite-select alert-block alert-warning fade fade-in-alert mrg6\" style=\"overflow:hidden;\"><button type=\"button\" onclick='removeInvitedTasker("+userId+",\""+invitedTaskersRemove+"\",\""+targetDivId+"\",\""+taskerInvitedDivTitle+"\" )' class=\"close2\" data-dismiss=\"alert\"><img src=\"<?php echo CommonUtility::getPublicImageUri('info-del.png') ?>\" > </button><div class=\"col-lg-2 in-img\"><img src='"+userImage+"'></div><div class='in-img-name'>"+userName+setHeddenQueId+"</div></div>");
                $("#"+inviteBtnTarget+userId).addClass('invitedtasker');
                $("#"+takerInfoOwter+userId).addClass('invite-select');
                $("#"+inviteBtnTarget+userId).text('Invited');
            }
        }
    }

</script>
<style>
    /*#chooseCategoryinperson_chosen
    {
        width: 344px !important;
    }
    #chooseCategoryvirtual_chosen
    {
        width: 344px !important;
    }
    #chooseCategoryinstant_chosen
    {
        width: 344px !important;
    }
    #Task_end_time_chosen
    {
        width: 180px !important;
    }
    #load_recent_template_chosen
    {
         width: 260px !important;
    }*/
   
</style>

<?php
Yii::app()->clientScript->registerScript('searchTaskers', "
         


function reloadFilterGrid()
{ 
   $('#taskerName').val('');
   $('#active_within').val('');
    $('#completed_projects').val('');
     $('#average_price').val('');
      
       $('#locations').val('');
    $('#locations').trigger(\"chosen:updated\");
   // $('#locations').chosen({'no_results_text':'No results match','display_selected_options':false});
  $(\".keys\").attr('title', '');
    //var data = $('#taskerName').serialize(); 
   var data = $('#quickFilterValue').serialize();
  // var data = 'quick_filter = '+quickFilterValue+'&username=';
    $.fn.yiiListView.update('loadtaskerlist', {data: data});
}

function resetsearchfilter()
{ 
    $('#taskerName').val('');
    var data = $('#taskerName').serialize();   
    $.fn.yiiListView.update('loadtaskerlist', {data: data});
}
$('#taskerName').bind('keyup keypress' , function(e){
var code = e.keyCode || e.which; 
    if(code == 13)
    {
            var data = $('#taskerName').serialize();    
             $.fn.yiiListView.update('loadtaskerlist', {data: data});
             e.preventDefault();
            return false;
    }
     //e.preventDefault();
   
});
$('body').delegate('a#resetFilter','click',function()
{
   resetsearchfilter();
    return false; 
        
    
});
$('body').delegate('#multiskills','click',function()
{
    var setnull = 0;
   
    var data = $('#multiskills').serialize();    
    $.fn.yiiListView.update('loadtaskerlist', {data: data});
        
       
   
});

$('body').delegate('#searchByTaskName','click',function()
{
            var data = $('#taskerName').serialize();    
             $.fn.yiiListView.update('loadtaskerlist', {data: data});
});

$('body').delegate('#categoryNameSearch','keyup',function()
{
            var data = $('#categoryNameSearch').serialize();    
             $.fn.yiiListView.update('categorylistpopup', {data: data});
});
$('a#loadHired').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PREVIOUSLY_WORKED."'); reloadFilterGrid(); setActiveFilterTaskDetail(this.id); searchDoerBarHide();});
$('a#loadpremiumtasker').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid();setActiveFilterTaskDetail(this.id); searchDoerBarHide();});
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid(); setActiveFilterTaskDetail(this.id); searchDoerBarHide();});
$('a#loadAll').click(function(){ $('#quickFilterValue').val(''); reloadFilterGrid(); setActiveFilterTaskDetail(this.id); searchDoerBar();});



     "
                       );


?>
 <?php
$instantActive = null;
$virtualActive = null;
$inpersonActive = null;
$instantActiveTab = 'none';
$virtualActiveTab = 'none';
$inpersonActiveTab = 'none';
$selectedTaskType = 'virtual';
$selectedCategoryVirtul = '';
$selectedCategoryInperson = '';
$selectedCategoryInstant = '';
    switch ($task->{Globals::FLD_NAME_TASK_KIND}) /// insert values according to task type
    {
        case Globals::DEFAULT_VAL_I :
            $instantActive = 'active';
            $instantActiveTab = 'block';
            $selectedTaskType = 'instant';
            if(isset($editTaskPartials['category_id']))
            $selectedCategoryInstant = $editTaskPartials['category_id'];
            break;
    
        case Globals::DEFAULT_VAL_P :
            $inpersonActive = 'active';
            $inpersonActiveTab = 'block';
            $selectedTaskType = 'inperson';
            if(isset($editTaskPartials['category_id']))
            $selectedCategoryInperson = $editTaskPartials['category_id'];
            break;

        default:
            $virtualActive = 'active';
            $virtualActiveTab = 'block';
            $selectedTaskType = 'virtual';
            if(isset($editTaskPartials['category_id']))
            $selectedCategoryVirtul = $editTaskPartials['category_id'];
            break;
    }
    ?>
<?php echo  CHtml::hiddenField('task_description_instant_hidden','', array('id' => 'task_description_instant_hidden' )) ?>
<?php echo  CHtml::hiddenField('task_min_price_instant_hidden','', array('id' => 'task_min_price_instant_hidden' )) ?>
<?php echo  CHtml::hiddenField('task_cash_required_instant_hidden','', array('id' => 'task_cash_required_instant_hidden' )) ?>
<?php echo  CHtml::hiddenField('task_price_hidden','', array('id' => 'task_price_hidden' )) ?>
<?php echo  CHtml::hiddenField('switch_to_person','', array('id' => 'switch_to_person' )) ?>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'create-task-form',
				'enableAjaxValidation' => false,
                                'enableClientValidation' => true,
     'clientOptions' => array(
//        'validateOnSubmit' => true,
//    'validateOnChange' => true,
//    //'validateOnType' => true,
    ),
				
			)); 


echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>       
<?php echo  CHtml::hiddenField('selected_category[]', $selectedCategoryVirtul , array('id' => 'selectCategoryvirtual')) ?>
<?php echo  CHtml::hiddenField('selected_category[]', $selectedCategoryInperson , array('id' => 'selectCategoryinperson')) ?>
<?php echo  CHtml::hiddenField('selected_category[]', $selectedCategoryInstant , array('id' => 'selectCategoryinstant')) ?>
<?php echo  CHtml::hiddenField('selected_tasktype', $selectedTaskType , array('id' => 'selectTaskType' )) ?>
<?php echo  CHtml::hiddenField('createTaskform', serialize($form) , array('id' => 'createTaskform' )) ?>

<?php echo  CHtml::hiddenField('pageleavevalidation', '' , array('id' => 'pageleavevalidation' )) ?>
<?php echo  CHtml::hiddenField('pageleavevalidationonsubmit', '' , array('id' => 'pageleavevalidationonsubmit' )) ?>

<?php echo  CHtml::hiddenField('default_min_price', Globals::DEFAULT_VAL_MIN_PRICE , array('id' => 'default_min_price' )) ?>
<?php echo  CHtml::hiddenField('default_max_price', Globals::DEFAULT_VAL_MIN_PRICE , array('id' => 'default_max_price' )) ?>
<?php echo  CHtml::hiddenField('default_estimated_hours','', array('id' => 'default_estimated_hours' )) ?>



<?php
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{
    echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
    if($repeat == 1)
    {
        $action = "poster/savevirtualtask";
        $submitLabel = Yii::t('poster_createtask', 'lbl_post_project');
    }
    else
    {
        $action = "poster/updateproject";
        $submitLabel = Yii::t('poster_createtask', 'lbl_update_project');
    }
     
}
else
{
    $action = "poster/savevirtualtask";
    $submitLabel = Yii::t('poster_createtask', 'lbl_post_project');
}
//$submitLabel = ( $submitLabelisset($task->{Globals::FLD_NAME_TASK_ID})) ? Yii::t('poster_createtask', 'Update Project') : Yii::t('poster_createtask', 'Post Project');
?>

<div class="container content">
    

<!--Left bar start here-->
<div class="col-md-3 leftbar-fix" >
<!--Dashbosrd start here-->
<?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--left nav start here-->
<div id="">
<div class="margin-bottom-30">
<ul class="v-step">
    <li class="margin-bottom-20" onclick="<?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'return false;'; else echo 'goStep1()' ?>"><span id="taskStep1"  class="vstep1 <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'vstep1b'; else echo 'vstep1a' ?>">1</span> <span class="vtext1"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_category')) ?></span></li>
<li class="margin-bottom-20" onclick="goStep2()"><span id="taskStep2" class="vstep1 <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'vstep1a'; ?> ">2</span> <span class="vtext <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'vtext1'; ?>"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_details')) ?></span></li>
<!--<li class="margin-bottom-20" id="useraddTask">
   
     <?php echo CHtml::ajaxLink('<span id="taskStep3" class="vstep1">3</span> <span class="vtext">Post</span>', Yii::app()->createUrl($action), array(
              
                'dataType' => 'json', 
                'data' => 'js:jQuery(this).parents("form").serialize()',
                        'type' => 'POST',
         'beforeSend' => 'function(){
                                $(".help-block").css("display", "none");
                            }',
                        'success' => 'function(data){
                                                         if(data.status==="success")
                                                            {
                                                            $("#pageleavevalidationonsubmit").val("done");
                                                             window.location = data.detailUrl;
                                                            }
                                                        else
                                                        {
                                                        var msg = "";
                                                            $.each(data, function(key, val)
                                                            {
                                                              
                                                               msg += "<p><i class=\"fa fa-hand-o-right\"></i> "+val+"</p>";
                                                                $("#"+key+"_em_").text(val);
                                                             
                                                                $("#"+key).addClass("state-error");
                                                                $("#"+key).parent().addClass("state-error");

                                                                $("#"+key+"_em_").show();
                                                                

                                                            });
                                                            $("html, body").animate({ scrollTop: 0 }, "slow");
                                                            alertErrorMessage("<h4 class=\"error-h4\">Oops!! You got an error!</h4>"+msg , "validationErrorMsg");
                                                            //alertErrorMessage("OOps!!! please enter all required details to proceed.");
                                                            goStep2();
                                                        }
                                                    }'), 
                        array('id' => 'saveTaskByPost', 'class' => '', 'live' => false)); ?>

 
</li>-->
</ul>
</div>
<!--left nav Ends here-->

<!--left Button Start here-->
<div class="margin-bottom-30">

    <input class="btn-u btn-u-lg rounded btn-u-red push" type="button" onclick="window.location.href = '<?php echo Yii::app()->createUrl('index/dashboard') ?>'" value="Cancel" >
    <input type="button" class="btn-u btn-u-lg rounded btn-u-sea push" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'none'; else echo 'inline' ?>"  <?php if($editTaskPartials != '') echo ''; else echo ''; ?> onclick="goStep2()" id="fromProcessBtn" value="Enter Details" >
<span  style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'inline'; else echo 'none' ?>" id="taskSaveBtn" >
 
<?php 

                
                $successUpdate = '
                                    if(data.status==="success"){

                                            $("#pageleavevalidationonsubmit").val("done");
                                            if($("#pageleavevalidationonsubmit").val() != "")
                                            {
                                                window.location = data.detailUrl;
                                            }
                                    }
                                    else
                                    {
                                        var msg = "";
                                                            $.each(data, function(key, val)
                                                            {
                                                              
                                                              msg += "<p><i class=\"fa fa-hand-o-right\"></i> "+val+"</p>";
                                                                $("#"+key+"_em_").text(val);
                                                             
                                                                $("#"+key).addClass("state-error");
                                                                $("#"+key).parent().addClass("state-error");

                                                                $("#"+key+"_em_").show();
                                                                

                                                            });
                                                            $("html, body").animate({ scrollTop: 0 }, "slow");
                                                             alertErrorMessage("<h4 class=\"error-h4\">Oops!! You got an error!</h4>"+msg , "validationErrorMsg");
                                                            // $("#accordion #collapseOne").collapse("show");
                                                            if(!$("#collapseOne").hasClass("in"))
                                                            {
                                                                $("#collapseOne").parent(".panel").find( ".panel-heading .panel-title1 a" ).removeClass("collapsed");
                                                                $("#collapseOne").collapse(\'show\');
                                                            }
                                                          
                                    }
                                    ';
                
                                    CommonUtility::getAjaxSubmitButton(
                                              $submitLabel,
                                                Yii::app()->createUrl($action), 'btn-u btn-u-lg rounded btn-u-sea push', 'useraddTask', $successUpdate);
                                                ?>
<!--    <div class="progress-button">
            <button ><span>Submit</span></button>
            <svg class="progress-circle" width="70" height="70"><path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/></svg>
            <svg class="checkmark" width="70" height="70"><path d="m31.5,46.5l15.3,-23.2"/><path d="m31.5,46.5l-8.5,-7.1"/></svg>
            <svg class="cross" width="70" height="70"><path d="m35,35l-9.3,-9.3"/><path d="m35,35l9.3,9.3"/><path d="m35,35l-9.3,9.3"/><path d="m35,35l9.3,-9.3"/></svg>
    </div> /progress-button -->
</span>
    
</div>
<!--left Button Ends here-->
</div>
</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9 right-cont" onclick="$('#errorMsg').parent().fadeOut();">
    
    <div id="type_title" class="breadcrumbs fixed col-fixed">
        <h1 id="title_virtual" class="pull-left text-30" style="display: <?php echo $virtualActiveTab ?>;"><?php if(isset($task->{Globals::FLD_NAME_TASK_ID})  && $repeat == 0) echo 'Edit Virtual Project'; else echo 'New Virtual Project' ?> </h1>
        <h1 id="title_inperson" class="pull-left text-30"  style="display: <?php echo $inpersonActiveTab ?>;"><?php if(isset($task->{Globals::FLD_NAME_TASK_ID})  && $repeat == 0) echo 'Edit In-Person Project'; else echo 'New In-Person Project' ?></h1>
        <h1 id="title_instant" class="pull-left text-30" style="display: <?php echo $instantActiveTab ?>;" ><?php if(isset($task->{Globals::FLD_NAME_TASK_ID})  && $repeat == 0) echo 'Edit Instant Project'; else echo 'New Instant Project' ?></h1>
        <ul id="categoriesOnTitle" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>" class="pull-right breadcrumb">
            <li id="categoryNameParentDetailForm" >
                <?php 
                if(isset($editTaskPartials["parent_id"]))
                {
                   echo  CommonUtility::getCategoryName($editTaskPartials["parent_id"]);
                }
                ?> 
            </li>
            <li id="categoryNameDetailForm" class="active"> 
            <?php 
                if(isset($editTaskPartials["category_name"]))
                {
                   echo $editTaskPartials["category_name"];
                }
            ?>
            </li>
        </ul>
    </div>
    

<div id="taskType"  style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'none'; else echo 'block' ?>" >
    <div class="col-md-12 mrg-auto5">
<!--       <h2 id="title_virtual" class="h2 d-block">New Virtual Project</h2>
       <h2 id="title_inperson" class="h2 d-none">New Inperson Project</h2>
       <h2 id="title_instant" class="h2 d-none">New Instant Project</h2>-->

<!--top tab start here-->
<div class="grad-box margin-top-bottom-30 no-border">
    <div id="taskTypeTab" class="vtab">
<ul>
<li>
 
    <a id="loadVirtualTaskShort" onclick="<?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'return false'; else { ?> getTaskType('virtual'); <?php } ?>"  class="virtual <?php  echo $virtualActive ?>" href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_virtual')) ?></a>
</li>
<li>
    <a id="loadInpersonTaskShort" onclick="<?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'return false'; else { ?> getTaskType('inperson'); <?php } ?>"  class="inperson <?php  echo $inpersonActive ?>"  href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_inperson')) ?></a>
</li>
<li>
    <a id="loadInstantTaskShort" onclick="<?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'return false'; else { ?> getTaskType('instant'); <?php } ?>"  class="instant <?php  echo $instantActive ?>"  href="javascript:void(0)"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_instant')) ?></a>
</li>
</ul>
</div>
    <div class="clr"></div>
</div>
<div style="display: none" class="alert alert-danger fade in">
    <button onclick="$('#errorMsg').parent().fadeOut();" class="close4" type="button">×</button>
    <div id="errorMsg" >

    </div>
    
</div>

<!--top tab ends here-->
<div id="taskTypeTabsContant" >
<!--Choose a Category and Subcategory Start here-->
<div id="virtual" class="taskContant" style="display: <?php echo $virtualActiveTab ?>;"  >
      <?php if(!isset($task->{Globals::FLD_NAME_TASK_ID}))
      $this->renderPartial('partial/_virtualtask' , array( 'task' => $task , 'form' => $form , 'editTaskPartials' => $editTaskPartials )); ?>
  </div>
<!--Choose a Category and Subcategory Start here-->
  <div id="inperson" class="taskContant"  style="display: <?php echo $inpersonActiveTab ?>;" >
      <?php  
      if(!isset($task->{Globals::FLD_NAME_TASK_ID}))
      $this->renderPartial('partial/_inpersontask' , array( 'task' => $task , 'form' => $form , 'editTaskPartials' => $editTaskPartials)); ?>
  </div>


<!--Choose a Category and Subcategory Start here-->
  <div id="instant" class="taskContant" style="display: <?php echo $instantActiveTab ?>;" >
      <?php 
      if(!isset($task->{Globals::FLD_NAME_TASK_ID}))
      $this->renderPartial('partial/_instanttask' , array( 'task' => $task , 'form' => $form , 'editTaskPartials' => $editTaskPartials)); ?>
  </div>
</div> 
</div>
</div>
<div id="accordionDiv" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>"  >

<div class="col-md-12 no-mrg">


<!--top tab start here-->
<div id="recentTasksTemplates" class="col-md-5 mrg-auto5" style="display: <?php if($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INSTANT ) echo 'none'; else echo 'block' ?>" >
    <?php if(isset($editTaskPartials['previusTask']))
    {
        echo $editTaskPartials['previusTask'];
    }
    ?>
</div>
<!--top tab ends here-->

<!--Choose a Category and Subcategory Start here-->
<div class="margin-bottom-30">
    
<div class="panel-group" id="accordion">
<div id="taskDetailFrom" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>" >
    <?php
    switch ($task->{Globals::FLD_NAME_TASK_KIND}) /// insert values according to task type
    {
        case Globals::DEFAULT_VAL_I :
            $this->renderPartial('partial/_instant_task_detail_from' , array( 'task' => $task  , 'taskLocation'=>$taskLocation, 'taskerList' => $taskerList , 'model' => $model ,  'form' => $form , 'editTaskPartials' => $editTaskPartials , 'users' => $users,'repeat' => $repeat )); 
            break;
    
        case Globals::DEFAULT_VAL_P :
            $this->renderPartial('partial/_inperson_task_detail_from' , array( 'task' => $task  , 'taskLocation'=>$taskLocation, 'taskerList' => $taskerList , 'model' => $model ,  'form' => $form , 'editTaskPartials' => $editTaskPartials,'repeat' => $repeat )); 
            break;

        default:
            $this->renderPartial('partial/_virtual_task_detail_from' , array( 'task' => $task  , 'taskLocation'=>$taskLocation, 'taskerList' => $taskerList , 'model' => $model ,  'form' => $form , 'editTaskPartials' => $editTaskPartials,'repeat' => $repeat )); 
            break;
    }
    ?>
</div>
<?php  if($task->{Globals::FLD_NAME_TASK_KIND} != Globals::DEFAULT_VAL_TASK_KIND_INSTANT) 
{
    ?>
    <div id="findDoers" style="display: <?php  if(isset($task->{Globals::FLD_NAME_TASK_ID})) {  if($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INSTANT )  {   echo 'none';  }  else {   echo 'block'; }} else echo 'none' ?>">
    <?php $this->renderPartial('partial/_task_detail_invite_doers' , array(  'taskerList' => $taskerList , 'model' => $model , 'editTaskPartials' => $editTaskPartials ,'task' => $task )); ?>
    </div>
    <?php
}
?>


</div>
</div>
    </div>
   
</div>
</div>

<!--Choose a Category and Subcategory Ends here-->


<!--Right part ends here-->
</div>

<?php $this->endWidget(); ?>