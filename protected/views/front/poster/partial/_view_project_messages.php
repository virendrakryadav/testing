<!--<h3 class="border-bot1">Public Questions</h3>    
<div class="col-md-12 no-mrg question-bg overflow-h">
    <div class="post-question">
        <a href="javascript:void(0)" onclick="postQuestion()"><?php echo CHtml::encode(Yii::t('poster_projectdetail', 'txt_post_a_question')); ?></a>
    </div>    
   
</div>-->
<h3>Messages</h3>    
<div class="proposal_list margin-bottom-10">
<?php  $this->renderPartial('//poster/partial/_view_send_messages', array( 'task' => $task , 'message' => $message)); ?>


<div class="tasker_row1">
    
    
    <?php

    $this->widget('zii.widgets.CListView', array(
        'id' => 'loadAllMessages',
        'emptyText' => Yii::t('tasklist',' '),
        //'emptyTagName' => 'div class="box2"',
        'dataProvider' => $messagesOnTask,
        'viewData' => array( 'task' => $task,),

        'itemView' => '//poster/partial/_view_messages',
        'enableHistory' => true,

        'template'=>'{items}{pager}',
      //  'summaryCssClass'=>'ntointrested',
       // 'summaryText' => Yii::t('tasklist','Found {count} proposals'),
        'afterAjaxUpdate' => "function(id, data) {
                                    $('article').readmore({maxHeight: ".Globals::DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT.",speed: ".Globals::DEFAULT_VAL_READ_MORE_OPEN_SPEED.",moreLink: '<a href=\"#\">".Yii::t('tasklist', 'Read More')."</a>', lessLink: '<a href=\"#\">".Yii::t('tasklist', 'Read Less')."</a>',});
                  jQuery.ias({
                        'history':false,
                        'triggerPageTreshold':0,
                        'trigger':'Show more',
                        'container':'#loadAllMessages.list-view',
                        'item':'.rowselector',
                        'pagination':'#loadAllMessages .pager',
                        'next':'#loadAllMessages .next:not(.disabled):not(.hidden) a',
                        'loader':'Loading...'});              

            }",
        'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.rowselector',
                        'itemsSelector' => '.list-view',
                        'listViewId' => 'loadAllMessages',
                        'header' => '',
                        'loaderText' => 'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 0, 'trigger' => 'Show more'),
                    ),
                    ));
    
    ?>
    

<!--<div class="showmore"><a href="#">Show more</a></div>-->
</div>
</div>

<!--Message Ends here-->
