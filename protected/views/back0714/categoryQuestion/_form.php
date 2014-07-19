<?php
/* @var $this CategoryQuestionController */
/* @var $model CategoryQuestion */
/* @var $form CActiveForm */           
?>
<script type="text/javascript">
jQuery(document).ready(function(){
   jQuery('#CategoryQuestion_question_type_0').change(function(){
      jQuery('#expectedAnsLogical').css({'display': 'block'});
      jQuery('#expectedAnsDesc').css({'display': 'none'});
   });
   jQuery('#CategoryQuestion_question_type_1').change(function(){
      jQuery('#expectedAnsLogical').css({'display': 'none'});
      jQuery('#expectedAnsDesc').css({'display': 'block'});
   });
});
</script>
<div class="wide form" style="padding:10px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-question-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true
	),
)); ?>

<div class="row-fluid form-horizontal">

	<?php //echo $form->errorSummary($locale); ?>
        <?php
                if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,'question_id');
                }
                ?>
	<div class="control-group">
        <?php echo $form->labelEx($locale,'category_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <select id="CategoryQuestionLocale_category_id" name='CategoryQuestionLocale[category_id]' class ="span3 skills" >
                    <?php echo UtilityHtml::getCategoryListNasted('',$locale->category_id); ?>
                </select>
		<?php //echo $form->textField($locale,'category_id'); ?>
		<span class="help-inline"><?php echo $form->error($locale,'category_id'); ?></span>
            </div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($locale,'question_desc',array('class'=>'control-label','label'=>'Question')); ?>
		<div class="controls">
                <?php //echo $form->textArea($locale, 'question_desc', array('class'=>'span7','maxlength' => 1000, 'rows' => 5,)); ?>
                <?php echo $form->textField($locale,'question_desc',array('size'=>1,'maxlength'=>2000,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'question_desc'); ?></span>
                </div>
	</div>
        <div class="control-group">
		<?php echo $form->labelEx($model,'question_type',array('class'=>'control-label')); ?>
		<div class="controls">
                <?php echo $form->radioButtonList($model, 'question_type',array('l'=>'Logical','d'=>'Descriptive'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>')); //,'v'=>'Online'?>
                <?php //echo $form->textField($locale,'question_type',array('size'=>1,'maxlength'=>1,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($model,'question_type'); ?></span>
                </div>
	</div>
   
   <div class="control-group" id="expectedAnsLogical" <?php echo ($model->{Globals::FLD_NAME_QUESTION_TYPE}  === 'l') ? 'style=display:block;' : 'style=display:none;'; ?> >
		<?php echo $form->labelEx($locale,'expected_answer_logical',array('class'=>'control-label','label'=>'Expected Answer')); ?>
		<div class="controls">
                <?php echo $form->radioButtonList($locale, 'expected_answer_logical',array('1'=>'True / Yes','0'=>'False / No'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
                <?php //echo $form->textField($locale,'question_type',array('size'=>1,'maxlength'=>1,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'expected_answer_logical'); ?></span>
                </div>
	</div>
   <div class="control-group" id="expectedAnsDesc" <?php echo ($model->{Globals::FLD_NAME_QUESTION_TYPE}  === 'd') ? 'style=display:block;' : 'style=display:none;'; ?> >
		<?php echo $form->labelEx($locale,'expected_answer_desc',array('class'=>'control-label','label'=>'Expected Answer')); ?>
		<div class="controls">
                <?php echo $form->textArea($locale, 'expected_answer_desc', array('class'=>'span7','maxlength' => 1000, 'rows' => 5,)); ?>
                <?php //echo $form->textField($locale,'expected_answer_desc',array('size'=>1,'maxlength'=>2000,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'expected_answer_desc'); ?></span>
                </div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'question_for',array('class'=>'control-label')); ?>
		<div class="controls">
                <?php echo $form->radioButtonList($model, 'question_for',array('p'=>'Poster','t'=>'Tasker','b'=>'Both'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
                <?php //echo $form->textField($locale,'question_for',array('size'=>1,'maxlength'=>1,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($model,'question_for'); ?></span>
                </div>
	</div>
        <div class="control-group">
		<?php echo $form->labelEx($model,'is_answer_must',array('class'=>'control-label')); ?>
		<div class="controls">
                <?php echo $form->radioButtonList($model, 'is_answer_must',array('1'=>'Yes','0'=>'No'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
                <?php //echo $form->textField($locale,'is_answer_must',array('size'=>1,'maxlength'=>1,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($model,'is_answer_must'); ?></span>
                </div>
	</div>
        <div class="control-group">
		<?php echo $form->labelEx($locale,'status',array('class'=>'control-label')); ?>
		<div class="controls">
                <?php echo $form->radioButtonList($locale,'status',array('a'=>'Active','n'=>'In-Active'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
                <?php //echo $form->textField($locale,'is_answer_must',array('size'=>1,'maxlength'=>1,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($locale,'status'); ?></span>
                </div>
	</div>
	<div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'btn blue')); ?>
			<?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>

</div></div><!-- form -->