<!--Left bar start here-->

<!--Dashbosrd start here-->
<?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--Dashbosrd start here-->

<!--left nav start here-->
<div class="margin-bottom-30">

<div class="notifi-set">
    <ul>
  <li><a  href="<?php echo Yii::app()->createUrl('user/accountsetting')?>">Account</a></li>
  <li><a href="<?php echo Yii::app()->createUrl('user/changepassword')?>">Email/Password</a></li>
  <li><a href="#">Profile</a></li>
  <li><a href="#">Money</a></li>
  <li><a href="#" onclick="return gotoNotifications()">Notifications</a></li> 
  <li><a href="#"  onclick="return gotoLocations()">Locations</a></li>
    </ul>
    </div>
<div class="clr"></div></div>
<!--left nav Ends here-->

