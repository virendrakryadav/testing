
<div style="display: none;" id="changePasswordUpperDiv">
<h2 class="h2">Email/Password</h2>
<p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>
<div class="margin-bottom-20">
<h4 class="no-mrg">Customer ID:85873</h4>
</div>
</div>


<div class="col-md-12 no-mrg" id="emailcontent" style="display: none;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>
<div class="col-md-5 no-mrg">
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_LOGIN_NAME,array('label'=>Yii::t('index_addressinfo','Username & Email'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->textField($model,Globals::FLD_NAME_LOGIN_NAME, array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_LOGIN_NAME); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_PASSWORD,array('label'=>Yii::t('index_addressinfo','Old Password'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->passwordField($model,Globals::FLD_NAME_PASSWORD, array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_PASSWORD); ?>
</div>
<div class="col-md-11 no-mrg3">
<?php echo $form->labelEx($model,Globals::FLD_NAME_PASSWORD,array('label'=>Yii::t('index_addressinfo','New Password'),'style' =>'font-weight: lighter;')); ?>
<?php echo $form->passwordField($model,Globals::FLD_NAME_PASSWORD, array('placeholder' => 'johndoe@icloud.com','class'=>'form-control')); ?>
<?php echo $form->error($model,Globals::FLD_NAME_PASSWORD); ?>
</div>
</div>
    <?php $this->endWidget();?>
</div>

