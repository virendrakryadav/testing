<div id="loadProposalDiv" class=" positionRelativeClass">
    <?php echo UtilityHtml::getAjaxLoading("loadPreviewTaskLoadingImg") ?>
    <?php
    if(Yii::app()->user->id)
    {
    if ($isProposed)
        $this->renderPartial('_proposalfrom', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply,'currentUser'=>$currentUser,));
    else
        $this->renderPartial('_proposalpublished', array('task' => $task, 'taskTasker' => $taskTasker, 'model' => $model, 'taskQuestionReply' => $taskQuestionReply, 'proposals' => $proposals, 'currentUser'=>$currentUser,'bidStatus' => $bidStatus));
    }
    ?>
</div>
