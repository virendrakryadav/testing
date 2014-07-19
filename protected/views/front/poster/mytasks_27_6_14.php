<?php echo CommonScript::loadCreateTaskScript() ?>
<?php
$date = '';
$maxdate = isset($_GET["maxdate"]) ? $_GET["maxdate"] : '';
$mindate = isset($_GET["mindate"]) ? $_GET["mindate"] : '';

$maxPriceValue = isset($_GET["maxprice"]) ? $_GET["maxprice"] : $maxPrice;
$minPriceValue = isset($_GET["minprice"]) ? $_GET["minprice"] : $minPrice;
$taskType = (isset($_GET["taskType"])) ? $_GET["taskType"] : '' ;
$categoryName = (isset($_GET[Globals::FLD_NAME_CATEGORYNAME])) ? $_GET[Globals::FLD_NAME_CATEGORYNAME] : '' ;
$parentCategory = CommonUtility::getCategoryIdFromString($categoryName);
$subCategoryName = (isset($_GET[Globals::FLD_NAME_SUBCATEGORYNAME])) ? $_GET[Globals::FLD_NAME_SUBCATEGORYNAME] : '' ;
if(isset($_GET["maxdate"]) && isset($_GET["mindate"]) )
{
    $date = CommonUtility::formatedViewDate( $_GET["mindate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH )." - ".CommonUtility::formatedViewDate( $_GET["maxdate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH );
}
$rating = (isset($_GET["rating"])) ? $_GET["rating"] : '' ;
$state = (isset($_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE])) ? $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE] : '' ;
$taskName = (isset($_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE])) ? $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE] : '' ;
?>
<script>
//function cancelTask(taskId)
//{
////    if(!confirm('<?php echo Yii::t('tasker_mytasks','Are you sure to cancel this task !!!') ?>'))
////    {
////        return false;
////    }
////    
//    jQuery.ajax({
//    'dataType':'json',
//    'data':{'taskId':taskId},
//    'beforeSend':function(){$("#canceltask"+taskId).addClass("loading");},
//    'complete':function(){$("#canceltask"+taskId).removeClass("loading");},
//    'type':'POST',
//    'success':function(data)
//    {
//        if(data.status==='success')
//        {
//            // $.fn.yiiListView.update( 'loadmypostedtask');
//            loadpopup(data.html);
//        }
//        else
//        {
//            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
//        }
//    },
//    'url':'<?php echo Yii::app()->createUrl('poster/canceltaskform') ?>','cache':false});return false; 
//}
function editTask(taskId , categoryId , taskType)
{
    jQuery.ajax({
                    'beforeSend':function(){$("#edittask"+taskId).addClass("loading");},
                    'complete':function(){$("#edittask"+taskId).removeClass("loading");},
                    'dataType':'json','data':{'taskId':taskId,'category_id':categoryId,'formType':taskType,'onlyform':'1'},
                    'type':'POST',
                    'success':function(data){ loadpopup(data.form , '' , 'formedit'); },
                    'url':'<?php echo Yii::app()->createUrl('poster/edittask') ?>',
                    'cache':false
                });
    return false;
}
function SearchFunc(data)   
{

var url = document.URL;
//alert(url);
var params = $.param(data);
//url = url.substr(0, url.indexOf('?'));
window.History.pushState(null, document.title,$.param.querystring(url, data));
}
function SearchByDate(start, end)   
{
        var url = document.URL;
        var data = "mindate=" + start.format("<?php echo Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH ?>" )  + "&maxdate=" + end.format( "<?php echo Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH ?>" )  ;
        var params = $.param(data);
        window.History.pushState(null, document.title,$.param.querystring(url, data)); 
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
    var newUrl = '<?php echo Yii::app()->createUrl('poster/mytasks') ?>';
    var  newUrl = newUrl +'/'+taskType+'/'+ parentUrl+ data;
    window.History.pushState(null, document.title,newUrl);
   
}
</script>
<?php
Yii::app()->clientScript->registerScript('searchMytasks', "
                            
var ajaxUpdateTimeout;
var ajaxRequest;
var val;
var hasToRun = 0;
$('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
var pageUrl = '".Yii::app()->createUrl('poster/mytasks')."';

$(\".categoryScroll\").mCustomScrollbar();
$('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});

function reloadFilterGrid()
{ 
    data = $('#taskStateValue').serialize();
    var url = pageUrl;
    var params = $.param(data);
     
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var taskType = $('#taskType').val();   
    loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."');
    window.History.pushState(null, document.title,$.param.querystring(url, data));
}
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
    
     loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."');
});
$('body').delegate('a#resetFilter','click',function()
{
    var taskType =  '".Globals::DEFAULT_VAL_TASK_TYPE."';
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var url = pageUrl;
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
        },
        'url':'". Yii::app()->createUrl('tasker/getcategories') ."','cache':false});
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."' , 'reset');
        removeActiveMenu();
        return false; 
        
    
});
$('a#loadmytasksAll').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_NULL."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadmytasksOpen').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_OPEN."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadmytasksClose').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_FINISHED."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadmytasksAwarded').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadmytasksCancel').click(function(){ $('#taskStateValue').val('".Globals::DEFAULT_VAL_TASK_STATUS_CANCELED."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
    
