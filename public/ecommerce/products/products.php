<?php
	/*too keep the id's unique in the cart, we keep track of how many of each product we have, and add an incrementer.
	this incrementer is also the location of this product in the cart, so we know what which product options to mark
	for each product*/
	
	$mappedOptionCategories = $optionCategoryProductMapObj->getConditionalRecord(
		array("productID",$priModObj[0]->queryResults["priKeyID"],true)
	);
	$optionCategoryIDList = $optionCategoryProductMapObj->getQueryValueString(
		$mappedOptionCategories,"productOptionCategoryID",","
	);	
	$optionCategories = $productOptionCategoryObj->getConditionalRecordFromList(
		array("priKeyID",$optionCategoryIDList,true)
	);
	
	#check if the product has options
	if(mysqli_num_rows($optionCategories) > 0){
		$hasOptions = true;
	}
	else{
		$hasOptions = false;
	}
		
	if(!isset($tempProdArray)) {
		$tempProdArray = array();
	}
	$preID = $priModObj[0]->queryResults["priKeyID"];
	
	if($hasOptions){
		if(isset($priModObj[0]->viewCart)) {		
			if(!isset($tempProdArray[$priModObj[0]->queryResults["priKeyID"]])) {
				$tempProdArray[$priModObj[0]->queryResults["priKeyID"]] = 0;
			}
			else{
				$tempProdArray[$priModObj[0]->queryResults["priKeyID"]]++;
			}
	
			$priModObj[0]->queryResults["priKeyID"] .= "_" . $tempProdArray[$priModObj[0]->queryResults["priKeyID"]];
		}
		else {
			if(
				isset($_SESSION["cartProductIDs"]) &&
				isset($_SESSION["cartProductIDs"]["product". $priModObj[0]->queryResults["priKeyID"]])
			){
				$tempLength = count($_SESSION["cartProductIDs"]["product". $priModObj[0]->queryResults["priKeyID"]]);
				$priModObj[0]->queryResults["priKeyID"] .= "_" . $tempLength;
			}
			else{
				$priModObj[0]->queryResults["priKeyID"] .= "_0";
			}
		}
	}
	else{
		$tempProdArray[$priModObj[0]->queryResults["priKeyID"]] = 0;
		$priModObj[0]->queryResults["priKeyID"] .= "_0";
	}

