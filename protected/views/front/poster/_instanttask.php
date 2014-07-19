<?php
$lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
if(CommonUtility::IsProfilingEnabled())
{
   Yii::beginProfile('instanttaskCatgWidgetView','application.view.PosterController');
}
if($this->beginCache(Globals::$cacheKeys['WIDGET_VIEW_CATEGORY_INSTANT'].'_'.$lang, array('duration'=>Globals::DEFAULT_CATEGORY_CACHE_DURATION))) { ?>
<!--Instant task category start here-->
<script>
    $(document).ready(function(){
        $('.slider1').bxSlider({
            slideWidth: 164,
            minSlides: 5,
            maxSlides: 5,
            slideMargin: 0,
             moveSlides: 5,
            auto: true,
            autoHover: true,
            autoControls: true
                
        });
    });
</script>
<div class="controls-row pdn2">
    <h3 class="h3 bottom_border"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_choose_instant_task_category')); ?>  </h3>
    <div class="controls-row cnl_space">
        <?php
        if ($task->{Globals::FLD_NAME_TASK_ID}) {
            $task_id = $task->{Globals::FLD_NAME_TASK_ID};
            $action = 'poster/loadcategoryformtoupdate';
        } else {

            $task_id = "0";
            $action = 'poster/loadcategoryform';
        }
        ?>
        <?php
        $categorys = Category::getInstantCategoryList();
        if ($categorys) {
            ?>
            <div class="slider1">
            <?php
            $i = 0;
            foreach ($categorys as $category) {
                ?>
                    <div class="slide">
                        <div id="category_<?php echo $category->category_id ?>" class="task_cat  <?php if ($i % 2 == 0) echo 'cat_bg1'; else echo 'cat_bg2'; ?> ">
                   
                            <a id="loadinstantcategory_<?php echo $category->category_id ?>" onclick="loadCategoryFormScript('<?php echo Yii::app()->createUrl($action) ?>' ,<?php echo $category->category_id ?> , <?php echo  $task_id ?> , 'instant' )" href="#">
                                <div class="cat_img">
                                    <img src="<?php echo CommonUtility::getCategoryImageURI($category->category_id) ?>">
                                </div>
                                <p>
                                    <?php echo $category->categorylocale->category_name ?></p>
                            </a>
                        </div>
                    </div>
                            <?php
                            $i++;
                        }
                        ?>
            </div>
                <?php
            }
            ?>
    </div>
</div><!--Instant task category Ends here-->
<?php $this->endCache(); } 
if(CommonUtility::IsProfilingEnabled())
{
   Yii::endProfile('instanttaskCatgWidgetView');
}
?>