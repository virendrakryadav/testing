rrrr<div id="category_<?php echo $data->category_id ?>" class="task_cat  <?php if($i%2==0) echo 'cat_bg1'; else echo 'cat_bg2';?> ">
        <?php echo CHtml::ajaxLink('<div class="cat_img"><img src="'.CommonUtility::getCategoryImageURI($data->category_id).'"></div><p>'.$data->categorylocale->category_name.'</p>', Yii::app()->createUrl($action), array(
                'data'=>array('category_id'=>$data->category_id , 'formType'=>'instant','taskId'=>$task_id),
                'type'=>'POST',
            'dataType' => 'json', 
            'beforeSend' => 'function(){
                                            $("#rootCategoryLoading").addClass("displayLoading");
                                            $("#loadpreviuosTask").addClass("displayLoading");
                                            $("#templateCategory").addClass("displayLoading");}',
            'complete' => 'function(){       
                                            $("#rootCategoryLoading").removeClass("displayLoading");
                                            $("#loadpreviuosTask").removeClass("displayLoading");
                                            $("#templateCategory").removeClass("displayLoading");}',
            'success' => 'function(data){
                //alert(data.form);
                 activeForm("loadcategory_'.$data->category_id.'");
                                        $(\'#loadCategoryForm\').html(data.form);
                                        $(\'#loadPreviewTask\').html(data.previusTask);
                                        $(\'#loadTemplateCategory\').html(data.template);
                                       
                                        }'), 
                array('id' => 'loadinstantcategory_'.$data->category_id ,'live'=>false)); ?>
    </div>