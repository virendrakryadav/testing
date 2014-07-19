<?php echo CommonScript::loadCreateTaskScript() ?>
<?php

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
?>
<script>    
$( document ).ready(function() {
  $("#proposalssidebar").mCustomScrollbar();
});
</script>
<div class="page-container pagetopmargn">

<!--Left side bar start here-->
   <div class="leftbar">
    <!--task type start here-->
<!--    <div class="box">
    <div class="tasktype">
    <ul>
  <li><a href="#" class="active">New Task</a></li>
  <li><a href="#">Open Tasks</a></li>
  <li><a href="#">Current Tasks</a></li>
  <li><a href="#">Completed Tasks</a></li>
  <li><a href="#">All Tasks</a></li>
  <li><a href="#">Favorite Taskers</a></li>
    </ul>
    </div>
    </div>-->
    <!--task type ends here-->

<!--Proposal start here-->
      <div class="box">
         <div class="box_topheading"><h3 class="h3">Proposals</h3></div>
         <div id="proposalssidebar" class="box2" style="height: 300px">
             
             <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadAllProposalsSidebar',
                    'dataProvider' => $proposals,
                    'itemView' => '_viewallproposalssidebar',
                    'template'=>'{items}',
                    ));
                ?>
         </div>
      </div>
<!--Proposal Ends here-->

   </div>
    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar">
    
    
<!--Top proposal start here-->
   <div class="proposal_cont">
      <div class="proposal_list">
         <div class="tasker_row1">
            <div class="proposal_prof2"><img src="<?php echo CommonUtility::getTaskThumbnailImageURI($task->{Globals::FLD_NAME_TASK_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>" /></div>
            <div class="proposal_col">
               <div class="controls-row">
                  <p class="proposal_title"><a href="#"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}); ?> </a></p>
                  <div class="proposal_col4 ">Post date: <span class="date"> <?php echo CommonUtility::formatedViewDate( $task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
                  <div class="proposal_col4 ">Bid start date: <span class="date"> <?php echo CommonUtility::formatedViewDate( $task->{Globals::FLD_NAME_BID_START_DATE}) ?></span></div>
                  <div class="proposal_col4 ">Task type: <span class="date"> <?php echo ucfirst(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})) ?></span></div>
                  <div class="proposal_col4 ">Category:<span class="date"> <?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?></span></div>
                  <div class="proposal_col4 ">Estimated price:<span class="date"> <?php echo Globals::DEFAULT_CURRENCY . intval( $task->{Globals::FLD_NAME_PRICE} ); ?></span></div>
               </div>
               <div class="controls-row">
                  <div class="proposal_col4"><span class="mile_away">
                     <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/taskskillspopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>"><?php echo Yii::t('tasker_proposaldetail', 'skills_text'); ?></a>
                     </span>
                  </div>
                  
                  <div class="proposal_col4"><span class="mile_away">
                     <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasklocationspopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>"><?php echo Yii::t('tasker_proposaldetail', 'location_text'); ?></a>
                     </span>
                  </div>
                  
                  <?php
                     if( $isTaskCancel )
                     {
                         ?>
                         <div class="proposal_col4">
                             <span class="mile_away">
                                 <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/tasksharepopover') . '?' . Globals::FLD_NAME_TASK_ID . '=' . $task->{Globals::FLD_NAME_TASK_ID} ?>"><?php echo Yii::t('tasker_proposaldetail', 'share_text' ); ?></a>
                             </span>
                         </div>
                     <?php
                     }
                     ?>
                        
               </div>  
               <div class="proposal_row3">
                  <div class="total_task2"><span class="counttext">Total Proposal</span> <span class="countbox"><?php echo $task->{Globals::FLD_NAME_PROPOSALS_CNT} ?></span></div>
                        <div class="total_task2"><span class="counttext">Average rating</span> <span class="countbox">
                                <?php CommonUtility::DisplayRating(Globals::FLD_NAME_PROPOSALS_AVG_RATING,$task->{Globals::FLD_NAME_PROPOSALS_AVG_RATING}); ?>
                                </span>
                        </div>
                        <div class="total_task2"><span class="counttext">Average price</span> <span class="countbox"><?php echo Globals::DEFAULT_CURRENCY.intval($task->{Globals::FLD_NAME_PROPOSALS_AVG_PRICE}) ?></span></div>
