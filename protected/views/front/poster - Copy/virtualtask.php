<?php 
$lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
if(CommonUtility::IsProfilingEnabled())
{
   Yii::beginProfile('virtualtaskCatgView','application.view.PosterController');
}
if($this->beginCache(Globals::$cacheKeys['VIEW_CATEGORY_VIRTUALTASK'].'_'.$lang, array('duration'=>Globals::DEFAULT_CATEGORY_CACHE_DURATION))) { ?>
<div class="controls-row pdn2">
    <h3 class="h3 bottom_border"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_choose_virtual_task_category')); ?>  </h3>
    <div class="controls-row cnl_space">
        <?php
        if ($task->{Globals::FLD_NAME_TASK_ID}) 
        {
            $task_id = $task->{Globals::FLD_NAME_TASK_ID};
        } 
        else 
        {
            $task_id = Globals::DEFAULT_VAL_0;
        }
        ?>
        <select id="TaskCategory_category_id" name='TaskCategory[category_id]' onchange="loadvirtualtaskform(this.value,<?php echo $task_id ?>)" class ="span6" >
            <option value=''><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_select_task_category')); ?></option>
            <?php echo UtilityHtml::getVirtualTaskCategoryListNasted($category_id); ?>
        </select>
    </div>
</div>
<?php $this->endCache(); } 
if(CommonUtility::IsProfilingEnabled())
{
   Yii::endProfile('virtualtaskCatgView');
}
?>
