<!--<div class="col-md-7 no-mrg sky-form">

<div class="col-md-12 no-mrg">
<label class="label text-size-18">Skills</label>
<div class="v-search2">
<div class="v-searchcol1">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-searchic.png">
 </div>
<div class="v-searchcol4"><input type="text" placeholder="Search Skills" name=""></div>
<div class="v-searchcol5">
<img src="http://192.168.1.200:8080/greencometdev/public/media/image/in-closeic.png">
</div>
</div>
<button class="btn-u btn-u-sm rounded btn-u-sea" type="button">Add</button></div>


<div class="col-md-12 no-mrg">
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
<div class="alert2 alert-block alert-warning fade in mrg6" style="overflow:hidden;">
<button type="button" class="close" data-dismiss="alert">×</button>
<div class="col-lg-2 mrg">Skill 1</div>
</div>
</div>


</div>-->
<?php
$is_public = CommonUtility::getFormPublic($task->{Globals::FLD_NAME_VALID_FROM_DT});
Yii::import('ext.chosen.Chosen');
if(isset($skill) && $skill!='' )
{
  $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
}
if (!empty($skills)) 
{
?>
<div class="col-md-7 no-mrg">
<div class="col-md-12 no-mrg">
<label class="label text-size-18">Skills</label>
 <?php
                $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});
                if($is_public == true)
                {
                    echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS."_1", $taskSelected, $skills, array(
                    'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                    'disabled'=>$is_public,
                    'options' => array( 'displaySelectedOptions' => false,),
                    'class'=>'span5'
                    ));
                    if( $taskSelected != '' )
                    {
                        $taskSelected = array_flip($taskSelected);
                        $skills = array_diff_key($skills, $taskSelected);
                        $taskSelected = '';
                    }
                }
                echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS, $taskSelected, $skills, array(
                    'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                    'options' => array('displaySelectedOptions' => false ),
                    'class'=>'span5'
                ));
                ?>
</div>
</div>


                    <?php
}