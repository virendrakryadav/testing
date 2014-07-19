<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
//print_r($fillFields);
?>
    <div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'city_name',array('class'=>'control-label','label'=>Yii::t('admin_city_search','city_name_text'))); ?>
            <div class="controls"> 
            <?php      
                  //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                  CommonUtility::autocomplete('city_name','city/autocompletename',10,$fillFields,'span12',60,250); 
            ?>

            <?php //echo $form->textField($model,'state_name',array('class'=>'span12','size'=>60,'maxlength'=>250,'value'=>CommonUtility::createValue($fillFields,'state_name'))); ?>
            </div>
        </div>
    </div>
    <div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_city_search','country_code_text'))); ?>
            <div class="controls">
            <?php  
                
                        $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                        echo $form->dropDownList($model, 'country_code', $list, 
                        array('prompt'=>'Select Country',
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('state/ajaxgetstate'),
                                           'success' => "function(data){
                                               $('#City_state_id').html(data);
                                               $('#City_region_id').html('<option value=\"\">--Select Region--</option>');
                                                }",
                                           'data' => array('country_code'=>'js:this.value')),
                            'options' => array(CommonUtility::createValue($fillFields,'country_code')=>array('selected'=>true)),'class' => 'span12'));
            ?>

            </div>
        </div>
    </div>
   
    <div class="span2">
        <div class="control-group">
                <?php 
                    $statelist = array();
                    if(CommonUtility::createValue($fillFields,'country_code'))
                    {
                        $state_id = CommonUtility::createValue($fillFields,'country_code');
                       $statelist = CHtml::listData(StateLocale::getStateList($state_id),'state_id', 'state_name');
                    }
                ?>
                <?php echo $form->label($model,'state_id',array('class'=>'control-label','label'=>Yii::t('admin_city_search','state_id_text'))); ?>
                <div class="controls"><?php echo $form->dropDownList($model,'state_id',$statelist,
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('region/ajaxgetregion'),
                            'update' => '#City_region_id',
                            'data' => array('state_id'=>'js:this.value')),
                            'options' => array(CommonUtility::createValue($fillFields,'state_id')=>array('selected'=>true)),'class' => 'span12')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'state_id'); ?>
                    </span>
                </div>
        </div>
    </div>
    
    <div class="span2">
        <div class="control-group">
                
                <?php echo $form->label($model,'region_id',array('class'=>'control-label','label'=>Yii::t('admin_city_search','region_id_text'))); ?>
                <div class="controls">
                <?php 
                    $regionlist = array();
                    if(CommonUtility::createValue($fillFields,'state_id'))
                    {
                       $regionlist = CHtml::listData(RegionLocale::getRegionList(CommonUtility::createValue($fillFields,'state_id')),'region_id', 'region_name');
                    }
                ?>
                <?php echo $form->dropDownList($model,'region_id',$regionlist,
                        array('prompt'=>'--Select Region--',
                            'options' => array(CommonUtility::createValue($fillFields,'region_id')=>array('selected'=>true)),'class' => 'span12')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'region_id'); ?>
                    </span>
                </div>
        </div>
    </div>	
    
    <div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'city_status',array('class'=>'control-label','label'=>Yii::t('admin_city_search','city_status_text'))); ?>
            <div class="controls"> 
            <?php echo UtilityHtml::getStatusDropdown($model,'city_status', CommonUtility::createValue($fillFields,'city_status')); ?>
            </div>
        </div>
    </div>
<!--    <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'language_code',array('class'=>'control-label')); ?>
		<div class="controls">
                    <?php echo UtilityHtml::getLanguageDropdown($model,'language_code', CommonUtility::createValue($fillFields,'language_code')); ?>
                </div>
            </div>
    </div>-->
    <div class="span2 topspace">
            <?php echo CHtml::submitButton(Yii::t('admin_city_search','search_text'),array('class'=>'btn blue')); ?>
            <?php echo CHtml::resetButton(Yii::t('admin_city_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->