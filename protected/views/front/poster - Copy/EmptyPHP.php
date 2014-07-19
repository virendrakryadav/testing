<style>
    .tasklist_box {
    border: 1px solid;
    border-color: olive;
    margin: 10px !important;
    margin: 0 0 10px;
    overflow: hidden;
    padding: 4px 4px 10px;
}
.tasklist_box img {
    border: 1px solid #D3D4E2;
    float: left;
    margin-right: 10px;
}
.tasklist_box .date {
    color: #888888;
    font-size: 10px;
}
.tasklist_box p {
    line-height: 18px;
    margin: 0;
    padding: 0;
}
</style>
<!--this div for template description in popup-->
<div id="templatdiv" class="templatdiv" style="display: none;"></div>
<!--this div for template description in popup-->
<div class="page-container pagetopmargn">

<!--Left side bar start here-->
<div class="leftbar">
<!--Previoue tast start here-->
<div class="box">
<div class="box_topheading"><h3 class="h3">Find Task</h3></div>
<div class="box2" id="loadPreviewTask">
<?php //$this->renderPartial('_findtask'); ?>
    <?php  $this->renderPartial('_findtask',array(
    'task'=>$task,
)); ?>
</div>
</div>
<!--Previoue tast Ends here-->

<!--Template Category start here-->
<div class="box">
<div class="box_topheading"><h3 class="h3">Chat Now</h3></div>
<div class="box2" id="loadTemplateCategory">
<?php $this->renderPartial('_chatnow'); ?>
</div>
</div>
<!--Template Category tast Ends here-->

</div>
<!--Left side bar ends here-->
<!--Right side content start here-->
<div class="rightbar">
<div class="box">
<div class="box_topheading"><h3 class="h3">Task List</h3></div>
<?php
//echo"<pre>";
//print_r($task);
//exit();
$this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$task,
        'itemView'=>'_taskerlist',
        'viewData'=>array('dataProvider'=>$task)
)); ?>
</div>
</div>
<!--Right side content ends here-->


  </div>

