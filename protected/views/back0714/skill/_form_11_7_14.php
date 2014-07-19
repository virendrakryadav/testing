<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $form CActiveForm */
?>

<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skill-form',	
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true
	),
)); ?>
    <div class="row-fluid form-horizontal">
        <?php
                if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,'skill_id');
                    echo $form->hiddenField($locale,'current', array('value'=>$locale->skill_desc));
                }
                ?>
	<div class="control-group">
		<?php echo $form->labelEx($locale,'skill_desc',array('class'=>'control-label','label'=>'Skill')); ?>
                <div class="controls">
		<?php echo $form->textField($locale,'skill_desc',array('size'=>1,'maxlength'=>200,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'skill_desc'); ?></span>
                </div>
	</div>

        <div class="control-group">
        <?php echo $form->labelEx($model,'category_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <select id="Skill_category_id" name='Skill[category_id]' class ="span3 skills" >
                    <?php echo UtilityHtml::getCategoryListNasted('',$model->category_id); ?>
                </select>
		<?php //echo $form->textField($locale,'category_id'); ?>
		<span class="help-inline"><?php echo $form->error($model,'category_id'); ?></span>
            </div>
	</div>

	<div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'btn blue')); ?>
			<?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->