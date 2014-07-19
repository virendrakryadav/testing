<div id="loadProposalDiv" class="positionRelativeClass">
    <?php echo UtilityHtml::getAjaxLoading("loadPreviewTaskLoadingImg") ?>
    <?php
    $taskList = empty($taskList) ? false : $taskList;
    if(Yii::app()->user->id)
    {
    //if ($isProposed)
        $this->renderPartial('_proposalfrom', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply,'currentUser'=>$currentUser, 'isInvited' => $isInvited, 'taskList' => $taskList ));
//    else
//        $this->renderPartial('_proposalpublished', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'proposals' => $proposals, 'currentUser'=>$currentUser,'bidStatus' => $bidStatus));
    }
    ?>
</div>
