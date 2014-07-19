<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));  

               ?>

    <div class="span3">
        <div class="control-group">
            <?php echo $form->textFieldControlGroup($model, Globals::FLD_NAME_FIRSTNAME, array( 'placeholder'=> CHtml::encode(Yii::t('index_login','First Name')))); ?>
	</div>
    </div>
    
    <div class="span3">
        <div class="control-group">
		
            <?php echo $form->textFieldControlGroup($model, Globals::FLD_NAME_EMAIL, array( 'placeholder'=> CHtml::encode(Yii::t('index_login','Email')))); ?>
	
	</div>
    </div>
    
    <div class="span3">
        <div class="control-group">
		
            <?php echo $form->textFieldControlGroup($model, Globals::FLD_NAME_USER_ID, array( 'placeholder'=> CHtml::encode(Yii::t('index_login','User Id')))); ?>
	
	</div>
    </div>
    

    <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_admin_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_admin_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->