<?php echo CommonScript::loadPopOverHide(); ?>
<div class="pro_tab">
<h2 class="h2"><?php echo Yii::t('index_changepassword','change_password_text')?></h2>
    <div id="yw2" class="tabs-above">
        <div id="msg" style="display:none" class="flash-success"></div>
<!--<ul id="yw3" class="nav nav-tabs">
<li class="active">
<a href="#yw2_tab_1" data-toggle="tab"><?php //echo Yii::t('index_changepassword','change_password_text')?></a>
</li>
</ul>-->
        <div class="tab-content">
            <div id="yw2_tab_1" class="tab-pane fade active in">
            <?php /** @var BootActiveForm $form */
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'changepassword-form',
                                            'enableAjaxValidation' => true,
					//'action' => Yii::app()->createUrl('index/changepassword'), 
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
						'validateOnChange' => true,
						'validateOnType' => true,
					),
					));  ?>
				<div class="controls-row">
					<div class="span4 nopadding">
						<?php echo $form->labelEx($model,'oldpassword',array('label'=>Yii::t('index_changepassword','oldpassword_text'))); ?>
						<div class="span4 nopadding">
                                                    <?php echo $form->passwordField($model,'oldpassword', array('class'=>'span4','value'=>'')); ?>
						<?php echo $form->error($model,'oldpassword'); ?>
					</div></div>
				</div>
                                <div class="controls-row">
					<div class="span4 nopadding">
						<?php echo $form->labelEx($model,'newpassword',array('label'=>Yii::t('index_changepassword','newpassword_text'))); ?>
						<div class="span4 nopadding">
                                                    <?php $this->widget('ext.EStrongPassword.EStrongPassword',array('form'=>$form, 'model'=>$model, 'attribute'=>'newpassword','htmlOptions'=>array('class'=>'span4 left_password'),));?>
						<?php echo $form->error($model,'newpassword'); ?>
					</div></div>
				</div>
                                <div class="controls-row">
					<div class="span4 nopadding">
						<?php echo $form->labelEx($model,'repeatpassword',array('label'=>Yii::t('index_changepassword','repeatpassword_text'))); ?>
						<div class="span4 nopadding">
                                                    <?php echo $form->passwordField($model,'repeatpassword', array('class'=>'span4')); ?>
						<?php echo $form->error($model,'repeatpassword'); ?>
					</div></div>
				</div>
				<div id="post">
				</div>
                                <div class="controls-row">
					<div class="span4 nopadding">
					<?php
						echo CHtml::ajaxSubmitButton(Yii::t('index_changepassword','change_password_text'),Yii::app()->createUrl('index/changepassword'),array(
							   'type'=>'POST',
							   'dataType'=>'json',
							   //'beforeSend' => 'function(data){alert(data);  }',
							   'success'=>'js:function(data){
								   if(data.status==="success"){
									  $("#msg").html("'.Yii::t('index_changepassword','success_text').'");
									  $("#msg").css("display","block");
								   }else{
								   $.each(data, function(key, val) {
										$("#changepassword-form #"+key+"_em_").text(val);                                                    
										$("#changepassword-form #"+key+"_em_").show();
										});
								   }
								   $(".changepas_bnt").removeClass("loading"); 
							   }',
                               'beforeSend'=>'function(){                        
                                   $(".changepas_bnt").addClass("loading");
                              }'
							),array('class'=>'changepas_bnt'));
					?>
					<?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Change Password')),array('class'=>'sign_bnt')); ?>
					</div>
                                </div>
				 <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>