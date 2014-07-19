<?php $userImg = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_FROM_USER_ID},Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35);
$userName = CommonUtility::getUserFullName($data->{Globals::FLD_NAME_FROM_USER_ID}) ;?>
<div class="replymess1">
<?php //echo  $data->inboxuser->{Globals::FLD_NAME_IS_DELETE} ?>
    <?php //echo  $data->inboxuser->{Globals::FLD_NAME_MSG_FLOW} ?>
    <div class="replymess2">
        <div class="f-left col-md-1 msgchkbox" style="display: none;"><?php echo CHtml::checkBox('deleteMsg[]', '' , array('value' => $data->{Globals::FLD_NAME_MSG_ID})); ?>
        </div><img src="<?php echo $userImg ?>" class="message-thumb"><?php echo $userName ?><span class="date"> <?php echo CommonUtility::formatedViewDate($data->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
    <div class="replymess3"><?php echo $data->{Globals::FLD_NAME_BODY} ?></div>
    <div class="clr"></div>
    <?php 
    if(isset($data->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
    {
    ?>
        <div class="attachment-cont">
        <?php
        $attachments = CJSON::decode($data->{Globals::FLD_NAME_TASK_ATTACHMENTS});
        // print_r($data->{Globals::FLD_NAME_TASK_ATTACHMENTS});
         foreach($attachments as $file)
         {
            ?>
            <div class="attachment-row">
            <div class="attachment-col"><img class="attach-thumb" src="<?php echo  CommonUtility::getPublicImageUri('attach-file.png') ?>"></div>
            <div class="attachment-col"><a href="<?php echo Yii::app()->createUrl( "commonfront/filedownload?filename=".$file[Globals::FLD_NAME_FILE]) ?>"><?php echo CommonUtility::getImageDisplayName($file[Globals::FLD_NAME_FILE]); ?></a></div>
            <div class="attachment-col sortby-noti"><a  href="<?php echo Yii::app()->createUrl( "commonfront/filedownload?filename=".$file[Globals::FLD_NAME_FILE]) ?>"><img class="attach-thumb" src="<?php echo CommonUtility::getPublicImageUri('attach-download.png') ?>"></a></div>
            </div>
            <?php
            }
        ?>
        </div>
    <?php
    }
    ?>
    <!--<div class="reply_col3"><a class="interested_btn" href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark_as_read'))?></a></div>-->
    <div class="clr"></div>
</div>
<div class="clr"></div>