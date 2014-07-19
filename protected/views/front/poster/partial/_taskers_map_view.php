<style>
.gm-style .gm-style-iw 
{
    height: 194px !important; 
    left: 14px !important;
    overflow: auto;
    position: absolute;
    top: 9px;
    width: 255px;
}
.tasker_map_view {
    height: 600px;
    
}
</style>
<div class="col-md-12 no-mrg">
<div id="map"  class="mapimg tasker_map_view"></div>

</div>
<script type="text/javascript">
var locations = '';
<?php
$defulat=0;
$tasklatitude = 0;
$tasklongitude = 0;
$latitude2 = 0;
$longitude2 = 0;
if( isset($taskLocation ))
{
    $tasklatitude = $taskLocation->{Globals::FLD_NAME_LOCATION_LATITUDE};
    $tasklongitude = $taskLocation->{Globals::FLD_NAME_LOCATION_LONGITUDE};
}
?>
            var locations = [ <?php
                                if (count($users) > 0) 
                                {
                                    $count = 1;
                                    foreach ($users as $key => $data) 
                                    {
                                        $latitude2 = $data->{Globals::FLD_NAME_LOCATION_LATITUDE} ;
                                        $longitude2 = $data->{Globals::FLD_NAME_LOCATION_LONGITUDE} ;
                                        
                                        $getDistance = CommonUtility::calDistance($longitude2, $latitude2, $tasklongitude, $tasklatitude);

                                        echo '["'.CommonUtility::getThumbnailMediaURI($data->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35).'",' .$data->{Globals::FLD_NAME_LOCATION_LATITUDE} . ',' . $data->{Globals::FLD_NAME_LOCATION_LONGITUDE} . ',' . $count . ', '.$data->{Globals::FLD_NAME_USER_ID}.','.$getDistance.'], ' . "\n";
                                            
                                    }
                                    
                                    $count++;

                                }
                               ?>];
                                       <?php
$tasklatitude = empty($tasklatitude) ? $latitude2 : $tasklatitude;
$tasklongitude = empty($tasklongitude) ? $longitude2 : $tasklongitude;
                                 ?>
function initialize()   
{
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: <?php echo Globals::DEFAULT_VAL_MAP_ZOOM ?>,
          center: new google.maps.LatLng(<?php echo $tasklatitude ?>,<?php echo $tasklongitude ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });
  
    var infowindow = [];
    var marker, i;
    if(locations != '')
    {
        for (i = 0; i < locations.length; i++) 
        {  
            marker = new google.maps.Marker(
            {
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: locations[i][0],
                animation: google.maps.Animation.DROP


            });
            infowindow[i] = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker,i) 
            {
                
                return function() 
                {
                   
                    if(infowindow[i].getContent())
                    {
                        for (var j=0;j<infowindow.length;j++) 
                        {
                            infowindow[j].close();
                        }
                        
                        //$.when(infowindow[i].open(map, marker)).done(setInvitedUser('userInviteBtnOnMap'));
                       // $.when(aa()).then(setInvitedUser('userInviteBtnOnMap'));
                      
                      // alert(infowindow[i].open(map, marker));
                        infowindow[i].open(map, marker);
                        setInvitedUser('userInviteBtnOnMap');
                        //infowindow[i].open(map, marker);  
                        //setInvitedUser('userInviteBtnOnMap');
                    }
                    else
                    {
                        $.ajax({  
                            url: '<?php echo Yii::app()->createUrl('poster/inviteuserpopup') ?>', 
                            type:"POST",
                            dataType : "json",
                            cache:false,
                            data : { user_id : locations[i][4] , distance : locations[i][5] },
                            success: function(data) 
                            {  
                                if(data.status==='success')
                                {
                                    for (var j=0;j<infowindow.length;j++) 
                                    {
                                        infowindow[j].close();
                                    }
                                    infowindow[i].setContent(data.html);  
                                    infowindow[i].open(map, marker);  
                                    setInvitedUser('userInviteBtnOnMap');
                                }
                                else
                                {
                                    alert('<?php echo CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred')) ?>');
                                }

                            }  
                        });
                    }
                    
                    
            }
            
//                return function() 
//                {
//                    infowindow.setContent(htmldata[i]);
//                   
//                    infowindow.open(map, marker);
//                }
            })(marker,i));
        }
    }
    }
    initialize();
</script>

<?php $invitedTaskers = TaskTasker::getInvitedTaskerForTask($task->{Globals::FLD_NAME_TASK_ID}); ?>
<!--Invited Doers Start here-->
<div class="col-md-12 no-mrg"  id="" >
    <h3 id="taskerInvitedDivTitleOnMap" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID}))  if($invitedTaskers && count($invitedTaskers)>0)
    { echo 'block'; } else { echo 'none';} else echo 'none' ?>">Invited</h3>
    <button id="invitedTaskersRemoveOnMap" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) if($invitedTaskers && count($invitedTaskers)>0)
    { echo 'block'; } else { echo 'none';} else echo 'none' ?>" type="button" class="btn-u rounded btn-u-red"   onclick="removeAllInvited('invitedTaskersRemoveOnMap', 'invitedTaskersByMap' , 'taskerInvitedDivTitleOnMap' )"><i class="fa fa-times"></i> Remove all invited doers </button>
    <div class="col-md-12 no-mrg invitedtaskers" id="invitedTaskersByMap">
<?php
if(isset($task->{Globals::FLD_NAME_TASK_ID}))
{

    if($invitedTaskers && count($invitedTaskers)>0)
    {
        foreach($invitedTaskers as $tasker)
        {
            ?>
            <div style="overflow:hidden;" class="alert2 invite-select alert-block alert-warning fade in mrg6">
                <button data-dismiss="alert" class="close2" onclick="removeInvitedTasker(<?php echo $tasker->{Globals::FLD_NAME_TASKER_ID} ?> , 'invitedTaskersRemoveOnMap','invitedTaskersByMap','taskerInvitedDivTitleOnMap')" type="button">×</button>
                <div class="col-lg-2 in-img"><img src="<?php echo CommonUtility::getThumbnailMediaURI($tasker->{Globals::FLD_NAME_TASKER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80); ?>"></div>
                <div class="in-img-name"><?php 
                $fullname  = CommonUtility::getUserFullName( $tasker->{Globals::FLD_NAME_TASKER_ID} );
                 $name = explode(" ", $fullname);
               //  print_r($name);
               if(isset($name[0]) && isset($name[1]) )
               {
                    if(strlen($name[0]) < 8)
                    {
                       $userName = $name[0]." ".substr( $name[1] ,0, 1); 
                    }
                    else
                    {
                      $userName = $name[0]; 
                    }
                }
                else
                {
                    $userName = substr($fullname , 0, 10); 
                }
                echo $userName;
               ?>
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