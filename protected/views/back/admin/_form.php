<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>
<?php CommonScript::adminUserFormScript(); ?>
<?php Yii::import('ext.chosen.Chosen'); ?>
<div class="wide form" style="padding:10px;" >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
	//'minLevel' => '3' ,
	//'onsubmit'=>'return requerdFunn()',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		'validateOnType' => true,
		//'validateOnClick' => true
	),
)); 

?>
<div class="row-fluid form-horizontal">
<!--  <p class="note">Fields with <span class="required">*</span> are required.</p>-->
  <?php echo $form->errorSummary($model); ?>
  
  <div class="control-group"> <?php echo $form->labelEx($model,'login_name',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','login_name_text'))); ?>
    <div class="controls"> <?php echo $form->textField($model,'login_name',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?> <span class="help-inline"> <?php echo $form->error($model,'login_name'); ?> </span> </div>
  </div>
  <div class="control-group"> 
  
  <?php echo $form->labelEx($model,'firstname',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','firstname_text'))); ?>
          <!--<div class="controls"><div class="span1 margin_right" style="width:67px;"> <?php //UtilityHtml::getSalutionDropdown($model,'user_salutation',$model->user_salutation); ?>  <?php //echo $form->error($model,'user_salutation'); ?>  </div></div>-->
    
          <div class="controls"> <div class="span3 new_span3"><?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>100,'class'=>'span12')); ?>  <?php echo $form->error($model,'firstname'); ?>  </div></div>
  
    <div class="controls"> <div class="span3 new_span3"><?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>100,'class'=>'span12')); ?>  <?php echo $form->error($model,'lastname'); ?>  </div></div>

  
  </div>
   <div class="control-group"> <?php echo $form->labelEx($model,'email',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','user_email_text'))); ?>
   <?php
   if ($model->isNewRecord) 
  {
   ?>
    <div class="controls"> <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?> <span class="help-inline"> <?php echo $form->error($model,'email'); ?> </span> </div>
	<?php
	}
	else
	{
	?>
	<div class="controls"> <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'class'=>'span6','value' => CommonUtility::getUserEmail($model->user_id))); ?> <span class="help-inline"> <?php echo $form->error($model,'email'); ?> </span> </div>
	<?php
	}
	?>
  </div>
  <?php
  if ($model->isNewRecord) 
  {
    ?>
  <div class="control-group"> <?php echo $form->labelEx($model,'password',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','password_text')));?>
    <div class="controls"> 
		<?php $this->widget('ext.EStrongPassword.EStrongPassword',array('form'=>$form, 'model'=>$model, 'attribute'=>'password','htmlOptions'=>array('class'=>'Select_box span6 left_password'),));
		//echo $form->passwordField($model,'password',array('class' => 'Select_box span6')); ?> 
		<span class="help-inline"> <?php echo $form->error($model,'password'); ?> </span>
	</div>
  </div>
  <div class="control-group"> 
      <?php echo $form->labelEx($model,'repeatpassword',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','repeatpassword_text'))); ?>
        <div class="controls"> 
            <?php echo $form->passwordField($model,'repeatpassword',array('class' => 'Select_box span6')); ?> 
            <span class="help-inline"> 
                <?php echo $form->error($model,'repeatpassword'); ?> 
            </span> 
        </div>
  </div>
  <?php
  }
  ?>
  <div class="control-group"> <?php  echo $form->labelEx($model,'phone',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','user_phone_text'))); ?>
  <?php
  if($model->isNewRecord)
  {
  ?>
    <div class="controls"> <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20,'class'=>'span6')); ?> <span class="help-inline"> <?php echo $form->error($model,'phone'); ?> </span> </div>
	<?php
	}
	else
	{
	?>
	<div class="controls"> <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20,'class'=>'span6','value' => CommonUtility::getUserPhoneNumber($model->user_id))); ?> <span class="help-inline"> <?php echo $form->error($model,'phone'); ?> </span> </div>
	<?php
	}
	?>
  </div>
 
  
  <div class="control-group">
		<?php echo $form->label($model,'gender',array('label'=>Yii::t('admin_admin_admin','gender_text'))); ?>
        <div class="controls">
            <?php echo $form->radioButtonList($model,'gender', $model->getGenderOptions(),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<span class="help-inline"><?php echo $form->error($model,'gender'); ?></span></div>
	</div>
  
  <div class="control-group">
		<?php echo $form->label($model,'status',array('label'=>Yii::t('admin_admin_admin','status_text'))); ?>
        <div class="controls">
		<?php echo $form->radioButtonList($model, 'status',array('a'=>'Active','n'=>'In-Active'),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<span class="help-inline"><?php echo $form->error($model,'status'); ?></span></div>
	</div>
	
  <div class="control-group"> <?php echo $form->labelEx($model,'is_admin' ,array('class'=>'control-label','label'=>Yii::t('admin_admin_form','is_admin_text'))); ?>
    <div class="controls">
     <?php echo $form->checkBox($model,'is_admin',array('value'=>1,'uncheckValue'=>0,'class' => 'Select_box span6')); ?>
      <span class="help-inline"> <?php echo $form->error($model,'is_admin'); ?> </span> </div>
  </div>
  <div class="control-group"> <?php echo $form->labelEx($model,'user_roleid',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','user_roleid_text'))); ?>
    <?php $roles = Roles::model()->findAll(  array('order' => 'role_name'));  $list = CHtml::listData($roles, 'role_id', 'role_name');?>
    <div class="controls">
        <?php 
        
            $selectedRoles = CommonUtility::getUserSelectedRoles($model->{Globals::FLD_NAME_USER_ROLE_ID});
         echo Chosen::multiSelect(Globals::FLD_NAME_USER."[".Globals::FLD_NAME_USER_ROLE_ID."]", $selectedRoles, $list, array(
                            'data-placeholder' => 'Select Roles',
                            'options' => array(
                                'displaySelectedOptions' => false,
                                ),
                                'class'=>'Select_box span6'
                            ));
         
        // echo $form->dropDownList($model,'user_roleid',$list, array('empty' => 'Select Admin Role','class' => 'Select_box span6')); ?>
    <span class="help-inline"><?php echo $form->error($model,'user_roleid'); ?></span>
    </div>
</div>
	  
<!--    <div class="control-group"> <?php //echo $form->labelEx($model,'user_roleid',array('class'=>'control-label','label'=>Yii::t('admin_admin_form','User Front Role '))); ?>
    <?php //$roles = Roles::model()->findAll(  array("condition"=>" is_frontrole = '".Globals::DEFAULT_VAL_FRONT_ROLE_ACCESS."'" ,'order' => 'role_name'));  $list = CHtml::listData($roles, 'role_id', 'role_name');?>
    <div class="controls">
        <?php //echo $form->dropDownList($model,'user_front_role_id',$list, array('empty' => 'Select Admin Front Role','class' => 'Select_box span6')); ?>
    <span class="help-inline"><?php //echo $form->error($model,'user_roleid'); ?></span>
    </div>
</div>-->
    
  <div class="controls">
    <div class="span2"> 
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_admin_form','create_text') : Yii::t('admin_admin_form','update_text'),array('class'=>'btn blue')); ?> 
		<?php echo CHtml::button(Yii::t('admin_admin_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?> 
    </div>
  </div>
</div><!-- form -->
  <?php $this->endWidget(); ?>
</div>

