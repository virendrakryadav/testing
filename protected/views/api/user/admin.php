<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users',
	'Manage',
);


?>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i>Manage Site Users</div>
<div class="actions"><a class="btn green" href="<?php echo Yii::app()->createUrl('user/create')?>">
<i class="icon-plus"></i>Add New</a></div>
</div></div>


<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'fillFields'=>$fillFields,
)); ?>
</div><!-- search-form -->
<?php   $form=$this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'id'=>'grid-form'
        )); 

?>
<?php $this->widget('GridView', array(
	'id'=>'data-grid',
        'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
	'dataSession'=>'userDataSession', //sesseion name for current page size dropdown
        'statusField'=>'user_status',
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
                    'header'=>'Name',
                    'name'=>'firstname',
                    'value'=>'$data->firstname . " " . $data->lastname',

                    //'value'=>'$data["user_firstname"]'.'$data["user_firstname"]',
		),
		
		'email',
		'mobile',
                'zip_code',
		array(
			'header'=>'City Name',
			'name'=>'city_name',
                        'value'=>'$data["citylocale"]["city_name"]',
                    
		),
                array(
			'header'=>'Region Name',
			'name'=>'region_name',
                        'value'=>'$data["regionlocale"]["region_name"]',
                    
		),
		array(
			'header'=>'State Name',
			'name'=>'state_name',
                        'value'=>'$data["statelocale"]["state_name"]',
                    
		),
		array(
			'header'=>'Country Name',
                        'name'=>'country_name',
			'value'=>'$data["countrylocale"]["country_name"]',
		),
		
		array(
			'header'=>'User Photo',
                        'name'=>'user_image',
			'value'=>'UtilityHtml::getUserImage($data->user_image)',
		),
		array(
			'header'=>'User Video',
                        'name'=>'user_video',
			'value'=>'UtilityHtml::getVideo($data->user_video)',
		),
		array(
                    'header'=>'Change Password',
                    'name'=>'password',
                    'type'=>'html',
                    'value'=>'UtilityHtml::getFrontUserPasswordImage($data->{Globals::FLD_NAME_USER_ID})',
                    'htmlOptions' => array(
                        'class' => 'grid_password',
                    ),
                     'headerHtmlOptions'=>array(
                         'class' => 'grid_password'
                    ),
                ),
		array(
                    'name'=>'user_status',
                    'type'=>'html',
                    'value'=>'UtilityHtml::getStatusImage($data->user_status, "User", $data->{Globals::FLD_NAME_USER_ID}, "user_status","","user_id")',
                    'headerHtmlOptions' => array(
                        'class' => 'grid_status',
                    ),
                    'htmlOptions' => array(
                        'class' => 'grid_status',
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