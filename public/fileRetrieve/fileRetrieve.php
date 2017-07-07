<?php

	if(!isset($_SESSION)){

		session_start();

	}

	

	if(

		isset($_SESSION['userID']) && 

		isset($_REQUEST["fileID"])

	){

		

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/fileLibrary/fileLibrary.php');

		$fileLibrary = new fileLibrary(false);

		

		#get file info

		$fileInfo = $fileLibrary->getRecordByID($_REQUEST["fileID"]);

		

		if(mysqli_num_rows($fileInfo) > 0){

			$fi = mysqli_fetch_array($fileInfo);

		

			#file mime type

			$type = exec("/usr/bin/file -i -b ".$_SERVER['DOCUMENT_ROOT']."/fileLibrary/".$fi['fileName']);

			#set the file type header...

			header('Content-type: '.$type);

			// It will be called downloaded.pdf

			header('Content-Disposition: attachment; filename="'.$fi['fileName'].'"');

			#Send the file contents

			$filename = $_SERVER['DOCUMENT_ROOT']."/fileLibrary/" . $fi["fileName"];

			$handle = fopen($filename, "r");

			$contents = fread($handle, filesize($filename));

			echo $contents;

		}

		else{

			echo "File Doesn't Exist";

		}

	}

	else{

		echo "No Access";

	}



?>

