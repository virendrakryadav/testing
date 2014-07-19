  <script>
      function deleteUploadedReceipt()
      {
          var receipt_id = document.getElementById('receipt_id').value;
          $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('poster/deleteUploadedReceiptFile');?>',
            dataType: 'json',
            data: {receipt_id:receipt_id},
            success: function (data) {
                    $.fn.yiiListView.update("receipt_list_tasker_live");
            }
        })
      }
  </script>

        <div class="alert-uoload alert-block alert-warning fade in">
            <button class="close3" type="button" onclick="deleteUploadedReceipt()"><img src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png") ?>"></button>
            <input type="hidden" id="receipt_id" name="receipt_id" value="<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}?>">
            <div class="col-lg-2 uploaded-receipts"><img src="<?php echo CommonUtility::getPublicImageUri($data->{Globals::FLD_NAME_TASKER_RECEIPT_ATTACHMENT}) ?>"></div>
            <div class="col-lg-12 sky-form margin-bottom-5"><div class="input-group col-md-12 f-left">
                    <span class="input-group-addon">$</span>
                    <?php
                    echo CHtml::textField(Globals::FLD_NAME_RECEIPT_AMOUNT."[".$data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}."]",'',array('id'=>'receipt_amount','class'=>'form-control','placeholder'=>'Amount'));
                    ?>
<!--                    <input type="text" class="form-control" placeholder="Amount" id="receipt_amount" value="">-->
                </div></div>
        </div>

