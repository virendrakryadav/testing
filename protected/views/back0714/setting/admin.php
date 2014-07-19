<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	Yii::t('admin_setting_admin','setting_text'),
	Yii::t('admin_setting_admin','manage_text'),
);
?>
<style>
    input.btn[type="submit"] {
    margin-left: 450px;
}
</style>
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_setting_admin','manage_setting_text')?></div>
    </div>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'id'=>'grid-form'
)); ?>

<?php
$this->widget('zii.widgets.jui.CJuiAccordion',array(
    'panels'=>array(
        'Poster'=>$this->renderPartial('_poster', array(),true,false),
        'Doer'=>$this->renderPartial('_tasker',array(),true,false),
        'Other'=>$this->renderPartial('_viewallsettings',array(),true,false),
        ),
    // additional javascript options for the accordion plugin
    'options'=>array(
            //'animated'=>'bounceslide',
            'collapsible'=>true,
            'autoHeight'=>false,
            'icons'=>array(
	            "header"=>"ui-icon-plus",//ui-icon-circle-arrow-e
	             "headerSelected"=>"ui-icon-circle-arrow-s",//ui-icon-circle-arrow-s, ui-icon-minus
	        ),
        ),
));
?> 
<div class="controls">
    <div class="span2">
    <?php echo CHtml::submitButton(Yii::t('admin_setting_form','update_text'),array('class'=>'btn blue','name' => 'submit')); ?>
    </div>
</div>       
<?php $this->endWidget(); ?>