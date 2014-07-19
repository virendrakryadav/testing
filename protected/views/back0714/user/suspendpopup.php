<style>
    .window 
    {
        background: none repeat scroll 0 0 #FFFFFF;
        box-shadow: 0 0 15px #000000;
        min-height: 160px !important;
        position: fixed;
        top: 20%;
        z-index: 10000;
        left: 400px;
        width: 500px;
    }
    .errorMessage {
    color: #FF0000 !important;
    font-size: 12px;
    padding: 0;
}
.error input{
    background: none repeat scroll 0 0 #FFEEEE;
    border-color: #CC0000;
}
.required span{
    color: #E02222;
    font-size: 12px;
    padding-left: 2px;
}
</style>
<div style="padding: 10px 18px 0 26px">            
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'suspend-form',
     'enableClientValidation' => true,
        'clientOptions' => array(
                'validateOnSubmit' => true,
                ),
)); 
?>
    <div style="margin-bottom: 10px;">
        <span style=" font-size: 16px;font-weight: bold;"><?php echo CommonUtility::getUserNameOnUrl($of_user_id); ?> Suspend</span>
        <span style="float: right;font-size: 16px;font-weight: bold;cursor: pointer" onclick="$('#window').html('');">X</span></div>
    <div class="control-group">
            <?php echo $form->labelEx($suspenduser,'comments',array('class'=>'span3','label'=>'Comment')); ?>
            <div class="controls">
                    <?php echo $form->textField($suspenduser,'comments',array('class'=>'span8','size'=>60,'maxlength'=>100,)); ?>                                    
                    <span class="help-inline"><?php echo $form->error($suspenduser,'comments'); ?></span>                    
            </div>
        <?php echo $form->hiddenField($suspenduser, 'by_user_id',array('value'=>$by_user_id)); ?>
        <?php echo $form->hiddenField($suspenduser, 'of_user_id',array('value'=>$of_user_id)); ?>
     </div>  
    <div class="span5" style="float: right">
    <?php echo CHtml::ajaxSubmitButton('Submit',Yii::app()->createUrl('user/suspendpopup'),array(
			   'type'=>'POST',
			   'dataType'=>'json',
			   'success'=>'js:function(data){			   	
                                if(data.errorCode == "success")
                                {
                                    $("#window").html("");
                                    $("#updateuserbutton").removeAttr("disabled");                                    
                                }				   
                                else{
                                $.each(data, function(key, val) {
						$("#suspend-form #"+key+"_em_").text(val);
						$("#suspend-form #"+key+"_em_").show();
						});
                                }
			   }',
			),array('class'=>'btn blue','id'=>'suspendsubmit'));
	?>
    </div>
    <?php $this->endWidget(); ?>
</div>