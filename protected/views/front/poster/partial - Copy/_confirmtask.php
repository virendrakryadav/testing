	<?php 
        
	/** @var BootActiveForm $form */
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'posterconfirmtask-form',
					'enableAjaxValidation' => false,
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
						//'validateOnChange' => true,
						//'validateOnType' => true,
					),
				));
				
				
				?> 
<h2 class="h4"><?php echo CHtml::encode(Yii::t('poster_confirmtask','lbl_task_confirmation')) ?></h2>
<div class="controls-row">
<div class="span2 nopadding"><?php echo CHtml::encode(Yii::t('poster_confirmtask','lbl_task_rating')) ?></div>
<div class="span2 nopadding">
    <?php 
    $readOnly=false;
    $starValue = '';
    if(isset($task->{Globals::FLD_NAME_RANK}))
    {
        $readOnly=true;
        $starValue = $task->{Globals::FLD_NAME_RANK};
    }
    ?>
    <?php $this->widget('CStarRating',array('name'=>'rank',
        'starCount'=>5,
        'readOnly'=>$readOnly,
        'resetText'=>'',
        'value'=>$starValue,
        'callback'=>'function(){  $(\'#Task_rank\').val($(this).val()); }',
        
  )); ?>
    <?php echo $form->hiddenField($task,Globals::FLD_NAME_RANK); ?>
    <?php echo $form->error($task,  Globals::FLD_NAME_RANK); ?>
</div>
</div>
<div class="controls-row cnl_space">
<div class="span2 nopadding"><?php echo CHtml::encode(Yii::t('poster_confirmtask','lbl_task_comment')) ?></div>
<div class="span5 nopadding">
    <?php 
    $readOnly=false;
    $remarksValue = '';
    if(isset($task->{Globals::FLD_NAME_REF_REMARKS}) && $task->{Globals::FLD_NAME_REF_REMARKS} !='')
    {
        $readOnly=true;
        $remarksValue = $task->{Globals::FLD_NAME_REF_REMARKS};
    }
    ?>
        <?php echo $form->textArea($task, Globals::FLD_NAME_REF_REMARKS, array('class'=>'span5','maxlength' => 500,'disabled'=>$readOnly, 'placeholder'=> CHtml::encode(Yii::t('poster_confirmtask','txt_cmnt_here')))); ?>
        <?php echo $form->error($task,Globals::FLD_NAME_REF_REMARKS); ?>
<?php echo $form->hiddenField($task,Globals::FLD_NAME_TASK_ID); ?>
</div>
<div class="space">
    
     
    <?php 
    
    if(!isset($task->{Globals::FLD_NAME_REF_REMARKS}) || !isset($task->{Globals::FLD_NAME_RANK}))
    {
        $successUpdate = '
                                if(data.status==="save_success_message"){
                                    $.ajax({
                                                url      : "'.Yii::app()->createUrl('poster/setconfirmtaskpage').'",
                                                type     : "POST",
                                                data     : { "taskId": "'.$task->{Globals::FLD_NAME_TASK_ID}.'" },
                                                dataType : "html",
                                                cache    : false,
                                                success  : function(html)
                                                {
                                                    jQuery("#ratingtab").html(html);
                                                    $("#msgConfirmTask").html("'.CHtml::encode(Yii::t('poster_confirmtask','txt_confirm_success_msg')).'");
                                                    $("#msgConfirmTask").css("display","block");
                                                },
                                                error:function(){
                                                    alert("'.CHtml::encode(Yii::t('index_updateprofile_portfolio','txt_portfolio_request_failed')).'");
                                                }
                                            });
                                   }
                                   else
                                   {
                                        $.each(data, function(key, val) {
                                            $("#posterconfirmtask-form #"+key+"_em_").text(val);                                                    
                                            $("#posterconfirmtask-form #"+key+"_em_").show();
                                            
                                            });
                                   }
                            '; 
                            CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('index_updateprofile_portfolio',CHtml::encode(Yii::t('poster_confirmtask','lbl_task_submit')))),Yii::app()->createUrl("poster/submitconfirmtask"),'sign_bnt','useraddPortfolio',$successUpdate);
    }            
                            ?>
      </div>
</div>
<?php $this->endWidget(); ?>