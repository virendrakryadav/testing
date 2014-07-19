<?php
/* @var $this LanguageController */
/* @var $model Language */

$this->breadcrumbs=array(
	Yii::t('admin_language_create','language_text') =>array('admin'),
	Yii::t('admin_language_create','create_text'),
);

$this->menu=array(
	array('label'=>Yii::t('admin_language_create','list_language_text'), 'url'=>array('index')),
	array('label'=>Yii::t('admin_language_create','manage_language_text'), 'url'=>array('admin')),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_language_create','create_language_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>