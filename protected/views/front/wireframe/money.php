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
  <li><a href="#" class="active">Money</a></li>
  <li><a href="#">Notifications</a></li> 
  <li><a href="#">Locations</a></li>
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
<h2 class="h2">Money</h2>
<p class="margin-bottom-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>


<!--Money account setting start here-->
<div class="margin-bottom-30 overflow-h">

<div class="grad-box margin-bottom-30 no-border">
<div class="vtab3">
<ul>
<li><a href="#" class="active">Account</a></li>
<li><a href="#">Activity</a></li>
<li><a href="#">Reports</a></li>
<li><a href="#">Tax Records</a></li>
</ul>
</div>
<div class="clr"></div> 
</div>

<div class="margin-bottom-10 overflow-h">
<div class="f-left"><h3 class="no-mrg">Account</h3></div>
<div class="new-location">
<button class="btn-u rounded btn-u-sea" onclick="displayAddFilesController();" type="button"><i class="fa fa-plus"></i> New Card</button>
</div>
</div>
<div class="col-md-12 no-mrg">
<div class="table-responsive sky-form">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Account</th>
<th class="center">Primary</th>
<th class="center">Action</th>
</tr>
</thead>

<tbody>
<tr>
<td>Visa 3600</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center">
<a href="#"><i class="fa fa-trash-o"></i></a></td>
</tr>

<tr>
<td>MC 4589</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center">
<a href="#"><i class="fa fa-trash-o"></i></a></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!--Money account setting ends here-->

<!--Money Credit/Debit Card setting start here-->
<div class="margin-bottom-30 overflow-h">
<div class="margin-bottom-10 overflow-h">
<div class="f-left"><h3 class="no-mrg">Credit/Debit Card</h3></div>
<div class="new-location">
<button class="btn-u rounded btn-u-sea" onclick="displayAddFilesController();" type="button"><i class="fa fa-plus"></i> New Account</button>
</div>
</div>
<div class="col-md-12 no-mrg">
<div class="table-responsive sky-form">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Card</th>
<th class="center">Primary</th>
<th class="center">Action</th>
</tr>
</thead>

<tbody>
<tr>
<td>Visa 3600</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center">
<a href="#"><i class="fa fa-trash-o"></i></a></td>
</tr>

<tr>
<td>MC 4589</td>
<td class="center"><input type="radio" name="radio-inline"><i class="rounded-x"></i></td>
<td class="center">
<a href="#"><i class="fa fa-trash-o"></i></a></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!--Money Credit/Debit Card setting ends here-->

<!--Money Add Credit/Debit Card details start here-->
<div class="add-location">
<div class="col-md-12 no-mrg">
<div class="f-left"><h3 class="margin-bottom-20">Add Card Details</h3></div>
<div class="f-right1"> 
<a href="#"><img src="../images/bid-close.png"></a>
</div>
</div>

<div class="grad-box margin-bottom-30 no-border">
<div class="vtab">
<ul>
<li><a class="active" href="#">Visa</a></li>
<li><a href="#">MC</a></li>
<li><a href="#">AMX</a></li>
</ul>
</div>
<div class="clr"></div> 
</div>

<div class="col-md-12 no-mrg2">
<label class="text-size-14">Card Number</label>
<input type="text" placeholder="Enter your card number" class="form-control">
</div>

<div class="col-md-12 no-mrg2">
<label class="text-size-14">Name On Card</label>
<input type="text" placeholder="Enter your name on card" class="form-control">
</div>

<div class="col-md-12 no-mrg2">
<div class="col-md-5 no-mrg">
<label class="text-size-14">Expiration</label>
<input type="date" placeholder="10/2016" class="form-control">
</div>
<div class="col-md-4">
<label class="text-size-14">CVV</label>
<input type="text" placeholder="345" class="form-control">
</div>
</div>

<div class="col-md-12 no-mrg">
<div class="new-location">
<button type="button" class="btn-u btn-u-lg rounded btn-u-red push">Cancel</button>
<button type="button" class="btn-u btn-u-lg rounded btn-u-sea push">Add</button>
</div>
</div>

</div>

<!--Money Add Credit/Debit Card details ends here-->
</div>
<!--Right part ends here-->

</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

