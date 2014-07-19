<?php 

//$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
//				'id'=>'create-task-form',
//				'enableAjaxValidation' => false,
//                                'enableClientValidation' => true,
//				
//			)); 
?>
<?php Yii::import('ext.chosen.Chosen'); ?>
<?php
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlength = $totelstringlength-$srtlength; 
$category_id ='';
if(isset($editTaskPartials['category_id']))
            $category_id = $editTaskPartials['category_id'];
?>
<?php echo CommonScript::loadRemainingCharScript('Task_description', 'wordcountPosterComments', $totelstringlength) ?>

<input id="categoryIdHidden" type="hidden" name="category_id_value" value="<?php echo $category_id ?>" >


<!--Project details Start here-->
  <div class="panel panel-default margin-bottom-20">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseOne">
          Project Details<span class="color-red">*</span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in sky-form">
      <div class="panel-body">

<div class="col-md-6 no-mrg">

<div class="col-md-11 no-mrg3">
<div class="inline-group">
<label class="label text-size-18">Visibility</label>
<?php //$payment_mode = array('1' => CHtml::encode(Yii::t('poster_createtask', 'txt_public_visible_to_everyone')), '0' => CHtml::encode(Yii::t('poster_createtask', 'txt_private_only_candidates_i_invite_can_respond'))); ?>
                 
<?php //echo $form->radioButtonControlGroup($task, Globals::FLD_NAME_IS_PUBLIC, $payment_mode); ?>                   
<?php// echo CHtml::error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
                  

<label class="radio"><input type="radio" id="Task_is_public" <?php if($task->{Globals::FLD_NAME_IS_PUBLIC} == 1) echo 'checked' ?> name="<?php echo Globals::FLD_NAME_TASK ?>[<?php echo Globals::FLD_NAME_IS_PUBLIC ?>]" value="1"><i class="rounded-x"></i>Public</label>
<label class="radio"><input type="radio" id="Task_is_private" <?php if($task->{Globals::FLD_NAME_IS_PUBLIC} == 0) echo 'checked' ?> name="<?php echo Globals::FLD_NAME_TASK ?>[<?php echo Globals::FLD_NAME_IS_PUBLIC ?>]" value="0"><i class="rounded-x"></i>Private</label>
<?php echo $form->error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
</div>
</div>
    
<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18">Posting Type</label>
<div class="col-md-12 no-mrg">
<div class="col-md-3 no-mrg">
    <?php 
    $isPremiumName = Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_IS_PREMIUM_TASK."]";
    $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
'name' => $isPremiumName,
        'value' => $task->{Globals::FLD_NAME_IS_PREMIUM_TASK}
));?>
</div>
<!--    <button class="btn btn-lg btn-default">Basic</button>
    <button class="btn btn-lg active btn-primary">Premium</button>-->
<div class="no-mrg">
   
    <label class="radio">Premium Posting</label>
    
</div>
</div>
</div>
    <div class="col-md-11 no-mrg2">
<div class="col-md-12 no-mrg">
<div class="col-md-3 no-mrg">
    <?php 
    $isHihglight = Globals::FLD_NAME_TASK."[".Globals::FLD_NAME_IS_HIGHLIGHTED."]";
    $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
'name' => $isHihglight,
        'value' => $task->{Globals::FLD_NAME_IS_HIGHLIGHTED}
));?>
</div>
<div class="no-mrg">
   
    <label class="radio">Highlighted Search Result</label>
    
</div>
</div>

</div>

    
    
<div class="col-md-11 no-mrg2">

<?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_TITLE, 
        array('class' => 'form-control','placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_title')), 
            'label' => 'Project Title','labelOptions' => array('class' => 'text-size-18' ), )); ?>
<!--<input type="email" placeholder="Organizing my contacts" class="form-control ">-->
</div>
<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18">Project Completion</label>
<!--<div class="col-md-6 no-mrg">
   
   
       <?php