<!--                  
                  
                  
                  <div class="total_task3">
                            <?php
                            if( $isTaskCancel )
                            {
                                 echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Cancel')), Yii::app()->createUrl('poster/canceltask'), array(
                                    'beforeSend' => 'function(){$("#canceltask'.$task->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
                                    'complete' => 'function(){$("#canceltask'.$task->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
                                    'dataType' => 'json', 
                                    'data' => array('taskId' => $task->{Globals::FLD_NAME_TASK_ID}), 
                                    'type' => 'POST', 
                                    'success' => 'function(data){ 
                                                                    if(data.status==="success")
                                                                    {
                                                                        window.location.reload(true);
                                                                    }
                                                                }'), 
                                    array('id' => 'canceltask'.$task->{Globals::FLD_NAME_TASK_ID}, 'class' => 'btn', 'live' => false));
                            }
                            else
                            {
                                echo '<a id="canceledtask'.$task->{Globals::FLD_NAME_TASK_ID}.'" class="btn" href="#">Canceled</a>';
                                   
                            }
                            ?>
                        
                        </div>
                        <div class="total_task3"><input type="button" name="" value="Share" class="btn"></div>
                        <div class="total_task3">
                            <?php
                            if( $isTaskCancel )
                            {
                                echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'txt_edit')), Yii::app()->createUrl('poster/edittask'), array(
                                'beforeSend' => 'function(){$("#edittask'.$task->{Globals::FLD_NAME_TASK_ID}.'").addClass("loading");}',
                                'complete' => 'function(){$("#edittask'.$task->{Globals::FLD_NAME_TASK_ID}.'").removeClass("loading");}',
                                'dataType' => 'json', 
                                'data' => array('taskId' => $task->{Globals::FLD_NAME_TASK_ID}, 'category_id' => $task->categorylocale->category_id, 'formType' => 'virtual','onlyform' => '1'), 
                                'type' => 'POST', 
                                'success' => 'function(data){ loadpopup(data.form); }'), 
                                array('id' => 'edittask'.$task->{Globals::FLD_NAME_TASK_ID}, 'class' => 'btn', 'live' => false));
                            }
                            ?>
                        </div>
                        <div class="total_task3"><input type="button" name="" value="View" onclick="window.location = '<?php echo CommonUtility::getTaskDetailURI( $task->{Globals::FLD_NAME_TASK_ID} ) ?>'" class="btn"></div>
                  
                  -->
<!--                  <div class="total_task3"><input type="button" name="" value="Cancel" class="btn"></div>
                  <div class="total_task3"><input type="button" name="" value="Edit" class="btn"></div>
                  <div class="total_task3"><input type="button" name="" value="View" class="btn"></div>-->
               </div>            
            </div>
         </div>
      </div>
   </div>
<!--Top proposal ends here-->

        <div class="box">
            <div class="box_topheading">
              <h3 class="h3">Proposals detail</h3>
              <?php
//              echo"<pre>";
//              print_r($task_tasker);
              ?>
            </div>

            <div class="controls-row pdn6"> 
               <div class="proposal_list">
                  <div class="item_labelblue">
<span class="proposal_label_blue">New</span>
</div>
                  <div class="tasker_row1">
                     <div class="proposal_col1">
                        <div class="proposal_prof">
                           <img src="<?php echo CommonUtility::getThumbnailMediaURI($task_tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_71_52); ?>">
<!--                           <div class="tasker_invite"><a href="#">Invited</a></div>-->
                        </div>
                        <div class="proposal_rating"><?php  echo CommonUtility::DisplayRating(Globals::FLD_NAME_TASK_DONE_RANK_DETAIL.$task_tasker->{Globals::FLD_NAME_TASKER_ID} ,$user->{Globals::FLD_NAME_TASK_DONE_RANK}); ?></div>
