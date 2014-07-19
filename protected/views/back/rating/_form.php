<?php
/* @var $this RatingController */
/* @var $model Rating */
/* @var $form CActiveForm */
?>
<script>
    $(document).ready(function()
    {
        $('#Rating_rating_for').on('change', function()
        {
            if($('#RatingLocale_rating_desc').val() != '')
                                    {
                $('#RatingLocale_rating_desc').parent().removeClass("error");
                document.getElementById("RatingLocale_rating_desc_em_").style.display='none';
                                    }
        });  
    });
	
</script>
<div class="search-form">
<div class="wide form" style="padding:10px;">
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rating-form',
        'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		//'validateOnType' => true,
		'validateOnClick' => true 
            ),
)); ?>
<div class="row-fluid form-horizontal">	
	<?php //echo $form->errorSummary($model); ?>
	<?php //echo $form->errorSummary($locale); ?>
        <?php 
        if(!$model->isNewRecord)
                {
                    echo $form->hiddenField($model,'rating_id',array('class'=>'span6','size'=>60,'maxlength'=>250,)); 
                }
                ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'rating_for',array('class'=>'control-label','label'=>Yii::t('admin_rating_form','rating_for_text'))); ?>
            <div class="controls">
                <div class="span6">
                <?php $fillFields = '';
                echo UtilityHtml::getRatingDropdownPosterandTasker($model,Globals::FLD_NAME_RATING_FOR, $model->{Globals::FLD_NAME_RATING_FOR}); 
                ?>
                </div>
                <?php 
//              $rating_for = ''; 
//              $list = CHtml::listData(Rating::getRatingList(),'rating_for', 'rating_for');
//              echo $form->dropDownList($model,'rating_for', $list, array('prompt'=>'--Select Rating For--', 'class' => 'span6',
//              'options' => array($rating_for=>array('selected'=>true)),'class' => 'span6' ));
//              ?>
                <span class="help-inline">
                    <?php echo $form->error($model,'rating_for'); ?>
                </span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($locale,'rating_desc',array('class'=>'control-label','label'=>Yii::t('admin_rating_form','rating_desc_text'))); ?>
            <div class="controls">
                <?php echo $form->textField($locale,'rating_desc',array('class'=>'span6')); ?>
                <span class="help-inline">
                <?php echo $form->error($locale,'rating_desc'); ?>
                </span>
            </div>
	</div>
        <div class="control-group">
            <?php echo $form->labelEx($locale,'rating_priority',array('class'=>'control-label','label'=>Yii::t('admin_rating_form','rating_priority_text'))); ?>
            <div class="controls">
		<?php echo $form->textField($locale,'rating_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
                <span class="help-inline">
                <?php echo $form->error($locale,'rating_priority'); ?>
                </span>
            </div>
	</div>
        <div class="control-group">
            <?php echo $form->label($locale,'status',array('class'=>'control-label','label'=>Yii::t('admin_rating_form','rating_status_text'))); ?>
            <div class="controls">
		<?php echo $form->radioButtonList($locale, 'status',array('a'=>Yii::t('admin_country_form','active_text'),'n'=>Yii::t('admin_country_form','in_active_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<span class="help-inline">
                    <?php echo $form->error($locale,'status'); ?>
                </span>
            </div>
	</div>
	<div class="controls">
                <div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_rating_form','create_text') : Yii::t('admin_rating_form','update_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::button(Yii::t('admin_rating_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
                </div>
        </div>

<?php $this->endWidget(); ?>
</div></div>
</div><!-- form -->