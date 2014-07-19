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
<script>
function savebookmark(bookmark_type,id)
    {
    jQuery.ajax({
    'dataType':'json',
    'data':{'bookmark_type':bookmark_type,'id':id},
    'type':'POST',
    'success':function(data)
    {
    if(data.status==='success')
    {
    $('#setpotential'+id).html('Saved');
    $('#setpotential'+id).attr('onclick' , 'return false');
    }
    else
    {
    alert('unexpected_error');
    }
    },
   'url':'<?php echo Yii::app()->createUrl('tasker/savebookmark')?>','cache':false});return false;
    } 
</script>
<?php
if(!$isBookMark)
{
?>
<a id="setpotential<?php echo $id ?>" title="<?php echo Yii::t('tasklist','Add to favorite list') ?>" onclick="savebookmark('<?php echo $bookmark_type; ?>','<?php echo $id; ?>')" href="javascript:void(0)" >Save</a>
<?php
}
else
{
    ?>
    <a id="setpotential<?php echo $id ?>" title="<?php echo Yii::t('tasklist','Add to favorite list') ?>"  href="javascript:void(0)" >Saved</a>
    <?php
}
?>