<?php echo CommonScript::loadPopOverHide(); ?>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'editaccount-form',
       // 'name'=>'contactinformation-form',
        'enableClientValidation'=>true,
    'enableAjaxValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    
        
)); ?>

<script type="text/javascript">
 
	function SetTypeText(number)
	{
		var typeField = document.getElementById("cardType");
                var tosaveCard = document.getElementById("User_card_number_hidden");
		typeField.innerHTML = GetCardType(number);
                tosaveCard.value = GetCardType(number);
	}
 
        function GetCardType(number)
        {            
            var re = new RegExp("^4[0-9]{12}([0-9]{3})?$");
            if (number.match(re) != null)
                return "Visa";
 
            re = new RegExp("^3[47][0-9]{13}$");
            if (number.match(re) != null)
                return "American Express";
 
            re = new RegExp("^5[1-5][0-9]{14}$");
            if (number.match(re) != null)
                return "MasterCard";
 
            re = new RegExp("^6(?:011|5[0-9]{2})[0-9]{12}$");
            if (number.match(re) != null)
                return "Discover";
            
            re = new RegExp("^3(0[0-5]|[68][0-9])[0-9]{11}$");
            if (number.match(re) != null)
                return "Diners Club";
             
            re = new RegExp("^(3[0-9]{4}|2131|1800)[0-9]{11}$");
            if (number.match(re) != null)
                return "JCB";
              
            re = new RegExp("^8699[0-9]{11}$");
            if (number.match(re) != null)
                return "VOYAGER";  
            
            re = new RegExp("^(6334[5-9][0-9]|6767[0-9]{2})\\d{10}(\\d{2,3})?$");
            if (number.match(re) != null)
                return "SOLO";
             
            re = new RegExp("^(?:5020|6\\d{3})\\d{12}$");
            if (number.match(re) != null)
                return "MAESTRO";
             
            re = new RegExp("^(?:49(03(0[2-9]|3[5-9])|11(0[1-2]|7[4-9]|8[1-2])|36[0-9]{2})\\d{10}(\\d{2,3})?)|(?:564182\\d{10}(\\d{2,3})?)|(6(3(33[0-4][0-9])|759[0-9]{2})\\d{10}(\\d{2,3})?)$");
            if (number.match(re) != null)
                return "SWITCH CARD";
              
            re = new RegExp("^(?:417500|4026\\d{2}|4917\\d{2}|4913\\d{2}|4508\\d{2}|4844\\d{2})\\d{10}$");
            if (number.match(re) != null)
                return "ELECTRON";
               
            re = new RegExp("^(?:6304|6706|6771|6709)\\d{12}(\\d{2,3})?$");
            if (number.match(re) != null)
                return "LASER";
            
            return "";
        }
</script>
<div class="popup_head">
        <h2 class="heading"><?php echo Yii::t('user_editaccount','card_detail_text'); ?></h2><button id="cboxClose" onclick="document.getElementById('carddetail').style.display='none';" type="button"><?php echo Yii::t('user_editaccount','close_text'); ?></button>
      </div>
<div class="popup_padding">
      <?php //echo $card_id ;
            $preferences=array();
            if($card_id=='')
            {
               echo $form->hiddenField($model,Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN,array('value'=>0)); 
                $submitLabel = "Save";
                $card_id =0;
                $preferences['card'][$card_id]['type'] = '';
                $preferences['card'][$card_id]['name'] = '';
                $preferences['card'][$card_id]['number'] = '';
                $preferences['card'][$card_id]['month'] = '';
                $preferences['card'][$card_id]['year'] = '';
                $preferences['card'][$card_id]['cvv'] = '';
                $preferences['card'][$card_id]['preference']='';
                $preferences['card'][$card_id][Globals::FLD_NAME_TOKEN] = '';
            }
            else 
            {
                 $submitLabel =Yii::t('user_editaccount','update_text');
                if(isset($model->credit_account_setting))
                {
                    $preferences = json_decode($model->credit_account_setting, true);
                }
                if(!isset($preferences['card'][$card_id]['preference']))
                {
                    $preferences['card'][$card_id]['preference'] = 0;
                }
                
                 echo $form->hiddenField($model,Globals::FLD_NAME_CARD_ID,array('value'=>$card_id)); 
                 echo $form->hiddenField($model,Globals::FLD_NAME_CARD_PREFERENCE_HIDDEN,array('value'=>$preferences['card'][$card_id]['preference'])); 
                 
            }

            //print_r($preferences['card'][$card_id]);
                
                ?>
      

	<div class="col-md-12 no-mrg2">
		<?php echo $form->labelEx($model,Globals::FLD_NAME_CARD_NAME,array('class'=>'col-md-3','label'=>Yii::t('user_editaccount','card_name_text'))); ?>
			<div class="col-md-5 no-mrg">
		<?php echo $form->textField($model,Globals::FLD_NAME_CARD_NAME,array('size'=>60,'maxlength'=>100,'class'=>'form-control','value'=>$preferences['card'][$card_id]['name'])); ?>
		<span class="help-inline"><?php echo $form->error($model,'card_name'); ?></span></div>		
	</div>
         <div class="col-md-12 no-mrg2">
		<?php echo $form->labelEx($model,Globals::FLD_NAME_CARD_NUMBER,array('class'=>'col-md-3','label'=>Yii::t('user_editaccount','card_number_text'))); ?>
                <div class="col-md-5 no-mrg">
                    <?php echo $form->textField($model,Globals::FLD_NAME_CARD_NUMBER,array('size'=>50,'maxlength'=>50,'class'=>'form-control','onchange'=>'SetTypeText(this.value)','value'=>$preferences['card'][$card_id]['number'])); ?>
                    <?php echo $form->hiddenField($model,'card_number_hidden_validation',array('value'=>$preferences['card'][$card_id]['number'])); ?>
                    <?php echo $form->hiddenField($model,Globals::FLD_NAME_CARD_NUMBER_HIDDEN,array('value'=>$preferences['card'][$card_id]['type'])); ?>
                    <?php echo $form->hiddenField($model,Globals::FLD_NAME_TOKEN,array('value'=>$preferences['card'][$card_id][Globals::FLD_NAME_TOKEN])); ?>
                    <div id="cardType"><?php echo $preferences['card'][$card_id]['type'] ?></div>
                    <span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_CARD_NUMBER); ?></span>
                    <span class="help-inline"> <?php echo $form->error($model,'card_other_error'); ?> </span>
                </div>		
        </div> 
     
     
