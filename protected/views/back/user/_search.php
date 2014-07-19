<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));  

               ?>

<!--    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'login_name',array('class'=>'control-label','label'=>Yii::t('admin_admin_search','login_name_text'))); ?>
		<div class="controls"> 
                <?php      //print_r($fillFields);exit;
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('login_name','admin/autocompletelogin_name',10,$fillFields,'span12',60,250); 
                ?>
		<?php //echo $form->textField($model,'login_name',array('class'=>'span12','size'=>2,'maxlength'=>2,'style' => 'text-transform: uppercase', 'value'=>CommonUtility::createValue($fillFields,'login_name'))); ?>
                </div>
	</div>
    </div>-->
    
    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'firstname',array('class'=>'control-label','label'=>Yii::t('admin_admin_search','user_firstname_text'))); ?>
		<div class="controls"> 
                
		<?php echo $form->textField($model,'firstname',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'firstname'))); ?>
                </div>
	</div>
    </div>
    
    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'email',array('class'=>'control-label','label'=>Yii::t('admin_admin_search','user_email_text'))); ?>
		<div class="controls"> 
                <?php      
                      //autocomplete($name,$url,$limit,$value,$class,$size=40,$maxLength=50)
                      CommonUtility::autocomplete('email','admin/autocompleteemail',10,$fillFields,'span12',60,250); 
                ?>
		<?php //echo $form->textField($model,'email',array('class'=>'span12','size'=>2,'maxlength'=>2,'style' => 'text-transform: uppercase', 'value'=>CommonUtility::createValue($fillFields,'email'))); ?>
                </div>
	</div>
    </div>
    
    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'phone',array('class'=>'control-label','label'=>Yii::t('admin_admin_search','user_phone_text'))); ?>
		<div class="controls"> 
		<?php echo $form->textField($model,'phone',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'phone'))); ?>
                </div>
	</div>
    </div>

    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'status',array('class'=>'control-label','label'=>'Status')); ?>
		<div class="controls"> 
		<?php echo UtilityHtml::getStatusDropdownAandNandS($model,'status', CommonUtility::createValue($fillFields,'status')); ?>
                </div>
	</div>
    </div>
    
<!--    <div class="span2">
        <div class="control-group">
		<?php echo $form->label($model,'user_roleid',array('class'=>'control-label','label'=>Yii::t('admin_admin_search','user_roleid_text'))); ?>
		<div class="controls"> 
		<?php  $roles = Roles::model()->findAll(
                        array('order' => 'role_name'));

                        $list = CHtml::listData($roles, 
                            'role_id', 'role_name');

                        echo $form->dropDownList($model, 'user_roleid', $list, array('empty' => 'Select Admin Role','class' => 'Select_box',
                            'options' => array(CommonUtility::createValue($fillFields,'user_roleid') =>array('selected'=>true)) ));
               
//                        echo $form->hiddenField($model,'is_admin',array('value'=>'0'));
                        ?>
                </div>
	</div>
    </div>-->

    <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_admin_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_admin_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->