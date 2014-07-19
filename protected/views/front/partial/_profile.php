             
             <div class="pro_tab">
			 
			<h2 class="h2"> <?php echo Yii::t('index_profile','edit_account_info')?></h2>
			 <?php 
			  $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>Yii::t('index_profile','personal_info'), 'content'=>$this->renderPartial('//partial/_updateprofile', array('model'=>$model),true,false), 'active'=>true),
       	array('label'=>Yii::t('index_profile','contact_info'), 'content'=>$this->renderPartial('//partial/_profile2', array('model'=>$model),true,false)),
        array('label'=>Yii::t('index_profile','address_info'), 'content'=>$this->renderPartial('//partial/_addressinfo', array('model'=>$model),true,false)),
  
        ),
 
)); ?></div>
              	

