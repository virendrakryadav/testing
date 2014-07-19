
<div class="col-md-12 vsub-cat">
<div class="v-search">
<div class="v-searchcol1">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-searchic.png">
 </div>
<div class="v-searchcol2"><input type="text" placeholder="Search messages" name=""></div>
<div class="v-searchcol3">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-closeic.png">
</div>
</div>
<div class="col-md-12 v-nopdn">
<div class="v-sub-cat">
<div class="vnext"><a href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "arrowtopnew.png" ) ?>"></a></div>
<?php
    
        if ($subCategories) {
            ?>
            <ul>
            <?php
            $i = 0;
            foreach ($subCategories as $category) {
                ?>
                    <li><a id="loadinstantcategory_<?php echo $category->category_id ?>" onclick="selectCategory('<?php echo $category->category_id ?>' , '#selectedCategory')" href="javascript:void(0)" >
                              
                                    <img src="<?php echo CommonUtility::getCategoryThumbnailImageURI($category->category_id , Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
                        </a></li>
                            <?php
                            $i++;
                        }
                        ?>
           </ul>
                <?php
            }
            ?>


<div class="vnext"><a href="#"><img src="../images/arrowbottomnew.png"></a></div>
</div>
</div></div>