<?php
CommonUtility::updateAboutUsValidation();
Yii::import('ext.chosen.Chosen');
?>
<div class="pro_tab">
    <h2 class="h2"><?php echo Yii::t('index_about_us', 'about_us_text') ?></h2>
    <div id="yw2" class="tabs-above">
        <div class="tab-content">
            <div id="yw2_tab_1" class="tab-pane fade active in">

                <?php
                /** @var BootActiveForm $form */
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'aboutus-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        //'validateOnChange' => true,
                        'validateOnType' => true,
                    ),
                        ));

                //$allvalue = '';
                $aboutme = '';
                $certificateVal = '';
                if (isset($model->{Globals::FLD_NAME_ABOUT_ME}) && !empty($model->{Globals::FLD_NAME_ABOUT_ME})) {
                    $allvalue = json_decode($model->{Globals::FLD_NAME_ABOUT_ME});
                    $aboutme = $allvalue->aboutme;
                    $certificateVal = $allvalue->certificateVal;
                    //echo'<pre>';
                    //print_r($certificateVal[0]->certificate);
                    //echo count($certificateVal);
                }
                ?>
                <div id="msgAboutUs" style="display:none" class="flash-success"></div>
                <div id="errormsgaboutDiv" style="display:none" class="flash-error"></div>
                
                <div class="controls-row">
                    <div class="span4 nopadding">
                            <?php echo $form->labelEx($model, Globals::FLD_NAME_WORK_START_YEAR, array('label' => Yii::t('index_about_us', 'work_start_year_text'))); ?>
<?php //echo $form->dropDownList($model,'yearof',array(1=>'test1', 2=>'test2'),array('class'=>'span3'));  ?>
<?php UtilityHtml::getYearDropdown($model, Globals::FLD_NAME_WORK_START_YEAR, $model->work_start_year, 'span3') ?>
<?php echo $form->error($model, Globals::FLD_NAME_WORK_START_YEAR); ?>
                    </div>
                    <div class="span4 nopadding">
                        <?php echo $form->labelEx($model, Globals::FLD_NAME_TAGLINE, array('label' => Yii::t('index_about_us', 'tagline_text'))); ?>
                        <?php echo $form->textField($model, Globals::FLD_NAME_TAGLINE, array('class' => 'span3')); ?>
                        <?php echo $form->error($model, Globals::FLD_NAME_TAGLINE); ?>
                    </div>
                </div>
                
                
                   <div class="controls-row">
                    <div class="span4 nopadding"><?php echo $form->labelEx($model, Globals::FLD_NAME_ABOUT_ME, array('label' => Yii::t('index_about_us', 'about_me_text'))); ?></div>
                    <div class="span3 rightalign nopadding"><span id="wordcount">
<?php
$totelstringlength = 1000;
if (!empty($allvalue->aboutme)) {
    echo"Remaining characters: ";
    $srtlength = strlen($allvalue->aboutme);
    $totelstringlength = $totelstringlength - $srtlength;
    echo $totelstringlength;
}
?>
                        </span></div>
                            <?php //echo $form->textArea($model,'about_me'); ?>
                    <div class="span7 nopadding"><?php echo $form->textArea($model, Globals::FLD_NAME_ABOUT_ME, array('class' => 'span7', 'maxlength' => 1000, 'rows' => 5, 'value' => $aboutme)); ?>
                        <span  class="help-block error" id="User_about_me_em_" style="display: none"></span>

                    </div>
                            <?php //echo $form->error($model,'about_me'); ?>
                </div>
                  
                <div class="controls-row">

                    <div class="span7 nopadding relative">

                        <div id="skillscontainer" class="">
<?php
//echo '<pre>';
// print_r($skills);
$skill = CHtml::listData($skills, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
$skillsField = 1;
if (!empty($skill)) {
    ?>
                                <div class="controls-row">
                                    <div class="span7 nopadding">
                                <?php echo $form->labelEx($model, 'skillname', array('label' => CHtml::encode(Yii::t('index_about_us', 'skills_text')))); ?>
                                <?php
                                $skillSelected = CommonUtility::getUserSelectedSkills($model->{Globals::FLD_NAME_USER_ID});
                                //print_r($skill);
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS."user", $skillSelected, $skill, array(
                                    'data-placeholder' => CHtml::encode(Yii::t('index_about_us', 'txt_select_your_skills')),
                                    //'disabled'=>$is_public,
                                    'options' => array(
                                        'maxSelectedOptions' => 10,
                                        'displaySelectedOptions' => false,
                                    ),
                                    'class' => 'span7'
                                ));
                                ?>
                                    </div>
                                </div>
    <?php
}
?>
                        </div>
                    </div>
                </div>
                <div class="controls-row">
                    <div class="span7 nopadding relative">

                        <div id="worklocationscontainer" class="">
                        <?php
                        $location = CHtml::listData($countryLocale, Globals::FLD_NAME_COUNTRY_CODE, Globals::FLD_NAME_COUNTRY_NAME);
                     
                        $locationField = 1;
                        if (!empty($location)) {
                            ?>
                              
                                <div class="span7 nopadding">
                                <?php echo $form->labelEx($model, Globals::FLD_NAME_COUNTRY_CODE, array('label' => CHtml::encode(Yii::t('index_about_us', 'work_location_text')))); ?>
                                <?php
                                $locationSelected = CommonUtility::getUserSelectedCountryList($model->{Globals::FLD_NAME_USER_ID});
                                //print_r($locationSelected);
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTILOCATION, $locationSelected, $location, array(
                                    'data-placeholder' => CHtml::encode(Yii::t('index_about_us', 'txt_select_your_work_location')),
                                    //'disabled'=>$is_public,
                                    'options' => array(
                                        'maxSelectedOptions' => 10,
                                        'displaySelectedOptions' => false,
                                    ),
                                    'class' => 'span7'
                                ));
                                ?>
                                    </div>
                      
                                        <?php
                                    }
                                    ?>
                        </div>
                    </div>
                </div>
              
