<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/bootstrap-theme.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/app.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>



<div class="container content">

<!--Left bar start here-->
<div class="col-md-3">
<!--Dashbosrd start here-->
<div class="margin-bottom-30">
<div class="grad-box">
<div class="col-md-12"><h2 class="heading-md color-orange">erandoo</h2></div>
<div class="col-md-12">
<span class="das-col"><a href="#"><img src="../images/das-ic-1.png"></a> </span>
<span class="das-col"><a href="#"><img src="../images/das-ic2.png"></a> </span>
<span class="das-col"><a href="#"><img src="../images/das-ic3.png"></a> </span>  
</div>
<div class="col-md-12">
<span class="input-group-btn">fdf</span>
<select class="form-control das-input dashome">
<option>Dashboard</option>
</select>
</div>             
</div>
</div>
<!--Dashbosrd start here-->

<!--left nav start here-->
<div class="margin-bottom-30">
<ul class="v-step">
<li class="margin-bottom-20"><span class="vstep1a">1</span> <span class="vtext1">Mark Complete</span></li>
<li class="margin-bottom-20"><span class="vstep1">2</span> <span class="vtext">Receipts</span></li>
<li class="margin-bottom-20"><span class="vstep1">3</span> <span class="vtext">Rate</span></li>
<li class="margin-bottom-20"><span class="vstep1">4</span> <span class="vtext">Payment</span></li>
</ul>
</div>
<!--left nav Ends here-->

<!--left Button Start here-->
<div class="margin-bottom-30">
<button type="button" class="btn-u btn-u-red">Cancel</button>
<button type="button" class="btn-u btn-u-sea">Receipts</button>
</div>
<!--left Button Ends here-->




</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9">
<h2 class="h2">Project Completion</h2>
<!--Project detail Start here-->
<div class="col-md-11 mrg-auto overflow-h">
<div class="project-col">
<span class="project-col2">Posted By</span>
<img src="../images/tasker-img.jpg">
<span class="project-col2"><a href="#">John Smith</a></span>
</div>
<div class="project-cont">
<div class="tasker_row1">
<div class="proposal_row no-mrg">
<div class="col-md-10 no-mrg">
<span class="proposal_title">
<a href="#">Clean out tivoli enterprise console database </a></span></div>
<div class="project-price"><span class="proposal_price">$200</span></div>
</div>
<div class="proposal_col4 ">Posted: <span class="date">07-04-2013 </span></div>
<div class="proposal_col4 ">Start date: <span class="date">07-04-2013 </span></div>
</div>  
</div>
</div>
<!--Project detail Ends here-->

<!--Project detail message Start here-->
<div class="col-md-11 mrg-auto overflow-h">
<p class="project-text">Are you ready to close this job? Simply click </br>
complete to confirm!</p>
</div>
<!--Project detail message Ends here-->

<!--Button Start here-->
<div class="project-btn mrg-auto overflow-h">
<div class="project-col3"><a href="#">
<span><img src="../images/project-cancel-btn.png"></span>
<span>Cancel</span>
</a></div>
<div class="project-col4"><a href="#"><img src="../images/project-complete-btn.png">
<span>Complete</span></a></div>
</div>
<!--Button Ends here-->

</div>
<!--Right part ends here-->

</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

