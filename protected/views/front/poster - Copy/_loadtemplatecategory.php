<?php
$i=0;
if(isset($model) && !empty($model))
{
    foreach ($model as $category)
   {
        $templates = json_decode($category->categorylocale[Globals::FLD_NAME_TASK_TEMPLATES], true);   
        if(!empty($templates))
        {
         $templateId = 0;
         foreach($templates as $template){
//            $imageName = UtilityHtml::getCategoryImage($category->categorylocale[Globals::FLD_NAME_CATEGORY_IMAGE]);
           $imageName = CommonUtility::getCategoryImageURI($category->categorylocale[Globals::FLD_NAME_CATEGORY_IMAGE]);
         ?>
            <div class="prvlist_box"> <a href="#"><img src="<?php echo CommonUtility::getCategoryImageURI($category->category_id) ?>" width="71" height="52"></a>
            <p class="title"><strong><?php echo $template[Globals::FLD_NAME_TITLE];?></strong></p>
            <p class="title"><?php // echo substr($template[Globals::FLD_NAME_DESC],0,50);
                echo UtilityHtml::showLilitedStr($template[Globals::FLD_NAME_DESC],50);
            ?></p>
            <!--<a style="float: right" href="#" id="view<?php echo $i;?>">-->           
            <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'lbl_view_more')),Yii::app()->createUrl('poster/gettemplatedetail?category_id='.$category->category_id.'&templateId='.$templateId),array('success' => 'function(data){$(\'#templatdiv\').html(data);$(\'#templatdiv\').show();}'), array('id'=>'templateDetail_l'.$i,'live'=>false)); ?>
            <!--</a>-->
            </div>
<?php
        
        $i++;
        $templateId++;
        }
        }
        else
{
    echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_template_not_available'));
}
   }
}
else
{
    echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_template_not_available'));
}
?>