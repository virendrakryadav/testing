<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script>
    var maptodisplay = 0 ;
    function GridListView()
    {

        $('#loadDataMapView').css("display","none");
        $('#loadDataListView').css("display","block");
       
        //$(".tasker_list4 ").toggleClass('tasker_list_view')

    }
    function viewloadedmap()
    {

        $('#loadDataMapView').css("display","block");
        $('#loadDataListView').css("display","none");
       
        //$(".tasker_list4 ").toggleClass('tasker_list_view')

    }
    function inviteUser( task_id , user_id , location_longitude ,location_latitude ,tasker_in_range )
    {
        jQuery.ajax(
        {
            'data':{'task_id':task_id,'user_id':user_id,'location_longitude':location_longitude,'location_latitude':location_latitude,'tasker_in_range':tasker_in_range},
            'type':'POST',
            'success':function(data)
            { 
                $("#invitedbutton"+user_id).html("<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')) ?>");
                $("#invitedbuttonpopup"+user_id).html("<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')) ?>");
            },
            'url':'<?php echo Yii::app()->createUrl('tasker/invitenow'); ?>',
            'cache':false
        });
    }
    
</script>
<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->
<div class="container content">
    <!--Left side bar start here-->
    <div class="col-md-3">
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER )); ?>
        <!--Previoue tast start here-->
<!--        <div class="box">
            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_find_tsker')) ?></h3></div>
            <div class="box2" id="loadPreviewTask">
                <?php $this->renderPartial('_findtasker'); ?>
            </div>
        </div>-->
        <!--Previoue tast Ends here-->
        <!--Template Category start here-->
<!--        <div class="box">
            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_chat_now')) ?></h3></div>
            <div class="box2" id="loadTemplateCategory">
                <?php $this->renderPartial('_chatnow'); ?>
            </div>
        </div>-->
        <!--Template Category tast Ends here-->
    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
            <h3 class="h2 text-30a"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_recommended_tasker')) ?></h3>
            <div class="sortby-row margin-bottom-20">                      
                <div class="col-md-3 sortby-noti no-mrg">
                    <?php echo UtilityHtml::getSortingDropDownNotificationList( "sort" , array( 'id' => 'sortDrop' , 'class' => 'form-control mrg3' ) ); ?> 
                </div>
            </div>
<!--            <div class="list_head" id="yw0">
                <div class="tlist_col1"><h3 class="h3 blue_text"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_list_view')) ?></h3></div>
                <div class="tlist_col2">
                    <div class="tlist_col3"><a onclick = "GridListView();" href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "list-img.png" ) ?>"></a></div>
                    

                    <div class="tlist_col3" id = "viewmapbutton">
                    
                    <?php 
//                    if($dataProvider->getData())
//                    {
//                            echo  CHtml::ajaxLink('<img src="'.CommonUtility::getPublicImageUri( "map-view-img.png" ).'">',
//                            Yii::app()->createUrl("tasker/taskersmapview"), array(
//                                'data'=>array('taskId'=> $task_id , 'category_id' => $category_id,),
//                                'type'=>'POST',
//
//                                'beforeSend' => 'function(){
//                                                        // $("#forloader").addClass("displayLoading");
//                                                        }',
//                            'complete' => 'function(){       
//                                                            //$("#forloader").removeClass("displayLoading");
//                                                            }',
//                            'success' => 'function(data){
//               
//                                        $(\'#loadDataMapView\').html(data);
//                                        $(\'#loadDataMapView\').css("display","block");
//                                        $(\'#loadDataListView\').css("display","none");
//                                       
//                                        $(\'#viewmapbutton\').css("display","none");
//                                       $(\'#viewmapbutton2\').css("display","block");
//                                        }'), 
//                                array('id' => 'loadtaskersMapView' ,'live'=>false));
                    //}
                    ?>
                    </div>
                    <div class="tlist_col3" id = "viewmapbutton2" style="display: none">
                        <a  onclick="viewloadedmap()" href="#">
                        <img src="<?php echo CommonUtility::getPublicImageUri( "map-view-img.png" ) ?>">
                    </a>
                    </div>
                    <div class="tlist_col4">
                        <select class="form-control mrg3" name="archive">
                            <option><?php echo Yii::t('tasker_mytasks', 'Sort by Relevance')?></option>
                        </select>
                    </div>
                </div>
            </div>-->
            <div id="forloader" class=" positionRelativeClass ">
                <?php //echo UtilityHtml::getAjaxLoading("rootCategoryLoadingImg") ?>
<!--                <div  id="loadDataListView" class="controls-row pdn5"> -->
                    <div id="loadData" class="positionRelativeClass">
                        <?php

//                        if (!empty($dataProvider)  && !empty($task)) 
//                        {
                            $this->widget('ListViewWithLoader', array(
                                'id' => 'invitedTaskersList',
                                'dataProvider' => $dataProvider,
                                'emptyText' => Yii::t('tasklist','msg_no_tasker_found'),
                   
                                'itemView' => '_taskerlist',
                                'template' => '{items}{pager}',
                                'viewData' => array('dataProvider' => $dataProvider, 'taskLocation' => $taskLocation, 'task' => $task,)
                            ));
//                        } 
//                        else 
//                        {
//                            echo CHtml::encode(Yii::t('poster_createtask', 'txt_no_tasker_found'));
//                        }
                        ?>
                    </div>
<!--                </div>
                <div  id="loadDataMapView" class="controls-row pdn5"> 

                </div>-->
            </div>
    </div>
    <!--Right side content ends here-->
</div>