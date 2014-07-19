<?php
/* @var $this RatingController */
/* @var $model Rating */

$this->breadcrumbs=array(
	Yii::t('admin_rating_create','rating_text')=>array('admin'),
	Yii::t('admin_rating_create','create_text'),
);

?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_rating_create','create_rating_text')?></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model ,'locale'=>$locale)); ?>