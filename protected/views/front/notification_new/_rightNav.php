<?php 
//    $this->widget('bootstrap.widgets.TbTabs', array(
//    'type'=>'tabs',
//    'placement'=>'left', // 'above', 'right', 'below' or 'left'
//    ));
?>
<?php echo $this->renderPartial('//notification_new/_notifications', array('model'=>$model,'notifications' => $notifications),true,false); ?>   
