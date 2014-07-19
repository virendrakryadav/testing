<?php
/* @var $this SkillController */
/* @var $model Skill */

$this->breadcrumbs=array(
	'Skills',	
	'Update',
);

$this->menu=array(
	array('label'=>'List Skill', 'url'=>array('index')),
	array('label'=>'Create Skill', 'url'=>array('create')),
	array('label'=>'View Skill', 'url'=>array('view', 'id'=>$model->skill_id)),
	array('label'=>'Manage Skill', 'url'=>array('admin')),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>Update Skill</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>