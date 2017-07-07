<?php

	$_REQUEST["imageAreaMapID"] = 1;

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/imageAreaMap.php");

	$imageAreaMapObj = new imageAreaMap(false);

	$imageAreaQuery = $imageAreaMapObj->getCheckQuery(

	"SELECT 

	image_area_maps.*,

	image_area_maps.priKeyID AS imageAreaMapPriKeyID,

	gallery_images.*,

	hotspots.*,

	hotspots.priKeyID AS hotspotPriKeyID,

	hotspot_data_map.*,

	hotspot_data.*,

	hotspot_groups_map.*,

	hotspot_groups.* 

	FROM image_area_maps 

	LEFT JOIN gallery_images ON gallery_images.priKeyID = image_area_maps.galleryImageID

	LEFT JOIN hotspots ON hotspots.imageAreaMapID = image_area_maps.priKeyID 

	LEFT JOIN hotspot_data_map ON hotspot_data_map.hotspotID = hotspots.priKeyID 

	LEFT JOIN hotspot_data ON hotspot_data.priKeyID = hotspot_data_map.hotspotDataID 

	LEFT JOIN hotspot_groups_map ON hotspot_groups_map.hotspotID = hotspots.priKeyID 

	LEFT JOIN hotspot_groups ON hotspot_groups.priKeyID = hotspot_groups_map.hotspotGroupID 

	WHERE image_area_maps.priKeyID = ".$_REQUEST["imageAreaMapID"]."

	ORDER BY hotspots.priKeyID, hotspot_data.priKeyID"

	);

	$hotspots = array();

	while($x = mysqli_fetch_array($imageAreaQuery)){

	

		if(!isset($imageAreaMapID) && !isset($imageAreaMapName) && !isset($imageAreaMapPath)){

			$imageAreaMapID = $x['imageAreaMapPriKeyID'];

			$imageAreaMapName = $x['imageAreaMapName'];

			$imageAreaMapPath = "/images/galleryImages/85imageAreaMap/original/".$x['fileName'];

		}

		

		$hotspotKeyName = "hotspot".$x['hotspotPriKeyID'];

		if(!isset($hotspots[$hotspotKeyName])){

			$hotspots[$hotspotKeyName] = array();

			$hotspots[$hotspotKeyName]['groupNames'] = array();

			$hotspots[$hotspotKeyName]['data'] = array();

			$hotspots[$hotspotKeyName]['coordinates'] = "";

			$hotspots[$hotspotKeyName]['name'] = "";

		}

		

		if(empty($hotspots[$hotspotKeyName]['coordinates'])){

			$hotspots[$hotspotKeyName]['coordinates'] = $x['coordinates'];

		}

		if(empty($hotspots[$hotspotKeyName]['name'])){

			$hotspots[$hotspotKeyName]['name'] = $x['hotspotName'];

		}

		if(!in_array(str_replace(" ","",$x['hotspotGroupName']),$hotspots[$hotspotKeyName]['groupNames'])){

			$hotspots[$hotspotKeyName]['groupNames'][] = str_replace(" ","",$x['hotspotGroupName']);

		}

		if(!array_key_exists($x['hotspotDataName'], $hotspots[$hotspotKeyName]['data'])){

			$hotspots[$hotspotKeyName]['data'][$x['hotspotDataName']] = $x['hotspotDataValue'];

		}

	}

?>



<div class="imageMapContainer" id="imageMapContainer<?php echo $imageAreaMapID;?>">

	<img id="mappedImg<?php echo $imageAreaMapID;?>" src="<?php echo $imageAreaMapPath;?>" alt="<?php echo $imageAreaMapName;?>" border="0" usemap="#imageMap<?php echo $imageAreaMapID;?>" />

	<map name="imageMap<?php echo $imageAreaMapID;?>" id="imageMap<?php echo $imageAreaMapID;?>">

		<?php

		foreach ($hotspots as $hotspotKey => $hotspotValue) {

		?>

			<area 

				shape="poly" 

				coords="<?php echo $hotspots[$hotspotKey]['coordinates'];?>" 

				href="#" 

				alt="<?php echo $hotspots[$hotspotKey]['name'];?>" 

				id="<?php echo $hotspotKey;?>"

		<?php

			$groupLength = count($hotspots[$hotspotKey]['groupNames']);

			if($groupLength > 0){

				$groupNames = "";

				$groupIncrement = 1;

				foreach($hotspots[$hotspotKey]['groupNames'] as $groupValue){

					if(!empty($groupValue)){

						$groupNames .= $groupValue;

						if($groupIncrement != $groupLength){

							$groupNames .= ",";

						}

					}

					$groupIncrement++;

				}

				echo 'data-key="' . $hotspotKey . "," . trim($groupNames) . '"';

			}

			else{

				echo 'data-key="' . $hotspotKey . '"';

			}

			$dataLength = count($hotspots[$hotspotKey]['data']);

			if($dataLength > 0){

				$dataInfo = "";

				$dataIncrement = 1;

				foreach($hotspots[$hotspotKey]['data'] as $hotspotDataKey => $hotspotDataValue){

					$dataInfo .= '"' . $hotspotDataKey . '":"' . $hotspotDataValue . '"';

					if($dataIncrement != $dataLength){

						$dataInfo .= ",";

					}

					$dataIncrement++;

				}

				echo "data-info='{" . trim($dataInfo) . "}'";

			}

			?>

			/>

			<?php

		}

		?>

	</map>

<!-- #windowDiv - used to overlay numbers on hotspots -->

	<div id="windowDiv"></div>

	

<!-- will be filled via javascript	 -->

	<div class="imageMapInfoContainer" id="imageMapInfoContainer<?php echo $imageAreaMapID;?>">

		<div class="hotspotDataContainer" id="hotspotDataContainer<?php echo $imageAreaMapID;?>">

		<?php

		$dataLength = count($hotspots[$hotspotKey]['data']);

		if($dataLength > 0){

		?>

			<div class="dataLabelColumn">

		<?php

			foreach($hotspots[$hotspotKey]['data'] as $hotspotDataKey => $hotspotDataValue){

			?>

				<div class="dataInfoLabel">

					<?php echo $hotspotDataKey;?>:

				</div>

			<?php

			}

		?>

			</div>

			<div class="dataValueColumn">

		<?php

			foreach($hotspots[$hotspotKey]['data'] as $hotspotDataKey => $hotspotDataValue){

			?>

				<div class="dataInfoValue">

				</div>

			<?php

			}

			?>

			</div>

		<?php

		}

		?>

		</div>

	</div>

	<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroup.php");

	$hotspotGroupObj = new hotspotGroup(false);

	$hotspotsGroups = $hotspotGroupObj->getAllRecords();

	?>

	<div class="hotspotLegend" id="hotspotLegend<?php echo $imageAreaMapID;?>">

		<h2>Legend</h2>

		<?php

		while($x = mysqli_fetch_assoc($hotspotsGroups)){

			$groupArray[] = $x;

		}

		?>

		<div class="groupColorColumn">

		<?php

		foreach($groupArray as $value){

		?>

			<div class="hotspotGroupColor" style="background-color:<?php echo $value['color'];?>;"></div>

		<?php

		}

		?>

		</div>

		<div class="groupNameColumn">

		<?php

		foreach($groupArray as $value){

		?>

			<div class="hotspotGroupName">

				<span><?php echo $value['hotspotGroupName'];?>

			</div>

		<?php

		}

		?>

		</div>

	</div>

</div>

