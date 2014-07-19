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
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;
$taskName = (isset($_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE])) ? $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE] : '' ;


if(isset($_GET["maxdate"]) && isset($_GET["mindate"]) )
{
    $date = CommonUtility::formatedViewDate( $_GET["mindate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH )." - ".CommonUtility::formatedViewDate( $_GET["maxdate"] , Globals::DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH );
}
$rating = (isset($_GET["rating"])) ? $_GET["rating"] : '' ;
?>
<script>

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
   
}





</script>
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
    var parentCatId = $(this).data('id'); 
  // alert(parentCatId);
    var data = $(this).attr('href'); 
    var taskType = $('#taskType').val();
    var params = $.param(data);
    var url = '".CommonUtility::getTaskListURI()."';
    url = url + taskType + data;
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
        },
        'url':'". Yii::app()->createUrl('tasker/getcategories') ."','cache':false});
        loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."' , 'reset');
        removeActiveMenu();
        return false; 
        
    
});
$('a#loadPreviouslyWorked').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PREVIOUSLY_WORKED."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadNearBy').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_IN_RANGE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadHighlyRated').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_RANK."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadMostValued').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PRICE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPremiumTask').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid();  removeActiveMenu(); activeMenu(this); });


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
"
);
?>
<div class="page-container pagetopmargn">

    <!--Left side bar start here-->
    <div class="leftbar">
    
   <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER  , 'menusLinks' => 
           array(
                    'Completed tasks' => Yii::app()->createUrl('tasker/mytasks').'?Task[state]=f',
                    'All tasks' => Yii::app()->createUrl('tasker/mytasks'),
                    'Favorite Posters' => '#'
               )
   )); ?>
    <!--task type ends here-->
    
        <!--Filter start here-->
        <div class="box">
            <div class="filter_tophead"><h3 class="filtertitle"><?php echo Yii::t('tasklist', 'Filter') ?></h3> </div>
            <div id="loadactionfilter">
                <?php if($isLogin)
            {
                $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK ,'action_url' => Yii::app()->createUrl('tasker/savefilterform')));
            }
            ?>
            </div>
          <!--Save filter ends here-->
          
            <div class="filter_cont">
            <!--Start search start here-->
            <div class="smartsearch">
     <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>          
<ul>
    <?php 
        $previouslyWorked = ($quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED) ? 'activeCategory' : '' ;
        $potential = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'activeCategory' : '' ;
        $premium = ($quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE) ? 'activeCategory' : '' ;
    if($isLogin)
    {
        
       // $previouslyWorked = ($quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED) ? 'activeCategory' : '' ;
        ?>
    <li>
        <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previously worked')), 'javascript:void(0)', array('id' => 'loadPreviouslyWorked' , 'class' => $previouslyWorked)); ?>
        
    </li>
    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $potential)); ?></li>
    <?php
    }
    ?>
    
    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Premium task')), 'javascript:void(0)', array('id' => 'loadPremiumTask' , 'class' => $premium)); ?></li>
<!--    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Nearby')), 'javascript:void(0)', array('id' => 'loadNearBy')); ?></li>
    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Highly rated')), 'javascript:void(0)', array('id' => 'loadHighlyRated')); ?></li>
    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most valued')), 'javascript:void(0)', array('id' => 'loadMostValued')); ?></li>-->
    
</ul>
            </div>
            <!--Start search Ends here-->
            
   <!--Advance filter Start here--> 
 <?php echo CHtml::beginForm("#", 'get', array('id' => 'filter-form-porposals')); ?>  

       

<div class="advncsearch">
<div class="advnc_row"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Task type'));?></div>
<div class="advnc_row2">
<div class="advnc_col3"><?php  UtilityHtml::getTaskTypeDropDown( "taskType" , (isset($_GET["taskType"])) ? $_GET["taskType"] : ''   ); ?></div>
</div>
</div> 

<div id="loadcategory" >
<?php $this->renderPartial('_getfilters', array('taskType' => $taskType,  'maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'date' => $date , 'rating' => $rating , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'parentCategory' => $parentCategory , 'subCategoryName' => $subCategoryName , 'filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK ,'taskName' => $taskName));?>
</div>
<!--<div class="advncsearch">
    <div class="advnc_row">Location</div>
    <div class="advnc_row2">
        <div class="advnc_col3">
            <?php
//            $locations = CommonUtility::getCountryList();
//            $locationList = '';
//            $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
//            echo Chosen::multiSelect("taskLocations", $locationList, $locations, array(
//                'data-placeholder' => $placeholder,
//                'options' => array('displaySelectedOptions' => false,),
//                'class' => 'span2',
//                'onchange' => '  var form = $(this).closest(\'form\').attr(\'id\');$.fn.yiiListView.update(\'loadmytasksdata\', {data: $(\'#\'+form).serialize()});'
//            ));
            ?>
        </div>
    </div>
</div> -->

<?php echo CHtml::endForm(); ?>
   <!--Advance filter Ends here-->     
            </div>
        </div>
        <!--Filter tast Ends here-->
    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar">
        <div class="box">
            <div class="box_topheading">
              <h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Task list'));?></h3></div>
                <div class="sortby_row">
<!--                    <div class="ntointrested">Found 50 results</div>                      -->
                    <div class="sortby">  <?php echo UtilityHtml::getSortingDropDownTaskSearch( "sort" , array( 'id' => 'sortDrop' , 'class' => 'span2' ) ); ?> </div>
                </div>
                <div id="loadData " class="positionRelativeClass">
                <?php

                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmytasksdata',
                    'emptyText' => Yii::t('tasklist','msg_no_task_found'),
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $task,
                    'itemView' => '_tasklist',
                    'enableHistory' => true,
       
                    'template'=>'<div class="box5">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    'summaryText' => Yii::t('tasklist','Found {start} - {end} of {count} tasks'),
                    'afterAjaxUpdate' => "function(id, data) {
                                                $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                            }",
                    )
                );
                ?>
                    <?php
//$jo='[{"id":1,"name":"jack","age":10,"sex":"male"},{"id":2,"name":"jill","age":8,"sex":"female"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"}
//    ,{"id":3,"name":"asdassfdadfdjhon","age":5,"sex":"male"},{"id":3,"name":"jhsdfsdfon","age":5,"sex":"male"},{"id":3,"name":"jhtyutyutyuton","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"}
//    ,{"id":3,"name":"jh.,m.mon","age":5,"sex":"male"},{"id":3,"name":"jhogfggfhn","age":5,"sex":"male"},{"id":3,"name":"jytutyutyuhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"}
//    ,{"id":3,"name":"jhouyiuin","age":5,"sex":"male"},{"id":3,"name":"jasdasdhon","age":5,"sex":"male"},{"id":3,"name":"..,m.m,.n.jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"},{"id":3,"name":"jhon","age":5,"sex":"male"}]'; 
//
//$po=json_decode($jo); //brings array of objects.
//
//$dataProvider=new CArrayDataProvider($po, array(
//    
//    'sort'=>array(
//        'attributes'=>array(
//             'id', 'name', 'age',
//        ),
//    ),
//    'pagination'=>array(
//        'pageSize'=>3,
//    ),
//));
//
//$this->widget('ListViewWithLoader', array(
//        'dataProvider'=>$dataProvider,
//        'itemView'=>'_viewtest',
//)); 
?>
            </div>
        </div>        
    </div>
</div>
    <!--Right side content ends here-->

