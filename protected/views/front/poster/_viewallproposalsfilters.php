<!--Start search Ends here-->
<?php echo CHtml::beginForm("#", 'get', array('id' => 'filter-form-porposals')); ?>
<!--Advance filter Start here-->     
<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'Doer name')?></div>
    <div class="col-md-12 pdn-auto">
        <div class="col-md-10 no-mrg"><?php echo CHtml::textField(Globals::FLD_NAME_USER_NAME, $taskerName, array('id' => 'taskerName', 'placeholder' => 'Enter doer name', 'class' => 'form-control')); ?></div>
        <div class="col-md-1 no-mrg"><input name="" id="searchByTaskName" type="button" value="Go" class="btn-u btn-u-lg pdn-btn btn-u-sea" /></div>
    </div>
</div>  

<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'Price range')?></div>

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

                }',
            ),
            // slider css options
            'htmlOptions' => array(
                'style' => 'margin: 0 0 0 5px;max-width: 240px;width: 233px;'
            ),
        ));
        ?>
        <?php echo Yii::t('poster_createtask', 'Price Range')?>:<span id="priceRange"><?php echo $minPriceValue . "-" . $maxPriceValue ?></span>
        <?php echo CHtml::hiddenField('minprice', $minPriceValue, array('id' => 'minprice')); ?>
        <?php echo CHtml::hiddenField('maxprice', $maxPriceValue, array('id' => 'maxprice')); ?>
    <!--<img src="../images/pricerange.jpg" style=" max-width:248px;width:251px; height:39px;">-->
    </div>
</div> 

<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'lbl_ratings')?></div>
    <div class="col-md-12 pdn-auto"> <?php UtilityHtml::getSearchByRating( 'ratings' , $rating )?></div> 
</div>
<?php
if( $isFieldAccessByTaskTypeVirtual )
{
?>
<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'lbl_distance')?></div>


    <div class="col-md-12 pdn-auto">

        <?php echo CHtml::radioButtonList('choice', 'miles', array('miles' => 'Miles away', 'all' => 'Anywhere',), array('separator' => "  ",
            'template' => "<div class='advnc_col4'>{input} {label}</div>", 'labelOptions' => array('style' => 'display:inline;font-weight: normal;'))); ?>
        <div class="formRelative"> </div>
        <div id="locationSlider"> 
            <?php
            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                'name' => Globals::FLD_NAME_TASKER_IN_RANGE,
                'value' => '', // default selection 
                'event' => 'change',
                'options' => array(
                    'min' => 0, //minimum value for slider input
                    'max' => 100, // maximum value for slider input
                    'animate' => true,
                    'range' => 'max',
                    // on slider change event 
                    'slide' => 'js:function(event,ui){$("#locationRange").html(ui.value);$("#tasker_in_range").val(ui.value);}',
                    'stop' => 'js:function(event,ui){
                                var data = $("#tasker_in_range").serialize() ;    
                                SearchFunc(data);
                        }',
                ),
                // slider css options
                'htmlOptions' => array(
                    'style' => 'width:200px;background-color:red;'
                ),
            ));
            ?>
            <span id="locationRange"><?php  echo Globals::DEFAULT_VAL_PRICE_RANGE ?></span> <?php echo Yii::t('poster_createtask', 'lbl_miles')?> 
        </div>
    </div>
</div> 
<?php
}
?>

<?php $this->renderPartial('//tasker/_searchbycountry');?>


<?php echo CHtml::endForm(); ?>
<!--Advance filter Ends here-->     