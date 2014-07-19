<style>
    .go_to_login {
    height: auto;
    margin: 10px;
}
.create_acunt_right1 {
    height: auto;
    width: 202px;
}

.sign_form {
    float: left;
    padding: 10px;
    width: 93%;
}

.create_acunt_left {
    float: left;
    height: auto;
    width: 436px;
}
.overlayPopup{
    z-index: 1111;
}
.taskdetailpopup1 {
    left: 32%;
    margin: auto;
}
.profile_popup {
    height: 45%;
    width: 35%;
}
    </style>
<!--    <input type="hidden" id="body" value="<?php echo $msg ?>" >
    <?php 
//    if($msg == CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired_send_mail_again')))
//    {
    ?>
        <input type="hidden" id="to" value="<?php //echo @$to ?>" >
        <input type="hidden" id="subject" value="<?php //echo @$subject ?>" >
        <input type="hidden" id="message" value="<?php //echo @$message ?>" >
        <input type="hidden" id="body" value="<?php //echo @$body ?>" >-->
<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
//UtilityHtml::popupforUserVerification(@$to,@$subject,@$message,@$body,@$msg);
//}
//else
//{
//    UtilityHtml::popupforUserReVerification($msg);
//}
?>
<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
?>
<div id="dialog">
<div class="window" id="window">
<div class="lightbox" id="fl1">

  <div class="create_account">
    <div class="create_account_popup">
      <div class="popup_head">
        <h2 class="heading"></h2>
      </div>
      <div class="create_acunt_inner">
        <div class="create_acunt_left">
          <div class="create_acunt_col1"></div>
          
        </div>
        <div class="create_acunt_right">
	
			<div class="sign_form">
				<?php echo $msg?>
				</div>
			  </div>
		 
		  </div>
      </div>
    </div>
  </div>
</div>
</div>