<style>
    .popup_profile {
    margin: 30px;
    width: 80%;
}

.message {
    float: right;
    margin: 10px 15px;
    color: red;
}
.profile_link {
    border: 1px solid #DEDEDE;
    box-shadow: 0 0 6px 0 #CCCCCC;
    margin: auto;
    padding: 8px 0;
    text-align: center;
    width: 30%;
}
.profile_popup {
    height: 45%;
    width: 35%;
}
.taskdetailpopup1 {
    left: 32%;
    margin: auto;
}
</style>


<div id="profile_popup" class="popup_profile">
   <img src="<?php echo Yii::app()->getBaseUrl()?>/images/icon_alert_large.png">
   
      <?php

    if($data['error_code'])
    {
         echo "<div id=\"message\" class=\"message\">".CHtml::encode(Yii::t('poster_createtask', 'Oops!!! Please update following ....')).'</div><br/>';
         ?>
  <div class="margin-bottom-30">
<ul class="v-step">
   <?php   
   $i=1;
        foreach ($data['error_code'] as $error)
        {
            if(isset($error[ErrorCode::ERROR_CODE_USER_ADDRESS]))
            {
                ?>
                <li class="margin-bottom-20">
                <span id="taskStep1" class="vstep1 vstep1a"><?php echo $i ?></span>
                <span class="vtext1">Please provide your address detail</span>
                </li>
                <?php
                $i++;
            }
            if(isset($error[ErrorCode::ERROR_CODE_USER_DETAIL]))
            {
                ?>
                <li class="margin-bottom-20">
                <span id="taskStep1" class="vstep1 vstep1a"><?php echo $i ?></span>
                <span class="vtext1">Please provide your name, phone, email or other profile details</span>
                </li>
                <?php
                $i++;
            }
            if(isset($error[ErrorCode::ERROR_CODE_USER_PAYMENT]))
            {
                ?>
                <li class="margin-bottom-20">
                <span id="taskStep1" class="vstep1 vstep1a"><?php echo $i ?></span>
                <span class="vtext1">Please provide your payment account details</span>
                </li>
                <?php
                $i++;
            }

        }
        ?>
  </ul>
</div>
   <?php
    }

    ?>
   
</div>
<div id="myprofile_link" class="profile_link">
    <a href="<?php echo Yii::app()->getBaseUrl()?>/index/updateprofile"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_myprofile'));?></a>
</div>
