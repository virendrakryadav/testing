
<!--<div style="overflow:hidden;" class="alert2 alert-block alert-warning fade in mrg7">
<button data-dismiss="alert" class="close" type="button">×</button>
<div class="col-lg-2 mrg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac.</div>
</div>-->

<label class="label text-size-18">Questions</label>

<div class="col-md-12 no-mrg overflow-h" id="selectedQuestions">
<?php if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{
    $selectedQuestions = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
    if($selectedQuestions)
    {
        foreach ($selectedQuestions as $question) 
        {
            ?>
                    <div class="alert3 alert-block alert-warning fade in q-mrg" style="overflow:hidden;">
                        <button type="button" class="close" data-dismiss="alert" onclick="resetQuetionsDropdown( 'chooseQuestion' ,'<?php echo  $question->{Globals::FLD_NAME_QUESTION_ID} ?>')">×</button>
                        <div class="col-lg-2 mrg"><?php echo $question->{Globals::FLD_NAME_TASK_QUESTION_DESC} ?>
                            <input type="hidden" value="<?php echo $question->{Globals::FLD_NAME_QUESTION_ID} ?>--<?php echo $question->{Globals::FLD_NAME_TASK_QUESTION_DESC} ?>" name="multicatquestion[]">
                        </div>
                        <script>
                                $( document ).ready(function() 
                                { 
                                    $("#chooseQuestion option[value='<?php echo  $question->{Globals::FLD_NAME_QUESTION_ID} ?>']").prop('disabled', false);
                                    $("#chooseQuestion option[value='<?php echo  $question->{Globals::FLD_NAME_QUESTION_ID} ?>']").hide();
                                   
                                });
                        </script>
                    </div>
    
            <?php
        }
    }
    
} ?>
 
    
    
</div>


<div class="col-md-12 no-mrg">
    <?php
    if($questions)
    {
        ?>
        <div class="col-md-7 no-mrg">
        <?php  
        //$taskSelectedQuestion = CommonUtility::getSelectedQuestion($task->{Globals::FLD_NAME_TASK_ID});
        $question = CHtml::listData($questions, Globals::FLD_NAME_QUESTION_ID, 'categoryquestionlocale.'.Globals::FLD_NAME_QUESTION_DESC);
            echo CHtml::dropDownList('parentCategory','', $question, 
                     array('prompt'=>'Choose a Question',
                        'onchange' => "selectQuestions(this , 'chooseQuestion' , 'selectedQuestions' )",'class' => 'form-control' ,'id'=>'chooseQuestion'));
        ?>
</div>
<div class="col-md-1 f-left2">Or</div>
<?php
    }
    ?>

<div class="col-md-4 f-left3"><a onclick="addNewQuestion();" href="javascript:void(0)">Create Custom Question</a></div>
</div>
<div class="col-md-12 mrg-top d-none" id="createNewQuestion" >
<div class="col-md-4 no-mrg">
    <input type="text" id="customQuestion" placeholder="Add new question" class="form-control" name="coustomQue">

</div>
    <div class="col-md-3 left-mrg">
        <button class="btn-u rounded btn-u-sea" onclick="addcustomQuestion('customQuestion' ,'chooseQuestion' , 'selectedQuestions' )" type="button">Add</button>
        <button class="btn-u rounded btn-u-red" onclick="hideCustomQuestion('customQuestion')" type="button">Close</button>

    </div>
</div>

