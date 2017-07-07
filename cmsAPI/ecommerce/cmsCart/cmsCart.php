<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class cmsCart extends common{
		
		public $moduleTable = "";
				
		public function __construct($isAjax){
			parent::__construct($isAjax);
			
			if(!isset($_SESSION)){
				session_start();
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
			}
			
			#check to see if we have a cart in our session, if not, create it
			if(!isset($_SESSION["cartProductIDs"])) $_SESSION["cartProductIDs"] = array();
		
		}
		
		public function editOrderAddCart($orderID) {
			if($orderID == 0) {
				#remove the session variable, we are no longer editing an order
				if(isset($_SESSION["editOrder"])){
					unset($_SESSION["editOrder"]);
				} 
				
				#empty the cart
				if(isset($_SESSION["cartProductIDs"])) unset($_SESSION["cartProductIDs"]);
			}
			elseif ($_SESSION['sessionSecurityLevel'] == 3){
				#set the session variable, we are no longer editing an order
				if(!isset($_SESSION["editOrder"])){
					$_SESSION["editOrder"] = array();	
				} 
				
				#make sure the cart is empty.
				if(isset($_SESSION["cartProductIDs"])) unset($_SESSION["cartProductIDs"]);
				if(!isset($_SESSION["cartProductIDs"])) $_SESSION["cartProductIDs"] = array();

				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrder.php");
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductMap.php");
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductOptionMap.php");
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");

				$storeOrderObj = new storeOrder(false, NULL);
				$storeOrderProductMapObj = new storeOrderProductMap(false, NULL);
				$storeOrderProductOptionMapObj = new storeOrderProductOptionMap(false, NULL);
				$productsObj = new products(false, NULL);
				
				#get all existing order info
				$storeOrder = $storeOrderObj->getRecordByID($orderID);
				if(mysqli_num_rows($storeOrder) > 0){
					$order = mysqli_fetch_assoc($storeOrder);
					
					$_SESSION["editOrder"]["orderID"] = $orderID;
					$_SESSION["editOrder"]["shipName"] = $order["shipName"];
					$_SESSION["editOrder"]["primaryPhone"] = $order["primaryPhone"];
					$_SESSION["editOrder"]["shipStreet"] = $order["shipStreet"];
					$_SESSION["editOrder"]["shipCity"] = $order["shipCity"];
					$_SESSION["editOrder"]["shipProvStateID"] = $order["shipProvStateID"];
					$_SESSION["editOrder"]["shipPostalZip"] = $order["shipPostalZip"];
					$_SESSION["editOrder"]["shipCountryID"] = $order["shipCountryID"];
					
				}

				#get all products that are associated with this order
				$orderProdMap = $storeOrderProductMapObj->getConditionalRecord(
					array("storeOrderID",$orderID,true)
				);
				$products = $productsObj->getAllRecords();

				#loop though all products
				while($x = mysqli_fetch_array($orderProdMap)){
					#get all the options associated with this product
					$orderProdOptionMap = $storeOrderProductOptionMapObj->getConditionalRecord(
						array("storeOrderProductMapID",$x["priKeyID"],true)
					);
					$opsArray = [];
					while($y = mysqli_fetch_array($orderProdOptionMap)){
						#push this option to the array with the qty
						$opsArray[$y["productID"]] = $y["qty"];	
					}
					$cartObj = new cmsCart(false, NULL);
					#call the funtion that actually adds everything to the cart
					$cartObj->adjustCartItemQty($x["productID"],$x["qty"],true,$opsArray);
				}
			}
		}
		
		public function adjustCartItemQty($productID,$prodQty,$setQty,$opsArray){
			#var_dump($opsArray);
			if(!isset($_SESSION)){
				session_start();
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
			}
			
			if(strpos($productID,"_") !== false){
				$tempArray = explode("_",$productID);
				$loc = $tempArray[1];
				$tempProdID = $tempArray[0];
				$cartPage = true;
			}
			else{
				$loc = count($_SESSION["cartProductIDs"]["product$productID"]);
				//$loc = count($_SESSION["cartProductIDs"]["product$tempProdID"]);
				$cartPage = false;
				$tempProdID = $productID;
			}
			
			$_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["productID"] = $tempProdID;

			#because of the front end select menu's, it's easier
			#to remove all our options and add them again
			unset($_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["options"]);
			
			#prodID array we use for our product query, add options to it
			$prodIDList = array($tempProdID);
			
			
			#categoryID for any options that are a select, index of the categoryID
			#must be the same index as the prodID is in the $prodIDList
			$prodOpCatList = array("");
			#option qty, must be same index as prodID
			$prodQtyList = array($prodQty);
			
			#add options to 
			foreach($opsArray as $key => $value){
				#its a select item and we need to get the productID without the category
				if(strpos($key,"_")){ 
					array_push($prodIDList,substr($key,0,strpos($key,"_")));
					array_push($prodOpCatList,substr($key,strpos($key,"_") + 1));
				}
				else{
					array_push($prodIDList,$key);
					array_push($prodOpCatList,"");
				}
				array_push($prodQtyList,$opsArray[$key]);
			}

			/*foreach ($prodIDList as &$value) {
				$temp = explode("_",$value);
				$value = $temp[0];
			}*/
			
			#turn array to string
			$prodIDStr = implode(",",$prodIDList);
			
			#get product option info
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/products/products.php');
			$productsObj = new products(false);
			$productInfo = $productsObj->getConditionalRecordFromList(array("priKeyID",$prodIDStr,true,"LIST"));

			#we add a cartQty field to our JSON object to use in the browser
			$prodJSON = $productsObj->myySQLQueryToJSON($productInfo);

			#check if we have items in inventory and add to cart
			#cartQty in the JSON object is how many they want to add to cart
			#if the inventory level doesn't allow it, it won't get added
			$pCnt = 0;
			$negInv = false;
			while($prodInfo = mysqli_fetch_assoc($productInfo)){
				$tempStr = explode("_",$productID);
				
				#print_r($prodInfo);

				#primary product
				if($prodInfo["priKeyID"] == $tempStr[0]){
				
					#determine what the new inventory will be after the qty change
					if($setQty=="true") {
						$newInventoryQty = $prodInfo["invtQty"] - $prodQty;
					}
					else {
						$newInventoryQty = $prodInfo["invtQty"] - $prodQty - $_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["qty"];
					}
					
					#check inventory level and if negative quanties are allowed
					if(
						$newInventoryQty >= 0 || 
						($newInventoryQty < 0 && $prodInfo["allowNegInvt"] == 1)
					){
						#set the qty to a specific number
						if($setQty=="true") {
							$_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["qty"] = $prodQty;
						}
						#adjust the qty
						else {
							$_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["qty"] = $_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["qty"] + $prodQty;
						}
						
						#insert our cartQty before the pzriKeyID
						$prodJSON = str_replace(
							'"priKeyID":"' . $productID . '"',
							'"cartQty":"' . $prodQtyList[$pCnt] . '","priKeyID":"' . $productID . '","cartLocation":"' . $loc . '"',
							$prodJSON
						);
					}
				}
				#product options, set option in product session array
				else{
					$newInventoryQty = $prodInfo["invtQty"] - $prodQtyList[$pCnt];
					
					#print_r($prodInfo);
					#print_r($prodQtyList);
					#print_r($prodOpCatList);

					#check inventory level and if negative quanties are allowed
					if($newInventoryQty >= 0 || $prodInfo["allowNegInvt"] == 1){

						$_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["options"]["option" . $prodInfo["priKeyID"]]["optionID"] = $prodInfo["priKeyID"];
						$_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["options"]["option" . $prodInfo["priKeyID"]]["qty"] = $prodQtyList[$pCnt];

						#if this option is a select we need the option category for it
						if($prodOpCatList[$pCnt] !== "") {
							$catIDJSON = '"catOpID":"' . $prodOpCatList[$pCnt] . '",';
						}
						else $catIDJSON = '';					
					}
					#they want to add an option not available. remove this product from the cart
					elseif($newInventoryQty < 0 && $prodInfo["allowNegInvt"] == 0) $negInv = true;

					#insert our cartQty before the priKeyID
					$prodJSON = str_replace(
						'"priKeyID":"' . $prodInfo["priKeyID"] . '"',
						$catIDJSON . '"cartQty":"' . $prodQtyList[$pCnt]. '","priKeyID":"' . $prodInfo["priKeyID"] . '","cartLocation":"' . $loc . '"',
						$prodJSON
					);
				}
				$pCnt++;
			}
			#remove from cart if they choose too, or if they tried to get something not in stock
			if($_SESSION["cartProductIDs"]["product$tempProdID"][$loc]["qty"] <= 0 || $negInv) {
				
				//If this is the last item in the cart, and it is being removed
				if(count($_SESSION["cartProductIDs"]["product$tempProdID"]) === 1 && count($_SESSION["cartProductIDs"]) === 1) {
					//unset the cart
					unset($_SESSION["cartProductIDs"]);
				}
				else {
					
					//If this is the only poduct instance of this product remove it entirely 
					if (sizeof($_SESSION["cartProductIDs"]["product$tempProdID"]) == 1) {
						unset($_SESSION["cartProductIDs"]["product$tempProdID"]);
					} else {
						//else remove just the single instance of the product
						unset($_SESSION["cartProductIDs"]["product$tempProdID"][$loc]);
					}
					//after removing the item from the array we need to reset all of the locations
					if(isset($_SESSION["cartProductIDs"]["product$tempProdID"])){
						//create a new array containing the remaining values
						$temp_array = array_values($_SESSION["cartProductIDs"]["product$tempProdID"]);
						//set our array to the temp array so that it will contain the correct indexs 
						$_SESSION["cartProductIDs"]["product$tempProdID"] = $temp_array;	
					}
				}
				
			}
			
			
			

			#return	JSON
			if($this->ajax) echo $prodJSON;
			else return $result;
		}
		
		public function getCartProductTotal(){
			if(!isset($_SESSION)){
				session_start();
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
			}
			
			$productTotal = 0;
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
			$productsObj = new products(false);
			
			#object with no ajax
			$cmsCartObj = new cmsCart(false);
			
			#loop through the cart
			foreach($_SESSION["cartProductIDs"] as $key => $value){

				foreach($value as $loc => $cartProd) {
						$prodQty = $_SESSION["cartProductIDs"][$key][$loc]["qty"];
						#get product info
						$prodID = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
						$productInfo = $productsObj->getRecordById($prodID);
						$p = mysqli_fetch_assoc($productInfo);
						
						#increment total for this product
						$productTotal += $productsObj->getUserProductPrice($p["priKeyID"]) * $prodQty;
						#echo "HERE--" . $productTotal. "--";
						
						#increment total for this products options
						$productTotal += $cmsCartObj->getCartProductOptionTotal($p["priKeyID"], $loc) * $prodQty;
						
						#echo "HERE--" . $productTotal. "--";
				}
			}
			
			if($this->ajax) echo number_format(round($productTotal,2),2);
			else return round($productTotal,2);
		}
		
		#get the option total for a specific product, they is the location in the cart
		public function getCartProductOptionTotal($productID, $key){
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
			$productsObj = new products(false);
			$productTotal = 0;

			$loc = $_SESSION["cartProductIDs"]["product$productID"][$key];
			
			if(isset($loc["options"])){
				foreach($loc["options"] as $key2 => $value2){
					
					$prodOpID = $loc["options"][$key2]["optionID"];
					$prodOpQty = $loc["options"][$key2]["qty"];
					$productTotal += $productsObj->getUserProductPrice($prodOpID) * $prodOpQty;
					
					
				}
			}
					
			if($this->ajax) echo number_format(round($productTotal,2),2);
			else return round($productTotal,2);
		}
		
		/*public function getCartProductOptionTotal($productID){
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
			$productsObj = new products(false);
			$productTotal = 0;
			
			#loop through chosen options for this product
			if(isset($_SESSION["cartProductIDs"]["product$productID"]["options"])){
				foreach($_SESSION["cartProductIDs"]["product$productID"]["options"] as $key2 => $value2){
					$prodOpID = $_SESSION["cartProductIDs"]["product$productID"]["options"][$key2]["optionID"];
					$prodOpQty = $_SESSION["cartProductIDs"]["product$productID"]["options"][$key2]["qty"];
					$productTotal += $productsObj->getUserProductPrice($prodOpID) * $prodOpQty;
				}
			}
				
			if($this->ajax) echo number_format(round($productTotal,2),2);
			else return round($productTotal,2);
		}*/
		
		public function getCartTaxTotal(){
			if(!isset($_SESSION)){
				session_start();
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
			}
			
			$taxTotal = 0;
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
			$productsObj = new products(false);
	
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/productTaxMap.php");
			$productTaxMapObj = new productTaxMap(false);
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/taxes.php");
			$taxesObj = new taxes(false);
			
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
			$cmsCartObj = new cmsCart(false);
			
			
			#we can only determine what taxes to use once we know the shipping location
			#this session variable is set in canadapost.php getShippingOptions()
			if(isset($_SESSION["salesTaxIDList"]) && strlen($_SESSION["salesTaxIDList"]) > 0){
				#loop through the cart

				foreach($_SESSION["cartProductIDs"] as $key => $value){	
					#loop through each product/option configuration in the cart
					foreach($value as $loc => $cartProd){
							
						$prodQty = $_SESSION["cartProductIDs"][$key][$loc]["qty"];
					
						#get product info
						$prodID = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
						$productInfo = $productsObj->getRecordById($prodID);
						$p = mysqli_fetch_assoc($productInfo);
					
						#get taxes for this product
						$prodMapped = $productTaxMapObj->getConditionalRecordFromList(
							array(
								"taxID",$_SESSION["salesTaxIDList"],true,
								"productID",$prodID,true
							)
						);

						#figure out the taxes for this product
						while($x = mysqli_fetch_assoc($prodMapped)){
							$taxInfo = $taxesObj->getRecordById($x["taxID"]);
							$y = mysqli_fetch_assoc($taxInfo);
							$taxTotal += ($productsObj->getUserProductPrice($p["priKeyID"]) * $prodQty) * 
										 ($y["taxAmount"]/100);
									  
							#taxes for product options
							$taxTotal += $cmsCartObj->getCartProductOptionTotal(
								$p["priKeyID"],$loc
							)* ($y["taxAmount"]/100);
						}
					}
				}	
			}
			
			if($this->ajax) echo number_format(round($taxTotal,2),2);
			else return round($taxTotal,2);
		}
		
		public function getCartTotal(){
			$cmsCartObj = new cmsCart(false);
			
			$prodTotal = $cmsCartObj->getCartProductTotal();
			$taxTotal = $cmsCartObj->getCartTaxTotal();
			$cartTotal =  $prodTotal + $taxTotal;
			
			if($this->ajax) echo number_format(round($cartTotal,2),2,".","");
			else return round($cartTotal,2);
		}
		
		public function getCartItemQty(){			
			
			if(!isset($_SESSION)){
				session_start();
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
			}
			
			$itemQty = 0;
			
			#loop through the cart
			foreach($_SESSION["cartProductIDs"] as $key => $value) {
				#loop through each product/option configuration in the cart
				foreach($value as $loc => $cartProd) {
					
					$itemQty += $_SESSION["cartProductIDs"][$key][$loc]["qty"];
				}
			}
			
			if($this->ajax) echo $itemQty;
			else return $itemQty;
		}
		
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new cmsCart(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
?>