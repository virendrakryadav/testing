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
?>
<a id="unsetpotential<?php echo $id ?>" onclick="unsetpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>' ,'<?php echo $textCustomSave ?>' , '<?php echo $textCustom ?>' )" href="javascript:void(0)" >
    <?php
    if(isset($options['removeText']))
    {
        echo $options['removeText'];
    }
    else 
    {
     ?>
     <img src="<?php echo CommonUtility::getPublicImageUri( "fevorite.png" ) ?>">
    <?php
        
    }?>
   </a>