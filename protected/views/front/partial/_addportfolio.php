<script>
    /*$(document).ready(function()
{
                $('#Task_description').keyup(function(){
                $('#Task_description_em_').css('display','none');
                if($('#Task_description').val().match(/^[ \s]/)){
                                $('#Task_description_em_').css('display','block');
                                $('#Task_description_em_').html('Space not allowed');
                                 return false;
                }
        });
});*/
    function removeVideo()
    {
        $( "#uploadPortfolioVideo" ).parent().css("display","block");
        $("#uploadPortfolioVideo").css("display","block");
        $("#takeVideosPortfolio").css("display","none");
    }

</script>
<?php echo CommonScript::loadPopOverHide(); ?>
<div class="controls-row  nopadding"><div class="span7 nopadding"><h4></h4></div><div class="span2 space_top">
        <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_view_my_portfolio')), Yii::app()->createUrl('user/userviewportfolio'), array('success' => 'function(data){$(\'#addContent\').html(data);}'), array('id' => 'viewPortfolioLinktop')); ?>
    </div></div>


<div class="controls-row" style="width:97.7%;"> 
    <?php
    /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'portfolio-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        //'validateOnChange' => true,
        //'validateOnType' => true,
        ),
            ));
    ?>

    <div class="controls-row">
        <div class="span4 nopadding">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_TITLE, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_name')))); ?>
            <div class="span4 nopadding">
            <?php echo $form->textField($task, Globals::FLD_NAME_TITLE, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_name')))); ?>
            <?php echo $form->error($task, Globals::FLD_NAME_TITLE); ?>
        </div></div>

    </div>
    <div class="controls-row">
        <div class="span4 nopadding">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_CREATOR_ROLE, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_type')))); ?>
            <?php $portfolioType = array('t' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_tab_task_done_by_you')), 'p' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_tab_task_for_you'))); ?>
