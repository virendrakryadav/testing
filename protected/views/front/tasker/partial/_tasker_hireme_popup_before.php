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
       <div class="popup_head margin-bottom-15"><h2 class="heading">Confirmation</h2></div>
            <div class="proposal_row">

                <div class="col-md-12 no-mrg">
                    <h4 class="confirm-h4 color-orange">You have chosen <b id="popupDoerID"></b> to work with you and your project. Please confirm that this is the Member you would like to work with and the terms for this project:</h4>
                    
                </div>
                
                <div class="proposal_row1">
                   
                    <div class="confirm-col1"> Project Details: <a href="#"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></a></div>
                    <div class="confirm-col1"> Project Type: <span class="color-green1"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
                    <div class="confirm-col1"> Rate: <span class="color-green1"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE}); ?></span></div>
                    <div class="confirm-col1"> Expenses Required: <span class="color-green1"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) ?></span></div>
                    <div class="confirm-col1"> Project Start Date: <span class="color-light-grey"><?php  echo  CommonUtility::projectStartDate($task->{Globals::FLD_NAME_TASK_ID}) ?></span></div>
                    <div class="confirm-col1"> Project Completion Date:  
                       <span class="color-light-grey"> <?php 
                            if ($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON) 
                            {
                                echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_END_DATE});
                            } 
                            else 
                            {
                                echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                            }
                        ?></span>
                    </div>
                    
                </div>
                <div class="col-md-12 no-mrg">
                    <p></p>
                   
                    
                </div>
       		    <div class="col-md-12 no-mrg3"  >

        <label for="exampleInputEmail1" class="label text-size-14">
         Are these terms exactly what you are agreeing to with this project?; <?php  echo   $form->checkBox($message, Globals::FLD_NAME_AGREE_FOR_TERMS, array('class' => 'check-mrg' ,'value'=>1, 'uncheckValue'=>'')); ?> 
        </label>
        <?php echo $form->error($message, Globals::FLD_NAME_AGREE_FOR_TERMS,array('class' => 'invalid')); ?>
        </div> 
                <div class="col-md-12 no-mrg4">
                    <div class="col-md-9 no-mrg">Would you like to continue to receive bid proposals from additional Doers; or is this project full? </div>
                     <div class="col-md-2 no-mrg">
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
                            'htmlOptions' => array('disabled' => $disabled)
                        ));
                        ?>

                        <div class="clr"></div>
                    </div>
                    
                </div>

                <div class="col-md-12 no-mrg">
                    <p>Please take a moment and send a message to your Doer with their first instructions: </p>
                    <div class="col-md-12 no-mrg">
                         <?php 
                            echo $form->textArea($message, Globals::FLD_NAME_BODY, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => '7', )); 
                            echo $form->hiddenField($message, Globals::FLD_NAME_MSG_TYPE , array( 'value' => Globals::DEFAULT_VAL_MSG_TYPR_HIRING ));
                            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                            echo $form->hiddenField($message, Globals::FLD_NAME_SUBJECT , array( 'value' => Globals::DEFAULT_VAL_MSG_SUBJECT_PROPOSAL ) );
                            echo $form->hiddenField($message, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => '' , 'id' => 'popupMsgToUserId'));
                            echo $form->hiddenField($task, Globals::FLD_NAME_CREATER_USER_ID , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID}));

                            ?>
                    </div>
                    
                </div>
                <div class="col-md-12 no-mrg"> 
                    <div class="col-md-5 no-mrg">
                        <?php echo $form->error($message, Globals::FLD_NAME_BODY,array('class' => 'invalid'));  ?>      
                    </div>
    <div class="f-right mrg-auto">
              <input type="button" class="btn-u btn-u-lg rounded btn-u-red push" onclick="hireDoerClosePopup();" value="Back">
             <?php
                         echo CHtml::hiddenField(Globals::FLD_NAME_TASK_TASKER.'['.Globals::FLD_NAME_TASK_TASKER_ID.']' , '' , array('id' => 'popupTaskTaskerID'));
                            $successUpdate = '
                                    if(data.status==="success")
                                    {
                                        $.fn.yiiListView.update(\'loadAllProposals\');
                                        hireDoerClosePopup();
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