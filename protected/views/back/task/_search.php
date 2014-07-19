<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
//        'id'=>'search-form',
)); 
//print_r($fillFields);
?>	
	<div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'title',array('class'=>'control-label','label'=>'Task')); ?>
                <div class="controls">
		<?php
                CommonUtility::autocomplete('title','task/autocompletename',10,$fillFields,'span12',60,250);
//                echo $form->textField($model,'skill_id',array('class'=>'span12 ac_input')); ?>
                </div>
                </div>
	</div>
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'creator_user_id',array('class'=>'control-label','label'=>'Posted By')); ?>
                <div class="controls">
		<?php
                CommonUtility::autocomplete('creator_user_id','task/autocompletepostername',10,$fillFields,'span12',60,250);?>
                </div>
              </div>
	</div>
    
        <div class="span2">
                <div class="control-group">
                    <?php echo $form->label($model,'tasker_id',array('class'=>'control-label','label'=>'Received By')); ?>
                    <div class="controls">
                    <?php
                    CommonUtility::autocomplete('tasker_id','task/autocompletepostername',10,$fillFields,'span12',60,250);?>
                    </div>
                </div>
        </div>
    
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'location_geo_area',array('class'=>'control-label','label'=>'Location')); ?>
                <div class="controls">
		<?php
                CommonUtility::autocomplete('location_geo_area','task/autocompletelocation',10,$fillFields,'span12',60,250);?>
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
                                            'success' => "function(data){}",
                                            'data' => array('country_code'=>'js:this.value')),
                                'options' => array(CommonUtility::createValue($fillFields,'country_code')=>array('selected'=>true)),'class' => 'span12'));
                ?>

                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'state',array('class'=>'control-label','label'=>'State')); ?>
                <div class="controls">
		<?php echo $form->dropDownList($model,'state',
                        array(''=>'all','o'=>'open for bid','c'=>'cancelled','a'=>'assigned to tasker','f'=>'finished','d'=>'under dispute','s'=>'suspended'),array('options' => array(CommonUtility::createValue($fillFields,'state')=>array('selected'=>true))));?>
                </div>
                </div>
	</div>
	<div class="span2 topspace">
            <?php echo CHtml::submitButton('Search',array('class'=>'btn blue')); ?>
            <?php echo CHtml::resetButton('Reset', array('id'=>'form-reset-button', 'class'=>'btn')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->