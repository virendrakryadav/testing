<div style="padding-top:90px" >
    <div style="font-size:24px; height:500px" align="center"><?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'login-form',
				//'enableAjaxValidation' => true,
				'action' => Yii::app()->createUrl('commonfront/sendmailtest'), 
				//'enableClientValidation' => true,
				//'clientOptions' => array(
					//'validateOnSubmit' => true,
					//'validateOnChange' => true,
					//'validateOnType' => true,
				//),
				
			)); 
			
			
			?>
<?php echo CHtml::hiddenField("data", '{"cmd":"send_email","id":"welcome_email","to":"thaparajay@hotmail.com",
	"param":"{\"voboloURL\":\"www.vobolo.com\",\"fullName\":\"ArchanaThapar\"}"}' ); ?>
	<?php echo CHtml::submitButton(Yii::t('admin_admin_search','Submit'),array('class'=>'btn blue')); ?>
	

    <?php $this->endWidget(); ?>
    </div>
        
</div><!-- saved from url=(0022)http://internet.e-mail -->

