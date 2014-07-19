<?php
/* @var $this IndexController */
/* @var $form CActiveForm */


?>
<div class="wrapper">
    <div id="dialog">
    <div class="window" id="window">
    <div class="create_account">
        <div class="create_account_popup">
        <div class="popup_head">
            <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_forgotpassword','txt_reset_your_password')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_close')); ?></button>
        </div>
        <div class="create_acunt_inner">
            <div class="create_acunt_left">
            <div class="create_acunt_col1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img1.jpg" /></div>
            <div class="create_log_fb">
    <!--          <a href="#" class="log_fb"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_sign_in_with_facebook')); ?></a>

                    <a href="#" class="log_google" style="margin-left:14px;"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_sign_in_with_google')); ?></a>-->
            <?php /*?> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login-with-fb.jpg"></a><?php */?></div>
            </div>
            <div class="create_acunt_right">
                            <div class="sign_form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'register-form',
                    'enableAjaxValidation' => false,
                    //'action' => Yii::app()->createUrl('index/register'), 
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                    'validateOnSubmit' => true,
                //   'validateOnChange' => true,
                            //'validateOnType' => true,
                    ),
            )); ?>
    <?php echo CommonScript::loadPopOverHide(); ?>
                    <div id="error"></div>
                    <!--<p><?php //echo CHtml::encode(Yii::t('index_register','txt_sign_up_with_just_a_single_step')); ?></p>-->
                    <?php /*?><div class="sign_row_name">
                    <?php echo $form->textField($model,'firstname',array('style'=>'margin-right: 7px;','placeholder'=>'First name','size'=>3,'maxlength'=>100)); ?>
                    <?php echo $form->textField($model,'lastname',array('placeholder'=>CHtml::encode(Yii::t('blog','Last name')))); ?>
                    <?php echo $form->error($model,'firstname'); ?>
                    <?php echo $form->error($model,'lastname'); ?>
                    </div><?php */?>
                    <?php 
                    if(@$email)
                    {//echo $verificationcode;exit;
                    ?>
                    <div class="sign_row">
                        <div class="popup_padding">
                    <?php echo $form->hiddenField($resetPassword, Globals::FLD_NAME_EMAIL, array('value' => $email)); ?>
                            <?php echo $form->hiddenField($resetPassword, 'verificationcode', array('value' => $verificationcode)); ?>
                            <?php echo $form->hiddenField($resetPassword, 'timestamp', array('value' => $timestamp)); ?>
                        </div>

                    </div>
                    <?php
                    }
                    ?>
                    <div class="sign_row">
                        <div class="popup_padding">
                    <?php echo $form->passwordFieldControlGroup($resetPassword, Globals::FLD_NAME_PASSWORD, array('labelOptions' => array("label" => false), 'prepend' => '<i class="icon-key"></i>', 'placeholder'=>CHtml::encode(Yii::t('index_register','txt_fld_new_password_placeholder')))); ?>
                        </div>
                    <?php //echo $form->passwordField($model,'password',array('placeholder'=>CHtml::encode(Yii::t('blog','Password')))); ?>
                    <?php echo $form->error($model,'password'); ?>
                    </div>
                    <div class="sign_row">
                        <div class="popup_padding">
                            <?php echo $form->passwordFieldControlGroup($resetPassword, Globals::FLD_NAME_REPEAT_PASSWORD, array('labelOptions' => array("label" => false), 'prepend' => '<i class="icon-key"></i>', 'placeholder'=>CHtml::encode(Yii::t('index_register','txt_fld_repeatpassword_placeholder')))); ?>
                        </div>
                            <?php //echo $form->passwordField($model,'repeatpassword',array('placeholder'=>CHtml::encode(Yii::t('blog','Confirm password')))); ?>
                            <?php echo $form->error($model,'repeatpassword'); ?>
                    </div>
                    <div class="sign_row2">
                    <?php
                    echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('index_forgotpassword','btn_submit')),Yii::app()->createUrl('index/savepassword'),array(
                            'type'=>'POST',
                            'dataType'=>'json',
                            'success'=>'js:function(data){
                            //alert("xdfgd");
                                    if(data.status==="success"){//alert(data.status);
                                            $(".sign_form").html("'.CHtml::encode(Yii::t('index_forgotpassword','txt_success_msg_your_password_has_been_reset_successfully')).'");
                                    }
                                    else if(data.status==="timeout"){
                                            $(".sign_form").html("'.CHtml::encode(Yii::t('index_forgotpassword','txt_success_msg_your_verification_code_has_been_expired')).'");
                                    }
                                    else if(data.status==="not"){
                                            $(".sign_form").html("'.CHtml::encode(Yii::t('index_forgotpassword','txt_user_not_found')).'");
                                    }
                                    else{
                                        $.each(data, function(key, val) 
                                        {
                                                        $("#register-form #"+key+"_em_").text(val);                                                    
                                                        $("#register-form #"+key+"_em_").show();
                                            });
                                    }
                            }',
                            ),array('class'=>'sign_bnt','id'=>'registrationFormToSave'));
            ?>
                    <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Sign up')),array('class'=>'sign_bnt')); ?>
                    <?php echo CHtml::Button(CHtml::encode(Yii::t('index_register','btn_txt_cancel')),array('class'=>'cnl_btn','onclick'=>'document.getElementById("window").style.display="none"')); ?>
                    </div>
                    <?php $this->endWidget(); ?>
    </div>

            </div>
        </div>
        </div>
    </div>
    </div>
    </div>
</div>

 <div class="banner"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner-img.jpg" width="1280" height="696"></div>
  <!--Banner Ends Here-->
  <!--Overview Start Here-->
  <div class="overview"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/overview.jpg" width="1280" height="575"></div>
  <!--Overview Ends Here-->
  <!--How it work Start Here-->
  <div class="howitwork"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/how-it-work.jpg" width="1280" height="383"></div>
  <!--How it work Ends Here-->
  <!--Features Start Here-->
  <div class="feature"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/features.jpg" width="1280" height="409"></div>
  <!--Features Ends Here-->
  <!--Testimonials Start Here-->
  <div class="testimonial"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/testimonials.jpg" width="1280" height="384"></div>
  <!--Testimonials Ends Here-->
  <!--Map Start Here-->
  <div class="map"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/map.jpg" width="1280" height="600"></div>
  <!--Map Ends Here-->
 <div class="map"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/footer.jpg" width="1280" height="216"></div>