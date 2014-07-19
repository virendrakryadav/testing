<?php
$maxPriceValue = isset($maxPriceValue) ? $maxPriceValue : $maxPrice;
$minPriceValue = isset($minPriceValue) ? $minPriceValue : $minPrice;
$date = isset($date) ? $date : '';
$rating = isset($rating) ? $rating : '';
$isLogin = CommonUtility::isUserLogin();

 
?>
<?php if($isLogin)
{
    
      $skills = UtilityHtml::getUserSkillsListInTaskSearch( Yii::app()->user->id ); 
      if( $skills )
      {
?>
<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('tasker_mytasks', 'Skills')?></div>
    <div class="col-md-12 pdn-auto">
        <div class="advnc_row2">
            <div class="advnc_row3">
            <?php echo $skills; ?>
            </div>
        </div>
    </div>
<!--<div class="col-md-12 pdn-auto">
<div class="advnc_row2">
<div class="advnc_row3">
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Cake PHP</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Core PHP</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Html code</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>MYSQL</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Zend Framework</label>
</div>
</div>
</div>-->
</div> 
<?php
      }
}
?>
<div class="advncsearch">
<div class="advnc_row margin-bottom-10"><?php echo Yii::t('tasker_mytasks', 'Task Name')?></div>

<div class="col-md-12 pdn-auto">
    <div class="col-md-10 no-mrg"><?php //echo CHtml::textField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TITLE . ']', $taskName, array('id' => 'taskTitle', 'placeholder' => 'Enter project name', 'class' => 'form-control')); ?></div>
    <div class="col-md-1 no-mrg"><input name="" id="searchByTaskTitle" type="button" value="Go" class="btn-u btn-u-lg pdn-btn btn-u-sea" /></div>
</div>
</div> 

<div class="advncsearch">
<div class="advnc_row margin-bottom-10"><?php echo Yii::t('tasker_mytasks', 'Price range')?></div>

<div class="col-md-12 pdn-auto">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                            'name' => 'price_range',
                            'event' => 'change',
                            'options' => array(
                                'values' => array($minPriceValue, $maxPriceValue), // default selection
                                'min' => $minPrice, //minimum value for slider input
                                'max' => $maxPrice, // maximum value for slider input
                                'animate' => true,
                                // on slider  change event 
                                'slide' => 'js:function(event,ui)
                                { 
                                    $("#priceRange").html(ui.values[0]+\'-\'+ui.values[1]);
                                    $("#minprice").val(ui.values[0]);
                                    $("#maxprice").val(ui.values[1]);
                                }',
                                // on slider stop change event 
                                'stop' => 'js:function(event,ui)
                                {
                                    var data = $("#minprice").serialize()+"&"+$("#maxprice").serialize() ;    
                                    SearchFunc(data);
                                    loadfilters("'.$filter_type.'");
       

                                }',
                            ),
                            // slider css options
                                'htmlOptions' => array(
                                'style' => 'margin: 0 0 0 5px;max-width: 240px;width: 233px;'
                            ),
                        ));
                        ?>
                        <?php echo Yii::t('poster_createtask', 'Price Range')?> : <span id="priceRange"><?php echo $minPriceValue . "-" . $maxPriceValue ?></span>
                        <?php echo CHtml::hiddenField('minprice', $minPriceValue, array('id' => 'minprice')); ?>
                        <?php echo CHtml::hiddenField('maxprice', $maxPriceValue, array('id' => 'maxprice')); ?>
                    <!--<img src="../images/pricerange.jpg" style=" max-width:248px;width:251px; height:39px;">-->
                    </div>
</div> 
<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Date</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-12 no-mrg">
<?php 

echo CHtml::textField('date', $date, array('id' => 'date', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Select date')), 'class' => 'form-control')); ?>
</div>
</div>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10"><?php echo Yii::t('tasker_mytasks', 'Ratings')?></div>
<div class="col-md-12 pdn-auto">
    <?php UtilityHtml::getSearchByRating( 'ratings' , $rating , $filter_type  )?>
   
</div>
</div> 

<!--<div class="advncsearch">
<div class="advnc_row">Distance</div>
<div class="advnc_row2">


                        <?php echo CHtml::radioButtonList('choice', 'miles', array('miles' => 'Miles away', 'all' => 'Anywhere',), array('separator' => "  ",
                            'template' => "<div class='advnc_col4'>{input} {label}</div>", 'labelOptions' => array('style' => 'display:inline;font-weight: normal;'))); ?>
                        <div class="formRelative"> </div>
                        <div id="locationSlider"> 
                            
                            
                            <?php
                            
                            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                                'name' => Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASKER_IN_RANGE . ']',
                                'value' => '', // default selection 
                                'event' => 'change',
                                'options' => array(
                                    'min' => 0, //minimum value for slider input
                                    'max' => 100, // maximum value for slider input
                                    'animate' => true,
                                    'range' => 'max',
                                    // on slider change event 
                                    'slide' => 'js:function(event,ui){$("#locationRange").html(ui.value);$("#Task_tasker_in_range").val(ui.value);}',
                                    'stop' => 'js:function(event,ui){
                                         hasToRun = 1;
                                            var form = $(this).closest(\'form\').attr(\'id\');
                                            $.fn.yiiListView.update(\'loadmytasksdata\', {data: $(\'#\'+form).serialize()});
                                        }',
                                ),
                                // slider css options
                                'htmlOptions' => array(
                                    'style' => 'width:200px;'
                                ),
                            ));
                            ?>
                            <span id="locationRange">0</span> miles
                        </div>
                    </div>

</div> -->