<?php
	if(!isset($_SESSION)){
		session_start();
	}

   #make sure it's the correct file type
	if($_FILES["fileName"]["error"] === UPLOAD_ERR_OK){		
		//security measure to make sure the user is logged in. if they aren't logged in, they can't upload a file
	   if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0){
	   
			include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibrary.php");
			$fileLibraryObj = new fileLibrary(false);
	
			#resolve any identical name problems
			$libraryFileName = $fileLibraryObj->getUniqueName($_FILES['fileName']['name'],0);
	
			#we need to update the file name in the database, right now it will be the original name
			$paramsArray = array();
			$paramsArray["fileName"] = $libraryFileName;
			$paramsArray["priKeyID"] = $_REQUEST["priKeyID"];
			$fileLibraryObj->updateRecord($paramsArray);
	
			#place file in directory
			$original_path = $_SERVER['DOCUMENT_ROOT']. '/fileLibrary/' . $libraryFileName; 
			move_uploaded_file($_FILES['fileName']['tmp_name'], $original_path); 
			echo "1";
		
		}
		#the user isn't logged in
		else{
			echo "Invalid Login";
		}
	}
	#there was an error uploading the file
	else {
		if($_FILES["fileName"]["error"] === UPLOAD_ERR_OK){
			echo "There is no error, the file uploaded with success. ";
		}
		elseif($_FILES["fileName"]["error"] === UPLOAD_ERR_INI_SIZE){
			echo "The uploaded file exceeds the upload_max_filesize directive in php.ini. ";
		}
		elseif($_FILES["fileName"]["error"] === UPLOAD_ERR_FORM_SIZE){
			echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. ";
		}
		elseif($_FILES["fileName"]["error"] === UPLOAD_ERR_PARTIAL){
			echo "The uploaded file was only partially uploaded. ";
		}
		elseif($_FILES["fileName"]["error"] === UPLOAD_ERR_NO_FILE){
			echo "No file was uploaded. ";
		}
		elseif($_FILES["fileName"]["error"] === UPLOAD_ERR_NO_TMP_DIR){
			echo "Missing a temporary folder.";
		}
		elseif($_FILES["fileName"]["error"] ===  UPLOAD_ERR_CANT_WRITE){
			echo "Failed to write file to disk.";
		}	
		elseif($_FILES["fileName"]["error"] ===  UPLOAD_ERR_EXTENSION){
			echo "A PHP extension stopped the file upload.";
		}	
	}

?>