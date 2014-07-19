<script>
    $(document).ready(function()
    {
        $(".notify_cont").hover(
            function() 
            {
                $(this).addClass("notify_over");
                var thisId = $(this).attr("id");
                //alert(thisId);
                $(this).children( ".ntf_cont_over" ).addClass("displayBlock"); 
                $(this).children( ".notify_time" ).addClass("displayNone"); 
                var is_seen = $(this).children(".getSeen").children("span").attr("class");
                var alert_id = $(this).children(".getAlertId").children("span").attr("class");
             
                if( is_seen == <?php echo Globals::DEFAULT_VAL_NOTIFICATION_NOTSEEN ?> )
                {
                    $.ajax({
                                    url: '<?php echo Yii::app()->createUrl('index/isseentrue') ?>',
                                    data: { alert_id: alert_id ,is_seen: is_seen },
                                    type: "POST",
                                    dataType: 'json',
                                    error: function () 
                                    {
                                        $("#rootCategoryLoading").removeClass("displayLoading");
                                        $('#loadCategoryForm').html('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                                        // alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    },
                                    success: function (data) 
                                    {
                                        
                                        if(data.status==="success")
                                        {
//                                            $("#"+thisId).removeClass("notSeen");
                                            $("#"+thisId).children(".getSeen").children("span").removeClass(is_seen);
                                            $("#"+thisId).children(".getSeen").children("span").addClass('1');
                                        }
                                        else
                                        {
                                            alert("<?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) ?>");
                                        }
                                    }
                                });
                }
            },
            function() 
            {
                $(this).removeClass("notSeen");
                $(this).removeClass("notify_over");
                $(this).children( ".ntf_cont_over" ).removeClass("displayBlock"); 
                $(this).children( ".notify_time" ).removeClass("displayNone"); 
            }
        );
    });
</script>     
<div class="pro_tab">
    <h2 class="h2"> <?php echo Yii::t('index_profile', 'edit_account_info') ?></h2>
    <?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above', // 'above', 'right', 'below' or 'left'
        'tabs' => array(
            array('label' => Yii::t('index_profile', 'Instant task'), 'content' => $this->renderPartial('//partial/_notificationsinstant', array('model' => $model, 'notifications' => $notifications), true, false), 'active' => true),
            array('label' => Yii::t('index_profile', 'In-person task'), 'content' => $this->renderPartial('//partial/_notificationsinperson', array('model' => $model, 'notifications' => $notifications), true, false)),
            array('label' => Yii::t('index_profile', 'Virtual task'), 'content' => $this->renderPartial('//partial/_notificationsvirtual', array('model' => $model, 'notifications' => $notifications), true, false)),
           // array('label' => Yii::t('index_profile', 'Others'), 'content' => $this->renderPartial('//partial/_addressinfo', array('model' => $model, 'notifications' => $notifications), true, false)),
        ),
    ));
    ?>
</div>