<?php 
			  $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'left', // 'above', 'right', 'below' or 'left'
              
    'tabs'=>array(
		array('icon' => 'icon-time','active'=>true,'label'=>Yii::t('index_partial_navbar','notifications'), 'content'=>$this->renderPartial('//notification/_notifications', array('model'=>$model,'notifications' => $notifications),true,false)),
    ),
)); ?>
