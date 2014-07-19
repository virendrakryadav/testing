<style>
    .rightbar 
    {
        padding: 0 2px 10px 7px;
        width: 95%;
    }
    
    .task_detail_col2 
    {
        float: left;
        padding: 0 0 10px 10px;
        width: 120px;
    }
    .task_descrip 
    {
        padding: 5px 0 15px 10px;
    }
    .nopad
    {
        padding-bottom: 5px;
    }
</style>
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
  <div class="popup_head">
        <h2 class="heading"><?php echo Yii::t('poster_createtask', 'Proposal Preview')?></h2>
      </div>
<div class="controls-row "> 

    <div class="page-container ">
        <div id="msgConfirmTask" style="display:none" class="flash-success"></div>
        <!--about profile Start here-->
        <div class="controls-row">
            <div class="profile_img">
                <?php $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                <img src="<?php echo $img ?>"></div>
            <div class="profile_name"><h1><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp<span class="tagline"><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></h1>
                <span class="tagline"><?php echo $model->tagline; ?></span></div>
        </div>
        <!--about profile Ends here-->

        <!--Left side bar start here-->
   
        <!--Right side content start here-->
        <div class="rightbar1 box2 span11">
            <div class="box">
                <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_proposal_detail')) ?>&nbsp<?php echo $task->title; ?>&nbsp</h3></div>
                <!--tasker specialties start here-->
                <div class="task_detail_col1 box2">
<!--                        <h2 class="h4"><?php //echo CHtml::encode(Yii::t('poster_confirmtask', 'Proposal Detail')) ?></h2>-->
                        
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_proposal_date')) ?></div>
                            <div class="task_detail_col3"><?php echo CommonUtility::formatedViewDate($taskTasker->{Globals::FLD_NAME_CREATED_AT}); ?></div>
                        </div>
                      
                        <div class="controls-row">
                            <div class="task_detail_col2"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_estimated_cost')) ?></div>
                            <div class="task_detail_col3 blue_text">
                                <?php echo UtilityHtml::displayPrice( $taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ) ?>
                                <?php // echo Globals::DEFAULT_CURRENCY.$taskTasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ?></div>
                        </div>

                        <div class="task_descrip">
                              <h4><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_proposal')); ?></h4>
                              <?php echo $taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS} ?> 
                        </div>
                    </div>
                
                    
                <!--tasker specialties ends here-->

                <!--task detail  start here-->
                
<div class="controls-row">
                    <?php echo UtilityHtml::getProposalAttachments($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $model->profile_folder_name,$taskTasker->task_tasker_id); ?>

                </div>

                <div class="controls-row pdn" id="ratingtab">

                  
                        
                        <?php
                $question = TaskQuestion::getTaskQuestion($task_id);
                $i = 1;
                if($question)
                {
                    ?>
                    <h2 class="h4"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_answers')) ?></h2>
                    <?php
                            $answers =  CommonUtility::getQuestionAnswerByTasker($task_id, $taskTasker->tasker_id );
                            if($answers)
                            {
                               foreach ($question as $questions)
                               {
                               ?>
                                    <div class="task_descrip" >
                                       <h4><?php echo $i . '. ' . $questions->categoryquestionlocale->question_desc; ?></h4>
                                       <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?>  <?php echo $answers[$questions->question_id]; ?>
                                    </div>
                                   <?php
                                   $i++;
                               }
                            }
                           
                         
                }
                ?>


                </div>
               <div class="controls-row cnl_space box2">
                  <div class="btn_cont">
                   <?php
                   if(!isset($is_pubilshed))
                   {
                      // echo $taskTasker->task_tasker_id;
                    if($question)
                    {
                           echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/proposal'), array(
                              'beforeSend' => 'function(){$("#loadProposalDiv").addClass("displayLoading");}',
                              'complete' => 'function(){$("#loadProposalDiv").removeClass("displayLoading");
                                  $("#proposalDiv").removeClass("displayNone");
                                  $("#queAnsDiv").addClass("displayNone");
                                  
                                  $("#proposalSubmitDiv").addClass("displayNone");
                                  }
                                  ',
                              'data' => array( 'taskTasker' => $taskTasker->task_tasker_id, 'taskId' =>$task_id  ), 'type' => 'POST',
                          'success' => 'function(data){$(\'#loadProposalDiv\').html(data);   jQuery("#loadproposalpreview").css("display","none"); }'), array('id' => 'edituserproposal', 'class' => 'sign_bnt', 'live' => false));
                    }
                    else
                    {
                          echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/proposal'), array(
                              'beforeSend' => 'function(){$("#loadProposalDiv").addClass("displayLoading");}',
                              'complete' => 'function(){$("#loadProposalDiv").removeClass("displayLoading");
                                  $("#proposalDiv").removeClass("displayNone");
                                  $("#queAnsDiv").addClass("displayNone");
                                  
                                  $("#proposalSubmitDiv").addClass("displayBlock");
                                  }
                                  ',
                              'data' => array( 'taskTasker' => $taskTasker->task_tasker_id, 'taskId' =>$task_id  ), 'type' => 'POST',
                          'success' => 'function(data){$(\'#loadProposalDiv\').html(data);   jQuery("#loadproposalpreview").css("display","none"); }'), array('id' => 'edituserproposal', 'class' => 'sign_bnt', 'live' => false)); 
                    }
                      
                    ?>
                    &nbsp;
                    <?php 
                    echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                    echo $form->hiddenField($taskTasker, 'task_tasker_id');
                    $successUpdate = '
                                    if(data.status==="save_success_message")
                                    {

                                        $.ajax({
                                                url      : "' . Yii::app()->createUrl('poster/proposal') . '",
                                                data     : { "taskId": '.$task->{Globals::FLD_NAME_TASK_ID}.' , "taskTasker" : data.task_tasker_id
                                                , "is_published" : 1 },
                                                type     : "POST",
                                                dataType : "html",
                                                cache    : false,
                                                success  : function(html)
                                                {
                                                    jQuery("#loadProposalDiv").html(html);
                                                    
//                                                    jQuery("#postedporposal").css("display","block");
                                                    jQuery("#loadproposalpreview").css("display","none");
//                                                    jQuery("#proposal").css("display","none");
//                                                    jQuery("#sendProposal").css("display","none");
                                                },
                                                error:function(){
                                                   // jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                }
                                            });

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
                                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_taskdetail', 'lbl_send')), Yii::app()->createUrl('poster/publishproposal'), 'sign_bnt', 'taskerSendProposal', $successUpdate);
                  
                  }
                  else
                  {
                     ?>
                     <input class="sign_bnt" type="button" value="<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_back')) ?>" onclick="document.getElementById('loadproposalpreview').style.display='none';" />
                     <?php
                  }
                        ?>
                  </div>
               </div>
                <!--task detail ends here-->


            </div>
        </div>
        <!--Right side content ends here-->
    </div>
</div>
<?php $this->endWidget(); ?>