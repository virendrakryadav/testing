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
//    
//                    array('id' => 'setpotential'.$taskId, 'class' => '', 'live' => false));
?>
<?php
$textCustom = '';
$textCustomSave = '';
$saveClass = '';
$removeClass = '';
if(isset($options['removeText']) &&  $options['removeText'] != '' )
{
    $textCustom = $options['removeText'];
}
if(isset($options['saveText']) &&  $options['saveText'] != '')
{
    $textCustomSave = $options['saveText'];
}
if(isset($options['saveClass']) &&  $options['saveClass'] != '')
{
    $saveClass = $options['saveClass'];
}
if(isset($options['removeClass']) &&  $options['removeClass'] != '')
{
    $removeClass = $options['removeClass'];
}

//print_r($options);
if(isset($savebutton))
{
   ?>
<a style="color: #fff;" id="setpotential<?php echo $id ?>" onclick="setpotentialSave('<?php echo $bookmark_type; ?>','<?php echo $id; ?>')" href="javascript:void(0)">Save</a>
<?php 
}
else
{
?>
<a class="<?php echo $saveClass ?>" id="setpotential<?php echo $id ?>" title="<?php echo Yii::t('tasklist','Add to favorite list') ?>" onclick="setpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>','<?php echo $textCustomSave ?>' , '<?php echo $textCustom ?>', '<?php echo $saveClass ?>' , '<?php echo $removeClass ?>' )" href="javascript:void(0)">
     <?php
    if(isset($options['saveText']) &&  $options['saveText'] != '')
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
<?php
}
?>