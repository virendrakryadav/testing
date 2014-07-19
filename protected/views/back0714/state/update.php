<?php
/* @var $this StateController */
/* @var $model State */

$this->breadcrumbs=array(
	Yii::t('admin_state_update','state_text')=>array('admin'),
	//$model->state_id=>array('view','id'=>$model->state_id),
	Yii::t('admin_state_update','update_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_state_update','update_state_text')?></div>
</div>
    
<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>