<script>
    function GobackToEdit()
    {
        $("#proposalDiv").removeClass("displayNone");
        $("#queAnsDiv").addClass("displayNone");
        $("#proposalSubmitDiv").addClass("displayNone");
    }
    function confirmBeforeUnload(e) {
        var e = e || window.event;
        if( parseInt($("#pageleavevalidation").val().length) > 1 )
        {
            if($("#pageleavevalidationonsubmit").val().length == 0 )
            {
                if (e) 
                {
                    e.returnValue = '<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_are_you_sure_to_leave')); ?>';
                }
                // For Safari
                return '<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_are_you_sure_to_leave')); ?>';
            }
        }
    }
    window.onbeforeunload = confirmBeforeUnload;

$(document).ready(function(){
$('#TaskTasker_poster_comments').on('keyup',function(){
    $('#pageleavevalidation').val("done");
  });                        
});
</script>
<?php echo CommonScript::loadRemainingCharScript('TaskTasker_poster_comments', 'wordcountPosterComments', Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH) ?>

<?php echo CommonScript::errorMsgDisplay() ?>
<?php echo CommonScript::errorMsgDisplay(".input-group .form-control") ?>
<?php $question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});?>
<?php
$taskList = empty($taskList) ? 'false' : $taskList;
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'tasketdetail-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>

<!--Project live apply start-->
<div class="col-md-12 overflow-h project-live-apply">
<div class="col-md-12 no-mrg">
    <div class="col-md-8 no-mrg"><h3>Craft A Bid <span id="bidFor"></span></h3></div>
<div class="f-right1"> 
<a class="minimize-btn" onclick="minimizePopup('applyProposal')" href="javascript:void(0)"><img src="<?php  echo CommonUtility::getPublicImageUri( "bid-minus.png" ) ?>"></a>
<a class="maximize-btn" onclick="maximizePopup('applyProposal')"  style="display: none" href="javascript:void(0)"><img src="<?php  echo CommonUtility::getPublicImageUri( "bid-plus.png" ) ?>"></a>
<a href="javascript:void(0)" onclick="closeApplyForTask()" ><img src="<?php  echo CommonUtility::getPublicImageUri( "bid-close.png" ) ?>"></a>
</div>
</div>
    <div class="clr"></div>


<div id="applyProposal-minimize" >
    
    <div id="proposalDiv">
<div class="col-md-12 no-mrg">
    <?php echo $form->textArea($taskTasker, Globals::FLD_NAME_TASKER_POSTER_COMMENTS, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH, 'rows' =>7, 'placeholder' => CHtml::encode(Yii::t('poster_taskdetail', 'Enter your proposal')))); ?>
    <div  class="col-md-6 no-mrg">
        <?php echo $form->error($taskTasker, Globals::FLD_NAME_TASKER_POSTER_COMMENTS,array('class' => 'invalid p-no-mrg')); ?>
    </div>  
<div id="wordcountPosterComments" class="col-md-4 no-mrg right-align f-right">
                           
                            <?php
				$totelstringlength = Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH;
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                $srtlength = strlen($taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS});
                                $totelstringlength = $totelstringlength-$srtlength;
                                echo $totelstringlength;
				?>
                        
                        </div>
</div>
        <div  class="col-md-12 bid-mrg applyPopupProjectLive " style="height: <?php if(intval($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) <= 0 && !$question ) { echo '160px';} ?> "  >
    <div class="col-md-12 bid-mrg1" >
      
    <?php
    $i = 1;
    if($question)
    {
        ?>
        <div class="col-md-12 bid-mrg1">
        <label for="exampleInputEmail1" class="label text-size-18">Required Question<span class="required">*</span></label>
        <?php
        if(isset($taskTasker->{Globals::FLD_NAME_TASKER_ID})) $answers =  CommonUtility::getQuestionAnswerByTasker($task->{Globals::FLD_NAME_TASK_ID}, $taskTasker->{Globals::FLD_NAME_TASKER_ID} );

        foreach ($question as $questions)
        {
            $value ='';
            if(isset($answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}]))
            {
                $value = $answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}];
            }
           // echo $questions[Globals::FLD_NAME_TASK_QUESTION_ID];
            ?> 
            <div class="col-md-12 no-mrg"><label for="exampleInputEmail1" class="label text-size-14"> <?php  echo $i . '. ' . $questions[Globals::FLD_NAME_TASK_QUESTION_DESC]; ?> </label></div>
            <div class="col-md-12 no-mrg3 not-sky-check">
                <?php echo UtilityHtml::getQuestionInputType($questions["categoryquestion"][Globals::FLD_NAME_QUESTION_TYPE], $questions[Globals::FLD_NAME_TASK_QUESTION_ID],$form,$taskQuestionReply,$value,'form-control'); ?>
            </div>
            <?php
            $i++;
        }
        ?>
        </div>
        <?php
    }
    ?>

