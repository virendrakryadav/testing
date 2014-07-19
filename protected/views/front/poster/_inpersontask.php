<?php 
$lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
if(CommonUtility::IsProfilingEnabled())
{
   Yii::beginProfile('inpersontaskCatgWidgetView','application.view.PosterController');
}
if($this->beginCache(Globals::$cacheKeys['WIDGET_VIEW_CATEGORY_INPERSON'].'_'.$lang, array('duration'=>Globals::DEFAULT_CATEGORY_CACHE_DURATION))) { ?>
<!--in-person task category start here-->
<script>
    $(document).ready(function(){
        $('.slider2').bxSlider({
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
    <h3 class="h3 bottom_border"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_choose_inperson_task_category')); ?>  </h3>
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
        $categories = Category::getInpersonCategoryList();
        if ($categories) {
            ?>
            <div class="slider2">
            <?php
            $i = 0;
            foreach ($categories as $category) {
                //print_r($category);//CommonUtility::getCategoryThumbnailImageURI($category->category_id,  "100x100")
                ?>
                    <div class="slide">
                        <div id="category_<?php echo $category->category_id ?>" class="task_cat  <?php if ($i % 2 == 0) echo 'cat_bg1'; else echo 'cat_bg2'; ?> ">
                    <?php
//        echo CHtml::ajaxLink('<div class="cat_img"><img src="'.CommonUtility::getCategoryImageURI($category->category_id).'"></div><p>'.$category->categorylocale->category_name.'</p>', Yii::app()->createUrl($action), array(
//            'data'=>array(Globals::FLD_NAME_CATEGORY_ID =>$category->category_id,Globals::FLD_NAME_FORM_TYPE=> 'inperson',Globals::FLD_NAME_TASKID=>$task_id),
//            'type'=>'POST',
//            'dataType' => 'json', 
//            'beforeSend' => 'function(){
//                                            $("#rootCategoryLoading").addClass("displayLoading");
//                                            $("#loadpreviuosTask").addClass("displayLoading");
//                                            $("#templateCategory").addClass("displayLoading");}',
//            'complete' => 'function(){       
//                                            $("#rootCategoryLoading").removeClass("displayLoading");
//                                            $("#loadpreviuosTask").removeClass("displayLoading");
//                                            $("#templateCategory").removeClass("displayLoading");}',
//            'success' => 'function(data){
//                //alert(data.form);
//                                        $(\'#loadCategoryForm\').html(data.form);
//                                        $(\'#loadPreviewTask\').html(data.previusTask);
//                                        $(\'#loadTemplateCategory\').html(data.template);
//                                        $(\'#templateCategory\').fadeIn(500);
//                                        activeForm("loadcategory_'.$category->category_id.'");
//                                           
//                                        }'),
//            array('id' => 'loadinpersoncategory_'.$category->category_id, 'live'=>false )); 
                    ?>
                            <a id="loadinpersoncategory_<?php echo $category->category_id ?>" onclick="loadCategoryFormScript('<?php echo Yii::app()->createUrl($action) ?>' ,<?php echo $category->category_id ?> , <?php echo $task_id ?> , 'inperson' )" href="#">
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
}
?>
        </div>
    </div>

    <!--in-person task category Ends here-->
<?php $this->endCache(); } 
if(CommonUtility::IsProfilingEnabled())
{
   Yii::endProfile('inpersontaskCatgWidgetView');
}
?>