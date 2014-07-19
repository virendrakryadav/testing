<?php echo CommonScript::loadPopOverHide(); ?>
<?php /** @var BootActiveForm $form */
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'updateprofile-form',
					'enableAjaxValidation' => false,
					//'action' => Yii::app()->createUrl('index/updateprofile'), 
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
						//'validateOnChange' => true,
						'validateOnType' => true,
					),
					'htmlOptions' => array('enctype' => 'multipart/form-data'),
					)
				); 
                                        $profileinfo = json_decode($model->{Globals::FLD_NAME_PROFILE_INFO});
                        ?>
                                        <div id="msg" style="display:none" class="flash-success"></div>
                                        <div class="col-md-12 no-mrg2 sky-form">
					<div class="col-md-6">
                                        <?php 
										
                                            echo $form->labelEx($model,'image',array('label'=>Yii::t('index_updateprofile_personal_information','img_text'))); ?>
                                        <?php
                                        //$img = CommonUtility::getprofilePicMediaURI($model->{Globals::FLD_NAME_USER_ID});
                                        $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID},Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50);
                                        ?>
                                        <div id="imgPreview" style="float: left"><img height="50" width="50" src="<?php echo  $img ?>"></img></div>
                                            

                                        <?php
                                        $success = "$('#imgPreview').css('display','block');
                                                                $('#imgPreview img ').attr('src', '".CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID},Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50).'-'."'+ (new Date().getTime()));
                                                                $('#uploadFile .qq-upload-list').html('');
                                                                $(\"#profileImageIconOnHeader\").attr('src', '');
                                                                $(\"#gcHeader li a img#profileImageIconOnHeader\").attr('src', '".CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID},Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35).'-'."'+ (new Date().getTime()));";
                                        CommonUtility::getUploader('uploadFile',Yii::app()->createUrl('index/updateimage'),Yii::app()->params['allowImages'],Yii::app()->params['maxfileSize'],Yii::app()->params['minfileSize'],$success);
                                        ?>
                                        <?php //echo $form->fileField($model,'image', array('class'=>'span3')); ?>
                                        <?php echo $form->error($model,'image'); ?>
					</div>
					<div class="col-md-6">
                                            <?php echo $form->labelEx($model,'video',array('label'=>Yii::t('index_updateprofile_personal_information','video_text'))); ?>
                                                <?php
                                                    $videoLinkId = 'video_profile-'.uniqid();
                                                    if(!empty($profileinfo))
                                                    {
                                                        if($profileinfo->video != '')
                                                        {
                                                            $videoUrl = CommonUtility::getVideoMediaURI($model->{Globals::FLD_NAME_USER_ID});
                                                            ?>
                                                                <div id="videoPreview" style="float: left;display: <?php if($profileinfo->video == '') echo 'none' ?> " >
                                                                    <?php echo  CHtml::ajaxLink('<i class="icon-facetime-video"></i>Play Video', Yii::app()->createUrl('index/playvideo')."?url=".$videoUrl,
                                                                                array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' => $videoLinkId,'class'=>'playVideo'));
                                                                    ?>
                                                                </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <div id="videoPreview" style="float: left;display: block">
                                                                <?php 

                                                                echo CHtml::ajaxLink('<i class="icon-facetime-video"></i>No Video', Yii::app()->createUrl('index/playvideo'),
                                                                            array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' =>$videoLinkId ,'class'=>'playVideo','onclick'=>'return false'));?>
                                                                </div>                                                       
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                            <div id="videoPreview" style="float: left;display: block">
                                                            <?php 
                                                            
                                                            echo CHtml::ajaxLink('<i class="icon-facetime-video"></i>No Video', Yii::app()->createUrl('index/playvideo'),
                                                                        array('success'=>'function(data){ $(\'#playVideo\').css("display","block");$(\'#playVideo\').html(data);}'),array('id' =>$videoLinkId ,'class'=>'playVideo','onclick'=>'return false'));?>
                                                            </div>                                                       
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                
                                                    <?php
                                                    $videoSuccess = " 
//                                                    $('#videoPreview').css('display','block');
//                                                     $.ajax({
//                                                            url      : '".Yii::app()->createUrl('user/userupdatepersonalinformation')."',
//                                                            type     : \"POST\",
//                                                            dataType : \"html\",
//                                                            cache    : false,
//                                                            success  : function(html)
//                                                            {
//                                                                jQuery(\"#yw0_tab_2\").html(html);
//                                                                    $(\"#msg\").html(\"Video has been Uploaded successfully.\");
//                                                                    $(\"#msg\").css(\"display\",\"block\");
//                                                                    $('".$videoLinkId."').html('<i class=\"icon-facetime-video\"></i>Play Video');
//
//                                                            },
//                                                            error:function(){
//                                                                    alert(\"Request failed\");
//                                                            }
//                                                        });
                                            
                                                     window.location.href= window.location.href;
//                                                    $('#videoPreview a').attr('href', '".Yii::app()->baseUrl."/video/'+fileName);
                                                    ";
                                                    CommonUtility::getUploader('uploadVideo',Yii::app()->createUrl('index/updatevideouser'),Yii::app()->params['allowVideos'],Yii::app()->params['maxfileSize'],Yii::app()->params['minfileSize'],$videoSuccess);
                                                   ?>
						<?php echo $form->error($model,'video'); ?>
					</div>	
                                </div>
				<div class="col-md-12 no-mrg2 sky-form">
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_FIRSTNAME,array('label'=>Yii::t('index_updateprofile_personal_information','firstname_text'))); ?>
						<?php echo $form->textField($model,Globals::FLD_NAME_FIRSTNAME,array('class'=>'form-control')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_FIRSTNAME); ?>
					</div>
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_LASTNAME,array('label'=>Yii::t('index_updateprofile_personal_information','lastname_text'))); ?>
						<?php echo $form->textField($model,Globals::FLD_NAME_LASTNAME, array('class'=>'form-control')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_LASTNAME); ?>
					</div></div>
              
					<?php
						
						//echo $profileinfo->pic;
						if(!empty($profileinfo))
						{
					?>  
                                
                      
                                    <div class="col-md-12 no-mrg2 sky-form">				
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_WEBURL,array('label'=>Yii::t('index_updateprofile_personal_information','weburl_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_WEBURL_ISPUBLIC, array('disabled'=>false,'checked'=>$profileinfo->weburl_ispublic)); ?></div>
						<div class="col-md-12 no-mrg"><?php echo $form->textField($model,Globals::FLD_NAME_WEBURL, array('class'=>'form-control','value'=>$profileinfo->weburl)); ?></div>
						<?php echo $form->error($model,'weburl'); ?>
					</div>
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_URL,array('label'=>Yii::t('index_updateprofile_personal_information','url_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_URL_ISPUBLIC, array('disabled'=>false,'checked'=>$profileinfo->url_ispublic)); ?> </div>
						<div class="col-md-12 no-mrg"><?php echo $form->textField($model,Globals::FLD_NAME_URL, array('class'=>'form-control','value'=>$profileinfo->url)); ?></div>
						<?php echo $form->error($model,'url'); ?>
					</div>
                                    </div>
                                        <?php
						}
						else
						{
					?>
                                
                        
                                
                    <div class="col-md-12 no-mrg2">				
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_WEBURL,array('label'=>Yii::t('index_updateprofile_personal_information','weburl_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_WEBURL_ISPUBLIC, array('disabled'=>false,'checked'=>'')); ?></div>
						<div class="col-md-6 no-mrg"><?php echo $form->textField($model,Globals::FLD_NAME_WEBURL, array('class'=>'form-control','value'=>'')); ?></div>
						<?php echo $form->error($model,'weburl'); ?>
					</div>
					<div class="col-md-6">
						<div class="ol-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_URL,array('label'=>Yii::t('index_updateprofile_personal_information','url_text'))); ?></div>
						<div class="ol-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_URL_ISPUBLIC, array('disabled'=>false,'checked'=>'')); ?></div>
						<div class="ol-md-6 no-mrg"><?php echo $form->textField($model,Globals::FLD_NAME_URL, array('class'=>'form-control','value'=>'')); ?></div>
						<?php echo $form->error($model,'url'); ?>
					</div>
					</div>
					<?php
						}
					?>
                    <div class="col-md-12 no-mrg2">
					<div class="col-md-6">

					<?php
                                        $successUpdate = '
                                                            if(data.status==="success"){
                                                               //alert(data.status);
                                                               //alert("You are Registerd Successfully");
                                                                      $("#msg").html("'.Yii::t('index_updateprofile_personal_information','success_msg_text').'");
                                                                      if(data.sessionname != "not")
                                                                      {
                                                                        $("#yw4 li a span.sessionname").html(data.sessionname);
                                                                      }
                                                                      $("#msg").css("display","block");
                                                               }else{
                                                               $.each(data, function(key, val) {
                                                              // alert(val);
                                                                            $("#updateprofile-form #"+key+"_em_").text(val);                                                    
                                                                            $("#updateprofile-form #"+key+"_em_").show();
                                                                            });
                                                               }
                                                        '; 
                                        CommonUtility::getAjaxSubmitButton(Yii::t('index_updateprofile_personal_information','update_text'),Yii::app()->createUrl('index/updateprofile'),'btn-u btn-u-lg rounded btn-u-sea','userProfileUpdate',$successUpdate);
						
					?>
					<?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
					</div></div>
				
<div id="playVideo" class="window" style="display: none"></div>
			
				 <?php $this->endWidget(); ?>

