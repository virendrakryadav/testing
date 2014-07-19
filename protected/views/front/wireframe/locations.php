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
<span class="input-group-btn"></span>
<select class="form-control das-input dashome">
<option>Dashboard</option>
</select>
</div>
<div class="clr"></div>             
</div>
</div>
<!--Dashbosrd start here-->

<!--left nav start here-->
<div class="margin-bottom-30">
<div class="notifi-set">
    <ul>
  <li><a  href="#">Account</a></li>
  <li><a href="#">Email/Password</a></li>
  <li><a href="#">Profile</a></li>
  <li><a href="#">Money</a></li>
  <li><a href="#">Notifications</a></li> 
  <li><a href="#" class="active">Locations</a></li>
    </ul>
    </div>
<div class="clr"></div></div>

<div class="margin-bottom-30">
<button class="btn-u btn-u-lg rounded btn-u-red push" type="button">Cancel</button>
<button class="btn-u btn-u-lg rounded btn-u-sea push" type="button">Save</button>
</div>
<!--left nav Ends here-->


</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9">
<h2 class="h2">Profile</h2>
<p class="margin-bottom-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>


<!--Locations setting start here-->
<div class="margin-bottom-10 overflow-h">
<div class="f-left"><h3 class="no-mrg">Locations</h3></div>
<div class="new-location">
<button class="btn-u rounded btn-u-sea" onclick="displayAddFilesController();" type="button"><i class="fa fa-plus"></i> New Location</button>
</div>
</div>
<div class="col-md-12 no-mrg">
<div class="table-responsive sky-form">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Location Name</th>
<th>Address</th>
<th class="center">Default</th>
<th class="center">Action</th>
</tr>
</thead>

<tbody>
<tr>
<td>Home</td>
<td>2004 First Ave New York NY 10028</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center"><a href="#"><img src="../images/del-ic.png"></a></td>
</tr>

<tr>
<td>Work</td>
<td>1998 Atlantic Ave Brooklyn NY 10128</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center"><a href="#"><img src="../images/del-ic.png"></a></td>
</tr>


</tbody>
</table>
</div>

</div>

<!--Add new locations start here-->
<div class="add-location">
<div class="col-md-12 no-mrg">
<div class="f-left"><h3 class="margin-bottom-20">Add New Location</h3></div>
<div class="f-right1"> 
<a href="#"><img src="../images/bid-close.png"></a>
</div>
</div>
<div class="col-md-12 no-mrg2">
<label class="text-size-14">Location</label>
<input type="email" class="form-control" placeholder="Enter your location">
</div>

<div class="col-md-12 no-mrg2">
<label class="text-size-14">Zip Code</label>
<input type="email" class="form-control" placeholder="Enter your zip code">
</div>

<div class="col-md-12 no-mrg2">
<label class="text-size-14">City</label>
<input type="email" class="form-control" placeholder="Enter your city">
</div>

<div class="col-md-12 no-mrg2">
<label class="text-size-14">State</label>
<input type="email" class="form-control" placeholder="Enter your state">
</div>

<div class="col-md-12 no-mrg3">
<label class="text-size-14">Country </label>
<select class="form-control mrg5">
<option>Select your country</option>
</select>
</div>

<div class="col-md-12 no-mrg">
<div class="new-location">
<button class="btn-u btn-u-lg rounded btn-u-red push" type="button">Cancel</button>
<button class="btn-u btn-u-lg rounded btn-u-sea push" type="button">Save</button>
</div>
</div>

</div>
<!--Add new locations ends here-->

<!--Locations setting ends here-->

</div>
<!--Right part ends here-->

</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

