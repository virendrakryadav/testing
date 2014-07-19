<?php 
 Yii::import('ext.chosen.Chosen');
echo  Chosen::multiSelect("multilocations", '', $locations, array(
                    'data-placeholder' => $placeholder,
                    'options' => array(
                        //  'maxSelectedOptions' => 3,
                        'displaySelectedOptions' => false,
                    ),
    'class'=>'span5'
                ));
?>