<style> 
.sign_row3 {
    bottom: 16px;
    float: left;
    font-size: 12px;
    padding: 20px 0 0;
    position: relative;
    width: 100%;
}
.errorMessage {
    color: #FF0000 !important;
    font-size: 12px;
    padding: 0;
}
    </style>
<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
?>

<div class="window" id="window">
<div class="lightbox" id="fl1">

  <div class="create_account">
    <div class="create_account_popup">
      <div class="popup_head">
        <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_login','txt_login_to_your_account')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_login','btn_txt_close')); ?></button>
      </div>
      <div class="create_acunt_inner">
        <div class="create_acunt_left">
          <div class="create_acunt_col1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img1.jpg" /></div>
          <div class="create_log_fb">
              <?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>
<!--		  <a href="#" class="log_fb"><?php echo CHtml::encode(Yii::t('index_login','btn_txt_sign_in_with_facebook')); ?></a>
                  <a href="#" class="log_google" style="margin-left:14px;">
		  <?php echo CHtml::encode(Yii::t('index_login','btn_txt_sign_in_with_google')); ?></a>-->
		  </div>
        </div>
        <div class="create_acunt_right ">
	
		
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'login-form',
				//'enableAjaxValidation' => true,
				'action' => Yii::app()->createUrl('index/login'), 
				//'enableClientValidation' => true,
				//'clientOptions' => array(
					//'validateOnSubmit' => true,
					//'validateOnChange' => true,
					//'validateOnType' => true,
				//),
				
			)); 
			
			
			?>

			<div class="sign_form sky-form">
				<div id="error" class="errorMessage"></div>
				
				<?php //echo $form->errorSummary($model); ?>
			
     <section>
<label class="input"><?php echo CHtml::encode(Yii::t('index_login','txt_welcome_to_greencomet_please_enter_your_email_id_and_password_to_sign_in')); ?>
</label>
</section>
           
<section>
<label class="input">
<i class="icon-append fa fa-user"></i>
<input type="text" placeholder="<?php echo CHtml::encode(Yii::t('index_login','txt_email_placeholder')) ?>" name="<?php echo Globals::FLD_NAME_FRONT_LOGIN_FORM.'['. Globals::FLD_NAME_EMAIL.']'; ?>">
<!--<b class="tooltip tooltip-bottom-right">Needed to enter the website</b>-->
</label>
</section>

<section>
<label class="input">
<i class="icon-append fa fa-lock"></i>
<input type="password" id="password" placeholder="Password" name="<?php echo Globals::FLD_NAME_FRONT_LOGIN_FORM.'['. Globals::FLD_NAME_PASSWORD.']'; ?>">
<!--/*<b class="tooltip tooltip-bottom-right">Don't forget your password</b>*/-->
</label>
</section>
		<div class="sign_row2">
				 <?php echo $form->checkBox($model,Globals::FLD_NAME_REMEMBER_ME,array('checked'=>Yii::app()->request->cookies['rememberMeFront'])); ?>
				  <span class="bluetext"><?php echo CHtml::encode(Yii::t('index_login','txt_keeped_me_logged_in')); ?></span> <span class="bluetext forgotpassword">
				  <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_login','txt_forgot_password')), Yii::app()->createUrl('index/forgotpassword'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?>
				  </span></div>
                                <div class="sign_row2">
                                    <input type="hidden" value="<?php echo CHttpRequest::getUrlReferrer();?>" name="currentpage">
                                </div>
				<div class="sign_row3">
				<?php
                                
		echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('index_login','btn_txt_sign_in')),Yii::app()->createUrl('index/login'),array(
			   'type'=>'POST',
			   'dataType'=>'json',
			   'success'=>'js:function(data){
			   	//alert(data.status);
				   if(data.errorCode == "success"){
					  //window.location.href="'.Yii::app()->createUrl('index/dashboard').'";
					  window.location.href=data.location;
				   }
				   else if(data.errorCode){
					  	if(data.errorCode == "ERROR_EMAIL_INVALID")
						{
							$("#error").html("'.CHtml::encode(Yii::t('index_login','txt_error_msg_incorrect_email_or_password')).'");
						}
						if(data.errorCode == "ERROR_PASSWORD_INVALID")
						{
							$("#error").html("'.CHtml::encode(Yii::t('index_login','txt_error_msg_incorrect_email_or_password')).'");
						}
						if(data.errorCode == "ERROR_STATUS_DEACTIVE")
						{
							$("#error").html("'.CHtml::encode(Yii::t('index_login','status_deactive_text')).'");
						}
				   }
				   else{
						$("#error").html("'.CHtml::encode(Yii::t('index_login','txt_error_msg_incorrect_email_or_password')).'");
						$.each(data, function(key, val) {
						$("#login-form #"+key+"_em_").text(val);
						$("#login-form #"+key+"_em_").show();
						});
				   }
			   }',
			),array('class'=>'btn-u btn-u-lg rounded btn-u-sea push'));
	?>
				  <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Sign in')),array('class'=>'sign_bnt')); ?>
				   <?php echo CHtml::Button(CHtml::encode(Yii::t('index_login','btn_txt_cancel')),array('class'=>'btn-u btn-u-lg rounded btn-u-red push','onclick'=>'document.getElementById("window").style.display="none"')); ?>
				</div>
			  </div>
		  <?php $this->endWidget(); ?>
		  </div>
      </div>
    </div>
  </div>
</div>
</div>