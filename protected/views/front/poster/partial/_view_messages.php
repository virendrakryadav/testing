<?php $userImg = CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_FROM_USER_ID},Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180);
$userName = CommonUtility::getUserFullName($data->{Globals::FLD_NAME_FROM_USER_ID}) ;?>
<div class="rowselector"><div class="message_cont">
<div class="messege_thumb"><img src="<?php echo $userImg ?>"></div>
<div class="message_area">
    <p class="tasker_name"><a target="_blank" href="<?php echo CommonUtility::getTaskerProfileURI( $data->{Globals::FLD_NAME_FROM_USER_ID} ) ?>"><?php echo $userName ?></a> <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></p>
<p class="message_text"><?php echo $data->{Globals::FLD_NAME_BODY} ?></p>

<?php 
if($task->{Globals::FLD_NAME_CREATER_USER_ID} == Yii::app()->user->id )
{
    if($data->{Globals::FLD_NAME_FROM_USER_ID} != $task->{Globals::FLD_NAME_CREATER_USER_ID} )
    {
    ?>
<!--    <div class="reply_text "><span class="mile_away">
            <a onclick="replyMessage('<?php echo $data->{Globals::FLD_NAME_FROM_USER_ID} ?>' , '<?php echo $data->{Globals::FLD_NAME_TASK_ID} ?>' , '<?php echo $userName ?>' , '<?php echo $userImg ?>')" href="#">Reply</a>
        </span> </div>-->

<div class="reply_text " id="markRead<?php echo $data->{Globals::FLD_NAME_MSG_ID}?>" class="reply_text "  ><span class="mile_away">
<?php 
          //  print_r($data);
//echo $data->inboxuser->{Globals::FLD_NAME_IS_READ};

if($data->{Globals::FLD_NAME_IS_PUBLIC} != Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE)
{
        
    if($data->inboxuser->{Globals::FLD_NAME_IS_READ} == Globals::DEFAULT_VAL_MSG_IS_NOT_READ)
    {
        ?>
        <a href="javascript:void(0)" onclick="markRead( '<?php echo $data->{Globals::FLD_NAME_MSG_ID}?>' ,'<?php echo $data->{Globals::FLD_NAME_TO_USER_IDS}?>' )" >Mark Read</a>
        <?php
    }
    else
    {
        ?>
        <a href="javascript:void(0)" onclick="markUnread( '<?php echo $data->{Globals::FLD_NAME_MSG_ID}?>' ,'<?php echo $data->{Globals::FLD_NAME_TO_USER_IDS}?>' )" >Mark Unread</a>
        <?php
    }
}
?>
    </span> </div>
<?php
    }
    ?>
    
    
    <?php  
    if($data->{Globals::FLD_NAME_IS_PUBLIC} == Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE)
    {
        ?>
        <!--<div class="reply_text "><a href="#">Make Private</a></div>-->
        <?php
    }
    else
    {
        ?>
        <div id="publicMsgId<?php echo $data->{Globals::FLD_NAME_MSG_ID}?>" class="reply_text " onclick="makeMsgPublic( '<?php echo $data->{Globals::FLD_NAME_MSG_ID}?>' )"><a href="javascript:void(0)">Make Public</a></div>
        <?php
    }
    
}
?>
</div>
</div></div>