<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class galleryImage extends common{
		public $moduleTable = "gallery_images";
		public $instanceTable = "instance_gallery_image";
		protected $image;
  		protected $image_type;
						
		public function removeGalleryImage($priKeyID){
			$imageInfo = $this->getRecordByID($priKeyID);
			
			while($x = mysqli_fetch_array($imageInfo)){
				unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/original/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/thumb/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/medium/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/large/" . $x["fileName"]);
			}
		}
		
		public function updateImgSize($galID){
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
			$galleryObj = new gallery(false);
			$galleryInfo = $galleryObj->getRecordByID($galID);
			
			#we need to create a gallery image object, we can't use $this incase this function is being called through an ajax call
			$galleryImagesObj = new galleryImage(false);
			
			$galleryImages = $galleryImagesObj->getConditionalRecord(array("galleryID",$galID,true));
			while($y = mysqli_fetch_assoc($galleryInfo)){
				while($x = mysqli_fetch_assoc($galleryImages)){
					$this->adjustImageSize($y,$x);
				}
			}
		}
						
		/****image manipulation functions****/
		public function load($filename) {
		  $image_info = getimagesize($filename);
		  $this->image_type = $image_info[2];
		  if( $this->image_type == IMAGETYPE_JPEG ) {
			 $this->image = imagecreatefromjpeg($filename);
		  } elseif( $this->image_type == IMAGETYPE_GIF ) {
			 $this->image = imagecreatefromgif($filename);
		  } elseif( $this->image_type == IMAGETYPE_PNG ) {
			 #make sure the png transparencies stay transparent
			 $this->image = imagecreatefrompng($filename); 
		  }
		 
		  return $this->image;
		}
		
		public function save($filename, $image_type, $compression=90, $permissions=null) {
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($this->image,$filename,$compression);
				$this->compress_jpeg($filename);
			} 
			elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($this->image,$filename);         
			} 
			elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($this->image,$filename);
				$this->compress_png($filename,100);
			} 
			  
			if( $permissions != null) {
				chmod($filename,$permissions);
			}
		}
		
		public function output($image_type=IMAGETYPE_JPEG) {
		  if( $image_type == IMAGETYPE_JPEG ) {
			 imagejpeg($this->image);
		  } elseif( $image_type == IMAGETYPE_GIF ) {
			 imagegif($this->image);         
		  } elseif( $image_type == IMAGETYPE_PNG ) {			 
			 imagepng($this->image);
		  }   
		}
		
		public function getImgType(){
			return $this->image_type;
		}
		
		public function getWidth() {
			return imagesx($this->image);
		}
		
		public function getHeight() {
			return imagesy($this->image);
		}
		
		public function adjustImageSize($gallery,$image){
			$thumbWidth = $gallery["thumbWidth"];
			$thumbHeight = $gallery["thumbHeight"];
			$thumbMethod = $gallery["thumbMethod"];
			$thumbColour = $gallery["thumbColour"];
			$mediumWidth = $gallery["mediumWidth"];
			$mediumHeight = $gallery["mediumHeight"];
			$mediumMethod = $gallery["mediumMethod"];
			$mediumColour = $gallery["mediumColour"];
			$largeWidth = $gallery["largeWidth"];
			$largeHeight = $gallery["largeHeight"];
			$largeMethod = $gallery["largeMethod"];
			$largeColour = $gallery["largeColour"];
			#moduleGalPath is set manually in the settings_modules table, only set for module galleries
			if(isset($gallery['moduleGalPath'])) $galID = $gallery['moduleGalPath'];
			else $galID = $gallery["priKeyID"];
			
			$original_path = $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/original/"; 
	 		$thumb_path =  $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/thumb/";
	 		$medium_path =  $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/medium/";
	 		$large_path =  $_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $galID . "/large/";
	 		
	 		#original
	 		if(!file_exists($original_path)){
				mkdir($original_path,0755,true);
			}
			$original_path .= $image["fileName"];
			#thumb
			if(!file_exists($thumb_path)){
				mkdir($thumb_path,0755,true);
			}
			$thumb_path .= $image["fileName"];
			if(is_file($thumb_path)){
				unlink($thumb_path);
			}
			#medium
			if(!file_exists($medium_path)){
				mkdir($medium_path,0755,true);
			}
			$medium_path .= $image["fileName"];
			if(is_file($medium_path)){
	 			unlink($medium_path);
			}
			#large
			if(!file_exists($large_path)){
				mkdir($large_path,0755,true);
			}
	 		$large_path .= $image["fileName"];
	 		if(is_file($large_path)){
	 			unlink($large_path);
			}
	 		
			foreach(
				array(
					$thumb_path=>array($thumbMethod,$thumbWidth,$thumbHeight,$thumbColour),
					$medium_path=>array($mediumMethod,$mediumWidth,$mediumHeight,$mediumColour),
					$large_path=>array($largeMethod,$largeWidth,$largeHeight,$largeColour)
				) as $key => $value
			){
			    #set original as our photo object 
				$origImg = $this->load($original_path);
				$origWidth = $this->getWidth($origImg);
				$origHeight = $this->getHeight($origImg);
				switch($value[0]){
					case 0: #auto (smallest change)
						$widthDiff = abs($value[1] - $origWidth);
						$heightDiff = abs($value[2] - $origHeight);
						if($widthDiff > $heightDiff){
							$this->resizeToHeight($value[2]);
						}
						else{
							$this->resizeToWidth($value[1]);
						}
						$this->applyFilter($value[3]);
					  	$this->save($key,$this->getImgType());
						break;
					case 1: #scale to width
						$this->resizeToWidth($value[1]);
						$this->applyFilter($value[3]);
					  	$this->save($key,$this->getImgType());
						break;
					case 2: #scale to height
						$this->resizeToHeight($value[2]);
						$this->applyFilter($value[3]);
					  	$this->save($key,$this->getImgType());
						break;
					case 3: #scale to both (may crop)
						$widthDiff = abs($value[1] - $origWidth);
						$heightDiff = abs($value[2] - $origHeight);
						if($widthDiff > $heightDiff){
							$this->resizeToHeight($value[2]);
						}
						else{
							$this->resizeToWidth($value[1]);
						}
						
						$this->crop($value[1],$value[2]);
						$this->applyFilter($value[3]);
					  	$this->save($key,$this->getImgType());
						break;
					case 4: #stretch to fit (may distort)
						$this->resizeToBoth($value[1],$value[2]);
						$this->applyFilter($value[3]);
					  	$this->save($key,$this->getImgType());
						break;			
				}
			}
		}
		
		public function resizeToHeight($height) {
			$ratio = $height / $this->getHeight();
			$width = $this->getWidth() * $ratio;
			$this->resize($width,$height);
		}
		
		public function resizeToWidth($width) {
			$ratio = $width / $this->getWidth();
			$height = $this->getheight() * $ratio;
			$this->resize($width,$height);
		}
		
		public function resizeToBoth($width,$height) {
			$this->resize($width,$height);  
		}
		
		public function stretchToBoth($width,$height) {
			$this->resize($width,$height);
		}
				
		public function crop($newwidth, $newheight) {
			
			$x = $this->getWidth();
			$y = $this->getHeight();
		
			// old images width will fit
			if(($x / $y) < ($newwidth/$newheight)){
				$scale = $newwidth/$x;
				$newX = 0;
				$newY = - ($scale * $y - $newheight) / 2;
		
			// else old image's height will fit
			}else{
				$scale = $newheight/$y;
				$newX = - ($scale * $x - $newwidth) / 2;
				$newY = 0;
			}
		
			// new image
			$new_image = imagecreatetruecolor($newwidth, $newheight);
			
			#lets image keep transparency
			imagealphablending($new_image, false);
			imagesavealpha($new_image,true);
			$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
			imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
		
			// now use imagecopyresampled
			imagecopyresampled(
				$new_image, $this->image, 
				$newX, $newY, 0, 0, 
				$scale * $x, $scale * $y, $x, $y
			);
			
			$this->image = $new_image;
		}
		
		public function resize($width,$height) {
			#make sure we have a with and height
			$width = ($width >= 1) ? $width : 1;
			$height = ($height >= 1) ? $height : 1;

			$new_image = imagecreatetruecolor($width, $height);
			
			#lets image keep transparency
			imagealphablending($new_image, false);
			imagesavealpha($new_image,true);
			$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
			imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
			 
			imagecopyresampled(
				$new_image, $this->image, 
				0, 0, 0, 0, 
				$width, $height, $this->getWidth(), $this->getHeight()
			);
			$this->image = $new_image;
		} 
		
		public function applyFilter($filterType){
			switch($filterType){
				case 1: #greyscale
					imagefilter($this->image,IMG_FILTER_GRAYSCALE);
					break;
				case 0:
				default:
					break;
			}
		}
		
		function compress_png($path_to_png_file, $max_quality = 90){
			if (!file_exists($path_to_png_file)) {
				throw new Exception("File does not exist: $path_to_png_file");
			}
		
			// guarantee that quality won't be worse than that.
			$min_quality = 60;
		
			// '-' makes it use stdout, required to save to $compressed_png_content variable
			// '<' makes it read from the given file path
			// escapeshellarg() makes this safe to use with any path
			$compressed_png_content = exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg($path_to_png_file));
		
		}
		
		function compress_jpeg($path_to_jpeg_file){
			if (!file_exists($path_to_jpeg_file)) {
				throw new Exception("File does not exist: $path_to_jpeg_file");
			}

			$compressed_jpeg_content = exec(
				"jpegtran -outfile " . escapeshellarg($path_to_jpeg_file)  . " -optimize -verbose -progressive -copy none " . escapeshellarg($path_to_jpeg_file)
			);
		
			return $compressed_jpeg_content;
		}
		   
	}

	//ajax, our first parameter is the function name, the other parameters are parameters for that function
	if(isset($_REQUEST["function"])){	
		$moduleObj = new galleryImage(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new galleryImage(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>