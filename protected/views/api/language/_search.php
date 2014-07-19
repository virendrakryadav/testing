<?php
/* @var $this LanguageController */
/* @var $model Language */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

        <div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'language_code',array('class'=>'control-label','label'=>Yii::t('admin_language_search','language_code_text'))); ?>
            <div class="controls"> 
            <?php      
                  //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                  CommonUtility::autocomplete('language_code','language/autocompletecode',10,$fillFields,'span12',60,250); 
            ?>
            </div>
        </div>
        </div>
	
        <div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'language_name',array('class'=>'control-label','label'=>Yii::t('admin_language_search','language_name_text'))); ?>
            <div class="controls"> 
            <?php      
                  //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                  CommonUtility::autocomplete('language_name','language/autocompletename',10,$fillFields,'span12',60,250); 
            ?>
            </div>
        </div>
        </div>

	<div class="span2">
        <div class="control-group">
            <?php echo $form->label($model,'language_status',array('class'=>'control-label','label'=>Yii::t('admin_language_search','language_status_text'))); ?>
            <div class="controls"> 
            <?php echo UtilityHtml::getStatusDropdown($model,'language_status', CommonUtility::createValue($fillFields,'language_status')); ?>
            </div>
        </div>
        </div>

	 <div class="span2 topspace">
            <?php echo CHtml::submitButton(Yii::t('admin_language_search','search_text'),array('class'=>'btn blue')); ?>
            <?php echo CHtml::resetButton(Yii::t('admin_language_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->