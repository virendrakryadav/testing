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

function girdView()
{
    $('#currentView').val('grid');
    $('.search_row').addClass('list-col');
	
    $('.pro-icon-cont').hide();
    $('.pro-icon-doer').show();
    $('.invite-row3-proposal').addClass('margin-bottom-10');

    $('.proposal_col2').addClass('doer-grig-col');
    $('.doer-grig-col').removeClass('proposal_col2');
	
    $('#listView').show();
    $('#gridView').hide();   
   setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','grid');   
}
function listView()
{
    $('#currentView').val('list');
    $('.search_row').removeClass('list-col');
	
    $('.pro-icon-cont').show();
    $('.pro-icon-doer').hide();
    $('.invite-row3-proposal').removeClass('margin-bottom-10');

    $('.doer-grig-col').addClass('proposal_col2');
    $('.proposal_col2').removeClass('doer-grig-col');
	
	
     $('#listView').hide();
    $('#gridView').show();
    setCurrentViewForUser('<?php echo Yii::app()->controller->action->id; ?>','list');        
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
    var sortDrop = $('#sortDrop').serialize();
    var taskerName = $('#taskerName').serialize();
    url = url+'?'+data+'&'+sortDrop+'&'+taskerName;
//    alert(data);
//    alert(sortDrop);
//    alert(taskerName);
//    data = sortDrop.taskerName;        
    loadtaskersfilters( '".$taskerName."' , '".$rating."' );
    loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."');
    window.History.pushState(null, document.title,url); 
//    window.History.pushState(null, document.title,$.param.querystring(url, data));
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
    $('#sortDrop').val('');
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
 
$('body').delegate('#cleareSearchByTaskName','click',function()
{
            
            var data = $('#taskerName').serialize(); 
            $('#sortby-row').show();
            SearchFunc(data);            
            loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER."');
 });
$('a#loadHired').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_PREVIOUSLY_WORKED."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadpremiumtasker').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadNearby').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASKER_IN_RANGE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadHighlyrated').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_RANK."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });

$('a#loadMostExperienced').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_TASK_DONE_CNT."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});

$('a#loadInvited').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_SELECTION_TYPE."'); reloadFilterGrid();removeActiveMenu(); activeMenu(this); });
$('a#loadPotential').click(function(){  $('#quickFilterValue').val('".Globals::FLD_NAME_BOOKMARK_SUBTYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this); });
$('a#loadPremiumTask').click(function(){ $('#quickFilterValue').val('".Globals::FLD_NAME_ACCOUNT_TYPE."'); reloadFilterGrid(); removeActiveMenu(); activeMenu(this);});



$('#sortDrop').change(function(){  
        var data = $(this).serialize();    
            SearchFunc(data); 
         loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
    }); 
    
$('#resetLeftBar').click(function(){
       var sort = '?'+$('#sortDrop').serialize()+'&'+$('#taskerName').serialize();
       var url = pageUrl + sort;
       $('#sortby-row').show();  
       $('#taskerlist ul li a').removeClass('active');  
       
      window.History.pushState(null, document.title,url);
 });

    currentView();
    "
);
$sort = "";
if(isset($_GET['sort']))
{
    $sort = $_GET['sort'];
}
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
<div class="container content">
    <!--Left bar start here-->
    <div class="col-md-3 leftbar-fix">
        <!--Dashboard (erandoo) start here-->
            <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashboard (erandoo) end here-->
        <div class="margin-bottom-30">
            <a href="<?php echo Yii::app()->createUrl('poster/createtask');?>" class="btn-u rounded btn-u-sea display-b text-16"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_a_new_project')); ?></a></div>
        <!--Instant Navigation start here-->
        <?php // $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER )); ?>
        
        
        <div id="leftSideBarScroll">
        
        <?php
                  /* $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER  , 'menusLinks' => 
                        array(
                            
//                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_currently_hiring')) => Yii::app()->createUrl('tasker/mytasks?Task[state]=o') ,
//                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_active_projects')) => CommonUtility::getTaskerActiveProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_completed_projects')) => CommonUtility::getTaskerCompletedProjectsUrl(),
//                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_all_projects')) => Yii::app()->createUrl('tasker/mytasks'),
                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_currently_hiring')) => CommonUtility::getPosterCurrentryHiringUrl(),
                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_active_projects')) => CommonUtility::getPosterActiveProjectsUrl(),
                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_completed_projects')) => CommonUtility::getPosterCompletedProjectsUrl(),
                            CHtml::encode(Yii::t('poster_mytasklist', 'txt_all_projects')) => CommonUtility::getPosterAllProjectsUrl(),
                        )
                    )); 
                      */
                    ?>
        
        
        <!--Instant Navigation ends here-->
        
        <!--Filter start here-->
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h3 class="panel-title no-mrg">
                        <?php echo Yii::t('poster_createtask', 'lbl_filter_by')?>  
                            <span class="btn-u rounded btn-u-blue reset-right" id="resetLeftBar"><?php echo Yii::t('poster_createtask', 'lbl_reset')?></span>
                            <div class="clr"></div>
                        </h3>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">
                        <div class="col-md-12 no-mrg">
                            <!--Start search start here-->
                            <div class="message-filter">
                                <div id="taskerlist">
                                    <?php
                                    $hired = ($quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED) ? 'active' : '' ;
                                    $premium = ($quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE) ? 'active' : '' ;
                                    $nearby = ($quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE) ? 'active' : '' ;
                                    $rated = ($quickFilter == Globals::FLD_NAME_TASK_DONE_RANK) ? 'active' : '' ;
                                    $bookmark = ($quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE) ? 'active' : '' ;                                   
                                    $mostexperienced = ($quickFilter == Globals::FLD_NAME_TASK_DONE_CNT) ? 'active' : '' ;
                                    $invited = ($quickFilter == Globals::FLD_NAME_SELECTION_TYPE) ? 'active' : '' ;

                                    echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>          
                                    <ul>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_highly_rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?> </li>                                        
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_most_experienced')), 'javascript:void(0)', array('id' => 'loadMostExperienced' , 'class' => $mostexperienced)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_nearby')), 'javascript:void(0)', array('id' => 'loadNearby' , 'class' => $nearby)); ?></li>
                                        <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_previously_hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired)); ?></li>                                                                                                                                                                
                                    </ul>
                                </div>
                            </div>                            
                            <!--Advance filter Ends here-->     
                        </div>
                    </div>
                </div>       
            </div>
            <div class="clr"></div>
        </div>
        </div>
        <!--Filter ends here-->
    </div>
    <!--Left bar Ends here-->  
    <div class="col-md-9 right-cont">
