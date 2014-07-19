<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	
	Yii::t('admin_admin_updateaccount','update_account_text'),
);
?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-user"></i><?php echo Yii::t('admin_admin_updateaccount','update_profile_text')?>: <span style="color:#0088CC"><?php echo $model->login_name; ?></span></div>
</div>
</div>
<?php $this->renderPartial('_formupdateaccount', array(
                                                         'model'=>$model,
                                                         'contactEmail'=>$contactEmail,
            )); ?>