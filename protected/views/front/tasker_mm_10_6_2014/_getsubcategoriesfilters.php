<?php
$filterArray = array(0);
if(isset($subCategoryName))
{
    $filterArray = CommonUtility::getCategoryIdFromString($subCategoryName , true); // true for get multiple
}

if($categoryList)
{
    foreach($categoryList as $category)
    {
        $checked = false;
        if(in_array($category["categorylocale"]["category_id"], $filterArray))
        $checked = true;
        $parentUrl = CommonUtility::getCategoryNameOnUrl($parentCategory);
        $url = CommonUtility::getCategoryNameOnUrl($category["categorylocale"]["category_id"]);
        echo '<div id="catIdRowSub_'.$category["categorylocale"]["category_id"].'" class="advnc_col6">'.
                CHtml::checkBox("categories[]", $checked ,array('id' => Globals::URL_CATEGORY_TYPE_SLUG.$category["categorylocale"]["category_id"] , 'value'=>$url , 'onclick' => 'return searchByChildCategory("'.$parentUrl.'","'.$category["categorylocale"]["category_id"].'")' , 'class' => 'subcategory','style'=>'margin:0px 5px 0 0;') ).$category["categorylocale"]["category_name"] .
               '</div>';
    }
}
?>