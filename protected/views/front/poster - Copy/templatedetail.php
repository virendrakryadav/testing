<div class="create_account">
<div class="create_account_popup">    
<?php
if(!empty($msg))
{    
    ?>
        <div class="popup_head">
                <h2 class="heading">
                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_no_title')); ?>
                </h2>
            <button type="button" onclick="document.getElementById('templatdiv').style.display='none';" id="cboxClose"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_close')); ?></button>
        </div>
                <div class="create_acunt_inner"><?php echo $msg; ?></div><?php
}
foreach ($category as $cat) 
{
    $template = json_decode($cat->categorylocale[Globals::FLD_NAME_TASK_TEMPLATES], true);
    ?>    
            <div class="popup_head">
                <h2 class="heading"><?php echo $template[$templateId][Globals::FLD_NAME_TITLE]; ?></h2><button type="button" onclick="document.getElementById('templatdiv').style.display='none';" id="cboxClose"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_close')); ?></button>
            </div>
            <div class="create_acunt_inner">
                <?php echo $template[$templateId][Globals::FLD_NAME_DESC]; ?>
                <input type="hidden" id="templateTitle<?php echo $templateId;?>" value="<?php echo $template[$templateId][Globals::FLD_NAME_TITLE]; ?>">
                <input type="hidden" id="templateDetail<?php echo $templateId;?>" value="<?php echo $template[$templateId][Globals::FLD_NAME_DESC]; ?>">
                <div>
                    <div style="float: right;cursor: pointer;" ><button class="sign_bnt" onclick="templateDetailFill(<?php echo $templateId;?>)"><?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_use_this_template')); ?></button></div>
                </div>
            </div>        
    <?php
}
?>   
    </div>
    </div>