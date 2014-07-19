<!--<div class="margin-bottom-30" style="display: none; >
<button class="btn-u btn-u-lg rounded btn-u-red push" type="button">Cancel</button>
<button class="btn-u btn-u-lg rounded btn-u-sea push" type="button">Save</button>
</div>-->

<div id ="accountUpperDiv" style="display: none;">
<h2 class="h2">Account</h2>
<p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>
<div class="margin-bottom-20">
<h4 class="no-mrg">Customer ID:85873</h4>
</div>
</div>
<!--
<div class="col-md-12 margin-bottom-30 no-mrg" id="accountcontent" style="display: none;">
jchvhjdhvbjsbjhvhsfvbjh
    </div>-->

<div class="col-md-12 no-mrg" id="accountcontent" style="display: none;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>
<div class="col-md-4 no-mrg">
<h3>Address</h3>
<div class="col-md-11 no-mrg3">
    
<?php 
    echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_COUNTRY_CODE,array('label'=>Yii::t('index_addressinfo','Country'),'style' =>'font-weight: lighter;')); 

    $list = CHtml::listData(Country::getCountryList(),Globals::FLD_NAME_COUNTRY_CODE, 'countrylocale.country_name');
    echo $form->dropDownList($model, Globals::FLD_NAME_BILLADDR_COUNTRY_CODE, $list, 
        array('prompt'=>'--Select Country--',
            'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('admin/state/ajaxgetstate'),
            'success' => "function(data){
            $('#User_billaddr_state_id').html(data);
            $('#User_billaddr_region_id').html('<option value=\"\">--Select Region--</option>');
            $('#User_billaddr_id').html('<option value=\"\">--Select City--</option>');

            }",
            'data' => array('country_code'=>'js:this.value')),'options' => array($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}=>array('selected'=>true)),'class' => 'form-control'));

    echo $form->error($model,Globals::FLD_NAME_BILLADDR_COUNTRY_CODE); ?>    
    

</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_STREET1,array('label'=>Yii::t('index_addressinfo','Address'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,Globals::FLD_NAME_BILLADDR_STREET1,array('placeholder' => '2118 3rd Ave apt 4','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_STREET1); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_ZIPCODE,array('label'=>Yii::t('index_addressinfo','Zip Code'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,Globals::FLD_NAME_BILLADDR_ZIPCODE, array('placeholder' => 'Enter your zip code','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_BILLADDR_ZIPCODE); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'City',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'billaddr_city_id',array('placeholder' => 'Brooklyn','class' => 'form-control')); ?>
<?php echo $form->error($model,'City'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php 
    echo $form->labelEx($model,Globals::FLD_NAME_BILLADDR_STATE_ID,array('label'=>Yii::t('index_addressinfo','State'),'style' =>'font-weight: lighter;'));
    $statelist = array(); 
    if(isset($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}))
    {
        $statelist = CHtml::listData(StateLocale::getStateList($model->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE}),Globals::FLD_NAME_STATE_ID, Globals::FLD_NAME_STATE_NAME);
    }

    echo $form->dropDownList($model,Globals::FLD_NAME_BILLADDR_STATE_ID,$statelist,
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
        'options' => array($model->{Globals::FLD_NAME_BILLADDR_STATE_ID}=>array('selected'=>true)),'class' => 'form-control')); 
        
    echo $form->error($model,Globals::FLD_NAME_BILLADDR_STATE_ID); ?>
</div>
</div>

<div class="col-md-4 no-mrg">
<h3>Contact</h3>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Mobile Number',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'billaddr_state_id',array('placeholder' => '347-999-6785','class' => 'form-control')); ?>
<?php echo $form->error($model,'Mobile Number'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Phone Number',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'billaddr_state_id',array('placeholder' => '347-999-6785','class' => 'form-control')); ?>
<?php echo $form->error($model,'Phone Number'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Secondary Email',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'primary_email',array('placeholder' => 'jane@gmail.com','class' => 'form-control')); ?>
<?php echo $form->error($model,'Secondary Email'); ?>
</div>
</div>

<div class="col-md-4 no-mrg">
<h3>Social</h3>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Facebook',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'primary_email',array('placeholder' => 'johnpdoe','class' => 'form-control')); ?>
<?php echo $form->error($model,'Facebook'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Twitter',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'primary_email',array('placeholder' => 'johnpdoe','class' => 'form-control')); ?>
<?php echo $form->error($model,'Twitter'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'LinkedIn',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'primary_email',array('placeholder' => 'johnpdoe','class' => 'form-control')); ?>
<?php echo $form->error($model,'LinkedIn'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'Google+',array('style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,'primary_email',array('placeholder' => 'johnpdoe','class' => 'form-control')); ?>
<?php echo $form->error($model,'Google+'); ?>
</div>
</div>
<?php $this->endWidget();?>
</div>