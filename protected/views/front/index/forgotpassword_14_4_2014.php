<?php

/* @var $this IndexController */

/* @var $form CActiveForm */

?>

<div class="window" id="window">

<div class="lightbox" id="fl1">

  <div class="create_account">

    <div class="create_account_popup">

      <div class="popup_head">

        <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_forgotpassword','txt_forgot_password')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('blog','btn_txt_close')); ?></button>

      </div>

      <div class="create_acunt_inner">

        <div class="create_acunt_left">

          <div class="create_acunt_col1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img1.jpg" /></div>

        </div>

        <div class="create_acunt_right">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(

				'id'=>'forgotpassword-form',

				//'enableAjaxValidation' => true,

				/*'action' => Yii::app()->createUrl('index/forgotpasswordnew'), 

				'enableClientValidation' => true,

				'clientOptions' => array(

					'validateOnSubmit' => true,

					'validateOnChange' => true,

					'validateOnType' => true,

				),*/

			)); ?>



			<div class="sign_form">

			<div class="sign_row2">

				 <span class="bluetext forgotpassword">

				  <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_forgotpassword','txt_back_to_login')), Yii::app()->createUrl('index/login'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?>

				  </span></div>

			

				<div id="error" class="errorMessage"></div>				

				<p class="signin"><?php echo CHtml::encode(Yii::t('index_forgotpassword','txt_welcome_to_greencomet_please_enter_your_email')); ?></p>

				<?php //echo $form->errorSummary($model); ?>

				<div class="sign_row">

				<?php echo $form->textFieldRow($model, Globals::FLD_NAME_EMAIL, array('labelOptions' => array("label" => false), 'prepend' => '<i class="icon-user"></i>', 'placeholder'=> CHtml::encode(Yii::t('index_forgotpassword','txt_fld_email_placeholder')))); ?>

				

				  <?php //echo $form->textField($model,'email',array('placeholder'=> CHtml::encode(Yii::t('blog','E-mail id')))); ?>

				<?php //echo $form->error($model,'email'); ?>

				</div>

				<div class="sign_row2">

				<?php

		echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('index_forgotpassword','btn_txt_send')),Yii::app()->createUrl('index/forgotpassword'),array(

			   'type'=>'POST',

			   'dataType'=>'json',
                           'success'=>'js:function(data){
			   	//alert(data.status);
				   if(data.status == "success"){
				   //alert("if");
					  $(".sign_form").html("'.CHtml::encode(Yii::t('index_forgotpassword','txt_success_msg_a_link_send_to_your_mail_id_successfully')).'");
					  //window.location.href="'.Yii::app()->createUrl('index/dashboard').'";
				   }
				   else if(data.status === "not"){
					  $("#error").html("'.CHtml::encode(Yii::t('index_forgotpassword','txt_success_msg_mail_not_sent')).'");
				   }
				   else{	
				   //alert("else");			   	
				   $.each(data, function(key, val) {
                        $("#forgotpassword-form #"+key+"_em_").text(val);                                                    
                        $("#forgotpassword-form #"+key+"_em_").show();
                        });
				   }
			   }',
			   

			),array('class'=>'sign_bnt'));

	?>

				  <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Sign in')),array('class'=>'sign_bnt')); ?>

				   <?php echo CHtml::Button(CHtml::encode(Yii::t('index_forgotpassword','btn_txt_cancel')),array('class'=>'cnl_btn','onclick'=>'document.getElementById("window").style.display="none"')); ?>

				</div>

			  </div>

		  <?php $this->endWidget(); ?>

		  </div>

      </div>

    </div>

  </div>

</div>

</div>