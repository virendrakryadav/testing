<style>

    </style>
<?php echo CommonScript::loadCreateTaskScript() ?>
<?php
$taskType = (isset($_GET["taskType"])) ? $_GET["taskType"] : '' ;

$user = User::model()->findByPk($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$latitude2 = $task_tasker->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE} ;
$longitude2 = $task_tasker->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE} ;
$getDistance = 0;
if(isset($taskLocation))
{
    $latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
    $longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
    $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
}
$isTaskCancel = CommonUtility::isTaskStateCancel($task->{Globals::FLD_NAME_TASK_STATE});
$isPremium = CommonUtility::isPremium($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$skills = UtilityHtml::userSkillsCommaSeprated($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$skills = $skills ? $skills : 'No Skills Given';
?>
<script>    
$( document ).ready(function() {
  $("#proposalssidebar").mCustomScrollbar();
});
</script>
<div class="container content">

<!--Left side bar start here-->

   <div class="col-md-3">
       <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--       <div class="margin-bottom-30">
           
       </div>-->

    <!--task type start here-->
    <?php $this->renderPartial('//tasker/instantnavigation',array('type' => Globals::DEFAULT_VAL_USER_ROLE_TASKER )); ?>
    <!--task type ends here-->

<!--Proposal start here-->
<!--      <div class="box">
         <div class="box_topheading"><h3 class="h3">My Proposals</h3></div>
         <div id="proposalssidebar" class="box2" style="height: 300px">
             
             <?php
//                $this->widget('ListViewWithLoader', array(
//                    'id' => 'loadAllProposalsSidebar',
//                    'dataProvider' => $proposals,
//                    'itemView' => '_viewallproposalssidebar',
//                    'template'=>'{items}',
//                    ));
                ?>
         </div>
      </div>-->
<!--Proposal Ends here-->
            <?php $this->renderPartial('//tasker/proposaldetailfilter',array('maxPrice' => $maxPrice ,'minPrice' => $minPrice ,'task' => $task,'proposals' => $proposals));?>
 
   </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
    
    
<!--Top proposal start here-->
    <?php   $this->renderPartial('//tasker/_taskdetailupperbar',array('task' => $task ,'isTaskCancel' =>$isTaskCancel , 'noControl' => 1)); ?>
<!--Top proposal ends here-->
<!--        <div class="box">
            <div class="box_topheading">-->
              <h3 class="h2 text-30a"><?php echo Yii::t('tasker_mytasks', 'Proposals detail')?></h3>
              <div class="margin-bottom-30">
<!--            </div>-->

<div class="margin-bottom-30">
<!--<div class="sortby-row margin-bottom-20"> 
<div class="prvproposal"><a href="#"><img src="../images/prv.png"></a> Previous Proposal </div>                     
<div class="proposalnum">2 of 50 proposals  </div>
<div class="nextproposal">Next Proposal <a href="#"><img src="../images/next.png"></a></div>
</div>-->
<div class="col-md-12 no-mrg">
<div class="proposal_list margin-bottom-10">
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="<?php echo CommonUtility::getThumbnailMediaURI($task_tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>">
<?php
if($isPremium==1)
{
?>
<div class="premiumtag2"><img src="<?php echo CommonUtility::getPublicImageUri('premium-item.png') ?>"></div>
<?php
}
?>
<div class="ratingtsk">
    <?php echo UtilityHtml::getDisplayRating($user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?>    
</div></div>
<div class="pro-icon-cont">
<div class="proposal_rating">
    
    
    <div class="iconbox3" >
        <?php
        if( $task_tasker->{Globals::FLD_NAME_TASKER_STATUS})
        {
            ?>
            <a href="#" title="<?php echo Yii::t('tasklist', 'You hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes.png") ?>"></a>

        <?php
        }
        else
        {
            ?>
                <a href="#" title="<?php echo Yii::t('tasklist', 'You not hired')?>"><img src="<?php echo CommonUtility::getPublicImageUri("yes-gray.png") ?>"></a>

        <?php
        }
        ?>
</div>

<?php 
//if(TaskTasker::isTaskerInvitedForTask( $task_tasker->{Globals::FLD_NAME_TASK_ID} , $task_tasker->{Globals::FLD_NAME_TASKER_ID} ))
//{
?>
<div class="iconbox4"><?php echo UtilityHtml::isTaskerInvitedForTask($task_tasker->{Globals::FLD_NAME_TASK_ID}, Yii::app()->user->id); ?></div>
<?php
//}
//else
//{
?>
<!--<div class="iconbox4"><img src="<?php // echo CommonUtility::getPublicImageUri('bell-gray.png') ?>"></div>-->
<?php
//}
?>
<!--<div class="iconbox4" id="potentialFor_<?php echo $task_tasker->{Globals::FLD_NAME_TASK_TASKER_ID} ?>">
   
    <?php //echo CommonUtility::createorDeleteBookmark(Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER,$task_tasker->{Globals::FLD_NAME_TASK_TASKER_ID},true); ?>

</div>-->
</div>
<div class="total_task">Task completed: <span class="mile_away">10</span></div>
<!--<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b" href="#">Hire me</a></div>-->
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" href="#">Message</a></div>
</div>
<!--<div class="total_task">Task completed: <span class="mile_away">10</span></div>-->
</div>
<div class="proposal_col2">
<div class="proposal_row">
<div class="newcol1">
<p class="tasker_name"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $task_tasker->{Globals::FLD_NAME_TASKER_ID}) ?><span class="tasker_city"> <?php  echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></a></p>
<div class="tasker_col4 "><span class="date"><?php echo Yii::t('tasker_mytasks', 'Date')?>: <?php echo CommonUtility::formatedViewDate( $task_tasker->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
<div class="tasker_col4 "><span class="mile_away"><a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/userskillspopover').'?'.Globals::FLD_NAME_USER_ID.'='.$task_tasker->{Globals::FLD_NAME_TASKER_ID} ?>">miles away</a></span></div>
<div class="tasker_col4"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $task_tasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>
</div>
<div class="newcol2">
<div class="taskerhired taskerlist_total"><span class="taskercount">10</span><br>Total</div>
<div class="taskerhired otherhired"><span class="taskercount">10</span><br>Others</div>
<div class="taskerhired taskerlist_network"><span class="taskercount">5</span><br> Networks</div>
<div class="taskerhired taskerlist_youhired"><span class="taskercount">2</span><br> You hired</div>
</div>
</div>
<div class="proposal_row1">
  <div class="total_task"><?php echo Yii::t('poster_createtask', 'lbl_task_user_skills')?> <span class="graytext"><?php echo $skills?></span></div>
</div> 
<div class="proposal_row2"><strong><?php echo Yii::t('tasker_mytasks', 'Description')?>:</strong> <?php  echo $task_tasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?></div>   

<!--<li><span class="quescoler">Q.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry?</li>
<li><span class="quescoler">Ans.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
<li><span class="quescoler">Q.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry?</li>
<li><span class="quescoler">Ans.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>-->

<?php
$question = TaskQuestion::getTaskQuestion($task_tasker->{Globals::FLD_NAME_TASKER_ID});
$i = 1;
if($question)
{
?>
<div class="proposal_row2">
<h3 class="quest"><?php echo Yii::t('tasker_mytasks', 'Question answer')?></h3>
<div class="quest_cont">
<ul>
<h2 class="h4"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_answers')) ?></h2>
    <?php
    $answers =  CommonUtility::getQuestionAnswerByTasker($task_id, $taskTasker->tasker_id );
    if($answers)
    {
        foreach ($question as $questions)
        {
        ?>
            <li><span class="quescoler">Q.</span><?php echo $i . '. ' . $questions->categoryquestionlocale->question_desc; ?></li>
            <li><span class="quescoler"><?php echo CHtml::encode(Yii::t('poster_taskdetail', 'lbl_task_que_ans')); ?></span>  <?php echo $answers[$questions->question_id]; ?></li>                                    
            <?php
            $i++;
        }
    }
    ?>
</ul>
</div>
</div>
<?php
}
?>

<!--    </li>-->

</div>
</div>

                  
                  <div class="tasker_row1">
                     <h3 class="h3 bot_border"><?php echo Yii::t('tasker_mytasks', 'Review')?></h3>
                     <div class="proposal_row3 botmrgn">
                    <div class="reviewcol"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Total Reviews')?></span> <span class="countbox">0</span></div>
                    <div class="reviewcol"><span class="counttext"><?php echo Yii::t('tasker_mytasks', 'Average rating')?></span> <span class="countbox">
                           <?php echo UtilityHtml::getDisplayRating($task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?>   
                        </span></div>
                    <div class="reviewcol2"><span class="counttext">Average price</span> <span class="countbox">$0</span></div>
                    </div>
                     <div class="review_cont">
                        <ul class="timeline">
                           <li class="event">
                              <input type="radio" name="tl-group">
                              <label></label>
                               <div class="thumb" style="background:url(<?php echo CommonUtility::getPublicImageUri("pro_img.png") ?>) no-repeat;" >
                               <span>5 May 2014</span></div>
                              <div class="content-perspective">
                                 <div class="content_testi">
                                    <div class="content-inner">
                                       <h3><?php echo Yii::t('tasker_mytasks', 'Reviewed by')?> <a href="#">Thomas Stein</a> for <a href="#">Handcrafted dining table</a></h3>
                                       <p>Just wanted to say thanks for the two weeks of vacation that you guys organize,we had a really good time, met good people that we'll probably be friends for a long time. Dan and Joce</p>
                                    </div>
                                 </div>
                              </div>
                           </li>	
                        </ul>
                     </div>
                    <div class="write_but">
                    <div class="messagesend"><a href="#" class="btn-u rounded btn-u-blue">View all</a></div></div>
                  </div>
                  
                  <div class="tasker_row1">
                     <h3 class="h3"><?php echo Yii::t('tasker_mytasks', 'Write message')?></h3>
                     <div class="writeheadbg"><img src="<?php echo CommonUtility::getPublicImageUri('write-bg.jpg') ?>"></div>
                     <div class="writemess_cont">
                        <div class="write_thumb"><img src="<?php echo CommonUtility::getPublicImageUri('pro_img.png') ?>"></div>
                        <div class="write_area"><textarea name="" cols="" rows=""></textarea></div>
                        <div class="write_but">
                        <div class="messagesend"><input name="" type="button" value="Send" class="btn-u rounded btn-u-sea" /></div></div>
                     </div>
                  </div>
                                                        
                   
                  <div class="tasker_row1">
                      
                      <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadAllProposalsMain',
                    'dataProvider' => $proposals,
                    'itemView' => '_viewallproposalsmain',
                    'template'=>'{items}{pager}',
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.rowselector',
                        'itemsSelector' => '.list-view',
                        'listViewId' => 'loadAllProposalsMain',
                        'header' => '',
                        'loaderText' => 'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 0, 'trigger' => 'Show more'),
                    ),
                    ));
                ?>
                                        
<!--                     <div class="showmore"><a href="#">Show more</a></div>-->
                  </div>
               
               </div>              
<!--            </div>-->
<!--         </div>        -->
      </div>
    </div>
</div>
    <!--Right side content ends here-->
</div>