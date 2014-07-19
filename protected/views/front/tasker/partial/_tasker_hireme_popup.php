<div class="col-md-12 no-mrg no-overflow">
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
    <div class="search_row">
       <div class="popup_head margin-bottom-30"><h2 class="heading">Confirmation</h2></div>
            <div class="proposal_row">
                <div class="col-md-12 no-mrg">
                    <p>You have chosen <b><?php echo CommonUtility::getUserFullName($taskTasker->{Globals::FLD_NAME_TASKER_ID}) ?></b> to work with you and your project. Please confirm that this is the Member you would like to work with and
                     the terms for this project:</p>
                    
                </div>
                
                <div class="col-md-12 ">
                   
                    <div class="proposal_col4 "> Project Details: <?php echo $task->{Globals::FLD_NAME_TITLE} ?></div>
                    <div class="proposal_col4 "> Project Type: <?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></div>
                    <div class="proposal_col4 "> Rate: <BID RATE></div>
                    <div class="proposal_col4 "> Expenses Required: <?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) ?></div>
                    <div class="proposal_col4 "> Project Start Date: <?php  echo  CommonUtility::projectStartDate($task->{Globals::FLD_NAME_TASK_ID}) ?></div>
                    <div class="proposal_col4 "> Project Completion Date:  
                        <?php 
                            if ($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON) 
                            {
                                echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_END_DATE});
                            } 
                            else 
                            {
                                echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                            }
                        ?>
                    </div>
                    
                </div>
                <div class="col-md-12 no-mrg">
                    <p></p>
                   
                    
                </div>
        <div class="col-md-12 no-mrg"  >

        <label for="exampleInputEmail1" class="label text-size-14">
         Are these terms exactly what you are agreeing to with this project?; <?php  echo   $form->checkBox($message, Globals::FLD_NAME_AGREE_FOR_TERMS, array('class' => 'check-mrg' ,'value'=>1, 'uncheckValue'=>'')); ?> 
        </label>
        <?php echo $form->error($message, Globals::FLD_NAME_AGREE_FOR_TERMS,array('class' => 'invalid')); ?>
        </div> 
                <div class="col-md-12 no-mrg">
                    <p>Would you like to continue to receive bid proposals from additional Doers; or is this project full? </p>
                     <div class="col-md-2 nopad">
                        <?php
                        if ($task->{Globals::FLD_NAME_HIRING_CLOSED} == 0) 
                        {
                            $switch = 1;
                            $disabled = false;
                        }
                        else
                        {
                            $switch = 0;
                            $disabled = true;
                        }
                        $isHihglight = Globals::FLD_NAME_HIRING_CLOSED;
                        $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
                            'name' => $isHihglight,
                            'value' => $switch,
                            'events' => array('switch-change' => 'function (e, data) { 
                                    
                                                jConfirm(\'Are you sure you want to close hiring for this project?\', \'Confirmation Hiring\', function(r) {
                                                    if( r == true)
                                                    {
                                                        var $el = $(data.el) , value = data.value;
                                                        if(!value)
                                                        {
                                                             setTaskHiring("' . $task->{Globals::FLD_NAME_TASK_ID} . '");
                                                        }

                                                    }
                                                    else
                                                    {
                                                        $(\'#hiring_closed\').parent().removeClass(\'switch-off\');
                                                        $(\'#hiring_closed\').parent().addClass(\'switch-on\');
                                                        $(\'#hiring_closed\').prop(\'disabled\', false);
                                                        $(\'#hiring_closed\').prop(\'checked\', true);
                                                    }
                                                    
                                                });

                                                       
                                                        
                                                    }'
                            ),
                            'htmlOptions' => array('disabled' => $disabled, 'onclick' => 'alert();')
                        ));
                        ?>

                        <div class="clr"></div>
                    </div>
                    
                </div>
                <div class="col-md-12 ">
                    <p>Please take a moment and send a message to your Doer with their first instructions: </p>
                    <div class="col-md-12 no-mrg">
                         <?php 
                            echo $form->textArea($message, Globals::FLD_NAME_BODY, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => '7', )); 
                            

                            echo $form->hiddenField($message, Globals::FLD_NAME_MSG_TYPE , array( 'value' => Globals::DEFAULT_VAL_MSG_TYPR_MESSAGES ));
                            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                            echo $form->hiddenField($message, Globals::FLD_NAME_SUBJECT , array( 'value' => Globals::DEFAULT_VAL_MSG_SUBJECT_PROPOSAL ) );
                               
                            echo $form->hiddenField($message, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => $taskTasker->{Globals::FLD_NAME_TASKER_ID}));
                            echo $form->hiddenField($task, Globals::FLD_NAME_CREATER_USER_ID , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID}));

                            ?>
<!--<div id="wordcountPosterComments" class="col-md-4 no-mrg right-align f-right">
                           
                            <?php
//				$totelstringlength = Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH;
//                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
//                                $srtlength = strlen($taskTasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS});
//                                $totelstringlength = $totelstringlength-$srtlength;
//                                echo $totelstringlength;
				?>
                        
                        </div>-->
                    </div>
                    
                </div>
                <div class="col-md-12"> 
                    <div class="col-md-5 no-mrg">
                        <?php echo $form->error($message, Globals::FLD_NAME_BODY,array('class' => 'invalid'));  ?>      
                    </div>
    <div class="f-right mrg-auto">
              <input type="button" class="btn-u btn-u-lg rounded btn-u-red push" onclick="closepopup();" value="Back">
             <?php
                         echo $form->hiddenField($taskTasker, Globals::FLD_NAME_TASK_TASKER_ID);
                            $successUpdate = '
                                    if(data.status==="success")
                                    {
                                        $.fn.yiiListView.update(\'loadAllProposals\');
                                        closepopup();
                                    }
                                    else
                                    {
                                        var msg = "";
                                        $.each(data, function(key, val)
                                        {
                                        
                                        
                                            $("#tasketdetail-form #"+key+"_em_").text(val);
//                                            $("#tasketdetail-form #"+key).addClass("state-error");
//                                            $("#tasketdetail-form #"+key).parent().addClass("state-error");
                                            $("#tasketdetail-form #"+key+"_em_").show();
                                        });
                                    }
                                    ';
                
                                    CommonUtility::getAjaxSubmitButton(
                                              'Submit',
                                                Yii::app()->createUrl('poster/proposalaccept'), 'btn-u btn-u-lg rounded btn-u-sea push', 'useraddTask', $successUpdate);
                                                ?>
    </div>  
    </div>
                    
            </div>

    </div>
<?php $this->endWidget(); ?>
</div>