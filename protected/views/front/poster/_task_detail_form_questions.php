
<!--<div style="overflow:hidden;" class="alert2 alert-block alert-warning fade in mrg7">
<button data-dismiss="alert" class="close" type="button">×</button>
<div class="col-lg-2 mrg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac.</div>
</div>-->

<label class="label text-size-18">Questions</label>
<div id="selectedQuestions">
 
    
    
</div>


<div class="col-md-12 mrg-top">
<div class="col-md-7 no-mrg">
    <?php  
    if($questions)
    {
        
    }
     $taskSelectedQuestion = CommonUtility::getSelectedQuestion($task->{Globals::FLD_NAME_TASK_ID});
     $question = CHtml::listData($questions, Globals::FLD_NAME_QUESTION_ID, 'categoryquestionlocale.'.Globals::FLD_NAME_QUESTION_DESC);
           
            echo CHtml::dropDownList('parentCategory',$taskSelectedQuestion, $question, 
                     array('prompt'=>'Choose a Question',
                        'onchange' => "selectQuestions(this , 'chooseQuestion' , 'selectedQuestions' )",'class' => 'form-control' ,'id'=>'chooseQuestion'));
?>
</div>
<div class="col-md-1 f-left2">Or</div>
<div class="col-md-4 f-left3"><a onclick="addNewQuestion();" href="javascript:void(0)">Create Custom Question</a></div>
</div>
<div class="col-md-12 mrg-top d-none" id="createNewQuestion" >
<div class="col-md-6 no-mrg">
    <input type="text" id="customQuestion" placeholder="Add new question" class="form-control" name="coustomQue">

</div>
    <div class="col-md-1 left-mrg">
        <button class="btn-u btn-u-sm rounded btn-u-sea" onclick="addcustomQuestion('customQuestion' ,'chooseQuestion' , 'selectedQuestions' )" type="button">Add</button>
    </div>
</div>

