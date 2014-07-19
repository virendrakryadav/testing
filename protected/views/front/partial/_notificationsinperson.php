<div class="notify_wrap">
    <div class="items">
        <!--Notifications start here-->
            <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $notifications->getInpersonTaskNotification(),
                   'itemView' => '//partial/_notificationslist',
                 'emptyText' => Yii::t('notifications','msg_no_inperson_notification'),
                ));
                ?>
        <!--Notifications ends here-->                     
    </div>
</div>  