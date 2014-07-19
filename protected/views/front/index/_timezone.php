<style>
    .go_to_login {
    height: auto;
    margin: 10px;
}
.create_acunt_right1 {
    height: auto;
    margin: 0 0 0 30px;
    width: 202px;
}

.sign_form {
    float: left;
    padding: 10px;
    width: 93%;
}
    </style>
 
<?php
/* @var $this IndexController */
/* @var $form CActiveForm */

?><?php //echo $to; echo $msg;exit;?>
<div class="wrapper">
    <div id="dialog">
    <div class="window" id="window">
    <div class="create_account">
        <div class="create_account_popup">
        <div class="popup_head">
            <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_register','txt_verify_registration')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_close')); ?></button>
        </div>
        <div class="create_acunt_inner" id="verification_msg">
            <div class="create_acunt_left">
            <?php echo $msg;?>
               
            </div>
            <div class="create_acunt_right1">
                            <div class="sign_form">
                            </div>
            </div>
        </div>
        <div class="go_to_login">
                <?php
                if($msg == 'you are verified successfully')
                {
                    echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('layout_main','txt_sign_in')),
                            Yii::app()->createUrl('index/login'),
                            array('update' => '#window'),
                            array('id' => 'login-'.uniqid(),'class' => 'sign_bnt')
                            );
                }
                ?>
            </div>          
        </div>
    </div>
    </div>
    </div>
</div>