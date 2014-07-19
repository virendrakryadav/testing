<?php
/* @var $this CategoryQuestionController */
/* @var $model CategoryQuestion */

$this->breadcrumbs=array(
	'Category Questions'=>array('admin'),
	'Create',
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>Create Question</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>