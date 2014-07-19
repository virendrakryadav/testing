<?php //echo CommonScript::loadPopOverHide(); ?>
<?php echo CommonScript::loadTaskFormScript($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION},$task->{Globals::FLD_NAME_TASK_ATTACHMENTS}) ?>

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
 if( $task->bid_duration && $is_public == true )
 {
     ?>
<script>
    $( document ).ready(function() 
    {
        var selected = "<?php echo $task->bid_duration ?>";
        var options = document.getElementById("Task_bid_duration").getElementsByTagName("option");
        var selected_position = $("#Task_bid_duration option[value='"+selected+"']").index();
        for (var i = 0; i < options.length; i++) 
        {
            if( i < selected_position ) 
            {
                options[i].disabled = true;
            }
        }
       
        
    }); 
</script>
<?php
 }
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
<div class="controls-row pdn2">
    <div class="cat_border">
        <div class="cat_type">
            <i class="task_icon2 virtual2"></i><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_virtual_task')) ?>
        </div>
        <div class="cat_heading"><img src="<?php echo CommonUtility::getCategoryImageURI($category[0]->categorylocale->category_id)?>"><?php echo $category[0]->categorylocale->category_name ?>
            <input id="categoryIdHidden" type="hidden" name="category_id_value" value="<?php echo $category[0]->categorylocale->category_id ?>" >
        </div>

        <div class="change_cat">
            <?php
            if (!isset($task->{Globals::FLD_NAME_TASK_ID})) 
            {
//                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadvirtualtask'), array(
//                    'beforeSend' => 'function(){$("#rootCategoryLoading").addClass("displayLoading"); $("#templateCategory").hide();}',
//                    'complete' => 'function(){$("#rootCategoryLoading").removeClass("displayLoading");}',
//                    'success' => 'function(data){activeCategory("loadVirtualTask");$(\'#loadCategory\').html(data);}'), array('id' => 'loadVirtualTaskCategory', 'class' => 'cat_btn','live'=>false));
            
                 echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadvirtualtask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                'data' => array( 'YII_CSRF_TOKEN' =>  Yii::app()->request->csrfToken ), 
                                    'success' => 'function(data){ 
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.virtual);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadVirtualTaskShort");
                                                                }'), 
                            array('id' => 'loadVirtualTaskShotCategory' , 'class' => 'cat_btn','live'=>false)); 
            }
            else 
            {
//                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadvirtualtask'), array(
//                    'beforeSend' => 'function(){$("#rootCategoryLoading").addClass("displayLoading"); $("#templateCategory").hide();}',
//                    'complete' => 'function(){$("#rootCategoryLoading").removeClass("displayLoading");}',
//                    'data'=>array(Globals::FLD_NAME_TASKID => $task->{Globals::FLD_NAME_TASK_ID},Globals::FLD_NAME_CATEGORY_ID=>$category[0]->categorylocale->category_id),Globals::FLD_NAME_TYPE=>'POST',
//                            'success' => 'function(data){activeCategory("loadVirtualTask");$(\'#loadCategory\').html(data);}'), array('id' => 'loadVirtualTaskCategory', 'class' => 'cat_btn','live'=>false));
            
                    echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_change_category')), Yii::app()->createUrl('poster/loadvirtualtask'),
                            array(
                                    'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
                                    'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
                                    'dataType' => 'json', 
                                    'data'=>array(Globals::FLD_NAME_TASKID => $task->{Globals::FLD_NAME_TASK_ID},Globals::FLD_NAME_CATEGORY_ID=>$category[0]->categorylocale->category_id),
                                    Globals::FLD_NAME_TYPE=>'POST',
                                    'success' => 'function(data){ 
                                                                    $(\'#loadPreviewTask\').html(data.previusTask);
                                                                    $(\'#loadCategory\').html(data.virtual);
                                                                    $(\'#templateCategory\').hide();
                                                                    activeCategory("loadVirtualTaskShort");
                                                                }'), 
                            array('id' => 'loadVirtualTaskShotCategory' , 'class' => 'cat_btn','live'=>false)); 
                    
            }
            ?>
        </div>
    </div>
    <div class="controls-row pdn3">
        <div class="step_row">
            <div class="step1 active">
                <span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_1')) ?></span><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_create_your_task')) ?>
            </div>
            <div class="step1"><span class="nubr"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_state_2')) ?></span>
                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_preview')) ?>
            </div>
        </div>
        <!--Instant task left form part start here-->
        <div class="task_boxleft2">
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/title-ic.png"></div>
                <div class="span5 nopadding">
                    <?php //echo $form->labelEx($task, Globals::FLD_NAME_TITLE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_title')))); ?>
                    <div class="span5 nopadding">
                        <?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_TITLE, array('class' => 'span5', 
                            'errorOptions'=>array
                            (
                                'errorCssClass'=>'',
                                'successCssClass'=>'',
                                'validatingCssClass'=>'',
                                'style'=>'display: none',
                                'hideErrorMessage'=>TRUE,
                                'afterValidateAttribute'=>'js:afterValidateAttribute',
                            ),
                            'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_title')),'readonly'=>$is_public)); ?>
                        <?php //echo $form->error($task, Globals::FLD_NAME_TITLE); ?>
                    </div>
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"> <?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_msg')) ?></span>
                </div>
            </div>

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/dic-ic.png"></div>
                <div class="span5 nopadding">
                    <div class="span3  nopadding">
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_DESCRIPTION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_task_description')))); ?>

                    </div>
                    <div class="span2 rightalign ">
                        
                        <span >
                        <?php echo CHtml::ajaxLink(Yii::t('poster_createtask','lbl_browse_template'),Yii::app()->createUrl('poster/browsetemplatecategory'),array('data'=>array(Globals::FLD_NAME_CATEGORY_ID=>$category[0]->categorylocale->category_id ,'formType'=>'v','YII_CSRF_TOKEN' =>  Yii::app()->request->csrfToken),Globals::FLD_NAME_TYPE=>'POST','success' => 'function(data){$(\'#templatdiv\').html(data);showPopup();}'), array('id'=>'templateDetailBrowse','live'=>false)); ?>
                        </span>
                            
                    </div>
                    <div class="span5 nopadding">
                        <?php 
                        if( $is_public == true )
                        {
                            ?>
                            <div class="partfix">
                                <?php
                                echo '<textarea id="Task_description_nonedit" class="span5" name="Task[description_nonedit]" readonly="readonly">'.$task->{Globals::FLD_NAME_DESCRIPTION}.'</textarea>';
                                echo '<textarea id="Task_description_editable" name="Task[description_editable]" placeholder="'.CHtml::encode(Yii::t('poster_createtask', 'txt_task_description_update')).'" rows="4" maxlength="'.Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.'" class="span5 var"></textarea>';
                                echo $form->hiddenField($task, Globals::FLD_NAME_DESCRIPTION ); 
                                ?>
                            </div>
                           <?php
                        }
                        else
                        {
                            echo $form->textAreaControlGroup($task, Globals::FLD_NAME_DESCRIPTION, array('class' => 'span5', 'maxlength' => Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH , 'rows' => 4, 
                                'errorOptions'=>array
                            (
                                'errorCssClass'=>'',
                                'successCssClass'=>'',
                                'validatingCssClass'=>'',
                                'style'=>'display: none',
                                'hideErrorMessage'=>TRUE,
                                'afterValidateAttribute'=>'js:afterValidateAttribute',
                            ),
                                'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_description')))); 
                        }
                    ?>
                        <?php //echo $form->error($task, Globals::FLD_NAME_DESCRIPTION); ?>
                    </div>
                    <div class="span3  nopadding">
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
				$totelstringlength = Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH;
                                echo CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'));
                                $srtlength = strlen($task->{Globals::FLD_NAME_DESCRIPTION});
                                $totelstringlength = $totelstringlength-$srtlength;
                                echo $totelstringlength;
				
				?>
                        </span>
                            </div>
                    </div>
                    <div class="span5 nopadding">
                    
                    <div id="loadAttachment" style="display: <?php if (isset($task->{Globals::FLD_NAME_TASK_ATTACHMENTS}))
                            echo 'block'; ?> ">

                        <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
                        <?php
                        $success = CommonScript::loadAttachmentSuccess('uploadPortfolioImage','takeImagesPortfolio','portfolioimages');
                        $allowArray = array_keys(Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS]);
                        CommonUtility::getUploader('uploadPortfolioImage', Yii::app()->createUrl('poster/uploadtaskfiles'), $allowArray, Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE], Yii::app()->params[Globals::FLD_NAME_MIX_FILE_SIZE], $success);
                        ?>
                       <?php
