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
<li class="margin-bottom-20"><span class="vstep1a">1</span> <span class="vtext1">Category</span></li>
<li class="margin-bottom-20"><span class="vstep1">2</span> <span class="vtext">Details</span></li>
<li class="margin-bottom-20"><span class="vstep1">3</span> <span class="vtext">Hire</span></li>
</ul>
</div>
<!--left nav Ends here-->

<!--left Button Start here-->
<div class="margin-bottom-30">
<button type="button" class="btn-u btn-u-red">Cancel</button>
<button type="button" class="btn-u btn-u-sea">Enter Details</button>
</div>
<!--left Button Ends here-->




</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9">
<h2 class="h2">New Project</h2>

<!--top tab start here-->
<div class="grad-box margin-top-bottom-30">
<div class="vtab">
<ul>
<li><a href="#" >Virtual</a></li>
<li><a href="#" >In Person</a></li>
<li><a href="#" class="active">Instant</a></li>
</ul>
</div>
</div>
<!--top tab ends here-->

<!--Choose a Category and Subcategory Start here-->

<div class="margin-bottom-30">
<h3>Choose a Category</h3>
<div class="col-md-5 mrg-all">
<select class="form-control">
<option value="0">Choose a category</option>
<option value="1">Alexandra</option>
<option value="2">Alice</option>
<option value="3">Anastasia</option>
<option value="4">Avelina</option>
</select></div>
</div>

<div class="margin-bottom-30">
<div class="col-md-12 mrg-all"><h3>Choose a Subcategory</h3></div>
<div class="col-md-7 mrg-bottom">
<div class="v-search2">
<div class="v-searchcol1">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-searchic.png">
 </div>
<div class="v-searchcol4"><input type="text" placeholder="Search Cateogories" name=""></div>
<div class="v-searchcol5">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-closeic.png">
</div>
</div>
</div>
<div class="col-md-12 no-mrg"><img src="../images/cat-slid.jpg"></div>
</div>

<!--Choose a Category and Subcategory Ends here-->


<!--Right part ends here-->

</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

