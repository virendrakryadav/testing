<?php
$taskerName = (isset($_GET[Globals::FLD_NAME_USER_NAME])) ? $_GET[Globals::FLD_NAME_USER_NAME] : '' ;
$rating = (isset($_GET[Globals::FLD_NAME_RATING])) ? $_GET[Globals::FLD_NAME_RATING] : '' ;
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;
?>
<script>
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
function loadtaskersfilters( taskerName , rating )
{

        jQuery.ajax({
    'dataType':'json',
    'data':{'taskerName': taskerName , 'rating' : rating},
    'type':'POST',
    'success':function(data)
    {
        if(data.status==='success')
        {
        $('#loadtaskerfilter').html(data.html);
        }
        else
        {
            alert('<?php echo Yii::t('tasker_createtask','unexpected_error') ?>');
        }
    },
    'url':'<?php echo Yii::app()->createUrl('poster/gettaskerlistfilters') ?>','cache':false});return false; 
}
</script>
<?php


Yii::import('ext.chosen.Chosen');
Yii::app()->clientScript->registerScript('searchMytasks', "
var pageUrl = '".Yii::app()->createUrl('poster/findtasker')."';            
$('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
$(\".categoryScroll\").mCustomScrollbar();
$('#date').daterangepicker(null, function(start, end){ SearchByDate(start, end)});

function reloadFilterGrid()
{ 
    data = $('#quickFilterValue').serialize();
    var url = pageUrl;
    var params = $.param(data);
    //url = url.substr(0, url.indexOf('?'));
    loadtaskersfilters( '".$taskerName."' , '".$rating."' );
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."');
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
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."');
});


$('body').delegate('a#resetFilter','click',function()
{
    
    var url = pageUrl;
    window.History.pushState(null, document.title,url);

    loadtaskersfilters( '' , '' );
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."' , 'reset');
    removeActiveMenu();
    return false; 
        
    
});
$('body').delegate('#searchByTaskName','click',function()
{

            var data = $('#taskerName').serialize();    
            SearchFunc(data);
            
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."');
            });
$('a#loadHired').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PREVIOUSLY_WORKED."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadpremiumtasker').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadNearby').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_IN_RANGE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadHighlyrated').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_RANK."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadMostValued').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_TOTAL_PRICE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});
$('a#loadInvited').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_SELECTION_TYPE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPremiumTask').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});



    $('#sortDrop').change(function(){  
        $.fn.yiiListView.update(\"loadmytasksdata\",{data:{sort:$(this).val()},type:\"POST\"}) 
    }); "
);
?>

<div class="container content">
    <!--Left bar start here-->
    <div class="col-md-3">
        <!--Dashboard (erandoo) start here-->
            <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashboard (erandoo) end here-->
        
        <!--Instant Navigation start here-->
        <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER )); ?>
        <!--Instant Navigation ends here-->
        
        <!--Filter start here-->
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
                        <?php echo Yii::t('poster_createtask', 'txt_filter')?>
                        <span class="accordian-state"></span>
                        </a>
                        </h3>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">
                        <div id="loadactionfilter">
                            <?php $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER ,'action_url' => Yii::app()->createUrl('tasker/savefilterform'))); ?>
                        </div>

                        <div class="col-md-12 no-mrg">
                            <!--Start search start here-->
                            <div class="smartsearch">
                                <div id="taskerlist">
                                    <?php
                                    $hired = ($quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED) ? 'activeCategory' : '' ;

                                    $premium = ($quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE) ? 'activeCategory' : '' ;
                                    $nearby = ($quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE) ? 'activeCategory' : '' ;
                                    $rated = ($quickFilter == Globals::FLD_NAME_TASK_DONE_RANK) ? 'activeCategory' : '' ;
                                    $bookmark = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'activeCategory' : '' ;
                                    $mostvalued = ($quickFilter == Globals::FLD_NAME_TASK_DONE_TOTAL_PRICE) ? 'activeCategory' : '' ;
                                    $invited = ($quickFilter == Globals::FLD_NAME_SELECTION_TYPE) ? 'activeCategory' : '' ;

                                    echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>          
                                    <ul>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_previously_hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_premium_tasker')), 'javascript:void(0)', array('id' => 'loadpremiumtasker' , 'class' => $premium)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_nearby')), 'javascript:void(0)', array('id' => 'loadNearby')); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_highly_rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?> </li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $bookmark)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_most_valued')), 'javascript:void(0)', array('id' => 'loadMostValued' , 'class' => $mostvalued)); ?> </li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_invited')), 'javascript:void(0)', array('id' => 'loadInvited' , 'class' => $invited)); ?> </li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_ending_today'))); ?> </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="loadtaskerfilter">
                                <?php $this->renderPartial('_findtaskersfiltes',array('taskerName' => $taskerName ,'rating' => $rating)); ?>
                            </div>
                            <!--Advance filter Ends here-->     
                        </div>
                    </div>
                </div>
        
                <!--My Tasks start here-->
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a href="#collapse-Two" data-parent="#accordion" data-toggle="collapse">
                            <?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_my_tasks'));?>
                            <span class="accordian-state"></span>
                            </a>
                        </h3>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapse-Two">
                        <div class="panel-body pdn-auto2">
                            <div class="col-md-12 no-pdn">
                                <?php
                                foreach($taskList as $taskList)
                                {
                                ?>
                                <div class="prvlist_box"> <a href="#"><img width="71" height="52" src="<?php echo CommonUtility::getTaskThumbnailImageURI($taskList->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>"></a>
                                    <p class="title"><?php echo $taskList->title?></p>
                                    <p class="date"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'Done By'));?> : John 21-01-2014</p>
                                    <p><a id="loadinstantcategories_542" href="<?php echo CommonUtility::getTaskDetailURI($taskList->{Globals::FLD_NAME_TASK_ID}); ?>"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'View'));?></a></p>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--My Tasks Ends here-->
            </div>
            <div class="clr"></div>
        </div>
        <!--Filter ends here-->
    </div>
    <!--Left bar Ends here-->  
    <div class="col-md-9 sky-form">
<!--        <div class="box">-->
<!--            <div class="box_topheading">-->
              <h3 class="h2 text-30a"><?php echo CHtml::encode(Yii::t('poster_createtask', 'search_result_tasker_list'));?></h3>
<!--            </div>-->
        <div class="margin-bottom-30">
            <div class="sortby-row margin-bottom-20" id="sortby-row margin-bottom-20" style="display: <?php if($taskerList->getTotalItemCount() > 0 ) echo 'block'; else echo 'none'; ?>; min-height: 20px;"> 
<!--                <div class="ntointrested"> Found 100 results</div> -->
                <div class="col-md-3 sortby-noti no-mrg">
                    <?php echo UtilityHtml::getSortingDropDownProposalList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ); ?> 
                </div>
            </div>

            <div class="col-md-12 no-mrg">
                <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadtaskerlist',
                    'emptyText' => Yii::t('tasklist','msg_no_tasker_found'),
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $taskerList,
                    'itemView' => '_taskerlist',
                    'enableHistory' => true,
                    'enablePagination'=>true,
                    'viewData' => array( 'model' => $model),
                    'template'=>'<div id="summerytesxt" class="box5" style="margin-top:-15px;">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
                    'afterAjaxUpdate' => "function(id, data) {
                                                $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
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
<!--        </div> -->
        </div>
    </div> 
</div>
