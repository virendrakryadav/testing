<?php
$date = '';
$maxdate = isset($_GET["maxdate"]) ? $_GET["maxdate"] : '';
$mindate = isset($_GET["mindate"]) ? $_GET["mindate"] : '';

$maxPriceValue = isset($_GET["maxprice"]) ? $_GET["maxprice"] : $maxPrice;
$minPriceValue = isset($_GET["minprice"]) ? $_GET["minprice"] : $minPrice;
$taskType = (isset($_GET["taskType"])) ? $_GET["taskType"] : Globals::DEFAULT_VAL_TASK_TYPE ;
$categoryName = (isset($_GET[Globals::FLD_NAME_CATEGORYNAME])) ? $_GET[Globals::FLD_NAME_CATEGORYNAME] : '' ;
$parentCategory = CommonUtility::getCategoryIdFromString($categoryName);
$subCategoryName = (isset($_GET[Globals::FLD_NAME_SUBCATEGORYNAME])) ? $_GET[Globals::FLD_NAME_SUBCATEGORYNAME] : '' ;
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;
$taskName = (isset($_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE])) ? $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE] : '' ;


if(isset($_GET["maxdate"]) && isset($_GET["mindate"]) )
{
    $date = CommonUtility::formatedViewDate( $_GET["mindate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH )." - ".CommonUtility::formatedViewDate( $_GET["maxdate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH );
}
$rating = (isset($_GET["rating"])) ? $_GET["rating"] : '' ;

$checkedValue = "";
$duration = "";
$ending = "";
$proposals = "";
$relationships = "";

$searchtype = "";
$displayDuration = "none";
$displayEnding = "none";
$displayProposals = "none";
$displayRelationships = "none";

$classDuration = "";
$classEnding = "";
$classProposals = "";
$classRelationships = "";
$sortVal = "";

if(isset($_GET['duration']))
{
    $classDuration = "showing";
    $checkedValue = $_GET['duration'];
    $duration = $_GET['duration'];
    $searchtype = "duration";
    $displayDuration = "block";
}
if(isset($_GET['ending']))
{
    $classEnding = "showing";
    $checkedValue = $_GET['ending'];
    $ending = $_GET['ending'];
    $searchtype = "ending";
    $displayEnding = "block";
}
if(isset($_GET['proposals']))
{
    $classProposals = "showing";
    $checkedValue = $_GET['proposals'];
    $proposals = $_GET['proposals'];
    $searchtype = "proposals";
    $displayProposals = "block";
}
if(isset($_GET['relationships']))
{
    $classRelationships = "showing";
    $checkedValue = $_GET['relationships'];
    $relationships = $_GET['relationships'];
    $searchtype = "relationships";
    $displayRelationships = "block";
}
if(isset($_GET['sort']))
{
   
    $sortVal = $_GET['sort'];    
}


?>
<script>
var searchByDuration = '<?php echo $checkedValue; ?>';
function markRead(taskId)
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'taskId':taskId},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#markReadfor_'+taskId).html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/markread') ?>','cache':false});return false; 
}
function markUnRead(taskId)
{
    jQuery.ajax({
    'dataType':'json',
    'data':{'taskId':taskId},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#markReadfor_'+taskId).html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('tasker/markunread') ?>','cache':false});return false; 
}

function SearchFunc(data)   
{
    var url = document.URL;
    var params = $.param(data);
    window.History.pushState(null, document.title,$.param.querystring(url, data));
}
function SearchByDate(start, end)   
{      
    var url = document.URL;
    var data = "mindate=" + start.format("<?php echo Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH ?>" )  + "&maxdate=" + end.format( "<?php echo Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH ?>" )  ;
    var params = $.param(data);
    window.History.pushState(null, document.title,$.param.querystring(url, data)); 
}

function SearchByDuration(type)   
{    
    if(type != "")
    {
        var date = new Date();
        var gatdate = date.getDate();
        var month = date.getMonth()+1;
        var end = date.getFullYear()+"-"+month+"-"+gatdate;
        var start = date.getFullYear()+"-"+month+"-"+gatdate;        
        if(type == "1week") 
        {      
           date = new Date(date - 1000 * 60 * 60 * 24 * 6);
           month = date.getMonth()+1;
           start = date.getFullYear()+"-"+month+"-"+date.getDate();
        }
        else if(type == "15days")
        {            
           date = new Date(date - 1000 * 60 * 60 * 24 * 14);
           month = date.getMonth()+1;
           start = date.getFullYear()+"-"+month+"-"+date.getDate(); 
        }
        else if(type == "1month")
        {
           date = new Date(date - 1000 * 60 * 60 * 24 * 30);
           month = date.getMonth()+1;
           start = date.getFullYear()+"-"+month+"-"+date.getDate(); 
        }        
        var url = document.URL;
        var data = "mindate=" + start+ "&maxdate=" + end;
        var params = $.param(data);
        window.History.pushState(null, document.title,$.param.querystring(url, data)); 
    }
    else
    {
        resetDate(); 
        if($("#taskTitle").val() != "")
        {
            var data = $('#taskTitle').serialize();    
            SearchFunc(data);  
            loadfilters('<?php echo Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK; ?>'); 
        }
    }
}

function resetDate()
{
    var taskType =  '<?php echo Globals::DEFAULT_VAL_TASK_TYPE; ?>';
    $('#taskType').val('<?php echo Globals::DEFAULT_VAL_TASK_TYPE; ?>');
    var url = '<?php echo CommonUtility::getTaskListURI(); ?>';
    $('#allCategory').hide();
    $('#sortDrop').val('');
    window.History.pushState(null, document.title,url);
    
    jQuery.ajax({
        //'dataType':'json',
        'data':{'taskType':taskType , 'maxPrice' : <?php echo $maxPrice; ?> ,'minPrice' : <?php echo $minPrice; ?>},
        'type':'POST',
        'success':function(data)
        {
            $('#loadcategory').html(data);
            $('.categoryScroll .advnc_row3 a').removeClass('activeCategory');
            //$(\".categoryScroll\").mCustomScrollbar();
            $('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});            
        },
        'url':'<?php echo Yii::app()->createUrl('tasker/getcategories'); ?>','cache':false});
        loadfilters('<?php echo Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK; ?>' , 'reset');
        removeActiveMenu();
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
            loaduoloaderOnAjax();
            applyForTask();
        },
        'url':'<?php echo Yii::app()->createUrl('poster/applyForTask'); ?>','cache':false});        
        return false; 
}