<div class="controls-row">

                    <div class="span4 nopadding relative">
                        <?php echo $form->labelEx($model, Globals::FLD_NAME_CERTIFICATE, array('label' => Yii::t('index_about_us', 'certificate_text'))); ?>
                        <div id="certificateCon" >
                            <?php
                            if (!empty($certificateVal)) {
                                $count = 1;
                                $totelrecord = count($certificateVal);
                                for ($certificateField = 0; $certificateField < $totelrecord; $certificateField++) {
                                    ?>
                                    <div class="removeControl span4 nopadding"> 
                                    <?php echo $form->textField($model, '[' . Globals::FLD_NAME_CERTIFICATE_ID_ . $count . ']' . Globals::FLD_NAME_CERTIFICATE, array('class' => 'span2 certificate', 'value' => $certificateVal[$certificateField]->certificate, 'placeholder' => "Enter Your certificate " . $count,)); ?>
                                        <?php UtilityHtml::getCertificateDropdown($model, '[' . Globals::FLD_NAME_CERTIFICATE_ID_ . $count . '][' . Globals::FLD_NAME_CERTIFICATE_ID_OF . ']', $certificateVal[$certificateField]->certificateidof, 'space') ?>
                                        <span  class="help-block error" style="display: none"></span>
                                    </div>
        <?php
        $count++;
    }
} else {
    $certificateField = 1;
    ?>
                                <div class="removeControl span4 nopadding"> 
                                <?php echo $form->textField($model, '[certificate_id_1]' . Globals::FLD_NAME_CERTIFICATE, array('class' => 'span2 certificate', 'placeholder' => "Enter Your certificate " . $certificateField,)); ?>
                                <?php UtilityHtml::getCertificateDropdown($model, '[' . Globals::FLD_NAME_CERTIFICATE_ID_ . $certificateField . '][' . Globals::FLD_NAME_CERTIFICATE_ID_OF . ']', '', 'space') ?>
                                    <span  class="help-block error" style="display: none"></span>
                                </div>
                                    <?php
                                }
                                ?>	
                            <div class="addRemove">
                                <a href="javascript:void(0)" id="addmore" onclick="addmoreCertificate();" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                                <a href="javascript:void(0)" id="remCertf"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
                            </div>
                            <div id="fields"><input type="hidden" id="certfnum" name="totalCertfId" value="<?php echo $certificateField ?>"/></div>
<!--                                <div id="fields"><input type="hidden" id="certfnum_<?php echo $certificateField ?>" name="totalCertfId" value="<?php echo $certificateField ?>"/></div>
                                <div id="total"><input type="hidden" id="total_cert" name="total_cert" value="<?php echo $certificateField ?>"/></div>-->
                        </div>
                    </div>
</div>

             
                <div class="controls-row">
                    <div class="span7 nopadding">
<?php
echo CHtml::ajaxSubmitButton(Yii::t('index_about_us', 'update_text'), Yii::app()->createUrl('index/aboutus'), array(
    'type' => 'POST',
    'dataType' => 'json',
    //'beforeSend' => 'function(data){alert(data);  }',
    'success' => 'js:function(data){
                                       $(".changepas_bnt").removeClass("loading"); 
								               if(data.status==="success"){
                                           var msg = "";
                                            var successMsg = "";
                                            if(data.certificateErr == 1)
                                            {
                                                msg = msg.concat("' . Yii::t('index_about_us', 'duplicate_certificate_text') . '"); 
                                            }
   //alert(data.statusNew);
//                                           $.ajax({
//                                                 url      : "' . Yii::app()->createUrl('user/userupdateaboutus') . '",
//                                                 type     : "POST",
//                                                 dataType : "html",
//                                                 cache    : false,
//                                                 success  : function(html)
//                                                                {
//                                                                 jQuery("#tabs_tab_2").html(html);
                                                                    $("#msgAboutUs").html("' . Yii::t('index_about_us', 'success_msg_text') . '");
                                                                    $("#msgAboutUs").css("display","block");
                                                                    if(msg)
                                                                    {
                                                                        $("#errormsgaboutDiv").html(msg);
                                                                        $("#errormsgaboutDiv").css("display","block");
                                                                    }
//                                                                 },
//                                                 error:function(){
//                                                                  alert("Request failed");
//                                                                 }
//                                                 });
                                            
									  
								   }else{
								   		$.each(data, function(key, val) {
										$("#aboutus-form #"+key+"_em_").text(val);                                                    
										$("#aboutus-form #"+key+"_em_").show();
										});
								   }
								 
							   }',
    'beforeSend' => 'function(){                        
                                          $(".changepas_bnt").addClass("loading");
                                          return validateFormAboutUs();
                                       }',
        ), array('class' => 'changepas_bnt', 'id' => 'aboutus-ajaxlink-' . uniqid()));
?>
                        <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
                    </div></div>
                        <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>