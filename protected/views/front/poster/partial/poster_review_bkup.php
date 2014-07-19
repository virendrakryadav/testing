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
    $receipt_amount = 0;
    $total_payment = CommonUtility::totalPaymentAmount(array('task_id'=>$task->{Globals::FLD_NAME_TASK_ID},'task_price'=>$task->{Globals::FLD_NAME_PRICE},'service_fee'=>$service_fee,'receipt_amount'=>$receipt_amount,'bonus' => $bonus));

?>

<h4 class="panel-title">Confirm Final Payment Release</h4>
<div class="col-md ratting-bg3 mrg-auto overflow-h" id="payment_div">
    
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Project Total</div>
            <div class="col-md-3 pdn-top-bot3 text-22" id="totalPaymentDiv"><input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?></div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3">Project</div>
            <div class="col-md-3 pdn-top-bot3"><input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?></div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3">Approved Receipts</div>
            <input type="hidden" id="receipt_total_amount" name="receipt_total_amount" value="">
            <div class="col-md-3 pdn-top-bot3" id="displayReceiptAmount"></div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Sub-Total</div>
            <div class="col-md-3 pdn-top-bot3 text-22" id="subTotalDiv"><input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?>
            </div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Bonus</div>
            <div class="col-md-3 pdn-top-bot3" id="bonusDiv">
                <input type="hidden" id="bonus" name="bonus" value="">
                <input type="text" id="bonus" name="bonus" value="" size="5">
            </div>
            <div class="col-md-3 pdn-top-bot3" id="bonusDiv">
<!--                <input type="button" id="bonus" name="bonus" value="Add">-->
                <button type="button" id="bonus" name="bonus" value="50">Add</button>
            </div>
        </div>
        
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Escrow Release</div>
            <div class="col-md-4 pdn-top-bot3 text-22" id="totalPaymentDiv"><input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>"><?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?></div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3">Total Due</div>
            <div class="col-md-4 pdn-top-bot3" id="bonusDiv"><input type="hidden" id="bonus" name="bonus" value="">$20</div>
        </div>
    
</div>


<?php
}
else
{
    echo 'You have already completed this procedure';
}
?>

    <div class="col-md-12 no-mrg text-right">
        <div class="col-md-8 pdn-top-bot3 text-22">Pay with</div>
        <?php  UtilityHtml::getPayWithDropDown( "payWith" , (isset($_GET["payWith"])) ? $_GET["payWith"] : ''   ); ?>
    </div>
    <div class="col-md-12 no-mrg text-right">
        <a href="#">Add New Payment Type <a>
    </div>
</div>