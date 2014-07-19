<style>
    .btn-u {
    background: none repeat scroll 0 0 #72C02C;
    border: 0 none;
    color: #FFFFFF !important;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 400;
    padding: 6px 13px;
    position: relative;
    text-align: center;
    text-decoration: none;
}
.errorBorder 
{
    border-color: #b94a48 !important;
}
</style>

<script>
    function goStep1()
    {
        $("#taskStep1").removeClass("vstep1b");
        $("#taskStep2").removeClass("vstep1a");
        $("#taskStep3").removeClass("vstep1a");
        $("#taskStep2").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1a");
        $("#taskStep2").next().removeClass("vtext1"); 
        $("#taskStep3").next().removeClass("vtext1"); 
        $("#taskStep1").addClass("vstep1a");
        $("#taskStep1").next().addClass("vtext1"); 
        
        $("#cancel").show();
        $("#receipts").hide();
        $("#skip").hide();
        $("#rate").show();
        $("#payment").hide();
        $("#submit").hide();
        $("#stepTwo").hide();
        $("#stepOne").show();
        $("#stepThree").hide();
       
    }       
    function goStep2()
    {
        var allreceiptid = $('#allreceiptid').val();
        var i;        
        var allreceiptid = allreceiptid.split(",");        
        for(i=0;i<allreceiptid.length;i++)
        {
            if($('#viewstatus'+allreceiptid[i]).val() == 0)
            {
                jAlert("Please check all receipt");
                return false;
            }
        }
        $("#taskStep1").addClass("vstep1b");
        $("#taskStep3").removeClass("vstep1a");
        $("#taskStep2").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1b");
        $("#taskStep2").next().addClass("vtext1"); 
        $("#taskStep3").next().removeClass("vtext1"); 
        $("#taskStep2").addClass("vstep1a");
        $("#taskStep2").next().addClass("vtext1"); 
        
        $("#payment").show();
        $("#cancel").hide();
        $("#skip").show();
        $("#receipts").hide();
        $("#rate").hide();
        $("#submit").hide();
        $("#stepTwo").show();
        $("#stepOne").hide();
        $("#stepThree").hide();
       
    }
    function goStep3()
    {
        var allreceiptid = $('#allreceiptid').val();
        var i;        
        var allreceiptid = allreceiptid.split(",");        
        for(i=0;i<allreceiptid.length;i++)
        {
            if($('#viewstatus'+allreceiptid[i]).val() == 0)
            {
                jAlert("Please check all receipt");
                return false;
            }
        }
        totalReceiptsAmount();
        $("#taskStep1").addClass("vstep1b");
        $("#taskStep2").addClass("vstep1b");
        $("#taskStep2").next().addClass("vtext1"); 
        $("#taskStep3").removeClass("vstep1b");
        $("#taskStep2").removeClass("vstep1a");
        $("#taskStep3").next().addClass("vtext1");  
        $("#taskStep3").addClass("vstep1a");
        $("#taskStep3").next().addClass("vtext1"); 
        
        $("#skip").hide();
        $("#cancel").show();
        $("#payment").hide();
        $("#rate").hide();
        $("#receipts").hide();
        $("#submit").show();
        $("#stepTwo").hide();
        $("#stepOne").hide();
        $("#stepThree").show();  
    }
    
      function totalReceiptsAmount()
      {
            var project_price = $('#project_price').val();
            var totleReceiptsAmount = $('#totleReceiptsAmount').val();

            var totlePayment = Number(project_price)+Number(totleReceiptsAmount);
            $("#totalPaymentDiv").html("<?php echo Globals::DEFAULT_CURRENCY ?>"+totlePayment);        
            $("#total_payment").val(totlePayment);

            $("#displayReceiptAmount").html("<?php echo Globals::DEFAULT_CURRENCY ?>"+totleReceiptsAmount);
      }

      function cancelReview()
      {
          taskDetailUrl = $('#task_detail_url').val();
          window.location = taskDetailUrl;
      }
      
      function approveUploadedReceipt(id,amount)
      {
         var tatleAmount = $('#totleReceiptsAmount').val();
         var receiptsIds = $('#receiptsIds').val();
         tatleAmount = Number(tatleAmount) + Number(amount);
            if(receiptsIds == '')
            {
                receiptsIds+= id;
            }
            else
            {
                receiptsIds+=','+id;
            }         
         $('#totleReceiptsAmount').val(tatleAmount);
         $('#receiptsIds').val(receiptsIds);         
         $('#approve'+id).attr('disabled','disabled');
         $('#delete'+id).removeAttr('disabled','disabled');
         $("#status"+id).html("Accepted");
         $('#viewstatus'+id).val('1');
         
      }
      function deleteUploadedReceipt(id,amount)
      {
         var tatleAmount = $('#totleReceiptsAmount').val();
         var receiptsIds = $('#receiptsIds').val();
         
         if(receiptsIds.contains(id))
            {
                tatleAmount = Number(tatleAmount) - Number(amount);
                receiptsIds = receiptsIds.replace(","+id,"");
                receiptsIds = receiptsIds.replace(id+",","");
                receiptsIds = receiptsIds.replace(id,"");                
            }         
                    
         $('#totleReceiptsAmount').val(tatleAmount);
         $('#receiptsIds').val(receiptsIds);
        $('#delete'+id).attr('disabled','disabled');
        $('#approve'+id).removeAttr('disabled','disabled');
        $("#status"+id).html("Rejected");
        $('#viewstatus'+id).val('1');
      }
