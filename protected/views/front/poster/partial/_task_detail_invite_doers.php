 <!--Invite Doers Start here--> 
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title1">
        <a data-toggle="collapse" data-parent="#accordion" 
          href="#collapseThree" class="collapsed">
          Invite Doers
          <span class="accordian-state"></span>
        </a>
      </h4>
    </div>
<div id="collapseThree" class="panel-collapse collapse">
<div class="panel-body">
<!--Invite Doers Top tab Start here-->
<div id="createTaskFormFilters" class="grad-box margin-top-bottom-10 no-border">
<div class="vtab3">
<ul>

<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Featured')), 'javascript:void(0)', array('id' => 'loadpremiumtasker','class' => 'active')); ?>
</li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Previous')), 'javascript:void(0)', array('id' => 'loadHired')); ?></li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Favorite')), 'javascript:void(0)', array('id' => 'loadPotential')); ?></li>
<li><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Search')), 'javascript:void(0)', array('id' => 'loadAll')); ?></li>
</ul>
</div>
    <div class="clr"></div>
</div>
<!--Invite Doers Top tab Ends here-->
<div id="searchDoers"  style="display: none">
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
<div class="col-md-12 invitedtaskers pdn-top-15 sky-form">

<div class="col-md-3 no-mrg">
<label class="label text-size-14">Active Within:</label>
<?php
$activewithin = Globals::userActiveWithInSelectArray();
?>
<?php

   echo CHtml::dropDownList('active_within', '', $activewithin,
     array('prompt'=> CHtml::encode(Yii::t('poster_createtask', 'Select')),
         'onchange' => ' 
                var data = $("#active_within").serialize() ;   
                if(data == "")
                {
                data = "active_within=";
                }
                $.fn.yiiListView.update("loadtaskerlist", {data: data});
                ',
                'class' => 'form-control mrg5','id' => 'active_within' , 'live'=>false));
?>
</div>

<div class="col-md-3 mrg8">
<label class="label text-size-14">Completed:</label>
<?php
$userCompletedTask = Globals::userCompletedProjectsSelectArray();
?>

<?php
   echo CHtml::dropDownList('completed_projects', '', $userCompletedTask,
     array('prompt'=> CHtml::encode(Yii::t('poster_createtask', 'txt_select')),
          'onchange' => ' 
                var data = $("#completed_projects").serialize() ;   
                if(data == "")
                {
                data = "completed_projects=";
                }
                $.fn.yiiListView.update("loadtaskerlist", {data: data});
                ',
    'class' => 'form-control mrg5','id' => 'completed_projects' , 'live'=>false));
?>
</div>

<div class="col-md-2 mrg8">
<label class="label text-size-14">Average Price:</label>
<?php
$userAveragePriceWorkDone = Globals::userAveragePriceWorkDoneSelectArray();
?>
<?php
   echo CHtml::dropDownList('average_price', '', $userAveragePriceWorkDone,
     array('prompt'=> CHtml::encode(Yii::t('poster_createtask', 'Select')),
         'onchange' => ' 
                var data = $("#average_price").serialize() ;   
                if(data == "")
                {
                data = "average_price=";
                }
                $.fn.yiiListView.update("loadtaskerlist", {data: data});
                ',
    'class' => 'form-control mrg5','id' => 'average_price' , 'live'=>false));
?>
</div>

<div class="col-md-4 mrg8">
<label class="label text-size-14">Location:</label>
<?php
            $locations = CommonUtility::getCountryList();
            $locationList = '';
            $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
            echo Chosen::multiSelect(Globals::FLD_NAME_LOCATIONS, $locationList, $locations, array(
                'data-placeholder' => $placeholder,
                'options' => array('displaySelectedOptions' => false,),
                'class' => 'form-control',
                'onchange' => ' 
                var data = $("#'.Globals::FLD_NAME_LOCATIONS.'").serialize() ;   
                if(data == "")
                {
                data = "'.Globals::FLD_NAME_LOCATIONS.'=";
                }
                $.fn.yiiListView.update("loadtaskerlist", {data: data});
                '

            ));
            ?>