//echo "HERE!" . $preID;
//var_dump($tempProdArray);
	#SET VARIABLES THAT WE USE IN MORE THAN ONE DOM ELEMENT
	if(
		array_key_exists("hpp",$priModObj[0]->domFields) || 
		array_key_exists("cqp",$priModObj[0]->domFields) ||
		array_key_exists("hppda",$priModObj[0]->domFields)
	){
		$userPrice = htmlspecialchars(
			number_format(
				$priModObj[0]->getUserProductPrice($priModObj[0]->queryResults["priKeyID"]),2
			)
		);
	}
	
	#WRAP ALL PRODUCT DOM ELEMENTS IN FORM
	if(array_key_exists("pfo",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfo"] = '
		<form
			action="#"
			id="form' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] .'" 
			name="form' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] .'"
		>';
	}

	/*PRICE FIELD - JUST ONE - WE NEED THE <span>
	for easy access to the price for our javascript*/
	if(array_key_exists("hpp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hpp"] = 
		'<div 
			class="hpp-'. $priModObj[0]->className .'"
			id="hpp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>$ <span>' . $userPrice . '</span>';
		$priModObj[0]->domFields["hpp"] .= '</div>';
	}
 
	#PRODUCT PAGE BUTTON 2
	if(array_key_exists("hpgb",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hpgb"] =
		'<a
			class="hpgb hpgb-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID=' . $priModObj[0]->productPageID .'&amp;productsID=' . $priModObj[0]->queryResults["priKeyID"].'" 
			onclick="upc(
				' . $priModObj[0]->productPageID .',
				\'productsID='.$priModObj[0]->queryResults["priKeyID"].'\'
			);return false"
		>' . $priModObj[0]->viewProdBtnText2 . '</a>';
	}
 
	#PRICE FIELD FOR ALL OF THIS ITEM IN CART
	if(array_key_exists("cqp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["cqp"] =
		'<div 
			class="cqp cqp-'. $priModObj[0]->className.'"
			id="cqp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>$';
		
		#get the total for the number of this product without options
		$combinedItemUserPrice =
		isset($_SESSION["cartProductIDs"]["product" . $priModObj[0]->queryResults["priKeyID"]])
		? htmlspecialchars(
			number_format(
				$userPrice * $_SESSION["cartProductIDs"]["product" . $priModObj[0]->queryResults["priKeyID"]]["qty"],2
			)
		) :  ""; 
		
		#get the total including options
		$combinedItemUserPrice += $cmsCartObj->getCartProductOptionTotal($priModObj[0]->queryResults["priKeyID"]);
		
		$priModObj[0]->domFields["cqp"] .= $combinedItemUserPrice . '</div>';
	}
 
	#PRICE FIELD FOR ALL OF THIS ITEM IN CART WITH IT'S SELECTED OPTIONS
	if(array_key_exists("coqp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["coqp"] =
		'<div 
			class="coqp coqp-' . $priModObj[0]->className. '"
			id="coqp-' . $priModObj[0]->className. '-'. $priModObj[0]->queryResults["priKeyID"].'"
		>$';
		
		$combinedOptionUserPrice =
		isset($_SESSION["cartProductIDs"]["product" . $priModObj[0]->queryResults["priKeyID"]])
		? $cmsCartObj->getCartProductOptionTotal(
			$priModObj[0]->queryResults["priKeyID"]
		) : "";
		
		$priModObj[0]->domFields["coqp"] .=
		htmlspecialchars(number_format($combinedOptionUserPrice + $combinedItemUserPrice,2)) . '
		</div>';
	}

	#IN/OUT OF STOCK MESSAGE
	if(array_key_exists("hps",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hps"] =
		'<div class="hps hps-'. $priModObj[0]->className . '">';
		
		$priModObj[0]->domFields["hps"] .=
		($priModObj[0]->inventoryDispayType == 1) 
			? $priModObj[0]->queryResults["invtQty"] :
					($priModObj[0]->queryResults["invtQty"] > 0) 
					 ? $priModObj[0]->inventoryInStockText : $priModObj[0]->inventoryOutStockText;
		$priModObj[0]->domFields["hps"] .= '</div>';
	}

	#DISCOUNT AMOUNT
	if(array_key_exists("hppda",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hppda"] = '
		<div class="hppda hppda-' . $priModObj[0]->className . '">
			$' . 
			htmlspecialchars(
				number_format(
					$priModObj[0]->queryResults["price"] - $userPrice,2
				)
			) .'
		</div>';
	}

	#PRODUCT NAME
	if(array_key_exists("hpn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hpn"] = '
		<div 
			class="hpn hpn-' . $priModObj[0]->className . '" 
			id="hpn-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["productName"]) .'
		</div>';
	}

	#SKU
	if(array_key_exists("hpsku",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hpsku"] = '
		<div class="hpsku hpsku-' . $priModObj[0]->className .'"> 
			' . htmlspecialchars($priModObj[0]->queryResults["sku"]) .'
		</div>';
	}

	#PRODUCT OPTION CATEGORIES
	if(array_key_exists("hpoc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hpoc"] = '
		<div class="hpoc hpoc-' . $priModObj[0]->className . '">';
		
		#generate form validation code here so we don't have to requery for it later
		$_GET["moduleScripts"] .= '$("#form' .$priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '").validate({rules: {';
		$selectOpQty = ''; #loop through option categories
		$requiredOptions = ''; #required form fields
		
		while($poc = mysqli_fetch_assoc($optionCategories)){
	
			$priModObj[0]->domFields["hpoc"] .= '
				<h3>' . $poc["productOptionCategoryDesc"] . '</h3>
			';
			
			//Add a hidden label to allow for friendly error messages
			$priModObj[0]->domFields["hpoc"] .= '<label class="hidden" for="po_'. $priModObj[0]->queryResults["priKeyID"] . "_" .  $poc["priKeyID"]. '">'.$poc["productOptionCategoryDesc"].'</label>';
			
			/*If not a drop down or a list 
				Put a hidden input. We do this so that when there is 
				an error the user will get friendly names*/
			if($poc["optionGroupType"] != 2 && $poc["optionGroupType"] != 3){
				$priModObj[0]->domFields["hpoc"] .= '<input	
						class="hidden"
						type="checkbox"
						name="po_' . $priModObj[0]->queryResults["priKeyID"] . '_' . $poc["priKeyID"] .'"
						id="po_' . $priModObj[0]->queryResults["priKeyID"] . '_' . $poc["priKeyID"] .'"
					/>';
			}
					
			#which option categories belong to this product
			$priModObj[0]->domFields["hpoc"] .= '
			<input
				name="poc_' . $priModObj[0]->priKeyID . '_' . $priModObj[0]->queryResults["priKeyID"] .'"
				type="hidden"
				value="' . $poc["priKeyID"] .'"
			/>';
			
			$mappedCategoryOptions = $prodOpCatMap->getConditionalRecord(
				array("productOptionCategoryID",$poc["priKeyID"],true)
			);
			$categoryOptionIDList = $prodOpCatMap->getQueryValueString($mappedCategoryOptions,"productID",",");
			$productOptions = $priModObj[0]->getConditionalRecordFromList(
				array("priKeyID",$categoryOptionIDList,true)
			);
			
			#counter to keep track of if we are at the start or end of the loop
			#used to opening and closing the select tag
			$opCnt = 1;
			$opLen = mysqli_num_rows($productOptions);
			$selectedOption = '';
			#we assume we don't change the order in the queries, and the options in the
			#mapping query are in the same order as in the actual productOptions query
			while($po = mysqli_fetch_assoc($productOptions)){
				$opChecked = '';
				if(isset($priModObj[0]->viewCart)){
					if(isset($_SESSION["cartProductIDs"]["product".$preID][$tempProdArray[$preID]]["options"]["option" . $po["priKeyID"]]["qty"])){
						$opQty = $_SESSION["cartProductIDs"]["product".$preID][$tempProdArray[$preID]]["options"]["option" . $po["priKeyID"]]["qty"];
				
						if($opQty > 0){
							if($poc["optionGroupType"] != 2) $opChecked = 'checked="checked"';
							else{
								$opChecked = 'selected="selected"';
								$selectOpQty = $opQty;
							}
						} 
					}
					else {
						$opQty = 0;	
					}
				}
				else {
					$opQty = 0;	
				}
				
				/*bleh dont need i think
				if(isset($priModObj[0]->viewCart)){
					var_dump($_SESSION["cartProductIDs"]);
					//var_dump($po);
					//echo "here" . $opChecked;
					if($opChecked == 'selected="selected"'){
						//$selectedOption =  "<span class=\"selected-option\" name=\"po_" . $priModObj[0]->queryResults["priKeyID"] . "_"
						//.$poc["priKeyID"]. '\" value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . "\">". $po['productName'] . "</span>";
						
					}
					
				}*/
				//else{
				$mappedOptionArray = mysqli_fetch_assoc($mappedCategoryOptions);
					
				#the value of the chosen option, is the qty of the value field
				$userOptionPrice = htmlspecialchars(
					number_format($priModObj[0]->getUserProductPrice($po["priKeyID"]),2)
				);
				
				
				
				
				#if not a drop down
				if($poc["optionGroupType"] != 2){
					$priModObj[0]->domFields["hpoc"] .= '
					<div class="po po-' . $priModObj[0]->className .'">	
						<div class="pop pop-' . $priModObj[0]->className .'">
							$' .$userOptionPrice. '
						</div>
						<label for="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '">
							' .$po["productName"] .'
						</label>';
				}
					
				#radio button - the ID is just for the form label, value is the ID of the qty field
				if($poc["optionGroupType"] == 0){
					$priModObj[0]->domFields["hpoc"] .= '
					<input
						' . $opChecked .'	
						class="' . $poc["productOptionCategoryDesc"] . '"
						id="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"	
						name="po_' . $priModObj[0]->queryResults["priKeyID"] . '_' . $poc["priKeyID"] .'"
						type="radio"
						value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"
					/>';
				}
				#check box - the ID is just for the form label, value is the ID of the qty field
				elseif($poc["optionGroupType"] == 1){
					$priModObj[0]->domFields["hpoc"] .= '
					<input
						' . $opChecked .'	
						class="' . $poc["productOptionCategoryDesc"] . '"
						id="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"	
						
						name="po_' . $priModObj[0]->queryResults["priKeyID"] . '_' . $poc["priKeyID"] .'"
						type="checkbox"
						value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"
					/>';
				}
				elseif($poc["optionGroupType"] == 3){
					$priModObj[0]->domFields["hpoc"] .= '
					<input
						' . $opChecked .'	
						style="display: none"
						id="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"	
						name="po_' . $priModObj[0]->queryResults["priKeyID"] . '_' . $poc["priKeyID"] .'"
						type="checkbox"
						checked="checked"
						value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"
					/>';
				}
				#select
				elseif($poc["optionGroupType"] == 2){
					#open tag and first option
					if($opCnt===1){
						
						$priModObj[0]->domFields["hpoc"] .= '
						<select
							class="' . $poc["productOptionCategoryDesc"] . '"
							name="po_'. $priModObj[0]->queryResults["priKeyID"] . "_" .  $poc["priKeyID"]. '"
							id="po_'. $priModObj[0]->queryResults["priKeyID"] . "_" .  $poc["priKeyID"]. '"
						  >
							<option value="">Select a ' . $poc["productOptionCategoryDesc"] . '</option>
							<option
								' . $opChecked . ' 
								value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"
							>
								' .$po["productName"] . ' - $' . 
								$userOptionPrice .
							'</option>';
					}
					elseif($opCnt <= $opLen){
						$priModObj[0]->domFields["hpoc"] .= '
						<option
							' . $opChecked . ' 
							value="' . $po["priKeyID"] . '_' .  $poc["priKeyID"] . '"
						 >'
							. $po["productName"] . '- $' . $userOptionPrice . 
						'</option>';
					}
						
					if($opCnt === $opLen){
						$priModObj[0]->domFields["hpoc"] .=  '</select>';
						
						#qty field - if the user can't specify, we default to 1
						if($poc["optionQtyField"] == 1){
							if ($selectOpQty < 1) {
								$selectOpQty = 0;
							}
							$priModObj[0]->domFields["hpoc"] .= '<label class="hidden" for="qtypo_'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'">'.$poc["productOptionCategoryDesc"].' Quantity</label>';
							$priModObj[0]->domFields["hpoc"] .= '
							<input
								id="qtypo_'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
								class="qtypo qtypo_'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
								maxlength="4"
								name="qtypo_'. $poc["priKeyID"].'_'. $priModObj[0]->queryResults["priKeyID"].'"
								type="text"
								value="'. $selectOpQty.'"
							/>';
						}
						else{
							$priModObj[0]->domFields["hpoc"] .= '
							<input
								id="qtypo_'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
								class="qtypo qtypo_'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
								name="qtypo_'.$poc["priKeyID"].'_'. $priModObj[0]->queryResults["priKeyID"].'"
								type="hidden"
								value="1"
							/>';
						}
					}
				}
				#qty field - if the user can't specify, we default to 1
				#selects only need one qty field
				if($poc["optionQtyField"] == 1 && $poc["optionGroupType"] != 2){
					$priModObj[0]->domFields["hpoc"] .= '<label class="hidden" for="po_'. $priModObj[0]->queryResults["priKeyID"].'_'. $po["priKeyID"].'">'.$poc["productOptionCategoryDesc"].' - '.$po["productName"].' Quantity</label>';
					$priModObj[0]->domFields["hpoc"] .= '
					<input
						id="po_'. $priModObj[0]->queryResults["priKeyID"].'_'. $po["priKeyID"].'"
						class="qtypo po'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
						name="po_'. $priModObj[0]->queryResults["priKeyID"].'_'. $po["priKeyID"].'"
						type="text"
						value="'. $opQty .'"
					/>';
					
				}
				elseif($poc["optionGroupType"] != 2){
					$priModObj[0]->domFields["hpoc"] .= '
					<input
						id="po_'. $priModObj[0]->queryResults["priKeyID"].'_'. $po["priKeyID"].'"
						class="qtypo po'. $priModObj[0]->queryResults["priKeyID"].'_'. $poc["priKeyID"].'"
						name="po_'. $priModObj[0]->queryResults["priKeyID"].'_'. $po["priKeyID"].'"
						type="hidden"
						value="1"
					/>';
				}						
				
				if($poc["optionGroupType"] != 2){
					$priModObj[0]->domFields["hpoc"] .= '</div>';
				}
				
				/*VALIDATION:
					Quantity field is required if checked.
					Quantity field needs to be greater than 0 if checked.
					Quantity field needs to be a number.
				*/
			
				#If Checkbox or Radio Button
				if($poc["optionGroupType"] != 2 && $poc["optionGroupType"] != 3){
					
					$element = $po['priKeyID'] . "_" .  $poc['priKeyID']; //checkbox element
					$validation = "po_". $priModObj[0]->queryResults["priKeyID"]."_". $po["priKeyID"]." :{required:'#".$element.":checked',number:true,min:function (element) {if(document.getElementById('".$element."').checked) {return 1;}else{return 0;}}}";
					
					if(strlen($requiredOptions) > 0) {
						$requiredOptions .= "," . $validation;
					}
					else {
						$requiredOptions .= $validation;
					}
					
				}
				
				/*VALIDATION:
					Quantity field needs to be a number.
					Quantity field needs to be equal to or greater than 0.
				*/
				
				#if it is a list
				if($poc["optionGroupType"] == 3){
					
					#VALIDATION - Make sure that the input is numerical 
					
					if(strlen($requiredOptions) > 0) {
						//Quantity Field is required if the checkbox is checked
						$requiredOptions .= ",po_". $priModObj[0]->queryResults["priKeyID"]."_". $po["priKeyID"]." :{number:true,min:0}";	
					}
					else {
						//Quantity Field is required if the checkbox is checked
						$requiredOptions .= "po_". $priModObj[0]->queryResults["priKeyID"]."_". $po["priKeyID"]." :{number:true,min:0}";	
					}
					
				}
				$opCnt++;
				
			}
			
			#build up required form properties
			#These propertys need to be validated regardless on if they are required
			
			#select
			if($poc["optionGroupType"] == 2){
				
				$select = 'po_'. $priModObj[0]->queryResults["priKeyID"] . "_" .  $poc["priKeyID"];
			
				$element = "qtypo_".$poc["priKeyID"]."_". $priModObj[0]->queryResults["priKeyID"];
				
				$validation = $element . " :{number:true,min:function (element) {if ($('#".$select."').val() == '') {return 0;}else{return 1;}}}";
				
				//:{required:'#".$element.":checked',number:true,min:function (element) {if($('#".$element."').checked) {return 1;}else{return 0;}}}";
				
				if(strlen($requiredOptions) > 0) {
					$requiredOptions .= "," . $validation;
				}
				else {
					$requiredOptions .= $validation;
				}
			}
			
			#These fields are requried 
			if($poc["optionRequired"] == 1){
				if(strlen($requiredOptions) > 0) {
					$requiredOptions .= ",po_" . $priModObj[0]->queryResults["priKeyID"] . "_" . $poc["priKeyID"] . ":{required:true}";
					$requiredOptions .= ",qtypo_".$poc["priKeyID"]."_". $priModObj[0]->queryResults["priKeyID"]. " :{min:1}";
				}
				else {
					$requiredOptions .= "po_" . $priModObj[0]->queryResults["priKeyID"] . "_" . $poc["priKeyID"] . ":{required:true}";
					$requiredOptions .= ",qtypo_".$poc["priKeyID"]."_". $priModObj[0]->queryResults["priKeyID"]. " :{min:1}";
				}
				
			}
		}
		if(isset($selectedOption)){
			$priModObj[0]->domFields["hpoc"] .= $selectedOption . '</div>';
		}
		else{
			$priModObj[0]->domFields["hpoc"] .= '</div>';	
		}
			
		#complete form validation
		$_GET["moduleScripts"] .= $requiredOptions . '}});';
	}
	
	#PRODUCT FEATUES
	if(array_key_exists("pfl",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfl"] = '
		<div 
			class="pf pf-'. $priModObj[0]->className.'" 
			id="pf-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>';

		$productFeatures = $productFeatureObj->getConditionalRecord(
			array("productID",$priModObj[0]->queryResults["priKeyID"],true)
		);
				
		#determine how many features to list
		if(strlen($priModObj[0]->featureDisplayCount) == 0) {
			$pfQty = mysqli_num_rows($productFeatures);
		}
		else {
			$pfQty = $priModObj[0]->featureDisplayCount;
		}
		
		while($pf = mysqli_fetch_assoc($productFeatures)){
			if($pfQty > 0){
				$priModObj[0]->domFields["pfl"] .= '
				<div 
					class="pfc pfc-'. $priModObj[0]->className.'"
					id="pfc-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
				>
					<div 
						class="pfl pfl-'. $priModObj[0]->className.'"
						id="pfl-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
					>
						'. htmlspecialchars($pf["featureLabel"]).'
					</div>
					<div 
						id="pft-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
						class="pft"
					>
						'. htmlspecialchars($pf["featureText"]).'
					</div>
				</div>'
				;
				$pfQty--;
			}
		}
		$priModObj[0]->domFields["pfl"] .= '</div>';
	}
	
	#PRODUCT FEATURES 2
	if(array_key_exists("pfl2",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfl2"] = '
		<div 
			class="pf2 pf2-'. $priModObj[0]->className.'" 
			id="pf2-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>';

		$productFeatures = $productFeature2Obj->getConditionalRecord(
			array("productID",$priModObj[0]->queryResults["priKeyID"],true)
		);
				
		#determine how many features to list
		if(strlen($priModObj[0]->featureDisplayCount) == 0) {
			$pfQty = mysqli_num_rows($productFeatures);
		}
		else {
			$pfQty = $priModObj[0]->featureDisplayCount;
		}
		
		while($pf = mysqli_fetch_assoc($productFeatures)){
			if($pfQty > 0){
				$priModObj[0]->domFields["pfl2"] .= '
				<div 
					class="pfc2 pfc2-'. $priModObj[0]->className.'"
					id="pfc2-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
				>
					<div 
						class="pfl2 pfl2-'. $priModObj[0]->className.'"
						id="pfl2-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
					>
						'. htmlspecialchars($pf["featureLabel"]).'
					</div>
					<div 
						id="pft2-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'-'. $pf["priKeyID"].'"
						class="pft2"
					>
						'. htmlspecialchars($pf["featureText"]).'
					</div>
				</div>'
				;
				$pfQty--;
			}
		}
		$priModObj[0]->domFields["pfl2"] .= '</div>';
	}
	
	#PRODUCT COPY
	if(array_key_exists("prdc",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["prdc"] = '<div class="prdc prdc-'. $priModObj[0]->className.'">';
		
		if($priModObj[0]->copyLen == 0){
			$priModObj[0]->domFields["prdc"] .= $priModObj[0]->queryResults["productCopy"];
		}
		else{
			$priModObj[0]->domFields["prdc"] .=  
				strip_tags(substr($priModObj[0]->queryResults['productCopy'],0,$priModObj[0]->copyLen));
			$priModObj[0]->domFields["prdc"] .= '...';
		}
		$priModObj[0]->domFields["prdc"] .= '</div>';
	}
	
	#LINK TO CATEGORIES FOR THIS PRODUCT
	if(array_key_exists("pcl",$priModObj[0]->domFields)){
		if($priModObj[0]->categoryLinkQty > 0){
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodCatMap.php");
			$prodCatObj = new prodCatMap(false);
			$mappedCategories = $prodCatObj->getConditionalRecord(
				array("productID",$priModObj[0]->queryResults["priKeyID"],true)
			);
			#if this product belongs to categories
			if(mysqli_num_rows($mappedCategories) > 0){
				$priModObj[0]->domFields["pcl"] = '
				<div class="pcl pcl-'. $priModObj[0]->className.'">';
	
					#get list of category ID's
					$mappedCatIDString = $prodCatObj->getQueryValueString(
						$mappedCategories,
						 "productCategoryID",
						 ","
					);
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
					$productCategoriesObj = new productCategories(false);
					$productCategories = $productCategoriesObj->getConditionalRecordFromList(
						array("priKeyID",$mappedCatIDString,true)
					);
					
					#output category links		
					$prodCatCnt = 0;
					
					#the first category link is always the current category so we give it a unique ID incase we want to display:none - Shawn
					$idLink = true;
					while($mc = mysqli_fetch_assoc($productCategories)){
						if($prodCatCnt<$priModObj[0]->categoryLinkQty){
							if(isset($idFirstLink) && $idFirstLink == true){
								$priModObj[0]->domFields["pcl"] .= '
								<a 
									class="ccl ccl'. $priModObj[0]->className.' sb"
									href="/index.php?pageID='. $priModObj[0]->prodCatPageID.'&amp;prodCatID='. $mc["priKeyID"].'&amp;prodCatParentID='. $mc["priKeyID"].'"
									onclick="upc(
										'. $priModObj[0]->prodCatPageID .',
										\'prodCatID='. $mc["priKeyID"].'&amp;prodCatParentID='. $mc["priKeyID"].'\'
									);
									return false"
								>'. $mc["categoryName"].'</a>';
								$idLink = false;
								}
								else{
									$priModObj[0]->domFields["pcl"] .= '
									<a 
										class="pclnk pclnk-'. $priModObj[0]->className.' sb"
										href="/index.php?pageID='. $priModObj[0]->prodCatPageID.'&amp;prodCatID='. $mc["priKeyID"].'&amp;prodCatParentID='. $mc["priKeyID"].'"
										onclick="upc(
											' . $priModObj[0]->prodCatPageID . ',
											\'prodCatID='. $mc["priKeyID"] .'&amp;prodCatParentID='. $mc["priKeyID"]. '\'
										);
										return false"
									>'. $mc["categoryName"].'</a>';
								}
							}
							$prodCatCnt++;
						}
				$priModObj[0]->domFields["pcl"] .= '</div>';
			}
		}
	}

	#REMOVE ONE ITEM FROM CART BUTTON
	if(array_key_exists("rop",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["rop"] = '					
		<input
			class="rop rop-'. $priModObj[0]->className.' sb" 
			id="rop-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
			onclick="'. $priModObj[0]->className.'.adjustCartItemQty(
				\''.$priModObj[0]->queryResults["priKeyID"].'\',
				-1,
				false
			);"
			type="button"
			value="'. $priModObj[0]->viewCartRemoveOne.'"
		/>';
	}
	
	#ADD ONE PRODUCT TO CART BUTTON
	if(array_key_exists("aop",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["aop"] = '
		<input 
			class="aop aop-'. $priModObj[0]->className.' sb" 
			id="aop-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
			onclick="'. $priModObj[0]->className.'.adjustCartItemQty(
				\''.$priModObj[0]->queryResults["priKeyID"].'\',
				1,
				false
			)"
			type="button"
			value="'. $priModObj[0]->viewCartAddOne.'"
		/>';
	}
	
	#REMOVE ALL FROM CART
	if(array_key_exists("rfc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["rfc"] = '
		<input 
			id="rfc-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
			class="rfc rfc-'. $priModObj[0]->className.' sb" 
			onclick="'. $priModObj[0]->className.'.adjustCartItemQty(
				\''.$priModObj[0]->queryResults["priKeyID"].'\',
				0,
				true
			)"
			type="button"
			value="'. $priModObj[0]->viewCartRemoveFromCart.'"
		/>';
	}
	
	#SET QTY BUTTON
	if(array_key_exists("scq",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["scq"] = '
		<input
			id="scq-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
			class="scq scq-'. $priModObj[0]->className.' sb" ';
			//If selected to send customer to cart when item is added to the cart
			if ($priModObj[0]->sendToCart == 1) {
				$priModObj[0]->domFields["scq"] .= '
				onclick="'. $priModObj[0]->className.'.adjustCartItemQty(
					\''.$priModObj[0]->queryResults["priKeyID"].'\',
					$s(\'pq_'. $priModObj[0]->className . "_" . $priModObj[0]->queryResults["priKeyID"].'\').value,
					true,true
				)"';
			}
			else {
				$priModObj[0]->domFields["scq"] .= '
				onclick="'. $priModObj[0]->className.'.adjustCartItemQty(
					\''.$priModObj[0]->queryResults["priKeyID"].'\',
					$s(\'pq_'. $priModObj[0]->className . "_" . $priModObj[0]->queryResults["priKeyID"].'\').value,
					true
				)"';
			}
			$priModObj[0]->domFields["scq"] .= '
			type="button"
			value="'; 
			$priModObj[0]->domFields["scq"] .= $priModObj[0]->viewCartSetQty.'"/>';

	}
	
	#DISPLAY QTY FIELD
	if(array_key_exists("pqf",$priModObj[0]->domFields)){
		
		#if the qty is determined by options, its a hidden value thats always equal to one
		if($priModObj[0]->queryResults["optionQty"] == 1){
			$tempProdQtyType = "hidden";
		}
		else{
			$tempProdQtyType = "text";
		}

		$priModObj[0]->domFields["pqf"] = '
		<label 
			class="pql pql-'. $priModObj[0]->className.'" 
			id="pql-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>
			Quantity:
		</label>
		<input
			class="pqf pqf-'. $priModObj[0]->className.'"
			id="pq_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
			maxlength="6"
			name="pq_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'" 
			type="' . $tempProdQtyType . '"
			value="';
		if($hasOptions == true && !isset($priModObj[0]->viewCart)){
			$priModObj[0]->domFields["pqf"] .= "1";
		}
		else{
			#if the cart qty is determined by the options our value should always be 1
			if($priModObj[0]->queryResults["optionQty"] == 1){
				$priModObj[0]->domFields["pqf"] .= "1";
			}
			#display a qty if we have this in our cart
			elseif(
				!isset($_SESSION["cartProductIDs"]["product" . $preID][$tempProdArray[$preID]]["qty"]) ||
				strlen($_SESSION["cartProductIDs"]["product" . $preID][$tempProdArray[$preID]]["qty"]) == 0
			) {
				$priModObj[0]->domFields["pqf"] .= "1";
			}
			else{
				$priModObj[0]->domFields["pqf"] .= 
					$_SESSION["cartProductIDs"]["product" . $preID][$tempProdArray[$preID]]["qty"];
			}
		}
		$priModObj[0]->domFields["pqf"] .= '"
		/>';
	}
	
	#DISPLAY CART UPDATE MESSAGE
	if(array_key_exists("ccd",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["ccd"] = '
		<div
			class="ccd ccd-'. $priModObj[0]->className.'"
			id="ccd-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"] .'" 
			style="opacity:0;filter:alpha(opacity=0)"
		>
		</div>';
	}
	
	#VIEW CART BUTTON
	if(array_key_exists("vcb",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vcb"] = '
		<a
			class="vcb vcb-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID='. $priModObj[0]->viewCartPageID.'"
			id="vcb-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
			onclick="upc('. $priModObj[0]->viewCartPageID.');return false"
		>
			'. $priModObj[0]->viewCartButtonText.'
		</a>';
	}

	#VIEW PRODUCT BUTTON
	if(array_key_exists("vpb",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vpb"] = '				
		<a
			class="vpb vpb-'. $priModObj[0]->className.' sb" 
			href="/index.php?pageID='. $priModObj[0]->productPageID.'&amp;productsID='. $priModObj[0]->queryResults["priKeyID"].'" 
			id="vpb-'. $priModObj[0]->className.'-'.$priModObj[0]->queryResults["priKeyID"].'" 
			onclick="upc(
				'. $priModObj[0]->productPageID.',
				\'productsID='. $priModObj[0]->queryResults["priKeyID"].'\'
			);return false" 
		>
			'. $priModObj[0]->viewProdBtnText.'
		</a>';
	}
	
	#WRAP ALL PRODUCT DOM ELEMENTS IN FORM
	if(array_key_exists("pfc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfc"] = '</form>';
	}
	
	#OPTIONS FOR THIS PRODUCT (Doesn't work yet)
	if(array_key_exists("proc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["proc"] = '
		<a
			class="proc proc-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID=-161"&amp;prodID='. $priModObj[0]->queryResults["priKeyID"].'
			id="proc-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
			onclick="atpto_adminTopNav.toggleBlind(\'-161\',true,0,\'upc(-161,\\\'&amp;prodID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--161\',event);return false"
		>Options</a>';
	}
?>

