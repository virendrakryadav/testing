 <!--Invite Doers Start here--> 
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseThree">
          Invite Doers
        </a>
      </h4>
    </div>
<div id="collapseThree" class="panel-collapse collapse">
<div class="panel-body">
<!--Invite Doers Top tab Start here-->
<div id="createTaskFormFilters" class="grad-box margin-top-bottom-10">
<div class="vtab3">
<ul>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Search')), 'javascript:void(0)', array('id' => 'loadAll','class' => 'active')); ?></li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Featured')), 'javascript:void(0)', array('id' => 'loadpremiumtasker')); ?>
</li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previous')), 'javascript:void(0)', array('id' => 'loadHired')); ?></li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Favorite')), 'javascript:void(0)', array('id' => 'loadPotential')); ?></li>
</ul>
</div>
</div>
<!--Invite Doers Top tab Ends here-->

<!--Invite Doers Search Start here-->
<div class="col-md-12 no-mrg">

<div class="v-searchcont">
<div class="v-search6">
<div class="v-searchcol1">
<img src="<?php echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>">
 </div>
<div class="v-searchcol7">
<?php echo CHtml::textField(Globals::FLD_NAME_USER_NAME, '', array('id' => 'taskerName', 'placeholder' => 'Search Doer')); ?></div>
<div class="v-searchcol5">
    <a id="resetFilter" href="javascript:void(0)" ><img src="<?php echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>"></a>
</div>
</div>
<button class="btn-u btn-u-sm rounded btn-u-sea" id="searchByTaskName" type="button">Find</button></div>

</div>
<!--Invite Doers Search Ends here-->

<!--Invite Doers Search Results slider Start here-->
<div class="col-md-12 no-mrg">
    
    <button type="button" class="btn-u btn-u-sea"   onclick="inviteAll()"   >Select all for invitation</button>
    <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'loadtaskerlist',
                    'emptyText' => Yii::t('tasklist','msg_no_tasker_found'),
                  
                    'dataProvider' => $taskerList,
                    'itemView' => 'partial/_task_detail_form_tasker_list',
       
                    'enablePagination'=>true,
                    'viewData' => array( 'model' => $model),
                  //  'template'=>'<div id="summerytesxt" class="box5">{summary}</div>{items}{pager}',
                  //  'summaryCssClass'=>'ntointrested',
                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
                    'afterAjaxUpdate' => "function(id, data) {
                                                        setInvitedUser();
}",
                    )
                );
                ?>
</div>
<!--Invite Doers Search Results slider Ends here-->
<?php $invitedTaskers = TaskTasker::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID}); ?>
<!--Invited Doers Start here-->
<div class="col-md-12 no-mrg" >
    <h3 id="invitedTaskersTitle" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>">Invited</h3>
    <button id="invitedTaskersRemove" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>" type="button" class="btn-u btn-u-sea"   onclick="removeAllInvited()"   >Remove all invited doers </button>
<div class="col-md-12 no-mrg" id="invitedTaskers">
<?php
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{

    if($invitedTaskers && count($invitedTaskers)>0)
    {
        foreach($invitedTaskers as $tasker)
        {
            ?>
            <div style="overflow:hidden;" class="alert2 alert-block alert-warning fade in mrg6">
                <button data-dismiss="alert" class="close2" onclick="removeInvitedTasker(<?php echo $tasker->{Globals::FLD_NAME_TASKER_ID} ?>)" type="button">×</button>
                <div class="col-lg-2 in-img"><img src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80); ?>"></div>
                <div class="in-img-name"><?php echo substr(CommonUtility::getUserFullName( $tasker->{Globals::FLD_NAME_TASKER_ID} ),0 , 10) ; ?>
                <input type="hidden" value="<?php echo $tasker->{Globals::FLD_NAME_TASKER_ID} ?>" name="invitedtaskers[]" class="taskers_hidden"></div></div>
        <?php
        }
        ?>
        <script>
            $( document ).ready(function() 
            { 
                setInvitedUser();
            });
        </script>
        <?php
    }
}

?>

</div>
</div>
<!--Invited Doers Ends here-->
      </div>
    </div>
  </div>
  <!--Invite Doers Ends here-->