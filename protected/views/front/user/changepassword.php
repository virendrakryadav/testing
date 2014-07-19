<div class="container content">
<div class="col-md-3">
<?php $this->renderPartial('//commonfront/_settings_left_sidebar');?>
    <div class="margin-bottom-30" id="btnDiv">
            <?php
    $form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>
<button class="btn-u btn-u-lg rounded btn-u-red push" type="button">Cancel</button>
<?php
echo CHtml::ajaxSubmitButton('Submit',Yii::app()->createUrl('//user/changepassword'),
        array(
            'type' => 'POST',
            'dataType' => 'html',
            'success' => 'js:function(data){
                    $("#User_oldpassword").val(""); 
                    $("#User_newpassword").val(""); 
                    $("#User_repeatpassword").val(""); 
                    $("#alertDiv").show(); 
                    $("#errorMsg").append("Password Changed Successfully");
                }',
        ),
        array(
            'id' =>'submit',
            'class' =>'btn-u btn-u-lg rounded btn-u-sea push',
        ));
?>
<!--<button class="btn-u btn-u-lg rounded btn-u-sea push" type="button">Save</button>-->
</div>

</div>

<div class="col-md-9">
<div id="changePasswordUpperDiv">
<h2 class="h2">Email/Password</h2>
<p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>
<div class="margin-bottom-20">
<h4 class="no-mrg">Customer ID:85873</h4>
</div>
</div>


<div class="col-md-12 no-mrg" id="emailcontent">
<div class="col-md-5 no-mrg">
<div style="display: none" class="alert alert-danger fade in" id="alertDiv">
<button onclick="$('#errorMsg').parent().fadeOut();" class="close4" type="button">×</button>
<div id="errorMsg" ><i class='fa fa-hand-o-right'></i>
</div>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,'oldpassword',array('label'=>Yii::t('index_addressinfo','Old Password'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->passwordField($model,'oldpassword', array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,'oldpassword'); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_NEW_PASSWORD,array('label'=>Yii::t('index_addressinfo','New Password'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->passwordField($model,Globals::FLD_NAME_NEW_PASSWORD, array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_NEW_PASSWORD); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_REPEAT_PASSWORD,array('label'=>Yii::t('index_addressinfo','Repeat Password'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->passwordField($model,Globals::FLD_NAME_REPEAT_PASSWORD, array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_REPEAT_PASSWORD); ?>
</div>
</div>
    <?php $this->endWidget();?>
</div>
    </div></div>