</div>
<!--<div class="col-md-2 mrg8">
<label class="label text-size-14">&nbsp;</label>
<select class="form-control mrg5">
<option>Toronto</option>
</select>
</div>-->

</div>
<!--Invite Doers Search Results slider Start here-->
</div>
<div class="col-md-12 no-mrg">
    
    <button type="button" class="btn-u rounded btn-u-sea select-all"  id="sorterRow"  onclick="inviteAll()"   ><i class="fa fa-check"></i> Select all for invitation</button>
    <?php
                $this->widget('ListViewWithLoader', array(
                    'id' => 'loadtaskerlist',
                   // 'emptyText' => Yii::t('tasklist','msg_no_tasker_found'),
                'emptyText' => '<div class="items overflow-h"><div class="alert alert-danger fade in">'.Yii::t('tasklist','msg_no_tasker_found').'.</div></div>',
                  'emptyTagName' => 'div class="box2"',
                    'dataProvider' => $taskerList,
                    'itemView' => 'partial/_task_detail_form_tasker_list',
                    
                    'enablePagination'=>true,
                    'viewData' => array( 'model' => $model),
                   'template'=>'<div id="summerytesxt" class="summary foundcount">{summary}</div>{items}{pager}',
                    
                    'summaryCssClass'=>'summary foundcount',
                    'pagerCssClass'=>'pager col-md-12 no-mrg',
                   // 'emptyTagName' => 'div class="alert alert-danger fade in"',
                    'itemsCssClass'=>'items overflow-h',
                    'summaryText' => Yii::t('tasklist','Found {count} doers'),
                    'afterAjaxUpdate' => "function(id, data) {
                                                        setInvitedUser();
                                                  if($('#summerytesxt').html() == '')
                                                  {
                                                    
                                                    $('#sorterRow').css('display', 'none');
                                                  }
                                                  else
                                                  {
                                                    $('#sorterRow').css('display', 'block');
                                                  }
                        }",
                    )
                ); 
                ?>
    <div class="clr"></div>
</div>
<!--Invite Doers Search Results slider Ends here-->
<?php $invitedTaskers = TaskTasker::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID}); ?>
<!--Invited Doers Start here-->
<div class="col-md-12 no-mrg" >
    <h3 id="invitedTaskersTitle" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID}))  if($invitedTaskers && count($invitedTaskers)>0)
    { echo 'block'; } else { echo 'none';} else echo 'none' ?>">Invited</h3>
    <button id="invitedTaskersRemove" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) if($invitedTaskers && count($invitedTaskers)>0)
    { echo 'block'; } else { echo 'none';} else echo 'none' ?>" type="button" class="btn-u rounded btn-u-red"   onclick="removeAllInvited()"><i class="fa fa-times"></i> Remove all invited doers </button>
<div class="col-md-12 invitedtaskers" id="invitedTaskers"  style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) if($invitedTaskers && count($invitedTaskers)>0)
    { echo 'block'; } else { echo 'none';} else echo 'none' ?>">
<?php
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{

    if($invitedTaskers && count($invitedTaskers)>0)
    {
        foreach($invitedTaskers as $tasker)
        {
            ?>
            <div style="overflow:hidden;" class="alert2 invite-select alert-block alert-warning fade fade-in-alert mrg6">
                <button data-dismiss="alert" class="close2" onclick="removeInvitedTasker(<?php echo $tasker->{Globals::FLD_NAME_TASKER_ID} ?>)" type="button"><img src="<?php echo CommonUtility::getPublicImageUri('info-del.png') ?>" ></button>
                <div class="col-lg-2 in-img"><img src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80); ?>"></div>
                <div class="in-img-name"><?php echo substr(CommonUtility::getUserFullName( $tasker->{Globals::FLD_NAME_TASKER_ID} ),0 , 10) ; ?>
                <input type="hidden" value="<?php echo $tasker->{Globals::FLD_NAME_TASKER_ID} ?>" name="invitedtaskers[]" class="taskers_hidden"></div>
            </div>
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
  
 