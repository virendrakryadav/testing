<?php
//$currentPageUrl = Yii::app()->createUrl('poster/mytasks/');
$currentPageUrl = CommonUtility::getMyTaskListURIAsDoer();
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

$state = (isset($_GET[Globals::FLD_NAME_TASK_STATE])) ? $_GET[Globals::FLD_NAME_TASK_STATE] : '';


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

$msg = Yii::t('tasklist','msg_no_task_found');
// for message
if($state == Globals::DEFAULT_VAL_TASK_STATUS_OPEN)
{
    $msg = 'There is no project found in <strong>Currently Hiring</strong>.';
}
if($state == Globals::DEFAULT_VAL_TASK_STATUS_FINISHED)
{
    $msg = 'There is no project found in <strong>Completed Projects</strong>.';
}
if($state == Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE)
{
    $msg = 'There is no project found in <strong>Active Projects</strong>.';
}
if($state == Globals::DEFAULT_VAL_TASK_STATUS_CANCELED)
{
    $msg = 'There is no project found in <strong>Cancel Projects</strong>.';
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
    var url = '<?php echo $currentPageUrl; ?>';
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
function searchByChildCategory( parent , id )
{
    var setnull = 0;
    var url = '';
    var sort = '?'+$('#sortDrop').serialize();
    var filterByType = $('#taskStateValue').attr('name');
    var filterByVal = $('#taskStateValue').val();   
    if(filterByType != '')
    {
        sideBarFielter = '?'+filterByType+'='+filterByVal;
        sort = '&'+$('#sortDrop').serialize();
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
    var newUrl = '<?php echo $currentPageUrl ?>';
    var  newUrl = newUrl +taskType+'/'+ parentUrl+ data + sideBarFielter + sort;
    window.History.pushState(null, document.title,newUrl);
   
}

//function girdView()
//{
//    $('#currentView').val('grid');
//    $('.search_row').addClass('list-col');
//    $('#listView').show();
//    $('#gridView').hide();
//   setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','grid');  
//}
//function listView()
//{
//    $('#currentView').val('list');
//    $('.search_row').removeClass('list-col');
//     $('#listView').hide();
//    $('#gridView').show();
//    setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','list'); 
//}
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
//$(\".categoryScroll\").mCustomScrollbar();
$('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});

function reloadFilterGrid()
{ 
    data = $('#quickFilterValue').serialize();
    var url = '".$currentPageUrl."';
    var params = $.param(data);
    //url = url.substr(0, url.indexOf('?'));
    
    
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var taskType = $('#taskType').val();   
    loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
    window.History.pushState(null, document.title,$.param.querystring(url, data));
}

function reloadFilterGridNew()
{ 
    data = $('#taskStateValue').serialize();
    var taskTitle = $('#taskTitle').serialize();
    var sortDrop = $('#sortDrop').serialize();
    var url = '".$currentPageUrl."?'+data+'&'+taskTitle+'&'+sortDrop;
    var params = $.param(data);
     

    if($('#taskStateValue').val() == '".Globals::DEFAULT_VAL_TASK_STATUS_OPEN."')
    {
        $('#msg').val('There is no project found in <strong>Currently Hiring</strong>.');
    }
    if($('#taskStateValue').val() == '".Globals::DEFAULT_VAL_TASK_STATUS_FINISHED."')
    {
        $('#msg').val('There is no project found in <strong>Completed Projects</strong>.');
    }
    if($('#taskStateValue').val() == '".Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE."')
    {
        $('#msg').val('There is no project found in <strong>Active Projects</strong>.');
    }
    if($('#taskStateValue').val() == '".Globals::DEFAULT_VAL_TASK_STATUS_CANCELED."')
    {
        $('#msg').val('There is no project found in <strong>Cancel Projects</strong>.');
    }
       
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var taskType = $('#taskType').val(); 
    loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."');
    window.History.pushState(null, document.title,url);
//    window.History.pushState(null, document.title,$.param.querystring(url, data));
   
}

$('#resetLeftBar').click(function(){
       var sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskTitle').serialize();
       var url = '".$currentPageUrl."'+sort;
          
      window.History.pushState(null, document.title,url); 
    
    $('.project-filter input[type=checkbox]').removeAttr('checked');                                 
    $('#'+$('#fieltertype').val()).next('ul').hide();
    $('#tasklist ul li a').removeClass('active'); 
    $('#tasklist ul li a').first().addClass('active'); 
 });

function reloadFilterByForm()
{
    var form = $(this).closest('form').attr('id');
    $.fn.yiiListView.update('loadmytasksdata', {data: $('#'+form).serialize()});
}
//$('#taskType').change(function()
//{ 
//    var taskType = $(this).val();   
//    var url = '".$currentPageUrl."';
//    if( taskType != '".Globals::DEFAULT_VAL_TASK_TYPE."' )
//    {
//        url = url + taskType;
//    }
//    window.History.pushState(null, document.title,url);
//   
//        loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
//        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
//        removeActiveMenu();
//        return false; 
//});

$('body').delegate('#searchByTaskTitle','click',function()
{
 var data = $('#taskTitle').serialize();    
            SearchFunc(data);  
            //SearchByDuration($('#duration').val());
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
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
    var sort = '?'+$('#sortDrop').serialize();
    var filterByType = $('#taskStateValue').attr('name');
    var filterByVal = $('#taskStateValue').val();   
    if(filterByType != '')
    {
        sideBarFielter = '?'+filterByType+'='+filterByVal;
        sort = '&'+$('#sortDrop').serialize();
    }
    var parentCatId = $(this).data('id'); 
  // alert(parentCatId);
    var data = $(this).attr('href'); 
    var taskType = $('#taskType').val();
    var params = $.param(data);
    var url = '".$currentPageUrl."';
    url = url + taskType + data + sideBarFielter + sort;
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
    var url = '".$currentPageUrl."';
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
//$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid();  removeActiveMenu(); activeMenu(this); });


$('a#loadmytasksAll').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_NULL."'); reloadFilterGridNew(); removeActiveMenu(); activeMenu(this);});
$('a#loadmytasksOpen').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_OPEN."'); reloadFilterGridNew();removeActiveMenu(); activeMenu(this); });
$('a#loadmytasksClose').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_FINISHED."'); reloadFilterGridNew(); removeActiveMenu(); activeMenu(this);});
$('a#loadmytasksAwarded').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE."'); reloadFilterGridNew();removeActiveMenu(); activeMenu(this); });
$('a#loadmytasksCancel').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_CANCELED."'); reloadFilterGridNew();removeActiveMenu(); activeMenu(this); });
   


$('#loadEndingToday').click(function()
{ 
$('#quickFilterValue').val('".Globals::FLD_NAME_ENDING_TODAY."'); 
    reloadFilterGrid();
    removeActiveMenu(); 
    activeMenu(this);
    });
     
//$('.project-filter input[type=checkbox]').click(function()
//{       
//    resetDate();    
//    var type = $('#fieltertype').val();
//    if($(this).attr('checked') == 'checked')
//    {  
//        searchByDuration += $(this).attr('id')+'-';
//    }  
//    if($(this).attr('checked') != 'checked')
//    {          
//      searchByDuration = searchByDuration.replace($(this).attr('id')+'-', '');       
//    }   
////     searchByDuration = type+'='+searchByDuration;  
////     SearchFunc(searchByDuration);
//            
//    var url = '".$currentPageUrl."?'+type+'=';
//    url = url+searchByDuration;
//    window.History.pushState(null, document.title,url);      
//});


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
        searchByDuration = '';
        $('.project-filter input[type=checkbox]').removeAttr('checked'); 
        $('#fieltertype').val($(this).attr('id'));
        $('.showing').hide();        
        $(this).next('ul').show();        
        $(this).next('ul').addClass('showing');
    });      
    $('#categoryClick').click(function(){             
        $('#allCategory').show();                
    });  
    currentView();
    $('#msgshow').html($('#msg').val());
"
);
?>
<input type="hidden" id="msg" name="msg" value="<?php echo $msg;?>">
<div class="container content">
    <!--Left side bar start here-->
    <div class="col-md-3 leftbar-fix">
        <!--Dashbosrd start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashbosrd start here-->
        
        <!--Instant Navigations starts here-->
        <?php
//        $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
//                array(
//                    CHtml::encode(Yii::t('tasklist', 'txt_applied_to')) => '#',
//                    CHtml::encode(Yii::t('tasklist', 'txt_saved_projects')) => '#',
//                    CHtml::encode(Yii::t('tasklist', 'txt_active_projects')) => '#',
//                    CHtml::encode(Yii::t('tasklist', 'txt_completed_projects')) => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=f',
//                    CHtml::encode(Yii::t('tasklist', 'txt_all_projects')) => Yii::app()->createUrl('tasker/mytasks'),
//                            
//                    )
//        )); 
        ?>
        <!--Instant Navigations ends here-->
      <?php /* $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
                array(
                    CHtml::encode(Yii::t('tasklist', 'Search Projects')) => Yii::app()->createUrl('public/tasks'),
                )
        ));*/ ?>
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
                                                        
                                                        
                                <div class="message-filter">
                                    <div id="tasklist">
                                    <?php
                                    $all = ($state == Globals::DEFAULT_VAL_NULL) ? 'active' : '' ;
                                    $statusOpen = ($state == Globals::DEFAULT_VAL_TASK_STATUS_OPEN) ? 'active' : '' ;
                                    $statusFinished = ($state == Globals::DEFAULT_VAL_TASK_STATUS_FINISHED) ? 'active' : '' ;
                                    $statusAwarded = ($state == Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE) ? 'active' : '' ;
                                    $statusCancel = ($state == Globals::DEFAULT_VAL_TASK_STATUS_CANCELED) ? 'active' : '' ;
                                    ?>
                                        <?php echo CHtml::hiddenField( 'taskType' , $taskType, array('id' => 'taskType')); ?>  
                                        <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
                                        <?php // echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_NULL, array('id' => 'taskStateValue')); ?>
                                        <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK_STATE, Globals::DEFAULT_VAL_NULL, array('id' => 'taskStateValue')); ?>

                                        <ul>
                                            
                                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Applied To')), 'javascript:void(0)', array('id' => 'loadmytasksOpen' , 'class' => $statusOpen)); ?></li>
                                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Active Projects')), 'javascript:void(0)', array('id' => 'loadmytasksAwarded' , 'class' => $statusAwarded)); ?></li>
                                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Completed Projects')), 'javascript:void(0)', array('id' => 'loadmytasksClose' , 'class' => $statusFinished)); ?></li>
                                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Cancel Projects')), 'javascript:void(0)', array('id' => 'loadmytasksCancel' , 'class' => $statusCancel)); ?></li>
                                            <li> <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'All Projects')), 'javascript:void(0)', array('id' => 'loadmytasksAll' , 'class' => $all )); ?></li>

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
                    <?php echo UtilityHtml::getSortingDropDownTaskSearchForDoer( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) , $sortVal ); ?>
                </div>
            <div class="sortby-cat btn btn-xs rounded btn-default" id="categoryClick">
                    Category                                        
                </div> 
            <div class="popover bottom in" style="top: 102px; left:435px;" id="allCategory">
                <div class="arrow"></div>
