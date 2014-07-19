<?php
/* @var $this LanguageController */
/* @var $model Language */

$this->breadcrumbs=array(
	Yii::t('admin_language_update','language_text')=>array('admin'),
	//$model->{Globals::FLD_NAME_LANGUAGE_CODE}=>array('view','id'=>$model->{Globals::FLD_NAME_LANGUAGE_CODE}),
	Yii::t('admin_language_update','update_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_language_update','update_language_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>