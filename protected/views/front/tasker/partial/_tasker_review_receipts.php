  <script>
      function deleteUploadedReceipt(id)
      {
          var receiptCount = $('#receiptCount').val();
          receiptCount = receiptCount - 1;
          $('#receiptCount').val(receiptCount);
          $('#receipt_'+id).html('');
          $('#receipt_'+id).remove();
          if(receiptCount == 0)
            {
                $('#uploadedReceipt').hide();
            }
      }
      function addExpenses()
      {
          $('#errorMsg').html('');
          var expense = document.getElementById('expense_without_receipt').value;
          var reason = document.getElementById('expense_reason').value;
          var count = document.getElementById('expenseCount').value;
          var myRegxp = /([a-zA-Z0-9_-]+)$/;
          if(expense=='' || isNaN(expense))
          {
              $('#expense_without_receipt').addClass('state-error');
              $('#alertDiv').show();
              if(expense=='')
              {
                $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Expenses amount cannot be blank.<br/>');
              }
            if(isNaN(expense))
            {
                     $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Expenses amount should be numeric.<br/>');
            }
          }
          else
          {
            $('#expense_without_receipt').removeClass('state-error');
          }
          if(reason=='' || myRegxp.test(reason)==false)
          {
              $('#expense_reason').addClass('state-error');
              $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Expenses reason cannot be blank.<br/>');
              return false;
          }
          else
          {
              $('#expense_reason').removeClass('state-error');
          }
             
          if(expense!='' && reason!='' && isNaN(expense)==false)
          {
            $('#alertDiv').hide();
            count = ++count;
            $('#expenseDiv').show();
            $('#expenseCount').val(count);
            $('#expenseTableBody').append('<tr>'+
            '<input type="hidden" id="expense_id" name="expense_id['+count+']" value="'+count+'">'+
            '<input type="hidden" id="expense_amount[]" name="expense_amount['+count+']" class="receiptAmountField" value="'+expense+'">'+
            '<input type="hidden" id="expense_label[]" name="expense_label['+count+']" value="'+reason+'">'+
            '<td>'+expense+'</td><td>'+reason+'</td>'+
            '<td align="center"><a onclick="removeExpense('+count+')"><img src="<?php echo CommonUtility::getPublicImageUri("del-ic.png") ?>" /></a></td></tr>');
            $('#expense_without_receipt').val('');
            $('#expense_reason').val('');
            $('#isValidation').val('0');
            
          }
          else
          {
              return  false;
          }
      }
      
      function removeExpense(id)
      {
          var expenseCount = $('#expenseCount').val();
          count = expenseCount-1;
          $('#expenseCount').val(count);
          document.getElementById("expenseTable").deleteRow(id);
          if(count==0)
            {
                $('#expenseDiv').hide();
            }
      }
    
        function validateReceiptsAndExpense(args)
        {
            ValidateEX = 0;
            if(args == '1')
            {
                ValidateEX = 1;
                $('#isValidation').val('1');
            }
            if($('#isValidation').val() == '1')
            {
                ValidateEX = 1;
            }
            if(ValidateEX == '1')
            {
                addExpenses();
            }
            
             var isValidation = $('#isValidation').val();
            validateReceiptAmountField(ValidateEX,isValidation);
        }
  </script>
<?php 
//CommonScript::loadExpenseErrorPopOver();
$taskTaskerReceipt = new TaskTaskerReceipt();
$ratingLocale = new RatingLocale();
$receiptFiles = $taskTaskerReceipt->getReceiptAttachmentByTaskTaskerId();?>
<!--Project detail Start here-->
<?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task , 'model' => $model)); ?>
<!--Project detail Ends here-->

<!--Upload Receipts Start here-->
<div class="col-md-12 no-mrg2">
    <div style="display: none" class="alert alert-danger fade in" id="alertDiv">
    <button onclick="$('#errorMsg').parent().fadeOut();" class="close4" type="button">×</button>
    <div id="errorMsg" >
    </div>
    </div>
    <h4 class="panel-title">Upload Receipts</h4>
    <p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis acneque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor.</p>

    <div class="col-md-9 no-mrg overflow-h sky-form">
        <div class="col-md-">
             <?php
                $success = CommonScript::loadAttachmentSuccessForDoerReview('uploadProposalAttachments','getAtachmentsPropsal','proposalAttachments','uploadedReceipt','receiptInfo');

                $allowArray = array('jpg','jpeg','png');
                $maxUploadFileSize = LoadSetting::getMaxUploadFileSize();
                $minUploadFileSize = LoadSetting::getSettingValue(Globals::SETTING_KEY_MIN_UPLOAD_FILE_SIZE);

                echo CommonUtility::getUploader('uploadProposalAttachments', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, $maxUploadFileSize, $minUploadFileSize  , $success);
                ?>
                <div id='fileUploadBtn' style="display: none" class="col-md-12  overflow-h mrg-top">
                <?php
                    echo $form->hiddenField($task,Globals::FLD_NAME_TASK_ID);
                ?>
                </div>
        </div>
    </div>
</div>   
<!--Uploaded Start here-->
<div class="col-md-12 no-mrg2"  >  
    <h4 class="panel-title">Uploaded</h4>
    <div class="col-md-12 no-mrg" id="receiptInfo">
        <input type="hidden" name="receiptCount" id="receiptCount" value="0">
        <input type="hidden" name="emptyFieldError" id="emptyFieldError" value="0">
        <input type="hidden" name="numericFieldError" id="numericFieldError" value="0">
    </div>
</div>

<!--Uploaded Ends here-->

<!--Other Expenses Start here-->
<div class="col-md-12 no-mrg2 sky-form">
    <h4 class="panel-title margin-bottom-10">Other Expenses</h4>
    <div class="col-md-12 no-mrg">
        <div class="col-md-2 no-mrg">
            <div class="input-group col-md-12 f-left">
                <span class="input-group-addon">$</span>
                <?php
                    echo $form->textField($ratingLocale,Globals::FLD_NAME_EXPENSE,array(
                        'id'=>'expense_without_receipt',
                        'class'=>'form-control required',
                        'placeholder'=>'Amount',
                        'data-container'=>'body',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'data-trigger'=>'click',
                        'data-content'=>'kdfvndskjvnjksdnvjfns' 
                    ));
                ?>
            </div>
        </div>
        <div class="col-md-8">
            <?php
                echo $form->textField($ratingLocale,Globals::FLD_NAME_EXPENSE_REASON,   array('id'=>'expense_reason','class'=>'form-control','placeholder'=>'Label'));
            ?>
        </div>
<?php
echo CHtml::button('+ Add Expense',array('id' =>'add_expense','class' =>'btn-u rounded btn-u-sea','onclick' => 'validateReceiptsAndExpense(1)'));
?>
    </div>
    <div class="col-md-12 mrg-auto2">Add an expense without a receipt.</div>
    <div class="col-md-12 mrg-auto2" id="expenseDiv" style="display:none;">
        <div class="table-responsive">
            <input type="hidden" name="expenseCount" id="expenseCount" value="0">
            <input type="hidden" name="isValidation" id="isValidation" value="0">
            <table class="table table-bordered table-striped" id="expenseTable">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Label</th>
                        <th class="align-center">Action</th>
                    </tr>
                </thead>

                <tbody id="expenseTableBody">
                </tbody>
            </table>
          
        </div>
    </div>

</div>
<!--Other Expenses Ends here-->