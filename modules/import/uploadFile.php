<?php
if (!isset($_SESSION)) {
    session_start();
}

#header('Content-Type: text/html; charset=utf-8');

iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");
iconv_set_encoding("input_encoding", "UTF-8");

#make sure it's the correct file type
if ($_FILES["fileName"]["error"] === UPLOAD_ERR_OK) {
    //security measure to make sure the user is logged in. if they aren't logged in, they can't upload a file
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0) {
        
        include_once($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/module/module.php");
        $modObj = new module(false);
		$moduleID = $_POST["moduleID"];
		$modInfo = $modObj->getRecordByID($moduleID); 
        
		$targetModInfo = mysqli_fetch_assoc($modInfo);
		
		include_once($_SERVER['DOCUMENT_ROOT'] . $targetModInfo["primaryAPIFile"]);
		$targetModObj = new $targetModInfo["phpClass"](false);
        
		$finalMapArr = array();
		foreach ($_POST as $key => $value) {
			if (strpos($key, 'dbCol-') === 0) {
				$newKey = str_replace("dbCol-","",$key);
				$finalMapArr[$newKey] = $value;
			}
		}
		
		// replace the whole table content
		if($_POST["importType"] == 1) {
			$targetModObj->getCheckQuery("DELETE FROM ".$targetModObj->moduleTable);	
		}
        
        $f = fopen($_FILES["fileName"]["tmp_name"], 'r');
        if ($f) {
            
            #locale must be set right before the fgetcsv or it won't work
            setlocale(LC_ALL, 'en_US.UTF-8');
            
            $line = fgetcsv($f);
            while ($line = fgetcsv($f)) { 
				
				$paramsArray                = array();				
				
				foreach ($finalMapArr as $key => $value) {
					$paramsArray[$key] = $line[$value];
				}
				
				#$GLOBALS["mysqli"]->set_charset('utf8');
				$targetModObj->importRecord($paramsArray);
                
            } // end of while
            fclose($f);
			echo "1";
        } else {
            echo "Failed to open CSV file!";
        }
        
    }
    #the user isn't logged in
    else {
        echo "Invalid Login";
    }
}
#there was an error uploading the file
else {
    if ($_FILES["fileName"]["error"] === UPLOAD_ERR_OK) {
        echo "There is no error, the file uploaded with success.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_INI_SIZE) {
        echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_FORM_SIZE) {
        echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_PARTIAL) {
        echo "The uploaded file was only partially uploaded.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_NO_FILE) {
        echo "No file was uploaded.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_NO_TMP_DIR) {
        echo "Missing a temporary folder.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_CANT_WRITE) {
        echo "Failed to write file to disk.";
    } elseif ($_FILES["fileName"]["error"] === UPLOAD_ERR_EXTENSION) {
        echo "A PHP extension stopped the file upload.";
    }
}
?>