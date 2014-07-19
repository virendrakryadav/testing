 <!--Start search Ends here-->
                <?php echo CHtml::beginForm("#", 'get', array('id' => 'filter-form-taskers')); ?>
             
            
                <!--Advance filter Start here-->     
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
                   
<!--                <div class="advncsearch">
                <div class="advnc_row"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_skills'));?></div>
                <div class="advnc_row2">
                <label class="checkbox chkcolor">
                    <input type="checkbox" value="" name=""><?php echo Yii::t('poster_createtask', 'Web designing')?>
                </label>
                <label class="checkbox chkcolor">
                    <input type="checkbox" value="" name=""><?php echo Yii::t('poster_createtask', 'Mobile application')?>
                </label>
                <label class="checkbox chkcolor">
                    <input type="checkbox" value="" name=""><?php echo Yii::t('poster_createtask', 'Software application')?>
                </label>
                <label class="checkbox chkcolor">
                    <input type="checkbox" value="" name=""><?php echo Yii::t('poster_createtask', 'Other IT &amp; programming')?>
                </label>
                </div>
                </div>-->
                
<!--                <div class="advncsearch">
                    <div class="advnc_row"><?php echo CHtml::encode(Yii::t('poster_findtasker', 'txt_distance'));?></div>
                    <div class="advnc_row2">

                        <?php echo CHtml::radioButtonList('choice', 'miles', array('miles' => 'Miles away', 'all' => 'Anywhere',), array('separator' => "  ",
                            'template' => "<div class='advnc_col4'>{input} {label}</div>", 'labelOptions' => array('style' => 'display:inline;font-weight: normal;'))); ?>
                        <div class="formRelative"> </div>
                        <div id="locationSlider"> 
                            <?php
//                            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
//                                'name' => Globals::FLD_NAME_TASK_TASKER . '[' . Globals::FLD_NAME_TASKER_IN_RANGE . ']',
//                                'value' => '', // default selection 
//                                'event' => 'change',
//                                'options' => array(
//                                    'min' => 0, //minimum value for slider input
//                                    'max' => 100, // maximum value for slider input
//                                    'animate' => true,
//                                    'range' => 'max',
//                                    // on slider change event 
//                                    'slide' => 'js:function(event,ui){$("#locationRange").html(ui.value);$("#TaskTasker_tasker_in_range").val(ui.value);}',
//                                    'stop' => 'js:function(event,ui){
//                                            var form = $(this).closest(\'form\').attr(\'id\');
//                                            $.fn.yiiListView.update(\'loadAllProposals\', {data: $(\'#\'+form).serialize()});
//                                        }',
//                                ),
//                                // slider css options
//                                'htmlOptions' => array(
//                                    'style' => 'width:200px;background-color:red;'
//                                ),
//                            ));
                            ?>
                            <span id="locationRange">0</span> <?php // echo CHtml::encode(Yii::t('poster_findtasker', 'lbl_miles'));?>
                        </div>
                    </div>
                </div> -->

                <?php $this->renderPartial('//tasker/_searchbycountry',array('name' => Globals::FLD_NAME_LOCATIONS , 'filter' => Globals::DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER));?>
<!--                <div class="advncsearch">
                    <div class="advnc_row marginadv-bottom-10"><?php //echo Yii::t('poster_createtask', 'txt_location')?></div>
                    <div class="col-md-12 pdn-auto">
                    <div class="col-md-12 no-mrg">
                    <?php  //UtilityHtml::getTaskTypeDropDown( "taskType" , (isset($_GET["taskType"])) ? $_GET["taskType"] : ''   ); ?>
                    </div>
                    </div>
                </div>-->
                <?php echo CHtml::endForm(); ?>