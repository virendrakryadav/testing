<div class="tasklist_box"><img src="<?php echo CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_180) ?>" width="200" height="200">
    <div><h3><a href="#"><?php echo CommonUtility::getUserFullName($data->{Globals::FLD_NAME_USER_ID}); ?></a></h3> <h4><?php echo $data->{Globals::FLD_NAME_COUNTRY_CODE}; ?></h4></div>  
    <p> <?php
$latitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE} . '<br>';
$longitude1 = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE} . '<br>';
$latitude2 = $data->{Globals::FLD_NAME_LOCATION_LATITUDE} . '<br>';
$longitude2 = $data->{Globals::FLD_NAME_LOCATION_LONGITUDE} . '<br>';
//                        $data->{Globals::FLD_NAME_USER_ID};
$getDistance = CommonUtility::calDistance($longitude2, $latitude2, $longitude1, $latitude1);
                echo round($getDistance, Globals::DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY) . ' ' . CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away'));
?></p>     
    <p>------------------------------------------------------------------------------------------------------------------------</p>     
    <!--<p>Category:<?php //echo $tasks->{Globals::FLD_NAME_TITLE}; ?> | Invited:10 | Accepted:5| Responded:2</p>-->
<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'invitenow-form',
        ));
echo $form->hiddenField($task, Globals::FLD_NAME_TASK_ID, array('value' => $task->{Globals::FLD_NAME_TASK_ID}));
echo $form->hiddenField($data, Globals::FLD_NAME_USER_ID, array('value' => $data->{Globals::FLD_NAME_USER_ID}));

echo $form->hiddenField($data, Globals::FLD_NAME_LOCATION_LATITUDE, array('value' => $data->{Globals::FLD_NAME_LOCATION_LATITUDE}));
echo $form->hiddenField($data, Globals::FLD_NAME_LOCATION_LONGITUDE, array('value' => $data->{Globals::FLD_NAME_LOCATION_LONGITUDE}));


$userinvited = TaskTasker::model()->findByAttributes(array( Globals::FLD_NAME_TASKER_ID =>$data->{Globals::FLD_NAME_USER_ID},Globals::FLD_NAME_TASK_ID=>$task->{Globals::FLD_NAME_TASK_ID}));
?>
    <div class="skills"><?php echo UtilityHtml::userSkills($data->{Globals::FLD_NAME_USER_ID}); ?></div>
    <input type="hidden" name="tasker_in_range" value="<?php echo $getDistance; ?>">
    <div class="sign_row2" id="invitedbutton<?php echo $data->{Globals::FLD_NAME_USER_ID};?>">
    <?php
    if(empty($userinvited))
    {

//    echo CHtml::ajaxSubmitButton('Connect me', Yii::app()->createUrl('tasker/invitenow'), array(
//        'type' => 'POST',
//        'dataType' => 'json',
//        'success' => 'js:function(data){
//			   	alert(data.errorCode);
//				   if(data.errorCode == "success"){
//					//  window.location.href="' . Yii::app()->createUrl('index/dashboard') . '";
//				   }				   
//				   else{
//
//				   }
//			   }',
//            ), array('class' => 'sign_bnt'));
    			  
 $successUpdate = '
                                if(data.errorCode==="success"){                                
                                    $("#invitedbutton'.$data->{Globals::FLD_NAME_USER_ID}.'").html("<strong>'.CHtml::encode(Yii::t('poster_createtask', 'lbl_invited')).'</strong>");
                                   }else{
                                    //alert("notsuccess");
                                   }
                                ';
            CommonUtility::getAjaxSubmitButton(CHtml::encode(Yii::t('poster_createtask', 'lbl_invite_me')), Yii::app()->createUrl('tasker/invitenow'), 'sign_bnt', 'inviteme', $successUpdate);
    }
    else
        {
            echo "<strong>".CHtml::encode(Yii::t('poster_createtask', 'lbl_invited'))."</strong>";
        }
       ?>
        <button class="cnl_btn" onclick="window.location='<?php echo Yii::app()->createUrl('poster/tasklist'); ?>'; return false;">Close</button>
    </div>



<?php $this->endWidget(); ?>
</div>



