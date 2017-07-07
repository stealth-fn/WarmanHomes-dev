<?php	

	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/channelList/channelList.php");

	$channelListObj = new channelList(false);

	$channelListInfo = $channelListObj->getAllRecords();

?>



<div id="channelListing">

	<p class="channelList" id="channelList">Channels:</p>

	<?php

		if(mysqli_num_rows($channelListInfo) > 0){

			while($x = mysqli_fetch_array($channelListInfo)){

				echo "<p id='channelList" . $x["priKeyID"] . "' class='channelList' onclick='getFAQCat(" . $x["priKeyID"] . ");return false;'>";

					echo $x["channelList"];

				echo "</p>";

			}

		}

	?>

</div>