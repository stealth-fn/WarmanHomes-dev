<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class instanceBlogSidebar extends common{	
		public $moduleTable = "instance_blog_sidebar";
		public $instanceTable = "instance_blog_sidebar";
		public $settingTable = "instance_blog_sidebar";
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
		}
		
		public function getBlogCatTree($treeArray){
			
			global $rootCatID;
			global $rootID;
			
			//our keys are the blogCat id's, the values are associative arrays
			foreach($treeArray as $blogCatID => $currentArray){				
				//string since we output as js
				$isRoot = "false";
								
				//+1 for styles
				$treeLevel = $currentArray["level"] + 1;
				$childLevel = $currentArray["level"] + 2;
				
				//$rootCatID = $currentArray["rootID"];
				
				if($treeLevel === 1){
					//get categories that aren't sub categories, they will be our root categories
					$isRoot = "true";
					$rootID = $blogCatID;
					$rootCatID = $blogCatID . "-" . $treeLevel . "-" . $blogCatID;
					$afterRun = $this->createInstanceOnclick($blogCatID,$blogCatID);
				}
				else{
					$afterRun = $this->createInstanceOnclick($blogCatID,$currentArray["rootID"]);
				}
				
				$onMouseOver = "";
				$onMouseOut = "";
				$onclick = "";
				
				//how many products are in this category
				//$categoryProducts = parent::getAllCategoryProducts($x["priKeyID"]);
				//$catProdQty = mysqli_num_rows($categoryProducts);
				
				/*if($blogCatID == 0){
					$rootCatID = $blogCatID . "-" . $treeLevel . "-" . $blogCatID;
				}*/
				
				//0 - side tree, 1 - top tree
				if(isset($topSide) && $topSide == 1){
					$onMouseOver = '$s("blogCatChildren' . $blogCatID . '-' . $treeLevel . '-' . $blogCatID . '").style.display="block";
									clearTimeout("naDropTimeblogCatChildren' . $blogCatID . '");
									prevHideID="blogCatChildren' . $blogCatID . '-' . $treeLevel . '-' . $blogCatID . '";';
					$onMouseOut = 'accordionTreeBlogCatObj.mouseOutTop("' . $blogCatID . '-' . $treeLevel . '-' . $rootID . '")';
					$onclick = 'event.cancelBubble = true;if (event.stopPropagation){event.stopPropagation();}' . $afterRun;
				}
				else{
					$onMouseOver = "";
					$onMouseOut = "";
					$onclick = 'accordionTreeBlogCatObj.toggleBlind("' . $blogCatID . "-" . $treeLevel . "-" . $rootID . '",' . $isRoot . ',"' . $rootCatID . '","' . $afterRun . '",this,event)';
				}
									
				echo "<div 
						class='navChoose blogCatTreeLvl" , $treeLevel , "' 
						id='blogRootCat" , $blogCatID , "-" , $treeLevel , "-" , $rootID , "' 
						onmouseover='" , $onMouseOver , "' 
						onmouseout='" , $onMouseOut , "' 
						onclick='" , $onclick , "'  
						>
						<p 
							class='navChoose bcatLvl" , $treeLevel , "' 
							id='bcat" , $blogCatID , "-" , $treeLevel , "-" , $rootID , "'>" . 
								$currentArray["categoryName"] , 
							"</p>
							<div 
							class='blogCatChildren" , $treeLevel , "' 
							id='blogCatChildren" , $blogCatID , "-" , $treeLevel , "-" , $rootID , "' 
							style='display: none'
							>";
							
					foreach($currentArray as $subKey => $subValue){
						if(is_numeric($subKey)){			
							echo $this->getBlogCatTree($subValue);
						}
					}			
				echo "</div>";
				echo "</div>";		  
		  	}
		}
	}

	if(isset($_REQUEST["function"])){
		$moduleObj = new instanceBlogSidebar(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceBlogSidebar(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>