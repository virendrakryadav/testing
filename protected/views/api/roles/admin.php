<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	Yii::t('admin_roles_admin','roles_text'),
	Yii::t('admin_roles_admin','manage_text'),
);
?>

<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_roles_admin','manage_roles_text'); ?></div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('roles/create')?>">
<i class="icon-plus"></i><?php echo Yii::t('admin_roles_admin','add_roles_text');?></a></div>
</div></div>


<?php /*?><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?><?php */?>
<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'fillFields'=>$fillFields,
)); ?>
</div><!-- search-form -->


<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'id'=>'grid-form'
)); ?>

<?php $this->widget('GridView', array(
	'id'=>'data-grid',
	'formActions'=>'delete', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'rolesDataSession', //sesseion name for current page size dropdown
        'clildTable'=>'Admin',
        'actionClassName'=>'Roles',
        'hasLacale'=>'No',
	'dataProvider'=>$model->search(),
   
	//'filter'=>$model,
	'columns'=>array(
            array(
			'class'=>'CCheckBoxColumnUniform',
			'selectableRows' => 1000,
			'id'=>'autoId',
		),
		array(
			'header'=>Yii::t('admin_roles_admin','ser_no_text'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),
		'role_name',
		//'role_permission',
            array(
                    'header' => Yii::t('admin_roles_admin','role_permission_text'),
                    'type' => 'raw',
                    'value' => 'UtilityHtml::renderPermissions($data->role_id)',
                    'name' => 'role_permission',
                'headerHtmlOptions'=>array(
                            'class' => 'grid_permissions'
                        ),
             
                ),
		array(
			'header'=> Yii::t('admin_roles_admin','edit_text'),
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> Yii::t('admin_roles_admin','delete_text'),
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
	),
)); ?>
<?php $this->endWidget(); ?>