<?php
/* @var $this IndexController */
/* @var $form CActiveForm */
?>	
<style>
div.flash-success
{
	background: none repeat scroll 0 0 #E6EFC2;
    border-color: #C6D880;
    color: #264409;
	margin: 1em 0;
    padding: 0.5em;
}
</style>
	<script type="text/javascript" src="/greencometdev/js/errorpopover.js"></script>
<?php //CommonUtility::updateProfileValidation(); ?>
		<div style="padding-top:76px">
		  <div class="create_account" style="width:70%">
			<div class="create_account_popup">
			<?php
			if(Yii::app()->user->hasFlash('success')): ?>
					<div class="flash-success">
						<?php echo Yii::app()->user->getFlash('success'); ?>
					</div>
			<?php endif; ?>

			<div class="popup_head">
				<h2 class="heading"><?php echo CHtml::encode(Yii::t('blog','Change Profile Pick')); ?></h2>
			</div>
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'upload-form',
					'enableAjaxValidation' => true,
					//'action' => Yii::app()->createUrl('index/updateimage'), 
					'enableClientValidation' => true,
				'clientOptions' => array(
						'validateOnSubmit' => true,
						'validateOnChange' => true,
						'validateOnType' => true,
					),
					'htmlOptions' => array('enctype' => 'multipart/form-data'),
					)); 
					
$htmlOptions =array
    (
        'errorCssClass'=>'',
        'successCssClass'=>'',
        'validatingCssClass'=>'',
        'style'=>'display: none',
        'hideErrorMessage'=>true,
        'afterValidateAttribute'=>'js:afterValidateAttribute'
		
);
		

$validationArray = array
(
    'hideErrorMessage'=>true,
    'errorCssClass'=>'',
    'successCssClass'=>'',
    'validatingCssClass'=>'',
	'style'=>'display: none',
    'afterValidateAttribute'=>'js:afterValidateAttribute'
);
					?>
					<fieldset>
					<?php //echo $form->errorSummary($model); ?>
			  <div class="create_acunt_inner">
				<div class="create_acunt_left">
				<div class="sign_row">
			<?php //echo $form->textFieldRow($model,'firstname',array('placeholder'=>'firstname', 'class'=>'span4','errorOptions'=>$htmlOptions,'prepend'=>'<i class="icon-globe"></i>'));?>
				</div>
									
				<div class="sign_row">
			<?php echo $form->textFieldRow($model,'email',array('placeholder'=>'email', 'class'=>'span3','errorOptions'=>$htmlOptions,'prepend'=>'<i class="icon-envelope"></i>'));?>
			<? //=CHtml::image(Yii::app()->request->baseUrl.'/images/uploads/'.$model->user_image,"image",array("width"=>200));	//echo getcwd().'/images/uploads/';	?>
				</div>
				<div class="sign_row">
			<?php //echo $form->textFieldRow($model,'firstname',array('placeholder'=>'firstname', 'class'=>'span3','errorOptions'=>$htmlOptions,'prepend'=>'<i class="icon-globe"></i>'));?>
				</div>
			<div class="sign_row">
			<?php //echo $form->textFieldRow($model,'lastname',array('placeholder'=>'lastname', 'class'=>'span3','errorOptions'=>$htmlOptions,'prepend'=>'<i class="icon-globe"></i>'));?>
			</div>
			<div class="sign_row">
			<? /* $this->widget('ext.EAjaxUpload.EAjaxUpload',
						array(
								'id'=>'uploadFile',
								'config'=>array(
									   'action'=>Yii::app()->createUrl('index/upload/'),
									   'allowedExtensions'=>array("jpg","jpeg","gif","exe","mov","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
									   'sizeLimit'=>10*1024*1024,// maximum file size in bytes
									   'minSizeLimit'=>1*12*12,*/// minimum file size in bytes
									   /*'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
									   'messages'=>array(
									                     'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
									                    'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
									                     'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
									                     'emptyError'=>"{file} is empty, please select files again without it.",
									                     'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
									                    ),
									   'showMessage'=>"js:function(message){ alert(message); }"*/
									  /* 'onComplete'=>"js:function(id, fileName, responseJSON){ 
                                                            if(responseJSON.success){ 
                                                                var msg = JSON.stringify(responseJSON);
                                                                addFlashMessage(msg);
                                                                $('#documents-grid').yiiGridView.update('index-grid'); 
                                                            }
                                                        }", 
									  )
						));*/ ?>
				
						<?php 
						//echo Yii::getPathOfAlias('webroot').'/images/productTheme/';
						/*$this->widget('ext.imageSelect.ImageSelect',  array(
								'path'=>Yii::app()->baseUrl.'/images/uploads/',
								'alt'=>'alt text',
								'uploadUrl'=>Yii::getPathOfAlias('webroot').'/images/uploads/',
								'htmlOptions'=>array('enctype' => 'multipart/form-data'),
						   ));*/
						
						/*echo $form->labelEx($model,'image');
						echo $form->fileField($model,'image');
						echo $form->error($model,'image');*/
						
						$this->widget('ext.imageAttachment.ImageAttachmentWidget', array(
							'model' => $model,
							'behaviorName' => 'preview',
							'apiRoute' => 'user/saveImageAttachment',
						));
						/*if($model->preview->hasImage())
							echo CHtml::image($model->preview->getUrl('medium'),'Medium image version');
						else
							echo 'no image uploaded';*/
						
						?>
					</div>
					<div class="sign_row">
					<? //=$model->user_video;?>
						<?php /*?><embed src="<?=Yii::app()->request->baseUrl.'/video/'.$model->user_video;?>" height="200" width="200"><?php */?>
					</div>
					<div class="sign_row">
						<?php 
						/*echo $form->labelEx($model,'video');
						echo $form->fileField($model,'video');
						echo $form->error($model, 'video');*/
						?>
					</div>
				
	<div class="sign_row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname'); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>


					
					
					<div class="sign_row2">
					<?php echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Upload Image')),array('class'=>'sign_bnt')); ?>
					</div>
				</div>
			  </div>
			  </fieldset>
			  <?php $this->endWidget(); ?>
			</div>
		  </div>
		</div>