//                        $date = '';
//                        $minDate = Globals::DEFAULT_VAL_DATE_START_FROM;
//                        if (isset($task->{Globals::FLD_NAME_TASK_START_DATE})) {
//                            $date = $task->{Globals::FLD_NAME_TASK_START_DATE};
//                           // $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
//                         //   $minDate = $date;
//                        }
                        ?>
    <div class="control-group ">
          
           <div class="controls">
                <?php 
                
//                $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
//                'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_START_DATE.']',
//                    'value' => $date,
//                'pluginOptions' => array(
//                'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
//                        'startDate' => $minDate,
//                ),
//                    'htmlOptions' => array(
//                                        'class' => 'form-control',
//                                            'onkeydown' => 'return false',
//                                        'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_start')),
//                                        'readonly' => false,
//                                         //  'disabled'=>$is_public, 
//                                        ),
//                ));
                ?>
                <?php echo $form->error($task, Globals::FLD_NAME_TASK_START_DATE); ?>
           </div>
       </div>
   
</div>-->
<div class="col-md-12 no-mrg">
    <?php
        $date = '';
        $minDateEnd =  Globals::DEFAULT_VAL_DATE_START_FROM;
        if (isset($task->{Globals::FLD_NAME_TASK_END_DATE})) {
            $date = $task->{Globals::FLD_NAME_TASK_END_DATE};
          //  $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
           // $minDateEnd = $date;
//            if( $is_public == true)
//            {
//                $minDateEnd = $date;
//            }
        }
        ?>
       <div class="control-group ">
          
           <div class="controls">
               <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                    'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_END_DATE.']',
                    'value' => $date,
                      'pluginOptions' => array(
                      'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
                              'startDate' => $minDateEnd,
                      ),
                          'htmlOptions' => array(
                                              'class' => 'form-control',
                                                  'onkeydown' => 'return false',
                                              'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_date')),
                                              'readonly' => false,
                                               //  'disabled'=>$is_public, 
                                              ),
                      ));
                ?>
    <?php echo $form->error($task, Globals::FLD_NAME_TASK_END_DATE); ?>
           </div>
       </div>
    
<?php
//$this->widget(
//'yiiwheels.widgets.timepicker.WhTimePicker',
//array(
//'htmlOptions' => array('class' => 'form-control',
//                                'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'End Time')),
//                        ),
//    'pluginOptions' => array('showMeridian' => false),
//'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_END_TIME.']',
//'value' => Globals::DEFAULT_VAL_TASK_END_TIME,
//
//)
//);
?>
   </div>
</div>


<div class="col-md-11 no-mrg2">
<label for="exampleInputEmail1" class="label text-size-18">Bid End Date</label>
<div class="col-md-6 no-mrg">
   
   
       <?php
                        $date = '';
                        $minDate = Globals::DEFAULT_VAL_DATE_START_FROM;
                        if (isset($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE})) {
                            $date = $task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE};
                            $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH, $date);
                         //   $minDate = $date;
                        }
                        ?>
    <div class="control-group ">
          
           <div class="controls">
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                'name' => Globals::FLD_NAME_TASK.'['.Globals::FLD_NAME_TASK_BID_CLOSE_DATE.']',
                    'value' => $date,
                'pluginOptions' => array(
                'format' => Globals::DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL,
                        'startDate' => $minDate,
                ),
                    'htmlOptions' => array(
                                        'class' => 'form-control',
                                            'onkeydown' => 'return false',
                                        'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Bid Close Date')),
                                        'readonly' => false,
                                         //  'disabled'=>$is_public, 
                                        ),
                ));
                ?>
                <?php echo $form->error($task, Globals::FLD_NAME_TASK_BID_CLOSE_DATE); ?>
           </div>
       </div>
   
</div>

</div>

</div>

<div class="col-md-6 no-mrg">

