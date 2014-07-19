<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	Yii::t('admin_roles_update','roles_text')=>array('admin'),
	//$model->role_id=>array('view','id'=>$model->role_id),
	Yii::t('admin_roles_update','update_text'),
);


?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-edit"></i><?php echo Yii::t('admin_roles_update','update_role_text')?></div>
</div></div>

<?php 

    $models = Yii::app()->params['rolesModelsFront']; #get modules 
    $allModel['model']=$model;
//     foreach ($models as $index => $newModel)
//    {
//        if(is_array($newModel))
//        {
//// print_r($newModel);
//          $var = strtolower($index);
//            $allModel[strtolower($index)]=$$var;
//           
//        }
//        else
//        {
//            $var = strtolower($newModel);
//            $allModel[strtolower($newModel)]=$$var;
//        }
//        
//        
//
//    }
$this->renderPartial('_form',$allModel); ?>