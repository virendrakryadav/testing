<?php
        $skills = UtilityHtml::userSkills( $user_id , "span4 nopadding specialties", Globals::DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN) ;
        if( $skills )
        {
            echo $skills;
        }
        else
        {
                echo CHtml::encode(Yii::t('userprofile', 'txt_no_skills_specified'));
        }
?>