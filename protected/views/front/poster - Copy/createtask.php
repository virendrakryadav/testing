<script src="<?php echo Yii::app()->request->baseUrl ?>/js/bxslider/jquery.bxslider.min.js"></script>

<link href="<?php echo Yii::app()->request->baseUrl ?>/js/bxslider/jquery.bxslider.css" rel="stylesheet">
    <?php echo CommonScript::loadCreateTaskScript() ?>
<?php UtilityHtml::popupforUserProfile(); ?>
<?php Yii::import('ext.chosen.Chosen'); ?>

<script>
    function loadCategoryFormScript( action , category_id , taskId ,formType )
    {
        jQuery.ajax(
        {
            'data':{'category_id': category_id ,'formType':formType,'taskId':taskId ,'YII_CSRF_TOKEN' : '<?php echo Yii::app()->request->csrfToken ?>'},
            'type':'POST',
            'dataType' : 'json',
           
            'beforeSend':function(){
                $("#rootCategoryLoading").addClass("displayLoading");
                $("#loadpreviuosTask").addClass("displayLoading");
                $("#templateCategory").addClass("displayLoading");
            },
            'complete':function(){
                    $("#rootCategoryLoading").removeClass("displayLoading");
                    $("#loadpreviuosTask").removeClass("displayLoading");
                    $("#templateCategory").removeClass("displayLoading");
                    
                },
            
            'success':function(data)
            { 
                    activeForm("loadcategory_" + category_id);
                    $('#loadCategoryForm').html(data.form);
                    $('#loadPreviewTask').html(data.previusTask);
                    $('#loadTemplateCategory').html(data.template);
                    $('#templateCategory').fadeIn(500);
            },
            'url': action,
            'cache':false
        });
    }
    
</script>
<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->
<div class="page-container pagetopmargn">
    <!--Left side bar start here-->
    <div class="leftbar">
        <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER )); ?>
        <!--Previoue tast start here-->   
        <div id="loadpreviuosTask" class="box positionRelativeClass">
            <?php // echo UtilityHtml::getAjaxLoading("loadPreviewTaskLoadingImg") ?>
            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_previous_task')) ?></h3></div>
            <div class="box2" id="loadPreviewTask">
                <?php $this->renderPartial('_loadpreviuostask' , array( 'formtype' =>  '' )); ?>
            </div>
        </div>
        <!--Template Category start here-->
        <div class="box positionRelativeClass" id="templateCategory" style="display: none">
            <?php //echo UtilityHtml::getAjaxLoading("loadTemplateCategoryLoadingImg") ?>
            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_template_category')) ?></h3></div>
            <div class="box2" id="loadTemplateCategory">
                <?php $this->renderPartial('_loadtemplatecategory'); ?>
            </div>
        </div>
        <!--Template Category tast Ends here-->
    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar">
        <div id="rootCategoryLoading" class="box positionRelativeClass">

            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_task_heading')) ?></h3></div>
            <!--Which kind of task  start here-->
            <?php echo UtilityHtml::getAjaxLoading("rootCategoryLoadingImg") ?>
            <div class="controls-row pdn rootCategoryThumb" style="display: none">
                <div class="span3 nopadding"><h3 class="h3-1"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_kind_of_task')) ?></h3></div>
                <div class="tast_box_new">
                    <?php echo CHtml::ajaxLink('<i class="task_icon2 virtual2"></i>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_virtual_task')), Yii::app()->createUrl('poster/loadvirtualtask'), 
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){ 
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.virtual);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadVirtualTaskShort");
                                                                   
                                                                }'), 
                            array('id' => 'loadVirtualTaskShort','live'=>false)); ?>
                </div>
                <div class="tast_box_new">
                    <?php echo CHtml::ajaxLink('<i class="task_icon2 inperson2"></i>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_inperson_task')), Yii::app()->createUrl('poster/loadinpersontask'), 
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                                                    activeCategory("loadInpersonTaskShort");
                                                                    $(\'#loadCategory\').html(data.inperson);
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    
                                                                    $(\'#templateCategory\').hide();
                                                                    
                                                                }'), 
                            array('id' => 'loadInpersonTaskShort','live'=>false));?>
                </div>
                <div class="tast_box_new">
                    <?php echo CHtml::ajaxLink('<i class="task_icon2 instant2"></i>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_instant_task')), Yii::app()->createUrl('poster/loadinstanttask'), 
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                                                    activeCategory("loadInstantTaskShort");
                                                                     $(\'#loadCategory\').html(data.instant);
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#templateCategory\').hide();
                                                                    
                                                                }'), 
                                    array('id' => 'loadInstantTaskShort','live'=>false)); ?>
                </div>
            </div>
            <div  class="controls-row pdn rootCategory">
                <h3 class="h3 bottom_border"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_kind_of_task')) ?></h3>
                <div class="tast_box">
                    <?php echo CHtml::ajaxLink('<i class="task_icon virtual"></i><p>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_virtual_task')) . ' <span>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_anywhere')) . '</span></p>', Yii::app()->createUrl('poster/loadvirtualtask'), 
                            array(
                                   'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){ 
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.virtual);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadVirtualTaskShort");
                                                                }'), 
                            array('id' => 'loadVirtualTask','live'=>false)); ?>
                    
                    <?php
//                    echo CHtml::ajaxLink('<i class="task_icon virtual"></i><p>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_virtual_task')) . ' <span>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_anywhere')) . '</span></p>', Yii::app()->createUrl('poster/loadvirtualtask'), array(
//                         'beforeSend' => 'function(){$("#rootCategoryLoading").addClass("displayLoading");}',
//                        'complete' => 'function(){$("#rootCategoryLoading").removeClass("displayLoading");}',
//                        'success' => 'function(data){$(\'#loadCategory\').html(data);activeCategory("loadVirtualTask");loadSidebar("v",""); $(\'#templateCategory\').hide();}'), array('id' => 'loadVirtualTask')); 
                    ?>
                </div>
                <div class="tast_box">
                    <?php echo CHtml::ajaxLink('<i class="task_icon inperson"></i><p>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_inperson_task')) . ' <span>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_at_my_location')) . '</span> </p>', Yii::app()->createUrl('poster/loadinpersontask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.inperson);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInpersonTaskShort");
                                                                }'), 
                            array('id' => 'loadInpersonTask','live'=>false)); ?>
                </div>
                <div class="tast_box ">
                    <?php echo CHtml::ajaxLink('<i class="task_icon instant"></i><p>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_instant_task')) . ' <span>' . CHtml::encode(Yii::t('poster_createtask', 'lbl_need_it_now')) . '</span></p>', Yii::app()->createUrl('poster/loadinstanttask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'success' => 'function(data){
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.instant);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadInstantTaskShort");
                                                                }'), 
                                    array('id' => 'loadInstantTask','live'=>false)); ?>
                    
                </div>
            </div>
            <!--Which kind of task  ends here-->
            <div id="loadCategory"></div>
            <div id="loadCategoryForm"></div>
            <div id="loadpreview"></div>
        </div>
    </div>
    <!--Right side content ends here-->
</div>

