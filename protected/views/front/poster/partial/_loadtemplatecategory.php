<?php

if(isset($model) && !empty($model))
{
    foreach ($model as $category)
   {
        $templates = json_decode($category->categorylocale[Globals::FLD_NAME_TASK_TEMPLATES], true);   
        if(!empty($templates))
        {
            $templateId = 0;
            foreach($templates as $template)
            {
           
                $selectTemplate[$templateId] = $template[Globals::FLD_NAME_TITLE];
                $templateId++;
            }
        }
 
   }
}
?>
<?php  
if(isset($selectTemplate))
{
        echo CHtml::dropDownList('category_template','', $selectTemplate, 
         array('prompt'=>'Choose Template',
                               'ajax' => array(
                               'type' => 'POST',
                               'dataType' => 'json', 
                               'url' => CController::createUrl('poster/gettemplatedetail'),
                               'success' => "function(data){
                                   if(data.status==='success')
                                    {
                                        $('#Task_description').val(data.description);
                                        var vall = $('#Task_description').val().length;
                                        var total=".Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.";
                                        total = total-vall;
                                        $('#wordcountPosterComments').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'))."'+total);
                                    }
                                    else
                                    {
                                        alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    }
                                }",
                               'data' => array('templateId'=>'js:this.value' , 'category_id' => $category->category_id )),'class' => 'form-control mrg5','live'=>false));
}
?>




