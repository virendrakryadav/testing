<?php
/* @var $this SkillController */
/* @var $model Skill */
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
		<?php echo $form->label($model,'skill_desc',array('class'=>'control-label','label'=>'Skill')); ?>
                <div class="controls">
		<?php
                CommonUtility::autocomplete('skill_desc','skill/autocompletename',10,$fillFields,'span12',60,250);
//                echo $form->textField($model,'skill_id',array('class'=>'span12 ac_input')); ?>
                </div>
                </div>
	</div>
	<div class="span2 topspace">
            <?php echo CHtml::submitButton('Search',array('class'=>'btn blue')); ?>
            <?php echo CHtml::resetButton('Reset', array('id'=>'form-reset-button', 'class'=>'btn')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->