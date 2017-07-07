<?php

	$_REQUEST["imageAreaMapID"] = 1;

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroup.php");

	$hotspotGroupObj = new hotspotGroup(false);

	$hotspotsGroups = $hotspotGroupObj->getAllRecords();

	$increment = 0;

	$areasObject = "areas: [

	";

	while($x = mysqli_fetch_array($hotspotsGroups)){

		$areasObject .=

		"{

		staticState:true,

		key:'".str_replace(" ","",$x['hotspotGroupName'])."',

		fillColor:'".strtoupper(str_replace("#","",$x['color']))."',

		fillOpacity:'1'

		}\n";

		$increment++;

		if(mysqli_num_rows($hotspotsGroups) == $increment){

			$areasObject .= 

			"]";

		}

		else $areasObject .= ",";

	}

?>

var initialOptions = {

    mapKey:'data-key',

    stroke:true,

    strokeColor:'FFFFFF',

	strokeOpacity:'0.3',

	showToolTip: true,

	<?php echo $areasObject;?>

};



function hotspotMouseover(){

	console.log('hi');

}



var realOptions = {

	mapKey:'data-key',

	fillColor:'FFFFFF',

	fillOpacity:'0.3',

	onMouseover:function(data){

		var areaData = $("#"+data.key).data('info');

		var increment = 0;

		for(var key in areaData){

			$($("#imageMapInfoContainer<?php echo $_REQUEST["imageAreaMapID"];?> .dataInfoValue")[increment]).html(areaData[key]);

			increment++;

		}

	},

	isSelectable:false

}





$('#mappedImg<?php echo $_REQUEST["imageAreaMapID"];?>').mapster(initialOptions).mapster('snapshot').mapster('rebind',realOptions,true);