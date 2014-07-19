<?php
/* @var $this StateController */
/* @var $model State */
/* @var $form CActiveForm */
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'state_name',array('class'=>'control-label','label'=>Yii::t('admin_state_search','state_name_text'))); ?>
                <div class="controls"> 
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('state_name','state/autocompletestatename',10,$fillFields,'span12',60,250); 
                ?>
                    
		<?php //echo $form->textField($model,'state_name',array('class'=>'span12','size'=>60,'maxlength'=>250,'value'=>CommonUtility::createValue($fillFields,'state_name'))); ?>
                </div>
            </div>
        </div>
    
		<div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_state_search','country_code_text'))); ?>
		<div class="controls"> 
		<?php  $list = CHtml::listData(Country::getCountryList(),'country_code', 'countrylocale.country_name');

                        echo $form->dropDownList($model, 'country_code', $list, array('empty' => '--Select Country--','class' => 'Select_box',
                            'options' => array(CommonUtility::createValue($fillFields,'country_code') =>array('selected'=>true)) ));
                ?>
                </div>
	</div>
    </div>

        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'state_status',array('class'=>'control-label','label'=>Yii::t('admin_state_search','state_status_text'))); ?>
                <div class="controls"> 
		<?php echo UtilityHtml::getStatusDropdown($model,'state_status', CommonUtility::createValue($fillFields,'state_status')); ?>
                </div>
            </div>
        </div>
<!--      <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'language_code',array('class'=>'control-label','label'=>Yii::t('admin_state_search','language_code_text'))); ?>
		<div class="controls">
                    <?php echo UtilityHtml::getLanguageDropdown($model,'language_code', CommonUtility::createValue($fillFields,'language_code')); ?>
                </div>
            </div>
        </div>-->
		<div class="span2 topspace">
			<?php echo CHtml::submitButton(Yii::t('admin_state_search','search_text'),array('class'=>'btn blue')); ?>
			<?php echo CHtml::resetButton(Yii::t('admin_state_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->