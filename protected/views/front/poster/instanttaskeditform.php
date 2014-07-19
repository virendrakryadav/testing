<?php
$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;

$srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
$totelstringlength = $totelstringlength-$srtlength;                   
?>
<?php echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadTaskFormScript($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION},$task->{Globals::FLD_NAME_TASK_ATTACHMENTS}) ?>
<?php echo CommonScript::loadRemainingCharScript("Task_description_editable","wordcount",$totelstringlength) ?>
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'virtualtask-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
Yii::import('ext.chosen.Chosen');
 $is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
 echo $form->hiddenField($task, Globals::FLD_NAME_TASKER_ID_SOURCE);
 echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE);
 

?>
<script>
    $( document ).ready(function() 
    {
        $("#Task_end_date").change(function(){
            var options = document.getElementById("Task_bid_duration").getElementsByTagName("option");
            var end_date = $("#Task_end_date").val();
            var date1 = new Date();
            var date2 = new Date(end_date);
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            
            options[2].disabled = false;
            options[3].disabled = false;
            options[4].disabled = false;
            if( diffDays < 7 )
            {
                options[2].disabled = true;
                options[3].disabled = true;
                options[4].disabled = true;
            }
            if( diffDays < 15 )
            {
                options[3].disabled = true;
                options[4].disabled = true;
            }
            if( diffDays < 30 )
            {
                options[4].disabled = true;
            }
        //   alert(diffDays);
        });
        
    }); 
</script>
<?php echo $form->hiddenField($taskLocation,  Globals::FLD_NAME_LOCATION_GEO_AREA); ?>

<?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LATITUDE); ?>
<?php echo $form->hiddenField($taskLocation, Globals::FLD_NAME_LOCATION_LONGITUDE); ?>
<input type="hidden" name="category_id_value" value="<?php echo $category[0]->categorylocale->category_id ?>" >
<div class="controls-row pdn2">
   
    <div class="controls-row pdn3">
       
        <!--Instant task left form part start here-->
        <div class="task_editbox">
            

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="<?php echo CommonUtility::getPublicImageUri("dic-ic.png") ?>"></div>
                <div class="span4 nopadding">
                    <div class="span3  nopadding">
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_description')))); ?>

                    </div>
                    <div class="span2 rightalign ">
                        
                        <span >
                        <?php //echo CHtml::ajaxLink(Yii::t('poster_createtask','lbl_browse_template'),Yii::app()->createUrl('poster/browsetemplatecategory'),array('data'=>array(Globals::FLD_NAME_CATEGORY_ID=>$category[0]->categorylocale->category_id ,'formType'=>'v'),Globals::FLD_NAME_TYPE=>'POST','success' => 'function(data){$(\'#templatdiv\').html(data);showPopup();}'), array('id'=>'templateDetailBrowse','live'=>false)); ?>
                        </span>
                            
                    </div>
                    <div class="span4 nopadding">
                        <?php 
                        if( $is_public == true )
                        {
                            ?>
                            <div class="partfix">
                                <?php
                                echo $task->{Globals::FLD_NAME_DESCRIPTION};
                                echo '<input type="hidden" id="Task_description_nonedit" value="'.$task->{Globals::FLD_NAME_DESCRIPTION}.'" >';

                                echo '<textarea id="Task_description_editable" name="Task[description_editable]" placeholder="'.CHtml::encode(Yii::t('poster_createtask', 'txt_task_description_update')).'" rows="4" maxlength="'.Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.'" class="span4 var"></textarea>';
                                echo $form->hiddenField($task, Globals::FLD_NAME_DESCRIPTION ); 
                                ?>
                            </div>
                           <?php
                        }
                        else
                        {
                            echo $form->textArea($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'span5', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 
                        }
                    ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_DESCRIPTION); ?>
                    </div>
                    <div class="span2  nopadding">
                        <div  id="addAttachmentHead" onclick="slideImages();" class="span3 adattach"> 
                            <a>
                                <i class="icon-plus-sign"></i>
                                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_add_attachment')) ?>
                            </a>
                        </div>
                       
                    </div>
                    <div class="span2 rightalign ">
                        <div class="span2 wordcount3">
                        <span id="wordcount">
                           
                             <?php
			
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                             
                               
                                echo $totelstringlength;
				
				?>
                        </span>
                            </div>
                    </div>
                    <div class="span4 nopadding">
                    
                    <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                        <?php //echo $form->error($task,'image'); ?>
                        <div id="takeImagesPortfolio" class="" style="display: <?php
                        if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; else
                            echo 'none';
                        ?> ">
                                 <?php
                                 if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})) {
                                     echo UtilityHtml::getAttachmentsOnEdit($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}, $model->profile_folder_name ,$task->{Globals::FLD_NAME_TASK_ID});
                                 }
                                 ?>

                        </div>

                    </div>
                </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_description_msg')) ?></span>
                </div>
            </div>

              
            
     
     
        </div>
        
   
        
    </div>
  
      <div class="controls-row cnl_space">
        <div class="btn_cont">
            <div class="ancor">
        <?php
        if($is_public)
        {
            echo $form->hiddenField($task, Globals::FLD_NAME_IS_PUBLIC);
            echo $form->hiddenField($task, Globals::FLD_NAME_PAYMENT_MODE);
            echo $form->hiddenField($task, Globals::FLD_NAME_TASKER_ID_SOURCE);
        }
        if (isset($task->{Globals::FLD_NAME_TASK_ID})) 
        {
            $action = "poster/editinstanttask";
            echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
        } 
        else 
        {
            $action = "poster/saveinstanttask";
        }
        $successUpdate = '
                                if(data.status==="success"){
                                    
                                   window.location.href = window.location.href;

                                   }else{
                                   $.each(data, function(key, val) {
                                                $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                $("#virtualtask-form #"+key+"_em_").show();
                                                });
                                   }
                                ';
CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_save')), Yii::app()->createUrl($action), 'sign_bnt', 'useraddTask', $successUpdate);
?>
            </div>
        <div class="ancor">
            <?php
            $successUpdatePublish = '
                                        if(data.status==="success"){

                                           window.location.href = window.location.href;

                                           }else{
                                           $.each(data, function(key, val) {
                                                        $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                        $("#virtualtask-form #"+key+"_em_").show();
                                                        });
                                           }
                                    ';

            if ($task->{Globals::FLD_NAME_VALID_FROM_DT} == Globals::DEFAULT_VAL_VALID_FROM_DT ) 
            {
                CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_publish')), Yii::app()->createUrl($action) . "?publish=1", 'ancor_bnt2', 'userPublishTask', $successUpdatePublish);
            }
            ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
