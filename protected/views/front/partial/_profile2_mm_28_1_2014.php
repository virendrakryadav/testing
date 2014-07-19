<style>
    .addRemove {
    bottom: 20px;
    position: absolute;
    right: 50px;
}
.span4.nopadding.relative {
    position: relative;
}
</style>
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
<script>
   function addmore()
   {
       var num = $('#chatnum').val();
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->baseUrl; ?>' + '/user/getchatfield',
                data: {'num':num},
                success: function(data) {
                    $('#chatcontainer').append(data);
                    num++;
                    $('#chatcontainer #fields').html('<input type="hidden" id="chatnum" name="totalChatId" value="'+num+'"/>');
                    if(num==1)
                    {
                        $( "#chatcontainer .addRemove #remScnt ").css("visibility", "hidden");
                    }
                    else
                    {
                        $( "#chatcontainer .addRemove #remScnt ").css("visibility", "visible");
                    }
                },
                dataType: 'html'
            });
        
   }
   function addmoresocial()
   {
       var num = $('#socialnum').val();
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->baseUrl; ?>' + '/user/getsocialfield',
                data: {'num':num},
                success: function(data) {
                    $('#socialcontainer').append(data);
                    num++;
                    $('#socialcontainer #fields').html('<input type="hidden" id="socialnum" name="totalSocialId" value="'+num+'"/>');
                    if(num==1){ $( "#socialcontainer .addRemove #remSocial ").css("visibility", "hidden");}
                    else{ $( "#socialcontainer .addRemove #remSocial ").css("visibility", "visible"); }
                },
                dataType: 'html'
            });
        
   }
   function addmoremobile()
   {
        var num = $('#mobilenum').val();
        if(num<=1)
        {
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->baseUrl; ?>' + '/user/getmobilefield',
                data: {'num':num},
                success: function(data) {
                    $('#mobilecontainer').append(data);
                    num++;
                    $('#mobilecontainer #fields').html('<input type="hidden" id="mobilenum" name="totalMobileId" value="'+num+'"/>');
                    if(num==1){ $( "#mobilecontainer .addRemove #remMobile ").css("visibility", "hidden"); }
                    else{ $( "#mobilecontainer .addRemove #remMobile ").css("visibility", "visible");} 
                },
                dataType: 'html'
            });
        }
   }
   function addmoreemail()
   {
        var num = $('#emailnum').val();
        if(num<=1)
        {
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->baseUrl; ?>' + '/user/getemailfield',
                data: {'num':num},
                success: function(data) {
                    $('#emailcontainer').append(data);
                    num++;
                    $('#emailcontainer #fields').html('<input type="hidden" id="emailnum" name="totalEmailId" value="'+num+'"/>');
                    if(num==1){ $( "#emailcontainer .addRemove #remEmail ").css("visibility", "hidden"); }
                    else {$( "#emailcontainer .addRemove #remEmail ").css("visibility", "visible");}
                },
                dataType: 'html'
            });
        }
   }
   function validateForm()
   {
       var elements = document.forms['contactinformation'].elements;
       var ret = true;
        for (i=0; i<elements.length; i++)
        {
        
            if($('#'+document.forms['contactinformation'].elements[i].id).hasClass('mobile'))
            {
                var mobileId = document.forms['contactinformation'].elements[i].id;
                var mobileVal = document.forms['contactinformation'].elements[i].value;
                var msg = '';
                if(isNaN(mobileVal))  
                {  
                       msg = 'Mobile must be a number.';
                } 
                else if(mobileVal.length < 10 && mobileVal.length > 0)
                {
                       msg = 'Mobile is too short (minimum is 10 characters)..';
                }
                if(msg !='')
                {
                    $('#'+mobileId).next('.help-block').text(msg);
                    $('#'+mobileId).next('.help-block').css("display", "block");
                    $('#'+mobileId).addClass('hasError');
                    ret = false;
                }
                else
                {
                        $('#'+mobileId).next('.help-block').text(msg);
                        $('#'+mobileId).next('.help-block').css("display", "none");
                        $('#'+mobileId).removeClass('hasError');
                }
                
            }
            if($('#'+document.forms['contactinformation'].elements[i].id).hasClass('email'))
            {
                var emailId = document.forms['contactinformation'].elements[i].id;
                var emailVal = document.forms['contactinformation'].elements[i].value;
                var msg = '';
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(emailVal) && emailVal.length > 0 )  
                {   
                    var msg = 'Email is not a valid email address.';
                } 
                else if(emailVal.length < 3 && emailVal.length > 0)
                {
                    var msg = 'Email is too short (minimum is 3 characters)..'
                }
                if(msg !='')
                {
                    $('#'+emailId).next('.help-block').text(msg);
                    $('#'+emailId).next('.help-block').css("display", "block");
                    $('#'+emailId).addClass('hasError');
                    ret = false;
                }
                else
                {
                    $('#'+emailId).next('.help-block').text(msg);
                    $('#'+emailId).next('.help-block').css("display", "none");
                    $('#'+emailId).removeClass('hasError');
                }
            }
            if($('#'+document.forms['contactinformation'].elements[i].id).hasClass('chat'))
            {
                var cahtId = document.forms['contactinformation'].elements[i].id;
                var cahtVal = document.forms['contactinformation'].elements[i].value;
                var msg = '';
                
                if($('#User_chat_id_2_chat_id').length)
                {
                    if(cahtVal == '')
                    {
                        var msg = 'Chat Id cannot be blank.'
                        $('#'+cahtId).addClass('hasError');
                    }

                    if(msg !='' )
                    {
                        $('#'+cahtId).next('select').next('.help-block').text(msg);
                        $('#'+cahtId).next('select').next('.help-block').css("display", "block");
                        ret = false;
                    }
                    else
                    {
                        $('#'+cahtId).next('select').next('.help-block').text('');
                        $('#'+cahtId).next('select').next('.help-block').css("display", "none");

                    }
                }
                else
                {
                    $('#'+cahtId).next('select').next('.help-block').text('');
                    $('#'+cahtId).next('select').next('.help-block').css("display", "none");

                }
                
            }
            if($('#'+document.forms['contactinformation'].elements[i].id).hasClass('social'))
            {
                var socialId = document.forms['contactinformation'].elements[i].id;
                var socialVal = document.forms['contactinformation'].elements[i].value;
                var msg = '';
                if($('#User_social_2_social').length)
                {
                    if(socialVal == '')
                    {
                        var msg = 'Social Id cannot be blank.'
                        $('#'+socialId).addClass('hasError');
                    }

                    if(msg !='')
                    {
                        $('#'+socialId).next('select').next('.help-block').text(msg);
                        $('#'+socialId).next('select').next('.help-block').css("display", "block");
                        ret = false;
                    }
                    else
                    {
                        $('#'+socialId).next('select').next('.help-block').text('');
                        $('#'+socialId).next('select').next('.help-block').css("display", "none");

                    }
                }
                else
                {
                    $('#'+socialId).next('select').next('.help-block').text('');
                    $('#'+socialId).next('select').next('.help-block').css("display", "none");

                }
            }
        }
        if(ret==false)
            {
                $(".changepas_bnt").removeClass("loading");
            }
        return ret;
      
   }
   
   $(function() {
        if($('#chatnum').val()==1)  { $( "#chatcontainer .addRemove #remScnt ").css("visibility", "hidden");      }
        if($('#mobilenum').val()==1){ $( "#mobilecontainer .addRemove #remMobile ").css("visibility", "hidden");  }
        if($('#emailnum').val()==1) { $( "#emailcontainer .addRemove #remEmail ").css("visibility", "hidden");    }
        if($('#socialnum').val()==1){ $( "#socialcontainer .addRemove #remSocial ").css("visibility", "hidden");  }
        $('#remScnt').live('click', function() 
        { 
            $( "#chatcontainer .removeControl" ).last().remove();
            var num = $('#chatnum').val();
            num--;
            $('#chatcontainer #fields').html('<input type="hidden" id="chatnum" name="totalChatId" value="'+num+'"/>');
            if(num==1)
            {
                $( "#chatcontainer .addRemove #remScnt ").css("visibility", "hidden");
                $('#User_chat_id_1_chat_id').next('select').next('.help-block').text('');
                $('#User_chat_id_1_chat_id').next('select').next('.help-block').css("display", "none");
            }
            else
            {
                $( "#chatcontainer .addRemove #remScnt ").css("visibility", "visible");
            }
        });
         $('#remMobile').live('click', function() { 
                $( "#mobilecontainer .removeControl" ).last().remove();
                var num = $('#mobilenum').val();
                num--;
                $('#mobilecontainer #fields').html('<input type="hidden" id="mobilenum" name="totalMobileId" value="'+num+'"/>');
                if(num==1){ $( "#mobilecontainer .addRemove #remMobile ").css("visibility", "hidden");}
                else{ $( "#mobilecontainer .addRemove #remMobile ").css("visibility", "visible"); }
        });
         $('#remEmail').live('click', function() { 
                $( "#emailcontainer .removeControl" ).last().remove();
                var num = $('#emailnum').val();
                num--;
                $('#emailcontainer #fields').html('<input type="hidden" id="emailnum" name="totalEmailId" value="'+num+'"/>');
                if(num==1){ $( "#emailcontainer .addRemove #remEmail ").css("visibility", "hidden"); }
                else{ $( "#emailcontainer .addRemove #remEmail ").css("visibility", "visible");}
        });
         $('#remSocial').live('click', function() { 
                $( "#socialcontainer .removeControl" ).last().remove();
                var num = $('#socialnum').val();
                num--;
                $('#socialcontainer #fields').html('<input type="hidden" id="socialnum" name="totalSocialId" value="'+num+'"/>');
                if(num==1)
                {
                    $("#socialcontainer .addRemove #remSocial ").css("visibility", "hidden");
                    $('#User_social_1_social').next('select').next('.help-block').text('');
                    $('#User_social_1_social').next('select').next('.help-block').css("display", "none");
                }
                else
                {
                    $( "#socialcontainer .addRemove #remSocial ").css("visibility", "visible");
                }
        });
    });
        $('.mobile').live('blur', function() { 
                    
                    var msg = '';
                  if(isNaN(this.value))  
                  {  
                      var msg = 'Mobile must be a number.';
                      $(this).next('.help-block').css("display", "block");
                      $(this).addClass('hasError');
                  } 
                  else if(this.value.length < 10 && this.value.length > 0)
                  {
                      var msg = 'Mobile is too short (minimum is 10 characters)..';
                      $(this).next('.help-block').css("display", "block");
                      $(this).addClass('hasError');
                  }
                  else
                  {
                      var msg = ''
                      
                      $(this).next('.help-block').css("display", "none");
                      $(this).removeClass('hasError');
                  }
                $(this).next('.help-block').text(msg);
        });
        $('.email').live('blur', function() { 
                    
                    var msg = '';
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(this.value) && this.value.length > 0 )  
                    {   
                          var msg = 'Email is not a valid email address.';
                          $(this).next('.help-block').css("display", "block");
                          $(this).addClass('hasError');
                    } 
                    else if(this.value.length < 3 && this.value.length > 0)
                    {
                          var msg = 'Email is too short (minimum is 3 characters)..'
                          $(this).next('.help-block').css("display", "block");
                          $(this).addClass('hasError');
                    }
                    else
                    {
                          var msg = ''
                          $(this).next('.help-block').css("display", "none");
                          $(this).removeClass('hasError');
                    }
                   $(this).next('.help-block').text(msg);
                
        });
        $('#contactinformation-form').validate_popover({ popoverPosition: 'top' });
