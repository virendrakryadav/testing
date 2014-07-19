<div class="notify_wrap">
    <div class="items">
        <!--Notifications start here-->
            <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $notifications->getVirtualTaskNotification(),
                    'itemView' => '//partial/_notificationslist',
                   // 'template' => '{summary} {sorter} {items} {pager}',
                    'emptyText' => Yii::t('notifications','msg_no_virtual_notification'),
                ));
                ?>
        <!--Notifications ends here-->                     
    </div>
</div>  