function searchByChildCategory( parent , id )
{
    var setnull = 0;
    var url = '';
    var sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();
    var filterByType = $('#fieltertype').val();
    var sideBarFielter = '';
    if(filterByType != '')
    {
        sideBarFielter = '&'+filterByType+'='+searchByDuration;
        sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();
    }
    
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
    var  newUrl = newUrl +taskType+'/'+ parentUrl+ data + sort + sideBarFielter;
    window.History.pushState(null, document.title,newUrl);
   
}


function currentView()
{    
    if($('#currentView').val() == 'grid')
    {
        girdView();
    }
    else
    {
        listView()
    }
}
function postQuestion(id)
{
    loadpopup($('#social'+id).html(), '' , 'post-question-task-detail social-link-popup')  
} 



//div fiexed scripted srart

//function UpdateTableHeaders() {
//       $(".content").each(function() {
//       
//           var el             = $(this),
//               offset         = el.offset(),
//               scrollTop      = $(window).scrollTop(),
//               floatingHeader = $(".floatingHeader", this)
//           
//           if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
//               floatingHeader.css({
//                "visibility": "visible"
//               });
//           } else {
//               floatingHeader.css({
//                "visibility": "hidden"
//               });      
//           };
//       });
//    }
//    
//    // DOM Ready      
//    $(function() {
//    
//       var clonedHeaderRow;
//    
//       $(".content").each(function() {
//           clonedHeaderRow = $(".col-md-66", this);
//           clonedHeaderRow
//             .before(clonedHeaderRow.clone())
//             .css("width", clonedHeaderRow.width())
//             .addClass("floatingHeader");
//             
//       });
//       
//       $(window)
//        .scroll(UpdateTableHeaders)
//        .trigger("scroll");
//       
//    });

//div fiexed scripted End


$(document).mouseup(function (e){
    var container = $("#allCategory");

    if (container.has(e.target).length === 0) {
        container.hide();
    }
});

</script>

<?php

if(Yii::app()->user->hasState(Yii::app()->controller->action->id))
{
    $currentViewValue = Yii::app()->user->getState(Yii::app()->controller->action->id);
}
else
{
    $currentViewValue = "list";
}

