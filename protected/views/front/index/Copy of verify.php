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
    <input type="hidden" id="body" value="<?php echo $msg ?>" >
    <?php 
    if($msg == CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired_send_mail_again')))
    {
    ?>
        <input type="hidden" id="to" value="<?php echo @$to ?>" >
        <input type="hidden" id="subject" value="<?php echo @$subject ?>" >
        <input type="hidden" id="message" value="<?php echo @$message ?>" >
        <input type="hidden" id="body" value="<?php echo @$body ?>" >
<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
UtilityHtml::popupforUserVerification(@$to,@$subject,@$message,@$body,@$msg);
}
else
{
    UtilityHtml::popupforUserVerification($msg);
}
?><?php //echo $to; echo $msg;exit;?>
<!--<div class="wrapper">
    <div id="dialog">
    <div class="window" id="window">
    <div class="create_account">
        <div class="create_account_popup">
        <div class="popup_head">
            <h2 class="heading"><?php //echo CHtml::encode(Yii::t('index_register','txt_verify_registration')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_close')); ?></button>
        </div>
        <div class="create_acunt_inner">
            <div class="create_acunt_left" id="verification_msg">
            <?php //echo $msg;?>
               
            </div>
            <div class="create_acunt_right1">
                            <div class="sign_form">
                                <?php 
                                //if(@$to && $msg!= CHtml::encode(Yii::t('index_register','txt_you_are_verified')))
                                //{
                                    ?>
                               
                                <input type="hidden" id="to" value="<?php //echo $to ?>" >
                                <input type="hidden" id="subject" value="<?php //echo $subject ?>" >
                                <input type="hidden" id="message" value="<?php //echo $message ?>" >
                                <input type="hidden" id="body" value="<?php //echo $body ?>" >
                                <?php 
//                                echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('index_register','txt_resend_link')),
//                                Yii::app()->createUrl('index/sendmail'),
//                                array(
//                                    'type'=>'POST',
//                                    'dataType'=>'json',
//                                    'data' => array('to'=>@$to,'subject'=>@$subject,'message' => @$message,'body'=>@$body),
////                                    'success'=>'js:function(data){alert(data.status)
////			   
////                                            if(data.status==="success"){
////                                                    $(".verification_msg").html("'.$msg.'");
////                                            }
////                                    }',
//                                    ),
////                                    array('update' => '#window'),
//                                    array('class'=>'sign_bnt','id'=>'sendlink'));
//                               
//                                }
                                ?>
                            </div>
            </div>
        </div>
        <div class="go_to_login">
                <?php
//                if($msg == CHtml::encode(Yii::t('index_register','txt_you_are_verified')))
//                {
//                    echo CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('index_register','txt_sign_in')),
//                            Yii::app()->createUrl('index/login'),'sign_bnt','sign_in'
////                            array('update' => '#window'),
////                            array('id' => 'sign_in','class' => 'sign_bnt')
//                            );
//                }
                ?>
            </div>          
        </div>
    </div>
    </div>
    </div>
</div>-->