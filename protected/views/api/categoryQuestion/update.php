<?php
/* @var $this CategoryQuestionController */
/* @var $model CategoryQuestion */

$this->breadcrumbs=array(
	'Category Questions',
	'Update',
);
?>
<div class="portlet box blue"><div class="portlet-title">
        <div class="caption"><i class="icon-edit"></i>Update CategoryQuestion</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>