<div class="col-md-11 no-mrg3">
<div class="inline-group">
<label class="label text-size-18">Project Description</label>
<div id="categoryTemplates">
<?php 
if(isset($editTaskPartials['template']))
{
    echo $editTaskPartials['template'];
}
?>
</div>
<?php
echo $form->textAreaControlGroup($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 7, 
                                'labelOptions' => array('label' => false ), 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 

?>

<div id="wordcountPosterComments" class="col-md-12 no-mrg right-align"><?php
				
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                
                                echo $totelstringlength;
				
				?></div>

</div>
</div>
<div class="col-md-12 no-mrg2">
<label for="exampleInputEmail1" class="text-size-18">Estimated Project Price</label>
<div class="col-md-12 estimated-cont">
<div class="grad-box margin-top-bottom-30 vtabprice">
<div id="selectPriceMode" class="vtab2">
<ul>
    <li><a id="selectPriceModeHourly" class="<?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} != Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'active' ?>" href="javascript:void(0)" onclick="setPriceMode('<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY ?>')">Hourly</a></li> 
<li><a id="selectPriceModeFixed" href="javascript:void(0)" class="<?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'active' ?>" onclick="setPriceMode('<?php echo Globals::DEFAULT_VAL_PAYMENT_MODE ?>')">Fixed</a></li>
</ul>
</div>
</div>
    <?php 
    if(!isset($task->{Globals::FLD_NAME_PAYMENT_MODE}))
    {
        $task->{Globals::FLD_NAME_PAYMENT_MODE} = Globals::DEFAULT_VAL_PAYMENT_MODE_HOURLY;
    }
    else 
    {
        $task->{Globals::FLD_NAME_PAYMENT_MODE} = $task->{Globals::FLD_NAME_PAYMENT_MODE};
    }
?>
<?php echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE, array( 'value' => Globals::FLD_NAME_PAYMENT_MODE)); ?>
<section>
<div class="row">
<label class="label colsspace col-4">Price Range</label>
<div class="col col-8">
<div class="input-group col-md-5 f-left" >
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_TASK_MIN_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_MIN_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_MIN_PRICE} = intval($task->{Globals::FLD_NAME_TASK_MIN_PRICE});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_MIN_PRICE, array('class'=>'form-control' , 'onkeyup' => 'estimatedCost();')); ?>


</div>
<div class="col-md-2 f-left2">To</div>
<div class="input-group col-md-5 f-left">
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_MAX_PRICE} = intval($task->{Globals::FLD_NAME_TASK_MAX_PRICE});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_MAX_PRICE, array('class'=>'form-control','onkeyup' => 'estimatedCost();')); ?>
</div>

</div>
<div class="col-md-13 no-mrg right-align">Minimum of $<span id="min_price_msg">0</span></div>
</div>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_MIN_PRICE); ?>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_MAX_PRICE); ?>
</section>


    <section id="for_fixed_price_mode" style="display : <?php if($task->{Globals::FLD_NAME_PAYMENT_MODE} == Globals::DEFAULT_VAL_PAYMENT_MODE ) echo 'none' ?>">
<div class="row">
<label class="label colsspace col-5">Estimated # of hours per week</label>
<div class="col col-7">
<div class="input-group col-md-6 f-right" >
    <?php 
    if(!isset($task->{Globals::FLD_NAME_WORK_HRS}))
    {
        $task->{Globals::FLD_NAME_WORK_HRS} = Globals::DEFAULT_VAL_WORK_HRS;
    }
    else 
    {
        $task->{Globals::FLD_NAME_WORK_HRS} = intval($task->{Globals::FLD_NAME_WORK_HRS});
    }
?>
<?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'form-control', 'max' => 2, 'onkeyup' => 'estimatedCost();','labelOptions' => array('label' => false ))); ?>

<!--<input type="text" class="form-control">-->
</div>
</div>
</div>
</section>

<section>
<div class="row">
<label class="label colsspace2 col-4">Expected Expenses <span class="text-size-11">Stamps, Tickets etc.</span></label>
<div class="col col-8">
<div class="input-group col-md-12 f-left" >
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_TASK_CASH_REQUIRED} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_TASK_CASH_REQUIRED} = intval($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_TASK_CASH_REQUIRED, array('class'=>'form-control','onkeyup' => 'estimatedCost();')); ?>

</div>
</div>
</div>
<?php echo $form->error($task, Globals::FLD_NAME_TASK_CASH_REQUIRED); ?>
</section>


