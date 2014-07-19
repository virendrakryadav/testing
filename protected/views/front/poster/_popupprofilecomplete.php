<style>
    .popup_profile {
    margin: 30px;
    width: 80%;
}

.message {
    float: right;
    margin: 10px 15px;
    color: red;
}
.profile_link {
    border: 1px solid #DEDEDE;
    box-shadow: 0 0 6px 0 #CCCCCC;
    margin: auto;
    padding: 8px 0;
    text-align: center;
    width: 30%;
}
.profile_popup {
    height: 45%;
    width: 35%;
}
.taskdetailpopup1 {
    left: 32%;
    margin: auto;
}
</style>

<div id="profile_popup" class="popup_profile">
   <img src="<?php echo Yii::app()->getBaseUrl()?>/images/icon_alert_large.png">
   <div id="message" class="message">
       <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_profile_address'));?>
   </div>
</div>
<div id="myprofile_link" class="profile_link">
    <a href="<?php echo Yii::app()->getBaseUrl()?>/index/updateprofile"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_myprofile'));?></a>
</div>
