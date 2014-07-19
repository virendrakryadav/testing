<?php echo CommonScript::loadCreateTaskScript() ?>
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
$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});
$quickFilter = (isset($_GET[Globals::FLD_NAME_QUICK_FILTER])) ? $_GET[Globals::FLD_NAME_QUICK_FILTER] : '' ;
$isFieldAccessByTaskTypeVirtual = CommonUtility::isFieldAccessByTaskTypeVirtual($task->{Globals::FLD_NAME_TASK_KIND});
$rating = (isset($_GET[Globals::FLD_NAME_RATING])) ? $_GET[Globals::FLD_NAME_RATING] : '' ;
$taskerName = (isset($_GET[Globals::FLD_NAME_USER_NAME])) ? $_GET[Globals::FLD_NAME_USER_NAME] : '' ;

//$maxPriceValue = isset($_GET[Globals::FLD_NAME_MAXPRICE]) ? $_GET[Globals::FLD_NAME_MAXPRICE] : $maxPrice;
//$minPriceValue = isset($_GET[Globals::FLD_NAME_MINPRICE]) ? $_GET[Globals::FLD_NAME_MINPRICE] : $minPrice;
?>
<script>    
$( document ).ready(function() {
  $("#proposalssidebar").mCustomScrollbar();
});
</script>

<div class="container content">

    <!--Left side bar start here-->
   <div class="col-md-3">
    <!--erandoo start here-->
    <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
    <!--erandoo end here-->
    
    <!--task type start here-->
    <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER )); ?>
    <!--task type ends here-->
    
        <!--Filter start here-->
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                            <h3 class="panel-title">
                            <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
                            <?php echo Yii::t('poster_createtask', 'Filter')?>
                            <span class="accordian-state"></span>
                            </a>
                            </h3>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">
                        <div id="loadactionfilter">
                        <?php 
                        $this->renderPartial('//tasker/_actionfilters',array('filter_type' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS ,'action_url' => Yii::app()->createUrl('tasker/savefiltertaskproposalform')));
                        ?>
                        <div class="clr"></div>
                        </div>
                        <div class="filter_cont">
                        <!-- Start search start here-->
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
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previously hired')), 'javascript:void(0)', array('id' => 'loadHired' , 'class' => $hired )); ?> </li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Premium task')), 'javascript:void(0)', array('id' => 'loadPremiumTask' , 'class' => $premium)); ?></li>
                                        <?php
                                        if( $isFieldAccessByTaskTypeVirtual )
                                        {
                                            ?>
                                            <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Nearby')), 'javascript:void(0)', array('id' => 'loadNearby' , 'class' => $nearby)); ?></li>
                                            <?php
                                        }
                                        ?>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Highly rated')), 'javascript:void(0)', array('id' => 'loadHighlyrated' , 'class' => $rated)); ?> </li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Potential')), 'javascript:void(0)', array('id' => 'loadPotential' , 'class' => $bookmark)); ?></li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Most valued')), 'javascript:void(0)', array('id' => 'loadMostValued' , 'class' => $mostvalued)); ?> </li>
                                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Invited')), 'javascript:void(0)', array('id' => 'loadInvited' , 'class' => $invited)); ?> </li>
                                </ul>
                            </div>
                            <div class="advncsearch">
                                <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'txt_doer_name')?></div>
                                <div class="col-md-12 pdn-auto">
                                    <div class="col-md-10 no-mrg"><?php echo CHtml::textField(Globals::FLD_NAME_USER_NAME, $taskerName, array('id' => 'taskerName', 'placeholder' => 'Enter Doer name', 'class'=>'form-control')); ?></div>
                                    <div class="col-md-1 no-mrg"><input name="" id="searchByTaskName" type="button" value="Go" class="btn-u btn-u-lg pdn-btn btn-u-sea" /></div>
                                </div>
                            </div>   
                
                            <div class="advncsearch">
                                <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'lbl_ratings')?></div>
                                <div class="col-md-12 pdn-auto"> <?php UtilityHtml::getSearchByRating( 'ratings' , $rating , Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER)?></div> 
                            </div>
                            
                             <?php $this->renderPartial('//tasker/_searchbycountry',array('name' => Globals::FLD_NAME_LOCATIONS , 'filter' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER));?>
    <!--                        <div id="loadproposalfilters">
                            <?php  //$this->renderPartial('_viewallproposalsfilters',array('rating' => $rating, 'taskerName' => $taskerName , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'maxPrice' => $maxPrice , 'minPrice' => $minPrice , 'isFieldAccessByTaskTypeVirtual' => $isFieldAccessByTaskTypeVirtual)); ?>
                            </div>-->
                        </div>
                    </div>
                </div>
                
                <!--Proposal start here-->
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading"><h3 class="panel-title"><a href="#collapse-Two" data-parent="#accordion" data-toggle="collapse">
                        <?php echo Yii::t('tasker_mytasks', 'Proposals')?>
                        <span class="accordian-state"></span>
                        </a></h3>
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapse-Two">
                        <div class="panel-body pdn-auto2">
                        <?php
                            $this->widget('ListViewWithLoader', array(
                                'id' => 'loadAllProposalsSidebar',
                                'dataProvider' => $proposals,
                                'itemView' => '_viewallproposalssidebar',
                                'template'=>'{items}',
                                ));
                            ?>
                        </div>
                    </div>
                </div>
                <!--Proposal Ends here-->
            </div>
        </div>
        <!--Filter Ends here-->
    </div>
    <!--Left side bar ends here-->
    
    
    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
        
        <!--Top proposal start here-->
        <?php   $this->renderPartial('//tasker/_taskdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel)); ?>
        <!--Top proposal ends here-->

<!--        <div class="box">-->
<!--<div class="box_topheading">-->
        <h3 class="h2 text-30a"><?php echo Yii::t('tasker_mytasks', 'Proposals detail')?></h3>
    
        <div class="margin-bottom-30">
            <div class="col-md-12 no-mrg">
            <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadProposalDetail',
                    'dataProvider' => $proposalsDetail,
                    'itemView' => '_proposaldetail',
                    'enableHistory' => true,
                    'summaryCssClass' => 'proposalnum2',
                    'template'=>'{pager}<div class="sortby-row margin-bottom-20">{summary}</div>{items}',
                    'summaryText' => '{start} of {count} proposals',
                    'viewData'=>array('isTaskCancel' => $isTaskCancel),
                    'pager'        => array(
                    'cssFile'=>  Globals::BASH_URL."/css/front/proposal-detail.css",          
                    'prevPageLabel' => '<img src="'.CommonUtility::getPublicImageUri("prv.png").'"> Previous Proposal',
                    'nextPageLabel' => ' Next Proposal <img src="'.CommonUtility::getPublicImageUri("next.png").'">',
                    'firstPageLabel'=>'',
                    'lastPageLabel'=>'',
                    'maxButtonCount'=>0 // defalut 10      
                    ),
                    ));
                ?>
            </div>  
        </div>
    </div>
    <!--Right side content ends here-->
</div>
 