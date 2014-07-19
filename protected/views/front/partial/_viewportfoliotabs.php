
<div id="msgPortfolio" style="display:none" class="flash-success"></div>
<div class="controls-row  nopadding"><div class="span7 nopadding"><h4></h4></div><div class="span2 space_top"><i class="icon-plus-sign"></i>
        <?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('index_updateprofile_portfolio', 'lbl_add_new_portfolio')), Yii::app()->createUrl('user/useraddportfolio'), array('success' => 'function(data){$(\'#addContent\').html(data);}'), array('id' => 'addPortfolioLink')); ?>
    </div></div>
<?php //UtilityHtml::flashMessage(); ?>
<?php
$this->widget('bootstrap.widgets.TbTabs', array(
    'id'=>'portfolioTabs',
    'type' => 'tabs',
    'placement' => 'above', // 'above', 'right', 'below' or 'left'
    'tabs' => array(
        array('id'=>'lbl_tab_task_for_you','label' => Yii::t('index_updateprofile_portfolio', 'lbl_tab_task_for_you'), 'content' => $this->renderPartial('//partial/_viewportfoliopost', array('model' => $model, 'task' => $task), true, false), 'active' => true),
        array('id'=>'lbl_tab_task_done_by_you','label' => Yii::t('index_updateprofile_portfolio', 'lbl_tab_task_done_by_you'), 'content' => $this->renderPartial('//partial/_viewportfoliotask', array('model' => $model, 'task' => $task), true, false)),
    ),
));
?>	