//    $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
//    'name' => 'uploadPortfolioImage',
//    'uploadAction' => $this->createUrl('poster/uploadtaskfiles', array('fine' => 2)),
//    'pluginOptions' => array(
//    'validation'=>array(
//    'allowedExtensions' => $allowArray
//    )
//    )
//    ));
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

            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/time_ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_TASK_START_DATE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_finish_my_task_till')))); ?>

                    <div class="span3 nopadding">

                        <?php
                        $date = '';
                        $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        if (isset($task->{Globals::FLD_NAME_TASK_START_DATE})) {
                            $date = $task->{Globals::FLD_NAME_TASK_START_DATE};
                           // $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
                            $minDate = $date;
                        }
                        ?><?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'Task[start_date]',
                            'value' => $date,
                            // additional javascript options for the date picker plugin
                            'options' => array(

                                'dateFormat' => Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH,     // format of "2012-12-25"
                                'yearRange' => Globals::DEFAULT_VAL_DATE_YEAR_RANGE,     // range of year
                                'minDate' =>  $minDate, // minimum date
                                'maxDate' => date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH, strtotime('+' . Globals::DEFAULT_VAL_MAX_YEAR_RANGE . ' years')),   // maximum date
                                'showOtherMonths' => true,      // show dates in other months
                                'selectOtherMonths' => true,    // can seelect dates in other months
                                'changeYear' => true,           // can change year
                                'changeMonth' => true,          // can change month
                            ),
                            'htmlOptions' => array(
                            'class' => 'span3',
                                'onkeydown' => 'return false',
                            'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_start')),
                            'readonly' => false,
                             'disabled'=>$is_public,  
                            ),
                        ));
                        ?> 
                        <?php echo $form->error($task, Globals::FLD_NAME_TASK_START_DATE); ?>
                    </div>
                    <div class="span5 nopadding">

                    <div class="span3 nopadding">

                        <?php
                        $date = '';
                        $minDateEnd = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        if (isset($task->{Globals::FLD_NAME_TASK_END_DATE})) {
                            $date = $task->{Globals::FLD_NAME_TASK_END_DATE};
                          //  $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
                            $minDateEnd = $minDate;
                            if( $is_public == true)
                            {
                                $minDateEnd = $date;
                            }
                        }
                        ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'Task[end_date]',
                            'value' => $date,
                            // additional javascript options for the date picker plugin
                            'options' => array(
                               
                                'dateFormat' => Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH,     // format of "2012-12-25"
                                'yearRange' => Globals::DEFAULT_VAL_DATE_YEAR_RANGE,     // range of year
                                'minDate' =>  $minDateEnd, // minimum date    // minimum date
                                'maxDate' => date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH, strtotime('+' . Globals::DEFAULT_VAL_MAX_YEAR_RANGE . ' years')),   // maximum date
                                'showOtherMonths' => true,      // show dates in other months
                                'selectOtherMonths' => true,    // can seelect dates in other months
                                'changeYear' => true,           // can change year
                                'changeMonth' => true, 
                               ),
                            'htmlOptions' => array(
                            'class' => 'span3',
                                'onkeydown' => 'return false',
                            'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'lbl_select_date')),
                            'readonly' => false,
                             //  'disabled'=>$is_public, 
                            ),
                        ));
                        ?> 
                        <?php echo $form->error($task, Globals::FLD_NAME_TASK_END_DATE); ?>
                    </div>

                    <div class="startby span2">
                        <?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_WORK_HRS, array('class' => 'span2 startby nomargin', 'max' => 2, 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_hours')),'readonly'=>$is_public)); ?>
                        <?php //echo $form->textFieldControlGroup($task, 'work_hrs', array('labelOptions' => array("label" => false),'value'=>5,'class'=>'span1 startby nomargin', 'append' => 'Miles', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_hours')))); ?>
                        <?php //echo $form->error($task, Globals::FLD_NAME_WORK_HRS); ?>
                    </div>
                </div>
                    
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_hours')); ?></span>
                </div>
            </div>
            
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/time_ic.png"></div>
                <div class="span5 nopadding">
                    <div class="span3 nopadding">
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_BID_DURATION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_bid_duration')))); ?>
                    </div>
                    <div class="span2 startby">
                        <?php 
                        if(isset($task->bid_start_dt))
                        {
                          //  echo $form->labelEx($task, Globals::FLD_NAME_BID_START_DATE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'lbl_bid_start_date')))); 
                        }?>
                    </div>
                    <div class="span3 nopadding">
                        <?php
                        $date = '';
                        $minDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH);
                        if ($task->bid_duration) 
                        {
                            $date = $task->bid_duration;
                            $date = CommonUtility::changeDateFormate(Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH, $date);
                            
                        }
                        $bidDuration = Globals::getbidDurationArray();
                        echo $form->dropDownList($task, Globals::FLD_NAME_BID_DURATION, $bidDuration, array(
                           // 'disabled'=>$is_public,
                            'empty' => Yii::t('poster_createtask','txt_task_select_bid_duration'),
                               //'options' => array('1 day' => array('disabled' => true),'15 days' => array('disabled' => true)),
                            'class' => 'span3'));
                        ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_BID_DURATION); ?>
                    </div>
                    <div class="startby span2">
                        <?php
                        if(isset($task->bid_start_dt))
                        {
//                            echo '<input  class="span2" type="text" name="bid_start_dt" value="'.Yii::app()->dateFormatter->format(Globals::DEFAULT_VAL_DATE_FORMATE_D_MMM_Y,strtotime($task->bid_start_dt)).'" disabled="disabled">';
//                            echo $form->checkBox($task, 'bid_start_today',array('disabled'=>$is_public)); 
//                            echo $form->labelEx($task, 'bid_start_today', array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_bid_start_today')))); 
                        }?>
                    </div>
                    
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_bid_close_date')); ?></span>
                </div>
            </div>
            
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/card-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_PRICE, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_i_am_willing_to_pay')))); ?>
                    <div class="span2 nopadding"> 
                        <?php 
                            if(!isset($task->{Globals::FLD_NAME_PRICE}))
                            {
                                $task->{Globals::FLD_NAME_PRICE} = 0;
                            }
                            else 
                            {
                                $task->{Globals::FLD_NAME_PRICE} = intval($task->{Globals::FLD_NAME_PRICE});
                            }
                        ?>
                        <?php echo $form->textFieldControlGroup($task, Globals::FLD_NAME_PRICE, array('labelOptions' => array("label" => false),'class'=>'pricein', 'prepend' => Globals::DEFAULT_CURRENCY,'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_bid_enter_amount')),'readonly'=>$is_public)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_PRICE); ?>
                    </div>
                    <div class="span3">
                        <?php
                        if(!isset($task->{Globals::FLD_NAME_PAYMENT_MODE}))
                        {
                            $task->{Globals::FLD_NAME_PAYMENT_MODE} = Globals::DEFAULT_VAL_B;
                        }
                        $payment_mode = array(Globals::DEFAULT_VAL_F => CHtml::encode(Yii::t('poster_createtask', 'txt_fixed_price')), Globals::DEFAULT_VAL_B => CHtml::encode(Yii::t('poster_createtask', 'txt_open_bid')));
                        ?>
                        <?php echo $form->radioButtonList($task, Globals::FLD_NAME_PAYMENT_MODE, $payment_mode, array(
						'template'=>"<label class='radio spanweek'>{input}{label}</label>",
						'class' => '','disabled'=>$is_public,)); ?>
                        <?php echo $form->error($task, Globals::FLD_NAME_PAYMENT_MODE); ?>
                    </div> 
