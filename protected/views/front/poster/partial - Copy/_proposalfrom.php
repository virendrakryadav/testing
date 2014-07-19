<script>
    function GobackToEdit()
    {
        $("#proposalDiv").removeClass("displayNone");
        $("#queAnsDiv").addClass("displayNone");
        $("#proposalSubmitDiv").addClass("displayNone");
    }
</script>
<?php
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
<?php $question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});?>
 <div class="box">
 <div class="box_topheading"><h3 class="h3"><?php  echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_make_a_proposal')); ?></h3></div>
<!-- <div style="color:#FF0000;text-align: center;">Sorry bid closed</div>               -->
 <div class="box3">
                
                    <div id="proposalDiv" class="controls-row">
                    <div class="praposal_field formRelative">
                        
                        <?php //echo $form->textField($taskTasker, Globals::FLD_NAME_TASKER_PROPOSED_COST, array( 'class' => 'span3','placeholder' => CHtml::encode(Yii::t('poster_taskdetail', 'txt_estimated_cost')))); ?>
                        <?php echo $form->textFieldControlGroup($taskTasker, Globals::FLD_NAME_TASKER_PROPOSED_COST, array('labelOptions' => array("label" => false),'class'=>'pricein', 'prepend' => '$','placeholder' => CHtml::encode(Yii::t('poster_taskdetail', 'txt_estimated_cost')))); ?>
                        <?php echo $form->error($taskTasker, Globals::FLD_NAME_TASKER_PROPOSED_COST); ?>
                    </div>
                    <div class="praposal_field formRelative">
                        <div class="praposal_field ">
                            <?php echo $form->textArea($taskTasker, Globals::FLD_NAME_TASKER_POSTER_COMMENTS, array('class' => '', 'maxlength' => Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH, 'rows' =>7, 'placeholder' => CHtml::encode(Yii::t('poster_taskdetail', 'txt_proposal_description')))); ?>
                            <?php echo $form->error($taskTasker, Globals::FLD_NAME_TASKER_POSTER_COMMENTS); ?>
                        </div>
                        <div class="praposal_attach" onclick="SlideAttachments();" id="addAttachmentHead"> 
                            <a href="#"><i class="icon-plus-sign"></i> <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_add_attachment')) ?></a></div>
                        <div id="wordcountPosterComments" class="praposal_attach2 ">
                           
                            <?php
				$totelstringlength = Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH;
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                $srtlength = strlen($taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS});
                                $totelstringlength = $totelstringlength-$srtlength;
                                echo $totelstringlength;
				?>
                        
                        </div>
                    </div>
                    <div class="praposal_field formRelative">
                    <div id="loadAttachment" style="display: <?php if (isset($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}))
                            echo 'block'; ?> ">
                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadProposalAttachments','getAttachmentsPropsal','proposalAttachments');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadProposalAttachments', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
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
                            echo UtilityHtml::getAttachmentsOnEdit($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $currentUser->profile_folder_name,"proposalAttachments");
                        }
                                 ?>
                        </div>
                    </div>
                    </div>
                    
                    <div class="next_praposal formRelative">
                    <?php
                        
                        
                        $i = 1;
                        if($question)
                        { 
                            $successUpdate = '
                                    if(data.status==="save_success_message")
                                    {
                                        $("#proposalDiv").addClass("displayNone");
                                        $("#queAnsDiv").removeClass("displayNone");
                                        $("#proposalSubmitDiv").removeClass("displayNone");
                                   }
                                   else
                                   {
                                        $.each(data, function(key, val) 
                                        {
                                                    $("#tasketdetail-form #"+key+"_em_").text(val);                                                    
                                                    $("#tasketdetail-form #"+key+"_em_").show();
                                        });
                                   }
                                ';
                                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_next')), Yii::app()->createUrl('poster/validateproposal'), 'sign_bnt', 'taskervalidateProposal', $successUpdate);
                        }
                        
                        ?>
                    </div> 

    </div>
                    <div id="queAnsDiv" class="controls-row displayNone" >
        <div class="praposal_field formRelative">
            <h4 ><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'txt_answere_some_que')); ?> :</h4>
            
            <?php
            $i = 1;
            if($question)
            {
                if(isset($taskTasker->tasker_id)) $answers =  CommonUtility::getQuestionAnswerByTasker($task->{Globals::FLD_NAME_TASK_ID}, $taskTasker->tasker_id );

                foreach ($question as $questions)
                {
                    $value ='';
                    if(isset($answers[$questions->question_id]))
                    {
                        $value = $answers[$questions->question_id];
                    }
                    ?> <div class="span3 nopadding"> <?php  echo $i . '. ' . $questions->categoryquestionlocale->question_desc; ?> </div>
                    <div class="span3">
                        <?php echo UtilityHtml::getQuestionInputType($questions->categoryquestion->question_type, $questions->question_id,$form,$taskQuestionReply,$value,'span3'); ?>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
                <div id="proposalSubmitDiv" class="controls-row <?php if($question){echo 'displayNone'; } ?>">
                    <div class="previous_praposal <?php if(!$question){echo 'displayNone'; } ?>">
                        <input id="gobacktoedit" class="sign_bnt " type="button" onclick="GobackToEdit();" value="Back" name="gobacktoedit">
                    </div>
                <div class="next_praposal ">
                    
                        <?php
                       echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                      // echo $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID};
                        if(isset($task_tasker_id))
                        {
                            $action = 'poster/editproposal';
                            echo $form->hiddenField($taskTasker, 'task_tasker_id');
                        }
                        else
                        {
                             $action = 'poster/saveproposal';
                        }
                                $successUpdate = '                                    
                                    if(data.status==="save_success_message")
                                    {

                                        $.ajax({
                                                url      : "' . Yii::app()->createUrl('poster/loadproposalpreview') . '",
                                                data     : { "taskId": '.$task->{Globals::FLD_NAME_TASK_ID}.' , "task_tasker_id" : data.task_tasker_id },
                                                type     : "POST",
                                                dataType : "html",
                                                cache    : false,
                                                success  : function(html)
                                                {
                                                    jQuery("#loadproposalpreview").html(html);
                                                    jQuery("#loadproposalpreview").css("display","block");
                                                },
                                                error:function(){
                                                   // jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                }
                                            });

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
                                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_preview_proposal')), Yii::app()->createUrl($action), 'sign_bnt', 'taskerSendProposal', $successUpdate);
                        
                        ?>
                    </div>
                </div>
</div>
 </div>
<?php $this->endWidget(); ?>
          