</div>
<div  class="col-md-12 bid-mrg1  ">
<div class="col-md-5 no-mrg">
<div class="col-md-11 no-mrg3">
<div class="col-md-6 no-mrg">
<label for="exampleInputEmail1" class="label text-size-14">My Pay<span class="required">*</span></label>
<div class="input-group col-md-10 ">
<span class="input-group-addon">$</span>
<?php 
if($taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST})
{
    $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} = intval($taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST});
}

echo $form->textField($taskTasker, Globals::FLD_NAME_TASKER_PROPOSED_COST, array('class'=>'form-control text-align-right', 'onkeyup' => 'setApproverCost()')); ?>

</div>
<?php echo $form->error($taskTasker, Globals::FLD_NAME_TASKER_PROPOSED_COST,array('class' => 'invalid')); ?>
</div>
    
<div class="col-md-6 no-mrg">
<label for="exampleInputEmail1" class="label text-size-14">Poster Pays</label>
<div class="input-group col-md-10 f-left">
<span class="input-group-addon">$</span>
<!--<div class="poster-pays text-align-right" id="TaskTasker_approved_cost_view"><?php echo Globals::DEFAULT_VAL_MIN_APPROVED_COST; ?></div>-->
<?php 
$taskTasker->{Globals::FLD_NAME_APPROVED_COST} = round($taskTasker->{Globals::FLD_NAME_APPROVED_COST});
//echo //$form->hiddenField($taskTasker, Globals::FLD_NAME_APPROVED_COST, array('class'=>'form-control')); ?>
<?php echo $form->textField($taskTasker, Globals::FLD_NAME_APPROVED_COST, array('class'=>'form-control text-align-right', 'onkeyup' => 'setMyPayCost();')); ?>

</div>
<?php echo $form->error($taskTasker, Globals::FLD_NAME_APPROVED_COST,array('class' => 'invalid')); ?>
</div>
</div>
<div class="col-md-11 no-mrg3">
    
<div class="col-md-6 no-mrg">
<label for="exampleInputEmail1" class="label text-size-14">Expected Expenses</label>
<div class="col-md-11 no-mrg">
    <div class="input-group col-md-11 f-left">
<span class="input-group-addon">$</span>
<div class="budget-box form-control text-align-right" id="TaskTasker_approved_cost_view"><?php echo intval($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) ?></div>
<?php echo $form->hiddenField($task ,Globals::FLD_NAME_TASK_CASH_REQUIRED ); ?>
</div>
   
</div>
</div>
    
<div class="col-md-6 no-mrg">
<label for="exampleInputEmail1" class="label text-size-14">Time To Complete</label>
<div class="col-md-10 no-mrg">
    <?php
    $timeToComplete = Globals::timeToCompleteArray();
            echo   $form->dropDownList($taskTasker, Globals::FLD_NAME_PROPOSED_DURATION, $timeToComplete, array('class' => 'form-control'));
    ?>
<?php echo $form->error($taskTasker, Globals::FLD_NAME_PROPOSED_DURATION,array('class' => 'invalid')); ?>
</div>
</div>

</div>
    

</div>

