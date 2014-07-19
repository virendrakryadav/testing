<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/jcarousel.connected-carousels.js"></script>
<script>
    function activeTab(id)
    {
        $('.rightbar .sign_bnt').removeClass("activeTab");
        $('#'+id).addClass("activeTab");
    } 
    
</script>

    
    <div class="container content">
        
<!--        <div id="msgConfirmTask" style="display:none" class="flash-success"></div>
        about profile Start here
        <div class="controls-row">
            <div class="profile_img">
                <?php $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                <img src="<?php echo $img ?>"></div>
            <div class="profile_name"><h1><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp<span class="tagline"><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></h1>
                <span class="tagline"><?php echo $model->tagline; ?></span></div>
        </div>-->
        <div class="col-md-3">
            <!--Dashbosrd start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--left nav start here-->
            <!--Previoue tast start here-->
            <div class="box">
                <div class="box_topheading">
                    <div class="ratting"> <?php echo UtilityHtml::getDisplayRating($model->{Globals::FLD_NAME_TASK_DONE_RANK});?></div>
                    
                    <div class="reviews"><img src="<?php echo CommonUtility::getPublicImageUri("like.png") ?>"><a href="#">0 Reviews</a></div>
                </div>
                <div class="box2">
                    <div class="prvlist_box"><div class="tasker_col3"> <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("email-ic.png") ?>"></a>
                    <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("phone-ic.png") ?>"></a>
                    <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("chat-ic.png") ?>"></a>
                    <a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("video-icon.png") ?>"></a>
                </div></div>
                    
                <!--<div class="prvlist_box"> <i class="icon-map-marker"></i>1.5 miles away</div>-->
                    <?php $mobile = CommonUtility::getUserPhoneNumber($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($mobile) && $mobile != '' && $mobile != Array()) 
                    {
                        ?>
<!--                        <div class="prvlist_box"><i class="icon-bell"></i><?php echo $mobile; ?></div>-->
                        <?php
                    }
                    ?>
                    <?php /* $email = CommonUtility::getUserEmail($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($email) && $email != '' && $email != Array()) 
                    {
                        ?>
                        <div class="prvlist_box"><i class="icon-envelope"></i> <?php echo $email ?></div>
                        <?php
                    } */
                    ?>   

                    <?php $workPreferences = CommonUtility::getUserWorkPreferences($model->{Globals::FLD_NAME_USER_ID}); ?>
                    <?php
                    if (isset($workPreferences) && $workPreferences != '' && $workPreferences != Array()) 
                    {
                        ?>
                        <div class="prvlist_box"><i class="icon-time"></i> 
                            <table width="91%" style="float: right;">
                                <?php
                                foreach ($workPreferences as $index => $schedule) 
                                {
                                    ?>
                                    <tr>
                                        <td><label><?php echo $schedule[0][Globals::FLD_NAME_HRS]; ?> </label><?php
                                        $i = 1;
                                        foreach ($schedule as $day) 
                                        {
                                            if ($i == count($schedule)) 
                                            {
                                                echo ucfirst($day[Globals::FLD_NAME_DAYS]);
                                            } 
                                            else 
                                            {
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

                    <div class="prvlist_box"><input name="" type="button" value="Send Request" class="btn-u rounded btn-u-sea display-b text-16 push"/></div>
                </div>
                
            </div>
            <!--Previoue tast Ends here-->


        </div>
        <!--Left side bar ends here-->

        <!--Right side content start here-->
        <div class="col-md-9 sky-form">
            <div id="msgConfirmTask" style="display:none" class="flash-success"></div>
<!--            about profile Start here-->
            <div class="col-md-12 overflow-h no-mrg">
                <div class="profile_img">
                    <?php $img = CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180); ?>
                    <img src="<?php echo $img ?>"></div>
                <div class="profile_name"><h1><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?>&nbsp<span class="tagline"><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span></h1>
                    <span class="tagline"><?php echo $model->tagline; ?></span></div>
            </div>
            <div class="margin-bottom-30"></div>
            <div class="tab-v2">
            <?php
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'About Me')), Yii::app()->createUrl('userprofile/taskeraboutme'), array(
                'beforeSend' => 'function(){$("#rootProfileLoading").addClass("displayLoading");}',
                'complete' => 'function(){$("#rootProfileLoading").removeClass("displayLoading");}',
                'data' => array(Globals::FLD_NAME_USER_ID => $model->{Globals::FLD_NAME_USER_ID}), 'type' => 'POST',
                'success' => 'function(data){activeTab("profileAboutMe"); $(\'#loadprofileData\').html(data); }'), array('id' => 'profileAboutMe', 'class' => 'activeTab sign_bnt', 'live' => false));
            ?>

            &nbsp;
            <?php
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Connections')), Yii::app()->createUrl('userprofile/taskerconnections'), array(
                'beforeSend' => 'function(){$("#rootProfileLoading").addClass("displayLoading");}',
                'complete' => 'function(){$("#rootProfileLoading").removeClass("displayLoading");}',
                'data' => array(Globals::FLD_NAME_USER_ID => $model->{Globals::FLD_NAME_USER_ID}), 'type' => 'POST',
                'success' => 'function(data){activeTab("profiletaskerconnections");$(\'#loadprofileData\').html(data); }'), array('id' => 'profiletaskerconnections', 'class' => 'sign_bnt', 'live' => false));
            ?>
            &nbsp;
            <?php
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Tasks')), Yii::app()->createUrl('userprofile/taskertasks'), array(
                'beforeSend' => 'function(){$("#rootProfileLoading").addClass("displayLoading");}',
                'complete' => 'function(){$("#rootProfileLoading").removeClass("displayLoading");}',
                'data' => array(Globals::FLD_NAME_USER_ID => $model->{Globals::FLD_NAME_USER_ID}), 'type' => 'POST',
                'success' => 'function(data){activeTab("profiletaskertasks");$(\'#loadprofileData\').html(data); }'), array('id' => 'profiletaskertasks', 'class' => 'sign_bnt', 'live' => false));
            ?>
            &nbsp;
            <?php
