function propertyLoad ()
{
	if ( $( "#googleSingleMap" ).length ) { 
		singleMap(); 
	}
	
	if ( $( "#googleMultiMap" ).length ) {
		multiMap();
	}
}

//This funtion will generate a unique map for the property location
function singleMap()
{

	<?php
	
	if (isset($priModObj[0]->propertyID))
	{
		$propertyID = $priModObj[0]->propertyID;
		
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/property.php");
		$propertyObj = new property(false, null);
		$property = $propertyObj->getAllRecords();	
	
		while($x = mysqli_fetch_array($property))
		{
			if($x["priKeyID"] == $propertyID) {
				
				$lat = $x["latitude"]; 
				$lng =  $x["longitude"];
				$name =  $x["propertyName"];
				$add =  $x["address"] . " " . $x["cityProv"];
				$completeAddress =  $x["completeAddress"];
				
				$markerText =  $name . '</br>';
				$markerText .= "<span id='infoWindowAddress'>" .$add . "</span></br>";
				if (empty($completeAddress)) {
					$markerText .= "<a href='http://maps.google.com/?q=" . $completeAddress . " ' target='_blank'>Get Directions</a>";
				}
				else {
					$markerText .= "<a href='http://maps.google.com/?q=" . $lat . "," . $lng . "' target='_blank'>Get Directions</a>";
				}
			}
		}
		
	
	?>
		//la, log for location displaying on the map
		var myCenter = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>);
	
		var mapProp = {
			center: myCenter,
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
	
		//Get the HTML property you want to replace
		var map = new google.maps.Map(document.getElementById("googleSingleMap"), mapProp);
	
		//Create a marker on the map, at the location we are viewing
		var marker = new google.maps.Marker({
			position: myCenter,
		});
	
		//Place the marker on the map
		marker.setMap(map);
	
		//Setup an inforamtion window for the marker
		var infowindow = new google.maps.InfoWindow({
			content: "<?php echo $markerText ?>"
		});
	
		//Add event listener to the marker window, so when the user
		//clicked on the marker it will appear
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
<?php } ?>
}

//This funtion will a marker on the map for all properties 
function multiMap()
{
	
	//Set the center location for the veiwing point (currently Saskatoon Center)
	var myCenter = new google.maps.LatLng(52.12441, -106.66288);

	//Find the HTML element you wish to replace and setup your map
	var map = new google.maps.Map(document.getElementById('googleMultiMap'), {
		zoom: 11,
		center: myCenter,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	//Turn on the information window funtion
	var infowindow = new google.maps.InfoWindow();

	var marker, i;
	
	i = 0;
	
	<?php
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/property.php");
	$propertyObj = new property(false, null);
	$property = $propertyObj->getAllRecords();	

	while($x = mysqli_fetch_array($property))
	{
		$lat = $x["latitude"]; 
		$lng =  $x["longitude"];
		$name =  htmlspecialchars($x["propertyName"]);
		$name = addslashes($name);
		$add =  htmlspecialchars($x["address"]) . " " . htmlspecialchars($x["cityProv"]);
		
		$completeAddress =  $x["completeAddress"];
		$completeAddress = addslashes($completeAddress);
		$markerText =  $name . '</br>';
		$markerText .= '<span id="infoWindowAddress">' . $add . '</span></br>';
	
		//$markerText .= '<a href="/contact" onclick="upc(2481,\"propertyID='.$x["priKeyID"].'\");return false">More Details</a>';
	
	
	?>
	
		//add marker to the map
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>),
			map: map
		});
		
		//Add event listener to the marker window, so when the user
		//clicked on the marker it will appear
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent('<?php print $markerText ?>');
				//Place the marker on the map
				infowindow.open(map, marker);
			}
		})(marker, i));
		
		i++;
			
	<?php
		
	}
	?>
}

function goBack() {
   History.back();
}