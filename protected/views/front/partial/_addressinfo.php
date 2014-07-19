<script type="text/javascript">
$(document).ready(function()
{
	$('#User_geoaddr_issame').click(function() {
    var $this = $(this);
    // $this will contain a reference to the checkbox   
    if ($this.is(':checked')) {
        $('#geo').css('display','none');
    } else {
        // the checkbox was unchecked
		$('#geo').css('display','block');
		//$('#User_geoaddr_street1').val("");
    }
});
});
</script>
<h4 style="color:#0088CC"><?php echo Yii::t('index_addressinfo','billing_address_text')?></h4>	
	<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'addressinfo-form',
					'enableAjaxValidation' => true,
					//'action' => Yii::app()->createUrl('index/updateprofile'), 
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
						//'validateOnChange' => true,
						//'validateOnType' => false,
					),
)); 

$htmlOptions =array
    (
        'errorCssClass'=>'',
        'successCssClass'=>'',
        'validatingCssClass'=>'',
        'style'=>'display: block',
        'hideErrorMessage'=>false,
        'afterValidateAttribute'=>'js:afterValidateAttribute'
		
);
?>
					<div id="msgnew" style="display:none" class="flash-success"></div>
					<div class="col-md-12 no-mrg2">
						<div class="col-md-6">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_STREET1,array('label'=>Yii::t('index_addressinfo','billaddr_street1_text'))); ?>
							<?php //echo $form->textFieldControlGroup($model,'billaddr_street1',array('placeholder'=>'email', 'class'=>'span4','errorOptions'=>$htmlOptions,'prepend'=>'<i class="icon-globe"></i>'));?>
							<?php echo $form->textField($model,Globals::FLD_NAME_BILLADDR_STREET1,array('class'=>'form-control')); ?>
							<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_STREET1); ?>
						</div>
						<div class="col-md-6">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_STREET2,array('label'=>Yii::t('index_addressinfo','billaddr_street2_text'))); ?>
							<?php echo $form->textField($model,Globals::FLD_NAME_BILLADDR_STREET2, array('class'=>'form-control')); ?>
							<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_STREET2); ?>
						</div></div>
					<div class="col-md-12 no-mrg2">
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_COUNTRY_CODE,array('label'=>Yii::t('index_addressinfo','billaddr_country_code_text'))); ?>
						<?php  
							$list = CHtml::listData(Country::getCountryList(),Globals::FLD_NAME_COUNTRY_CODE, 'countrylocale.country_name');
							echo $form->dropDownList($model, Globals::FLD_NAME_BILLADDR_COUNTRY_CODE, $list, 
                             array('prompt'=>'--Select Country--',
                                                   'ajax' => array(
                                                   'type' => 'POST',
                                                   'url' => CController::createUrl('admin/state/ajaxgetstate'),
												   //'beforeSend' => 'function(data){alert(data);  }',
                                                   'success' => "function(data){
												   //alert('ghhhg');
												   //alert(data);
                                                       $('#User_billaddr_state_id').html(data);
                                                       $('#User_billaddr_region_id').html('<option value=\"\">--Select Region--</option>');
                                                        $('#User_billaddr_id').html('<option value=\"\">--Select City--</option>');

                                                    }",
                                                   'data' => array('country_code'=>'js:this.value')),'options' => array($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}=>array('selected'=>true)),'class' => 'form-control'));
                ?>
						<?php //echo $form->textField($model,'billaddr_country_code', array('class'=>'span3')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_COUNTRY_CODE); ?>
					</div>			
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_STATE_ID,array('label'=>Yii::t('index_addressinfo','billaddr_state_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_BILLADDR_STATE_ISPUBLIC, array('disabled'=>false)); ?></div>
						<?php  $statelist = array(); 
						if(isset($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}))
						{
						   $statelist = CHtml::listData(StateLocale::getStateList($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}),Globals::FLD_NAME_STATE_ID, Globals::FLD_NAME_STATE_NAME);
						}
						?>
						<div class="col-md-12 no-mrg">
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_BILLADDR_STATE_ID,$statelist,
                        
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('admin/region/ajaxgetregion'),
                            'success' => "function(data){
							//alert('dftgh');
								$('#User_billaddr_region_id').html(data);
								$('#User_billaddr_city_id').html('<option value=\"\">--Select City--</option>');
                              }",
                            'data' => array('state_id'=>'js:this.value','language'=>Yii::app()->user->getState('language'))),
                            'options' => array($model->{Globals::FLD_NAME_BILLADDR_STATE_ID}=>array('selected'=>true)),'class' => 'form-control')); ?></div>
						<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_STATE_ID); ?>
					</div>
					</div>
					<div class="col-md-12 no-mrg2">	
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_REGION_ID,array('label'=>Yii::t('index_addressinfo','billaddr_region_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_BILLADDR_REGION_ISPUBLIC, array('disabled'=>false)); ?></div>
						<div class="col-md-12 no-mrg">
						<?php  $regionlist = array();
						 if(isset($model->{Globals::FLD_NAME_BILLADDR_STATE_ID}))
						{
                                                    $regionlist = CHtml::listData(RegionLocale::getRegionList($model->{Globals::FLD_NAME_BILLADDR_STATE_ID}),Globals::FLD_NAME_REGION_ID, Globals::FLD_NAME_REGION_NAME);
						}
						?>
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_BILLADDR_REGION_ID,$regionlist,array('prompt'=>'--Select Region--',
                                                            'ajax' => array(
                                                                    'type' => 'POST',
                                                                    'url' => CController::createUrl('admin/city/ajaxgetcity'),
                                                                    'update' => '#User_billaddr_city_id',
                                                                    'data' => array('region_id'=>'js:this.value','language'=>Yii::app()->user->getState('language'))),
                                                            'options' => array($model->{Globals::FLD_NAME_BILLADDR_REGION_ID}=>array('selected'=>true)),'class' => 'form-control')); ?></div>
						<?php //echo $form->textField($model,'billaddr_region_id', array('class'=>'span3')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_REGION_ID); ?>
					</div>			
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_CITY_ID,array('label'=>Yii::t('index_addressinfo','billaddr_city_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_BILLADDR_CITY_ISPRIVATE, array('disabled'=>false)); ?></div>
						<div class="col-md-12 no-mrg">
						<?php  $citylist = array(); 
						 if(isset($model->{Globals::FLD_NAME_BILLADDR_REGION_ID}))
						{
						   $citylist = CHtml::listData(City::getCityList($model->{Globals::FLD_NAME_BILLADDR_REGION_ID}),'city_id', 'city_name');
						}
						?>
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_BILLADDR_CITY_ID,$citylist,array('prompt'=>'--Select City--','class' => 'form-control')); ?>
						<?php //echo $form->textField($model,'billaddr_city_id', array('class'=>'span3')); ?></div>
						<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_CITY_ID); ?>
					</div>
					</div>
                    <div class="col-md-12 no-mrg2">				
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_ZIPCODE,array('label'=>Yii::t('index_addressinfo','billaddr_zipcode_text'))); ?>
						<?php echo $form->textField($model,Globals::FLD_NAME_BILLADDR_ZIPCODE, array('class'=>'form-control')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_ZIPCODE); ?>
					</div>
					</div>
                    <?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_GEOADDR_ISSAME, array('disabled'=>false)); ?>
					<div id="geo" <?php if($model->{Globals::FLD_NAME_GEOADDR_ISSAME} == '1') { ?> style='display:none;' <?php }?>>
					<div class="col-md-12 no-mrg2">
						<div class="col-md-6">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_STREET1,array('label'=>Yii::t('index_addressinfo','geoaddr_street1_text'))); ?>
							<?php echo $form->textField($model,Globals::FLD_NAME_GEOADDR_STREET1,array('class'=>'form-control')); ?>
							<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_STREET1); ?>
						</div>
						<div class="col-md-6">
							<?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_STREET2,array('label'=>Yii::t('index_addressinfo','geoaddr_street2_text'))); ?>
							<?php echo $form->textField($model,Globals::FLD_NAME_GEOADDR_STREET2, array('class'=>'form-control')); ?>
							<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_STREET2); ?>
						</div></div>
					<div class="col-md-12 no-mrg2">
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_COUNTRY_CODE,array('label'=>Yii::t('index_addressinfo','geoaddr_country_code_text'))); ?>
						<?php  
							$list = CHtml::listData(Country::getCountryList(),Globals::FLD_NAME_COUNTRY_CODE, 'countrylocale.country_name');
							echo $form->dropDownList($model, Globals::FLD_NAME_GEOADDR_COUNTRY_CODE, $list, 
                             array('prompt'=>'--Select Country--',
                                                   'ajax' => array(
                                                   'type' => 'POST',
                                                   'url' => CController::createUrl('admin/state/ajaxgetstate'),
												   //'beforeSend' => 'function(data){alert(data);  }',
                                                   'success' => "function(data){
												   //alert('ghhhg');
												   //alert(data);
                                                       $('#User_geoaddr_state_id').html(data);
                                                       $('#User_geoaddr_region_id').html('<option value=\"\">--Select Region--</option>');
                                                        $('#User_geoaddr_id').html('<option value=\"\">--Select City--</option>');

                                                    }",
                                                   'data' => array('country_code'=>'js:this.value')),'options' => array($model->{Globals::FLD_NAME_GEOADDR_COUNTRY_CODE}=>array('selected'=>true)),'class' => 'form-control'));
                ?>
						<?php //echo $form->textField($model,'geoaddr_country_code', array('class'=>'span3')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_COUNTRY_CODE); ?>
					</div>			
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_STATE_ID,array('label'=>Yii::t('index_addressinfo','geoaddr_state_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_GEOADDR_STATE_ISPUBLIC, array('disabled'=>false)); ?></div>
						<?php  $statelist = array(); 
						if(isset($model->{Globals::FLD_NAME_GEOADDR_COUNTRY_CODE}))
						{
						   $statelist = CHtml::listData(StateLocale::getStateList($model->{Globals::FLD_NAME_GEOADDR_COUNTRY_CODE}),Globals::FLD_NAME_STATE_ID, Globals::FLD_NAME_STATE_NAME);
						}
						?>
						<div class="col-md-12 no-mrg">
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_GEOADDR_STATE_ID,$statelist,
                        
                        array('prompt'=>'--Select State--',
                            'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('admin/region/ajaxgetregion'),
                            'success' => "function(data){
							//alert('dftgh');
								$('#User_geoaddr_region_id').html(data);
								$('#User_geoaddr_city_id').html('<option value=\"\">--Select City--</option>');
                              }",
                            'data' => array('state_id'=>'js:this.value','language'=>Yii::app()->user->getState('language'))),
                            'options' => array($model->{Globals::FLD_NAME_GEOADDR_STATE_ID}=>array('selected'=>true)),'class' => 'form-control')); ?></div>
						<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_STATE_ID); ?>
					</div>
					</div>
					<div class="col-md-12 no-mrg2">	
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_REGION_ID,array('label'=>Yii::t('index_addressinfo','geoaddr_region_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_GEOADDR_REGION_ISPUBLIC, array('disabled'=>false)); ?></div>
						<div class="col-md-12 no-mrg">
						<?php  $regionlist = array();
						 if(isset($model->{Globals::FLD_NAME_GEOADDR_STATE_ID}))
						{
						   $regionlist = CHtml::listData(RegionLocale::getRegionList($model->{Globals::FLD_NAME_GEOADDR_STATE_ID}),Globals::FLD_NAME_REGION_ID, Globals::FLD_NAME_REGION_NAME);
						} 
						?>
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_GEOADDR_REGION_ID,$regionlist,array('prompt'=>'--Select Region--',
                     		'ajax' => array(
                            'type' => 'POST',
                            'url' => CController::createUrl('admin/city/ajaxgetcity'),
                            'update' => '#User_geoaddr_city_id',
                            'data' => array('region_id'=>'js:this.value','language'=>Yii::app()->user->getState('language'))),
                    'options' => array($model->{Globals::FLD_NAME_GEOADDR_REGION_ID}=>array('selected'=>true)),'class' => 'form-control')); ?></div>
						<?php //echo $form->textField($model,'geoaddr_region_id', array('class'=>'span3')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_REGION_ID); ?>
					</div>			
					<div class="col-md-6">
						<div class="col-md-10 no-mrg"><?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_CITY_ID,array('label'=>Yii::t('index_addressinfo','geoaddr_city_id_text'))); ?></div>
						<div class="col-md-2 no-mrg"><?php echo $form->checkBoxControlGroup($model,Globals::FLD_NAME_GEOADDR_CITY_ISPRIVATE, array('disabled'=>false)); ?></div>
						<div class="col-md-12 no-mrg">
						<?php  $citylist = array(); 
						 if(isset($model->{Globals::FLD_NAME_GEOADDR_REGION_ID}))
						{
						   $citylist = CHtml::listData(City::getCityList($model->{Globals::FLD_NAME_GEOADDR_REGION_ID}),Globals::FLD_NAME_CITY_ID, Globals::FLD_NAME_CITY_NAME);
						}
						?>
						<?php echo $form->dropDownList($model,Globals::FLD_NAME_GEOADDR_CITY_ID,$citylist,array('prompt'=>'--Select City--','class' => 'form-control')); ?>
						<?php //echo $form->textField($model,'geoaddr_city_id', array('class'=>'span3')); ?></div>
						<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_CITY_ID); ?>
					</div>
					</div>
                    <div class="col-md-12 no-mrg2">				
					<div class="col-md-6">
						<?php echo $form->labelEx($model,Globals::FLD_NAME_GEOADDR_ZIPCODE,array('label'=>Yii::t('index_addressinfo','geoaddr_zipcode_text'))); ?>
						<?php echo $form->textField($model,Globals::FLD_NAME_GEOADDR_ZIPCODE, array('class'=>'form-control')); ?>
						<?php echo $form->error($model,Globals::FLD_NAME_GEOADDR_ZIPCODE); ?>
					</div>
					</div>
					</div>
                    <div class="col-md-12 no-mrg2">
					<div class="col-md-6">
					<?php
						echo CHtml::ajaxSubmitButton(Yii::t('index_addressinfo','update_text'),Yii::app()->createUrl('index/addressinfo'),array(
							   'type'=>'POST',
							   'dataType'=>'json',
							   //'beforeSend' => 'function(data){alert(data);  }',
							   'success'=>'js:function(data){
							   //alert(data.status);
								   if(data.status==="success"){
								   //alert(data.status);
								   //alert("You are Registerd Successfully");
									  $("#msgnew").html("'.Yii::t('index_addressinfo','success_msg_text').'");
									  $("#msgnew").css("display","block");
								   }else{
								   $.each(data, function(key, val) {
								  // alert(val);
										$("#addressinfo-form #"+key+"_em_").text(val);                                                    
										$("#addressinfo-form #"+key+"_em_").show();
										});
								   }
								   $(".changepas_bnt").removeClass("loading"); 
							   }',                               
							   'beforeSend'=>'function(){                        
                                   $(".changepas_bnt").addClass("loading");
                              }'
							),array('class'=>'btn-u btn-u-lg rounded btn-u-sea'));
					?>
					<?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
					</div></div>
				
		
			
				 <?php $this->endWidget(); ?>