</script>

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'posterrating-form',
        'action'=>Yii::app()->createUrl('//poster/projectcomplationbyposter'),
        'enableAjaxValidation'=>false,
    )); 
?>
<input type="hidden" value="" id="receiptsIds" name="receiptsIds">
<input type="hidden" value="" id="totleReceiptsAmount" name="totleReceiptsAmount">
<input type="hidden" value="<?php echo $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID}; ?>" id="task_tasker_id" name="task_tasker_id">
<input type="hidden" value="<?php echo $taskTasker->{Globals::FLD_NAME_TASKER_ID}; ?>" id="tasker_id" name="tasker_id">
<div class="container content">
    <!--Left bar start here-->
    <div class="col-md-3 leftbar-fix" >
        <!--left nav start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <div class="margin-bottom-30">
            <ul class="v-step">
                <li class="margin-bottom-20" onclick="goStep1()" ><span id="taskStep1"  class="vstep1a">1</span> <span class="vtext1">Receipts</span></li>
                <li class="margin-bottom-20" onclick="goStep2()" ><span id="taskStep2"  class="vstep1">2</span> <span class="vtext">Rate</span></li>
                <li class="margin-bottom-20" onclick="goStep3()" ><span id="taskStep3"  class="vstep1">3</span> <span class="vtext">Payment</span></li>
            </ul>
        </div>
        <!--left nav Ends here-->

        <!--left Button Start here-->
        <div class="margin-bottom-30">
            <button type="button" class="btn-u btn-u-red" id="cancel" onclick="cancelReview()">Cancel</button>
            <button type="button" class="btn-u btn-u-red" id="skip" style="display:none;" onclick="goStep3()">Skip</button>
            <button type="button" class="btn-u btn-u-sea" id="receipts" style="display:none;">Receipts</button>
            <button type="button" class="btn-u btn-u-sea" id="rate" onclick="goStep2()">Rate</button>
            <button type="button" class="btn-u btn-u-sea" style="display:none;" id="payment" onclick="goStep3()">Payment</button>
            <?php 
            echo CHtml::ajaxSubmitButton('Submit',Yii::app()->createUrl('//poster/projectcomplationbyposter'),
                array(
                    'type' => 'POST',
                    'dataType' => 'html',
                    'success' => 'js:function(data){
                            $("#stepThree_payment").html(""); 
                            $("#stepThree_payment").html("You have completed this procedure"); 
                            $("#submit").css("display","none");
                            window.location="'.Yii::app()->createUrl('//index/dashboard').'";
                        }',
                ),
                array(
                    'id' =>'submit',
                    'class' =>'btn-u btn-u-sea',
                    'style' => 'display:none'
                ));
            ?>
        </div>
        <!--left Button Ends here-->
    </div>
    <!--Left bar Ends here-->
    
    <div class="col-md-9 right-cont">
        <h2 class="h2">Project Completion</h2>
        <!--Project detail Start here-->
        <div id="stepOne">
            <?php $this->renderPartial('partial/_poster_review_receipts' , array( 'task' => $task,'taskTasker'=>$taskTasker , 'model' => $model,'form' => $form)); ?>
        </div>
        <div id="stepTwo" style="display: none">
            <?php $this->renderPartial('partial/_poster_review_rate' , array( 'task' => $task ,'taskTasker'=>$taskTasker , 'model' => $model)); ?>
        </div>
        <div id="stepThree" style="display: none">
            <?php $taskDetailPageUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID}); ?>
            <input type="hidden" id="task_detail_url" name="task_detail_url" value="<?php echo $taskDetailPageUrl?>">
            <?php $this->renderPartial('partial/_poster_review_payment' , array( 'task' => $task ,'taskTasker'=>$taskTasker , 'model' => $model,'rating' => $rating,'form' => $form)); ?>
        </div>       
    </div>    
</div>
<?php $this->endWidget();?>