<div class="span6 nopadding">          
  <?php echo $form->radioButtonList($task, Globals::FLD_NAME_CREATOR_ROLE, $portfolioType, array('class' => 'radio' , 'template' => '<label class="radio spanweek">{input}{label}</label>')); ?>
            <?php echo $form->error($task, Globals::FLD_NAME_CREATOR_ROLE); ?>
        </div>   </div>

    </div>
    <div class="controls-row">
        <div class="span6 nopadding">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_description')))); ?>
           <div class="span6 nopadding"> <?php echo $form->textArea($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'span7', 'maxlength' => 4000, 'rows' => 5, 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_description')))); ?>
            <?php echo $form->error($task, Globals::FLD_NAME_DESCRIPTION); ?>
        </div></div>
    </div>

    <div class="controls-row">
        <div class="span4 nopadding">
            <?php echo $form->label($task, CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_upload_photo'))); ?>
            <?php
            $success = "
                            $('#takeImagesPortfolio').css('display','block');
                            var divId = fileName.split('.')[0];
                            $('#takeImagesPortfolio').append( '<div class=\"imagesPreview '+divId+'\"></div>' );  
                            $('#takeImagesPortfolio .'+divId ).append( '<img  src=\"" . Globals::FRONT_USER_VIEW_TEMP_PATH . "'+fileName+'\" />' );  
                            $('#takeImagesPortfolio .'+divId ).append( '<input type=\"hidden\" name=\"portfolioimages[]\" value=\"'+fileName+'\" />' );      
                            $('#takeImagesPortfolio .'+divId ).append( '<a onclick=\"$(this).parent().remove();\">remove</a> ' );      
                            $('#uploadPortfolioImage .qq-upload-list').html('');
                                                                
                        ";
            CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('user/uploadportfolioimage'), Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES], Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIN_FILE_SIZE], $success);
            ?>
            <?php //echo $form->error($task,'image'); ?>
            <div id="takeImagesPortfolio" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                echo 'block'; else
                echo 'none'; ?> ">
            <?php
            if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                $images = CommonUtility::getPortfolioAttachmentUrlFromJson($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, 'image');
                $imageCount = 0;
                if (isset($images) && $images != '') {
                    foreach ($images as $index => $image) {
                        $imageKey = str_replace($model->profile_folder_name . "/", '', $index);
                        ?>
                            <input type="hidden" name="portfolioimagestoremove[]" value="<?php echo $imageKey; ?>" />
                            <div class="imagesPreview">
                                <img  src="<?php echo $image; ?>" />
                                <input type="hidden" name="portfolioimages[]" value="<?php echo $imageKey; ?>" />
                                <a onclick="$(this).parent().remove();"><?php echo CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_upload_remove')); ?></a>
                            </div>
            <?php
            $imageCount++;
        }
    }
}
?>
            </div>
        </div>
        <div class="span4 nopadding">
                <?php
                $videoUrl = '';
                $videoName = '';
                if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                    $videoArr = CommonUtility::getPortfolioAttachmentUrlFromJson($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, Globals::DEFAULT_VAL_VIDEO_TYPE);
                    //$videoUrl=$videoArr[0];
                    $videoCount = 1;
                    foreach ($videoArr as $index => $video) {
                        if ($videoCount == 1) {
                            $videoUrl = $video;
                            $videoName = str_replace($model->profile_folder_name . "/", '', $index);
                        }
                        $videoCount++;
                    }
                }
                ?>
            <?php 
            //echo $videoName;
            echo $form->label($task, CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_upload_video'))); ?>
            <div  style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})  &&  $videoName != '')
                echo 'none'; else
                echo 'block'; ?> " >
            <?php
            $success = "
                                                    $('#takeVideosPortfolio').css('display','block');
                                                    $('#takeVideosPortfolio #portfoliovideo').remove();
                                                    $('#takeVideosPortfolio').append( '<input id=\"portfoliovideo\" type=\"hidden\" name=\"portfoliovideo\" value=\"'+fileName+'\" />' );      
                                                    $('#uploadPortfolioVideo .qq-upload-list').html('');
                                                    $('#uploadPortfolioVideo').css('display','none');
                                            ";
            CommonUtility::getUploader('uploadPortfolioVideo', Yii::app()->createUrl('user/uploadportfoliovideo'), Yii::app()->params['allowVideos'], Yii::app()->params['maxfileSize'], Yii::app()->params['minfileSize'], $success);
            ?>
            </div>
            <div id="takeVideosPortfolio" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})  && $videoName != '')
                    echo 'block'; else
                    echo 'none'; ?> ">
                <?php
                echo CHtml::ajaxLink('<i class="icon-facetime-video"></i>' . CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_play_video')), Yii::app()->createUrl('index/playvideo') . "?url=" . $videoUrl, array(
                    'data' => array('video' => 'js:$("#portfoliovideo").val()', 'path' => Globals::FRONT_USER_VIEW_TEMP_PATH),
                    'success' => 'function(data){ $(\'#playportfolioVideo\').css("display","block");$(\'#playportfolioVideo\').html(data);}'), array('id' => 'playVideoPortfolio', 'class' => 'playVideo'));
                ?>
                <a id="uploadPortfolioVideoRemoveProfile" onclick="removeVideo()" ><?php echo CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_upload_remove')); ?></a>
                <input id="portfoliovideo" type="hidden" name="portfoliovideo" value="<?php echo $videoName ?>" />
                <input  type="hidden" name="portfoliovideoremove" value="<?php echo $videoName ?>" /> 
            </div>
        </div>
    </div>
    

    
<div class="controls-row">
<div class="span4 nopadding">

  <div class="span4 nopadding">
