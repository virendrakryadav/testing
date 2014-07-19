<?php //echo CommonScript::loadPopOverHide(); ?>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'editaccount-form',
       // 'name'=>'contactinformation-form',
        //'enableClientValidation'=>true,
        'enableAjaxValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    
        
)); ?>
<div class="popup_head">
        <h2 class="heading"><?php echo Yii::t('user_editpaypalaccount','paypal_email_text')?></h2><button id="cboxClose" onclick="document.getElementById('carddetail').style.display='none';" type="button"><?php echo Yii::t('user_editpaypalaccount','close_text')?></button>
      </div>
<div class="popup_padding">
      <?php //echo $paypal_id ;
            $preferences=array();
            if($paypal_id=='')
            {
              echo $form->hiddenField($model,Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN,array('value'=>0)); 
                $paypal_id =0;
                $submitLabel =Yii::t('user_editpaypalaccount','save_text');
                $preferences['paypal'][$paypal_id]['email'] = '';
                
            }
            else 
            {
                $submitLabel = Yii::t('user_editpaypalaccount','update_text');
                if(isset($model->credit_account_setting))
                {
                    $preferences = json_decode($model->credit_account_setting, true);
                }
                echo $form->hiddenField($model,Globals::FLD_NAME_PAYPAL_ID,array('value'=>$paypal_id)); 
                echo $form->hiddenField($model,Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN,array('value'=>$preferences['paypal'][$paypal_id]['preference'])); 
            }

            //print_r($preferences['card'][$paypal_id]);
                
                ?>
      

	<div class="col-md-12 no-mrg2">
		<?php echo $form->labelEx($model,Globals::FLD_NAME_PAYPAL_EMAIL,array('class'=>'col-md-4','label'=>Yii::t('user_editpaypalaccount','paypal_email_text'))); ?>
			<div class="col-md-6 no-mrg2">
		<?php echo $form->textField($model,Globals::FLD_NAME_PAYPAL_EMAIL,array('size'=>60,'maxlength'=>50,'class'=>'form-control','value'=>$preferences['paypal'][$paypal_id]['email'])); ?>
                <?php echo $form->hiddenField($model,'paypal_email_validation',array('value'=>$preferences['paypal'][$paypal_id]['email'])); ?>

                            
                <span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_PAYPAL_EMAIL); ?></span></div>		
	</div>
         
<div class="col-md-12 no-mrg2">
    <?php
    $successUpdate = '
                        if(data.status == "success"){
                            $.ajax({
                                    url      : "'.Yii::app()->createUrl('user/creditaccountsetting').'",
                                    type     : "POST",
                                    dataType : "html",
                                    cache    : false,
                                    success  : function(html)
                                    {
                                        jQuery("#tabs_tab_4").html(html);
                                        $("#errorDivContact").text("'.Yii::t('user_editpaypalaccount','success_msg_text').'");
                                        $("#errorDivContact").css("display","block");
                                    },
                                    error:function(){
                                            alert("'.Yii::t('user_editpaypalaccount','request_failed_msg_text').'");
                                    }
                            });
                       }
                       else{	
                            $("#errorDivContact").text("");	
                               $("#errorDivContact").css("display","none");
                            $.each(data, function(key, val) {
                                //alert(key);
                                $("#editaccount-form #"+key+"_em_").text("");                                                    
                                $("#editaccount-form #"+key+"_em_").hide();

                                $("#editaccount-form #"+key+"_em_").text(val);                                                    
                                $("#editaccount-form #"+key+"_em_").show();
                            });
                       }
                                                        '; 
        $before=
                '
                    $(".help-block").css("display","none");
                ';
                CommonUtility::getAjaxSubmitButton($submitLabel,Yii::app()->createUrl('user/editpaypalaccountupdate'),'btn-u btn-u-lg rounded btn-u-sea','paypalEmailUpdate',$successUpdate,$before);
             
                if($paypal_id!='' && $preferences['paypal'][$paypal_id]['preference']!=1)
                {
                    
                    $successUpdate = '
                        if(data.status == "success"){
                        
                            if(data.preference == "preference"){
                                var msg = '.Yii::t('user_editpaypalaccount','acc_not_del_msg_text').';
                            }
                            else
                            {
                                var msg = '.Yii::t('user_editpaypalaccount','acc_del_msg_text').';
                            }
                        
                            $.ajax({
                                        url      : "'.Yii::app()->createUrl('user/creditaccountsetting').'",
                                        type     : "POST",
                                        dataType : "html",
                                        cache    : false,
                                        success  : function(html)
                                        {
                                            jQuery("#tabs_tab_4").html(html);
                                            $("#errorDivContact").text(msg);
                                            $("#errorDivContact").css("display","block");
                                        },
                                        error:function(){
                                                alert("'.Yii::t('user_editpaypalaccount','request_failed_msg_text').'");
                                        }
                                    });
                           }
                           else{	
                                $("#errorDivContact").text("");
                                $("#errorDivContact").css("display","none");
                                $.each(data, function(key, val) {
                                    //alert(key);
                                    $("#editaccount-form #"+key+"_em_").text("");                                                    
                                    $("#editaccount-form #"+key+"_em_").hide();

                                    $("#editaccount-form #"+key+"_em_").text(val);                                                    
                                    $("#editaccount-form #"+key+"_em_").show();
                                });
                           }
                                                        '; 
        $before=
                '
                    $(".help-block").css("display","none");
                ';
                CommonUtility::getAjaxSubmitButton(Yii::t('user_editpaypalaccount','delete_text'),Yii::app()->createUrl('user/deletepaypalaccount'),'cnl_btn','paypalEmailDelete',$successUpdate,$before);
                }
                        ?>
				
            <input class="btn-u btn-u-lg rounded btn-u-red" onclick="document.getElementById('carddetail').style.display='none';" name="yt1" type="button" value="<?php echo Yii::t('user_editpaypalaccount','cancel_text')?>">
    </div>
	 <div class="controls">
	<div class="span1">
		
	</div>
             <div class="span1">
		
	</div>
	</div>
</div>
<?php $this->endWidget(); ?>
