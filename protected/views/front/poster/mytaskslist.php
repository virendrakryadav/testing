<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->
<div class="page-container pagetopmargn">
    
    <!--Left side bar start here-->
    <div class="leftbar">
        <!--Previoue tast start here-->
        <div class="box">
            <div class="box_topheading"><h3 class="h3">
                    <?php echo CHtml::encode(Yii::t('poster_mytasklist', 'txt_task_find')); ?>
                </h3></div>
            <div class="box2" id="loadPreviewTask">
                <?php
                $this->renderPartial('_findtask', array(
                    'task' => $task,
                ));
                ?>
            </div>
        </div>
        <!--Previoue tast Ends here-->
        <!--Template Category start here-->
        <div class="box">
            <div class="box_topheading"><h3 class="h3">
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_chat_now')); ?>
                </h3></div>
            <div class="box2" id="loadTemplateCategory">
                <?php $this->renderPartial('_chatnow'); ?>
            </div>
        </div>
        <!--Template Category tast Ends here-->
    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar">
        <div class="box">
            <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_list')); ?></h3></div>
            <div  class="list-view"> 
                <div class="task_toptab">
                    <div class="task_toptab_col1"  id="tasklist">
                        <?php
                        Yii::app()->clientScript->registerScript('searchMytasks', "var ajaxUpdateTimeout;
                                var ajaxRequest;
                                var val;
                                $('a#loadmytasksAll').click(function(){
                                    ajaxRequest = $('#loadmytasksAllValue').serialize();
                                    $(this).addClass('active');
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmytasksdata',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksOpen').click(function(){
                                    ajaxRequest = $('#loadmytasksOpenValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmytasksdata',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksClose').click(function(){
                                    ajaxRequest = $('#loadmytasksCloseValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmytasksdata',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksAwarded').click(function(){
                                    ajaxRequest = $('#loadmytasksAwardedValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmytasksdata',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksCancel').click(function(){
                                    ajaxRequest = $('#loadmytasksCancelValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmytasksdata',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });"
                        );
                        ?>
                        <ul>
                            <li>
                                <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_all')), 'javascript:void(0)', array('id' => 'loadmytasksAll', 'class' => 'active')); ?>
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_NULL, array('id' => 'loadmytasksAllValue')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_open')), 'javascript:void(0)', array('id' => 'loadmytasksOpen')); ?>
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_TASK_STATUS_OPEN, array('id' => 'loadmytasksOpenValue')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_close')), 'javascript:void(0)', array('id' => 'loadmytasksClose')); ?>
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_TASK_STATUS_FINISHED, array('id' => 'loadmytasksCloseValue')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_awarded')), 'javascript:void(0)', array('id' => 'loadmytasksAwarded')); ?>
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE, array('id' => 'loadmytasksAwardedValue')); ?>
                            </li>
                            <li>
                                <?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'txt_cancel')), 'javascript:void(0)', array('id' => 'loadmytasksCancel')); ?>
                                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', Globals::DEFAULT_VAL_TASK_STATUS_CANCELED, array('id' => 'loadmytasksCancelValue')); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="task_toptab_col2">
                        <div class="archive_col1" ><select name="archive" class="span2">	
                                <option><?php echo Yii::t('poster_createtask', 'Select Archive')?></option>
                            </select>
                            <input name="" type="button" class="archive_btn" value="Archive" />
                            <select name="archive" class="span2">
                                <option><?php echo Yii::t('poster_createtask', 'Sort by Relevance')?></option>
                            </select>
                        </div>
                    </div>
                </div>	
                <div id="myTaskLoading " class="positionRelativeClass">
                    <?php echo UtilityHtml::getAjaxLoading("loadPreviewTaskLoadingImg") ?>
                    <div id="loadData " class="positionRelativeClass">
                        <?php // $this->renderPartial('_mytaskslistall', array('task' => $task));  ?>
                        <?php
                        $this->widget('ListViewWithLoader', array(
                            'id' => 'loadmytasksdata',
                            'dataProvider' => $task,
                            'itemView' => '_mytaskslist',
                            'template' => '{items}{pager}',
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Right side content ends here-->
</div>
<div id="loadtaskpreview" class="windowpoposal" style="display: none" > </div>