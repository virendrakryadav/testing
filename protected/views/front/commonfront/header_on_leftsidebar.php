 <?php   
$userid  = Yii::app()->user->id;
	
if (isset($userid) && $userid >0)
{
    $loggedInUser = CommonUtility::getLoginUserName($userid);
            $loggedInUser = "<span class='sessionname'>".$loggedInUser."</span>";
            // $img = CommonUtility::getprofilePicMediaURI($userid);
             $img = CommonUtility::getThumbnailMediaURI($userid,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35);
    ?>
<div class="margin-bottom-30">
<div class="grad-box">
<div class="col-md-12">
    <div class="headuser"><!--<a href="#" class="popovercontent" data-placement='bottom' data-poload='<?php //echo Yii::app()->createUrl('commonfront/usermenu') ?>' ><img src="<?php echo CommonUtility::getPublicImageUri( "das-ic-1.png" );?>"></a>--></div>
<div class="headlogo"><h2 class="heading-md color-orange"><?php echo Globals::DEFAULT_APP_NAME_ERANDOO;?></h2></div>
<div class="headhelp"><a href="#"  class="popovercontent" data-placement='bottom' data-poload='<?php echo Yii::app()->createUrl('commonfront/userhelpmenu') ?>'><i class="fa fa-question-circle"></i></a></div>
<div class="clr"></div>
    
    </div>
    
<div class="col-md-12">
     
    <?php

            
            
          // exit;
            $this->widget('bootstrap.widgets.TbNav', 
                
                array(
        
                'id'=>'gcHeader',
                
                    
                'htmlOptions'=>array('class'=>'nav-menu-hoheader'),
                'encodeLabel'=>false,
	        'items'=>array(
			 
//        array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic-1.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
//        'style' => 'width:39px;height: 39px','id'=>'profileImageIconOnHeader')),	
//            'htmlOptions'=>array('class'=>'das-col'),
//            'encodeLabel'=>false,
//                    'items'=>array(
//                    array('label'=>"<i class='fa fa-dashboard'></i>".Yii::t('layout_main','lbl_dashboard'), 'url'=>Yii::app()->createUrl('index/dashboard')),                        
//                    array('label'=>"<i class='fa fa-user'></i>".Yii::t('layout_main','lbl_dropdown_my_profile'), 'url'=>Yii::app()->createUrl('index/updateprofile')),
//
//                    array('label'=>"<i class='fa fa-key'></i>".Yii::t('layout_main','lbl_dropdown_change_password'), 'url'=>Yii::app()->createUrl('index/changepassword')),
//                    '---',
//                    array('label'=>"<i class='fa fa-lock'></i>".Yii::t('layout_main','lbl_dropdown_logout'), 'url'=>Yii::app()->createUrl('index/logout')),
//                )
//            ),
                                array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic-1.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
        'style' => 'width:39px;height: 39px','id'=>'profileImageIconOnHeader')),
                         'url'=>'#','htmlOptions'=>array('class'=>'das-col popovercontent' , 'data-poload' => Yii::app()->createUrl('commonfront/usermenu'), 'data-placement' => 'bottom' )),        
                    
                    array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic2.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
    'id'=>'notificationImageIconOnHeader')),
                        'url'=>Yii::app()->createUrl('notification/index'), 'htmlOptions'=>array('class'=>'das-col popovercontent' , 'data-poload' => Yii::app()->createUrl('commonfront/usernotifications'), 'data-placement' => 'bottom' )),
				 array('label'=>CHtml::image(CommonUtility::getPublicImageUri( "das-ic3.png" ),Yii::t('layout_main','txt_alt_user_image') , array(
    'id'=>'messagesImageIconOnHeader')),'url'=>Yii::app()->createUrl('inbox/index'), 'htmlOptions'=>array('class'=>'das-col popovercontent','data-poload' => Yii::app()->createUrl('commonfront/usermessages'), 'data-placement' => 'bottom'))
				
            )
        ));


 $controller_id = Yii::app()->controller->id;
 $action_id = Yii::app()->controller->action->id;
    ?>
    
    <script>
//   $('ul#menu-droopdown li a').click(function(){
//       $('#menu-selected-item').html($(this).html());
//       $('#menu-selected-item .fa').addClass('home-size18');
//      
//   }); 
//   $(document).ready(function(){
//        $('#menu-selected-item').html($('#<?php //echo $controller_id ?>-<?php //echo $action_id ?>').html());
//        $('#menu-selected-item .fa').addClass('home-size18');
//    });
</script>

