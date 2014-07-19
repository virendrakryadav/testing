<div class="portlet box blue">
    <div class="portlet-title">
    <div class="caption"><i class="icon-cogs"></i><?php echo Yii::t('admin_admin_admin','Search');?></div>

    </div>
</div>
<div class="search-form" >
<?php $this->renderPartial('_searchtaskposted',array(
	'task'=>$task,
        'fillFields'=>$fillFields,
)); ?>
</div><!-- search-form -->
<script>
   
</script>
    <?php
//print_r($fillFields);
    
    
//     $this->beginWidget('zii.widgets.jui.CJuiDialog', 
//       array(   'id'=>'pendaftar_dialog',
//                // additional javascript options for the dialog plugin
//                'options'=>array(
//                                'title'=>'List Pendaftar',
//                                'width'=>'auto',
//                                'autoOpen'=>false,
//                                ),
//                        ));

     
$this->widget('GridView', array(
	'id'=>'data-grid',
	//'formActions'=>'all', //visible :: all-> active+inactive+delete, delete-> delete, status-> active/inactive
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
                        'value'=>'$data["'.Globals::FLD_NAME_TITLE.'"]',
		),
                array(
			'header'=>'Description',
			'name'=>'description',
                        'value'=>'UtilityHtml::setStrlength($data["'.Globals::FLD_NAME_DESCRIPTION.'"],30)',

		),
                array(
			'header'=>'Doer Name',
			'name'=>'tasker_name',
                        'value'=>'UtilityHtml::getReceivedUserName($data["taskTasker"]["'.Globals::FLD_NAME_TASKER_ID.'"],$data["taskTasker"]["'.Globals::FLD_NAME_TASKER_STATUS.'"])',

		),
                array(
			'header'=>'Status',
			'name'=>'state',
                        'value'=>'UtilityHtml::getTaskStatus($data["'.Globals::FLD_NAME_TASK_STATE.'"])',

		),
           
            array(
            'header'=>'Refund',
            'type'=>'raw',
            'value'=>'CHtml::ajaxLink($data["'.Globals::FLD_NAME_PROPOSALS_CNT.'"], array("user/taskproposallist", "'.Globals::FLD_NAME_TASK_ID.'"=>$data["'.Globals::FLD_NAME_TASK_ID.'"]), array(
           "update"=>"#jobslist",
            "beforeSend" => "function() {           
                $(\"#jobslist\").addClass(\"grid-view-loading\");
               
                $(\"#jobslist\").dialog(\"open\"); 
            }",
            "complete" => "function() {
           
                $(\"#jobslist\").removeClass(\"grid-view-loading\");
                 
            }", 
            ),array("id"=>"showProposals".$data["'.Globals::FLD_NAME_TASK_ID.'"]));',

        ),
                array(
			'header'=>'Escrow Account',
			'name'=>'payment_mode',
                        'value'=>'',

		),
                array(
			'header'=>'Paid Amount',
			'name'=>'price',
                        'value'=>'$data["'.Globals::FLD_NAME_PRICE.'"]',

		),
            array(
			'header'=>'Task Type',
			'name'=>'price',
                        'value'=>'UtilityHtml::getTaskType($data["'.Globals::FLD_NAME_TASK_KIND.'"])',

		),
            array(
			'header'=>'Post Date',
			'name'=>'price',
                        'value'=>'CommonUtility::formatedViewDate( $data["'.Globals::FLD_NAME_CREATED_AT.'"])',

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
)); 

//$this->endWidget('zii.widgets.jui.CJuiDialog');
//echo CHtml::Button('Get Pendaftar', 
//                      array('onclick'=>'$("#pendaftar_dialog").dialog("open"); return false;',
//                   ))
//
//        ?> 

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobslist',
                'options'=>array(
                    'title'=>Yii::t('job','Jobs List'),
                    'autoOpen'=>false,
                    'modal'=>'true',
                    'width'=>'750',
                    'height'=>'500',
                ),
                )); ?>

        
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
      