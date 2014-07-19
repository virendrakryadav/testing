<div class="popup_head">
        <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_login','Cancel task')); ?></h2><button id="cboxClose" onclick="closepopup();" type="button"><?php echo CHtml::encode(Yii::t('index_login','btn_txt_close')); ?></button>
</div>
<?php
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlength = $totelstringlength-$srtlength;                   
?>
<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadRemainingCharScript("Task_description_editable","wordcount",$totelstringlength) ?>
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
<div class="controls-row pdn2">
   
    <div class="controls-row pdn3">
       
        <!--Instant task left form part start here-->
     
            

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("dic-ic.png") ?>"></div>
                <div class="span4 nopadding">
                    <div class="span3  nopadding">
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'Task cancel reason ')))); ?>

                    </div>
                    
                    <div class="span4 nopadding">
                       
                            
                          <?php  echo $form->textArea($task, Globals::FLD_NAME_TASK_CANCEL_REASON, array('class' => 'span5', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter task cancel reason')))); ?>
                      
                        <?php echo $form->error($task, Globals::FLD_NAME_TASK_CANCEL_REASON); ?>
                    </div>
                   
                   
                   
                </div>
              
            </div>

              
            
     
     

        
   
        
    </div>
  
      <div class="controls-row cnl_space">
        <div class="btn_cont">
            <div class="ancor">
                
        <?php
      
        echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
            $action = "poster/canceltask";
           
        if(isset($refresh))
        {
            $afterAction = 'window.location.reload(true);';
        }
        else
        {
             $afterAction = '  $.fn.yiiListView.update( \'loadmypostedtask\');
                                    closepopup();';
        }
        $successUpdate = '
                                if(data.status==="success"){
                                
                                
                                    '.$afterAction.' 
                                        }else{
                                   $.each(data, function(key, val) {
                                                $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                $("#virtualtask-form #"+key+"_em_").show();
                                                });
                                   }
                                ';
CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_save')), Yii::app()->createUrl($action), 'sign_bnt', 'useraddTask', $successUpdate);
?>
            </div>
        
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
