<script>
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
function loadproposalsfilters( taskerName , rating , maxPriceValue , minPriceValue , maxPrice , minPrice , isFieldAccessByTaskTypeVirtual)
{
//    jQuery.ajax({
//        'dataType':'json',
//        'data':{'taskerName': taskerName , 'rating' : rating, 'maxPriceValue' : maxPriceValue, 'minPriceValue' : minPriceValue, 'maxPrice' : maxPrice, 'minPrice' : minPrice , 'isFieldAccessByTaskTypeVirtual' : isFieldAccessByTaskTypeVirtual},
//        'type':'POST',
//        'success':function(data)
//        {
//            if(data.status==='success')
//            {
//            $('#loadproposalfilters').html(data.html);
//            }
//            else
//            {
//                alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
//            }
//        },
//        'url':'<?php echo Yii::app()->createUrl('poster/getproposalslistfilters') ?>','cache':false});
        return false; 
}
</script>
<?php
$maxPriceValue = isset($_GET[Globals::FLD_NAME_MAXPRICE]) ? $_GET[Globals::FLD_NAME_MAXPRICE] : $maxPrice;
$minPriceValue = isset($_GET[Globals::FLD_NAME_MINPRICE]) ? $_GET[Globals::FLD_NAME_MINPRICE] : $minPrice;
$rating = (isset($_GET[Globals::FLD_NAME_RATING])) ? $_GET[Globals::FLD_NAME_RATING] : '' ;
$taskerName = (isset($_GET[Globals::FLD_NAME_USER_NAME])) ? $_GET[Globals::FLD_NAME_USER_NAME] : '' ;
$interest = isset($_GET[Globals::FLD_NAME_INTEREST]) ? $_GET[Globals::FLD_NAME_INTEREST] : '';
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;

$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});

$isFieldAccessByTaskTypeVirtual = CommonUtility::isFieldAccessByTaskTypeVirtual($task->{Globals::FLD_NAME_TASK_KIND});
Yii::import('ext.chosen.Chosen');

