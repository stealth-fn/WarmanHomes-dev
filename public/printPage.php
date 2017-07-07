<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/publicModule.php");

	$publicModuleObj = new publicModule(false);

	$module = $publicModuleObj->getRecordByID($_REQUEST["moduleID"]);

	$mod = mysqli_fetch_array($module);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $mod["moduleName"]; ?></title>

<link href="<?php echo $mod["cssLink"]; ?>" id="moduleStyle" rel="stylesheet" type="text/css"/>

</head>



<body onload="window.print()">

	<?php

		include_once($_SERVER['DOCUMENT_ROOT'] . $mod["includeFile"]); 

	?>

</body>

</html>