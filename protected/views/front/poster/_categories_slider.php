<script>
    $(document).ready(function(){
        $('.slider1').bxSlider({
            slideWidth: 164,
            minSlides: <?php echo Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT ?>,
            maxSlides: <?php echo Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT ?>,
            slideMargin: 0,
             moveSlides: <?php echo Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT ?>,
            auto: true,
            autoHover: true,
            autoControls: true
                
        });
    });
</script>
<div class="margin-bottom-30">
<div class="col-md-4 mrg-all"><h3>Choose a Subcategory</h3></div>
<div class="col-md-4 v-pdn">
<?php
if(count($subCategories)> Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT)
{
    ?>

    <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Full List of Subcategories')), Yii::app()->createUrl('poster/getsubcategoriespopup'), 
                            array(
                                    'beforeSend' => 'function(){
                                                $("#subcategoryFullList'.$category_id.'").addClass("loading-select");
                                            }',
                                    'complete' => 'function(){       
                                                $("#subcategoryFullList'.$category_id.'").removeClass("loading-select");
                                            }',
                                    'dataType' => 'json', 
                                    'type'=>'POST',
                                    'data'=> array(Globals::FLD_NAME_CATEGORY_ID => $category_id),
                                    'success' => "function(data){
                                        if(data.status==='success')
                                                {
                                                   
                                                     loadpopup(data.html , '' , '');
                                                }
                                                else
                                                {
                                                    alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                                }
                                                                   
                                                                    
                                                                }"), 
                            array('id' => 'subcategoryFullList'.$category_id,'live'=>false));?>
   
<?php
}
?>
</div>
<div class="col-md-12">
    <div id="selectedCategory" class="task_cat">
    <?php $this->renderPartial('partial/_selected_category' , array( 'category_id' => $category_id)); ?>
    </div>
</div>
<div class="col-md-12">
    <?php
    
        if ($subCategories) {
            ?>
            <div class="slider1">
            <?php
            $i = 0;
            foreach ($subCategories as $category) {
                ?>
                    <div class="slide">
                        <div id="category_<?php echo $category->category_id ?>" class="task_cat  <?php if ($i % 2 == 0) echo 'cat_bg1'; else echo 'cat_bg2'; ?> ">
                   
                            <a id="loadinstantcategory_<?php echo $category->category_id ?>" onclick="selectCategory('<?php echo $category->category_id ?>' , '#selectedCategory')" href="javascript:void(0)">
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
    <!--<img src="../images/cat-slid.jpg">-->
</div>
</div>