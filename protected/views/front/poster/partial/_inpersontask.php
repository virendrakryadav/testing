<?php  $parentCategory = Category::getInpersonCategoryListParentOnly(); ?>
<?php //Yii::import('ext.chosen.Chosen'); ?>

<div class="margin-bottom-30">
<h3><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_choose_a_category')) ?></h3>

<div class="col-md-5 mrg-all" id="chooseCategoryinpersoncont">
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
            
            echo Chosen::dropDownList('parentCategoryinperson', $parent_id, $list,
     array('prompt'=>'Choose a category',
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('poster/getsubcategories'),
                                            'dataType' => 'json', 
                                            'beforeSend' => 'function(){
                                                 $("#chooseCategoryinpersoncont").addClass("loading-select");
                                                 
                                             }',
                                             'complete' => 'function(){
                                                     $("#chooseCategoryinpersoncont").removeClass("loading-select");
                                             }',
                                            'success' => "function(data){
                                                if(data.status==='success')
                                                {
//                                                    selectCategoryByTaskType('');
                                                    $('#categorySliderinperson').html(data.html);
                                                    
//                                                    getFormDataByCategory(data.category_id);
                                                    
                                                    
                                                }
                                                else
                                                {
                                                    alertErrorMessage(\"OOps!! no sub category, please select other category (i.e Restaurant Delivery)\");
                                                   // alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                                }

                                            }",
                                           'data' => array(Globals::FLD_NAME_CATEGORY_ID => 'js:this.value')),'class' => 'form-control' ,'id'=>'chooseCategoryinperson'));
            
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

<div id="categorySliderinperson">
   <?php if(isset($editTaskPartials['categories_slider']))
            {
                echo $editTaskPartials['categories_slider'];
            }
   ?>
</div>