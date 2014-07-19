<?php
/* @var $this SkillController */
/* @var $model Skill */

$this->breadcrumbs=array(
	'Skills',
	'Create',
);
?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i>Manage Skill</div>
<div class="actions"><a onclick="$('#skillmaindiv').show();$('#categorymaindiv').hide();" class="btn green">
<i class="icon-plus"></i>Add Skill</a></div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>