<?php
$date = '';
if (isset($task->{Globals::FLD_NAME_TASK_FINISHED_ON})) {
     $date = $task->{Globals::FLD_NAME_TASK_FINISHED_ON};
     $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_M_D_Y_SLASH, $date);
}
?>
            <?php echo $form->labelEx($task, Globals::FLD_NAME_TASK_FINISHED_ON, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_date')))); ?>
          <div class="span4 nopadding">  <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'Task[task_finished_on]',
                'value' => $date,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                ),
                'htmlOptions' => array(
                    'class' => 'span3',
                    'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_date')),
                ),
            ));
            ?> 
            <?php echo $form->error($task, Globals::FLD_NAME_TASK_FINISHED_ON); ?>
        </div>  </div>
  <div class="span4 nopadding">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_WORK_HRS, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_hours')))); ?>
          <div class="span4 nopadding">  <?php echo $form->textField($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_hours')))); ?>
            <?php echo $form->error($task, Globals::FLD_NAME_WORK_HRS); ?>
        </div></div>
  <div class="span4 nopadding ">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_PRICE, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_price')))); ?>
            <div class="span4 nopadding "><?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_PRICE, array('labelOptions' => array("label" => false), 'class'=>'pricein', 'prepend' => '$', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_price')))); ?>
            <?php echo $form->error($task, Globals::FLD_NAME_PRICE); ?>			
        </div></div>

</div>
<div class="span4 nopadding">
  <div class="span4 nopadding">
            <?php echo $form->labelEx($task, Globals::FLD_NAME_REF_DONE_BY_NAME, array('label' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_task_reference_name')))); ?>
            <div class="span4 nopadding">
            <?php echo $form->error($task, Globals::FLD_NAME_REF_DONE_BY_NAME); ?>
<?php echo $form->textField($task, Globals::FLD_NAME_REF_DONE_BY_NAME, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_reference_name')))); ?>
            </div>
            <div class="span4 nopadding">
            <?php echo $form->error($task, Globals::FLD_NAME_REF_DONE_BY_EMAIL); ?>
            <?php echo $form->textField($task, Globals::FLD_NAME_REF_DONE_BY_EMAIL, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_reference_email')))); ?>
            </div>
            <div class="span4 nopadding">

<?php echo $form->textField($task, Globals::FLD_NAME_REF_DONE_BY_PHONE, array('class' => 'span3', 'placeholder' => CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_task_reference_phone')))); ?>
                <?php echo $form->error($task, Globals::FLD_NAME_REF_DONE_BY_PHONE); ?>
            </div>
        </div>
        
  <div class="span3 nopadding">
    <div class="btn_cont">
        <div class="ancor">

<?php
$location = 'user/addportfolio';
if (isset($task->{Globals::FLD_NAME_TASK_ID}))
    {
        $location = 'user/updateportfolio';
        echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID); 
    }
            $successUpdate = '
                                if(data.status==="save_success_message"){
                                $.ajax({
                                            url      : "' . Yii::app()->createUrl('user/userviewportfolio') . '",
                                            type     : "POST",
                                            dataType : "html",
                                            cache    : false,
                                            success  : function(html)
                                            {
                                                jQuery("#addContent").html(html);
                                                $("#msgPortfolio").html("' . CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_portfolio_success_msg')) . '");
                                                $("#msgPortfolio").css("display","block");
                                            },
                                            error:function(){
                                                alert("' . CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_portfolio_request_failed')) . '");
                                            }
                                        });

                                   }else{
                                   $.each(data, function(key, val) {
                                                $("#portfolio-form #"+key+"_em_").text(val);                                                    
                                                $("#portfolio-form #"+key+"_em_").show();
                                                });
                                   }
                                ';
            CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_btn_update')), Yii::app()->createUrl($location), 'sign_bnt', 'useraddPortfolio', $successUpdate);
            ?>
        </div>
        <div class="ancor">
            <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_btn_cancel')), Yii::app()->createUrl('user/userviewportfolio'), array('success' => 'function(data){$(\'#addContent\').html(data);}'), array('id' => 'viewPortfolioLink' . uniqid(), 'class' => 'cnl_btn2')); ?>
            <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
        </div>
    </div></div> 
        </div>
</div>

<!--    <div class="span4 nopadding">
    <div class="btn_cont">
        <div class="ancor">

<?php
//$location = 'user/addportfolio';
//if (isset($task->{Globals::FLD_NAME_TASK_ID}))
//    {
//        $location = 'user/updateportfolio';
//        echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID); 
//    }
//            $successUpdate = '
//                                if(data.status==="save_success_message"){
//                                $.ajax({
//                                            url      : "' . Yii::app()->createUrl('user/userviewportfolio') . '",
//                                            type     : "POST",
//                                            dataType : "html",
//                                            cache    : false,
//                                            success  : function(html)
//                                            {
//                                                jQuery("#addContent").html(html);
//                                                $("#msgPortfolio").html("' . CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_portfolio_success_msg')) . '");
//                                                $("#msgPortfolio").css("display","block");
//                                            },
//                                            error:function(){
//                                                alert("' . CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_portfolio_request_failed')) . '");
//                                            }
//                                        });
//
//                                   }else{
//                                   $.each(data, function(key, val) {
//                                                $("#portfolio-form #"+key+"_em_").text(val);                                                    
//                                                $("#portfolio-form #"+key+"_em_").show();
//                                                });
//                                   }
//                                ';
//            CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_btn_update')), Yii::app()->createUrl($location), 'sign_bnt', 'useraddPortfolio', $successUpdate);
            ?>
        </div>
        <div class="ancor">
            <?php // echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'txt_btn_cancel')), Yii::app()->createUrl('user/userviewportfolio'), array('success' => 'function(data){$(\'#addContent\').html(data);}'), array('id' => 'viewPortfolioLink' . uniqid(), 'class' => 'cnl_btn2')); ?>
            <?php //echo CHtml::submitButton(CHtml::encode(Yii::t('blog','Update')),array('class'=>'update_bnt')); ?>
        </div>
    </div></div>-->
            <?php $this->endWidget(); ?>
    <div id="playportfolioVideo" class="window" style="display: none"></div>
</div>