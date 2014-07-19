 <?php $invited =  GetRequest::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
 	//$profileImageWithPopOver = $i % 4 == 0 ? UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID},'invt_tasker') : UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID});
 if( $invited )
 {
     ?>
    <div class="panel panel-default margin-bottom-20 sky-form">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="#collapseThree" data-parent="#accordion" data-toggle="collapse">
            <?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_invited_tasker')); ?>
            <span class="accordian-state"></span>
            </a>
            </h3>
        </div>
        <div class="panel-collapse collapse in" id="collapseThree">
            <div class="panel-body no-pdn">
                <div class="col-md-12 no-mrg"> 
        <?php
        $i = 1 ;
        foreach ($invited as $tasker) 
        {
            ?>
                    <div class="invited_tasker pdn-auto2 <?php if( $i % 4 == 0 ) echo 'invitedimgright' ?> " >
            
                <!--<img class="<?php //if( $i % 4 == 0 ) echo 'invt_tasker' ?>" src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>" width="60" height="60">-->
				<?php 
				$profileImageWithPopOver = ($i % 4 == 0) ? UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID},'left','invt_tasker') : UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID});
				
					echo $profileImageWithPopOver;
					?>
				
                    </div>
            <?php
            $i++;
		}
        	?>
                </div>
            </div>
        </div>
    </div>
<?php
 }
?>          