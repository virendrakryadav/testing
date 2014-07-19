<?php  $parentCategory = Category::getVirtualCategoryListParentOnly(); ?>


<div class="margin-bottom-30">
<h3>Choose a Category</h3>

<div class="col-md-5 mrg-all">
<?php  
            $list = CHtml::listData($parentCategory, Globals::FLD_NAME_CATEGORY_ID , 'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME);
            echo CHtml::dropDownList('parentCategory','', $list, 
                     array('prompt'=>'Choose a category',
                                           'ajax' => array(
                                           'type' => 'POST',
                                           'url' => CController::createUrl('poster/getsubcategories'),
                                            'dataType' => 'json', 
                                            'beforeSend' => 'function(){
                                                 $("#chooseCategory").addClass("loading-select");
                                                 
                                             }',
                                             'complete' => 'function(){
                                                     $("#chooseCategory").removeClass("loading-select");
                                             }',
                                            'success' => "function(data){
                                                if(data.status==='success')
                                                {
                                                    selectCategoryByTaskType(data.category_id);
                                                    $('#categorySlider').html(data.html);
                                                    formProcess();
                                                    getFormDataByCategory(data.category_id);
                                                    
                                                    
                                                }
                                                else
                                                {
                                                    alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                                }

                                            }",
                                           'data' => array(Globals::FLD_NAME_CATEGORY_ID => 'js:this.value')),'class' => 'form-control' ,'id'=>'chooseCategory'));
?>
</div>
</div>

<div id="categorySlider">
   
</div>
