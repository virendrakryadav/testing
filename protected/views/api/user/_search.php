<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'id'=>'search-form',
)); ?>

    
	
    <div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,'firstname',array('class'=>'control-label')); ?>
                    <div class="controls"> 
                    <?php echo $form->textField($model,'firstname',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'firstname'))); ?>
                    </div>
            </div>
        </div>
    
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'email',array('class'=>'control-label')); ?>
		<div class="controls"> 
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('email','user/autocompleteemail',10,$fillFields,'span12',60,100); 
                ?>
		<?php //echo $form->textField($model,'email',array('class'=>'span12','size'=>2,'maxlength'=>2,'style' => 'text-transform: uppercase', 'value'=>CommonUtility::createValue($fillFields,'email'))); ?>
                </div>
            </div>
        </div>
	 <div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,'mobile',array('class'=>'control-label')); ?>
                    <div class="controls"> 
                    <?php echo $form->textField($model,'mobile',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'mobile'))); ?>
                    </div>
            </div>
        </div>

	<div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'country_code',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php  
                
                        $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');
                        echo $form->dropDownList($model, 'country_code', $list, 
                        array('prompt'=>'Select Country',
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('state/ajaxgetstate'),
                                           'success' => "function(data){
                                               $('#User_state_id').html(data);
                                               $('#User_region_id').html('<option value=\"\">--Select Region--</option>');
                                               $('#User_city_id').html('<option value=\"\">--Select City--</option>');
                                               

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
                <?php echo $form->label($model,'state_id',array('class'=>'control-label')); ?>
                <div class="controls"><?php echo $form->dropDownList($model,'state_id',$statelist,
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('region/ajaxgetregion'),
                            'success' => "function(data){
                                           $('#User_region_id').html(data);
                                           $('#User_city_id').html('<option value=\"\">--Select City--</option>');
                            }",
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
                
                <?php echo $form->label($model,'region_id',array('class'=>'control-label')); ?>
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
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('city/ajaxgetcity'),
                            'update' => '#User_city_id',
                            'data' => array('region_id'=>'js:this.value')),
                                'options' => array(CommonUtility::createValue($fillFields,'region_id')=>array('selected'=>true)),'class' => 'span12')); ?>
                    <span class="help-inline">
                    <?php echo $form->error($model,'region_id'); ?>
                    </span>
                </div>
        </div>
    </div>	
     <div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,'city_id',array('class'=>'control-label')); ?>
                    <div class="controls"> 
                    <?php 
                        $citylist = array();
                        if(CommonUtility::createValue($fillFields,'region_id'))
                        {
                           $citylist = CHtml::listData(City::getCityList(CommonUtility::createValue($fillFields,'region_id')),'city_id', 'city_name');
                        }
                    ?>
                    <?php echo $form->dropDownList($model,'city_id',$citylist,array('prompt'=>'--Select City--',
                        'options' => array(CommonUtility::createValue($fillFields,'city_id')=>array('selected'=>true)),'class' => 'span12')); ?>
                    </div>
            </div>
        </div>
   

	<div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,'zip_code',array('class'=>'control-label')); ?>
                    <div class="controls"> 
                    <?php echo $form->textField($model,'zip_code',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'zip_code'))); ?>
                    </div>
            </div>
        </div>

	<div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'user_status',array('class'=>'control-label')); ?>
                <div class="controls"> 
		<?php echo UtilityHtml::getStatusDropdown($model,'user_status', CommonUtility::createValue($fillFields,'user_status')); ?>
                </div>
            </div>
        </div>
	
<div class="span2 topspace">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton('Reset', array('id'=>'form-reset-button','class'=>'btn')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->