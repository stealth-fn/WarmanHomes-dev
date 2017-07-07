<div id="productCategoryContainer">
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
	$productCategoriesObj = new productCategories(false);
	$productCategories = $productCategoriesObj->getAllRecords();
	
	while($x = mysqli_fetch_array($productCategories)){
		echo '<div id="prodCatOutter">' .
			 '<div id="prodCatInner" onclick="upc(-46,\'viewProdByCatID=' . $x["priKeyID"] . '\')">' .
				 '<div id="prodCatName">'.
					 $x["categoryName"].
				 '</div>'.
			 '</div>'.
		 '</div>';
	}
?>
</div>