<!--        <div class="box">-->        
        <div class="margin-bottom-30">
            <div class="col-md-65 fixed">                                               
                <div class="col-md-12 no-mrg">
                <form action="" class="sky-form">
                    <div class="project-search">
                        <div class="project-search-new-1">
                            <div class="project-search3">
                                <img src="<?php echo CommonUtility::getPublicImageUri("in-searchic.png"); ?>">
                            </div>
                            <div class="project-search2">
                                <?php echo CHtml::textField(Globals::FLD_NAME_USER_NAME, $taskerName, array('id' => 'taskerName', 'placeholder' => 'Search', 'class' => '','autofocus' => true)); ?>
                            </div> 
                            <div class="project-search4">
                                <img id="cleareSearchByTaskName" style="cursor: pointer" onclick="$('#taskerName').val('');" src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png"); ?>">
                            </div>
                        </div>                    
                        <button type="button" id="searchByTaskName" class="btn-u rounded btn-u-sea"><?php echo Yii::t('poster_createtask','lbl_search') ?></button></div>
                </form>
                </div>

                <div class="sortby-row margin-bottom-10" id="sortby-row" style="display: <?php if($taskerList->getTotalItemCount() > 0 ) echo 'block'; else echo 'none'; ?>; min-height: 20px;"> <!--                <div class="ntointrested"> Found 100 results</div> -->
                    <div class="select-list">
                    <a id="gridView" onclick="girdView()" href="javascript:void(0)"><i class="fa fa-th-large"></i></a>
                    <a id="listView" style="display: none" onclick="listView()"  href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                </div> 
                    <div class="col-md-3 sortby-noti no-mrg">
                        <?php echo UtilityHtml::getSortingDropDownDoerSearch( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ,$sort); ?> 
                    </div>
                </div>
                <div id="success_msg" style="display: none" class="alert alert-success fade in">
                    <button class="close4" type="button" onclick="$('#success_msg').fadeOut();">×</button>            
                    <i class="fa fa-hand-o-right"></i>
                    <span id="messageDetail"></span> 
                </div> 
             </div>
            <div class="margin-bottom-80"></div>
            <div class="col-md-12 no-mrg">
                <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadtaskerlist',
                    'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.Yii::t('tasklist','msg_no_tasker_found').'.</div></div>',
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $taskerList,
                    'itemView' => '_taskerlist',
                    'enableHistory' => true,
                    'enablePagination'=>true,
                    'viewData' => array( 'model' => $model),
                    'template'=>'{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
                    'afterAjaxUpdate' => "function(id, data) {
						currentView(); $('html,body').animate({ scrollTop : 0 }, 'slow');
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
                
                
                <?php
//                $this->widget('ListViewWithLoader', array(
//                    'id' => 'loadtaskerlist',
//                    'dataProvider' => $taskerList,
//                    'itemView' => '_taskerlist',
//                    'enableHistory' => true,
//                    'viewData' => array( 'model' => $model),
//                    'template'=>'{items}{pager}',
//                    'emptyText' => Yii::t("tasklist","msg_no_tasker_found"),
//                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
//                    'afterAjaxUpdate' => "function(id, data) {
//                    $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
//                    jQuery.ias({
//                        'history':false,
//                        'triggerPageTreshold':0,
//                        'trigger':'Load more',
//                        'container':'#loadtaskerlist.list-view',
//                        'item':'.doerlist',
//                        'pagination':'#loadtaskerlist .pager',
//                        'next':'#loadtaskerlist .next:not(.disabled):not(.hidden) a',
//                        'loader':'Loading...'});}",
//                    'pager' => array(
//                        'class' => 'ext.infiniteScroll.IasPager', 
//                        'rowSelector'=>'.doerlist', 
//                        'itemsSelector' => '.list-view',
//                        'listViewId' => 'loadtaskerlist',
//                        'header' => '',
//                        'loaderText'=>'Loading...',
//                    // 'onPageChange' => "function() { alert();}",
//                        'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Load more',
//                        //'onRenderComplete'=>"function(items) {alert();}",
//                        ),
//                                )
//                            )
//                    );
                ?>
                
            </div> 
<!--        </div> -->
        </div>
    </div> 
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