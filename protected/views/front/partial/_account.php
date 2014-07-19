<style>
    .popup_padding {
    padding: 10px;
}
</style>
<div class="pro_tab">
<h2 class="h2"><?php echo Yii::t('index_account','credit_account_setting_text');?></h2>
<div id="yw2" class="tabs-above">
<div class="tab-content">
<div id="yw2_tab_1" class="tab-pane fade active in">
<?php 
//CommonUtility::updateContactInformationValidation();

/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'contactinformation-form',
       // 'name'=>'contactinformation-form',
        'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions' => array(
    'name' => 'contactinformation',
   ),
        
)); ?>
    <?php   
    
   $cards = array();
   $paypalids = array();
   $preferenceUpdate = 1;
    $preferenceAccount = array();
            $selected = '';
            if(isset($model->credit_account_setting))
            {
                if($model->credit_account_setting!='')
                {
                    $preferences = $model->credit_account_setting;
                    $preferences = json_decode($preferences, true);
    //               echo '<pre>';
    //                print_r($preferences);
    //
    //                echo '</pre>';
                    $i=0;
                    if(isset($preferences['card']))
                    {
                        if($preferences['card']!='')
                        {
                            foreach ($preferences['card'] as $index=>$card)
                            {
                                @$cardNumber = "xxxxxxxxxx".substr($card["number"], -4);
                                @$cardType = $card["type"];
                                @$cards[$index] = $cardFullName = $cardNumber."   ".$cardType;
                                @$preferenceAccount['Card']['card_'.$index] = $cardNumber."   ".$cardType;
                                if($card["preference"]==1)
                                {
                                    $selected = 'card_'.$index;
                                }

                                $i++;
                            }
                        }
                    }
                    if(isset($preferences['paypal']))
                    {
                        if($preferences['paypal']!='')
                        {
                            foreach ($preferences['paypal'] as $index=>$paypal)
                            {
                                $paypalEmail = $paypal["email"];
                                $paypalids[$index] = $paypalEmail;
                                $preferenceAccount['Paypal']['paypal_'.$index] = $paypalEmail;
                                if($paypal["preference"]==1)
                                {
                                    $selected = 'paypal_'.$index;
                                }
                            }
                        }
                    }
                }
            }
            if(empty($preferenceAccount))
            {
                $preferenceAccount[] = Yii::t('index_account','no_card_text');
                $preferenceUpdate = 0;
            }
    
    ?>
    <div id="errorDivContact" style="display:none" class="flash-success"></div>
    <div class="col-md-12 no-mrg2">
        <div class="col-md-6 no-mrg relative">
        <div class="col-md-12 no-mrg">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_ACCOUNT_PREFERENCE,array('label'=>Yii::t('index_account','account_preference_text'))); ?>
            </div>
           <div class="col-md-8 no-mrg">
            <?php echo $form->dropDownList($model,Globals::FLD_NAME_ACCOUNT_PREFERENCE, $preferenceAccount,
                    array('options' => array($selected=>array('selected'=>true)),'class'=>'form-control')); ?></div>
           <div class="col-md-2">
            <?php
           if($preferenceUpdate !=0)
            {
               $successUpdate = '
                                if(data.status == "success"){
                                $(".update_bnt").removeClass("loading"); 
                                     $("#errorDivContact").text("'.Yii::t('index_account','account_preference_success_msg_text').'");
                                     $("#errorDivContact").css("display","block");
                                      //window.location.href="'.Yii::app()->createUrl('index/index').'";
                                }
                                else
                                {	
                                    $("#errorDivContact").text("");	
                                    $("#errorDivContact").css("display","none");
                                    $.each(data, function(key, val) {
                                        //alert(key);
                                        $("#contactinformation-form #"+key+"_em_").text(val);                                                    
                                        $("#contactinformation-form #"+key+"_em_").show();
                                    });
                               }
                                                        '; 
                CommonUtility::getAjaxSubmitButton(Yii::t('index_account','update_text'),Yii::app()->createUrl('user/accountpreference'),'btn-u btn-u-lg rounded btn-u-sea','preference-ajaxlink-',$successUpdate);
            }
            ?></div>
            <?php echo $form->error($model,Globals::FLD_NAME_ACCOUNT_PREFERENCE); ?>
        </div>
        
           	
       
    </div>
   <div class="col-md-12 no-mrg2">
        <div class="col-md-4 no-mrg relative">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_CARD_PREFERENCE,array('label'=>Yii::t('index_account','card_preference_text'))); ?>
            <?php echo $form->dropDownList($model,Globals::FLD_NAME_CARD_PREFERENCE, $cards,
                     array('prompt'=>Yii::t('index_account','add_new_card_text'),
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('user/editaccount'),
                                           'success' => "function(data){
                                               $('#carddetail').css(\"display\",\"block\");
                                               $('#carddetail').html(data);
                                              
                                                }",
                                           'data' => array('card_id'=>'js:this.value')),
                            'options' => array(''=>array('selected'=>true)),'class' => 'form-control')); ?> 
            
            <div class="addRemove">
                                <?php echo CHtml::ajaxLink('<img src="'.Yii::app()->request->baseUrl.'/images/add-btn.png"></img>', Yii::app()->createUrl('user/editaccount'),
                    array('success'=>'function(data){ $(\'#carddetail\').css("display","block");$(\'#carddetail\').html(data);}'),array('id' => 'simple-addlink-'.uniqid()));?>
            </div>
                                
            <?php //echo CHtml::ajaxLink('<img src="'.Yii::app()->request->baseUrl.'/images/remove-btn.png"></img>', Yii::app()->createUrl('user/editaccount'),array('update' => '#User_card_preference'),array('id' => 'simple-deletelink-'.uniqid()));?>

            <?php echo $form->error($model,Globals::FLD_NAME_CARD_PREFERENCE); ?>
        </div>
    </div>
    <div class="col-md-12 no-mrg2">
        <div class="col-md-4 no-mrg relative">
            <?php echo $form->labelEx($model,Globals::FLD_NAME_PAYPAL,array('label'=>Yii::t('index_account','paypal_text'))); ?>
            <?php echo $form->dropDownList($model,Globals::FLD_NAME_PAYPAL, $paypalids, 
                    array('prompt'=>Yii::t('index_account','add_new_paypal_acc_text'),
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('user/editpaypalaccount'),
                                           'success' => "function(data){
                                               $('#carddetail').css(\"display\",\"block\");
                                               $('#carddetail').html(data);
                                            }",
                                           'data' => array('paypal_id'=>'js:this.value')),
                            'options' => array(''=>array('selected'=>true)),'class' => 'form-control',)); ?> 
            <div class="addRemove">
                                <?php echo CHtml::ajaxLink('<img src="'.Yii::app()->request->baseUrl.'/images/add-btn.png"></img>', Yii::app()->createUrl('user/editpaypalaccount'),
                    array('success'=>'function(data){ $(\'#carddetail\').css("display","block");$(\'#carddetail\').html(data);}'),array('id' => 'simple-addpaypallink-'.uniqid()));?>
            </div>
            
         
            <?php echo $form->error($model,Globals::FLD_NAME_PAYPAL); ?>
        </div>
    </div>
    
   
<?php $this->endWidget(); ?>
    <div id="carddetail" class="cardWindow" style="display: none"></div>
</div>
</div>
</div>
</div>