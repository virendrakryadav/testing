<div class="tasker_map">
<div id="map" class="instant_map"></div>
<script type="text/javascript">
var locations = '';
            var locations = [ ["<strong>Mukul Medawat</strong>",26.809267,75.54174340000002,1], 
["<strong>Mukul2 Jiji</strong>",26.909267,75.96174340000002,1], 
["<strong>john_smith01</strong>",26.759267,75.59174340000002,1], 
["<strong>Mukul Medatwal</strong>",26.809267,75.54174340000002,1], 
];
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: new google.maps.LatLng(26.9124165,75.7872879),
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });
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