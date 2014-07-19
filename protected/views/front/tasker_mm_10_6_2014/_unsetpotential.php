<?php
// echo CHtml::ajaxLink('<img src="'.CommonUtility::getPublicImageUri( "fevorite.png" ).'">', Yii::app()->createUrl('tasker/unsetpotential'), array(
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
//                        array('id' => 'unsetpotential'.$taskId, 'class' => '', 'live' => false));
//echo $bookmark_type;exit;
?>
<a id="unsetpotential<?php echo $id ?>" title="<?php echo Yii::t('tasklist','Remove from favorite list') ?>" onclick="unsetpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>')" href="javascript:void(0)" ><img src="<?php echo CommonUtility::getPublicImageUri( "fevorite.png" ) ?>"></a>