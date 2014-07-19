<?php
/* @var $this CategoryController */
/* @var $model Category */
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
		<?php echo $form->label($model,'category_name',array('class'=>'control-label','label'=>Yii::t('admin_category_search','category_name_text'))); ?>
                <div class="controls"> 
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('category_name','category/autocompletename',10,$fillFields,'span12',60,250); 
                ?>
                    
		<?php //echo $form->textField($model,'category_name',array('class'=>'span12','size'=>60,'maxlength'=>250,'value'=>CommonUtility::createValue($fillFields,'category_name'))); ?>
                </div>
            </div>
        </div>

	<div class="span2"><div class="control-group">
		<?php echo $form->label($model,'category_status',array('class'=>'control-label','label'=>Yii::t('admin_category_search','category_status_text'))); ?>
		<div class="controls">
		<?php echo UtilityHtml::getStatusDropdown($model,'category_status', CommonUtility::createValue($fillFields,'category_status')); ?>
	</div>
	</div></div>


        <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_category_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_category_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->