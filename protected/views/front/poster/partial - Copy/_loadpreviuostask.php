<?php
if(isset($model))
{
    $taskListNew = $model;       
}
else
{
    $taskList = Task::getUserTaskList();
    $taskListNew = $taskList;        
}
if(!empty($taskListNew))
{ 
//    echo $formtype;
    if($formtype == Globals::DEFAULT_VAL_V)
    {
        $url = Yii::app()->createUrl('poster/loadvirtualtaskpreview');
    }
    else if($formtype == Globals::DEFAULT_VAL_P)
    {
        $url = Yii::app()->createUrl('poster/loadinpersontaskpreview');
    }
    else
    {
        $url = Yii::app()->createUrl('poster/loadinstanttaskpreview');
    }
    foreach($taskListNew as $taskListNews)
    {
    ?>
      <div class="prvlist_box"> <a href="#"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($taskListNews->{Globals::FLD_NAME_TASK_ID},  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52) ?>" width="71" height="52"></a>
          <p class="title"><?php echo ucfirst($taskListNews->{Globals::FLD_NAME_TITLE}); ?></p>
          <p class="date"><?php echo Yii::t('poster_createtask', 'lbl_task_done_by')?> : John  21 April 2014</p>
          <p>
              <?php echo CHtml::ajaxLink('View', $url, array(
          'data'=>array(Globals::FLD_NAME_TASKID =>$taskListNews->{Globals::FLD_NAME_TASK_ID} , Globals::FLD_NAME_CATEGORY_ID =>$taskListNews->taskcategory[Globals::FLD_NAME_CATEGORY_ID],'key'=>'viewonly',  'YII_CSRF_TOKEN' =>  Yii::app()->request->csrfToken),
           'beforeSend' => 'function(){
                                      $("#rootCategoryLoading").addClass("displayLoading");
                                      $("#loadpreviuosTask").addClass("displayLoading");
                                      $("#templateCategory").addClass("displayLoading");}',
          'complete' => 'function(){       
                                      $("#rootCategoryLoading").removeClass("displayLoading");
                                      $("#loadpreviuosTask").removeClass("displayLoading");
                                      $("#templateCategory").removeClass("displayLoading");}',
          //'dataType' => 'json', 
          'type'=>'POST',
          'success' => 'function(data){
              //activeForm("loadcategory_'.$taskListNews->{Globals::FLD_NAME_TASK_ID}.'");
              //loadSidebar("'.$taskListNews->task_kind.'","'.$taskListNews->taskcategory[Globals::FLD_NAME_CATEGORY_ID].'",priview="priview");  
              //alert("hii");
              $(\'#loadpreview\').html(data); loadPreviousTaskPreview(); }'), 
                      array('id' => 'loadinstantcategories_'.$taskListNews->{Globals::FLD_NAME_TASK_ID} ,'live'=>false )); ?>
              </p>
      </div>
      <?php
    }
}
else
{
    echo CHtml::encode(Yii::t('poster_createtask', 'txt_task_previous_task_not_available'));
}
?>
