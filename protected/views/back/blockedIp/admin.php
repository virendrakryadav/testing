<?php
/* @var $this BlockedIpController */
/* @var $model BlockedIp */

$this->breadcrumbs=array(
	'Blocked',
	'Manage',
);
?>
<div class="portlet box blue">
    <div class="portlet-title">
    <div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_blockedIp_admin','Manage Blocked Ips')?></div>
        <div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('blockedip/create')?>">
        <i class="icon-plus"></i><?php echo Yii::t('admin_blockedIp_admin','Add New')?></a>
        </div>
    </div>
</div>

<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
        'fillFields'=>$fillFields,
)); ?>
    
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'id'=>'grid-form'
    
));
?>
<?php $this->widget('GridView', array(
	'id'=>'data-grid',
        'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
        'dataSession'=>'blockedIpDataSession', //sesseion name for current page size dropdown
        'statusAandN'=>'statusAandN',
        'statusField'=>'status',
        'ajaxUpdate'=>true,
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
               array(
                    'class'=>'CCheckBoxColumnUniform',
                    'selectableRows' => 1000,
                    'id'=>'autoId',
                    ),
                array(
                    'header'=>'S.No.',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions'=>array(
                                              'class' => 'grid_srno'
                                              ),
                    ),
                array(
			'header'=>'IP Address',
			'name'=>  Globals::FLD_NAME_BLOCKED_IP_ADDRESS,
		),
                array(
                        'header'=>'Start Date',
                        'name'=>Globals::FLD_NAME_BLOCKED_IP_START_DATE,
                        'value'=>'CommonUtility::formatedViewDate($data->start_dt)',
                        
                ),
                array(
                        'header'=>'End date',
                        'name'=>Globals::FLD_NAME_BLOCKED_IP_END_DATE,
                        'value'=>'CommonUtility::formatedViewDate($data->end_dt)',
                        
                ),
                array(
                        'header'=>'Reason',
                        'name'=>Globals::FLD_NAME_BLOCKED_IP_REASON,
                ),
                array(
			'name'=>'Status',
			'type'=>'html',
			'value'=>'UtilityHtml::getStatusImageForAandN($data->{Globals::FLD_NAME_BLOCKED_IP_STATUS}, "Blockedip", $data->{Globals::FLD_NAME_BLOCKED_IP_ID}, Globals::FLD_NAME_BLOCKED_IP_STATUS  , "" , Globals::FLD_NAME_BLOCKED_IP_ID)',
			'htmlOptions' => array(
                                              'class' => 'grid_status',
                                              ),
                        'headerHtmlOptions'=>array(
                                              'class' => 'grid_status'
                                                  ),
                ),
                array(
			'header'=> 'Edit',
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		array(
			'header'=> 'Delete',
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
		),
            ),
)); ?>
<?php $this->endWidget(); ?>