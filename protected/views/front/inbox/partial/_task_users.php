<?php
//echo CHtml::dropDownList(Globals::FLD_NAME_USERID, '', $userDetail)
        
        
?>
 <?php
 Yii::import('ext.chosen.Chosen');
                   // $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});

                    echo Chosen::multiSelect(Globals::FLD_NAME_TO_USER_IDS, '', $userDetail, array(
                        'data-placeholder' => 'Select user to sent message',
                        'options' => array('displaySelectedOptions' => false ),
                        'class'=>'form-control mrg3',
                       'onchange' => 'showSendButton();',
                    ));
                    ?>