<!--                        <div class="proposal_btn">
                           <input type="button" class="hire_btn" value="Hire me" name="">
                            
                            <?php
                            if( $isTaskCancel )
                            {
                                $ifAcceptAction = '<a id=\"proposalhaired'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'\" class=\"hire_btn\" href=\"#\">Hired</a>';
                                if( $task_tasker->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
                                {
                                    echo '<a id="proposalhaired'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'" class="hire_btn" href="#">Hired</a>' ;
                                }
                                elseif( $task_tasker->{Globals::FLD_NAME_TASKER_STATUS} != Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
                                {
                                                    echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'Hire me')), 
                                                    Yii::app()->createUrl('poster/proposalaccept'),
                                                    array(
                                                            'beforeSend' => 'function(){$("#proposalAccept'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                                            'complete' => 'function(){$("#proposalAccept'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                                            'data' => array(
                                                                    'task_tasker_id' => $task_tasker->{Globals::FLD_NAME_TASK_TASKER_ID}, 

                                                                    ),

                                                            'type' => 'POST', 
                                                            'dataType'=>'json',
                                                            'success' => 'js:function(data){
                                                                //jQuery("#loadProposalDiv").html(data); 
                                                                if(data.status==="success")
                                                                {
                                                                    jQuery("#acceptProposalButton'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifAcceptAction.'");
                                                                        jQuery("#rejectProposalButton'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").html("");
                                                                }
                                                                else
                                                                {
                                                                    alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                                }
                                                                                        }'), 
                                                            array('id' => 'proposalAccept'.$task_tasker->{Globals::FLD_NAME_TASKER_ID},
                                                            'class' => 'hire_btn', 'live' => false));
                                }
                            }
                            ?>
                            
                        </div>-->
<!--                        <div class="proposal_btn">
                           <input type="button" class="connect_btn" value="Connect me" name="">
                        </div>-->   
                     </div>
                     <div class="proposal_col2">
                        <div class="proposal_row">
                           <p class="tasker_name"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopover( $task_tasker->{Globals::FLD_NAME_TASKER_ID}) ?> <span class="tasker_city"><?php  echo $user->{Globals::FLD_NAME_BILLADDR_COUNTRY_CODE} ?></span></a></p>
                           <div class="tasker_col4 "><span class="date">Date: <?php echo CommonUtility::formatedViewDate( $task_tasker->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
                           <?php if($getDistance != 0)
      {
          ?>
          <div class="tasker_col4 "><span class="mile_away"><?php echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));?></span> </div>
          <?php } ?>
                           <div class="tasker_col4"><a href="#">10 Reviews</a></div>
                           <div class="tasker_col4"><span class="mile_away"><a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/userskillspopover').'?'.Globals::FLD_NAME_USER_ID.'='.$task_tasker->{Globals::FLD_NAME_TASKER_ID} ?>">Skills</a></span></div>
                           <div class="tasker_col4"><span class="proposal_price"><?php echo  Globals::DEFAULT_CURRENCY . intval( $task_tasker->{Globals::FLD_NAME_TASKER_PROPOSED_COST} ); ?></span></div>
                        </div> 
                         
                         
                         <div class="proposal_row1">
                            <div class="total_task">Task completed: <span class="mile_away">10</span></div><div class="iconbox">
                            <a href="#" class="popovercontent" data-placement="bottom" data-poload="<?php echo Yii::app()->createUrl('commonfront/taskqueansweroftasker').'?'.Globals::FLD_NAME_TASKER_ID.'='.$task_tasker->{Globals::FLD_NAME_TASKER_ID}."&".Globals::FLD_NAME_TASK_ID.'='.$task->{Globals::FLD_NAME_TASK_ID} ?>"><img src="../images/ask-question.png"></a>

                                </div>
                            <div class="iconbox"><img src="../images/potential.png"></div>
                            <?php if(TaskTasker::isTaskerInvitedForTask( $task_tasker->{Globals::FLD_NAME_TASK_ID} , $task_tasker->{Globals::FLD_NAME_TASKER_ID} ))
                            {
                                ?>
                                <div class="iconbox"><img src="../images/bell.png"></div>
                                <?php
                            }
                            ?>

                            <div class="iconbox"><img src="../images/connect.png"></div>
                            <div class="tasker_col5" id="rejectProposalButton<?php echo $task_tasker->{Globals::FLD_NAME_TASKER_ID}?>">
                                <?php
                                if( $isTaskCancel )
                                {
                                    $ifRejectAction = '<a id=\"proposalhaired'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'\" class=\"interested_btn\" href=\"#\">Rejected</a>';
                                    if( $task_tasker->{Globals::FLD_NAME_TASKER_STATUS} == Globals::DEFAULT_VAL_TASK_STATUS_REJECTED )
                                    {
                                        echo '<a id="proposalhaired'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'" class="interested_btn" href="#">Rejected</a>' ;
                                    }
                                    elseif( $task_tasker->{Globals::FLD_NAME_TASKER_STATUS} != Globals::DEFAULT_VAL_TASK_STATUS_SELECTED )
                                    {

                                    echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_taskdetail', 'Not interested')), 
                                                        Yii::app()->createUrl('poster/proposalreject'),
                                                        array(
                                                                'beforeSend' => 'function(){$("#proposalReject'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").addClass("loading");}',
                                                                'complete' => 'function(){$("#proposalReject'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").removeClass("loading");}',
                                                                'data' => array(
                                                                        'task_tasker_id' => $task_tasker->{Globals::FLD_NAME_TASK_TASKER_ID}, 
                                                                        ),
                                                                'dataType'=>'json',
                                                                'type' => 'POST', 
                                                                'success' => 'js:function(data)
                                                                {
                                                                    if(data.status==="success")
                                                                    {
                                                                        jQuery("#rejectProposalButton'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").html("'.$ifRejectAction.'");
                                                                        jQuery("#acceptProposalButton'.$task_tasker->{Globals::FLD_NAME_TASKER_ID}.'").html("");
                                                                    }
                                                                    else
                                                                    {
                                                                        alert("' . CHtml::encode(Yii::t('poster_createtask', 'txt_portfolio_request_failed')) . '");
                                                                    }
                                                                }'), 
                                                                array('id' => 'proposalReject'.$task_tasker->{Globals::FLD_NAME_TASKER_ID},
                                                                'class' => 'interested_btn', 'live' => false));
                                    }  
                                }



                            //}
                                                                ?>
                         </div>
                </div>
                        
                        <div class="proposal_row2"><strong>Description:</strong><?php  echo $task_tasker->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS}; ?></div>            
                     </div>
                  </div>
                  
