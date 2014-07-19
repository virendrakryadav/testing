<?php
$maxPriceValue = isset($maxPriceValue) ? $maxPriceValue : $maxPrice;
$minPriceValue = isset($minPriceValue) ? $minPriceValue : $minPrice;
$date = isset($date) ? $date : '';
$rating = isset($rating) ? $rating : '';
$isLogin = CommonUtility::isUserLogin();
$parentCategory = empty($parentCategory) ? "" : $parentCategory;
$subCategoryName = empty($subCategoryName) ? "" : $subCategoryName;
 $filter_type = empty($filter_type) ? "" : $filter_type;
  $taskName = empty($taskName) ? "" : $taskName;
 
?>
<div class="advncsearch">
<div class="advnc_row margin-bottom-10"><?php echo Yii::t('tasker_mytasks', 'Category')?></div>
<div class="col-md-12 pdn-auto">
<div class="advnc_row2 categoryScroll">
    <?php //echo UtilityHtml::getCategoryListNastedInTaskSearch($taskType); ?>
    <?php $this->renderPartial('//tasker/_getcategorylistinsearch', array('parentCategory' => $parentCategory , 'taskType' => $taskType , 'subCategoryName' => $subCategoryName));?>

</div>
</div>
</div>
<div id="aftercategoryfilter">
<?php $this->renderPartial('//tasker/_getfiltersaftercategory', array('maxPrice' => $maxPrice ,'minPrice' => $minPrice , 'date' => $date , 'rating' => $rating , 'maxPriceValue' => $maxPriceValue , 'minPriceValue' => $minPriceValue , 'filter_type' => $filter_type ,'taskName' => $taskName ));?>
</div>
