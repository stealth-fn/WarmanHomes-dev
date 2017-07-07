<?php	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/standardContent/standardContentNew.php");
	$headerObj = new standardContentPublic(false);
	$header = $headerObj->getRecordByID(1);
	if(mysqli_num_rows($header) > 0){
		$x = mysqli_fetch_assoc($header);
		if (strlen($x["headerContent"]) > 0) {
			echo '<div id="topBar">'.$x["headerContent"].'</div>';
		}
	}
?>