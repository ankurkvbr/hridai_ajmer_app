$(document).ready(function () {
			var map;
            var marker;
		//alert($('#latitude').val()+'--'+$('#longitude').val());

            if($('#latitude').val() != 0 && $('#longitude').val() != 0){                
               
			   var myLatlng = new google.maps.LatLng($('#latitude').val(),$('#longitude').val());
            }else{
                var myLatlng = new google.maps.LatLng(26.4498954,74.63991629999998);
            }
            //var myLatlng = new google.maps.LatLng(26.4498954,74.63991629999998);
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();
            function initialize(){
                var mapOptions = {
                    zoom: 16,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
		       
                map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
                
                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true 
                });     
                
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
                google.maps.event.addListener(marker, 'dragend', function() {

                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
            
            }
            
            google.maps.event.addDomListener(window, 'load', initialize);
			
			function codeAddress() {
				var address = document.getElementById('address').value;
				geocoder.geocode( { 'address': address}, function(results, status) {
					
				if (status == google.maps.GeocoderStatus.OK) {
					
					map.setCenter(results[0].geometry.location);
					
					if (marker) {
					   marker.setMap(null);
					   if (infowindow) infowindow.close();
					}
					marker = new google.maps.Marker({
						map: map,
						draggable: true,
						position: results[0].geometry.location
					});
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(address);
                            infowindow.open(map, marker);
					//$('#latitude').val(marker.getPosition().lat());
					//$('#longitude').val(marker.getPosition().lng());
					google.maps.event.addListener(marker, 'dragend', function() {
						geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							alert(results[0]);
							if (results[0]) {
								$('#address').val(results[0].formatted_address);
								$('#latitude').val(marker.getPosition().lat());
								$('#longitude').val(marker.getPosition().lng());
								infowindow.setContent(results[0].formatted_address);
								infowindow.open(map, marker);
							}
						}
					});
				});
				
			   } else {
				alert('Geocode was not successful for the following reason: ' + status);
			  }
			});
		}
$('#address').change(function(){
      codeAddress();
    });
});



