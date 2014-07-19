<?php
    $questions = TaskQuestion::getTaskQuestion($task_id);
    $i = 1;
    if($questions)
    {
    ?>

    <?php
            $answers =  CommonUtility::getQuestionAnswerByTasker($task_id, $tasker_id );
            if($answers)
            {
                foreach ($questions as $question)
                {
                ?>
                    <div class="task_descrip" >
                        <h5><?php echo $i . '. ' . $question->categoryquestionlocale->question_desc; ?></h5>
                        <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?>  <?php echo $answers[$question->question_id]; ?>
                    </div>
                    <?php
                    $i++;
                }
            }
    }
    else
    {
        echo 'No Questions';
    }
?>