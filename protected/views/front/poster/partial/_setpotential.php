<?php
// echo CHtml::ajaxLink('<img src="'.CommonUtility::getPublicImageUri( "unfevorite.png" ).'">', Yii::app()->createUrl('tasker/setpotential'), array(
//                    'dataType' => 'json', 
//                    'data' => array('taskId' => $taskId), 
//                    'type' => 'POST',         
//                    'success' => 'function(data){
//                        if(data.status==="success")
//                        {
//                            $(\'#potentialFor_'.$taskId.'\').html(data.html);
//                        }
//                        else
//                        {
//                            alert("'.Yii::t('tasker_createtask','unexpected_error').'");
//                        }
//                    }'), 
//                        array('id' => 'setpotential'.$taskId, 'class' => '', 'live' => false));
?>
<a id="setpotential<?php echo $id ?>" onclick="setpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>')" href="javascript:void(0)"><img src="<?php echo CommonUtility::getPublicImageUri( "unfevorite.png" ) ?>"></a>