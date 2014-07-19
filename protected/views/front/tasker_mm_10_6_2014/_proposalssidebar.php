<div class="panel panel-default margin-bottom-20 sky-form">
         <div class="panel-heading"><h3 class="panel-title"><a href="#collapse-Two" data-parent="#accordion" data-toggle="collapse">
            <?php echo Yii::t('tasker_mytasks', 'Proposals')?>
            <span class="accordian-state"></span>
            </a></h3>
         </div>
         <div class="panel-collapse collapse in sky-form" id="collapse-Two">
             <div class="panel-body pdn-auto2">
             <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadAllProposalsSidebar',
                    'dataProvider' => $proposals,
                    'itemView' => '_viewallproposalssidebar',
                    'template'=>'{items}',
                    ));
                ?>
             </div>
         </div>
      </div>