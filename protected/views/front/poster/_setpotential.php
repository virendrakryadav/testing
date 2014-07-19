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
$textCustom = '';
$textCustomSave = '';
if(isset($options['removeText']))
{
    $textCustom = $options['removeText'];
}
if(isset($options['saveText']))
{
    $textCustomSave = $options['saveText'];
}
//print_r($options);
?>
<a id="setpotential<?php echo $id ?>" onclick="setpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>','<?php echo $textCustomSave ?>' , '<?php echo $textCustom ?>' )" href="javascript:void(0)">
    <?php
    if(isset($options['saveText']))
    {
        echo $options['saveText'];
    }
    else 
    {
     ?>
    <img src="<?php echo CommonUtility::getPublicImageUri( "unfevorite.png" ) ?>">
    <?php
        
    }?>
    </a>