<style>
    .active{pointer-events: none;color: #00B68E!important}
</style>
<div class="page-container pagetopmargn">

    <!--Left side bar start here-->
    <div class="leftbar">


        <!--Filter start here-->
        <div class="box">
            <div class="filter_tophead"><h3 class="filtertitle">Filter</h3>
                <div class="total_task3"><input type="button" class="btn" value="Save filter" name=""></div>
            </div>
            <div class="filter_cont">
                <!--Start search start here-->
                <div class="smartsearch">
                    <div id="tasklist">
                    <?php
                        Yii::app()->clientScript->registerScript('searchMytasks', "var ajaxUpdateTimeout;
                                var ajaxRequest;
                                var val;
                                $('a#loadmytasksAll').click(function(){
                                    ajaxRequest = $('#loadmytasksAllValue').serialize();
                                    $(this).addClass('active');
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmypostedtask',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksOpen').click(function(){
                                    ajaxRequest = $('#loadmytasksOpenValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmypostedtask',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksClose').click(function(){
                                    ajaxRequest = $('#loadmytasksCloseValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmypostedtask',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksAwarded').click(function(){
                                    ajaxRequest = $('#loadmytasksAwardedValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmypostedtask',{data: ajaxRequest})
                                    },0);
                                    $('#tasklist ul li a').removeClass('active');
                                    $(this).addClass('active');
                                });
                                $('a#loadmytasksCancel').click(function(){
                                    ajaxRequest = $('#loadmytasksCancelValue').serialize();
                                    clearTimeout(ajaxUpdateTimeout);
                                    ajaxUpdateTimeout = setTimeout(function () {
                                        $.fn.yiiListView.update( 'loadmypostedtask',{data: ajaxRequest})
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
                </div>
                <!--Start search Ends here-->

                <!--Advance filter Start here--> 

                <div class="advncsearch">
                    <div class="advnc_row">Task type</div>
                    <div class="advnc_row2">
                        <div class="advnc_col3">
                            <select name="">
                                <option>Select task type</option>
                            </select></div>
                    </div>
                </div> 

                <div class="advncsearch">
                    <div class="advnc_row">Task title</div>
                    <div class="advnc_row2">
                        <div class="advnc_col1"><input name="" type="text" placeholder="Enter tasker name" /></div>
                        <div class="advnc_col2"><input name="" type="button" value="Go" class="go_btn" /></div>
                    </div>
                </div>  

                <div class="advncsearch">
                    <div class="advnc_row">Skills</div>
                    <div class="advnc_row2">
                        <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Web designing</label>
                        <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Mobile application</label>
                        <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Software application</label>
                        <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Other IT & programming</label>
                    </div>
                </div> 

                <div class="advncsearch">
                    <div class="advnc_row">Category</div>
                    <div class="advnc_row2">
                        <div class="advnc_row3">
                            <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Web designing</label>
                            <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Mobile application</label></div>
                        <div class="advnc_col6"><label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Web designing</label>
                            <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Mobile application</label></div>

                        <div class="advnc_row3">
                            <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Software application</label>
                            <label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Other IT & programming</label></div>
                        <div class="advnc_col6"><label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Web designing</label>

                            <div class="advnc_row3"><label class="checkbox chkcolor"><input name="" type="checkbox" value="" />Mobile application</label></div>
                        </div>
                    </div></div>

                <div class="advncsearch">
                    <div class="advnc_row">Distance</div>
                    <div class="advnc_row2">

                        <div class="advnc_col4">
                            <label class="radio">
                                <input type="radio"  value="all" name=""> Miles away </label></div>
                        <div class="advnc_col4">
                            <label class="radio">
                                <input type="radio" value="all" name=""> Anywhere </label></div>
                        <img src="../images/distance.jpg" style=" max-width:248px;width:251px; height:39px;"></div>
                </div> 

                <div class="advncsearch">
                    <div class="advnc_row">Location</div>
                    <div class="advnc_row2">
                        <div class="advnc_col3">
                            <select name="">
                                <option>Select your country/Region</option>
                            </select></div>
                    </div>
                </div> 


                <!--Advance filter Ends here-->     


            </div>
        </div>
        <!--Filter tast Ends here-->


    </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar">
        <div class="box">
            <div class="box_topheading">
                <h3 class="h3"><?php echo Yii::t('poster_mytasks', 'My posted projects') ?></h3></div>
            <div class="sortby_row">                                                               
<!--                <div class="ntointrested">Found 50 results</div>-->
                <div class="sortby">
                    <select class="span2" name="archive">
                        <option>Sort by</option>
                    </select>
                </div>
            </div> 
            <div class="rowselector positionRelativeClass">
            <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadmypostedtask',
                    'dataProvider' => $mytasklist,
                    'itemView' => '_mytasks',
                    'template'=>'{items}{pager}',
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.rowselector',
                        'itemsSelector' => '.list-view',
                        'listViewId' => 'loadAllProposalsMain',
                        'header' => '',
                        'loaderText' => 'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 0, 'trigger' => 'Load more'),
                    ),
                    ));
                ?> 
                </div> 
        </div>        
    </div>
</div>
<!--Right side content ends here-->


</div>