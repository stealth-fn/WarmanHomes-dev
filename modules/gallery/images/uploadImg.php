<?php	
	if(!isset($_SESSION)){
		session_start();
	}
		
	#get info for this gallery, the gallery info specifies our image sizes...
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/galleryImages.php");
	$galleryObj = new gallery(false);
	
	$galDir = $_REQUEST['galleryID'];
	$galleryInfo = mysqli_fetch_assoc($galleryObj->getRecordByID($_REQUEST["galleryID"]));
	$galleryImagesObj = new galleryImage(false);
	#make sure it's the correct file type
	if($_FILES["fileName"]["error"] === UPLOAD_ERR_OK){
		if(
			($_FILES["fileName"]["type"] === "image/gif" || 
				$_FILES["fileName"]["type"] === "image/jpeg" || 
				$_FILES["fileName"]["type"] === "image/pjpeg" || 
				$_FILES["fileName"]["type"] === "image/png"
			) &&
			$_FILES["fileName"]["size"] < $galleryImagesObj->moduleSettings["maxFileSize"]
		)
		{
			
			/*the php image library takes up lots of memory. increase the size for this script
			note:not all servers allow setting php settings this way. we might have to change
			it in the php.ini file*/
			ini_set('memory_limit',$galleryImagesObj->moduleSettings["memoryLimit"]);
	
		   //security measure to make sure the user is logged in. if they aren't logged in, they can't upload a file
		   if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0){
		   
				$origImg = $galleryImagesObj->load($_FILES['fileName']['tmp_name']);
					
				$origWidth = $galleryImagesObj->getWidth($origImg);
				$origHeight = $galleryImagesObj->getHeight($origImg);
				$orientation = $origHeight - $origWidth;
				switch($orientation){
					case($orientation < 0):
						$postfix = "_l";
						break;
					case($orientation == 0):
						$postfix = "_s";
						break;
					case($orientation > 0):
						$postfix = "_p";
						break;
				}
				$filename = substr($_FILES['fileName']['name'],0,-4) . $postfix . substr($_FILES['fileName']['name'],-4,4);
				//check to see if an image with this name exists already, if it does we need to rename it with a counter...
				$imageCheck = $galleryImagesObj->getConditionalRecord(array($filename,true));
	
				//this file already exists... we need to rename it..
				//NOTE: this will always happen since we're uploading creating the database record before we upload the image
				//so all of the images are getting a number appended to them
				if(mysqli_num_rows($imageCheck) > 0){
					$imageFileName = $galleryImagesObj->getUniqueName($filename,0);
				}
				else{
					$imageFileName = basename($filename);
				}
	
				//we need to update the image name in the database, right now it will be the original image
				$paramsArray = array();
				$paramsArray["galleryID"] = $_REQUEST["galleryID"];
				$paramsArray["fileName"] = $imageFileName;
				$paramsArray["priKeyID"] = $_REQUEST["priKeyID"];
				$galleryImagesObj->updateRecord($paramsArray);
				
				$original_path = $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galDir . "/original/" . $imageFileName; 
				move_uploaded_file($_FILES['fileName']['tmp_name'], $original_path); 
				#get current image record
				$image = $galleryImagesObj->getConditionalRecord(
					array("fileName",$imageFileName,true)
				);
				
				#resize images according to gallery settings
				$galleryImagesObj->adjustImageSize($galleryInfo,mysqli_fetch_assoc($image));		
				
				#signals that the image was uploaded correctly
				echo "1";
			
			}
			#the user isn't logged in
			else{
				echo "Invalid Login";
			}
		}
		#invalid file type or file is too large specified from the cms settings
		else{
			echo "Invalid file type or file to large. The file must be under " . 
			($galleryImagesObj->moduleSettings["maxFileSize"]/1048576) . " Megabytes";
		}
	}
	#there was an error uploading the file
	else{
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