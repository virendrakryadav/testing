<!--<script>
    $(document).ready(function(){
        $('.slider<?php echo $category_id ?>').bxSlider({
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
</script>-->
<div class="margin-bottom-30">
<div class="col-md-4 mrg-all"><h3>Choose a subcategory</h3></div>
<div class="col-md-4 v-pdn">
<?php
if(count($subCategories)> Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT)
{
    ?>

    <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_full_list_of_subcategories')), Yii::app()->createUrl('poster/getsubcategoriespopup'), 
                            array(
                                    'beforeSend' => 'function(){
                                                $("#subcategoryFullList'.$category_id.'").addClass("loading-select");
                                            }',
                                    'complete' => 'function(){       
                                                $("#subcategoryFullList'.$category_id.'").removeClass("loading-select");
                                            }',
                                    'dataType' => 'html', 
                                    'type'=>'GET',
                                    'data'=> array(Globals::FLD_NAME_CATEGORY_ID => $category_id),
                                    'success' => "function(data){
                                                if(data)
                                                {
                                                   
                                                     loadpopup(data , '' , 'subcatbg' , 'noscroll');
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
<div class="col-md-12 no-mrg overflow-h">
    <div id="selectedCategory<?php echo $category_id ?>" class="">
    <?php //$this->renderPartial('partial/_selected_category' , array( 'category_id' => $category_id)); ?>
    </div>
</div>
<!--<div class="col-md-12 no-mrg">
    <?php
    
//        if ($subCategories) {
//            ?>
            <div class="slider//<?php echo $category_id ?>">
            //<?php
//            $i = 0;
//            foreach ($subCategories as $category) 
//                {
//                    $catImg =  CommonUtility::getCategoryImageURI($category->category_id);
//                    ?>
                    <div class="slide">
                        <div id="category_//<?php // echo $category->category_id ?>" class="task_cat cat_bg1  <?php //if ($i % 2 == 0) echo 'cat_bg1'; else echo 'cat_bg2'; ?> ">
                   
                            <a id="loadinstantcategory_//<?php //echo $category->category_id ?>" onclick="selectSubCategory('<?php //echo $category->category_id ?>' , '<?php //echo $catImg ?>' , '<?php //echo $category->categorylocale->category_name ?>' , '#selectedCategory<?php //echo $category_id ?>')" href="javascript:void(0)">
                                <div class="cat_img">
                                    <img src="//<?php //echo $catImg ?>">
                                </div>
                                <p>
                                    //<?php //echo $category->categorylocale->category_name ?></p>
                            </a>
                        </div>
                    </div>
                            //<?php
//                            $i++;
//                    }
//                    ?>
            </div>
                //<?php
//            }
            ?>
    <img src="../images/cat-slid.jpg">
</div>-->

<div class="col-md-12 no-mrg">
  
  <div class="owl-carousel-v2 owl-carousel-style-v1 margin-bottom-50">
        <?php
if(count($subCategories)> Globals::SLIDER_SUBCATEGORY_SCROLL_LIMIT)
{
    ?>       
                  <div class="owl-navigation">
                        <div class="customNavigation">
                            <a class="owl-btn prev-v2"><i class="fa fa-angle-left"></i></a>
                            <a class="owl-btn next-v2"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div><!--/navigation-->    
<?php } ?>
                    <div class="owl-slider-v2">
            <?php
        if ($subCategories) {
            ?>
           
            <?php
            $i = 0;
            foreach ($subCategories as $category) 
                {
                    $catImg =  CommonUtility::getCategoryImageURI($category->category_id);
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
                        </div>
                </div>
                            <?php
                            $i++;
                    }
                    ?>
       
                <?php
            }
            ?>
                        
                    </div>
           
                </div>
</div>

</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
        OwlCarousel.initOwlCarousel();
    });
</script>