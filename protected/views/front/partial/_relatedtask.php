<div class="panel-heading">
    <h3 class="panel-title">
        <a href="#collapseFour" data-parent="#accordion" data-toggle="collapse">
            <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_related_task')); ?> 
            <span class="accordian-state"></span>
        </a>
    </h3>
</div>
<div class="panel-collapse collapse in" id="collapseFour">
    <div class="panel-body no-pdn">
        <div class="col-md-12 pdn-auto2">
        <?php
        if($relatedTask)
        {
            foreach ($relatedTask as $value) 
            {//echo $value->task_id;
                ?>
                <div class="prvlist_box">
                    <p><?php echo ucfirst($value[Globals::FLD_NAME_TITLE]); ?></p>
                    <p class="invt_done"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_posted_by')); ?> 
                        <a href="<?php echo CommonUtility::getTaskerProfileURI($value[Globals::FLD_NAME_CREATER_USER_ID]) ?>">
                            <?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster( $model->{Globals::FLD_NAME_USER_ID}) ?>
                        </a> 
                    <?php echo CommonUtility::agoTiming($value[Globals::FLD_NAME_CREATED_AT]); ?>&nbsp;<?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_ago')); ?> 
                    </p>
                </div>
                <?php
            }
        }
        ?>
        </div>
    </div>
</div>