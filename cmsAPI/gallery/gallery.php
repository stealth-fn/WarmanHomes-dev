<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class gallery extends common{
		public $moduleTable = "image_gallery";
		public $instanceTable = "instance_gallery";
				
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "parentGalleryID";
			$this->mappingArray[0]["fieldName"] = "childGalleryID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/gallery/imageGalleryMap.php";

		}			
		
		public function createGalDirTree($galID){
			mkdir($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID);
			mkdir($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/original");
			mkdir($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/thumb");
			mkdir($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/medium");
			mkdir($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/large");
		}
		
		public function getChildGalleries($galID,$addSelf=false){
			$SELECT = $addSelf ? "SELECT ".$galID." AS childGalleryID UNION ALL " : "";
			return mysqli_query($SELECT."SELECT childGalleryID FROM image_gallery_map WHERE parentGalleryID = ".$galID.";");
		}
				
		/*removes gallery folder and images*/
		public function removeGal($galID){
			
			/*need non-ajax object for recursive delete*/
			$galleryObj = new gallery(false);
			
			$galDir = $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID;
			
			$galleryObj->recursiveDelete($galDir);
				
			/*remove images from db*/
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/galleryImages.php");
			
			/*we need to create a gallery image object, we can't use $this incase this function is being called through an ajax call*/
			$galleryImagesObj = new galleryImage(false);
			
			/*first, set all the images for this gallery to have a primary image of 0*/
			$galleryImages = $galleryImagesObj->removeRecordsByCondition("galleryID", $galID);
		}
				
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new gallery(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new gallery(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>