<?php
/* @var $this SkillController */
/* @var $model Skill */

$this->breadcrumbs=array(
	'Skills',
	'Create',
);
?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>Create Skill</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'locale'=>$locale)); ?>