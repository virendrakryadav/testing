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
    </style>


<div style="opacity: 1;" class="windowpoposal taskdetailpopup1 profile_popup mCustomScrollbar _mCS_1" id="loadpopupForProfileAddress">
    <div style="position:relative; height:100%; overflow:hidden; max-width:100%;" id="mCSB_1" class="mCustomScrollBox mCS-light">
        <div style="position:relative; top:0;" class="mCSB_container mCS_no_scrollbar">
            
            <div class="wrapper">
                <div id="dialog">
                    <?php echo $msg?>
                    <?php 
//                        $successUpdate = 'if(data.status==="success"){
//					  $(".sign_form").html("'.CHtml::encode(Yii::t('index_register','txt_success_msg_a_mail_sent_to_your_mail_id')).'");
//				   }
//                                   else{
//                                    $.each(data, function(key, val) 
//                                    {
//                                                    $("#register-form #"+key+"_em_").text(val);                                                    
//                                                    $("#register-form #"+key+"_em_").show();
//                                        });
//				    }';
//                        echo CommonUtility::ajaxSubmitButton(CHtml::encode(Yii::t('index_register','txt_sign_in')),
//                            Yii::app()->createUrl('index/login'),array(
//                            'type'=>'POST',
//                            'dataType'=>'json',
//                            'success'=>'js:function(data){
//                                if(data.result==="success"){
//                                    // do something on success, like redirect
//                                }else{
//                                    $("#some-container").html(data.msg);
//                                }
//                            }',
//                            ));
                    echo CHtml::link(CHtml::encode(Yii::t('layout_main','txt_sign_in')), 
                            Yii::app()->createUrl('index/login'),
//                            //array('update' => '#loadpopupForProfileAddress'),
//                            array(
//                                "type" => "POST",
//                                "data" => array("ajax" => true),
//                                "success" => "function(data){
//                                     $('#overlayProfile').hide();
//                                }",
//                                    ), 
                            array('id' => 'login'));?>
                                
                   
                </div>
            </div>
            
        </div>
      <div style="position: absolute; display: none;" class="mCSB_scrollTools">
          <div class="mCSB_draggerContainer">
              <div oncontextmenu="return false;" style="position: absolute; top: 0px;" class="mCSB_dragger">
                  <div style="position:relative;" class="mCSB_dragger_bar">
                      
                  </div>
                  
              </div>
              <div class="mCSB_draggerRail">
                  
              </div>
              
          </div>
          
      </div>
        
    </div>
    
</div>