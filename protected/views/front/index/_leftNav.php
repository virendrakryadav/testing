<?php 
			  $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'left', // 'above', 'right', 'below' or 'left'
              
    'tabs'=>array(
		array('icon' => 'icon-user','label'=>Yii::t('index_index_navbar','change_password_text'), 'content'=>$this->renderPartial('//index/_changepassword', array('model'=>$model),true,false), 'active'=>true),
    ),
)); ?>
