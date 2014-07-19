 <?php 
 $catImg =  CommonUtility::getCategoryImageURI($data->category_id);
?>
<!--<li><a id="loadinstantcategory_<?php //echo $data->category_id ?>" onclick="selectSubCategory('<?php //echo $data->category_id ?>' , '<?php //echo $catImg ?>' , '<?php //echo $data->categorylocale->category_name ?>' , '#selectedCategory<?php //echo $data->category_id ?>')" href="javascript:void(0)" >

                <img src="<?php //echo CommonUtility::getCategoryThumbnailImageURI($data->category_id , Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
    </a>
<p><?php //echo $data->categorylocale->category_name ?></p></li>-->

<div class="item">
                           <div id="category_<?php echo $data->category_id ?>" class="task_cat cat_bg1 ">
                   
                            <a id="loadinstantcategory_<?php echo $data->category_id ?>" onclick="selectSubCategory('<?php echo $data->category_id ?>' , '<?php echo $catImg ?>' , '<?php echo $data->categorylocale->category_name ?>' , '#selectedCategory<?php echo $category_id  ?>')" href="javascript:void(0)">
                                <div class="cat_img">
                                    <img src="<?php echo $catImg ?>">
                                </div>
                                <p>
                                    <?php echo $data->categorylocale->category_name ?></p>
                            </a>
                        </div>
                </div>
        <?php
       