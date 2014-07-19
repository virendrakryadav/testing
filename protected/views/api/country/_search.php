<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */
?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search-form',
)); 
//print_r($fillFields);
//print_r();
?>

	<div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'country_code',array('class'=>'control-label','label'=>Yii::t('admin_country_search','country_code_text'))); ?>
		<div class="controls"> 
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('country_code','country/autocompletecountrycode',10,$fillFields,'span12 uppercase',2,2); 
                ?>
		<?php // echo $form->textField($model,'cou_code',array('class'=>'span12','size'=>2,'maxlength'=>2,'style' => 'text-transform: uppercase', 'value'=>CommonUtility::createValue($fillFields,'cou_code'))); ?>
                </div>
            </div>
        </div>

		<div class="span2"><div class="control-group">
		<?php echo $form->label($model,'country_name',array('class'=>'control-label','label'=>Yii::t('admin_country_search','country_code_text'))); ?>
		<div class="controls">
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('country_name','country/autocompletecountryname',10,$fillFields,'span12',60,250); 
                ?>
		<?php //echo $form->textField($model,'cou_name',array('class'=>'span12','size'=>60,'maxlength'=>250, 'value'=>CommonUtility::createValue($fillFields,'cou_name'))); ?></div>
	</div></div>

		<div class="span2"><div class="control-group">
		<?php echo $form->label($model,'country_status',array('class'=>'control-label','label'=>Yii::t('admin_country_search','country_status_text'))); ?>
		<div class="controls">
		<?php echo UtilityHtml::getStatusDropdown($model,'country_status', CommonUtility::createValue($fillFields,'country_status')); ?></div>
	</div></div>
    
<!--        <div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'language_code',array('class'=>'control-label')); ?>
		<div class="controls">
                    <?php echo UtilityHtml::getLanguageDropdown($model,'language_code', CommonUtility::createValue($fillFields,'language_code')); ?>
                </div>
            </div>
        </div>-->
	
	<div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_country_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_country_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->