?>
<input type="hidden" id="currentView" value="<?php echo $currentViewValue; ?>" name="currentView">
<?php echo  CHtml::hiddenField('pageleavevalidation', '' , array('id' => 'pageleavevalidation' )) ?>
<?php echo  CHtml::hiddenField('pageleavevalidationonsubmit', '' , array('id' => 'pageleavevalidationonsubmit' )) ?>
<?php

Yii::import('ext.chosen.Chosen');
$isLogin = CommonUtility::isUserLogin();
Yii::app()->clientScript->registerScript('searchMyPoposals', "
                            
var ajaxUpdateTimeout;
var ajaxRequest;
var val;
var hasToRun = 0;
$('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
$(\".categoryScroll\").mCustomScrollbar();
$('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});

function reloadFilterGrid()
{ 
    data = $('#quickFilterValue').serialize();
    var url = '".CommonUtility::getTaskListURI()."';
    var params = $.param(data);
    //url = url.substr(0, url.indexOf('?'));
    
    
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var taskType = $('#taskType').val();   
    loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
    window.History.pushState(null, document.title,$.param.querystring(url, data));
}

function reloadFilterByForm()
{
    var form = $(this).closest('form').attr('id');
    $.fn.yiiListView.update('loadmytasksdata', {data: $('#'+form).serialize()});
}
$('#taskType').change(function()
{ 
    var taskType = $(this).val();   
    var url = '".CommonUtility::getTaskListURI()."';
    if( taskType != '".Globals::DEFAULT_VAL_TASK_TYPE."' )
    {
        url = url + taskType;
    }
    window.History.pushState(null, document.title,url);
   
        loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
        removeActiveMenu();
        return false; 
});

$('body').delegate('#searchByTaskTitle','click',function()
{
 var data = $('#taskTitle').serialize();    
            SearchFunc(data);  
            //SearchByDuration($('#duration').val());
            //loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
            });
$('body').delegate('#cleareSearchByTaskTitle','click',function()
{
 var data = $('#taskTitle').serialize();    
            SearchFunc(data);  
            //SearchByDuration($('#duration').val());
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
            });

$('body').delegate('.skills','click',function()
{
    var setnull = 0;
    
    $('input:checkbox.skills').each(function () {
        if(this.checked)
        {
            var sThisVal = (this.checked ? $(this).val() : '');
            var data = $('.skills').serialize();    
            SearchFunc(data);  
            setnull = 1;
        }
    });
    if(setnull == 0)
    {
        var  data = 'skills[]=';
        SearchFunc(data); 
    }
    
     loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
});


$('body').delegate('.categoryScroll .advnc_row3 a','click',function()
{
    var catId = $(this).attr('id'); 
    var sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();    
    var filterByType = $('#fieltertype').val();
    var sideBarFielter = '';
    if(filterByType != '')
    {
        sideBarFielter = '&'+filterByType+'='+searchByDuration;
        sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();
    }
    var parentCatId = $(this).data('id');    
    var data = $(this).attr('href'); 
    var taskType = $('#taskType').val();    
    var url = '".CommonUtility::getTaskListURI()."';
    url = url + taskType + data + sort + sideBarFielter;
    window.History.pushState(null, document.title,url);
    //removeActiveMenu();
    $('.categoryScroll .advnc_row3 a').removeClass('activeCategory');
    $(this).addClass('activeCategory');
        jQuery.ajax({
        'dataType':'json',
        'data':{'catId':parentCatId},
        'type':'POST',
        'success':function(data)
        {
        if(data.status==='success')
        {
            $('.categoryScroll .advnc_col6 ').html('');
            $('#catIdRow_'+parentCatId).next('.advnc_col6').html(data.html);
            loadaftercategoriesfilter(  '".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."' , '".$maxPrice."' , '".$minPrice."' , '".$taskName."' );
        }
        else
        {
            alert('".Yii::t('tasker_createtask','unexpected_error')."');
        }
        },
        'url':'". Yii::app()->createUrl('tasker/getsubcategories') ."','cache':false});
            
        
            
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."'); 
        return false; 
});


$('body').delegate('a#resetFilter','click',function()
{
    var taskType =  '".Globals::DEFAULT_VAL_TASK_TYPE."';
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var url = '".CommonUtility::getTaskListURI()."';
    window.History.pushState(null, document.title,url);
    
    jQuery.ajax({
        //'dataType':'json',
        'data':{'taskType':taskType , 'maxPrice' : ".$maxPrice." ,'minPrice' : ".$minPrice."},
        'type':'POST',
        'success':function(data)
        {
            $('#loadcategory').html(data);
            $('.categoryScroll .advnc_row3 a').removeClass('activeCategory');
            //$(\".categoryScroll\").mCustomScrollbar();
            $('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});
            $('#taskTitle').val('');
            //$('#duration').val('');
        },
        'url':'". Yii::app()->createUrl('tasker/getcategories') ."','cache':false});
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."' , 'reset');
        removeActiveMenu();
        return false; 
        
    
});

//$('a#loadEndingToday').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ENDING_TODAY."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//$('a#loadFewProposals').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_FEW_PROPOSALS."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//
//
//$('a#loadPreviouslyWorked').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PREVIOUSLY_WORKED."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//$('a#loadNearBy').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_IN_RANGE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//$('a#loadHighlyRated').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_RANK."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//$('a#loadMostValued').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PRICE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
//$('a#loadPremiumTask').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid();  removeActiveMenu(); activeMenu(this); });


$('#loadEndingToday').click(function()
{ 
$('#quickFilterValue').val('".Globals::FLD_NAME_ENDING_TODAY."'); 
    reloadFilterGrid();
    removeActiveMenu(); 
    activeMenu(this);
    });
    
 $('#resetLeftBar').click(function(){
       var sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();
       var url = '".CommonUtility::getTaskListURI()."'+sort;
          
      window.History.pushState(null, document.title,url);   
//    var url = document.URL;  
//    url = url.replace('?'+$('#fieltertype').val()+'='+searchByDuration, ''); 
//    url = url.replace('&'+$('#fieltertype').val()+'='+searchByDuration, '');
//    searchByDuration = '';
//    window.History.pushState(null, document.title,url);
    $('#taskerlist ul li span').removeClass('active'); 
        $('#taskerlist ul li a').removeClass('active'); 
    $('.project-filter input[type=checkbox]').removeAttr('checked');               
    $('#'+$('#fieltertype').val()).next('ul').hide();
 });
$('.project-filter input[type=checkbox]').click(function()
{    
   // var url = document.URL;
        var url = '".CommonUtility::getTaskListURI()."';
    if($('#fieltertypeold').val() != '')
    {
        if($('#fieltertype').val() != $('#fieltertypeold').val())
        {
            url = url.replace('?'+$('#fieltertypeold').val()+'='+searchByDuration, ''); 
            url = url.replace('&'+$('#fieltertypeold').val()+'='+searchByDuration, ''); 
            searchByDuration ='';  
            $('#'+$('#fieltertypeold').val()).next('ul').removeClass('showing');  
        }
    }
    var type = $('#fieltertype').val(); 
    
    if($(this).attr('checked') == 'checked')
    {  
        searchByDuration += $(this).attr('id')+'-';
    }  
    if($(this).attr('checked') != 'checked')
    {          
      searchByDuration = searchByDuration.replace($(this).attr('id')+'-', '');       
    }   
     var searchByDurationUrl = type+'='+searchByDuration;  
          
    window.History.pushState(null, document.title,$.param.querystring(url, searchByDurationUrl));
            
//    var url = '".CommonUtility::getTaskListURI()."?'+type+'=';
//    url = url+searchByDuration;
//    window.History.pushState(null, document.title,url);    
    $('#fieltertypeold').val(type);
});


$('a#filterAllProposals').click(function(){ reloadFilterGrid(); });

    $('#choice_0').click(function() 
    {
        if($(\"input:radio[name='choice']\").is(\":checked\")) 
        {
        $('#locationSlider').fadeIn();
            // alert($(\"input:radio[name='choice']:checked\").val());
        }
    });
    $('#choice_1').click(function() 
    {
        if($(\"input:radio[name='choice']\").is(\":checked\")) 
        {
        $('#locationSlider').fadeOut();
        $('#Task_tasker_in_range').val('');
        var form = $(this).closest('form').attr('id');
        $.fn.yiiListView.update('loadmytasksdata', {data: $('#'+form).serialize()});
        }
    });
    $('#sortDrop').change(function(){  
        var data = $(this).serialize();    
            SearchFunc(data); 
         loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
    });      
    $('.fielter').click(function(){          
            
        if( $(this).next('ul').attr('class') != 'showing')
        {
            $('.project-filter input[type=checkbox]').removeAttr('checked'); 
        }
        
        $('#fieltertype').val($(this).attr('id'));  
        $('.showing').hide();        
        $(this).next('ul').show();        
        $(this).next('ul').addClass('showing'); 
        $('#taskerlist ul li span').removeClass('active'); 
        $('#taskerlist ul li a').removeClass('active'); 
        $(this).addClass('active');   
    });      
    $('#categoryClick').click(function(){             
        $('#allCategory').show();                
    });  
    currentView();
"
);
?>
<?php 
    $previouslyWorked = ($quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED) ? 'active' : '' ;
    $potential = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'active' : '' ;
    $premium = ($quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE) ? 'active' : '' ;
    $endingToday = ($quickFilter == Globals::FLD_NAME_ENDING_TODAY) ? 'active' : '' ;
    $fewProposals = ($quickFilter == Globals::FLD_NAME_FEW_PROPOSALS) ? 'active' : '' ;
?>
<div class="container content">
    <!--Left side bar start here-->
    <div class="col-md-3 leftbar-fix">
        <!--Dashbosrd start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashbosrd start here-->
         <div id="leftSideBarScroll">
        <!--Instant Navigations starts here-->
        <?php /*$this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
                array(
                    CHtml::encode(Yii::t('tasklist', 'txt_applied_to')) =>  CommonUtility::getTaskerApplyProjectsUrl(),
                    CHtml::encode(Yii::t('tasklist', 'txt_active_projects')) =>  CommonUtility::getTaskerActiveProjectsUrl(),
                    CHtml::encode(Yii::t('tasklist', 'txt_completed_projects')) => CommonUtility::getTaskerCompletedProjectsUrl(),
                    CHtml::encode(Yii::t('tasklist', 'txt_all_projects')) => CommonUtility::getTaskerProjectsUrl(),
                            
                    )
        ));*/ ?>
        <!--Instant Navigations ends here-->
    
        <!--Filter start here-->
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h3 class="panel-title no-mrg">
                        <?php echo Yii::t('poster_createtask', 'Filter By')?> 
                            <span class="btn-u rounded btn-u-blue reset-right" id="resetLeftBar">Reset</span>
                            <div class="clr"></div>
                        </h3>                        
                    </div>                    
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">                       
                        <div class="col-md-12 no-mrg">
                            <!--Start search start here-->
                                                        
                            
                            <div class="project-filter">
                                <div id="taskerlist">
                                    
                                    <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>          
                                    <?php echo CHtml::hiddenField( 'taskType' , $taskType, array('id' => 'taskType')); ?>          
                                    <?php echo CHtml::hiddenField( 'fieltertype' , $searchtype, array('id' => 'fieltertype')); ?>          
                                    <?php echo CHtml::hiddenField( 'fieltertypeold' , $searchtype, array('id' => 'fieltertypeold')); ?>          
                                        <ul>                                            
                                            <li class="no-mrg">
                                                <span class="fielter <?php if($classDuration) echo 'active' ?>" id="duration">Duration</span><?php // echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Duration')), 'javascript:void(0)', array('id' => 'loadEndingToday' , 'class' => $endingToday)); ?>                                                
                                                <ul style="display: <?php echo $displayDuration; ?>" class="<?php echo $classDuration?>">
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($duration,'1to1') ?> id="1to1" type="checkbox"> <label for="1to1"> < 1 Day </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($duration,'1to2') ?> id="1to2" type="checkbox"> <label for="1to2"> 1 to 2 Days </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($duration,'3to4') ?> id="3to4" type="checkbox"> <label for="3to4"> 3 to 4 Days </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($duration,'5toold') ?> id="5toold" type="checkbox"> <label for="5toold"> > 5 Days </label> </li>                                           
                                                </ul>
                                            </li>
                                            <li class="no-mrg">
                                                <span class="fielter <?php if($classEnding) echo 'active' ?>" id="ending">Ending</span><?php // echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Ending')), 'javascript:void(0)', array('id' => 'loadFewProposals' , 'class' => $fewProposals)); ?>
                                                <ul style="display: <?php echo $displayEnding; ?>" class="<?php echo $classEnding?>">
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($ending,'1too1') ?> id="1too1" type="checkbox"> <label for="1too1"> Today </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($ending,'1too2') ?> id="1too2" type="checkbox"> <label for="1too2"> 1 to 2 Days </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($ending,'3too4') ?> id="3too4" type="checkbox"> <label for="3too4"> 3 to 4 Days </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($ending,'5tooold') ?> id="5tooold" type="checkbox"> <label for="5tooold"> > 5 Days </label> </li>                                                                                               
                                                </ul>
                                            </li>

                                            <?php
                                            if($isLogin)
                                            {
                                                ?>


                                            <li class="no-mrg">
                                                <span  class="fielter <?php if($classProposals) echo 'active' ?>" id="proposals">Proposals</span><?php // echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Proposals')), 'javascript:void(0)', array('id' => 'loadPreviouslyWorked' , 'class' => $previouslyWorked)); ?>
                                                <ul style="display: <?php echo $displayProposals; ?>" class="<?php echo $classProposals?>">                                                                                                                                                            
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($proposals,'0to0') ?> id="0to0" type="checkbox"> <label for="0to0"> None </label> </li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($proposals,'1to5') ?> id="1to5" type="checkbox"> <label for="1to5"> 1 to 5 Proposals</label></li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($proposals,'5to10') ?> id="5to10" type="checkbox"> <label for="5to10"> 5 to 10 Proposals</label></li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($proposals,'10toabow') ?> id="10toabow" type="checkbox"> <label for="10toabow"> > 10 Proposals</label></li>                                           
                                                </ul>
                                            </li>
                                            <li class="no-mrg">
                                                <span class="fielter <?php if($classRelationships) echo 'active' ?>" id="relationships">Relationships</span><?php // echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Relationships')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $potential)); ?>
                                                <ul style="display: <?php echo $displayRelationships; ?>" class="<?php echo $classRelationships?>">                                                                                                                                                            
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($relationships,'all') ?> id="all" type="checkbox"> <label for="all"> All</label></li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($relationships,'connected') ?> id="connected" type="checkbox"> <label for="connected">Connected</label></li>
                                                    <li><input <?php echo CommonUtility::getDefaultSelected($relationships,'work_with_before') ?> id="work_with_before" type="checkbox"> <label for="work_with_before">Worked with Before</label></li>                                         
                                                </ul>
                                            </li>
                                            <?php
                                            }
                                            ?>  
                                             <div class="clr"></div>
                                            <li class="no-mrg"><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Saved Projects')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => 'fielter '. $potential)); ?></li>

                                        </ul>
                                    </div>
                                </div>
                            <!--Start search Ends here-->  
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        </div>
        <!--Filter Ends here-->
    </div>
    <!--Left side bar ends here-->
    
    <!--Right side content start here-->
    <div class="col-md-9 right-cont">
        
        <div class="col-md-65 fixed"> 
        <div class="col-md-12 no-mrg">
            <form action="" class="sky-form">
                <div class="project-search">
                    <div class="project-search-new-1">
                        <div class="project-search3">
                            <img src="<?php echo CommonUtility::getPublicImageUri("in-searchic.png"); ?>">
                        </div>
                        <div class="project-search5">
                            <?php echo CHtml::textField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TITLE . ']', $taskName, array('id' => 'taskTitle', 'placeholder' => 'Search project', 'class' => '','autofocus' => true)); ?>
                        </div> 
                        <div class="project-search4">
                            <img style="cursor: pointer" id="cleareSearchByTaskTitle" onclick="$('#taskTitle').val('');" src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png"); ?>">
                        </div>
                    </div>
<!--                    <div class="col-md-3">
                        <?php
//                          $searchProjectOption = Globals::getProjectSearchArray();  
//                          $searchProjectValue = "";
//                          echo CHtml::dropDownList(Globals::FLD_NAME_PROJECT_SEARCH_DURATION,$searchProjectValue,$searchProjectOption,array('class' => 'form-control'));                        
                        ?>                        
                    </div>-->
                    <button type="button" id="searchByTaskTitle" class="btn-u rounded btn-u-sea">Search</button></div>
            </form>
        </div>  
        
        <div class="sortby-row margin-bottom-10"> 
                <div class="select-list">
                    <a id="gridView" onclick="girdView()" href="javascript:void(0)"><i class="fa fa-th-large"></i></a>
                    <a id="listView" style="display: none" onclick="listView()"  href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                </div>                   
                <div class="col-md-3 sortby-noti no-mrg">
                    <?php echo UtilityHtml::getSortingDropDownTaskSearch( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) , $sortVal ); ?>
                </div>
            <div class="sortby-cat btn btn-xs rounded btn-default" id="categoryClick">
                    Category                                        
                </div> 
            <div class="popover bottom in" style="top: 102px; left:435px;" id="allCategory">
                <div class="arrow"></div>
                
                <div id="loadcategory" >
                            <?php $this->renderPartial('//tasker/_getfilters', array('taskType' => $taskType,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'date' => $date , 'rating' => $rating , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'parentCategory' => $parentCategory , 'subCategoryName' => $subCategoryName , 'filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK ,'taskName' => $taskName));?>
                </div>
                
            </div>
         </div>
        </div>
        
        <div class="margin-bottom-80"></div>
        <?php //if(Yii::app()->user->hasFlash('success')):?>
        <div onclick="$('#successNotiMsg').parent().fadeOut();" style="display: none" class="alert alert-success fade fade-in-alert">
            <button onclick="$('#successNotiMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
            <div id="successNotiMsg" >
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        </div>
        <?php //endif; ?>
<!--        <div id="ui-tooltip-79" role="tooltip" class="ui-tooltip ui-widget ui-corner-all ui-widget-content" style="top: 1233.68px; left: 453px; "><div class="ui-tooltip-content">Build a new e-learning site</div></div>-->
        <div id="loadData " class="margin-bottom-30 positionRelativeClass">            
                <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmytasksdata',
                    'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.Yii::t('tasklist','No project found matching your search criteria').'.</div></div>',
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $task,
                    'itemView' => '_tasklist',
                    'enableHistory' => true,
       
                    'template'=>'<div class="found-count">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    //'summaryText' => Yii::t('tasklist','Found {start} - {end} of {count} tasks'),
                    'summaryText' => '',
                    'afterAjaxUpdate' => "function(id, data) 
                        {
                        $('html,body').animate({ scrollTop : 0 }, 'slow');
                        currentView();  $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                        }",
                    )
                );
                ?>  
            
            
            <?php
//                $this->widget('ListViewWithLoader', array(
//                    'id' => 'loadmytasksdata',
//                    'dataProvider' => $task,
//                    'itemView' => '_tasklist',
//                    'enableHistory' => true,
////                    'viewData' => array( 'model' => $model),
//                    'template'=>'{items}{pager}',
//                    'emptyText' => Yii::t('tasklist','msg_no_task_found'),
//                    'emptyTagName' => 'div class="box2"',
////                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
//                    'afterAjaxUpdate' => "function(id, data) {
//                    currentView();  $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
//                    jQuery.ias({
//                        'history':false,
//                        'triggerPageTreshold':0,
//                        'trigger':'Load more',
//                        'container':'#loadmytasksdata.list-view',
//                        'item':'.search_row',
//                        'pagination':'#loadmytasksdata .pager',
//                        'next':'#loadmytasksdata .next:not(.disabled):not(.hidden) a',
//                        'loader':'Loading...'});}",
//                    'pager' => array(
//                        'class' => 'ext.infiniteScroll.IasPager', 
//                        'rowSelector'=>'.search_row', 
//                        'itemsSelector' => '.list-view',
//                        'listViewId' => 'loadmytasksdata',
//                        'header' => '',
//                        'loaderText'=>'Loading...',
//                        'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Load more',
////                            'onRenderComplete'=> "function(items) { alert();}",
//                        ),
//                                )
//                            )
//                    );
                ?>
            <!--Tasker list ends here-->
            <div class="clr"></div>
        </div>                      
    </div>
    <!--Right side content ends here-->
    
    <div id="applyProposal"  style="display: none" class="col-md-7 sky-form apply-popup" >
    <?php
//        $this->renderPartial('//poster/_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals,   'currentUser'=>$currentUser,'bidStatus' => $bidStatus));
    ?>
 </div>
    <script>
    $(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 800) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

        </script>
<div class="scroll-to-top" style="display: none">
   <?php $this->widget('ext.scrolltop.ScrollTop',array(
        'label' => '<img width="55px" height="50px" src="'.Globals::BASE_URL_PUBLIC_IMAGE_DIR.'up.png">',
        'speed' => 'slow'
)); ?> 
</div>
