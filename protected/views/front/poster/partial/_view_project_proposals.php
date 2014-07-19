<script>
function SearchFunc(data)   
{
    var url = document.URL;
    var params = $.param(data);
    window.History.pushState(null, document.title,$.param.querystring(url, data));
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


Yii::app()->clientScript->registerScript('searchMyPoposalsdetail', "
                            
                            
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
 
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."');
    window.History.pushState(null, document.title,$.param.querystring(url, data));
    
}

function reloadFilterByForm()
{
    var form = $(this).closest('form').attr('id');
    $.fn.yiiListView.update('loadmytasksdata', {data: $('#'+form).serialize()});
}


$('body').delegate('a#resetFilter','click',function()
{
    var url = pageUrl;
    window.History.pushState(null, document.title,url);
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS."' , 'reset');
    removeActiveMenu();

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
<div class="sortby-row margin-bottom-20">                      
<div class="col-md-3 sortby-noti no-mrg">

                <?php echo UtilityHtml::getSortingDropDownProposalList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ); ?> 
                </div>

</div>
<div class="col-md-12 no-mrg">
<div id="loadData " class="positionRelativeClass">
    <?php

    $this->widget('zii.widgets.CListView', array(
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
                             //       $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                                }",
        )
    );
    ?>
</div>
    </div>

