<?php
$item_count = $userNotification->getItemCount();
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $userNotification,
        'itemView' => '_user_notification',
        'summaryText' => '',
        'emptyText' => '<div class="alert alert-danger fade in"><i class="fa fa-hand-o-right"></i> '.Yii::t('user_alert','msg_no_notification_available').'</div>',
    ));
?>   
</div>
<?php
if($item_count >= Globals::DEFAULT_DISPLAY_TOTAL_NOTIFICATION_COUNT)
{
?>
<div class="col-md-12 margin-bottom-10 align-center"><a href="<?php echo Yii::app()->createUrl('notification/index');?>" class="color-orange"><?php echo Yii::t('user_alert','View All');?></a></div>
<?php
}
?>