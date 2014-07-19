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
        $("#taskStep4").removeClass("vstep1a");
        $("#taskStep2").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1b");
        $("#taskStep4").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1a");
        $("#taskStep2").next().removeClass("vtext1"); 
        $("#taskStep3").next().removeClass("vtext1"); 
        $("#taskStep4").next().removeClass("vtext1");
        $("#taskStep1").addClass("vstep1a");
        $("#taskStep1").next().addClass("vtext1"); 
        
        $("#receipts").show();
        $("#cancel").show();
        $("#skip").hide();
        $("#rate").hide();
        $("#payment").hide();
        $("#submit").hide();
        $("#stepTwo").hide();
        $("#stepOne").show();
        $("#stepThree").hide();
        $("#stepFour").hide();
       
    }
    function goStep2()
    {
        $("#taskStep1").addClass("vstep1b");
        $("#taskStep3").removeClass("vstep1a");
        $("#taskStep4").removeClass("vstep1a");
        $("#taskStep2").removeClass("vstep1b");
        $("#taskStep3").removeClass("vstep1b");
        $("#taskStep4").removeClass("vstep1b");
        $("#taskStep2").next().addClass("vtext1");
        $("#taskStep3").next().removeClass("vtext1"); 
        $("#taskStep4").next().removeClass("vtext1"); 
        $("#taskStep2").addClass("vstep1a");
        $("#taskStep2").next().addClass("vtext1"); 
        
        $("#rate").show();
        $("#cancel").show();
        $("#skip").hide();
        $("#receipts").hide();
        $("#payment").hide();
        $("#submit").hide();
        $("#stepTwo").show();
        $("#stepOne").hide();
        $("#stepThree").hide();
        $("#stepFour").hide();
       
    }
    function goStep3()
    {
//        $('#errorMsg').html('');
//        isError =validateReceiptAmountField(0,0);
////        alert(isError);
//        if(isError == 0)
//        {
            $("#taskStep1").addClass("vstep1b");
            $("#taskStep2").addClass("vstep1b");
            $("#taskStep2").next().addClass("vtext1"); 
            $("#taskStep3").removeClass("vstep1b");
            $("#taskStep2").removeClass("vstep1a");
            $("#taskStep4").removeClass("vstep1a");
            $("#taskStep3").next().addClass("vtext1"); 
            $("#taskStep4").next().removeClass("vtext1"); 
            $("#taskStep3").addClass("vstep1a");
            $("#taskStep3").next().addClass("vtext1"); 

            $("#skip").show();
            $("#cancel").hide();
            $("#payment").show();
            $("#rate").hide();
            $("#receipts").hide();
            $("#submit").hide();
            $("#stepTwo").hide();
            $("#stepOne").hide();
            $("#stepThree").show();
            $("#stepFour").hide();
//        }
       
    }
    function goStep4()
    {
        totalReceiptsAmount();
      
        $("#taskStep1").addClass("vstep1b");
        $("#taskStep2").addClass("vstep1b");
        $("#taskStep3").addClass("vstep1b");
        $("#taskStep2").next().addClass("vtext1"); 
        $("#taskStep3").next().addClass("vtext1"); 
        $("#taskStep4").removeClass("vstep1b");
        $("#taskStep4").next().addClass("vtext1");
        $("#taskStep4").addClass("vstep1a");
        $("#taskStep4").next().addClass("vtext1");  

        $("#cancel").show();
        $("#submit").show();
        $("#skip").hide();
        $("#rate").hide();
        $("#receipts").hide();
        $("#payment").hide();
        $("#stepTwo").hide();
        $("#stepOne").hide();
        $("#stepThree").hide();
        $("#stepFour").show();

        var project_price = $('#project_price').val();
        var service_fee = $('#service_fee').val();
        var receipt_amount = $('#receipt_total_amount').val();
        var bonus = $('#bonus').val();
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('tasker/paymentfordoer');?>',
            type: "POST",
            dataType: 'json',
            data: {project_price:project_price,service_fee: service_fee,receipt_amount:receipt_amount,bonus:bonus},
            success: function (data) {
                $('#serviceAmountDiv').html('$'+data.totalPaymentAmount.service_amount);
                $('#subTotalDiv').html('$'+data.totalPaymentAmount.sub_total);
                $('#totalPaymentDiv').html('$'+data.totalPaymentAmount.total_paymant_amount);
            }
            });
    }
    
      function totalReceiptsAmount()
      {
          receiptAmount = 0;
          $('#receipt_total_amount').val(0);
          $('.receiptAmountField').each(function(id) {
            receiptAmount = Number($(this).val());
            var totalValue = Number($('#receipt_total_amount').val());
            var total_amount = receiptAmount+totalValue;
            $('#receipt_total_amount').val(total_amount);
          });
          var displayReceiptAmount = $('#receipt_total_amount').val();
          $('#displayReceiptAmount').html('$'+displayReceiptAmount);
//          <%Session["receipt_amount"] = "This is my session";%>
          document.cookie = "receipt_amount = "+displayReceiptAmount;
      }

      function cancelReview()
      {
          taskDetailUrl = $('#task_detail_url').val();
          window.location = taskDetailUrl;
      }
      
      function validateReceiptAmountField(ValidateEX,isValidation)
      {
          var isError = 0;
          $('.receiptAmountField').each(function(id) {
           var receiptAmount = $(this).val()
            if(isNaN(receiptAmount) || receiptAmount == '')
            {
                $('#alertDiv').show();
                $(this).addClass("errorBorder");
                $(this).parent().parent().parent().addClass("errorBorder");
                if(receiptAmount == '')
                {
                    $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Receipt amount cannot be blank.<br/>');
//                        $('#emptyFieldError').val(1);
                }
                if(isNaN(receiptAmount))
                {
                    $('#errorMsg').append('<i class="fa fa-hand-o-right"></i> Receipt amount should be numeric.<br/>');
//                        $('#numericFieldError').val(1);
                }
                isError = 1;
            }
            else
            {
           
                if(isError == 0)
                {
                    $(this).removeClass("errorBorder");
                    $(this).parent().parent().parent().removeClass("errorBorder");
                    if(ValidateEX=='0'&& isValidation=='0')
                    {
                        $('#alertDiv').hide();
                    }
                }
            }
            return isError;
          });
      }
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'posterrating-form',
'action'=>Yii::app()->createUrl('//tasker/saveposterrating'),

