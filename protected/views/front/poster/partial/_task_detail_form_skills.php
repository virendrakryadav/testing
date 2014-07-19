
<?php

Yii::import('ext.chosen.Chosen');
if(isset($skill) && $skill!='' )
{
  $skills = CHtml::listData($skill, Globals::FLD_NAME_SKILL_ID, 'skilllocale.skill_desc');
}
if (!empty($skills)) 
{
?>
<div class="col-md-7 no-mrg3">
    <div class="col-md-12 no-mrg">
    <label class="label text-size-18">Skills</label>
    <?php
                    $taskSelected = CommonUtility::getSelectedSkills($task->{Globals::FLD_NAME_TASK_ID});

                    echo Chosen::multiSelect(Globals::FLD_NAME_MULTISKILLS, $taskSelected, $skills, array(
                        'data-placeholder' => CHtml::encode(Yii::t('poster_createtask', 'txt_task_select_your_skills')),
                        'options' => array('displaySelectedOptions' => false ),
                        'class'=>'span5',
                        'onchange' => 'filterBySkills()',
                    ));
                    ?>
    </div>
</div>


<?php
}