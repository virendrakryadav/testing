<?php  $parentCategory = Category::getVirtualCategoryListParentOnly(); ?>
<?php //Yii::import('ext.chosen.Chosen'); ?>

<div class="margin-bottom-30">
<h3>Choose a Category</h3>

<div class="col-md-5 mrg-all">
<?php  
            $list = CHtml::listData($parentCategory, Globals::FLD_NAME_CATEGORY_ID , 'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME);
           $parent_id = '';
            $category_id = '';
            if(isset($editTaskPartials['category_id']))
            {
                $category_id = $editTaskPartials['category_id'];
            }
            if(isset($editTaskPartials['parent_id']))
            {
                $parent_id = $editTaskPartials['parent_id'];
            }
            
            echo Chosen::dropDownList('parentCategory', $parent_id, $list,
     array('prompt'=>'Choose a category',
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('poster/getsubcategories'),
                                            'dataType' => 'json', 
                                            'beforeSend' => 'function(){
                                                 $("#chooseCategoryvirtual").addClass("loading-select");
                                                 
                                             }',
                                             'complete' => 'function(){
                                                     $("#chooseCategoryvirtual").removeClass("loading-select");
                                             }',
                                            'success' => "function(data){
                                                if(data.status==='success')
                                                {
//                                                    selectCategoryByTaskType('');
                                                    $('#categorySlider').html(data.html);
                                                    
//                                                    getFormDataByCategory(data.category_id);
                                                    
                                                    
                                                }
                                                else
                                                {
                                                    alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                                }

                                            }",
                                           'data' => array(Globals::FLD_NAME_CATEGORY_ID => 'js:this.value')),'class' => 'form-control' ,'id'=>'chooseCategoryvirtual'));
            
//            echo CHtml::dropDownList('parentCategory','', $list, 
//                     array('prompt'=>'Choose a category',
//                                           'ajax' => array(
//                                           'type' => 'POST',
//                                           'url' => CController::createUrl('poster/getsubcategories'),
//                                            'dataType' => 'json', 
//                                            'beforeSend' => 'function(){
//                                                 $("#chooseCategory").addClass("loading-select");
//                                                 
//                                             }',
//                                             'complete' => 'function(){
//                                                     $("#chooseCategory").removeClass("loading-select");
//                                             }',
//                                            'success' => "function(data){
//                                                if(data.status==='success')
//                                                {
//                                                    selectCategoryByTaskType(data.category_id);
//                                                    $('#categorySlider').html(data.html);
//                                                    formProcess();
//                                                    getFormDataByCategory(data.category_id);
//                                                    
//                                                    
//                                                }
//                                                else
//                                                {
//                                                    alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
//                                                }
//
//                                            }",
//                                           'data' => array(Globals::FLD_NAME_CATEGORY_ID => 'js:this.value')),'class' => 'form-control' ,'id'=>'chooseCategory'));
?>
</div>
</div>

<div id="categorySlider">
   <?php if(isset($editTaskPartials['categories_slider']))
            {
                echo $editTaskPartials['categories_slider'];
            }
   ?>
</div>
