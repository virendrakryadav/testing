<div class="controls-row" style="width:97.7%;"> 

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'postedTasks',
        'dataProvider' => $task->userPostedTasks(),
        //'filter'=>$model,
       // 'template' => '{summary} {pager} {items} {pager}',
        'emptyText' => Yii::t('index_updateprofile','msg_no_posted_tesk'),
        'ajaxUpdate' => true,
        'columns' => array(
                    
            array(
                'header' => 'S.No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array(
                    'class' => 'grid_srno'
                ),
            ),
            array(
                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_name')),
                'name' => 'title',
                'value' => '$data["title"]',
            ),
            array(
                 'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_price ({n})' , Globals::DEFAULT_CURRENCY)),
                'name' => 'price',
                'value' => '$data["price"]',
            ),
            array(
                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_state')),
                'name' => 'state',
                'value' => '$data["state"]',
            ),
            array(
                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'Task Detail')),
             'type' => 'html',
                'value' => 'UtilityHtml::getTaskDetailLink($data->{Globals::FLD_NAME_TASK_ID})',
            ),
//            array(
//                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_date')),
//                'name' => 'task_finished_on',
//                'value' => '$data["task_finished_on"]',
//            ),
//            array(
//                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_public')),
//                'type' => 'html',
//                'value' => 'UtilityHtml::getPublicImage($data["is_public"], "Task", $data["task_id"], "is_public","task_id","portfolio-grid-post")',
//                'headerHtmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//                'htmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//            ),
//            array(
//                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_update')),
//                'type' => 'html',
//                'value' => 'UtilityHtml::getUpdateImage($data["task_id"],$data["taskReference"]["verification_status"])',
//                'headerHtmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//                'htmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//            ),
//            array(
//                'header' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_delete')),
//                'type' => 'html',
//                'value' => 'UtilityHtml::getDeleteImage($data["task_id"],$data["taskReference"]["verification_status"],"portfolio-grid-post")',
//                'headerHtmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//                'htmlOptions' => array(
//                    'class' => 'grid_status',
//                ),
//            ),

        ),
    ));
    ?>
</div>
<?php //$this->endWidget(); ?>
