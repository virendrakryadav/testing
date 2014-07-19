<style>
    .search-form2 {
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: -moz-use-text-color #E3E8ED #E3E8ED;
    border-style: none solid solid;
    border-width: medium 1px 1px;
    padding: 10px;
}

#form-reset-button2 {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B3B3B3;
    box-shadow: 0 -2px 0 rgba(0, 0, 0, 0.15) inset;
    color: #333333;
    cursor: pointer;
    float: left;
    height: auto;
    margin: 5px 0 0 5px;
    padding: 6px;
    text-shadow: none;
    width: 46%;
}
</style>
<div class="portlet box blue"><div class="portlet-title">
<div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_admin_admin','Search');?></div>

</div></div>
<?php
$currentRequest =  Yii::app()->user->getState(Globals::FLD_NAME_PAGE_URL);
if(isset($currentRequest))
{   
    try
    {
        $currentRequest = CommonUtility::filterUrl($currentRequest);
    }
    catch(Exception $e)
    {             
        $msg = $e->getMessage();
        CommonUtility::catchErrorMsg( $msg  );
    }

}
$grid = 'data-grid-task-done';
Yii::app()->clientScript->registerScript('search2', "
                   
                 
                    $('.search-form2 form').submit(function(){
                            $('#$grid').yiiGridView('update', {  data: $(this).serialize() });
                        return false;
                    });

                    $('#form-reset-button2').click(function()
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
<div class="search-form2 " >
<?php 
$this->renderPartial('_searchtaskdone',array(
	'task'=>$task,
        'fillFields'=>$fillFields,
)); 
?>
</div><!-- search-form -->
    <?php
//print_r($fillFields);
$this->widget('GridView', array(
	'id'=>'data-grid-task-done',
	'dataSession'=>'taskDataSession',
	'dataProvider'=>$taskList,
        'ajaxUpdate'=>true,
	'pager'=>array(
		'maxButtonCount'=>4,
	),
	'columns'=>array(
//		array(
//			'class'=>'CCheckBoxColumnUniform',
//			'selectableRows' => 1000,
//			'id'=>'autoId',
//		),
                array(
                    'type'=> 'raw',
                    'value'=> 'CHtml::hiddenField("language[]", $data["language_code"])',
//                    'value'=> '',
                    'htmlOptions'=>array('style'=>'width:0%; display:none'),
                    'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                ),
		array(
			'header'=>'S.No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'headerHtmlOptions'=>array(
                            'class' => 'grid_srno'
                        ),
                ),               
                array(
			'header'=>'Task',
			'name'=>'title',                        
                        'value'=>'$data["title"]',
		),
                array(
			'header'=>'Description',
			'name'=>'description',
                        'value'=>'UtilityHtml::setStrlength($data["description"],30)',

		),
                array(
			'header'=>'Creator',
			'name'=>'creator_user_id',
                        'value'=>'UtilityHtml::getUserName($data["creator_user_id"])',

		),
              
          
                array(
			'header'=>'Status',
			'name'=>'state',
                        'value'=>'UtilityHtml::getTaskStatus($data["state"])',

		),
                array(
			'header'=>'Payment',
			'name'=>'payment_mode',
                        'value'=>'UtilityHtml::getPaymentMode($data["payment_mode"])',

		),
                array(
			'header'=>'Visibility',
			'name'=>'is_public',
                        'value'=>'UtilityHtml::getPublicMode($data["is_public"])',

		),
//		array(
//			'name'=>'Status',
//			'type'=>'html',
////                        'value'=>'UtilityHtml::getStatusImageForAandN($data["categoryquestionlocale"]["status"], "CategoryQuestionLocale", $data->question_id, "status",$data["categoryquestionlocale"]["language_code"],"question_id")',
//			'htmlOptions' => array(
//                            'class' => 'grid_status',
//			),
//                        'headerHtmlOptions'=>array(
//                             'class' => 'grid_status'
//                        ),
//                ),
		array(
			'header'=> 'View',
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
//		array(
//			'header'=> 'Delete',
//			'class'=>'CButtonColumn',
//			'template'=>'{delete}',
//			'afterDelete'=>'function(link,success,data){if(success){afterdelete(data);}}',
//		),
	),
)); ?> 

      