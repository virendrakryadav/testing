<div class="tasklist_box"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($data->{Globals::FLD_NAME_TASK_ID},  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="200" height="200">
                <?php
                 $taskDetailUrl =  CommonUtility::getTaskDetailURI($data->{Globals::FLD_NAME_TASK_ID});
                ?>
                
                
                <h3><a href="<?php echo $taskDetailUrl ?>"><?php echo $data->{Globals::FLD_NAME_TITLE}; ?></a></h3>
                <p class="date"> <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_posted_by')) ?> <a href="#"><?php //echo CommonUtility::getUserFullName($data->{Globals::FLD_NAME_USER_ID}); ?></a></p>
                <p class="date"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_post_date')) ?>: <?php echo date (Globals::DEFAULT_VAL_DATE_FORMATE_D_MMM_Y, strtotime($data->created_at));?></p>
                <p><?php echo $data->description; ?></p>
                <p>------------------------------------------------------------------------------------------------------------------------</p>
                <p> <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_category')) ?>:
                    <?php echo $data->{Globals::FLD_NAME_TITLE}; ?> | 
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')) ?>:10 | 
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_accepted')) ?>:5| 
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_responded')) ?>:2
                </p>
            </div>