'enableAjaxValidation'=>false,
)); 

?>
<!--Dashbosrd start here-->
<!--<form id="review_form" name="review_form" action="<?php // echo Yii::app()->createUrl('poster/saveposterrating');?>" method ="post">-->
<div class="container content">
    

<!--Left bar start here-->
<div class="col-md-3 leftbar-fix" >
<!--Dashbosrd start here-->
<!--<div class="margin-bottom-30">
<div class="grad-box">
<div class="col-md-12"><h2 class="heading-md color-orange">erandoo</h2></div>
<div class="col-md-12">
 
    <?php
//    echo $_COOKIE['receipt_amount'];
    $userid  = Yii::app()->user->id;
	
if (isset($userid) && $userid >0)
{
            $loggedInUser = CommonUtility::getLoginUserName($userid);
            $loggedInUser = "<span class='sessionname'>".$loggedInUser."</span>";
            // $img = CommonUtility::getprofilePicMediaURI($userid);
             $img = CommonUtility::getThumbnailMediaURI($userid,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50);
            
          // exit;
            $this->widget('bootstrap.widgets.TbNav', 
                
                array(
        
                'id'=>'gcHeader',
                'htmlOptions'=>array('class'=>'nav-menu-hoheader'),
                'encodeLabel'=>false,
	        'items'=>array(
			 
                    array('label'=>CHtml::image($img,Yii::t('layout_main','txt_alt_user_image') , array(
                    'style' => 'width:39px;height: 39px','id'=>'profileImageIconOnHeader')),	
                        'htmlOptions'=>array('class'=>'das-col'),
                    'items'=>array(
                    array('icon' => 'icon-th-large', 'label'=>Yii::t('layout_main','lbl_dashboard'), 'url'=>Yii::app()->createUrl('index/dashboard')),                        
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_dropdown_my_profile'), 'url'=>Yii::app()->createUrl('index/updateprofile')),
                    array('icon' => 'icon-lock', 'label'=>Yii::t('layout_main','lbl_dropdown_change_password'), 'url'=>Yii::app()->createUrl('index/changepassword')),
                    '---',
                    array('icon' => 'icon-key', 'label'=>Yii::t('layout_main','lbl_dropdown_logout'), 'url'=>Yii::app()->createUrl('index/logout')),
                        )
                    ),
                    array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic2.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
                    'id'=>'notificationImageIconOnHeader')),
                        'url'=>Yii::app()->createUrl('notification/index'), 'htmlOptions'=>array('class'=>'das-col')),
				array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic3.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
                                'id'=>'notificationImageIconOnHeader')),'url'=>Yii::app()->createUrl('inbox/index'), 'htmlOptions'=>array('class'=>'das-col'))
		)
        ));
}
?>
 <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
    <!--left nav start here-->
        <div class="margin-bottom-30">
            <ul class="v-step">
                <li class="margin-bottom-20" onclick="goStep1()" ><span id="taskStep1"  class="vstep1a">1</span> <span class="vtext1">Mark Complete</span></li>
                <li class="margin-bottom-20" onclick="goStep2()" ><span id="taskStep2"  class="vstep1">2</span> <span class="vtext">Receipts</span></li>
                <li class="margin-bottom-20" onclick="goStep3()" ><span id="taskStep3"  class="vstep1">3</span> <span class="vtext">Rate</span></li>
                <li class="margin-bottom-20" onclick="goStep4()" ><span id="taskStep4"  class="vstep1">4</span> <span class="vtext">Payment</span></li>
            </ul>
        </div>
    <!--left nav Ends here-->

