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
function activeMenu(id)
{
$(id).addClass('active');
}
function removeActiveMenu(id)
{
// alert(id);
if(id)
$(id).removeClass('active');
else
$('#collapseOne .active').removeClass('active');
}  
</script>
<?php
//CommonUtility::updateTaskAverageExperience();
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
//$('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
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
$('a#loadMostExperienced').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_CNT."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
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
    $('#resetLeftBar').click(function(){
       var url = pageUrl;
    window.History.pushState(null, document.title,url);
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."' , 'reset');
    removeActiveMenu();
        loadproposalsfilters( '".$taskerName."' , '".$rating."' , '".$maxPriceValue."' , '".$minPriceValue."' ,'".$maxPrice."', '".$minPrice."' , '".$isFieldAccessByTaskTypeVirtual."');

    return false; 
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
<div class="container content ">
    <!--Left side bar start here-->
    <div class="col-md-3 leftbar-fix"">
        <!--erandoo start here-->
            <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--erandoo end here-->
         <div id="leftSideBarScroll">
            <div class="margin-bottom-30">
                <a href="<?php echo CommonUtility::getCreateTaskUrl();?>" class="btn-u rounded btn-u-sea display-b text-16"><?php echo Yii::t('poster_createtask', 'Post a New Project')?></a>
            </div>
        <!--task type start here-->
         <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
        <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', 'a', array('id' => 'taskStateValue')); ?>
            <?php
            $this->renderPartial('instantnavigationproposals',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER  , 'menusLinks' => 
                array(

                    CHtml::encode(Yii::t('poster_projectdetail', 'Search Members')) => CommonUtility::getPosterSearchMembersUrl() ,
                    CHtml::encode(Yii::t('poster_projectdetail', 'Currently Hiring')) => CommonUtility::getPosterCurrentryHiringUrl(),
                    CHtml::encode(Yii::t('poster_projectdetail', 'Active Projects')) => CommonUtility::getPosterActiveProjectsUrl(),
                    CHtml::encode(Yii::t('poster_projectdetail', 'Completed Projects')) => CommonUtility::getPosterCompletedProjectsUrl(),
                    CHtml::encode(Yii::t('poster_projectdetail', 'All Projects')) => CommonUtility::getPosterAllProjectsUrl(),
                )
            )); 
            ?>
        <!--task type ends here-->
        
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
<!--        <div class="panel-heading">
        <h4 class="panel-title">
               <?php echo Yii::t('poster_createtask', 'Filter By')?>  
                <span style="float: right;cursor: pointer" id="resetLeftBar">Reset</span>
        <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
        Filter By
        <span style="float: right;cursor: pointer" id="resetLeftBar">Reset</span>
        </a>
        </h4>
        </div>-->
        <div class="panel-collapse collapse in sky-form" id="collapseOne">
<!--            <div id="fltbtn_cont">
                        <?php $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS ,'action_url' => Yii::app()->createUrl('poster/filterformmytasks'))); ?>
            </div>-->
        <div class="panel-body no-pdn">
        <div class="col-md-12 no-mrg">

        <div class="message-filter">
           <?php
            $hired = ($quickFilter == Globals::FLD_NAME_TASKER_STATUS) ? 'active' : '' ;
            $mostexperienced = ($quickFilter == Globals::FLD_NAME_TASK_DONE_CNT) ? 'active' : '' ;
            $nearby = ($quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE) ? 'active' : '' ;
            $rated = ($quickFilter == Globals::FLD_NAME_TASK_DONE_RANK) ? 'active' : '' ;
            $bookmark = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'active' : '' ;
            $mostvalued = ($quickFilter == Globals::FLD_NAME_TASKER_PROPOSED_COST) ? 'active' : '' ;
            $invited = ($quickFilter == Globals::FLD_NAME_SELECTION_TYPE) ? 'active' : '' ;
            echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); 
           ?>
        <ul>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Highly Rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most Value')), 'javascript:void(0)', array('id' => 'loadMostValued' , 'class' => $mostvalued)); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most Experienced')), 'javascript:void(0)', array('id' => 'loadMostExperienced' , 'class' => '')); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Near Me')), 'javascript:void(0)', array('id' => 'loadNearby' , 'class' => $nearby)); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $bookmark)); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previously Hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired)); ?></li>
        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Invited')), 'javascript:void(0)', array('id' => 'loadInvited' , 'class' => $invited)); ?></li>
        </ul>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="clr"></div>
        </div>
         </div>
        <!--Filter tast Ends here-->
    </div>
    <!--Left side bar ends here-->
    <?php $taskDetailUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID});
    ?>
    <?php
        if($task->{Globals::FLD_NAME_PROPOSALS_CNT} <= 0)
        {
            $emptyMsg = 'No Proposal submitted for this project';
        }
        else
        {
            $emptyMsg = Yii::t('tasklist','No proposal found matching your search criteria');
        }
    ?>
    <!--Right side content start here-->
    <div class="col-md-9 right-cont ">
        <div class="sky-form">
        <div class="h-tab flat">
	<a href="#">Currently Hiring</a>
	<a href="<?php echo $taskDetailUrl;?>" class="active"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?></a>
</div>
        <!--Top proposal start here-->
        <?php $this->renderPartial('_proposallistupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel)); ?>
        <!--Top proposal ends here-->
        
<!--        <h3 class="h2 text-30a"><?php // echo Yii::t('poster_createtask', 'Proposals list')?></h3>-->
        <div class="margin-bottom-30">
            <div class="sortby-row margin-bottom-20">
<!--                <div class="ntointrested">
                    <label class="checkbox">
                        <?php echo CHtml::checkBox(Globals::FLD_NAME_INTEREST, $interest, array('id'=>'interest') );?> <i></i><?php echo Yii::t('poster_createtask', 'Show not interested')?>
                    </label>
                </div>                      -->
                <div class="col-md-3 sortby-noti no-mrg">
                    <?php echo UtilityHtml::getSortingDropDownProposalList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ); ?> 
                </div>
            </div>
            <div id="loadData " class="col-md-12 no-mrg">
                        <?php $this->widget('ListViewWithLoader', array(
                            'id' => 'loadAllProposals',
                            'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.$emptyMsg.'</div></div>',
                            //'emptyTagName' => 'div class="box2"',
                            'dataProvider' => $proposals,
                            'viewData' => array('dataProvider' => $proposals, 'task' => $task, 'taskLocation' => $taskLocation , 'isTaskCancel' => $isTaskCancel ,'proposalIds' => $proposalIds ),
                            'itemView' => '_viewallproposals',
                            'enableHistory' => true,
                            'template'=>'{items}{pager}',
                        //  'summaryCssClass'=>'ntointrested',
                            'summaryText' => Yii::t('tasklist','Found {count} proposals'),
                            'afterAjaxUpdate' => "function(id, data) {
                                                     //  $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                                    }",
                            )
                        );
                        ?>
              </div>
         </div>
        </div>
    </div>
    <!--Right side content ends here-->

