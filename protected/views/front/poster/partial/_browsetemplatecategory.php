<div class="popup_head">
    <h2 class="heading"><?php echo CHtml::encode(Yii::t('poster_createtask', 'Templates')); ?></h2><button id="cboxClose" onclick="document.getElementById('templatdiv').style.display='none';" type="button">Close</button>
</div><?php

if (isset($model) && !empty($model)) 
    {
        foreach ($model as $category) 
        {
            $templates = json_decode($category->categorylocale[Globals::FLD_NAME_TASK_TEMPLATES], true);
            if (!empty($templates)) 
            {
               $templateId = 0;
               foreach($templates as $template){
//                $imageName = UtilityHtml::getCategoryImage($category->categorylocale[Globals::FLD_NAME_CATEGORY_IMAGE]);
                $imageName = CommonUtility::getCategoryImageURI($category->categorylocale[Globals::FLD_NAME_CATEGORY_IMAGE]);
                ?>
                 <div class="prvlist_box" style="padding: 10px;"> <a href="#"><img src="<?php echo CommonUtility::getCategoryImageURI($category->category_id) ?>" width="100" ></a>
                     <p class="title"><strong><?php echo $template[Globals::FLD_NAME_TITLE]; ?></strong></p>
                     <p class="title"><?php echo substr($template[Globals::FLD_NAME_DESC], Globals::DEFAULT_VAL_BROWSE_TEMPLATE_DESCRIPTION_LIMIT_FROM, Globals::DEFAULT_VAL_BROWSE_TEMPLATE_DESCRIPTION_LIMIT_TO); ?></p>
                     <input type="hidden" id="templateTitle<?php echo $templateId;?>" value="<?php echo $template[Globals::FLD_NAME_TITLE]; ?>">
                     <input type="hidden" id="templateDetail<?php echo $templateId;?>" value="<?php echo $template[Globals::FLD_NAME_DESC]; ?>">
                     <div style="margin-top: 5px;">
                         <div style="float: right;cursor: pointer;" ><button class="sign_bnt" onclick="templateDetailFill(<?php echo $templateId;?>)"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_use_this_template')); ?></button></div>
                     </div>
                 </div>
                 <?php
                 $templateId++;
                 }
            }
            else
            {
                 ?><div class="prvlist_box" style="padding: 10px;"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_template_not_available')); ?> </div> <?php
            }
    }
} 
else 
{
    echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_template_not_available'));
}
?>