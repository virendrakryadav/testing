<script>
function sendinvitation(id)
{
    $("#id_"+id).css('color','#B2DBA1');
    var doer_id = $("#doer_id_"+id).val();
    var task_id = $("#task_id_"+id).val();
    jQuery.ajax({
    'dataType':'json',
    'data':{'task_id': task_id , 'doer_id' : doer_id},
    'type':'POST',
    'success':function(data)
    {       
        var msg = "<strong>"+$("#doer_name_"+id).val()+"</strong> has been invited for <strong>"+$("#task_name_"+id).val()+"</strong>.";
       $("#success_msg").show();
       $("#messageDetail").html(msg);      
    },
    'url':'<?php echo Yii::app()->createUrl('poster/invitedoer') ?>','cache':false});return false; 
}
</script>
<?php
 $totletask = count($posterTasklists);
if($totletask > 0)
{
    $i=0;
    echo"<div class='col-md-4-doerlist'><ul>";
    foreach($posterTasklists as $posterTasklist)
    {       
        echo "<li title='".$posterTasklist['title']."' id='id_".$i."' style='cursor: pointer;' onclick='sendinvitation(".$i.")' >".CommonUtility::truncateText(ucfirst($posterTasklist['title']),Globals::DEFAULT_TASK_TITLE_LENGTH)."</li>
            <input type='hidden' id='doer_id_".$i."' value='".$doer_id."' >
            <input type='hidden' id='task_id_".$i."' value='".$posterTasklist['task_id']."' > 
            <input type='hidden' id='task_name_".$i."' value='".$posterTasklist['title']."' > 
            <input type='hidden' id='doer_name_".$i."' value='".CommonUtility::getUserFullName($doer_id)."' >"; 
        $i++;
    }
//    echo"<li style='cursor: pointer'><a href='".Yii::app()->createUrl('poster/createtask')."'>New Task</a></li></ul></div>";
    echo"</ul></div>";
}
else
{
    echo"<div class='col-md-4-doerlist'><ul><li>No project available to invite</li></ul></div>";
}
?>