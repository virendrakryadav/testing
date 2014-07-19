<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search-form',
)); ?>
    <div class="prvlist_box">

        <div class="span2"><div class="control-group">
		<?php //echo $form->label($task,'fds',array('class'=>'control-label','label'=>Yii::t('admin_category_search','category_status_text'))); ?>
		<div class="controls">
		<?php //echo $form->textField($task,'dfgds',array('size'=>60,'maxlength'=>100,'class'=>'span6'));?>
	</div>
	</div></div>

               <div><?php echo Yii::t('poster_createtask', 'Keyword')?></div>
               <?php //echo $form->label($task,'title',array('class'=>'control-label','label'=>Yii::t('admin_category_search','category_status_text'))); ?>
               <div><?php echo Yii::t('poster_createtask', 'City')?></div>
               <input type="text">
               <div><?php echo Yii::t('poster_createtask', 'Zip')?></div>
               <input type="text">
               <div><?php echo Yii::t('poster_createtask', 'Select Category')?></div>
               <input type="text">
              <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_category_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_category_search','reset_text'), array('id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div>
            </div>
    <?php $this->endWidget(); ?>