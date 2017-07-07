<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ecommerce/productCategories/productCategories.php');
	

	
	class instanceProductCategory extends productCategories{	
		public $moduleTable = "instance_product_category";
				
		
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new instanceProductCategory(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
?>