<?php CommonScript::manageCategoryTemplate(); 
Yii::import('ext.chosen.Chosen');
?>
<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<div class="search-form">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableClientValidation'=>true,
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true
	),
//        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 

echo Yii::log("errors saving SomeModel: " . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING, __METHOD__);
$templateVal = '';
if(isset($locale->{Globals::FLD_NAME_TASK_TEMPLATES}) && !empty($locale->{Globals::FLD_NAME_TASK_TEMPLATES}))
{
	$allvalue = json_decode($locale->{Globals::FLD_NAME_TASK_TEMPLATES});
	$templateVal = $allvalue;
	//$templateVal = $allvalue->certificateVal;
	//echo'<pre>';
        //print_r($allvalue);
	//print_r($templateVal[0]->certificate);
	//echo count($templateVal);
}
?>

	<div class="row-fluid form-horizontal">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <?php if(!$model->isNewRecord){
        echo $form->hiddenField($locale, 'category_id');
            } ?>
	<div class="control-group">
            <?php echo $form->labelEx($locale,'category_name',array('class'=>'control-label','label'=>Yii::t('admin_category_form','category_name_text'))); ?>
            <div class="controls">
            <?php echo $form->textField($locale,'category_name',array('size'=>60,'maxlength'=>250,'class'=>'span6',)); ?>
            <span class="help-inline"><?php echo $form->error($locale,'category_name'); ?></span>
            </div>		
	</div>
        <div class="control-group">
            <?php echo $form->labelEx($locale,'category_image',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                if(!empty($locale->category_image))
                {
                $imageName =  Globals::BASE_URL.'/'.Globals::CATEGORY_IMAGE_UPLOAD_PATH.$locale->category_image;
                }
                else
                {
                $imageName = Globals::DEFAULT_CATEGORY_IMAGE;
                }
                ?>
                <div class="span6">  
                    <img id="imagePriview" src="<?php echo $imageName;?>" height="50" width="50">
                    <input type="hidden" id="imageNameHidden" name="imageNameHidden">
                    <input type="hidden" id="path" value="<?php echo Globals::BASH_URL.'/'.Globals::FRONT_USER_PORTFOLIO_TEMP_PATH; ?>">
                    <?php
                    //echo Yii::app()->getBaseUrl();
                    $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                                    'id'=>'uploadFileNew',
                                    'config'=>array(
                                        'action'=>Yii::app()->createUrl('category/updateimage'),
                                        'allowedExtensions'=>Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES],//array("jpg","jpeg","gif","exe","mov" and etc...
                                        'sizeLimit'=>Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE],// maximum file size in bytes
                                        //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                                        'onComplete'=>"js:function(id, fileName, responseJSON){                                                                                
                                                $('.qq-upload-list').remove();
                                                var path = document.getElementById('path').value;
                                                document.getElementById('imagePriview').src = path+fileName;
                                                document.getElementById('imageNameHidden').value = fileName;
                                            }",                                  
                                        )
                            )); 
                    ?>
                </div>
            </div>
        </div>
            <div class="control-group">
		<?php echo $form->labelEx($locale,'parent_id',array('class'=>'control-label','label'=>Yii::t('admin_category_form','parent_id_text'))); ?>
			<div class="controls">
                                <select id="CategoryLocale_parent_id" name='CategoryLocale[parent_id]' class ="span6" >
                                    <option value=''><?php echo Yii::t('admin_category_form','no_parent_category_text')?></option>
                                    <?php echo UtilityHtml::getCategoryListNasted($model->category_id,$model->parent_id); ?>
                                </select>
                                <?php
                                    
        //                    $list = array();
        //                    echo $form->dropDownList($locale, 'parent_id', $list, 
        //                    array('prompt'=>'--Select Parent Category--', 'class' => 'span6'));
                                ?>
              
                        <span class="help-inline"><?php echo $form->error($locale,'parent_id'); ?></span>
                        </div>		
            </div>
	<div class="control-group">
		<?php echo $form->labelEx($locale,'category_priority',array('class'=>'control-label','label'=>Yii::t('admin_category_form','category_priority_text'))); ?>
		<div class="controls">
                <?php echo $form->numberField($locale,'category_priority',array('size'=>3,'maxlength'=>3,'class'=>'span6', 'value'=>$this->maxPriority)); ?>
                <span class="help-inline">
		<?php echo $form->error($locale,'category_priority'); ?>
                </span>
                </div>		
	</div>

	<div class="control-group">
		<?php echo $form->label($locale,'category_status',array('label'=>Yii::t('admin_category_form','category_status_text'))); ?>
                <div class="controls">
		<?php echo $form->radioButtonList($locale, 'category_status',array('1'=>Yii::t('admin_category_form','active_text'),'0'=>Yii::t('admin_category_form','inactive_text')),array('template'=>'<label class="radio">{label}<div class="radio"><span>{input}</span></div></label>'));?>
		<span class="help-inline"><?php echo $form->error($locale,'category_status'); ?></span>
                </div>
	</div>       
        <div class="control-group"> <?php echo $form->labelEx($model,'is_virtual' ,array('class'=>'control-label','label'=>Yii::t('admin_category_form','task_type_text'))); ?>
            <div class="controls">
             <?php echo $form->checkBox($model,'is_virtual',array('value'=>1,'uncheckValue'=>0,'Select_box span6')).Yii::t('admin_category_form','virtual_text'); ?>
             <?php echo $form->checkBox($model,'is_inperson',array('value'=>1,'uncheckValue'=>0,'Select_box span6')).Yii::t('admin_category_form','inperson_text'); ?>
             <?php echo $form->checkBox($model,'is_instant',array('value'=>1,'uncheckValue'=>0,'class' => 'Select_box span6')).Yii::t('admin_category_form','instant_text'); ?>
            </div>
        </div>
        
        <div>
        <?php ?>
        </div>
        <!--   min price   -->
        <div class="control-group">
            <?php echo $form->labelEx($model,'default_min_price',array('class'=>'control-label','label'=>Yii::t('admin_category_form','Minimum Price ($)'))); ?>
            <div class="controls">
		<?php echo $form->textField($model,'default_min_price',array('size'=>60,'maxlength'=>250,'class'=>'span6',)); ?>
		<span class="help-inline"><?php echo $form->error($model,'default_min_price'); ?></span>
            </div>		
	</div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'default_max_price',array('class'=>'control-label','label'=>Yii::t('admin_category_form','Maximum Price ($)'))); ?>
            <div class="controls">
		<?php echo $form->textField($model,'default_max_price',array('size'=>60,'maxlength'=>250,'class'=>'span6',)); ?>
		<span class="help-inline"><?php echo $form->error($model,'default_max_price'); ?></span>
            </div>		
	</div>   
        <div class="control-group">
            <?php echo $form->labelEx($model,'default_estimated_hours',array('class'=>'control-label','label'=>Yii::t('admin_category_form','Estimated Hours'))); ?>
            <div class="controls">
                <?php echo $form->textField($model,'default_estimated_hours',array('size'=>3,'maxlength'=>3,'class'=>'span6')); ?>
		<span class="help-inline"><?php echo $form->error($model,'default_estimated_hours'); ?></span>
            </div>		
	</div>   
            
            
           <?php
           $title = "";
           $description = "";
           if(!empty($locale->task_templates))
            {
           $template = json_decode($locale->task_templates,true);
           $title = $template[0]['title'];
           $description = $template[0]['desc'];
            }
           ?>

            <div class="control-group">
            <h3 class="temp-section">Template</h3>
            <div class="row-fluid">
						
                <div id="templateCon" >
                <?php

                if(!empty($templateVal))
                {
                        $count = 1; 
                        $totelrecord = count($templateVal);
                        for($templateField = 0;$templateField<$totelrecord;$templateField++)
                        { ?>
                   <div class="row-fluid removeControl" id="template<?php echo $count;?>">
                    <div class="control-group">
                        <?php echo $form->labelEx($locale,'[category_id_'.$count.']'.'title',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <div class="span6 nopadding">
                            <?php echo $form->textField($locale,'[category_id_'.$count.']'.'title',array('size'=>60,'maxlength'=>250,'class'=>'span6','value'=>$templateVal[$templateField]->title)); ?>
                            <span class="help-inline"><?php echo $form->error($locale,'title'); ?></span>
                            </div>                                                                
                            <div class="span1 nopadding">
                                <a href="javascript:void(0)" id="addmore" onclick="addmoreCatTemplate(<?php echo $count; ?>);" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>                               
                                <a href="javascript:void(0)" id="remTmpl" onclick="deleteTemplate(<?php echo $count; ?>)">                    
                                <img src="<?php echo Yii::app()->request->baseUrl;?>/images/remove-btn.png"></img></a>                               
                            </div>
                        </div>
                       
                        
                        
                        
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($locale,'[category_id_'.$count.']'.'description',array('class'=>'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textArea($locale, '[category_id_'.$count.']'.'description', array('class'=>'span7','maxlength' => 1000, 'rows' => 8,'value'=>$templateVal[$templateField]->desc,'style'=>"width: 468px; height: 131px;")); ?>
                        <?php //echo $form->textArea($locale,'description',array('size'=>60,'maxlength'=>250,'class'=>'span6',)); ?>
                        <span class="help-inline"><?php echo $form->error($locale,'description'); ?></span></div>
                    </div>
                </div>
                        <?php
                        $count++;
                    }
                }
                else
                { 
                $templateField = 1; 
                ?>
                <div class="row-fluid removeControl" id="template1">
                <div class="control-group">
                    <?php echo $form->labelEx($locale,'[category_id_1]'.'title',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <div class="span6 nopadding">
                            <?php echo $form->textField($locale,'[category_id_1]'.'title',array('size'=>60,'maxlength'=>250,'class'=>'span6 nopadding','value'=>$title)); ?>
                            <span class="help-inline"><?php echo $form->error($locale,'title'); ?></span>
                        </div>
                        <div class="span1 nopadding">
                            <a href="javascript:void(0)" id="addmore" onclick="addmoreCatTemplate(1);" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($locale,'[category_id_1]'.'description',array('class'=>'control-label')); ?>
                            <div class="controls">
                    <?php echo $form->textArea($locale, '[category_id_1]'.'description', array('class'=>'span7','maxlength' => 1000, 'rows' => 8,'value'=>$description,'style'=>"width: 468px; height: 131px;")); ?>
                    <?php //echo $form->textArea($locale,'description',array('size'=>60,'maxlength'=>250,'class'=>'span6',)); ?>
                    <span class="help-inline"><?php echo $form->error($locale,'description'); ?></span></div>
                </div>
              </div>                    
    <?php
            }
    ?>	
<!--            <div class="addRemove">
                    <a href="javascript:void(0)" id="addmore" onclick="addmoreCatTemplate(1);" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add-btn.png"></img></a>
                    <a href="javascript:void(0)" id="remTmpl"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/remove-btn.png"></img></a>
            </div>-->
            <div id="fields"><input type="hidden" id="tmplnum" name="totalCatTmplId" value="<?php echo $templateField ?>"/></div>
            </div>
           </div>

          </div>

	 <div class="controls">
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_category_form','create_text') : Yii::t('admin_category_form','save_text'),array('class'=>'btn blue')); ?>
		<?php echo CHtml::button(Yii::t('admin_category_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?>
	</div>
	</div>
<?php $this->endWidget(); ?>

</div>
</div><!-- form -->
</div>