<!--                    <div class="span5 nopadding"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_this_task_requires')); ?> <span class="blue_text">$25 </span>&ndash; <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_do_you_have')); ?> <span class="blue_text">$25</span> <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_to_use_on_this_task')); ?></div>-->
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_enter_offer_amount')); ?></span>
                </div>
            </div>
            <div class="controls-row cnl_space">
                <div class="name_ic"><img src="../images/vis-ic.png"></div>
                <div class="span5 nopadding">
                    <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_posting_visibility')))); ?>
                        <?php $payment_mode = array('1' => CHtml::encode(Yii::t('poster_createtask', 'txt_public_visible_to_everyone')), '0' => CHtml::encode(Yii::t('poster_createtask', 'txt_private_only_candidates_i_invite_can_respond'))); ?>
                    <div class="span5 nopadding">
                        <?php echo $form->radioButtonList($task, Globals::FLD_NAME_IS_PUBLIC, $payment_mode, array(
						'template'=>"<label class='radio visibil'>{input}{label}</label>",
							'checkValue' => '1', 'class' => '','disabled'=>$is_public,)); ?>                   
                        <?php echo $form->error($task, Globals::FLD_NAME_IS_PUBLIC); ?>
                    </div> 
                </div>
                <div class="help"><i class="icon-question-sign"></i>
                    <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_task_visible_to')); ?></span>
                </div>
            </div>
            <div id="advanceOptionHeader" onclick="slideIt();" class="h5 bottom_border"><img src="../images/portlet-collapse-icon.png"><span class="showoption"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_show')); ?> </span></div>
            <div id="advanceOption"  >
                <div class="controls-row cnl_space">
                    <div class="name_ic"><img src="../images/map-ic.png"></div>
                    <div class="span5 nopadding">
                        <?php
                        $locationList = array();
                        $location_check = false;
                        $disabled_check = false;
                        $selectedLocation = '';
                        if (isset($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION})) {
                            $location_check = true;
                            if( $is_public == true)
                            {
                                $disabled_check = true;
                            }
                            $locationList = CommonUtility::getLocationDropdownData($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION});
                            if ($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_C) {
                                $selectedLocation = $taskLocation->{Globals::FLD_NAME_COUNTRY_CODE};
                            } elseif ($taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} == Globals::DEFAULT_VAL_R) {
                                $selectedLocation = $taskLocation->{Globals::FLD_NAME_REGION_ID};
                            }
                        }
                        ?>
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_PREFERRED_LOCATION, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_need_tasker_at')))); ?>
                     <div class="span5 nopadding">
                     <label class='checkbox visibil'>
					 <?php echo $form->checkBox($task, Globals::FLD_NAME_PREFERRED_LOCATION_CHECK, array('onchange' => 'setLocation(this.id);', 'checked' => $location_check,'disabled'=>$disabled_check,)); ?>
                        <?php echo $form->labelEx($task, Globals::FLD_NAME_PREFERRED_LOCATION_CHECK, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_i_prefer_tasker_from_certain_location')))); ?>
                        </label>
                        </div>
                        <div id="select_preferred_location" >
                        <?php $preferred_location = array(Globals::DEFAULT_VAL_C => CHtml::encode(Yii::t('poster_createtask', 'txt_country')), Globals::DEFAULT_VAL_R => CHtml::encode(Yii::t('poster_createtask', 'txt_regions'))); ?>
                        <?php
                                echo $form->radioButtonList($taskLocation, Globals::FLD_NAME_IS_LOCATION_REGION, $preferred_location,
                                array('checkValue' => '1',
                                    'disabled'=>$disabled_check, 
                                    'class' => '343',
									'separator' => " ",
                                    'template'=>"<label class='radio spanweek'>{input}{label}</label>",
                                    'onChange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'data' => array(Globals::FLD_NAME_IS_LOCATION_REGION => 'js:this.value'),
                                    "url" => CController::createUrl('poster/ajaxgetpreferredlocationlist'),
                                    "success" =>    "function(response)
                                                        {
                                                            $('#multilocation').html(response);
                                                        }"
                                       ,
									    )),
                                ));
                        ?>           
                        <div id="multilocation" class="span5 nopadding">
                        <?php
                            $locationList = "";
                            $locations = array();
                            $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_location'));
                            $taskSelectedLocations = CommonUtility::getTaskPreferredLocations($task->{Globals::FLD_NAME_TASK_ID});
                            //print_r($taskSelectedLocations);
                            if($taskSelectedLocations)
                            {
                                if($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_C)
                                {
                                    $locations = CommonUtility::getCountryList();
                                    
                                    $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
                                }
                                elseif($taskSelectedLocations[Globals::FLD_NAME_IS_LOCATION_REGION] == Globals::DEFAULT_VAL_R)
                                {
                                    $locations = CommonUtility::getRegionsList();
                                    $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_region'));
                                }
                                $locationList = $taskSelectedLocations[Globals::FLD_NAME_LOCATIONS];
                            }
                            if($disabled_check == true)
                            {
                              //  print_r($locationList);
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS."_1", $locationList, $locations, array(
                                'data-placeholder' => $placeholder,
                                'disabled'=>$is_public,
                                'options' => array( 'displaySelectedOptions' => false, ),
                                'class'=>'span5'
                                ));
                                if($locationList != '')
                                {
                                    $locationList = array_flip($locationList);
                                    $locations = array_diff_key($locations, $locationList);
                                    $locationList = '';
                                }
                            }
                            echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_LOCATIONS, $locationList, $locations, array(
                            'data-placeholder' => $placeholder,
                            'options' => array(
                                'displaySelectedOptions' => false,
                                ),
                                'class'=>'span5'
                            ));
                        ?>
                        </div>
                            <?php echo $form->error($taskLocation, Globals::FLD_NAME_LOCATION_TYPE); ?>
                        </div>
                    </div>
                    <div class="help"><i class="icon-question-sign"></i>
                        <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_enter_preferred_tasker_location')); ?></span>
                    </div>
                </div>
                <?php
                if(isset($skill) && $skill!='' )
                {
                  $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
                }
                if (!empty($skills)) 
                {
                    ?>
                    <div class="controls-row cnl_space">
                        <div class="name_ic"><img src="../images/skils-ic.png"></div>
                        <div class="span5 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_request_specific_skills')))); ?>
                            <?php
                                    $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});
                                    if($is_public == true)
                                    {
                                        echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS."_1", $taskSelected, $skills, array(
                                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                                        'disabled'=>$is_public,
                                        'options' => array( 'displaySelectedOptions' => false,),
                                        'class'=>'span5'
                                        ));
                                        if( $taskSelected != '' )
                                        {
                                            $taskSelected = array_flip($taskSelected);
                                            $skills = array_diff_key($skills, $taskSelected);
                                            $taskSelected = '';
                                        }
                                    }
                                    echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS, $taskSelected, $skills, array(
                                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                                        'options' => array('displaySelectedOptions' => false ),
                                        'class'=>'span5'
                                    ));
                            ?>
                        </div>
                        <div class="help"><i class="icon-question-sign"></i>
                            <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_desired_skills')); ?></span>
                        </div>
                    </div>
                    <?php
                    }
                    $taskSelectedQuestion = CommonUtility::getSelectedQuestion($task->{Globals::FLD_NAME_TASK_ID});
                    $question = CHtml::listData($questions, Globals::FLD_NAME_QUESTION_ID, 'categoryquestionlocale.question_desc');
                    if (!empty($question)) 
                    {
                        ?>
                        <div class="controls-row cnl_space">
                        <div class="name_ic"><img src="../images/question-ic.png"></div>
                        <div class="span5 nopadding">
                            <?php echo $form->labelEx($task, Globals::FLD_NAME_IS_PUBLIC, array('label' => CHtml::encode(Yii::t('poster_createtask', 'txt_set_up_questions')))); ?>
                            <?php
                                if($is_public == true)
                                {
                                     echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_CAT_QUESTION."_1", $taskSelectedQuestion, $question, array(
                                    'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_question')),
                                    'disabled'=>$is_public,
                                    'options' => array('displaySelectedOptions' => FALSE,),
                                    'class'=>'span5'
                                    ));
                                    if( $taskSelectedQuestion != '' )
                                    {
                                        $taskSelectedQuestion = array_flip($taskSelectedQuestion);
                                        $question = array_diff_key($question, $taskSelectedQuestion);
                                        $taskSelectedQuestion = '';
                                    }

                                }
                                echo Chosen::multiSelect(Globals::FLD_NAME_MULTI_CAT_QUESTION, $taskSelectedQuestion, $question, array(
                                'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_question')),
                               
                                'options' => array('displaySelectedOptions' => FALSE,),
                                'class'=>'span5'
                                ));
                            ?>
                        </div>
                        <div class="help"><i class="icon-question-sign"></i>
                            <span class="helpdesk"><?php echo CHtml::encode(Yii::t('poster_createtask', 'help_category_questions')); ?></span>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
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
                    if( $taskLocation->{Globals::FLD_NAME_IS_LOCATION_REGION} )
                    {
                        echo $form->hiddenField($taskLocation, Globals::FLD_NAME_IS_LOCATION_REGION);
                    }
                } 
                if (isset($task->{Globals::FLD_NAME_TASK_ID})) 
                {
                    $action = "poster/editvirtualtask";
                    echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID);
                } 
                else
                {
                    $action = "poster/savevirtualtask";
                }
                $successUpdate = '
                                    if(data.status==="success"){

//                                        $.ajax({
//                                                url      : "' . Yii::app()->createUrl('poster/loadvirtualtaskpreview') . '",
//                                                data     : { "taskId": data.tack_id , "category_id": data.category_id },
//                                                type     : "POST",
//                                                dataType : "html",
//                                                cache    : false,
//                                                success  : function(html)
//                                                {
//                                                    loadPreview();
//                                                    jQuery("#loadpreview").html(html);
//                                                    jQuery("#templateCategory").hide();
//                                                },
//                                                error:function(){
//                                                    jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
//                                                    //alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
//                                                }
//                                            });

                                    }else{
                                    $.each(data, function(key, val) {
                                      //  afterAjaxSubmit( key, val);
                                                    $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                    $("#virtualtask-form #"+key+"_em_").show();
                                                    });
                                    }
                                    ';
                                    CommonUtility::getAjaxSubmitButton(
                                                CHtml::encode(Yii::t('poster_createtask', 'lbl_save')), 
                                                Yii::app()->createUrl($action), 'sign_bnt', 'useraddTask', $successUpdate);
            ?>
            </div>
        <div class="ancor">
            <?php
                $successUpdatePublish = '
                                        if(data.status==="success"){

                                            $.ajax({
                                                    url      : "' . Yii::app()->createUrl('poster/loadvirtualtaskpreview') . '",
                                                    data     : { "taskId": data.tack_id , "category_id": data.category_id },
                                                    type     : "POST",
                                                    dataType : "html",
                                                    cache    : false,
                                                    success  : function(html)
                                                    {
                                                        
                                                       // alert(html);
                                                        jQuery("#loadpreview").html(html);                                                        
                                                        loadPreview();
                                                    },
                                                    error:function(){
                                                    jQuery("#loadpreview").html("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '"); 
                                                        //alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                });

                                           }else{
                                           $.each(data, function(key, val) {
                                                        $("#virtualtask-form #"+key+"_em_").text(val);                                                    
                                                        $("#virtualtask-form #"+key+"_em_").show();
                                                        });
                                           }
                                    ';
            if ($task->{Globals::FLD_NAME_VALID_FROM_DT} == Globals::DEFAULT_VAL_VALID_FROM_DT) 
            {
                CommonUtility::getAjaxSubmitButton(
                                                    CHtml::encode(Yii::t('poster_createtask', 'lbl_publish')),
                                                    Yii::app()->createUrl($action) . "?publish=1", 'ancor_bnt2', 'uservirtualPublishTask', $successUpdatePublish
                                                    );
            }
            ?>
        </div></div>
    </div>
</div>
<?php $this->endWidget(); ?>
<style>
   
.partfix textarea {resize:none; border:none;margin:0}
.var {
    margin: -2px 0 10px !important;
}
</style>


