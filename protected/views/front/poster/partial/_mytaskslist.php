<style>
	.taskrete img
	{
		height: 12px;
		padding: 0 1px;
		width: 12px;
	}
</style>
<div class="list_box">
    <img width="<?php Globals::DEFAULT_VAL_TASK_IMAGE_WIDTH; ?>" height="<?php Globals::DEFAULT_VAL_TASK_IMAGE_HEIGHT; ?>" src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>">
    <?php
    $taskDetailUrl = CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
    $taskState = UtilityHtml::getTaskState($data->{Globals::FLD_NAME_TASK_STATE});
    $taskCategory = UtilityHtml::getTaskCategory($data->{Globals::FLD_NAME_TASK_STATE}, $data);
    ?>                 
    <div class="list_cont"> 
        <div class="list_col1"> 
            <h3 class="h3">
                <?php
                //echo CHtml::ajaxLink($data->{Globals::FLD_NAME_TITLE}, Yii::app()->createUrl('poster/viewtaskpopup'), array(
//                          'beforeSend' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
//                          'complete' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
//                        'data' => array(Globals::FLD_NAME_TASK_ID => $data->{Globals::FLD_NAME_TASK_ID}), 'type' => 'POST',
//                        'success' => 'function(data){ $(\'#loadtaskpreview\').html(data); $(\'#loadtaskpreview\').css("display","block");}'), array('id' => 'taskDetail' . $data->{Globals::FLD_NAME_TASK_ID}, 'live' => false));
                ?>
                <a href="<?php echo $taskDetailUrl ?>"><?php echo ucfirst($data->{Globals::FLD_NAME_TITLE}); ?></a>
            </h3>
            <p class="date"> 
                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')) ?> 
                <?php echo UtilityHtml::getUserFullNameWithPopover( $data->{Globals::FLD_NAME_CREATER_USER_ID} ) ?>
                
                <span class="date">
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_date')) ?>: 
                    <?php echo date(Globals::DEFAULT_VAL_DATE_FORMATE_D_M, strtotime($data->created_at)); ?>
                </span>
            </p>
            <p>
                 <?php  echo $description = CommonUtility::truncateText( $data->{Globals::FLD_NAME_DESCRIPTION} , Globals::DEFAULT_VAL_MY_TASK_DESCRIPTION_LIMIT ); ?>
                <?php //echo substr($data->description, 0, Globals::DEFAULT_VAL_MY_TASK_DESCRIPTION_LIMIT);
                if (strlen($data->{Globals::FLD_NAME_DESCRIPTION}) > Globals::DEFAULT_VAL_MY_TASK_DESCRIPTION_LIMIT )
                {
                    echo CHtml::ajaxLink(' View More', Yii::app()->createUrl('poster/viewtaskpopup'), array(
//                        'beforeSend' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
//                        'complete' => 'function(){$("#viewmore'.$data->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
                        'data' => array(Globals::FLD_NAME_TASK_ID => $data->{Globals::FLD_NAME_TASK_ID}), 
						'type' => 'POST',
                        'success' => 'function(data){ $(\'#loadtaskpreview\').html(data); $(\'#loadtaskpreview\').css("display","block");}'), array('id' => 'viewmore' . $data->{Globals::FLD_NAME_TASK_ID}, 'live' => false));
                 } 
                 ?>
            </p>
        </div>
        <div class="list_col2">
            <?php echo $taskState; ?>
            <br/>
            <?php
            if( $data->{Globals::FLD_NAME_PROPOSALS_CNT} > 0)
                        {
                            echo "<span class='popovercontent' id='lbl_invited".$data->{Globals::FLD_NAME_TASK_ID}."' 
                                    title='' data-placement='left' 
                                    data-poload='".Yii::app()->createUrl('commonfront/taskproposalspopover')."?".Globals::FLD_NAME_TASK_ID."=".$data->{Globals::FLD_NAME_TASK_ID}."'>".
                                    $data->{Globals::FLD_NAME_PROPOSALS_CNT}." ".CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals'))."</span>";
                        }
                        else
                        {
                            echo $data->{Globals::FLD_NAME_PROPOSALS_CNT}; 
                            echo "&nbsp";
                            echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals'));
                        }
                 ?>       
            
        </div>
    </div>
    <div class="tasklist_cat"> 
        <?php echo $taskCategory; ?>
    </div>
</div>