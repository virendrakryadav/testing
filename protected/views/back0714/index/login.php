<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<h3 class="form-title"><?php echo Yii::t('admin_index_login','login_your_acc_text')?></h3>
<!--
<p>Please fill out the following form with your login credentials:</p>
	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<div class="control-group">
	<div id="error" class="errorMessage"></div>
    <div class="input-icon left"><i class="icon-user"></i>
<?php /*?>		<?php echo $form->labelEx($model,'user name'); ?><?php */?>
		<?php echo $form->textField($model,'username',array('placeholder'=>'Username','class'=>'m-wrap','value'=>Yii::app()->request->cookies['username']
)); ?>
		
	</div>
	<?php echo $form->error($model,'username',array('class'=>'help-inline help-small no-left-padding')); ?>
	</div>

	<div class="control-group">
    <div class="input-icon left"><i class="icon-lock"></i>
		<?php /*?><?php echo $form->labelEx($model,'password'); ?><?php */?>
		<?php echo $form->passwordField($model,'password',array('placeholder'=>'Password','class'=>'m-wrap','value'=>Yii::app()->request->cookies['password'])); ?>
	
		<!--<p class="hint">
			Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
		</p>-->
	</div>
		<?php echo $form->error($model,'password',array('class'=>'help-inline help-small no-left-padding')); ?>
	</div>

	<div class="form-actions">
		<?php echo $form->checkBox($model,'rememberMe',array('class'=>'rembr_check','checked'=>Yii::app()->request->cookies['rememberMe'])); ?>
		<?php echo $form->label($model,'rememberMe',array('class'=>'checkbox')); ?>
		
		<?php echo $form->error($model,'rememberMe'); ?>
		
		<i class="m-icon-swapright m-icon-white"></i>
		<?php
		echo CHtml::ajaxSubmitButton(Yii::t('admin_index_login','sign_in_text'),Yii::app()->createUrl('index/login'),array(
			   'type'=>'POST',
			   'dataType'=>'json',
			   'success'=>'js:function(data){
			   	//alert(data);
				   if(data.status == "success"){
				   //alert("if");
					  window.location.href="'.Yii::app()->createUrl('index/index').'";
				   }
				   else if(data.status === "not"){
					  $("#error").html("'.Yii::t('admin_index_login','error_text').'");
				   }
				   else{	
				   //alert("else");			   	
				   $.each(data, function(key, val) {
                        $("#login-form #"+key+"_em_").text(val);                                                    
                        $("#login-form #"+key+"_em_").show();
                        });
				   }
			   }',
			),array('class'=>'btn green pull-right'));
	?>
		<?php //echo CHtml::submitButton('Login',array('class'=>'btn green pull-right')); ?>
        
	</div>
	
<?php $this->endWidget(); ?>
<!-- form -->
