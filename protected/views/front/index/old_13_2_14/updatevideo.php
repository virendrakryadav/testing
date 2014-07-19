<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
?>	
<style>
div.flash-success
{
	/*background: none repeat scroll 0 0 #E6EFC2;
    border-color: #C6D880;
    color: #264409;*/
	margin: 1em 0;
    padding: 0.5em;
}
</style>
	
<?php //CommonUtility::updateProfileValidation(); ?>
		<div style="padding-top:76px">
		  <div class="create_account" style="width:70%">
			<div class="create_account_popup">
			<?php if(Yii::app()->user->hasFlash('success')): ?>
					
			<?php $this->widget('bootstrap.widgets.TbAlert', array(
						'block'=>true, // display a larger alert block?
						'fade'=>true, // use transitions?
						'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
						'alerts'=>array( // configurations per alert type
							'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
						),
					)); ?>
						
						<?php //echo Yii::app()->user->getFlash('success'); ?>
					
			<?php endif; ?>

			<div class="popup_head">
				<h2 class="heading"><?php echo CHtml::encode(Yii::t('blog','Upload Video')); ?></h2>
			</div>
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'uploadvideo-form',
					'enableAjaxValidation' => false,
					'action' => Yii::app()->createUrl('index/updatevideo'), 
					'enableClientValidation' => false,
					'clientOptions' => array(
							'validateOnSubmit' => false,
							//'validateOnChange' => true,
							//'validateOnType' => true,
						),
					'htmlOptions' => array('enctype' => 'multipart/form-data'),
					)); ?>
					<?php //echo $form->errorSummary($model); ?>
			  <div class="create_acunt_inner">
				<div class="create_acunt_left">
					<div class="sign_row">
					</div>
					<div class="sign_row">
					<?php /*$this->widget('bootstrap.widgets.TbProgress', array(
							'type'=>'danger', // 'info', 'success' or 'danger'
							'percent'=>30, // the progress
							'striped'=>true,
							'animated'=>true,
						));*/ ?>
					<? //=$model->user_video;?>
						<?php /*?><embed src="<?=Yii::app()->request->baseUrl.'/video/'.$model->user_video;?>" height="200" width="200"><?php */?>
					</div>
					<div class="sign_row">
						<?php 
						echo $form->labelEx($model,'video');
						echo $form->fileField($model,'video');
						echo $form->error($model, 'video');
						?>
					</div>
					<div class="sign_row2">
					<?php
						/*echo CHtml::ajaxSubmitButton('Upload Video',Yii::app()->createUrl('index/updatevideo'),array(
							   'type'=>'POST',
							   'dataType'=>'json',
							   'success'=>'js:function(data){
							  // alert(data);
								   if(data.status==="success"){
									  //$(".sign_form").html("You are Registerd Successfully");
									  alert("Successfully");
								   }else{
								   $.each(data, function(key, val) {
								   	//alert(key);
										$("#uploadvideo-form #"+key+"_em_").text(val);                                                    
										$("#uploadvideo-form #"+key+"_em_").show();
										});
								   }
							   }',
							),array('class'=>'sign_bnt'));*/
					?>
					<?php echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Upload Video')),array('class'=>'sign_bnt')); ?>
					</div>
				</div>
			  </div>
			  <?php $this->endWidget(); ?>
			</div>
		  </div>
		</div>