Yii::app()->clientScript->registerScript('searchMyPoposals', "
                            
var ajaxUpdateTimeout;
var ajaxRequest;
var val;
var pageUrl = '".CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID})."';
var hasToRun = 0;
$('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
$(\".categoryScroll\").mCustomScrollbar();
$('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});

function reloadFilterGrid()
{ 
    data = $('#quickFilterValue').serialize();
    var url = pageUrl;
    var params = $.param(data);
    //url = url.substr(0, url.indexOf('?'));
    $('#taskType').val('".Globals::DEFAULT_VAL_TASK_TYPE."');
    var taskType = $('#taskType').val();   
   // loadcategoryfiltes( taskType ,'".$maxPrice."' ,'".$minPrice."' )
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."');
    loadproposalsfilters( '".$taskerName."' , '".$rating."' , '".$maxPriceValue."' , '".$minPriceValue."' ,'".$maxPrice."', '".$minPrice."' , '".$isFieldAccessByTaskTypeVirtual."');
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
    var url = pageUrl;
    if( taskType != '".Globals::DEFAULT_VAL_TASK_TYPE."' )
    {
        url = url + taskType;
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
            
        return false; 
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
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."');
});


$('body').delegate('.categoryScroll .advnc_row3 a','click',function()
{
    var catId = $(this).attr('id'); 
    var data = $(this).attr('href'); 
    var taskType = $('#taskType').val();
    var params = $.param(data);
   var url = pageUrl;
    url = url + taskType + data;
    window.History.pushState(null, document.title,url);
    return false;
});

$('body').delegate('a#resetFilter','click',function()
{
    var url = pageUrl;
    window.History.pushState(null, document.title,url);
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."' , 'reset');
    removeActiveMenu();
        loadproposalsfilters( '".$taskerName."' , '".$rating."' , '".$maxPriceValue."' , '".$minPriceValue."' ,'".$maxPrice."', '".$minPrice."' , '".$isFieldAccessByTaskTypeVirtual."');

    return false; 
        
    
});

$('body').delegate('#searchByTaskName','click',function()
{
            var data = $('#taskerName').serialize();    
            SearchFunc(data);
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."');
            });
$('a#loadHired').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_STATUS."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadNearby').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_IN_RANGE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadHighlyrated').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_RANK."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadMostValued').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_PROPOSED_COST."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadInvited').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_SELECTION_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPremiumTask').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('#interest').click(function() 
    {
        if($(\"input:checkbox[name='".Globals::FLD_NAME_INTEREST."']\").is(\":checked\")) 
        {
            var data = $('#interest').serialize();    
            SearchFunc(data);
        }
        else
        {
            var data = 'interest=';    
            SearchFunc(data);
        }
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
        $.fn.yiiListView.update('loadAllProposals', {data: $('#'+form).serialize()});
        }
    });
    

    $('#sortDrop').change(function(){  
        var data = $(this).serialize();    
            SearchFunc(data); 
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."');
    });
"
);

?> 
<?php echo CommonScript::loadCreateTaskScript() ?>
<div class="page-container pagetopmargn">
   

    <!--Left side bar start here-->
    <div class="leftbar">
    
        <!--task type start here-->
    <?php
            $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER ));
            ?>
    <!--task type ends here-->
        <!--Filter start here-->
        <div class="box">
            <div class="filter_tophead"><h3 class="filtertitle"><?php echo Yii::t('poster_createtask', 'Filter')?></h3>
            </div>
            
                <div id="loadactionfilter">
                <?php 
            $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS ,'action_url' => Yii::app()->createUrl('tasker/savefiltertaskproposalform')));
                ?>
            </div>
            
            <div class="filter_cont">
                <!--Start search start here-->
                <div class="smartsearch">
                  
                <?php 
                $hired = ($quickFilter == Globals::FLD_NAME_TASKER_STATUS) ? 'activeCategory' : '' ;
               
                $premium = ($quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE) ? 'activeCategory' : '' ;
                $nearby = ($quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE) ? 'activeCategory' : '' ;
                $rated = ($quickFilter == Globals::FLD_NAME_TASK_DONE_RANK) ? 'activeCategory' : '' ;
                $bookmark = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'activeCategory' : '' ;
                $mostvalued = ($quickFilter == Globals::FLD_NAME_TASKER_PROPOSED_COST) ? 'activeCategory' : '' ;
                 $invited = ($quickFilter == Globals::FLD_NAME_SELECTION_TYPE) ? 'activeCategory' : '' ;
        
                    echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>          
                <ul>
                    <li> <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previously hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired )); ?> </li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Premium task')), 'javascript:void(0)', array('id' => 'loadPremiumTask' , 'class' => $premium)); ?></li>
                        <?php
                        if( $isFieldAccessByTaskTypeVirtual )
                        {
                            ?>
                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Nearby')), 'javascript:void(0)', array('id' => 'loadNearby' , 'class' => $nearby)); ?></li>
                            <?php
                        }
                        ?>
                    <li> <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Highly rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?> </li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $bookmark)); ?></li>
                    <li>  <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most valued')), 'javascript:void(0)', array('id' => 'loadMostValued' , 'class' => $mostvalued)); ?> </li>
                    <li>  <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Invited')), 'javascript:void(0)', array('id' => 'loadInvited' , 'class' => $invited)); ?> </li>
                </ul>
                </div>
                <div id="loadproposalfilters">
                <?php   $this->renderPartial('_viewallproposalsfilters',array('rating' => $rating, 'taskerName' => $taskerName , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'maxPrice' => $maxPrice , 'minPrice' => $minPrice , 'isFieldAccessByTaskTypeVirtual' => $isFieldAccessByTaskTypeVirtual)); ?>
                </div>
            </div>
        </div>
        <!--Filter tast Ends here-->

        <!--Template Category start here-->
        <div class="box">
            <div class="box_topheading"><h3 class="h3"><?php echo Yii::t('poster_createtask', 'My tasks')?></h3></div>
            <div id="loadTemplateCategory" class="box2">
                <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmytasksdata',
                    'dataProvider' => $myTasks,
                    'itemView' => '_tasklistsidebar',
                    'template'=>'{items}',
                    ));
                ?>
            </div>
        </div>
        <!--Template Category tast Ends here-->

    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    
    <div class="rightbar">
     <!--Top proposal start here-->
     <?php   $this->renderPartial('//tasker/_taskdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel)); ?>
    <!--Top proposal ends here-->
        <div class="box">
            <div class="box_topheading">
                <h3 class="h3"><?php echo Yii::t('poster_createtask', 'Proposals list')?></h3></div>
            <div class="sortby_row">
                <div class="ntointrested"><?php echo CHtml::checkBox(Globals::FLD_NAME_INTEREST, $interest, array('id'=>'interest'));?> <?php echo Yii::t('poster_createtask', 'Show not interested')?></div>                      
                <div class="sortby">
                <?php echo UtilityHtml::getSortingDropDownProposalList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'span2' ) ); ?> 
                </div>
            </div>
             <div id="loadData " class="positionRelativeClass">
                <?php

                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadAllProposals',
                    'emptyText' => Yii::t('tasklist','No proposal found matching your search criteria'),
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $proposals,
                    'viewData' => array('dataProvider' => $proposals, 'task' => $task, 'taskLocation' => $taskLocation , 'isTaskCancel' => $isTaskCancel ,'proposalIds' => $proposalIds ),

                    'itemView' => '_viewallproposals',
                    'enableHistory' => true,
       
                    'template'=>'<div class="box6">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    'summaryText' => Yii::t('tasklist','Found {count} proposals'),
                    'afterAjaxUpdate' => "function(id, data) {
                                                $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                            }",
                    )
                );
                ?>
            </div>
        </div>        
    </div>
</div>


