<div class="tasker_map">
<div id="map" class="instant_map"></div>
<script type="text/javascript">
var locations = '';
<?php
$defulat=0;
if (isset($location)) 
{
    if ($location) 
    {?>
            var locations = [ <?php
                                if (count($location) > 0) 
                                {
                                    $count = 1;
                                    foreach ($location as $key => $value) 
                                    {
                                        echo '["<strong>' . CommonUtility::getUserFullName($location[$key][Globals::FLD_NAME_USER_ID]) . '</strong>",' . $location[$key][Globals::FLD_NAME_LAT] . ',' . $location[$key][Globals::FLD_NAME_LNG] . ',' . $count . '], ' . "\n";
                                    }
                                    $count++;
                                }
                               ?>];
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: <?php echo Globals::DEFAULT_VAL_MAP_ZOOM ?>,
          center: new google.maps.LatLng(<?php echo $lat ?>,<?php echo $lng ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });
    <?php
    }
    else
    {
        $defulat=1;
    }
} 
else 
{
    $defulat=1;
}
if($defulat==1)
{
    $lati = Globals::DEFAULT_VAL_LATITUDE;
    $longi = Globals::DEFAULT_VAL_LONGUTUDE;
    if (isset($model->location_latidude) && isset($model->{Globals::FLD_NAME_LOCATION_LONGITUDE}) )
    {
        $lati = $model->location_latidude;
    
    
        $longi = $model->{Globals::FLD_NAME_LOCATION_LONGITUDE};
        ?>
        var locations = 
        [
            ['<strong><?php CommonUtility::getUserFullName($model->{Globals::FLD_NAME_USER_ID}) ?></strong>', <?php echo $lati ?>, <?php echo $longi ?>, 1],
        ];  
    <?php
    }
    ?>
    var map = new google.maps.Map(document.getElementById('map'), 
    {
        zoom: <?php echo Globals::DEFAULT_VAL_MAP_ZOOM ?>,
        center: new google.maps.LatLng(<?php echo $lati ?>, <?php echo $longi ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    <?php
}
    ?>
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    if(locations != '')
    {
        for (i = 0; i < locations.length; i++) 
        {  
            marker = new google.maps.Marker(
            {
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) 
            {
                return function() 
                {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }
</script>

</div>
<div class="span3 nopadding">
        <?php
    if (isset($location)) 
    {
        if ($location) 
        {
            if (count($location) > 0) 
            {
                ?>
    <br/>
    <div class="box_topheading">
        <h3 class="h3">
            <?php echo CHtml::encode(Yii::t('poster_createtask','{n} txt_tasker_found|{n} txt_taskers_found', count($location))) ?>
        </h3>
                    </div>
   
    <?php
                
                $count = 1;
                foreach ($location as $key => $value) 
                {
                    if($count < Globals::DEFAULT_VAL_SIDEBAR_TASKER_FOUND)
                    {
                    ?>
                        <div class="tasker_list">
                            <?php   $ishired = TaskTasker::ishired($location[$key][Globals::FLD_NAME_USER_ID],$model->{Globals::FLD_NAME_USER_ID});
                            if($ishired == 1)
                            {
                               ?>
<!--                                <div class="item_label">
                                    <span class="item_label_text"><?php // echo CHtml::encode(Yii::t('poster_createtask', 'lbl_you_hider')) ?></span>
                                </div>-->
                                <?php
                            }
                            ?>
                            <div class="tasker_row1">
                                <div class="tasker_col1">
                                    <?php  $img = CommonUtility::getThumbnailMediaURI($location[$key][Globals::FLD_NAME_USER_ID],  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50); ?>
                                    <img src="<?php echo $img ?>">
                                    <div class="tasker_col3"> <a href="#"><img src="../images/email-ic.png"></a>
                                        <a href="#"><img src="../images/phone-ic.png"></a>
                                        <a href="#"><img src="../images/chat-ic.png"></a>
                                    </div>
                                </div>
                                <div class="tasker_col2">
                                    <p class="tasker_name"><a href="#"><?php echo CommonUtility::getUserFullName($location[$key][Globals::FLD_NAME_USER_ID]); ?></a><span class="tasker_city">
                                                <?php echo  $location[$key]["country_code"] ?></span></p>
                                    <p class="tasker_mile"><?php
                                    $getDistance = CommonUtility::calDistance($location[$key][Globals::FLD_NAME_LNG], $location[$key][Globals::FLD_NAME_LAT], $lng,$lat);
                                    echo round($getDistance, 2) ?>
                                    <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away')) ?></p>
                                    <p class="tasker_skill"> 
                                        <?php
                                         $skills =  UtilityHtml::userSkillsCommaSeprated($location[$key][Globals::FLD_NAME_USER_ID]); 
                                        if ($skills )
                                        {
                                            ?>
                                            <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_user_skills')) ?>
                                            <?php echo $skills; ?>
                                            <?php
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="tasker_row2">
                                <div class="tasker_col4"><a href="#">10 <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_reviews')) ?></a></div><div class="tasker_col4"><img src="../images/star.png"><img src="../images/star.png"><img src="../images/star.png"></div>
                            </div>
                        </div>
                        
                        <?php
                    }
                    $count++;
                }
                ?>
                <div class="">
                    <a href="javascript:void(0)" onclick="document.getElementById('NearByUsers').style.display='block';" ><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_view_all')) ?></a>
                 </div>
    <?php
            }
        }
    }
?>
</div>
<div style="display: none" class="templatdiv" id="NearByUsers">
    <div class="create_account">
        <div class="create_account_popup">
            <div class="popup_head">
                <h2 class="heading">
                    <?php echo CHtml::encode(Yii::t('poster_createtask','lbl_all_near_by_tasker')) ?></h3>

                 </h2><button id="cboxClose" onclick="document.getElementById('NearByUsers').style.display='none';" type="button"><?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_close')) ?></button>
            </div>
            <?php
                if (isset($location))
                {
                    if ($location)
                    {
                        if (count($location) > 0)
                        {
                            ?>
                <div class="box_topheading">
                    <h3 class="h3">
                            <?php echo CHtml::encode(Yii::t('poster_createtask','{n} txt_tasker_found|{n} txt_taskers_found', count($location))) ?></h3>
                </div>
                <?php
                            $count = 1;
                            foreach ($location as $key => $value)
                            {
                                ?>
                                    <div class="tasker_list">
                                        <?php   $ishired = TaskTasker::ishired($location[$key][Globals::FLD_NAME_USER_ID],$model->{Globals::FLD_NAME_USER_ID});
                                        if($ishired == 1)
                                        {
                                           ?>
<!--                                            <div class="item_label">
                                                <span class="item_label_text"><?php //echo CHtml::encode(Yii::t('poster_createtask', 'lbl_you_hider')) ?></span>
                                            </div>-->
                                            <?php
                                        }
                                        ?>

                                        <div class="tasker_row1">
                                            <div class="tasker_col1">
                                                <?php  $img = CommonUtility::getThumbnailMediaURI($location[$key][Globals::FLD_NAME_USER_ID],  Globals::IMAGE_THUMBNAIL_PROFILE_PIC_50); ?>
                                                <img src="<?php echo $img ?>">
                                                <div class="tasker_col3"> <a href="#"><img src="../images/email-ic.png"></a>
                                                    <a href="#"><img src="../images/phone-ic.png"></a>
                                                    <a href="#"><img src="../images/chat-ic.png"></a>
                                                </div>
                                            </div>
                                            <div class="tasker_col2">
                                                <p class="tasker_name"><a href="#"><?php echo CommonUtility::getUserFullName($location[$key][Globals::FLD_NAME_USER_ID]); ?></a><span class="tasker_city">
                                                            <?php echo  $location[$key]["country_code"] ?></span></p>
                                                <p class="tasker_mile"><?php
                                                $getDistance = CommonUtility::calDistance($location[$key][Globals::FLD_NAME_LNG], $location[$key][Globals::FLD_NAME_LAT], $lng,$lat);
                                                echo round($getDistance, 2) ?>
                                                <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_miles_away')) ?></p>
                                                <p class="tasker_skill">
                                                    <?php
                                                     $skills =  UtilityHtml::userSkillsCommaSeprated($location[$key][Globals::FLD_NAME_USER_ID]);
                                                    if ($skills )
                                                    {
                                                        ?>
                                                        <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_task_user_skills')) ?>
                                                        <?php echo $skills; ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tasker_row2">
                                            <div class="tasker_col4"><a href="#">10 <?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_reviews')) ?></a></div><div class="tasker_col4"><img src="../images/star.png"><img src="../images/star.png"><img src="../images/star.png"></div>
                                        </div>
                                    </div>
                                    <?php
                            }
                        $count++;
                        }
                    }
                }
            ?>
        </div>
    </div>
 </div>