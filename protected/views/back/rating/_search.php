<?php
/* @var $this RatingController */
/* @var $model Rating */
/* @var $form CActiveForm */
?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'search-form',
)); ?>
    
        <div class="span2">
            <div class="control-group">
                <?php echo $form->label($model,'rating_for',array('class'=>'control-label','label'=>Yii::t('admin_rating_search','rating_for_txt'))); ?>
                <div class="controls">
                <?php echo UtilityHtml::getRatingDropdownPosterandTasker($model,Globals::FLD_NAME_RATING_FOR, CommonUtility::createValue($fillFields,Globals::FLD_NAME_RATING_FOR)); ?>
                
                <?php 
//                $rating_for = ''; 
//                $list = CHtml::listData(Rating::getRatingList(),'rating_for', 'rating_for');
//                echo $form->dropDownList($model,'rating_for', $list, array('prompt'=>'--Select Rating--', 'class' => 'span12',
//                'options' => array($rating_for=>array('selected'=>true)),'class' => 'span12'));
                ?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                    <?php echo $form->label($model,'rating_desc',array('class'=>'control-label','label'=>Yii::t('admin_rating_search','rating_desc_txt'))); ?>
                    <div class="controls"> 
                        <?php CommonUtility::autocomplete('rating_desc','rating/autocompleteratingdescription',10,$fillFields,'span12',60,250);?>
                    <?php //echo $form->textField($model,'rating_desc',array('class'=>'span12', 'value'=>CommonUtility::createValue($fillFields,'rating_desc'))); ?>
                    </div>
            </div>            
        </div>
        <div class="span2">
                <div class="control-group">
                        <?php echo $form->label($model,'status',array('class'=>'control-label','label'=>Yii::t('admin_rating_search','rating_status_txt'))); ?>
                        <div class="controls"> 
                        <?php echo UtilityHtml::getStatusDropdownAandN($model,Globals::FLD_NAME_STATUS, CommonUtility::createValue($fillFields,Globals::FLD_NAME_STATUS)); ?>
                        </div>
                </div>
        </div>
        <div class="span2 topspace">
		<?php echo CHtml::submitButton(Yii::t('admin_rating_search','search_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::resetButton(Yii::t('admin_rating_search','reset_text'), array('id'=>'form-reset-button','class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->