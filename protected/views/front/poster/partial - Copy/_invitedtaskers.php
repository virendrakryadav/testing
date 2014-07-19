 <?php $invited =  GetRequest::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID});
 	//$profileImageWithPopOver = $i % 4 == 0 ? UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID},'invt_tasker') : UtilityHtml::getUserProfileImageWithPopover( $tasker->{Globals::FLD_NAME_TASKER_ID});
 if( $invited )
 {
     ?>
    <div class="box">
        <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_invited_tasker')); ?></h3></div>
        <div class="box2">
            <div class="controls-row">
                <div class="invited_tasker6"> 
        <?php
        $i = 1 ;
        foreach ($invited as $tasker) 
        {
            ?>
                    <div class=" invitedimg <?php if( $i % 4 == 0 ) echo 'invitedimgright' ?> " >
            
                <!--<img class="<?php if( $i % 4 == 0 ) echo 'invt_tasker' ?>" src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>" width="60" height="60">-->
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