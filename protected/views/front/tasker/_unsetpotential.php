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
if(isset($savebutton))
{
   ?>
    <a style="color: #fff;font-weight: bold" id="unsetpotential<?php echo $id ?>" onclick="unsetpotentialSave('<?php echo $bookmark_type; ?>','<?php echo $id; ?>')" href="javascript:void(0)">Saved</a>
<?php 
}
else
{ 
?>
    <a  class="<?php echo $removeClass ?>" id="unsetpotential<?php echo $id ?>" title="<?php echo Yii::t('tasklist','Remove from favorite list') ?>" onclick="unsetpotential('<?php echo $bookmark_type; ?>','<?php echo $id; ?>','<?php echo $textCustomSave ?>' , '<?php echo $textCustom ?>' , '<?php echo $saveClass ?>' , '<?php echo $removeClass ?>')" href="javascript:void(0)" >
    <?php
    if(isset($options['removeText']) &&  $options['removeText'] != '')
    {
        echo $options['removeText'];
    }
    else 
    {
     ?>
     <img src="<?php echo CommonUtility::getPublicImageUri( "fevorite.png" ) ?>">
    <?php
        
    }?>
     <!--<img src="<?php echo CommonUtility::getPublicImageUri( "fevorite.png" ) ?>">-->
</a>
<?php       
}
?>