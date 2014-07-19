<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs=array(
	
	Yii::t('admin_admin_changepassword','change_password_text'),
);

?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-lock"></i><?php echo Yii::t('admin_admin_userchangepassword','change_password_text')?>: <span style="color:#0088CC"><?php echo ucfirst($model->login_name); ?></span></div>
</div>

<?php $this->renderPartial('_userpassword', array('model'=>$model)); ?>