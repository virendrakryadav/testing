<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	Yii::t('admin_roles_create','roles_text')=>array('admin'),
	Yii::t('admin_roles_create','create_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-plus"></i><?php echo Yii::t('admin_roles_create','create_roles_text')?></div>
</div></div>
<?php 
    $models = Yii::app()->params['rolesModels']; #get modules 

    $allModel['model']=$model;
    foreach ($models as $newModel)
    {
        $var = strtolower($newModel);
        $allModel[strtolower($newModel)]=$$var;

    }
$this->renderPartial('_form',$allModel); ?>