<section>
<div class="row">
<label class="label colsspace col-4">Estimated Cost</label>
<div class="col col-8">
<div class="input-group col-md-12 f-left" >
<span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
<?php 
    if(!isset($task->{Globals::FLD_NAME_PRICE}))
    {
        $task->{Globals::FLD_NAME_PRICE} = Globals::DEFAULT_VAL_MIN_PRICE;
    }
    else 
    {
        $task->{Globals::FLD_NAME_PRICE} = intval($task->{Globals::FLD_NAME_PRICE});
    }
?>
<?php echo $form->textField($task, Globals::FLD_NAME_PRICE, array('class'=>'form-control' , 'onkeyup' => 'estimatedCost();' , 'readonly' => true)); ?>
</div>
</div>
</div>
</section>

</div>
</div>


</div>

      </div>
    </div>
  </div>
  <!--Project details Ends here-->
    <div class="panel panel-default margin-bottom-20">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseFour">
          Attachments
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse sky-form">
    <div class="panel-body">
    <div class="col-md-12 no-mrg">

<div class="col-md-11 no-mrg3">
<div class="inline-group">
      <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                       <?php
//    $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
//    'name' => 'uploadPortfolioImage',
//    'uploadAction' => $this->createUrl('poster/uploadtaskfiles', array('fine' => 2)),
//    'pluginOptions' => array(
//    'validation'=>array(
//    'allowedExtensions' => $allowArray
//    )
//    )
//    ));
    ?>
                        <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio" class="" style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; else
                            echo 'none';
                        ?> ">
                                 <?php
                                 if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                                     echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name ,$task->{Globals::FLD_NAME_TASK_ID});
                                 }
                                 ?>

                        </div>

                    </div>
</div>
</div>

</div>
          
         
    </div>
    </div>
    </div>
  <!--Doer details Start here-->
  <div class="panel panel-default margin-bottom-20">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseTwo">
          Doer Details
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse sky-form">
      <div class="panel-body">
    <div class="col-md-5 no-mrg">

<div class="col-md-11 no-mrg3">
<div class="inline-group">
<label class="label text-size-18">Doer Location</label>
<div class="col col-4 no-mrg">
                
<label class="radio"><input type="radio" <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] != Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'checked' ?> onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>');" value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE ?>" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Anywhere</label>
<label class="radio"><input type="radio" value="<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>" <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'checked' ?> onclick="setLocation('<?php echo Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY ?>');" name="<?php echo  Globals::FLD_NAME_TASK_LOCATION."[".Globals::FLD_NAME_IS_LOCATION_REGION."]" ?>"><i class="rounded-x"></i>Country</label>
</div>
<div id="selectCountryLocation" class="col-md-10 no-mrg3" style="display: <?php if( $taskLocation[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY  ) echo 'block'; else echo 'none'; ?>">
<?php
$locationList = "";
$locations = array();

$taskSelectedLocations = CommonUtility::getTaskPreferredLocations($task->{Globals::FLD_NAME_TASK_ID});
//print_r($taskSelectedLocations);
if($taskSelectedLocations)
{
    if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
    {
        $locations = CommonUtility::getCountryList();

        $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
    }
    
    $locationList = $taskSelectedLocations[Globals::FLD_NAME_LOCATIONS];
}
$locations = CommonUtility::getCountryList();
                                    
$placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS, $locationList, $locations, array(
                            'data-placeholder' => $placeholder,
                            'options' => array(
                                'displaySelectedOptions' => false,
                                ),
                                'class'=>'form-control'
                        ));
?>
</div>
</div>
</div>

</div>
          
         

<div  id="getskills">
<?php 
if(isset($editTaskPartials['skills']))
{
    echo $editTaskPartials['skills'];
}
?>
              
</div>

<div id="getQuestions" class="col-md-12 no-mrg">
<?php 
if(isset($editTaskPartials['questions']))
{
    echo $editTaskPartials['questions'];
}
?>
</div>
    </div>
    </div>
    </div>
  <!--Doer details Ends here-->
  
  
  

    

<?php //$this->endWidget(); ?>