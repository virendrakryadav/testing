<!--Left bar start here-->
<div class="col-md-3">
<!--Dashbosrd start here-->
<?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--Dashbosrd start here-->

<!--left nav start here-->
<div class="margin-bottom-30">

<div class="notifi-set">
    <ul>
  <li><a  href="#" onclick="return gotoAccount()">Account</a></li>
  <li><a href="#" onclick="return gotoEmail()">Email/Password</a></li>
  <li><a href="#" onclick="return gotoProfile()">Profile</a></li>
  <li><a href="#" onclick="return gotoMoney()">Money</a></li>
  <li><a href="#" onclick="return gotoNotifications()">Notifications</a></li> 
  <li><a href="#"  onclick="return gotoLocations()">Locations</a></li>
    </ul>
    </div>
<div class="clr"></div></div>
<!--left nav Ends here-->

<div class="margin-bottom-30" id="btnDiv" style="display:none;">
<button class="btn-u btn-u-lg rounded btn-u-red push" type="button">Cancel</button>
<button class="btn-u btn-u-lg rounded btn-u-sea push" type="button">Save</button>
</div>

</div>