<!--                                <input type="hidden" value="/a" name="taskType" id="taskType">-->
                <div id="loadcategory" >
                            <?php $this->renderPartial('//tasker/_getfilters', array('taskType' => $taskType,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'date' => $date , 'rating' => $rating , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'parentCategory' => $parentCategory , 'subCategoryName' => $subCategoryName , 'filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK ,'taskName' => $taskName));?>
                </div>
                
            </div>
         </div>
        </div>
        <div class="margin-bottom-80"></div>
        <?php if(Yii::app()->user->hasFlash('success')):?>
        <div onclick="$('#successNotiMsg').parent().fadeOut();" class="alert alert-success fade fade-in-alert">
            <button onclick="$('#successNotiMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
            <div id="successNotiMsg" >
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        </div>
        <?php endif; ?>
        <div id="loadData " class="margin-bottom-30 positionRelativeClass">            
                <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmytasksdata',
                    'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in" id="msgshow">'.Yii::t('tasklist','No project found matching your search criteria').'.</div></div>',
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $mytasklist,
                    'itemView' => '_mytasks',
                    'enableHistory' => true,
       
                    'template'=>'<div class="found-count">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    //'summaryText' => Yii::t('tasklist','Found {start} - {end} of {count} tasks'),
                    'summaryText' => '',
                    'afterAjaxUpdate' => "function(id, data) 
                        {
                        $('#msgshow').html($('#msg').val());
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
<div id="applyProposal"  style="display: none" class="col-md-7 sky-form apply-popup" >
    <?php
//        $this->renderPartial('//poster/_proposal', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'isProposed' => $isProposed, 'proposals' => $proposals,   'currentUser'=>$currentUser,'bidStatus' => $bidStatus));
    ?>
 </div>