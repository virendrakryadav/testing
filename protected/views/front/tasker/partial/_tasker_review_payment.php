    <!--Project detail Start here-->
<?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task , 'model' => $model)); ?>

<!--Project detail Ends here-->

<!--Upload Receipts Start here-->
<div class="col-md-12 no-mrg" id="stepfour_payment">
<?php
if(empty($rating))
{
    $bonus = 0;
    $service_fee = CommonUtility::getServiceFee();
//    $total_payment = CommonUtility::totalPaymentAmount(array('task_id'=>$task->{Globals::FLD_NAME_TASK_ID},'task_price'=>$task->{Globals::FLD_NAME_PRICE},'service_fee'=>$service_fee,'receipt_amount'=>$receipt_amount,'bonus' => $bonus));

?>

<h4 class="panel-title text-center">Payment</h4>
<div class="col-md-6 ratting-bg3 mrg-auto overflow-h" id="payment_div">
    <div class="col-md-12 no-mrg">
        <div class="col-md-8 pdn-top-bot3">Project Price</div>
        <div class="col-md-4 pdn-top-bot3"><input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?></div>
    </div>
    <div class="col-md-12 no-mrg">
        <div class="col-md-8 pdn-top-bot3"><input type="hidden" id="service_fee" name="service_fee" value="<?php echo $service_fee;?>">Service Fee @ <?php echo $service_fee;?>%</div>
        <div class="col-md-4 pdn-top-bot3" id="serviceAmountDiv"></div>
    </div>
    <div class="col-md-12 no-mrg border-bot">
        <div class="col-md-8 pdn-top-bot3">Receipts</div>
        <input type="hidden" id="receipt_total_amount" name="receipt_total_amount" value="">
        <div class="col-md-4 pdn-top-bot3" id="displayReceiptAmount"></div>
    </div>
    <div class="col-md-12 no-mrg">
        <div class="col-md-8 pdn-top-bot3 text-22">Sub-Total</div>
        <div class="col-md-4 pdn-top-bot3 text-22" id="subTotalDiv"></div>
    </div>
    <div class="col-md-12 no-mrg border-bot">
        <div class="col-md-8 pdn-top-bot3 text-22">Bonus</div>
        <div class="col-md-4 pdn-top-bot3 text-22" id="bonusDiv"><input type="hidden" id="bonus" name="bonus" value="50">$50.00</div>
    </div>
    <div class="col-md-12 no-mrg">
        <div class="col-md-8 pdn-top-bot3 text-22">Total</div>
        <div class="col-md-4 pdn-top-bot3 text-22" id="totalPaymentDiv"></div>
    </div>
</div>


<?php
}
else
{
    echo 'You have already completed this procedure';
}
?>
</div>
<!--Ratting Ends here-->