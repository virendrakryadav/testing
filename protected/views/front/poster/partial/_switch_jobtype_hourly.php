<div class="tasker_row1 sky-form">
<?php       
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
   // 'id' => 'sendmessage-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>
    
   <div class="col-md-12 mrg sky-form">

<div class="col-md-12 no-mrg3">

<div class="col-md-4 no-mrg">
   <label for="exampleInputEmail1" class="label text-size-18">Awarded Price:<span class="required">*</span></label>
    
</div>
<div class="col-md-4 no-mrg">
    <label for="exampleInputEmail1" class="label text-size-18"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE}) ?></label>
    
</div>
<div class="col-md-4 no-mrg">
  <?php //$form-> ?>
    
</div>
</div>

<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18">Project Notes <span class="required">*</span></label>
<div class="col-md-12 no-mrg">

</div>
</div>


</div> 

<?php $this->endWidget(); ?>
</div>