<!--                  <div class="tasker_row1">
                     <h3 class="quest">Question answer</h3>
                     <div class="quest_cont">
                        <ul> 
                         <?php
                $question = TaskQuestion::getTaskQuestion($task_tasker->{Globals::FLD_NAME_TASKER_ID});
                $i = 1;
                if($question)
                {
                    ?>
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
                           
                         
                }
                ?>
                         </ul>
                     </div>
                  </div>
                  
                  <div class="tasker_row1">
                     <h3 class="quest">Attachments</h3>
                     <div class="controls-row">
                         <?php echo UtilityHtml::getProposalAttachments($task_tasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS}, $user->profile_folder_name,$task_tasker->task_tasker_id); ?>
                        <div class="postedby"><img src="../images/doc_attachment.png"></div>
                        <div class="postedby"><img src="../images/excle.png"></div>
                        <div class="postedby"><img src="../images/pdf.png"></div>
                        <div class="postedby"><img src="../images/zip.png"></div>
                     </div>
                  </div>
                  -->
                  
                  <div class="tasker_row1">
                     <h3 class="h3 bot_border">Review</h3>
                     <div class="review_cont">
                        <ul class="timeline">
                           <li class="event">
                              <input type="radio" name="tl-group">
                              <label></label>
                               <div class="thumb" style="background:url(../images/pro_img.png) no-repeat;" >
                               <span>Aug 30</span></div>
                              <div class="content-perspective">
                                 <div class="content_testi">
                                    <div class="content-inner">
                                       <h3>Reviewed by <a href="#">Thomas Stein</a> for <a href="#">Handcrafted dining table</a></h3>
                                       <p>Just wanted to say thanks for the two weeks of vacation that you guys organize,we had a really good time, met good people that we'll probably be friends for a long time. Dan and Joce</p>
                                    </div>
                                 </div>
                              </div>
                           </li>	
                        </ul>
                     </div>
                  </div>
                  
                  <div class="tasker_row1">
                     <h3 class="h3 bot_border">Write message</h3>
                     <div class="writemess_cont">
                        <div class="write_thumb"></div>
                        <div class="write_area"><textarea name="" cols="" rows=""></textarea></div>
                        <div class="write_but"><input name="" type="button" value="Send" class="hire_btn" /></div>
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
                        'options' => array('history' => false, 'triggerPageTreshold' => 0, 'trigger' => 'Load more'),
                    ),
                    ));
                ?>
                                        
<!--                     <div class="showmore"><a href="#">Show more</a></div>-->
                  </div>
               
               </div>              
            </div>
         </div>        
      </div>
    </div>
    <!--Right side content ends here-->
</div>