<div class="col-md-7 border-left min-hight-200 drag-mrg">
<div class="col-md-12 no-mrg  sky-form">
<div class="col-md-12 no-mrg ">


    <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
    <?php
    $success = CommonScript::loadAttachmentSuccess('uploadProposalAttachments','getAttachmentsPropsal','proposalAttachments');
    $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
   $maxUploadFileSize = LoadSetting::getMaxUploadFileSize();
   $minUploadFileSize = LoadSetting::getSettingValue(Globals::SETTING_KEY_MIN_UPLOAD_FILE_SIZE);
    CommonUtility::getUploader('uploadProposalAttachments', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, $maxUploadFileSize, $minUploadFileSize , $success);
    ?>
    <?php //echo $form->error($task,'image'); ?>
    <div id="getAttachmentsPropsal" style="display: <?php
    if (isset($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}))
        echo 'block'; else
        echo 'none';
    ?> ">
    <?php
    if (isset($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS})) 
    {
        echo UtilityHtml::getAttachmentsOnEdit($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $currentUser->{Globals::FLD_NAME_PROFILE_FOLDER_NAME}, $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID},"proposalAttachments" , 'proposal');
    }
            ?>
                                </div>
                          

</div>

</div>
</div>
    
   
        <div class="col-md-12 no-mrg" <?php if(intval($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) <= 0) echo 'style = "display:none"';?> >

        <label for="exampleInputEmail1" class="label text-size-14">
         <?php  echo   $form->checkBox($taskTasker, Globals::FLD_NAME_AGREE_FOR_EXPENSES, array('class' => 'check-mrg' ,'value'=>1, 'uncheckValue'=>'')); ?> This project has expected expenses. Checking this box means you are willing and able to pay these expenses
        and submit proper receipts for reimbursement by the Poster.</label>
        <?php echo $form->error($taskTasker, Globals::FLD_NAME_AGREE_FOR_EXPENSES,array('class' => 'invalid')); ?>
        </div> 

   
   
   
    
</div>
</div>
         <div class="col-md-12 no-mrg border-top">
<div class="f-right mrg-auto">
    <input type="button" onclick="closeApplyForTask()" class="btn-u btn-u-lg rounded btn-u-red push" value="Cancel"></button>


 <?php
                            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                            // echo $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID};
                            $redirect = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID});
                            if($isInvited)
                            {
                                $action = '//poster/editproposal';
                                echo $form->hiddenField($taskTasker, 'tasker_id' , array('value' => Yii::app()->user->id));
                            }
                            else
                            {
                                $action = '//poster/saveproposal';
                            }
                            if(isset($taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID}))
                            {
                                $action = '//poster/editproposal';
                                echo $form->hiddenField($taskTasker, 'task_tasker_id' , array('value' => $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID}));
                                echo $form->hiddenField($taskTasker, 'tasker_id' , array('value' => Yii::app()->user->id));
                                $redirect = CommonUtility::getTaskerAllProjectsUrl();
                            }
                            if($taskList == 'true')
                            {
                                //echo $taskList;
                                ?>
                                <input id="taskerSendProposal" class="btn-u btn-u-lg rounded btn-u-sea push" onclick="sendProposal()" type="button" value="Submit" name="yt1">
                                <?php
                            }
                            else
                            {
                                $successUpdate = '                                    
                                            if(data.status==="save_success_message")
                                            {

                                               // closeApplyForTask();
                                               $("#pageleavevalidationonsubmit").val("done");
                                                if($("#pageleavevalidationonsubmit").val() != "")
                                                {
                                                    window.location = "'. $redirect .'";
                                                }

                                            }                                   
                                            else
                                            {
                                                    if(data.status==="error")
                                                    {
                                                        //alert(data.msg);
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                    else
                                                    {
                                                        $.each(data, function(key, val) 
                                                        {
                                                                    $("#tasketdetail-form #"+key+"_em_").text(val);                                                    
                                                                    $("#tasketdetail-form #"+key+"_em_").show();
                                                        });
                                                    }
                                            }
                                        ';
                                        CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_taskdetail', 'Submit')), Yii::app()->createUrl($action), 'btn-u btn-u-lg rounded btn-u-sea push', 'taskerSendProposal'.$task->{Globals::FLD_NAME_TASK_ID}, $successUpdate);
                                
                            }
                                
                                        

                                ?>

</div>
</div>
</div>
    
</div>

</div>
<!--Project live apply start-->
<?php $this->endWidget(); ?>