$('#taskType').change(function()
{ 
    var taskType = $(this).val();   
   var url = pageUrl;
    if( taskType != '".Globals::DEFAULT_VAL_TASK_TYPE."' )
    {
        url = url +'/'+ taskType;
    }
    window.History.pushState(null, document.title,url);
    jQuery.ajax({
        //'dataType':'json',
        'data':{'taskType':taskType , 'maxPrice' : ".$maxPrice." ,'minPrice' : ".$minPrice."},
        'type':'POST',
        'success':function(data)
        {
            $('#loadcategory').html(data);
            $(\".categoryScroll\").mCustomScrollbar();
            $('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});
        },
        'url':'". Yii::app()->createUrl('tasker/getcategories') ."','cache':false});
        loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."');
        removeActiveMenu();
        return false; 
});
$('body').delegate('#searchByTaskTitle','click',function()
{
 var data = $('#taskTitle').serialize();    
            SearchFunc(data);  
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."');
            });
$('body').delegate('.categoryScroll .advnc_row3 a','click',function()
{
    var catId = $(this).attr('id'); 
    var parentCatId = $(this).data('id'); 
  // alert(parentCatId);
    var data = $(this).attr('href'); 
    var taskType = $('#taskType').val();
    var params = $.param(data);
    var url = pageUrl;
    url = url + '/'+taskType + data;
    window.History.pushState(null, document.title,url);
    removeActiveMenu();
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
            loadaftercategoriesfilter( '".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."' , '".$maxPrice."' , '".$minPrice."');
        }
        else
        {
            alert('".Yii::t('tasker_createtask','unexpected_error')."');
        }
        },
        'url':'". Yii::app()->createUrl('tasker/getsubcategories') ."','cache':false});
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS."'); 
        return false; 
});


$('#sortDrop').change(function(){  

var data = $(this).serialize();    
            SearchFunc(data);  
//$.fn.yiiListView.update(\"loadmypostedtask\",{data:{sort:$(this).val()},type:\"POST\"})  

});
"
);
                        ?>
<div class="container content">
    
  
    <!--Left side bar start here-->
    <div class="col-md-3">
    <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>

    <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER 
        , 'menusLinks' => 
           array(
                    'Completed tasks' => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=f',
                   
                    'Favorite Posters' => '#'
               )
        )); ?>

        <!--Filter start here-->
    <div class="margin-bottom-30">
        <div id="accordion" class="panel-group">
            <div class="panel panel-default margin-bottom-20 sky-form">
                <div class="panel-heading">
                    <h3 class="panel-title no-mrg">
                    <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Filter'));?>
                    <span class="accordian-state"></span></a>
                    </h3>
                </div>
                <div class="panel-collapse collapse in sky-form" id="collapseOne">