<!--<span class="das-col"><a href="javascript:void(0)"><img src="<?php echo CommonUtility::getPublicImageUri( "das-ic-1.png" ) ?>"></a> </span>
<span class="das-col"><a href="javascript:void(0)"><img src="<?php echo CommonUtility::getPublicImageUri( "das-ic2.png" ) ?>"></a> </span>
<span class="das-col"><a href="javascript:void(0)"><img src="<?php echo CommonUtility::getPublicImageUri( "das-ic3.png" ) ?>"></a> </span>  -->
</div>
<div class="col-md-12  margin-bottom-10">
<div class="btn-group width-100">
<button  id='menu-selected-item' class="btn-u btn-u-blue width-80" type="button" onclick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl('index/dashboard') ?>'">
<i class="fa fa-home home-size18"></i>Dashboard</button>
<button data-toggle="dropdown" class="btn-u btn-u-blue btn-u-split-blue dropdown-toggle width-20" type="button">
<i class="fa fa-angle-down arrow-size18 "></i>
<span class="sr-only">Toggle Dropdown</span>                            
</button>
<ul id="menu-droopdown" role="menu" class="dropdown-menu width-100">
<li><a href="<?php echo Yii::app()->createAbsoluteUrl('index/dashboard') ?>"><i class="fa fa-home"></i>Dashboard</a></li>
<li><a id='poster-createtask' href="<?php echo Yii::app()->createAbsoluteUrl('poster/createtask') ?>"><i class="fa fa-tasks"></i>Create New Project</a></li>
<li><a id='tasker-tasklist' href="<?php echo Yii::app()->createAbsoluteUrl('public/tasks') ?>"><i class="fa fa-suitcase"></i>Search Projects</a></li>
<li><a id='poster-findtasker' href="<?php echo Yii::app()->createAbsoluteUrl('poster/findtasker') ?>"><i class="fa fa-user"></i>Search Members</a></li>
<li><a id='poster-findtasker' href="<?php echo Yii::app()->createAbsoluteUrl('poster/mytasks') ?>"><i class="fa fa-suitcase"></i>My Projects as Poster</a></li>
<li><a id='poster-findtasker' href="<?php echo Yii::app()->createAbsoluteUrl('tasker/mytasks') ?>"><i class="fa fa-suitcase"></i>My Projects as Doer</a></li>


<li><a id='tasker-tasklist' href="#"><i class="fa fa-users"></i>My Teams</a></li>
<li><a id='tasker-tasklist' href="<?php echo Yii::app()->createUrl('inbox/index') ?>"><i class="fa fa-location-arrow"></i>Message Central</a></li>
<li><a id='tasker-tasklist' href="#"><i class="fa fa-gears"></i>Account Settings</a></li>
<li><a id='notification-notificationsetting' href="<?php echo Yii::app()->createAbsoluteUrl('notification/notificationsetting') ?>"><i class="fa fa-cog"></i>Notification Settings</a></li>
<li><a id='updateprofile' href="<?php echo Yii::app()->createAbsoluteUrl('index/updateprofile') ?>"><i class="fa fa-user"></i>My Profile</a></li>
<li><a id='logout' href="<?php echo Yii::app()->createAbsoluteUrl('index/logout') ?>"><i class="fa fa-cog"></i>Logout</a></li>
</ul>
</div>
</div>
<!--<div class="col-md-12">
<span class="input-group-btn">fdf</span>
<select onchange="window.location.href = this.value" class="form-control das-input dashome">
    <option value="return false">Select</option>
     <option value="<?php //echo Yii::app()->getBaseUrl(true) ?>">Home</option>
     <option value="<?php //echo Yii::app()->createAbsoluteUrl('notification/notificationsetting') ?>">Notification Settings</option>
     <option value="<?php //echo Yii::app()->createAbsoluteUrl('poster/findtasker') ?>">Find Doer</option>
     <option value="<?php //echo Yii::app()->createAbsoluteUrl('public/tasks') ?>">Find Project</option>
    <option value="<?php //echo Yii::app()->createUrl('index/dashboard') ?>">Dashboard</option>
</select>
</div>-->
<div class="clr"></div>
</div>
</div>

<?php 
}
?>