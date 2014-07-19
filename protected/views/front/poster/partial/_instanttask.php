<?php  $parentCategory = Category::getInstantCategoryListParentOnly(); ?>
<?php //Yii::import('ext.chosen.Chosen'); ?>

<div class="margin-bottom-30">
<h3><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_choose_a_category')) ?></h3>

<div class="col-md-5 mrg-all" id="categorySliderinstantcont">
<?php  
//            $list = CHtml::listData($parentCategory, Globals::FLD_NAME_CATEGORY_ID , 'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME);
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
            
//            echo Chosen::dropDownList('parentCategoryinstant', $parent_id, $list,
//     array('prompt'=>'Choose a category',
//                                           'ajax' => array(
//                                           'type' => 'POST',
//                                           'url' => CController::createUrl('poster/getsubcategories'),
//                                            'dataType' => 'json', 
//                                            'beforeSend' => 'function(){
//                                                 $("#categorySliderinstantcont").addClass("loading-select");
//                                                 
//                                             }',
//                                             'complete' => 'function(){
//                                                     $("#categorySliderinstantcont").removeClass("loading-select");
//                                             }',
//                                            'success' => "function(data){
//                                                if(data.status==='success')
//                                                {
////                                                    selectCategoryByTaskType('');
//                                                    $('#categorySliderinstant').html(data.html);
//                                                    
////                                                    getFormDataByCategory(data.category_id);
//                                                    
//                                                    
//                                                }
//                                                else
//                                                {
//                                                 alertErrorMessage(\"OOps!! no sub category, please select other category (i.e Restaurant Delivery)\");
//                                                    //alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
//                                                }
//
//                                            }",
//                                           'data' => array(Globals::FLD_NAME_CATEGORY_ID => 'js:this.value')),'class' => 'form-control' ,'id'=>'chooseCategoryinstant'));

?>
</div>
</div>
<div id="categorySliderinstant">
    <div class="col-md-12 no-mrg overflow-h">
    <div id="selectedCategory<?php echo $category_id ?>" class="">
    <?php //$this->renderPartial('partial/_selected_category' , array( 'category_id' => $category_id)); ?>
    </div>
</div>
<div class="col-md-12 v-nopdn">
<div class="v-sub-cat">
    <div class="subCatInPopupInst">
    <?php
   $categorits = Category::getCategoryListByType(Globals::DEFAULT_VAL_I);
    foreach ($categorits as $category) 
    {
          $catImg =  CommonUtility::getCategoryImageURI($category->{Globals::FLD_NAME_CATEGORY_ID});
        ?>
    <div class="item">
    <div id="category_<?php echo $category->category_id ?>" class="task_cat cat_bg1  <?php //if ($i % 2 == 0) echo 'cat_bg1'; else echo 'cat_bg2'; ?> ">
                   
                            <a id="loadinstantcategory_<?php echo $category->category_id ?>" onclick="selectSubCategory('<?php echo $category->category_id ?>' , '<?php echo $catImg ?>' , '<?php echo $category->categorylocale->category_name ?>' , '#selectedCategory<?php echo $category_id ?>')" href="javascript:void(0)">
                                <div class="cat_img">
                                    <img src="<?php echo $catImg ?>">
                                </div>
                                <p>
                                    <?php echo $category->categorylocale->category_name ?></p>
                            </a>
                        </div>   </div>
   <?php
    }
   ?>
</div></div></div>
    </div>