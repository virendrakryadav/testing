<?php
/* @var $this AdminController */
/* @var $model Admin */

$grid = 'data-grid';
Yii::app()->clientScript->registerScript('searchusers', "
                   
                    $('.search-button').click(function(){
                       
                        $('.search-form').toggle();
                            return false;
                        });
                        $('.search-form form').submit(function(){
                            $('#$grid').yiiGridView('update', {
                                    data: $(this).serialize()
                        });
                        return false;
                    });

                    $('#form-reset-button').click(function()
                    {
                            var form = $(this).closest('form').attr('id');
                            $('#'+form+' input, #'+form+' select').each(function(i, o)
                            {
                                     if (($(o).attr('type') != 'submit') && ($(o).attr('type') != 'reset')) $(o).val('');
                            });
                       $(\".keys\").attr('title', '');
                            $.fn.yiiGridView.update('$grid', {data: $('#'+form).serialize()});
                    
                            return false;
                    
                    });
                   
                    
                    ");

?>


<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
        //'fillFields'=>$fillFields,
)); ?>
</div><!-- search-form -->

<?php   $form=$this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'id'=>'grid-form'
        )); 

?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>$grid,
	
	
 
	'dataProvider'=>$model->search(false),
	'columns'=>array(
               
		array(
                    'header'=>Yii::t('admin_admin_admin','ser_no_text'),
                    'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions'=>array(
                        'class' => 'grid_srno',
                    ),
                ),
//			array(
//                    'header' => Yii::t('admin_admin_admin','login_name_text'),
//                    'name' => 'login_name',
//                 ),
		array(
                    'header'=>Yii::t('admin_admin_admin','User ID'),
                    'name'=>'user_id',
//                    'value'=>'$data->firstname . " " . $data->lastname',
                    'value'=>'$data->{Globals::FLD_NAME_USER_ID}',
//                    'htmlOptions' => array(
//                        'class' => 'grid_password',
//                    ),
                    //'value'=>'$data["firstname"]'.'$data["firstname"]',
				),
            array(
                    'header'=>Yii::t('admin_admin_admin','name_text'),
                    'name'=>'firstname',
//                    'value'=>'$data->firstname . " " . $data->lastname',
                    'value'=>'UtilityHtml::setUserSessionLink($data->{Globals::FLD_NAME_USER_ID})',
//                    'htmlOptions' => array(
//                        'class' => 'grid_password',
//                    ),
                    //'value'=>'$data["firstname"]'.'$data["firstname"]',
				),
			array(
                    'header' => Yii::t('admin_admin_admin','user_email_text'),
                    'name' => 'contact_id',
					'value'=>'$data["usercontact"]["contact_id"]',
                
                 ),
			array(
                    'header' => Yii::t('admin_admin_admin','user_phone_text'),
                    'name' => 'user_phone',
					'value'=>'CommonUtility::getUserPhoneNumber($data->{Globals::FLD_NAME_USER_ID})',
                
                 ),
			array(
                    'header' => Yii::t('admin_admin_admin','user_registered_at'),
                    'name' => 'user_phone',
                    'value'=>'UtilityHtml::getRegisteredDate($data->{Globals::FLD_NAME_CREATED_AT})',
                
                 ),
//             array(
//                    'header' => Yii::t('admin_admin_admin','gender_text'),
//                    'type' => 'raw',
//                    'value' => 'UtilityHtml::getGender($data->gender)',
//                    'name' => 'gender',
//                
//                 ),
//			array(
//                    'header'=>Yii::t('admin_admin_admin','user_role_text'),
//                    'name'=>'user_roleid',
//                    'value'=>'CommonUtility::getUserRoleName($data->{Globals::FLD_NAME_USER_ROLE_ID})',
//				),
//            array(
//                    'header'=>Yii::t('admin_admin_admin','change_password_text'),
//                    'name'=>'password',
//                    'type'=>'html',
//                    'value'=>'UtilityHtml::getPasswordImage($data->{Globals::FLD_NAME_USER_ID})',
//                    'htmlOptions' => array(
//                        'class' => 'grid_password',
//                    ),
//                     'headerHtmlOptions'=>array(
//                         'class' => 'grid_password'
//                    ),
//                ),
		array(
                    'header'=>Yii::t('admin_admin_admin','status_text'),
					'name'=>'status',
                    'type'=>'html',
                    'value'=>'UtilityHtml::getStatusImageForAandN($data->status, "User", $data->{Globals::FLD_NAME_USER_ID}, "status","","category_id")',

                    'headerHtmlOptions' => array(
                        'class' => 'grid_status',
                    ),
                    'htmlOptions' => array(
                        'class' => 'grid_status',
                    ),
		),
                
//		array(
//                    'header'=> Yii::t('admin_admin_admin','edit_text'),
//                    'class'=>'CButtonColumn',
//                    'template'=>'{update}',
//		),
//		array(
//                    'header'=> Yii::t('admin_admin_admin','delete_text'),
//                    'class'=>'CButtonColumn',
//                    'template'=>'{delete}',
//                    'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
//		),
            
	),
)); ?>
<?php $this->endWidget(); ?>