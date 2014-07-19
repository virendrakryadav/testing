<script>
    // script for //partial/_profile/_profile2
    $(function() {
    $('#remScnt').live('click', function() 
    { 
        $( "#chatcontainer .removeControl" ).last().remove();
        var num = $('#chatnum').val();
        num--;
        $('#chatcontainer #fields').html('<input type="hidden" id="chatnum" name="totalChatId" value="'+num+'"/>');
        if(num==1)
        {
            $( "#chatcontainer .addRemove #remScnt ").css("display", "none");
            $('#User_chat_id_1_chat_id').next('select').next('.help-block').text('');
            $('#User_chat_id_1_chat_id').next('select').next('.help-block').css("display", "none");
        }
        else
        {
            $( "#chatcontainer .addRemove #remScnt ").css("display", "inline");
        }
    });
    $('#remMobile').live('click', function() { 
        $( "#mobilecontainer .removeControl" ).last().remove();
        var num = $('#mobilenum').val();
        num--;
        $('#mobilecontainer #fields').html('<input type="hidden" id="mobilenum" name="totalMobileId" value="'+num+'"/>');
        if(num==1)
        { 
        $( "#mobilecontainer .addRemove #remMobile ").css("display", "none");
        $( "#mobilecontainer .addRemove #addmoremobile ").css("display", "inline");
        }
        else
        { 
        $( "#mobilecontainer .addRemove #remMobile ").css("display", "inline"); 
         $( "#mobilecontainer .addRemove #addmoremobile ").css("display", "none");
        }
    });
     $('#remEmail').live('click', function() { 
            $( "#emailcontainer .removeControl" ).last().remove();
            var num = $('#emailnum').val();
            num--;
            $('#emailcontainer #fields').html('<input type="hidden" id="emailnum" name="totalEmailId" value="'+num+'"/>');
            if(num==1)
            {
                $( "#emailcontainer .addRemove #remEmail ").css("display", "none");
                $( "#emailcontainer .addRemove #addmore ").css("display", "inline");
            }
            else
            { 
                $( "#emailcontainer .addRemove #remEmail ").css("display", "inline");
                $( "#emailcontainer .addRemove #addmore ").css("display", "none"); 
            }
    });

     $('#remSocial').live('click', function() { 
            $( "#socialcontainer .removeControl" ).last().remove();
            var num = $('#socialnum').val();
            num--;
            $('#socialcontainer #fields').html('<input type="hidden" id="socialnum" name="totalSocialId" value="'+num+'"/>');
            if(num==1)
            {
                $("#socialcontainer .addRemove #remSocial ").css("display", "none");
                $('#User_social_1_social').next('select').next('.help-block').text('');
                $('#User_social_1_social').next('select').next('.help-block').css("display", "none");
            }
            else
            {
                $("#socialcontainer .addRemove #remSocial ").css("display", "inline");
            }
    });
     $('#remCertf').live('click', function() { 
        $( "#certificateCon .removeControl" ).last().remove();
        var num = $('#certfnum').val();
        num--;
        $('#certificateCon #fields').html('<input type="hidden" id="certfnum" name="totalCertfId" value="'+num+'"/>');
        if(num==1)
        {
            $( "#certificateCon .addRemove #remCertf ").css("display", "none");
            $('#User_certificate_id_1_certificate_id').next('select').next('.help-block').text('');
            $('#User_certificate_id_1_certificate_id').next('select').next('.help-block').css("display", "none");
        }
        else
        {
            $( "#certificateCon .addRemove #remCertf ").css("display", "inline");
        }
    });
     $('#remSkills').live('click', function() { 
            $( "#skillscontainer .removeControl" ).last().remove();
            var num = $('#skillsnum').val();
            num--;
            $('#skillscontainer #fields').html('<input type="hidden" id="skillsnum" name="totalSkillsId" value="'+num+'"/>');
            if(num==1)
            {
                $("#skillscontainer .addRemove #remSkills ").css("display", "none");
                $('#User_skills_1_skills').next('select').next('.help-block').text('');
                $('#User_skills_1_skills').next('select').next('.help-block').css("display", "none");
            }
            else
            {
                $( "#skillscontainer .addRemove #remSkills ").css("display", "inline");
            }
    });
 });
</script>
<?php 
$this->widget('bootstrap.widgets.TbTabs', array(
  'id'=>'tabs',  
  'type'=>'tabs',
    'placement'=>'left', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
		array('icon' => 'icon-user','label'=>Yii::t('index_partial_navbar','profile_text'), 'content'=>$this->renderPartial('//partial/_profile', array('model'=>$model),true,false), 'active'=>true),
                array('icon' => 'eye-open','label'=>Yii::t('index_partial_navbar','about_us_text'), 'content'=>$this->renderPartial('//partial/_aboutus', array('model'=>$model,'skills'=> $skills,'countryLocale' => $countryLocale),true,false)),
                array('icon' => 'icon-cog','label'=>Yii::t('index_partial_navbar','setting_text'), 'content'=>$this->renderPartial('//partial/_setting', array('model'=>$model),true,false)),
		array('icon' => 'icon-briefcase','label'=>Yii::t('index_partial_navbar','account_text'), 'content'=>$this->renderPartial('//partial/_account', array('model'=>$model),true,false)),
                array('icon' => 'icon-tags','label'=>Yii::t('index_partial_navbar','score_text'), 'content'=>$this->renderPartial('//partial/_score', array('model'=>$model),true,false)),
                array('icon' => 'icon-time','label'=>Yii::t('index_partial_navbar','transaction_history_text'), 'content'=>$this->renderPartial('//partial/_transactionhistory', array('model'=>$model),true,false)),
                array('icon' => 'icon-time','label'=>Yii::t('index_partial_navbar','portfolio_text'), 'content'=>$this->renderPartial('//partial/_viewportfolio', array('model'=>$model,'task'=>$task),true,false)),
                array('icon' => 'icon-time','label'=>Yii::t('index_partial_navbar','posted_tasks'), 'content'=>$this->renderPartial('//partial/_viewpostedtasks', array('model'=>$model,'task'=>$task),true,false)),
                array('icon' => 'icon-time','label'=>Yii::t('index_partial_navbar','notifications'), 'content'=>$this->renderPartial('//partial/_notifications', array('model'=>$model,'task'=>$task, 'notifications' => $notifications),true,false)),
                array('icon' => 'icon-time','label'=>Yii::t('index_partial_navbar','Notification Settings'), 'content'=>$this->renderPartial('//notification/notificationsetting', array('model'=>$model,'task'=>$task, 'notifications' => $notifications,'notificationsetting'=>$notificationsetting),true,false))
        ),
//                              'events'=>array('shown'=>'js:loadContent')
)); ?>
