<?php 

$attachments=json_decode($attachments); //brings array of objects.

//print_r($attachments);

$files = new CArrayDataProvider($attachments, array(
     'id'=>'files_data_array',
    'sort'=>array(
        'attributes'=>array(
             'type', 'file', 'upload_on','filesize','uploadedby'
        ),
        'defaultOrder'=>'upload_on DESC',

    ),
    'keyField' => 'file_id',
    'pagination'=>array(
        'pageSize'=>5,
    ),
));



?>
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'filesgrid-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>
<div onclick="$('#validationSuccessMsg').parent().fadeOut();" style="display: none" class="alert alert-success fade fade-in-alert">
    <button onclick="$('#validationSuccessMsg').parent().fadeOut();" class="close4" type="button">×</button>
    <div id="validationSuccessMsg" >

    </div>
    
</div>
<div onclick="$('#validationErrorMsg').parent().fadeOut();" style="display: none" class="alert alert-danger fade fade-in-alert">
    <button onclick="$('#validationErrorMsg').parent().fadeOut();" class="close4" type="button">×</button>
    <div id="validationErrorMsg" >

    </div>
    
</div>
<div class="col-md-12 no-mrg">
                    <div class="project-search">
                    <div class="action-col">
             
                       <?php 
                        echo CHtml::dropDownList('filesAction', '', array('delete' => 'Delete'), 
                             array('prompt'=>'Action',
                                        'ajax' => array(
                                        'type' => 'POST',
                                             'dataType' => "json",
                                        'url' => CController::createUrl('poster/bulkactionuploadedfile'),
                                            'beforeSend' => 'function(){
                                           ischeckedFiles();}',
                                          
                                        'success' => "function(data){
                                            
                                            var msgSuccess = '<p><i class=\"fa fa-hand-o-right\"></i> '+data.fileDeleted+' file(s) deleted successfully.</p>';
                                            var msgError  = '<p><i class=\"fa fa-hand-o-right\"></i> '+data.fileNotDeleted+' file(s) could not be deleted. These file(s) may not be uploaded by you.</p>';
                                          
                                            if(data.fileNotDeleted > 0 )
                                            {
                                                alertErrorMessage(msgError, 'validationErrorMsg');
                                            }
                                            
                                            if(data.fileDeleted > 0 )
                                            {
                                                alertErrorMessage(msgSuccess, 'validationSuccessMsg');
                                            }
                                            
                                            selectUserFiles();
                                            getTaskerDetails();
                                            $('#filesAction').val('');
                                            
                                         }",
                                        'data' => 'js:jQuery(this).parents("form").serialize()'),
                                 'options' => array(''=>array('selected'=>true)),'class' => 'form-control'));
                        ?>
                    </div>
                    <div class="storage-row">

                    <div class="storage-col2">Storage</div>
                    <div class="storage-col">
                    <h3 id='spaceQuotaUsed' class="heading-xs">2.5gb</h3>
                    <div class="progress progress-u progress-xs">
                    <div id='spaceQuotaUsedBar' class="progress-bar progress-bar-dark" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                    </div>
                    </div></div>
                    <div class="storage-col3"><?php echo LoadSetting::getSettingValue(Globals::SETTING_KEY_SPACE_QUOTA_ALLOWED); ?>MB</div>
                    </div>
                        <div class="storage-col4"><button type="button" onclick="displayAddFilesController();" class="btn-u rounded btn-u-sea"><i class="fa fa-plus"></i> Add</button></div>
                    <div class="clr"></div></div>
