<div class="popup_head margin-bottom-30">
        <h2 class="heading"><?php echo CHtml::encode(Yii::t('index_login','Cancel project')); ?></h2><button id="cboxClose" onclick="closepopup();" type="button"><?php echo CHtml::encode(Yii::t('index_login','btn_txt_close')); ?></button>
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
<div class="col-md-12 no-mrg2 sky-form">
<?php
if($taskStatus != Globals::DEFAULT_VAL_TASK_STATE_UNDER_DISPUTE)
{
    ?>
    <div class="col-md-12">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_TASK_CANCEL_REASON, array('label' => CHtml::encode(Yii::t('poster_createtask', 'Reason for project cancellation')) , 'class' => 'label text-size-18')); ?>

                        </div>

    <div class="col-md-12 margin-bottom-10">


                            <?php  echo $form->textArea($task, Globals::FLD_NAME_TASK_CANCEL_REASON, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Enter project cancel reason')))); ?>

                            
                        </div>

    <div class="col-md-12"> 
        <div class="col-md-5 no-mrg">
        <?php echo $form->error($task, Globals::FLD_NAME_TASK_CANCEL_REASON,array('class' => 'invalid p-no-mrg')); ?>
        </div>
    <div class="f-right mrg-auto">
    <input type="button" value="Cancel" onclick="closepopup()" class="btn-u btn-u-lg rounded btn-u-red push">
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
    CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'Submit')), Yii::app()->createUrl($action), 'btn-u btn-u-lg rounded btn-u-sea push', 'useraddTask', $successUpdate);
    ?>
    </div>  </div> 
    <?php
}
else
{
    echo "<div class='col-md-12 tasker_name'>You can not cancel project when the project in under Disput</div>";
}
?>
 </div>                  
       
<?php $this->endWidget(); ?>
