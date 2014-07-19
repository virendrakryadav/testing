<style>

.rightbartaskdetail {
    float: right;
    margin-top: 20px;
    padding: 20px 0 10px 2px;
    width: 268px;
}
</style>
<script>
function viewProposal()
{    
    $("#proposal").fadeIn(500);
}
</script>
<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->
<div class="page-container pagetopmargn">    
<!--Left side content start here-->
<div class="leftbartaskdetail" style="width:895px;float: left;">
    <div><a href="<?php echo Yii::app()->createUrl('poster/tasklist');?>">
            <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_back_to_task_list')); ?>
            </a></div>
<div class="controls-row pdn4">
<div class="controls-row">
<!--Task title start here-->
<div class="controls-row">
<div class="controls-row">
<div class="taskpreview_img">   
    <img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID},  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="150px" height="150"></div>

<div class="taskpreview_title">
<h3 class="h3-1"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></h3>
<span class="postedby">Posted by <a href="#"><?php echo CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}); ?></a></span>
<span class="postedby"><i class="icon-map-marker"></i><?php echo $model->{Globals::FLD_NAME_COUNTRY_CODE}; ?></span>
<span class="postedby"><?php echo CommonUtility::agoTiming($task->created_at); ?></span></div>
<?php
$daysleft = CommonUtility::leftTiming($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
?>
<div class="estimated">
    <span>
        <p>
            <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_estimated')); ?>
            </p>
        <p class="priceit"><?php echo Globals::DEFAULT_CURRENCY.$task->{Globals::FLD_NAME_PRICE}; ?></p>
    </span>
    <?php
    if($daysleft>0)
        {
    ?>
    <div class="send_proposal" onclick="viewProposal()">
        <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_send_proposal')); ?>
        </div>
    <?php
        }
    ?>
</div>
</div>
<div class="taskcount">
<div class="taskcount_col1"><span class="point">0</span><br/>
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_proposals')); ?>
    </div>
<div class="taskcount_col1"><span class="point">0</span><br/>
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')); ?>
    </div>
<div class="taskcount_col1"><?php echo UtilityHtml::getPriceOfTask($task->{Globals::FLD_NAME_TASK_ID}); ?></div>
<div class="datecount_col1"><?php

echo UtilityHtml::getBidStatus($task->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}); ?></div>
</div>
</div>
<!--Task title ends here-->

<!--Skills needed start here-->

<div class="controls-row">
<h2 class="taskheading">
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_skills_need')); ?>
    </h2>
<div class="skills">
    <?php echo UtilityHtml::taskSkills($task->{Globals::FLD_NAME_TASK_ID}); ?>
</div>
</div>
<!--Skills needed ends here-->

<!--Description Start here-->
<div class="controls-row">
<h2 class="taskheading">
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_description')); ?>
    </h2><?php echo $task->description; ?></div>
<!--Description Ends here-->

<!--Requirements & details Start here-->
<div class="controls-row">
<h2 class="taskheading">
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_req_and_detail')); ?>
    </h2>
<div class="controls-row"><div class="name_ic"><img src="../images/vis-ic.png"></div>
    <?php echo CommonUtility::getPublicDetail($task->is_public);  ?></div>
</div>
<div class="controls-row">
    <?php echo UtilityHtml::getAttachments($task->{Globals::FLD_NAME_TASK_ATTACHMENTS},$model->profile_folder_name);  ?>

</div>
<!--Requirements & details Ends here-->

<!--Invited tasker start here-->
<?php
$question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
if(!empty($question))
{
?>
<div class="controls-row">
<h2 class="taskheading">
    <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_que_and_ans')); ?>
    </h2>
<?php
$i=1;
foreach($question as $questions)
    {
        echo $i.'. '.$questions->categoryquestionlocale->question_desc."<br>";
        $i++;
    }
?>
</div>
<?php
}
?>
<!--Invited tasker ends here-->

</div>
</div>



    <div class="controls-row pdn4" id="proposal" style="display: none">
<div class="controls-row">
    <div class="box_topheading">
        <h3 class="h3">
            <?php echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_make_an_proposal')); ?>
            </h3>
    </div>
<!--Invited tasker start here-->
<div class="controls-row" style="padding: 10px">
<div><input type="text" placeholder="Estimated cost(min.$25)"></div>
<div><textarea placeholder="Write your proposal" style="width: 99%;" rows="7" ></textarea></div>
<div><a>Add attechment</a></div>
<div>
    <?php
$question = TaskQuestion::getTaskQuestion($task->{Globals::FLD_NAME_TASK_ID});
$i=1;
foreach($question as $questions)
    {
        echo $i.'. '.$questions->categoryquestionlocale->question_desc."<br>";
        echo"<strong>Ans:-</strong>";
        echo UtilityHtml::getQuestionInputType($questions->categoryquestion->question_type,$i);
        echo "<br>";
        $i++;
    }
?>
</div>
<div style="float: right"><input  class="sign_bnt" type="submit" value="Send proposal"></div>
</div>
<!--Invited tasker ends here-->

</div>
</div>


</div>

<!--left side content ends here-->
<div class="rightbartaskdetail">
    
    <div class="box">
        <div class="box_topheading">
        <h3 class="h3">Task posted by</h3>
        </div>
            <div id="loadPreviewTask" class="box2">
            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>

            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>
            </div>
     </div>

    <div class="box">
        <div class="box_topheading">
        <h3 class="h3">Share this Task</h3>
        </div>
            <div id="loadPreviewTask" class="box2">
            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>

            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>
            </div>
    </div>

    <div class="box">
        <div class="box_topheading">
        <h3 class="h3">Invited tasker</h3>
        </div>
            <div id="loadPreviewTask" class="box2">
            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>

            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>
            </div>
    </div>
    <div class="box">
        <div class="box_topheading">
        <h3 class="h3">Related Task</h3>
        </div>
            <div id="loadPreviewTask" class="box2">
            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>

            <div class="prvlist_box"> <a href="#"><img src="../images/prv_img.jpg" width="71" height="52"></a>
                <p class="title">Candy</p>
                <p class="date">Done by : John     21-01-2014</p>
            </div>
            </div>
    </div>

  </div>