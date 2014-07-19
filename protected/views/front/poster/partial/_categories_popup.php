<a  class="close-pop" onclick="closepopup();"href="javascript:void(0)" ><img src="<?php echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>"></a>
<div class="col-md-12 vsub-cat">
<div class="v-search">
<div class="v-searchcol1">
<img src="<?php echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>">
 </div>
<div class="v-searchcol2"><?php echo CHtml::textField(Globals::FLD_NAME_CATEGORY_NAME, '', array('id' => 'categoryNameSearch', 'placeholder' => 'Search Category')); ?></div>
<div class="v-searchcol3">
<!--<a id="resetcategoryFilter" href="javascript:void(0)" ><img src="<?php echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>"></a>-->
</div>
</div>
    
    
<div class="col-md-12 v-nopdn">
<div class="v-sub-cat">
<!--<div class="vnext"><a href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "arrowtopnew.png" ) ?>"></a></div>-->
<input type="hidden" value="<?php echo $category_id ?>" id="category_id_popup">
<div class="subCatInPopup">
<?php
    
        if ($subCategories) {


$this->widget('ListViewWithLoader', array(
    'id' => 'categorylistpopup',
    'dataProvider'=>$subCategories,
    'viewData' => array('category_id' => $category_id),
    'itemView'=>'partial/_view_categories_popup',
     'emptyTagName' => 'div class="alert alert-danger fade in"',
     'emptyText' => Yii::t('tasklist','No category found matching your search criteria.'),
     'summaryText' => Yii::t('tasklist','Found {count} categories'),
)); 
        }
            ?>

<!--<div class="vnext"><a href="#"><img src="../images/arrowbottomnew.png"></a></div>-->
</div></div>
</div></div>