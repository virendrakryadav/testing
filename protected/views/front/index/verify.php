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
.layer{
    background-color: rgba(248, 248, 236, 0.50);
    width:100%;
    height:100%;
    position:absolute;
    top:0;
    left:0;
    z-index:1111;
}
    </style>
<div class="layer">
</div>
<div class="wrapper">
    <div id="dialog">
    <div class="window" id="window">
    <div class="create_account">
        <div class="create_account_popup">
        <div class="popup_head">
            <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_register','txt_verify_registration')); ?></h2><button id="cboxClose" onclick="document.getElementById('window').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('index_register','btn_txt_close')); ?></button>
        </div>
        <div class="create_acunt_inner">
            <div class="create_acunt_left" id="verification_msg">
            <?php echo $msg;?>
               
            </div>
            <div class="create_acunt_right1">
                            <div class="sign_form">
                                <?php 
                                if(@$to && $msg== CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired_send_mail_again')))
                                {
                                    ?>
                               
                                <input type="hidden" id="to" value="<?php echo $to ?>" >
                                <input type="hidden" id="subject" value="<?php echo $subject ?>" >
                                <input type="hidden" id="message" value="<?php echo $message ?>" >
                                <input type="hidden" id="body" value="<?php echo $body ?>" >
                                <?php 
                                echo CHtml::ajaxSubmitButton(CHtml::encode(Yii::t('index_register','txt_resend_link')),
                                Yii::app()->createUrl('index/sendmail'),
                                array(
                                    'type'=>'POST',
                                    'dataType'=>'json',
                                    'data' => array('to'=>@$to,'subject'=>@$subject,'message' => @$message,'body'=>@$body),
                                    'success'=>'js:function(data){
			   
                                            if(data.status==="success"){
                                                    $(".verification_msg").html("'.$msg.'");
                                            }
                                    }',
                                    ),
//                                    array('update' => '#window'),
                                    array('class'=>'sign_bnt','id'=>'sendlink'));
//                               
                                }
                                ?>
                            </div>
            </div>
        </div>
        <div class="go_to_login">
                <?php
                if($msg != CHtml::encode(Yii::t('index_register','txt_your_registration_link_has_been_expired_send_mail_again')))
                {
                    echo Chtml::ajaxLink(CHtml::encode(Yii::t('index_register','txt_sign_in')),
                            Yii::app()->createUrl('index/login'),
                            array('update' => '#window'),
                            array('id' => 'sign_inlbjh','class' => 'sign_bnt')
                            );
                }
                ?>
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