<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
//	$model->setting_id,
//        'Admin'=>array('admin'),
);

//$this->menu=array(
//	array('label'=>'List Setting', 'url'=>array('index')),
//	array('label'=>'Create Setting', 'url'=>array('create')),
//	array('label'=>'Update Setting', 'url'=>array('update', 'id'=>$model->setting_id)),
//	array('label'=>'Delete Setting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->setting_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Setting', 'url'=>array('admin')),
//);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>View</div>
</div>
 <div class="wide form" style="padding:10px;">
     <div class="row-fluid form-horizontal">
        <div class="control-group">
            <label><?php echo CHtml::encode($model->getAttributeLabel('setting_id')); ?>:</label>
            <div class="controls"><?php echo $model->{Globals::FLD_NAME_SETTING_ID}; ?></div>
        </div>
        <div class="control-group">
            <label><?php echo CHtml::encode($model->getAttributeLabel('setting_type')); ?>:</label>
            <div class="controls"><?php echo $model->{Globals::FLD_NAME_SETTING_TYPE}; ?></div>
        </div>
        <div class="control-group">
            <label><?php echo CHtml::encode($model->getAttributeLabel('setting_key')); ?>:</label>
            <div class="controls"><?php echo $model->{Globals::FLD_NAME_SETTING_KEY}; ?></div>
        </div>
         <div class="control-group">
            <label><?php echo CHtml::encode($model->getAttributeLabel('setting_value')); ?>:</label>
            <div class="controls"><?php echo $model->{Globals::FLD_NAME_SETTING_VALUE}; ?></div>
        </div>
         <div class="control-group">
            <label><?php echo CHtml::encode($model->getAttributeLabel('setting_label')); ?>:</label>
            <div class="controls"><?php echo $model->{Globals::FLD_NAME_SETTING_LABEL}; ?></div>
        </div>
     </div>
 </div>
<?php 
//$this->widget('zii.widgets.CDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
//		'setting_id',
//		'setting_type',
//		'setting_key',
//		'setting_value',
//		'setting_label',
//		'created_at',
//		'updated_at',
//	),
//)); ?>
