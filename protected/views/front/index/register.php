<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
?>
<?php echo CommonScript::loadPopOverHide(".sign_row .help-block"); ?>
<?php echo CommonScript::loadPopOverHide(".sign_row2 .help-block"); ?>
<div class="window" id="window">
  <div class="create_account">
    <div class="create_account_popup">
      <div class="popup_head">
        <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_register','txt_create_your_account')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_close')); ?></button>
      </div>
      <div class="create_acunt_inner">
        <div class="create_acunt_left">
          <div class="create_acunt_col1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img1.jpg" /></div>
          <div class="create_log_fb">
          <a href="#" class="log_fb"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_sign_in_with_facebook')); ?></a>
		  
		  <a href="#" class="log_google" style="margin-left:14px;"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_sign_in_with_google')); ?></a>
         <?php /*?> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login-with-fb.jpg"></a><?php */?></div>
        </div>
        <div class="create_acunt_right">
			<div class="sign_form sky-form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'register-form',
		'enableAjaxValidation' => true,
		//'action' => Yii::app()->createUrl('index/register'), 
		'enableClientValidation' => true,
		'clientOptions' => array(
                'validateOnSubmit' => true,
             //   'validateOnChange' => true,
			//'validateOnType' => true,
		),
	)); ?>

		<div id="error"></div>
         <section>
<label class="input"><?php echo CHtml::encode(Yii::t('index_register','txt_sign_up_with_just_a_single_step')); ?>
</label>
</section>
		<?php /*?><div class="sign_row_name">
		<?php echo $form->textField($model,'firstname',array('style'=>'margin-right: 7px;','placeholder'=>'First name','size'=>3,'maxlength'=>100)); ?>
		 <?php echo $form->textField($model,'lastname',array('placeholder'=>CHtml::encode(Yii::t('blog','Last name')))); ?>
		 <?php echo $form->error($model,'firstname'); ?>
		<?php echo $form->error($model,'lastname'); ?>
		</div><?php */?>
        
<section>
<label class="input">
<i class="icon-append fa fa-user"></i>
<input type="text" placeholder="<?php echo CHtml::encode(Yii::t('index_register','txt_fld_email_placeholder')) ?>" name="<?php echo Globals::FLD_NAME_USER.'['. Globals::FLD_NAME_EMAIL.']'; ?>">

</label>
<?php echo $form->error($model,'email',array('class' => 'invalid')); ?>
</section>

<section>
<label class="input">
<i class="icon-append fa fa-lock"></i>
<input type="password" id="password" placeholder="<?php echo CHtml::encode(Yii::t('index_register','txt_fld_password_placeholder'))?>" name="<?php echo Globals::FLD_NAME_USER.'['. Globals::FLD_NAME_PASSWORD.']'; ?>">
<!--/*<b class="tooltip tooltip-bottom-right">Don't forget your password</b>*/-->
</label>
<?php echo $form->error($model,'password' ,array('class' => 'invalid')); ?>
</section>

<section>
<label class="input">
<i class="icon-append fa fa-lock"></i>
<input type="password" id="password" placeholder="<?php echo CHtml::encode(Yii::t('index_register','txt_fld_repeatpassword_placeholder')); ?>" name="<?php echo Globals::FLD_NAME_USER.'['. Globals::FLD_NAME_REPEAT_PASSWORD.']'; ?>">
<!--/*<b class="tooltip tooltip-bottom-right">Don't forget your password</b>*/-->
</label>
<?php echo $form->error($model,'repeatpassword' ,array('class' => 'invalid')); ?>
</section>


		
		
		
		<div class="sign_row2">
                    <div class="popup_padding">
		 <?php echo $form->checkBox($model,'terms_agree'); ?>
		  <?php echo CHtml::encode(Yii::t('index_register','txt_i_understand_and_agree')); ?> <span class="bluetext"><?php echo CHtml::encode(Yii::t('index_register','txt_with_terms_of_uses')); ?></span>
		  <?php echo $form->error($model,'terms_agree'); ?>
		  </div>  </div>
		<div class="sign_row2">
		<?php
                $successUpdate = 
                                    'if(data.status==="success"){
					  $(".sign_form").html("'.CHtml::encode(Yii::t('index_register','txt_success_msg_a_mail_sent_to_your_mail_id')).'");
				   }
                                   else{
                                    $.each(data, function(key, val) 
                                    {
                                                    $("#register-form #"+key+"_em_").text(val);                                                    
                                                    $("#register-form #"+key+"_em_").show();
                                        });
				    }';
		CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('index_register','btn_txt_sign_up')),Yii::app()->createUrl('index/register'),'btn-u btn-u-lg rounded btn-u-sea push','registrationFormToSave',$successUpdate);
	?>
		  <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Sign up')),array('class'=>'sign_bnt')); ?>
		  <?php echo CHtml::Button(CHtml::encode(Yii::t('index_register','btn_txt_cancel')),array('class'=>'btn-u btn-u-lg rounded btn-u-red push','onclick'=>'document.getElementById("window").style.display="none"')); ?>
		</div>
		<?php $this->endWidget(); ?>
</div>

        </div>
      </div>
    </div>
  </div>
  </div>

