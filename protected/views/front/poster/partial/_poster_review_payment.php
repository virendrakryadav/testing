<style>
    .col-md-3 {
    width: auto;
}
</style>
<script>
    function addBonus()
    {
        $('#errorMsg').html('');        
        var bonus = $('#bonus').val();
        var myRegxp = /([a-zA-Z0-9_-]+)$/;
        if(bonus=='' || isNaN(bonus))
        {           
            $('#bonus').addClass('state-error');
            $('#alertDiv').show();
            if(bonus=='')
            {
            $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Bonus amount cannot be blank.<br/>');
            }
            if(isNaN(bonus))
            {
                        $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Bonus amount should be numeric.<br/>');
            }
        }
        else 
        {
            var totlePayment = $("#total_payment").val();
            var bonus = $("#bonus").val();
            
            totlePayment = Number(totlePayment)+Number(bonus);
             $("#total_payment").val(totlePayment);             
             $("#totalPaymentDiv").html("<?php echo Globals::DEFAULT_CURRENCY ?>"+totlePayment);
             $("#bonusDiv").html("<?php echo Globals::DEFAULT_CURRENCY ?>"+bonus);
             $("#bonusval").val(bonus);             
        }
    }
</script>

<!--Project detail Start here-->
<?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task , 'model' => $model)); ?>
<!--Project detail Ends here-->

<!--Upload Receipts Start here-->
<div class="col-md-12 no-mrg" id="stepfour_payment">
    <div style="display: none" class="alert alert-danger fade in" id="alertDiv">
    <button onclick="$('#errorMsg').parent().fadeOut();" class="close4" type="button"><i class="fa fa-times"></i></button>
    <div id="errorMsg" >
    </div>
    </div>
<?php
if(empty($rating))
{
    $totaldue = 0;
    $bonus = 0;
    $service_fee = 0;
    $receipt_amount = 0;
    $total_payment = CommonUtility::totalPaymentAmount(array('task_id'=>$task->{Globals::FLD_NAME_TASK_ID},'task_price'=>$task->{Globals::FLD_NAME_PRICE},'service_fee'=>$service_fee,'receipt_amount'=>$receipt_amount,'bonus' => $bonus));
?>

<h4 class="panel-title">Confirm Final Payment Release</h4>
<div class="col-md ratting-bg3 mrg-auto overflow-h" id="payment_div">
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Project Total</div>
            <input type="hidden" id="total_payment"  name="total_payment" value="">
            <div class="col-md-3 pdn-top-bot3 text-22" id="totalPaymentDiv"></div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3">Project</div>
            <div class="col-md-3 pdn-top-bot3">
                <input type="hidden" id="project_price" name="project_price" value="<?php echo $task->{Globals::FLD_NAME_PRICE}?>">
                    <?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?>
            </div>
        </div>
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3">Approved Receipts</div>
            <div class="col-md-3 pdn-top-bot3" id="displayReceiptAmount"></div>
        </div>
        <div class="col-md-12 no-mrg">
            <div class="col-md-4 pdn-top-bot3 text-22">Bonus</div>
            <div class="col-md-4 pdn-top-bot3 text-22" id="bonusDiv">
                <div class="input-group col-md-5">
                    <span class="input-group-addon"><?php echo Globals::DEFAULT_CURRENCY ?></span>
                    <input class="form-control text-align-right" type="text" id="bonus" name="bonus" size="5" value="" placeholder="0">
                </div>
                <div class="col-md-4 pdn-top-bot3">
                    <?php echo CHtml::button('Add ',array('id' =>'add_bonus','class' =>'btn-u rounded btn-u-sea','onclick' => 'addBonus()'));?>
                </div>
            </div>
            <input type="hidden" id="bonusval" name="bonusval" value="">
        </div>
                
        <div class="col-md-8 no-mrg">
            <div class="col-md-6 pdn-top-bot3 text-22">Escrow Release</div>
            <div class="col-md-4 pdn-top-bot3 text-22" id="escrowReleaseDiv">
                    <?php echo UtilityHtml::displayPrice($task->{Globals::FLD_NAME_PRICE})?>
            </div>
        </div>
        <div class="col-md-8 no-mrg" id="totalDueDiv">
            <div class="col-md-6 pdn-top-bot3">Total Due</div>
            <div class="col-md-4 pdn-top-bot3" id="dueDiv">
<!--               <input type="hidden" id="bonus" name="bonus" value=""></div>-->
                <?php echo Globals::DEFAULT_CURRENCY ?><?php echo $totaldue; ?>
                
            </div>
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