<!--left Button Start here-->

<div class="margin-bottom-30">
<button type="button" class="btn-u btn-u-red" id="cancel" onclick="cancelReview()">Cancel</button>

<button type="button" class="btn-u btn-u-red" id="skip" style="display:none;" onclick="goStep4()">Skip</button>
<button type="button" class="btn-u btn-u-sea" id="receipts"  onclick="goStep2()">Receipts</button>
<button type="button" class="btn-u btn-u-sea" style="display:none;" id="rate"  onclick="goStep3()">Rate</button>
<button type="button" class="btn-u btn-u-sea" style="display:none;" id="payment"  onclick="goStep4()">Payment</button>
<?php 

if(empty($rating) && $task->{Globals::FLD_NAME_CREATER_USER_ID} != Yii::app()->user->id)
{
echo CHtml::ajaxSubmitButton('Submit',Yii::app()->createUrl('//tasker/saveposterrating'),
        array(
            'type' => 'POST',
            'dataType' => 'html',
            'success' => 'js:function(data){
                    $("#stepfour_payment").html(""); 
                    $("#stepfour_payment").html("You have completed this procedure"); 
                    $("#submit").css("display","none");
                    //window.location="'.Yii::app()->createUrl('//index/dashboard').'";
                }',
        ),
        array(
            'id' =>'submit',
            'class' =>'btn-u btn-u-sea',
            'style' => 'display:none'
        ));
}
?>
</div>
<!--left Button Ends here-->
</div>
<!--Left bar Ends here-->

    <!--Right part start here-->
    <div class="col-md-9 right-cont">
        <h2 class="h2">Project Completion</h2>
        <!--Project detail Start here-->
        <div id="stepOne">
            <?php $this->renderPartial('partial/_tasker_review_mark_complete' , array( 'task' => $task , 'model' => $model)); ?>
        </div>
        <div id="stepTwo" style="display: none">
            <?php $this->renderPartial('partial/_tasker_review_receipts' , array( 'task' => $task , 'model' => $model,'form' => $form)); ?>
        </div>
        <div id="stepThree" style="display: none">
            <?php $this->renderPartial('partial/_tasker_review_rate' , array( 'task' => $task , 'model' => $model)); ?>
        </div>
        <div id="stepFour" style="display: none">
            <?php
            $taskDetailPageUrl = CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID});
            ?>
            <input type="hidden" id="task_detail_url" name="task_detail_url" value="<?php echo $taskDetailPageUrl?>">
        <?php $this->renderPartial('partial/_tasker_review_payment' , array( 'task' => $task , 'model' => $model,'rating' => $rating)); ?>
        </div>
    </div>
    <!--Right part ends here-->
</div>
<?php $this->endWidget();?>