<!--            <div class="filter_tophead"><h3 class="filtertitle">Filter</h3> </div>  -->
                    <!--Save filter start here-->

                    <div id="fltbtn_cont">
                        <?php $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS ,'action_url' => Yii::app()->createUrl('poster/filterformmytasks'))); ?>
                    </div>
                    <div class="filter_cont">
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
                                <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_NULL, array('id' => 'taskStateValue')); ?>

                                <ul>
                                    <li> <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_all')), 'javascript:void(0)', array('id' => 'loadmytasksAll' , 'class' => $all )); ?></li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_open')), 'javascript:void(0)', array('id' => 'loadmytasksOpen' , 'class' => $statusOpen)); ?></li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_close')), 'javascript:void(0)', array('id' => 'loadmytasksClose' , 'class' => $statusFinished)); ?></li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_awarded')), 'javascript:void(0)', array('id' => 'loadmytasksAwarded' , 'class' => $statusAwarded)); ?></li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_cancel')), 'javascript:void(0)', array('id' => 'loadmytasksCancel' , 'class' => $statusCancel)); ?></li>
                                </ul>
                            </div>
                        </div>
                        <!--Start search Ends here-->

                        <!--Advance filter Start here--> 
                        <?php echo CHtml::beginForm("#", 'get', array('id' => 'filter-form-porposals')); ?>  
                        <div class="advncsearch">
                            <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_mytasks', 'Task type')?></div>
                            <div class="col-md-12 pdn-auto">
                                <div class="col-md-12 no-mrg">
                                    <?php  UtilityHtml::getTaskTypeDropDown( "taskType" , (isset($_GET["taskType"])) ? $_GET["taskType"] : ''   ); ?>
                                </div>
                            </div>
                        </div> 

                        <div id="loadcategory" >
                            <?php $this->renderPartial('//tasker/_getfilters', array('taskType' => $taskType,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'date' => $date , 'rating' => $rating , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'parentCategory' => $parentCategory , 'subCategoryName' => $subCategoryName ,  'filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS ,'taskName' => $taskName));?>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <!--Advance filter Ends here-->     
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--Filter tast Ends here-->


    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
<!--            <div class="box_topheading">-->
                <h3 class="h2 text-30a"><?php echo Yii::t('poster_mytasks', 'My Posted Projects') ?></h3>
<!--    </div>-->
       <div class="margin-bottom-30">
            <div class="sortby-row margin-bottom-20" style="display: <?php if($mytasklist->getTotalItemCount() > 0 ) echo 'block'; else echo 'none'; ?>" class="sortby_row">                                                               
<!--                <div class="ntointrested">Found 50 results</div>-->
                <div class="col-md-3 sortby-noti no-mrg">
                     <?php echo UtilityHtml::getSortingDropDownTaskSearch( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ); ?>
                </div>
            </div> 
            <div class="col-md-12 no-mrg">
            <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmypostedtask',
                    'emptyText' => Yii::t('poster_mytasks','msg_no_tasks'),
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $mytasklist,
                    'itemView' => '_mytasks',
                     'enableHistory' => true,
                    'summaryText' => Yii::t('tasklist','Found {count} projects'),
                    'template'=>'<div id="summerytesxt" class="box5" style="margin-top:-15px;">{summary}</div>{items}{pager}',
                     'afterAjaxUpdate' => "function(id, data) {
                                                    $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                                    $('div.total_task4 input').rating({'readOnly':true});
                                                  if($('#summerytesxt').html() == '')
                                                  {
                                                    
                                                    $('#sorterRow').css('display', 'none');
                                                  }
                                                  else
                                                  {
                                                    $('#sorterRow').css('display', 'block');
                                                  }
                                            }",
                    ));
                ?> 
            </div>     
        </div>
        <div class="clr"></div>
   
    </div>
    <!--Right side content ends here-->



</div>