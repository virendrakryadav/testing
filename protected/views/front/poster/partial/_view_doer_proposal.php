   <div class="margin-bottom-30">
            <div class="col-md-12 no-mrg">
                <div class="col-md-12 no-mrg">
                    <div class="tasker_row1">                        
                        <div class="proposal_col3">
                             <h3 class=""><?php echo Yii::t('tasker_mytasks', 'Proposal detail')?></h3>
                            <div class="proposal_row2"><strong><?php echo Yii::t('tasker_mytasks', 'Description')?>:</strong> <?php  echo $taskerProposal->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?></div>   
                            <?php
                            $question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
                            
                            $i = 1;                            
                            if($question)
                            {
                            ?>
                            <div class="proposal_row2">
                                <h3><?php echo Yii::t('tasker_mytasks', 'Question answer:')?></h3>
                                <div class="quest_cont">
                                    <ul>
<!--                                    <h2 class="h4"><?php // echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_answers')) ?></h2>-->
                                        <?php
                                        $answers =  CommonUtility::getQuestionAnswerByTasker($task->{Globals::FLD_NAME_TASK_ID}, $taskerProposal->{Globals::FLD_NAME_TASKER_ID} );
//                                        print_r($answers);
//                                        exit;
                                        if($answers)
                                        {
                                            foreach ($question as $questions)
                                            {
                                            ?>
                                        <li><span class="quescoler">Q.</span><?php echo $i . '. ' . $questions[Globals::FLD_NAME_TASK_QUESTION_DESC]; ?></li>
                                                <li><span class="quescoler"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?></span>  <?php if(isset($answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}])) echo $answers[$questions->{Globals::FLD_NAME_TASK_QUESTION_ID}]; ?></li>                                    
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                        <!--    </li>-->

                        <?php $attachments =  UtilityHtml::getProposalAttachments($taskerProposal->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $model->profile_folder_name,$taskerProposal->task_tasker_id); 
                        if($attachments)
                        {?>
                        <div class="proposal_row2">
                        <h3 class="quest"><?php echo CHtml::encode(Yii::t('poster_mytasklist', 'Attachments'));?></h3>
                        <div class="attachrow">
                            <div class="clr-padding-upload"></div>
                            <?php echo $attachments ?>
                            <div class="clr-padding-upload"></div>
                        </div>
                        </div>   
                        <?php
                        }
                        ?>
                        
                        </div>
                    </div>                                                    
               </div>              
<!--            </div>-->
<!--         </div>        -->
            </div>
        </div>