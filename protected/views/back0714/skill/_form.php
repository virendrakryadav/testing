<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $form CActiveForm */
?>
<script>
function insertSkills()
{
    var skillvalue = $('#skillname').val();
    if(skillvalue.trim() == "")
    {
        $("#skillmain").addClass('error');  
        $("#skillerror").show();  
        $("#skillerror").html('Skill cannot be blank.');  
    }
    else
    {
        $("#skillmain").removeClass('error');  
        $("#skillerror").hide();  
        $("#skillerror").html(''); 
        
        
        jQuery.ajax({
        'dataType':'json',
        'data':{'skillvalue': skillvalue},
        'type':'POST',
        'success':function(data)
        {
            if(data.status==='success')
            {
                window.location.reload(true);
            }
            else
            {
                $("#skillmain").addClass('error');  
                $("#skillerror").show();  
                $("#skillerror").html('Skill already exists.');  
            }
        },
        'url':'<?php echo Yii::app()->createUrl('skill/addskill') ?>','cache':false});return false;
    }     
}
</script>
<div id="categorymaindiv" class="wide form" style="padding:10px;">

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
	<div class="control-group">
        <?php echo $form->labelEx($model,'category_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <select id="Skill_category_id" name='Skill_category_id' class ="span3 skills" >
                    <?php echo UtilityHtml::getCategoryListNasted('',$model->category_id); ?>
                </select>
		<span class="help-inline"><?php echo $form->error($model,'category_id'); ?></span>
            </div>
	</div>

        <div class="control-group">
        <?php echo $form->labelEx($model,'skill_id',array('class'=>'control-label')); ?>
            <div class="controls">   
                <?php echo $form->dropdownList($model,'skill_id', CHtml::listData(SkillLocale::model()->findAll(), 'skill_id', 'skill_desc'), array('empty'=>'--Select Skill--','class'=>'span3 skills')); ?>		
		<span class="help-inline"><?php echo $form->error($model,'skill_id'); ?></span>
            </div>
	</div>

	<div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'btn blue')); ?>
                <?php echo CHtml::button('Cancel', array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div></div>

<?php $this->endWidget(); ?>        
</div></div><!-- form -->


<!-- for skill-->

<div id="skillmaindiv" class="wide form" style="padding:10px;display: none">
    <div class="row-fluid form-horizontal">       
	<div class="control-group">
            <label class="control-label required">Skill <span class="required">*</span></label>
            <div class="controls" id="skillmain">   
                <input type="text" id="skillname" class="span3 skills" >
                <span class="help-inline"><div id="skillerror" class="errorMessage" style="display: none"></div></span>
            </div>
	</div>

	<div class="controls">
	<div class="span2">
            <input class="btn blue" type="button" value="Create" onclick="insertSkills();">
            <input id="form-reset-button" class="btn" type="button" value="Cancel" onclick="$('#skillmaindiv').hide();$('#categorymaindiv').show();">
	</div></div>        
</div></div><!-- form -->