<div class="col-md-12 no-mrg2">
     <?php echo $form->labelEx($model,Globals::FLD_NAME_CARD_EXPIRE_MONTH,array('class'=>'col-md-3','label'=>Yii::t('user_editaccount','card_expire_month_text'))); ?>
        <div class="col-md-2 mrg-right relative">
           
           
             <?php UtilityHtml::getmonthDropdown($model,'['.Globals::FLD_NAME_CARD_EXPIRE_MONTH.']',$preferences['card'][$card_id]['month']) ?>
            
		
        </div>
    <div class="col-md-2 mrg-right relative">
          
        <?php UtilityHtml::getExpireYearDropdown($model,'['.Globals::FLD_NAME_CARD_EXPIRE_YEAR.']',$preferences['card'][$card_id]['year']) ?>
        
        
		<span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_CARD_EXPIRE_YEAR); ?></span>
        </div>
    <span class="help-inline"><?php echo $form->error($model,Globals::FLD_NAME_CARD_EXPIRE_MONTH); ?></span>
    <div class="col-md-2 mrg-right relative">
           
            <?php echo $form->passwordField($model,'card_cvv',array('size'=>4,'maxlength'=>4,'class'=>'form-control','placeholder' => 'cvv' ,'value'=>$preferences['card'][$card_id]['cvv'])); ?>
		<span class="help-inline"><?php echo $form->error($model,'card_cvv'); ?></span>
    </div>
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
                                            $("#errorDivContact").text("'.Yii::t('user_editaccount','card_success_msg_text').'");
                                            $("#errorDivContact").css("display","block");
                                        },
                                        error:function(){
                                            alert("'.Yii::t('user_editaccount','card_failed_msg_text').'");
                                        }
                                    });
                           }
                           else
                           {	
                                $("#errorDivContact").text("");	
                                $("#errorDivContact").css("display","none");
                                $.each(data, function(key, val) {
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
                CommonUtility::getAjaxSubmitButton($submitLabel,Yii::app()->createUrl('user/editaccountupdate'),'btn-u btn-u-lg rounded btn-u-sea','simple-ajaxlink-',$successUpdate,$before);
        
                if($card_id!='' && $preferences['card'][$card_id]['preference']!=1)
                {
                    $successUpdate = '
                        if(data.status == "success"){
                        
                        if(data.preference == "preference"){
                            var msg = "Card has not been deleted (preference account).";
                        }
                        else
                        {
                            var msg = "Card Detail has been deleted successfully.";
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
                                                alert("Request failed");
                                        }
                                });
                           }
                           else{	
                                $("#errorDivContact").text("");
                                $("#errorDivContact").css("display","none");
                                $.each(data, function(key, val) {
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
                CommonUtility::getAjaxSubmitButton('Delete',Yii::app()->createUrl('user/deleteaccountupdate'),'cnl_btn','simple-ajaxdeletelink-',$successUpdate,$before);
                }
                        ?>
				
            <input class="btn-u btn-u-lg rounded btn-u-red" onclick="document.getElementById('carddetail').style.display='none';" name="yt1" type="button" value="Cancel">
    </div>
</div>
<?php $this->endWidget(); ?>
