<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->{Globals::FLD_NAME_FIRSTNAME},
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->{Globals::FLD_NAME_USER_ID})),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->{Globals::FLD_NAME_USER_ID}),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
       
      'User Details'=>array('id'=>'userdetail','content'=>$this->renderPartial( 'viewuserdetail',  array('model'=>$model ),TRUE  )),
        'Task as Poster'=>array('id'=>'taskPosted','content'=>$this->renderPartial( '_mytasksposted',  array('taskList'=>$taskList ,'task' => $task, 'fillFields'=>$fillFields,),TRUE  )),        
        'Task as Doer'=>array('id'=>'taskDone','content'=>$this->renderPartial( '_mytasksdone',  array('taskList'=>$taskListAsTasker,'task' => $task, 'fillFields'=>$fillFields,),TRUE  )),  
        // panel 3 contains the content rendered by a partial view
       
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
    'id'=>'MyTab-Menu',
));
?>
          