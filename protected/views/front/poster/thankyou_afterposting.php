

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'posterrating-form',
        'action'=>Yii::app()->createUrl('//poster/saveposterrating'),
        'enableAjaxValidation'=>false,
    )); 
?>

<div class="container content">
    <!--Left bar start here-->
    <div class="col-md-3 leftbar-fix" >
        <!--left nav start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--        <div class="margin-bottom-30">
            <ul class="v-step">
                <li class="margin-bottom-20" onclick="goStep1()" ><span id="taskStep1"  class="vstep1a">1</span> <span class="vtext1">Receipts</span></li>
                <li class="margin-bottom-20" onclick="goStep2()" ><span id="taskStep2"  class="vstep1">2</span> <span class="vtext">Rate</span></li>
                <li class="margin-bottom-20" onclick="goStep3()" ><span id="taskStep3"  class="vstep1">3</span> <span class="vtext">Payment</span></li>
            </ul>
        </div>-->
                    <div class="margin-bottom-30">
                        <a class="btn-u rounded btn-u-sea display-b text-16" href="<?php echo CommonUtility::getCreateTaskUrl(); ?>">Post a New Project</a>
                    </div>
<?php
$this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_POSTER  , 'menusLinks' => 
                          array(
//                                CHtml::encode(Yii::t('poster_projectdetail', 'Bid Proposals')) => CommonUtility::getProposalListURI($task->{Globals::FLD_NAME_TASK_ID}) ,
                                CHtml::encode(Yii::t('poster_projectdetail', 'Search Members')) => CommonUtility::getPosterSearchMembersUrl() ,
                                CHtml::encode(Yii::t('poster_projectdetail', 'Currently Hiring')) => CommonUtility::getPosterCurrentryHiringUrl(),

                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_active_projects')) => CommonUtility::getPosterActiveProjectsUrl(),
                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_completed_projects')) => CommonUtility::getPosterCompletedProjectsUrl(),
                                CHtml::encode(Yii::t('poster_projectdetail', 'txt_all_projects')) => CommonUtility::getPosterAllProjectsUrl(),
                          )
                      )); 
?>
        <!--left nav Ends here-->

        <!--left Button Start here-->
       
        <!--left Button Ends here-->
    </div>
    <!--Left bar Ends here-->

    <!--Right part start here-->
    <div class="col-md-9 right-cont">
        
         <div class="col-md-11 mrg-auto overflow-h">
             <h1 class="align-center ">Thank you for posting project</h1>
</div>
        
       <div class="col-md-11 mrg-auto overflow-h">
           <p class="project-text">Your project <span class="text-18 color-green1"><?php echo $task->{Globals::FLD_NAME_TITLE} ?></span> has been posted successfully.</p>
</div>
<!--Project detail message Ends here-->

<!--Button Start here-->
<div class="align-center margin-bottom-30">

    <a id="saveFilter" class="btn-u btn-u-lg  btn-u-blue rounded" href="<?php echo CommonUtility::getPosterAllProjectsUrl()?>" >My Projects</a>
    <a id="saveFilter" class="btn-u btn-u-lg  btn-u-sea rounded" href="<?php echo CommonUtility::getTaskDetailURI($task->{Globals::FLD_NAME_TASK_ID})?>" >Project Detail</a>
 
</div>
        <!--Project detail ends here-->
    </div>
    <!--Right part ends here-->
</div>
<?php $this->endWidget();?>