<?php
//print_r($task);
$getRating = new RatingLocale();
$rating = 0;
//$rating = $_GET['over_rt'];
?>
<!--Project detail Start here-->
<?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task , 'model' => $model)); ?>
<!--Project detail Ends here-->

<!--Upload Receipts Start here-->
<div class="col-md-12 no-mrg">
    <?php //echo CHtml::encode(Yii::t('tasker_projectcompletion', 'txt_rate_your_experience')); ?>
<h4 class="panel-title">Rate Your Experience With John Smith</h4>
<p class="margin-bottom-15"><?php echo Yii::t('user_alert','rate_your_experience_text');?></p>
</div>
<!--Upload Receipts Ends here-->

<!--Ratting Start here-->
<div>
    <input type="hidden" name="over_rt" id="over_rt" value="">
    <input type="hidden" name="task_id" id="task_id" value="<?php echo $task->{Globals::FLD_NAME_TASK_ID}?>">
    <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $task->{Globals::FLD_NAME_CREATER_USER_ID}?>">
</div>
<div class="col-md-12 ratting-bg">
    <?php
        $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $getRating->getRatingForDoer(),
                    'itemView' => 'partial/_tasker_review_rate_list',
                    'viewData' => array('dataProvider' => $getRating->getRatingForDoer(),'task' => $task),
                    'summaryText' => '',
                ));
                ?>

    <div class="col-md-12 mrg-bottom border-top">Overall Rating
        <div class="avgrating"><?php  CommonUtility::displayOverAllRating('overall_rating',$rating);?></div>
        <div class="clr"></div>
    </div>
</div>
<!--Ratting Ends here-->