</div>
<div id="taskDetailAddFiles"  style="display: none" class="col-md-12 no-mrg overflow-h ">


    <?php //echo $form->label($task, CHtml::encode(Yii::t('poster_createtask', 'lbl_upload_attachment'))); ?>
    <?php
    $success = CommonScript::loadAttachmentSuccess('uploadProposalAttachments','getAttachmentsPropsal','proposalAttachments');
    $success .= " 
                     $(\"#fileUploadBtn\").show(); ";
   
   
    CommonUtility::getUploader('uploadProposalAttachments', Yii::app()->createUrl('poster/uploadtaskfiles'), '', '', '' , $success);
    ?>
   <div class="col-md-12 no-mrg" id="getAttachmentsPropsal"></div>
   <div id='fileUploadBtn' style="display: none" class="col-md-12  overflow-h mrg-top">
   <?php
    echo $form->hiddenField($task,Globals::FLD_NAME_TASK_ID);
    echo   CHtml::hiddenField('currentaskers','',array('id' => 'currentaskers2'));

   $successUpdate = '                                    
                                            if(data.status==="save_success_message")
                                            {
                                                $("#getAttachmentsPropsal").html("");
                                                $("#taskDetailAddFiles").hide();
                                                selectUserFiles();
                                                 getTaskerDetails();
                                                 $("#uploadProposalAttachments_totalFileSizeUsed").val(0);
                                                 $("#fileUploadBtn").hide();
                                            }                                   
                                            else
                                            {
                                                    if(data.status==="error")
                                                    {
                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                    }
                                                    else
                                                    {
                                                        $.each(data, function(key, val) 
                                                        {
                                                                    $("#filesgrid-form #"+key+"_em_").text(val);                                                    
                                                                    $("#filesgrid-form #"+key+"_em_").show();
                                                        });
                                                    }
                                            }
                                        ';
                                        CommonUtility::getAjaxSubmitButton('Upload', Yii::app()->createUrl('poster/uploadfileintaskdetail'), 'btn-u rounded btn-u-sea', 'uploadsFiles', $successUpdate);

?>
   </div>
</div>
                    <div class="clr"></div>

                    <div class="table-responsive">
                        <?php 
                        
                        $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'files-grid-project-live',
                            'summaryText' => 'Found {count} files.',
                                'dataProvider'=>$files,
                             'ajaxUpdate' => true,

                                'columns'=>array(
                                                    array(
                                                        'class'=>'CCheckBoxColumnUniform',
                                                        'selectableRows' => 1000,
                                                        'id'=>'file',
                                                       // 'value'=>'UtilityHtml::getFileNameInGrid( $data->{Globals::FLD_NAME_TASKER_ID} ,$data->{Globals::FLD_NAME_IS_POSTER},$data->{Globals::FLD_NAME_UPLOADED_BY},$data->{Globals::FLD_NAME_FILE})',
                                                        'value'=>'$data->{Globals::FLD_NAME_FILE}'
                                                    ),
                                                array(
                                                        'header' => 'Type',
                                                        'type'=>'html',
                                                        'name' => 'type',
                                                        'value'=>'UtilityHtml::getFileTypeImage($data->{Globals::FLD_NAME_TYPE})',
                                                        'htmlOptions' => array(
                                                            'class' => 'grid_status',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'grid_status'
                                                        ),
                                                    ),
                                              array(
                                                        'header' => 'File',
                                                        'type'=>'html',
                                                        'name' => 'file',
                                                        //'value'=>'CommonUtility::getImageDisplayName($data->{Globals::FLD_NAME_FILE})',
                                                        'value'=>'UtilityHtml::getFileNameInGrid( $data->{Globals::FLD_NAME_TASKER_ID} ,$data->{Globals::FLD_NAME_IS_POSTER},$data->{Globals::FLD_NAME_UPLOADED_BY},$data->{Globals::FLD_NAME_FILE})',
                                                        'htmlOptions' => array(
                                                            'class' => 'grid_status',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'grid_status'
                                                        ),
                                                    ),
                                                    array(
                                                        'header' => 'File Size',
                                                        'type'=>'html',
                                                        'name' => 'filesize',
                                                        'value'=>'CommonUtility::getFormatSizeUnitsFromBytes($data->{Globals::FLD_NAME_FILESIZE})',
                                                        'htmlOptions' => array(
                                                            'class' => 'center',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'center'
                                                        ),
                                                    ),
                                                  array(
                                                        'header' => 'Uploaded By',
                                                        'type'=>'html',
                                                        'name' => 'uploadedby',
                                                        'value'=>'CommonUtility::getUserFullName($data->{Globals::FLD_NAME_UPLOADED_BY})',
                                                        'htmlOptions' => array(
                                                            'class' => 'center',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'center'
                                                        ),
                                                    ),
                                                    array(
                                                        'header' => 'Uploaded On',
                                                        'type'=>'html',
                                                        'name' => 'upload_on',
                                                        'value'=>'CommonUtility::getDateTimeFromTimeStamp($data->{Globals::FLD_NAME_UPLOAD_ON})',
                                                        'htmlOptions' => array(
                                                            'class' => 'center',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'center'
                                                        ),
                                                    ),
                                                    array(
                                                        'header' => 'Actions',
                                                        'type'=>'html',
                                                        'name' => 'upload_on',
                                                        'value'=>'UtilityHtml::getActionsTaskDetailFile( $data->{Globals::FLD_NAME_FILE_ID}, $data->{Globals::FLD_NAME_TASK_ID},$data->{Globals::FLD_NAME_TASKER_ID} ,$data->{Globals::FLD_NAME_IS_POSTER},$data->{Globals::FLD_NAME_TASK_TASKER_ID} ,  $data->{Globals::FLD_NAME_FILE},$data->{Globals::FLD_NAME_UPLOADED_BY} , "files-grid-project-live")',
                                                        'htmlOptions' => array(
                                                            'class' => 'center',
                                                        ),
                                                        'headerHtmlOptions'=>array(
                                                             'class' => 'center'
                                                        ),
                                                    ),
                                                                   
                                                ),
                        )); 
                        
                        ?>

                    </div>
                    <?php $this->endWidget(); ?>