<div class="container content">
    <!-- Left bar starts -->
    <div class="col-md-3">
        <!--erandoo start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--erandoo end here-->
        
        <!--Instant Navigations start here-->
        <?php $this->renderPartial('//notification_new/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_NOTIFICATION)); ?>
        <!--Instant Navigations ends here-->
    </div>
    <!-- Left bar ends -->
     
    <!-- Right bar starts -->
    <div class="col-md-9 sky-form">
        <!--Right Navigations start here-->
        <?php echo $this->renderPartial('//notification_new/_rightNav', array('model'=>$model,'notifications' => $notifications),true,false); ?> 
        <!--Right Navigations ends here-->
    </div>
    <!-- Right bar starts -->
</div>