//            //
////                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'References')), Yii::app()->createUrl('userprofile/taskerreferences'), array(
////                'beforeSend' => 'function(){$("#rootProfileLoading").addClass("displayLoading");}',
////                'complete' => 'function(){$("#rootProfileLoading").removeClass("displayLoading");}',
////                'data' => array(Globals::FLD_NAME_USER_ID => $model->{Globals::FLD_NAME_USER_ID} ), 'type' => 'POST',
////                'success' => 'function(data){activeTab("profiletaskertaskerreferences");$(\'#loadprofileData\').html(data); }'), array('id' => 'profiletaskertaskerreferences', 'class' => 'sign_bnt', 'live' => false));
//            ?>
            &nbsp;
            <?php
//                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Groups')), Yii::app()->createUrl('userprofile/taskergroups'), array(
//                'beforeSend' => 'function(){$("#rootProfileLoading").addClass("displayLoading");}',
//                'complete' => 'function(){$("#rootProfileLoading").removeClass("displayLoading");}',
//                'data' => array(Globals::FLD_NAME_USER_ID => $model->{Globals::FLD_NAME_USER_ID} ), 'type' => 'POST',
//                'success' => 'function(data){activeTab("profiletaskergroups");$(\'#loadprofileData\').html(data); }'), array('id' => 'profiletaskergroups', 'class' => 'sign_bnt', 'live' => false));
            ?>
            <div class=" positionRelativeClass " id="rootProfileLoading">
                <?php echo UtilityHtml::getAjaxLoading("loadTemplateCategoryLoadingImg") ?>
                <div class="box " id="loadprofileData">
                    <?php $this->renderPartial('_taskeraboutme', array('model' => $model)); ?>
                </div>
            </div>
            </div>
        </div>
        <!--Right side content ends here-->
    </div>

