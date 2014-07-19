<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route).'?id='.$_GET['id'],
	'method'=>'get',
));  

               ?>

    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($task, Globals::FLD_NAME_TITLE); ?>
		<div class="controls"> 
               
		<?php echo $form->textField($task, Globals::FLD_NAME_TITLE,array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,Globals::FLD_NAME_TITLE ,Globals::FLD_NAME_TASK ))); ?>
                </div>
	</div>
    </div>
    
    <div class="span2">
            <div class="control-group">
		<?php echo $form->label($task,Globals::FLD_NAME_TASK_STATE,array('class'=>'control-label','label'=>'Status')); ?>
                <div class="controls">
		<?php echo $form->dropDownList($task,Globals::FLD_NAME_TASK_STATE,
                    UtilityHtml::getTaskStateArray()
                       ,array('options' => array(CommonUtility::createValue($fillFields,Globals::FLD_NAME_TASK_STATE,Globals::FLD_NAME_TASK)=>array('selected'=>true))));?>
                </div>
                </div>
	</div>

    <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_admin_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_admin_search','reset_text'), array('id'=>'form-reset-button2','class'=>'btn')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->