</script>				
<?php //echo $form->errorSummary($model); ?>
<!-- <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>-->

<?php $contact_info = json_decode($model->contact_info, true) ?>
  
    <div id="errorDiv" style="display:none" class="flash-success"></div>
  
        <div class="controls-row">
            <div class="span4 nopadding relative">
                    <?php echo $form->labelEx($model,'mobile'); ?>
                    <div id="mobilecontainer">
                        
                        <?php
                        if(isset($contact_info['phs']))
                        {
                            $mobileField = 0;
                            foreach ($contact_info['phs']  as $index =>$phone )
                            {
                                $mobileField++;
                               
                                ?>

                                <div class="removeControl span4 nopadding"> 
                                    <?php
                                    if($phone['type']=='p')
                                    {
                                         echo $form->textField($model,'[mobile_0]mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number",'value'=>$phone['p'],'disabled'=>true)); 
                                         echo $form->hiddenField($model,'[mobile_'.$mobileField.']mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number",'value'=>$phone['p'])); 
                                     
                                    }
                                    else 
                                    {
                                        echo $form->textField($model,'[mobile_'.$mobileField.']mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number",'value'=>$phone['p'])); 

                                    }
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
                                <div class="removeControl span4 nopadding"> 
                                    <?php echo $form->textField($model,'[mobile_'.$mobileField.']mobile', array('class'=>'span3 mobile number' ,'placeholder'=>"Mobile Number")); ?>
                                    <span  class="help-block error" style="display: none"></span>
                                </div>
                            <?php 
                        }
                            ?>
                        <div class="addRemove">
                                <a href="#" id="addmoremobile" onclick="addmoremobile();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="#" id="remMobile"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                        </div>
                        <div id="fields"><input type="hidden" id="mobilenum" name="totalMobileId" value="<?php echo $mobileField ?>"/></div>
                    </div>
            </div>
            <div class="span4 nopadding relative">
                    <?php echo $form->labelEx($model,'email'); ?>
                    <div id="emailcontainer">
                        <?php
                        if(isset($contact_info['emails']))
                        {
                            $emailField = 0;
                            foreach ($contact_info['emails']  as $index =>$email )
                            {
                                $emailField++; 
                                ?>
                                <div class="removeControl span4 nopadding"> 
                                    <?php
                                    if($email['type']=='p')
                                    {
                                         echo $form->textField($model,'[email_0]email', array('class'=>'span3 email' ,'placeholder'=>"Email Address",'value'=>$email['e'],'disabled'=>true)); 
                                         echo $form->hiddenField($model,'[email_'.$emailField.']email', array('class'=>'span3 email' ,'placeholder'=>"Email Address",'value'=>$email['e'])); 
                                    }
                                    else 
                                    {
                                         echo $form->textField($model,'[email_'.$emailField.']email', array('class'=>'span3 email' ,'placeholder'=>"Email Address",'value'=>$email['e'])); 
                                    }
                                    ?>
                                                     <div class="popover fade right in" style="top: 284.117px; left: 643.75px; display: block;">
<div class="arrow"></div>
<h3 class="popover-title"></h3>
<div class="popover-content">Email is not a valid email address.</div>
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
                                <div class="removeControl span4 nopadding"> 
                                    <?php echo $form->textField($model,'[email_'.$emailField.']email', array('class'=>'span3 email' ,'placeholder'=>"Email Address")); ?>
                                     <span  class="help-block error" style="display: none"></span>
                                </div>
                        
                            <?php 
                        }
                            ?>
                        <div class="addRemove">
                                <a href="#" id="addmore" onclick="addmoreemail();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="#" id="remEmail"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                        </div>
                        <div id="fields"><input type="hidden" id="emailnum" name="totalEmailId" value="<?php echo $emailField ?>"/></div>
                    </div>
            </div>
        </div>
         <div class="controls-row">
                <div class="span4 nopadding relative">
                        <?php echo $form->labelEx($model,'chat_id'); ?>
                    <div id="chatcontainer" class="">
                                <?php 
                                    if(isset($contact_info['chatids']))
                                    {
                                        $chatField = 0;
                                        foreach ($contact_info['chatids']  as $index =>$chat_id )
                                        {
                                            $chatField++; 
                                            ?>
                                            <div class="removeControl span4 nopadding"> 
                                                <?php   echo $form->textField($model,'[chat_id_'.$chatField.']chat_id', array('class'=>'span2 chat' ,'placeholder'=>"Chat Id ".$chatField,'value'=>$chat_id['id'],)); ?>
                                                <?php   UtilityHtml::getChatDropdown($model,'[chat_id_'.$chatField.'][chatidof]',$chat_id['type']) ?>
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
                                        <div class="removeControl span4 nopadding"> 
                                            <?php echo $form->textField($model,'[chat_id_1]chat_id', array('class'=>'span2 chat' ,'placeholder'=>"Chat Id",)); ?>
                                            <?php UtilityHtml::getChatDropdown($model,'[chat_id_'.$chatField.'][chatidof]','') ?>
                                            <span  class="help-block error" style="display: none"></span>
                                       </div>
                                        <?php 
                                    }
                                        ?>
                            <div class="addRemove">
                                <a href="#" id="addmore" onclick="addmore();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="#" id="remScnt"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                            </div>
                            <div id="fields"><input type="hidden" id="chatnum" name="totalChatId" value="<?php echo $chatField ?>"/></div>
                        </div>
                </div>
                <div class="span4 nopadding relative">
                        <?php echo $form->labelEx($model,'social'); ?>
                        <div id="socialcontainer">
                                <?php 
                                    if(isset($contact_info['socialids']))
                                    {
                                        $socialField = 0;
                                        foreach ($contact_info['socialids']  as $index =>$social_id )
                                        {
                                            $socialField++; 
                                            ?>
                                            <div class="removeControl span4 nopadding"> 
                                                <?php   echo $form->textField($model,'[social_'.$socialField.']social', array('class'=>'span2 social' ,'placeholder'=>"Social Id ".$socialField,'value'=>$social_id['id'],)); ?>
                                                <?php   UtilityHtml::getSocialDropdown($model,'[social_'.$socialField.'][socialof]',$social_id['type']) ?>
                                                <span  class="help-block error" style="display: none"></span>
                                            </div>
                                            <?php           
                                        }
                                    }
                                    else 
                                    {   
                                        $socialField = 1;
                                        ?>
                                        <div class="removeControl span4 nopadding"> 
                                            <?php echo $form->textField($model,'[social_1]social', array('class'=>'span2 social' ,'placeholder'=>"Social Id 1",)); ?>
                                            <?php UtilityHtml::getSocialDropdown($model,'[social_'.$socialField.'][socialof]','') ?>
                                            <span  class="help-block error" style="display: none"></span>
                                        </div>
                                        <?php 
                                    }
                                        ?>
                            <div class="addRemove">
                                <a href="#" id="addmore" onclick="addmoresocial();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="#" id="remSocial"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                            </div>
                            <div id="fields"><input type="hidden" id="socialnum" name="totalSocialId" value="<?php echo $socialField ?>"/></div>
                        </div>
                </div>
            </div>
<!--    <div id="chatcontainer">
         
        <div class="controls-row">
            <div class="span4 ">
                <?php echo $form->labelEx($model,'chat_id'); ?>
            </div>
            
        </div>
         
       
</div>-->



<div class="controls-row">
<div class="span7 nopadding">
                       <?php
		echo CHtml::ajaxSubmitButton('Update',Yii::app()->createUrl('user/contactinformation'),array(
			   'type'=>'POST',
			   'dataType'=>'json',
			   'success'=>'js:function(data){
				   if(data.status == "success"){
				   $(".changepas_bnt").removeClass("loading"); 
					 $("#errorDiv").text("Contact Information has been changed successfully.");
                                         $("#errorDiv").css("display","block");
					  //window.location.href="'.Yii::app()->createUrl('index/index').'";
				   }
				   else{	
					 $("#errorDiv").text("");		   	
				   $.each(data, function(key, val) {
                                   //alert(key);
                                        $("#contactinformation-form #"+key+"_em_").text(val);                                                    
                                        $("#contactinformation-form #"+key+"_em_").show();
                                        });
				   }
			   }',
                            'beforeSend'=>'function(){   
                                $(".changepas_bnt").addClass("loading");
                                    return validateForm();
                                   
                              }'

			),array('class'=>'changepas_bnt'));
	?>	
</div>
</div>
  
<?php $this->endWidget(); ?>