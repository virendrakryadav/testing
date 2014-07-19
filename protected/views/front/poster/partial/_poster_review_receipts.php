<?php 
$task_id = $task->{Globals::FLD_NAME_TASK_ID};
$taskTaskerIdArray[] = $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID};

$taskTaskerReceipt = new TaskTaskerReceipt();
$ratingLocale = new RatingLocale();
?>
    <!--Project detail Start here-->
    <?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task ,'model' => $model)); ?>
    <!--Project detail Ends here-->

    <div class="col-md-12 no-mrg2">
        <h4 class="panel-title">Confirm Receipts</h4>
    </div>
<?php 
if($taskTasker != NULL)
{
    echo "The Doer has marked this job complete. Here are his receipt for approval.";
}
else
{
    echo "No receipt found.";
}
?>
    <?php
    if($taskTasker)
    {
        $getReceiptArray = CommonUtility::createArrayForTaskReceipt($taskTaskerReceipt->checkTaskTaskerId($taskTaskerIdArray));
        ?><input type="hidden" id="allreceiptid" value="<?php echo $getReceiptArray; ?>"><?php
        $this->widget('ListViewWithLoader', array(
                    'id' => 'loadreceipts',
                    'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.Yii::t('tasklist','No receipt found').'.</div></div>',
                    'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $taskTaskerReceipt->checkTaskTaskerId($taskTaskerIdArray),
                    'itemView' => '//poster/partial/_poster_review_approve_receipts',
                    'enableHistory' => true,
                    'template'=>'<div class="found-count">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    //'summaryText' => Yii::t('tasklist','Found {start} - {end} of {count} tasks'),
                    'summaryText' => '',
                    'afterAjaxUpdate' => "function(id, data) 
                        { }",
                    )
                );
    }
    ?>