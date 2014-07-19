<?php 
CommonUtility::updateContactInformationValidation();

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
<?php $contact_info = json_decode($model->contact_info, true) ?>
  
    <div id="errorDiv" style="display:none" class="flash-success"></div>
    <div id="errormsgDiv" style="display:none" class="flash-error"></div>
        <div class="col-md-12 no-mrg2">
            <div class="col-md-6 no-mrg relative">
                    <?php echo $form->labelEx($model,Globals::FLD_NAME_MOBILE,array('label'=>Yii::t('index_updateprofile_contact_information','mobile_txt'))); ?>
                    <div id="mobilecontainer">
                        
                        <?php
                        if(isset($contact_info[Globals::FLD_NAME_PHS]))
                        {
                            $mobileField = 0;
                            foreach ($contact_info[Globals::FLD_NAME_PHS]  as $index =>$phone )
                            {
                                $mobileField++;
                               
                                ?>

                                <div class="removeControl col-md-9 no-mrg"> 
                                    <?php
//                                    if($phone['type']=='p')
//                                    {
//                                         echo $form->textField($model,'[mobile_0]mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number",'value'=>$phone['p'],'disabled'=>true)); 
//                                         echo $form->hiddenField($model,'[mobile_'.$mobileField.']mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number",'value'=>$phone['p'])); 
//                                     
//                                    }
//                                    else 
//                                    {
                                        echo $form->textField($model,'['.Globals::FLD_NAME_MOBILE_.$mobileField.']'.Globals::FLD_NAME_MOBILE, array('class'=>'form-control mobile number' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_mobile_txt'),'value'=>$phone['p'])); 

//                                    }
                                    ?>
                   
                                    <span  class="help-block error" style="display: none"></span>
                                </div>
                                
                                <?php           
                                
                            }
                        }
                        else 
                        {   
                            $mobileField = 1;
                            ?>
                                <div class="removeControl col-md-9 no-mrg"> 
                                    <?php echo $form->textField($model,'['.Globals::FLD_NAME_MOBILE_.$mobileField.']'.Globals::FLD_NAME_MOBILE, array('class'=>'form-control mobile number' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_mobile_txt'))); ?>
                                    <span  class="help-block error" style="display: none"></span>
                                </div>
                            <?php 
                        }
                            ?>
                        <div class="addRemove">
                                <a href="javascript:void(0)" id="addmoremobile" onclick="addmoremobile();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="javascript:void(0)" id="remMobile"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                        </div>
                        <div id="fields"><input type="hidden" id="mobilenum" name="totalMobileId" value="<?php echo $mobileField ?>"/></div>
                    </div>
            </div>
            <div class="col-md-6 no-mrg relative">
                    <?php echo $form->labelEx($model,Globals::FLD_NAME_EMAIL,array('label'=>Yii::t('index_updateprofile_contact_information','email_txt'))); ?>
                    <div id="emailcontainer">
                        <?php
                        if(isset($contact_info[Globals::FLD_NAME_EMAILS]))
                        {
                            $emailField = 0;
                            foreach ($contact_info[Globals::FLD_NAME_EMAILS]  as $index =>$email )
                            {
                                $emailField++; 
                                ?>
                                <div class="removeControl col-md-9 no-mrg"> 
                                    <?php
//                                    if($email['type']=='p')
//                                    {
//                                         echo $form->textField($model,'[email_0]email', array('class'=>'span3 email' ,'placeholder'=>"Email Address",'value'=>$email['e'],'disabled'=>true)); 
//                                         echo $form->hiddenField($model,'[email_'.$emailField.']email', array('class'=>'span3 email' ,'placeholder'=>"Email Address",'value'=>$email['e'])); 
//                                    }
//                                    else 
//                                    {
                                         echo $form->textField($model,'['.Globals::FLD_NAME_EMAIL_.$emailField.']'.Globals::FLD_NAME_EMAIL, array('class'=>'form-control email' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_email_txt'),'value'=>$email['e'])); 
//                                    }
                                    ?>
                                                     <div class="popover fade right in" style="top: 284.117px; left: 643.75px; display: block;">
<div class="arrow"></div>
<h3 class="popover-title"></h3>
<div class="popover-content"><?php echo Yii::t('index_updateprofile_contact_information','email_not_valid_msg_txt'); ?></div>
</div>
                                    <span  class="help-block error" style="display: none"></span>
                                </div>
                               
                                <?php           
                            }
                        }
                        else 
                        {   
                            $emailField = 1;
                            ?>
                                <div class="removeControl col-md-9 no-mrg"> 
                                    <?php echo $form->textField($model,'['.Globals::FLD_NAME_EMAIL_.$emailField.']'.Globals::FLD_NAME_EMAIL, array('class'=>'form-control email' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_email_txt'))); ?>
                                     <span  class="help-block error" style="display: none"></span>
                                </div>
                        
                            <?php 
                        }
                            ?>
                        <div class="addRemove">
                                <a href="javascript:void(0)" id="addmore" onclick="addmoreemail();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="javascript:void(0)" id="remEmail"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                        </div>
                        <div id="fields"><input type="hidden" id="emailnum" name="totalEmailId" value="<?php echo $emailField ?>"/></div>
                    </div>
            </div>
        </div>
         <div class="col-md-12 no-mrg2">
                <div class="col-md-6 no-mrg relative">
                        <?php echo $form->labelEx($model,Globals::FLD_NAME_CHAT_ID,array('label'=>Yii::t('index_updateprofile_contact_information','chat_id_txt'))); ?>
                    <div id="chatcontainer" >
                                <?php 
                                    if(isset($contact_info[Globals::FLD_NAME_CHAT_IDS]))
                                    {
                                        $chatField = 0;
                                        foreach ($contact_info[Globals::FLD_NAME_CHAT_IDS]  as $index =>$chat_id )
                                        {
                                            $chatField++; 
                                            ?>
                                            <div class="removeControl col-md-12 no-mrg"> 
                                                <?php   echo $form->textField($model,'['.Globals::FLD_NAME_CHAT_ID_.$chatField.']'.Globals::FLD_NAME_CHAT_ID, array('class'=>'form-control chat' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_chat_txt').$chatField,'value'=>$chat_id['id'],)); ?>
                                                <?php   UtilityHtml::getChatDropdown($model,'['.Globals::FLD_NAME_CHAT_ID_.$chatField.']['.Globals::FLD_NAME_CHAT_ID_OF.']',$chat_id['type'],'space form-control') ?>
                                                <?php /*  if($chatField != 1){?> <a href="#" id="remScnt"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a> <?php }
                                                        else{?><a href="#" id="addmore" onclick="addmore();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a> <?php } */?>
                                                <span  class="help-block error" style="display: none"></span>
                                            </div>
                                            <?php           
                                        }
                                    }
                                    else 
                                    {   
                                        $chatField = 1;
                                        ?>
                                        <div class="removeControl col-md-6 no-mrg"> 
                                            <?php echo $form->textField($model,'['.Globals::FLD_NAME_CHAT_ID_.$chatField.']'.Globals::FLD_NAME_CHAT_ID, array('class'=>'form-control chat' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_chat_txt'),)); ?>
                                            <?php UtilityHtml::getChatDropdown($model,'['.Globals::FLD_NAME_CHAT_ID_.$chatField.']['.Globals::FLD_NAME_CHAT_ID_OF.']','','space form-control') ?>
                                            <span  class="help-block error" style="display: none"></span>
                                       </div>
                                        <?php 
                                    }
                                        ?>
                            <div class="addRemove">
                                <a href="javascript:void(0)" id="addmore" onclick="addmore();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="javascript:void(0)" id="remScnt"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                            </div>
                            <div id="fields"><input type="hidden" id="chatnum" name="totalChatId" value="<?php echo $chatField ?>"/></div>
                        </div>
                </div>
                <div class="col-md-6 no-mrg relative">
                        <?php echo $form->labelEx($model,Globals::FLD_NAME_SOCIAL,array('label'=>Yii::t('index_updateprofile_contact_information','social_txt'))); ?>
                        <div id="socialcontainer">
                                <?php 
                                    if(isset($contact_info[Globals::FLD_NAME_SOCIAL_IDS]))
                                    {
                                        $socialField = 0;
                                        foreach ($contact_info[Globals::FLD_NAME_SOCIAL_IDS]  as $index =>$social_id )
                                        {
                                            $socialField++; 
                                            ?>
                                            <div class="removeControl col-md-12 no-mrg"> 
                                                <?php   echo $form->textField($model,'['.Globals::FLD_NAME_SOCIAL_.$socialField.']'.Globals::FLD_NAME_SOCIAL, array('class'=>'form-control social' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_social_txt').$socialField,'value'=>$social_id['id'],)); ?>
                                                <?php   UtilityHtml::getSocialDropdown($model,'['.Globals::FLD_NAME_SOCIAL_.$socialField.']['.Globals::FLD_NAME_SOCIAL_OF.']',$social_id['type']) ?>
                                                <span  class="help-block error" style="display: none"></span>
                                            </div>
                                            <?php           
                                        }
                                    }
                                    else 
                                    {   
                                        $socialField = 1;
                                        ?>
                                        <div class="removeControl col-md-12 no-mrg"> 
                                            <?php echo $form->textField($model,'[social_1]social', array('class'=>'form-control social' ,'placeholder'=>Yii::t('index_updateprofile_contact_information','pls_social_txt'),)); ?>
                                            <?php UtilityHtml::getSocialDropdown($model,'['.Globals::FLD_NAME_SOCIAL_.$socialField.']['.Globals::FLD_NAME_SOCIAL_OF.']','') ?>
                                            <span  class="help-block error" style="display: none"></span>
                                        </div>
                                        <?php 
                                    }
                                        ?>
                            <div class="addRemove">
                                <a href="javascript:void(0)" id="addmore" onclick="addmoresocial();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="javascript:void(0)" id="remSocial"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                            </div>
                            <div id="fields"><input type="hidden" id="socialnum" name="totalSocialId" value="<?php echo $socialField ?>"/></div>
                        </div>
                </div>
            </div>
<!--    <div id="chatcontainer">
         
        <div class="controls-row">
            <div class="span4 ">
                <?php echo $form->labelEx($model,Globals::FLD_NAME_CHAT_ID); ?>
            </div>
            
        </div>
         
       
</div>-->



<div class="col-md-12 no-mrg">
<div class="col-md-7 no-mrg">
                       <?php
                       
                       $successUpdate = '
                                        if(data.status == "success"){
                                        var msg = "";
                                        var successMsg = "";
                                        if(data.mobileErr == 1)
                                        {
                                            msg = msg.concat("'.Yii::t('index_updateprofile_contact_information','duplicate_mobile_txt').'"); 
                                        }
                                        if(data.emailErr == 1)
                                        {
                                            msg = msg.concat("'.Yii::t('index_updateprofile_contact_information','duplicate_email_txt').'"); 
                                        }
                                        if(data.chatErr == 1)
                                        {
                                            msg = msg.concat("'.Yii::t('index_updateprofile_contact_information','duplicate_chat_id_txt').'"); 
                                        }
                                        if(data.socialErr == 1)
                                        {
                                            msg = msg.concat("'.Yii::t('index_updateprofile_contact_information','duplicate_social_id_txt').'"); 
                                        }
                                        if(data.updateRows == 1)
                                        {
                                            successMsg = "'.Yii::t('index_updateprofile_contact_information','success_msg_txt').'"; 
                                        }
//                                        $.ajax({
//                                            url      : "'.Yii::app()->createUrl('user/userupdatecontactinformation').'",
//                                            type     : "POST",
//                                            dataType : "html",
//                                            cache    : false,
//                                            success  : function(html)
//                                            {
//                                                jQuery("#yw0_tab_2").html(html);
                                                    
                                                    if(successMsg)
                                                    {
                                                        $("#errorDiv").text(successMsg);
                                                    $("#errorDiv").css("display","block");
                                                    }
                                                    if(msg)
                                                    {
                                                        $("#errormsgDiv").html(msg);
                                                        $("#errormsgDiv").css("display","block");
                                                    }
                                                    
//                                                },
//                                                error:function(){
//                                                        alert("'.Yii::t('index_updateprofile_contact_information','request_failed_txt').'");
//                                                }
//                                            });

				   }
				   else{	
					 $("#errorDiv").text("");		   	
				   $.each(data, function(key, val) {
                                   //alert(key);
                                        $("#contactinformation-form #"+key+"_em_").text(val);                                                    
                                        $("#contactinformation-form #"+key+"_em_").show();
                                        });
				   }
                                                        '; 
                        $before='
                                    return validateForm(\''.$model->{Globals::FLD_NAME_CONTACT_INFO}.'\');
                                ';
                        CommonUtility::getAjaxSubmitButton(Yii::t('index_updateprofile_contact_information','update_txt'),Yii::app()->createUrl('user/contactinformation'),'btn-u btn-u-lg rounded btn-u-sea','contactInfoprofile-ajaxlink-',$successUpdate,$before);
					
                  
	?>	
</div>
</div>
  
<?php $this->endWidget(); ?>