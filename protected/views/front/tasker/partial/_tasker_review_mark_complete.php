
<?php $this->renderPartial('partial/_task_detail_header' , array( 'task' => $task , 'model' => $model)); ?>

<!--Project detail Ends here-->

<!--Project detail message Start here-->
<div class="col-md-11 mrg-auto overflow-h">
<p class="project-text">Are you ready to close this job? Simply click </br>
complete to confirm!</p>
</div>
<!--Project detail message Ends here-->

<!--Button Start here-->
<div class="project-btn mrg-auto overflow-h">
<div class="project-col3"><a onclick="cancelReview()">
        <span><img src="<?php echo CommonUtility::getPublicImageUri("project-cancel-btn.png") ?>"></span>
<span>Cancel</span>
</a></div>
<div class="project-col4"><a onclick="goStep2()" ><img src="<?php echo CommonUtility::getPublicImageUri("project-complete-btn.png") ?>">
<span>Complete</span></a></div>
</div>