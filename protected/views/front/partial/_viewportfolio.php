<div class="pro_tab">
<h2 class="h2"><?php echo  CHtml::encode(Yii::t('index_updateprofile_portfolio','lbl_portfolio_creation')) ?></h2>
<div id="yw2" class="tabs-above">
<div class="tab-content">
<div id="yw2_tab_1" class="tab-pane fade active in">
    <div id="msgPortfolio" style="display:none" class="flash-success"></div>
                <div id="addContent"> 
                <?php $this->renderPartial('//partial/_viewportfoliotabs', array('model'=>$model,'task'=>$task),false,false); ?>

                            
                </div>
</div>
</div>
</div>
</div>
