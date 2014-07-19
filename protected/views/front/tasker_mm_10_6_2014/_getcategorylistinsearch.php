<?php $category = Category::getParentCategory($taskType); 

if ($category) 
{
    foreach ($category as $parentcat) 
    {
         $activeCategory = false;
         $class = '';
        if(isset($parentCategory) && $parentCategory == $parentcat["categorylocale"]["category_id"] )
        {
            $activeCategory = true;
            $class = 'activeCategory';
        }
        ?>
        <div class="advnc_row3" id="catIdRow_<?php echo $parentcat["categorylocale"]["category_id"] ?>">
            <label class="checkbox">
                <?php echo CHtml::link($parentcat["categorylocale"]["category_name"],CommonUtility::getParentCategoryURI($parentcat["categorylocale"]["category_id"]),array('id' => Globals::URL_CATEGORY_TYPE_SLUG.$parentcat["categorylocale"]["category_id"] , 'class'=>$class , 'data-id' =>$parentcat["categorylocale"]["category_id"] )) ?>
                </>
            </label>
        </div>
        <div class="advnc_col6">
            <?php
            if($activeCategory)
            {
                
                $categoryList = Category::getChildCategoryByID($parentCategory);
                $this->renderPartial('//tasker/_getsubcategoriesfilters',array('categoryList' => $categoryList , 'parentCategory' => $parentCategory , 'subCategoryName' => $subCategoryName ));
            }
            ?>
        </div>
        <?php

    }
}

?>

