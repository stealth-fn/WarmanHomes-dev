<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false);
	
?>
//This funtion simply passes the desired orderID to the funtion that will populate the cart.
function edit() {
	var orderID = $( "#orderToEdit" ).val();
	editOrder(orderID,<?php echo $productsObj->viewCartPageID; ?>);
}
function shippingValidation() {
	$("#shippingForm").validate({
		rules: {
			shippingFirstName:{
				required: true
			},
			shippingLastName:{
				required: true			
			},
			shippingNumber:{
				required: true
			},
			shippingName:{
				required: true
			},
			shippingCity:{
				required: true
			},
			shippingCountry:{
				required: true
			},
			shippingFirstName:{
				required: true
			},
			shippingProvState:{
				required: true
			},
			shippingPostalZip:{
				required: true
			},
		}
	});	
}

//if any address items change, remove all shipping options
function resetShipping(){
	if(isset($s("shippingInfoContainer"))){
		$("input:radio[name='methodCheckBox']").rules('add', {required: false });
		$("#shippingInfoContainer").remove();
	}
}

function getShippingOptions(){
	if($("#shippingForm").validate().form()){
		var shippingAjax = ajaxObj();
		
		shippingAjax.onreadystatechange=function(){
			if(shippingAjax.readyState===4){
				$s("viewCartShippingOptions").innerHTML = shippingAjax.responseText;
				
				//update taxes based on shipping info
				var taxAjax = ajaxObj();
				
				taxAjax.onreadystatechange=function(){
					if(taxAjax.readyState===4) $s("itemTaxesTotal").innerHTML = "$" + taxAjax.responseText;
				}
				
				ajaxPost(
					taxAjax,
					"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
					"function=getCartTaxTotal",
					true,
					0,null,false
				);
				
				//update validation with the shipping options if there were no errors
				if(isset($s("shippingOptions"))){
					<?php
						#update form validation
						echo $productsObj->generateFormValidation(
							"shippingOptions",
							"methodCheckBox=>required::true::"
						);		
					?>
				}

				$s("shippingOptionsWaiting").style.display = "none";
			}
		}
		
		//parse country info to send to server
		var selectedCountry = $s("shippingCountry").options[$s("shippingCountry").selectedIndex];
		var country = selectedCountry.text;
		var countryID = selectedCountry.id.substr(15,selectedCountry.id.length);
		var countryCode = selectedCountry.value;
		
		//get shipping options from server
		ajaxPost(
			shippingAjax,
			"/cmsAPI/ecommerce/shipping/shipping.php",
			"function=getShippingOptions" +
				"&firstName=" + $s("shippingFirstName").value + 
				"&lastName=" + $s("shippingLastName").value + 
				"&streetNum=" + $s("shippingNumber").value + 
				"&streetName=" + $s("shippingName").value +
				"&unitApt=" + $s("address2").value +
				"&city=" + $s("shippingCity").value + 
				"&provState=" + $s("shippingProvState").options[$s("shippingProvState").selectedIndex].text + 
				"&provStateID=" + $s("shippingProvState").options[$s("shippingProvState").selectedIndex].value +
				"&country=" + country + 
				"&countryID=" + countryID +
				"&countryCode=" + countryCode + 
				"&postalZip=" + $s("shippingPostalZip").value +
				"&primaryPhone=" + $s("shippingPhoneNumber").value,
			true,
			0,null,false
		);
		
		$s("shippingOptionsWaiting").style.display = "block";
	}
}

function updateCartTotalWithShipping(shipValue){

	var cartTotalRequest = ajaxObj();
	cartTotalRequest.sv = shipValue;
	
	cartTotalRequest.onreadystatechange=function(){
		//multiplying by 1 stops it from appending the numbers as strings
		if(cartTotalRequest.readyState===4){
			var tempSum = (cartTotalRequest.responseText * 1 + cartTotalRequest.sv * 1).toFixed(2);
			$s("itemCartTotal").innerHTML = "$" + tempSum;
			
			//update displayed shipping amount
			$s("itemShippingTotal").innerHTML = "$" + $('input:radio[name=methodCheckBox]:checked').val();
		}
	}
	
	ajaxPost(
		cartTotalRequest,
		"/cmsAPI/ecommerce/cmsCart/cmsCart.php",
		"function=getCartTotal",
		true,
		0,null,false
	);
}

function proceedToCheckout(){
	//make shipping information required
	if($("#shippingForm").validate().form()){
		if($s("shippingOptions") && $("#shippingOptions").validate().form()){
			var checkoutAjax = ajaxObj();
			
			//the only value we need to send to the server is the shipping amount,
			//everything else is calculated server side	
			var shipAmt = $('input:radio[name=methodCheckBox]:checked').val();
			
			//determine which radio button is checked and get the name of the 
			//shipping method based off of that
			var shipChoices = $(".methodCheckBox");
			var choiceAmt = shipChoices.length;
			
			for(var x = 0; choiceAmt > x;x++ )
				if(shipChoices[x].checked) var choiceName = $s("methodName" + parseInt(x+1)).innerHTML;
			<?php
			if(isset($_SESSION["editOrder"]["orderID"] )){
			?>
				atpto_tNav.toggleBlind('-4',0,'upc(-4,"shipAmt=' + shipAmt + '&shipName=' + choiceName + '");','ntid_tNav--4');
			<?php
			} else {
			?>			
				ajaxPost(
					checkoutAjax,
					"/cmsAPI/ecommerce/paypal/paypal.php",
					"function=expressCheckout&shipAmt=" + shipAmt + "&shipName=" + choiceName,
					false,
					0,null,false
				);
				window.open(checkoutAjax.responseText);
			<?php
			}								
			?>
		}
		else {
			if(!$s("shippingOptions")) {
				alert("You must calculate shipping costs before you can proceed.");
			}
		}
	}
}

//gets the value of the field once a user chooses it, so we can tell if anything change
//if anything changed we need to reset the shipping information
function getShipValue(thisField){
	if(thisField.type === "text") shipAddressValue = thisField.value;
	else if(thisField.type === "select-one" && thisField.selectedIndex >=0)
		shipAddressValue = thisField.options[thisField.selectedIndex].value;
}

function checkShipClear(thisField){
	if(thisField.type === "text" && shipAddressValue != thisField.value) resetShipping();
	else if(
		thisField.type === "select-one" &&
		thisField.selectedIndex >=0 && 
		shipAddressValue != thisField.options[thisField.selectedIndex].value
	)
		resetShipping();
}