<script>
function SearchFunc(data)   
{

var url = document.URL;
//alert(url);
var params = $.param(data);
//url = url.substr(0, url.indexOf('?'));
window.History.pushState(null, document.title,$.param.querystring(url, data));
}
</script>
<?php

//echo"<pre>";
//    print_r(Yii::app()->user->getState('is_virtualdoer_license'));
//    print_r(Yii::app()->user->getState('is_inpersondoer_license'));
//    print_r(Yii::app()->user->getState('is_poster_license'));
//    print_r(Yii::app()->user->getState('is_premiumdoer_license'));
//    echo Yii::app()->user->getState('user_type');
//    exit();

Yii::import('ext.chosen.Chosen');
Yii::app()->clientScript->registerScript('searchMytasks', "
var pageUrl = '".Yii::app()->createUrl('notification/index')."';            

$('#sortDrop').change(function(){  
        var data = $(this).serialize();    
            SearchFunc(data); 
         loadfilters('".Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK."');
    });     
    "
);

$sort = "";
if(isset($_GET['sort']))
{
    $sort = $_GET['sort'];
}
?>
<div class="container content">
    <!--Left side bar start here-->
    <div class="col-md-3 leftbar-fix">
        <!--Dashbosrd start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashbosrd start here-->
         <div id="leftSideBarScroll">    
        <!--Filter start here-->
        
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h3 class="panel-title no-mrg">
                            Filter By    
                            <span style="float: right;cursor: pointer" id="resetLeftBar">Reset</span>
                        </h3>
                    </div>                    
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">                       
                        <div class="col-md-12 no-mrg">
                            <!--Start search start here-->
                                                        
                                                        
                                <div class="message-filter">
                                    <div id="tasklist">                                        
                                        <ul>
                                            <li> <a id="loadmytasksAll" class="active" href="javascript:void(0)">All Notifications</a></li>
                                            <li><a id="loadmytasksOpen" class="" href="javascript:void(0)">Doer</a></li>
                                            <li><a id="loadmytasksClose" class="" href="javascript:void(0)">Poster</a></li>
                                            <li><a id="loadmytasksAwarded" class="" href="javascript:void(0)">System</a></li>
                                            <li><a id="loadmytasksCancel" class="" href="javascript:void(0)">Other</a></li>
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
        <div class="col-md-12 no-mrg"><h2 class="h2 ">Notifications</h2>            
        </div>  
        
        <div class="sortby-row margin-bottom-10"> 
<!--                <div class="select-list">
                    <a id="gridView" onclick="girdView()" href="javascript:void(0)"><i class="fa fa-th-large"></i></a>
                    <a id="listView" style="display: none" onclick="listView()"  href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                </div>                   -->
                <div class="col-md-3 sortby-noti no-mrg">
                    <?php echo UtilityHtml::getSortingDropDownNotificationList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ,$sort ); ?>
                </div>            
         </div>
        </div>
        <div class="margin-bottom-80"></div>
        <div id="loadData " class="margin-bottom-30 positionRelativeClass">            
                <?php
//                echo count($notifications);
//                $old_date = 1;
//                $array = array();
                $array = CommonUtility::createArrayForNotification($notifications);                
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmytasksdata',
                    'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.Yii::t('tasklist','No project found matching your search criteria').'.</div></div>',
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $notifications,
                    'itemView' => '_notifications',
                    'viewData' => array( 'array' => $array),
                    'enableHistory' => true,
       
                    'template'=>'<div class="found-count">{summary}</div>{items}{pager}',
                    'summaryText' => '',
                    'afterAjaxUpdate' => "function(id, data) 
                        {                        
                        $('html,body').animate({ scrollTop : 0 }, 'slow');                        
                        }",
                    )
                );              
                ?>                          
            <!--Notification list ends here-->
            <div class="clr"></div>
        </div>                      
    </div>