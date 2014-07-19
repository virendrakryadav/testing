<?php
$instuctionMsg = Inbox::getHiringMsgFromPoster($task->{Globals::FLD_NAME_TASK_ID} ,$task->{Globals::FLD_NAME_CREATER_USER_ID} , $taskTasker->{Globals::FLD_NAME_TASKER_ID} );
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

<div class="container content">
    <!--Left bar start here-->
    <div class="col-md-3 leftbar-fix" >
        <!--left nav start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--        <div class="margin-bottom-30">
            <ul class="v-step">
                <li class="margin-bottom-20" onclick="goStep1()" ><span id="taskStep1"  class="vstep1a">1</span> <span class="vtext1">Receipts</span></li>
                <li class="margin-bottom-20" onclick="goStep2()" ><span id="taskStep2"  class="vstep1">2</span> <span class="vtext">Rate</span></li>
                <li class="margin-bottom-20" onclick="goStep3()" ><span id="taskStep3"  class="vstep1">3</span> <span class="vtext">Payment</span></li>
            </ul>
        </div>-->
                    <div class="margin-bottom-30">
             
           
              <?php
                         echo CHtml::hiddenField(Globals::FLD_NAME_TASK_TASKER.'['.Globals::FLD_NAME_TASK_TASKER_ID.']' , '' , array('id' => 'popupTaskTaskerID'));
                            $successUpdatedecline = '
                                    if(data.status==="success")
                                    {
                                         window.location = "'.CommonUtility::getUserDeshboadUrl().'";
                                    }
                                    else
                                    {
                                        var msg = "";
                                        $.each(data, function(key, val)
                                        {
                                        
                                        
                                            $("#"+key+"_em_").text(val);
//                                            $("#"+key).addClass("state-error");
//                                            $("#"+key).parent().addClass("state-error");
                                            $("#"+key+"_em_").show();
                                        });
                                    }
                                    ';
                
                                    CommonUtility::getAjaxSubmitButton(
                                            'Decline',
                                            Yii::app()->createUrl('poster/rejecthiringoffer'), 
                                            'btn-u btn-u-lg rounded btn-u-red push', 
                                            'rejectoffer', 
                                            $successUpdatedecline);
            ?>
             <?php
                        
                            $successUpdate = '
                                    if(data.status==="success")
                                    {
                                          window.location = "'.CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}).'";
                                    }
                                    else
                                    {
                                        var msg = "";
                                        $.each(data, function(key, val)
                                        {
                                        
                                        
                                            $("#"+key+"_em_").text(val);
//                                            $("#"+key).addClass("state-error");
//                                            $("#"+key).parent().addClass("state-error");
                                            $("#"+key+"_em_").show();
                                        });
                                    }
                                    ';
                
                                    CommonUtility::getAjaxSubmitButton(
                                              'Accpet',
                                                Yii::app()->createUrl('poster/accepthiringoffer'), 'btn-u btn-u-lg rounded btn-u-sea push', 'useraddTask', $successUpdate);
                                                ?>
    
                    </div>
        <!--left nav Ends here-->

        <!--left Button Start here-->
       
        <!--left Button Ends here-->
    </div>
    <!--Left bar Ends here-->

    <!--Right part start here-->
    <div class="col-md-9 right-cont">
        
         <div class="col-md-11 mrg-auto overflow-h">
             <h1 class="align-center ">CONGRATULATIONS!</h1>
</div>
        
<div class="col-md-11 mrg-auto overflow-h">
           <p class="project-text">You have been chosen by <span class="text-18 color-green1"><?php echo CommonUtility::getUserFullName($task->{Globals::FLD_NAME_CREATER_USER_ID}) ?></span> to compleat the project they posted. Please confirm that
           you would like to accept this project and agree to the terms you bid</p>
</div>
        <div class="proposal_row1 mrg11">
                   
                    <div class="confirm-col1 "> Project Details: <span class="color-blue"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></span></div>
                    <div class="confirm-col1 "> Project Type: <span class="color-green1"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?></span></div>
                    <div class="confirm-col1 "> Rate: <BID RATE></div>
                    <div class="confirm-col1 "> Expenses Required: <span class="color-green1"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_TASK_CASH_REQUIRED}) ?></span></div>
                    <div class="confirm-col1 "> Project Start Date: <span class="color-light-grey"><?php  echo  CommonUtility::projectStartDate($task->{Globals::FLD_NAME_TASK_ID}) ?></span></div>
                    <div class="confirm-col1 "> Project Completion Date:  
                   <span class="color-light-grey"> <?php 
                        if ($task->{Globals::FLD_NAME_TASK_KIND} == Globals::DEFAULT_VAL_TASK_KIND_INPERSON) 
                        {
                            echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_END_DATE});
                        } 
                        else 
                        {
                            echo  CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                        }
                    ?> </span>
                    </div>
                    
                </div>
        <div class="col-md-12 no-mrg3">
            <div class="col-md-9 no-mrg">
        <label for="exampleInputEmail1" class="label text-size-14">
         Do you agree to compleat the project within these terms? <?php  echo   $form->checkBox($message, Globals::FLD_NAME_AGREE_FOR_TERMS, array('class' => 'check-mrg' ,'value'=>1, 'uncheckValue'=>'')); ?> 
        </label>
        <?php echo $form->error($message, Globals::FLD_NAME_AGREE_FOR_TERMS,array('class' => 'invalid')); ?>
            </div>
            <div class="col-md-3 no-mrg right-align">
                <a href="#">Modify terms</a>
            </div>
        </div> 
        <div class="col-md-12 no-mrg">
                    
                    <p class="confirm-h4 color-orange">Instructions about this project sent to you by the Poster;</p>
                   
                    <div class="col-md-12 no-mrg">
                    <div class="triangle-border top">
                        <?php
                        echo $instuctionMsg;
                        ?>
                        </div>
                    </div>
                </div>
        <div class="col-md-12 mrg12">
                    <p>Please take a moment to reply to the poster about these instructions: </p>
                    <div class="col-md-12 no-mrg">
                        <?php 
                            echo $form->textArea($message, Globals::FLD_NAME_BODY, array('class' => 'form-control', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => '7', )); 
                            echo $form->hiddenField($message, Globals::FLD_NAME_MSG_TYPE , array( 'value' => Globals::DEFAULT_VAL_MSG_TYPR_CONFIRM_HIRING ));
                            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                            echo $form->hiddenField($message, Globals::FLD_NAME_SUBJECT , array( 'value' => Globals::DEFAULT_VAL_MSG_SUBJECT_PROPOSAL ) );
                            echo $form->hiddenField($message, Globals::FLD_NAME_TO_USER_IDS , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID} , 'id' => 'popupMsgToUserId'));
                            echo $form->hiddenField($task, Globals::FLD_NAME_CREATER_USER_ID , array( 'value' => $task->{Globals::FLD_NAME_CREATER_USER_ID}));
                            echo $form->hiddenField($taskTasker, Globals::FLD_NAME_TASK_TASKER_ID , array( 'value' => $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID}));
                        ?>
                    </div>
                    <div class="col-md-12 no-mrg"> 
                    <div class="col-md-5 no-mrg">
                        <?php echo $form->error($message, Globals::FLD_NAME_BODY,array('class' => 'invalid'));  ?>      
                    </div>
                    </div>
                    
                </div>
<!--Project detail message Ends here-->

<!--Button Start here-->

        <!--Project detail ends here-->
    </div>
    <!--Right part ends here-->
</div>
<?php $this->endWidget();?>