<div class="controls-row pagetopbg"> 

    <div class="page-container page_padding">
        <div id="msgConfirmTask" style="display:none" class="flash-success"></div>
        <!--about profile Start here-->
        <div class="controls-row">
            <div class="profile_img">
                <?php $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                <img src="<?php echo $img ?>"></div>
            <div class="profile_name"><h1><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp<span class="tagline"><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></h1>
                <span class="tagline"><?php echo $model->tagline; ?></span></div>
        </div>
        <!--about profile Ends here-->

        <!--Left side bar start here-->
        <div class="leftbar">
            <!--Previoue tast start here-->
             <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/loadcategoryformtoupdate'), array(
                'beforeSend' => 'function(){$("#rootCategoryLoading").addClass("displayLoading");}',
            'complete' => 'function(){$("#rootCategoryLoading").removeClass("displayLoading");}',
                 'success' => 'function(data){backForm();$(\'#loadCategoryForm\').html(data); $(\'#templateCategory\').show(); }'), array('id' => 'profileAboutUs', 'class' => 'sign_bnt', 'live' => false)); ?>
            <div class="box">
                <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_new_user')) ?></h3></div>
                <div class="box2">
                <!--<div class="prvlist_box"> <i class="icon-map-marker"></i>1.5 miles away</div>-->
                    <?php $mobile = CommonUtility::getUserPhoneNumber($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($mobile) && $mobile != '' && $mobile != Array()) 
                    {
                        ?>
                        <div class="prvlist_box"><i class="icon-bell"></i><?php echo $mobile; ?></div>
                        <?php
                    }
                    ?>
                    <?php $email = CommonUtility::getUserEmail($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($email) && $email != '' && $email != Array()) {
                        ?>
                        <div class="prvlist_box"><i class="icon-envelope"></i> <?php echo $email ?></div>
                        <?php
                    }
                    ?>
                    <?php $workPreferences = CommonUtility::getUserWorkPreferences($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($workPreferences) && $workPreferences != '' && $workPreferences != Array()) {
                        ?>
                        <div class="prvlist_box"><i class="icon-time"></i> 
                            <table width="91%" style="float: right;">
                        <?php
                        foreach ($workPreferences as $index => $schedule) {
                            ?>
                                    <tr>
                                        <td><label><?php echo $schedule[0][Globals::FLD_NAME_HRS]; ?> </label><?php
                                    $i = 1;
                                    foreach ($schedule as $day) {
                                        if ($i == count($schedule)) {
                                            echo ucfirst($day[Globals::FLD_NAME_DAYS]);
                                        } else {
                                            echo ucfirst($day[Globals::FLD_NAME_DAYS]) . ',';
                                        }
                                        $i++;
                                    }
                                    ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>
                            </table>
                        </div>
    <?php
}
?>
                </div>
            </div>
            <!--Previoue tast Ends here-->


        </div>
        <!--Left side bar ends here-->

        <!--Right side content start here-->
        <div class="rightbar2">
            <div class="box">
                <div class="box_topheading"><h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_name_prepand')) ?>&nbsp<?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp</h3></div>
                <!--tasker specialties start here-->
                <div class="controls-row pdn">
                    <h3 class="h3"><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'lbl_specialties')) ?></h3>

                    
                    <?php echo UtilityHtml::userSkills($model->{Globals::FLD_NAME_USER_ID} ,"span4 nopadding specialties", Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN ) ?>
                </div>
                
             <h3 class="h3" ><?php echo CHtml::encode(Yii::t('poster_confirmtask', 'Recent Works')) ?> </h3>
             
             <?php
             $youHired= GetRequest::getTaskerHiredByUser($model->{Globals::FLD_NAME_USER_ID});
               
                if($youHired)
                {
                    ?>
             <div class="controls-row pdn ">
                   <div class="span4 nopadding specialties">
                       <ul><li>You hired <?php echo count($youHired); ?></li></ul>
                            </div>
                
                </div>
             <div class="controls-row pdn ">
                   <div class="span4 nopadding specialties">
                       <ul>
                    <?php
                    
                    foreach( $youHired as $recentTask )
                    {
                        ?>
                           <li><?php echo $recentTask->task->{Globals::FLD_NAME_TITLE} ?> , <?php echo Globals::DEFAULT_CURRENCY.$recentTask->task->{Globals::FLD_NAME_PRICE} ?></li>
                      
                    <?php
                    }
                }
             ?>
              </ul>
                            </div>
                
                </div>
                <div class="controls-row pdn ">
                   
                <?php  
                
                
                $recentTasks = GetRequest::getTaskerRecentTasks($model->{Globals::FLD_NAME_USER_ID} , 3);
                if($recentTasks)
                {
                    foreach( $recentTasks as $recentTask )
                    {
                        ?>
                        <div class="span3 nopadding">
                            <div class="portfolio_cont"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($recentTask->{Globals::FLD_NAME_TASK_ID},  '241x251') ?>"> <div class="over"></div>
                                <div class="portfolio_title"><?php echo $recentTask->task->{Globals::FLD_NAME_TITLE} ?></div>
                                <div class="portfolio_detail"><input type="submit" value="Detail" name="" class="detail_bnt">	</div>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
                   

                </div>
                <!--tasker specialties ends here-->

                <!--task detail  start here-->


                <div class="controls-row pdn" id="ratingtab">



                </div>
                <!--task detail ends here-->


            </div>
        </div>
        <!--Right side content ends here-->
    </div>

