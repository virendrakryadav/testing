<?php 
//echo $row*$index; ?>
<div class="rowselector">
    <div class="controls-row pdn6"> 
<div class="task_list">
<!--<div class="item_labelgreen">
<span class="task_label_text2">Network</span>
</div>-->
<div class="tasker_row1">

<div class="proposal_col2">
<div class="proposal_row">
<p class="task_name"><b><?php echo CHtml::encode('name'); ?>:</b>
        <?php echo CHtml::encode($data->name); ?>
</p>
<div class="proposal_col4 "><b><?php echo CHtml::encode('age'); ?>:</b>
        <?php echo CHtml::encode($data->age); ?></div>
<div class="publctask">
<article><b><?php echo CHtml::encode('sex'); ?>:</b>
        <?php echo CHtml::encode($data->sex); ?></article>
        <?php  //echo $description = CommonUtility::truncateText( $data->{Globals::FLD_NAME_DESCRIPTION} , Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT ); ?></div>
</div>                
</div>

</div>
</div>
</div>              
</div>
