<div class="container content no-png">
<div class="land-bg">
<div class="landing-wrap">
<!--logo part start here-->
<div class="land-col align-center"><img src="../images/erandoo-logo.png"></div>
<!--logo part ends here-->

<!--COMING SOON part start here-->
<div class="land-col align-center"><h2>COMING SOON!</h2>
<p class="align-center">Our team of freelancers are currently putting the cherry on top<br/>
and getting erandoo ready for its international debut.</p>
</div>
<!--COMING SOON part ends here-->

<!--What is erandoo part start here-->
<div class="land-col2">
<h4 class="align-center color-red">What is erandoo?</h4>
<p class="align-center">We are the place where people who need things done find the people that want to do them.</p>

<div class="land-col3">
<h5 class="color-orange">AT HOME:</h5>
<ul>
<li>House Cleaning</li>
<li>Landscape/Yard Work</li>
<li>Endless Handyman Jobs</li>
<li>Local Deliveries/Pick-Up</li>
<li>Special On Demand Instant Services!</li>
<li>And more…</li>
</ul>
</div>

<div class="land-col3">
<h5 class="color-orange">AT THE OFFICE:</h5>
<ul>
<li>Copy Writing/Editing</li>
<li>Graphic Design</li>
<li>Virtual Administrative Assistance</li>
<li>Web Design</li>
<li>And more…</li>
</ul>
</div>

</div>
<!--What is erandoo part ends here-->
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'virtualtask-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>
<!--REQUEST AN INVITE part start here-->
<div class="land-col">
<p class="align-center">Want a special invitation announcing our debut? Skip the line and get noticed first.</p>
<div class="land-col4">
<div class="land-col5">
    <?php echo $form->textField($invitation, Globals::FLD_NAME_EMAIL, 
        array('class' => 'form-control','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter Your Email Address')))); ?>
    </div>
<div class="land-col6"><button class="btn-u r-btn" type="button">REQUEST AN INVITE</button></div>
</div>

</div>
<?php echo $form->error($invitation, Globals::FLD_NAME_EMAIL,array('class' => 'invalid')); ?>
<?php $this->endWidget(); ?>
<!--REQUEST AN INVITE part ends here-->

</div>

</div>
</div>