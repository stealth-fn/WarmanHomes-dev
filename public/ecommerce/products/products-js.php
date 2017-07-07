if(!publicProdObj.adjustCartItemQty){
	publicProdObj.prototype.adjustCartItemQty = function(productID,prodQty,setQty,goToCart){
		var frmID = "form" + this.moduleClassName + productID;

		if($("#" + frmID).validate().form()){
			var prodAjax = ajaxObj();
			prodAjax.ajPS = this.moduleClassName; //variables to in the ajax event handler
			prodAjax.qty = prodQty;
			prodAjax.sQty = setQty;		
			
			prodAjax.onreadystatechange=function(){
				try{//try / catch's are much easier for debuggin in async events
					if(prodQty >= 0) var adjustTxt = " added to cart.";
					else var adjustTxt = " removed from cart.";
					
					if(prodAjax.readyState===4){
						//location "prodIndex0" is primary product, other values are options
						var prodObj = JSON.parse(prodAjax.responseText);
						
						//if we are on the View Cart page, we want to update the cart totals
						if(isset($s("itemProductTotal"))){
						
							//reset shipping options
							resetShipping();
							
							var itemTotalRequest = ajaxObj();
							var taxesTotalRequest = ajaxObj();
							var cartTotalRequest = ajaxObj();
							
							//server requests for our item total, taxes, and cart total
							itemTotalRequest.onreadystatechange=function(){
								if(itemTotalRequest.readyState===4)
									$s("itemProductTotal").innerHTML = "$" + itemTotalRequest.responseText;
							}
							
							taxesTotalRequest.onreadystatechange=function(){
								if(taxesTotalRequest.readyState===4)
									$s("itemTaxesTotal").innerHTML = "$" + taxesTotalRequest.responseText;
							}
							
							cartTotalRequest.onreadystatechange=function(){
								if(cartTotalRequest.readyState===4)
									$s("itemCartTotal").innerHTML = "$" + cartTotalRequest.responseText;
							}
							
							//update total for this item if available
							if($s("cqp-" + prodAjax.ajPS + "-" + productID)) {
								$s("cqp-" + prodAjax.ajPS + "-" + productID).innerHTML = "$" +
									
									//round up to the nearest 2 decimal places
									Math.round(
										(
											$("#hpp-" + prodAjax.ajPS + "-" + productID + " span").html()
											 *
											$s("pq_" + prodAjax.ajPS + "_" + productID).value
										)
										* 100
									)/100;
							}
							
							ajaxPost(
								itemTotalRequest,
								"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
								"function=getCartProductTotal",
								true,
								0,null,false
							);
							
							ajaxPost(
								taxesTotalRequest,
								"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
								"function=getCartTaxTotal",
								true,
								0,null,false
							);
							
							ajaxPost(
								cartTotalRequest,
								"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
								"function=getCartTotal",
								true,
								0,null,false
							);
						}
						
						//Effect.Queues.get('cartFade' + productID ).invoke('cancel');

						//loop through products and options to check for inventory
						//prodIndex0 is always the parent product, the rest are options
						for(var z in prodObj){
							//they tried to get this product/option
							if(prodObj[z]["cartQty"] > 0){
								//the qty field of the product we're updating
								if(z === "prodIndex0") {
									var prodQtyField = $s("pq_" + prodAjax.ajPS + "_" + productID);
								}
								//checkbox and radio button options
								else if($s("po_" + productID + "_" + prodObj[z]["priKeyID"])) {
									var prodQtyField = $s("po_" + productID + "_" + prodObj[z]["priKeyID"]);
								}
								//select-one
								else {
									var prodQtyField = $s("qtypo_" + productID + "_" + prodObj[z]["catOpID"]);
								}

								//handle inventory messaging
								var currentQty = prodQtyField.value;
								
								//default to 0 if the field is empty
								if(currentQty.length === 0) currentQty = 0;
								
								var newInventoryQty = parseInt(prodObj[z]["invtQty"]) - parseInt(prodAjax.qty) - parseInt(currentQty);
								
								//with neg inventory, and not allowed to sell neg inventory				
								if(newInventoryQty < 0 && prodObj[z]["allowNegInvt"] == 0){
									alert(prodObj[z]["productName"] + ":" + prodObj[z]["negInvtMsg"]);
									
									//clear out our qty fields
									for(var zz in prodObj){
										//the qty field of the product we're updating
										if(zz === "prodIndex0") {
											var prodQtyField = $s("pq_" + prodAjax.ajPS + "_" + productID);
										}
										//checkbox and radio button options
										else if($s("po_" + productID + "_" + prodObj[zz]["priKeyID"])) {
											var prodQtyField = $s("po_" + productID + "_" + prodObj[zz]["priKeyID"]);
										}
										//select-one
										else {
											var prodQtyField = $s("qtypo_" + productID + "_" + prodObj[zz]["catOpID"]);
										}

										prodQtyField.value = 0;
									}
									return false;
								}
								//neg inventory, but allowed to sell
								else if(
									newInventoryQty >= 0 ||
									(newInventoryQty < 0 && prodObj[z]["allowNegInvt"] == 1)
								){
									//check for display message
									if(
										prodObj[z]["negInvtMsg"].length &&
										(newInventoryQty < 0 && prodObj[z]["allowNegInvt"] == 1)
									) {
										alert(prodObj[z]["productName"] + ":" + prodObj[z]["negInvtMsg"]);
									}
								}
							}
							
							//removing from cart
							if(prodAjax.qty == 0 && prodAjax.sQty){
													
								//the qty field of the product we're updating
								if(z === "prodIndex0") {
									var prodQtyField = $s("pq_" + prodAjax.ajPS + "_" + productID);
								}
								//checkbox and radio button options
								else if($s("po_" + productID + "_" + prodObj[z]["priKeyID"])) {
									var prodQtyField = $s("po_" + productID + "_" + prodObj[z]["priKeyID"]);
								}
								//select-one
								else {
									var prodQtyField = $s("qtypo_" + productID + "_" + prodObj[z]["catOpID"]);
								}
								
								/*if its a hidden field, the quantity is
								determined by the options, so we leave the
								value at 1*/
								if(prodQtyField.type !== "hidden"){	
									prodQtyField.value = 0;
								}
								
								upc(<?php echo $priModObj[0]->viewCartPageID; ?>);
							}
							//change the qty field for the primary product
							if(!prodAjax.sQty && z === "prodIndex0"){
								var prodQtyField = $s("pq_" + prodAjax.ajPS + "_" + productID)
								prodQtyField.value = (prodQtyField.value * 1) + prodAjax.qty;
							}
							
							
						}
						
						var cartDsp = "ccd-" + prodAjax.ajPS + "-" + productID;
						
						//display added/removed from cart message
						$s(cartDsp).innerHTML = Math.abs(prodAjax.qty) + " " + prodObj["prodIndex0"]["productName"] + adjustTxt;
						
						$("#" + cartDsp).stop(true).fadeTo(500,1,"swing",
							function callback(obj){
								$("#" + cartDsp).stop(true).fadeTo(2000,0,"swing");	
							}
						);	
												
						//update our cart qty display
						if(isset($s("innertCartQty"))){
							var cartQty = ajaxObj();
						
							cartQty.onreadystatechange=function(){
								if(cartQty.readyState===4) $s("innertCartQty").innerHTML = cartQty.responseText;
							}
							
							ajaxPost(
								cartQty,
								"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
								"function=getCartItemQty",
								true,
								0,null,false
							);
							
							
						}	
						
						//update our subtotal display
						if(isset($s("innertCartSubTotal"))){
							var cartSub = ajaxObj();
						
							cartSub.onreadystatechange=function(){
								if(cartSub.readyState===4) $s("innertCartSubTotal").innerHTML = cartSub.responseText;
							}
							
							ajaxPost(
								cartSub,
								"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
								"function=getCartProductTotal",
								true,
								0,null,false
							);
						}
					}
				}
				catch(e){alert("stealth Cart Error:" + e);}
			}		
			
			//put our product options into a json object to pass to the server
			var prodOpsObj = {};
			var prodOps = $s(frmID).elements;
			var prodOpsLen = prodOps.length;
	
			for(var po = 0; po < prodOpsLen; po++){
				var prodOpsType = prodOps[po].type;
				
				//we don't want the star rating buttons
				if(prodOps[po].className.indexOf("star-rating") >= 0){
					var isOption = false;
				}
				else{
					var isOption = true;
				}
				
				if(isOption){
			
					//for radio's and checkboxes, if they are selected, 
					//get their values from the hidden form fields
					if(prodOpsType === "checkbox" || prodOpsType === "radio"){
						if(prodOps[po].checked) {
	
							//product option ID
							var poSelected = prodOps[po].value.split("_");
							
							var prodOpID = poSelected[0];
							var prodOpCatID = poSelected[1];
							
							//we need to pass the optionID along to the server
							if(prodOps[po].value.length && isNumeric(prodOps[po].value)){
								prodOpsObj[prodOps[po].value]  = $s("po_" + productID + "_" + prodOpID).value;
							}
						}
					}	
					else if(prodOpsType === "select-one"){
						//get prodOpID and prodOpCatID from select value
						var poSelected = prodOps[po][prodOps[po].selectedIndex];
						var poTmp = poSelected.value.split("_");
						var prodOpID = poTmp[0];
						var prodOpCatID = poTmp[1];
						
						//we need to pass the categoryID along to the server
						if(poSelected.value.length && isNumeric(poSelected.value)){
							prodOpsObj[poSelected.value] = $s("qtypo_" + productID + "_" + prodOpCatID).value;
						}
					}
					//not the main prodQty field
					else if(prodOpsType === "text" && prodOps[po].id.indexOf("pq") === -1){
						var prodOpID = prodOps[po].id.split("_")[2]; //product option ID
	
						/*
						this is a line of code of destruction. if this was in place it would
						send in qty values that don't matter and break everything to oblivion.
						if you ever need to use this, talk to jared or kirsten. use at your own risk.
						if(prodOps[po].value.length && isNumeric(prodOps[po].value)) {
							prodOpsObj[prodOpID] = prodOps[po].value;
						}*/
					}
				}
			}
			
			//pass empty option object otherwise cart isn't happy
			var prodObsJSON = encodeURIComponent(JSON.stringify(prodOpsObj));

			if(isNumeric(prodQty))
				ajaxPost(
					prodAjax,
					"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
					"function=adjustCartItemQty&productID=" + productID 
					+ "&qty=" + prodQty
					+ "&setQty=" + setQty
					+ "&prodOps=" + prodObsJSON,
					true,
					0,null,false
				);				
			else alert("Only positive numeric values are allowed as a quantity.");
			
			
		if (goToCart == true) {
			upc(<?php echo $priModObj[0]->viewCartPageID; ?>);
		}
		}
	}
}