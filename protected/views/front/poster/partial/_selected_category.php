<?php if(isset($category_id))
{
    ?>
    <div class="cat_img">
    <img src="<?php echo CommonUtility::getCategoryThumbnailImageURI($category_id , Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50) ?>">
    </div>
    <p style="color: #000">
    <?php echo CommonUtility::getCategoryName($category_id); ?></p>
    <?php
}
else
{
    
}
?>

