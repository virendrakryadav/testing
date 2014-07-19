<?php
/* @var $this CategoryQuestionController */
/* @var $model CategoryQuestion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
//ssssprint_r($fillFields);
?>
	<div class="span2">
            <div class="control-group">
		<?php echo $form->label($model,'question_desc',array('class'=>'control-label','label'=>'Question')); ?>
                <div class="controls">
		<?php
                CommonUtility::autocomplete('question_desc','categoryquestion/autocompletename',10,$fillFields,'span12',60,250);
                //echo $form->textField($model,'question_desc',array('class'=>'span12 ac_input')); ?>
                </div>
                </div>
	</div>	        
	<div class="span2 topspace">
            <?php echo CHtml::submitButton(Yii::t('admin_city_search','search_text'),array('class'=>'btn blue')); ?>
            <?php echo CHtml::resetButton(Yii::t('admin_city_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->