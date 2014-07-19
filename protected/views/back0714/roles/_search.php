<?php
/* @var $this RolesController */
/* @var $model Roles */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
	<div class="span2"><div class="control-group">
		<?php echo $form->label($model,'role_name',array('class'=>'control-label','label'=>Yii::t('admin_roles_search','role_name_text'))); ?>
                
                
          <?php      
          //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
          CommonUtility::autocomplete('role_name','roles/autocompletelookup',10,$fillFields,'span12',20,20); 
          ?>
        </div></div>
        
	<div class="span2"><div class="control-group">
		<?php echo $form->label($model,'role_permission',array('class'=>'control-label','label'=>Yii::t('admin_roles_search','role_permission_text'))); ?>
		<div class="controls"> 
		<?php  
                        $models =  $model::getmodels();
                        echo $form->dropDownList($model, 'role_permission', $models, array('empty' => '--Select Model--','class' => 'Select_box',
                        'options' => array(CommonUtility::createValue($fillFields,'role_permission') =>array('selected'=>true)) ));
                ?>
                </div>
	</div></div>
        <div class="span2 topspace">
		<span><?php echo CHtml::submitButton(Yii::t('admin_roles_search','search_text'),array('class'=>'btn blue')); ?></span><span class="space"><?php echo CHtml::resetButton(Yii::t('admin_roles_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?></span>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->