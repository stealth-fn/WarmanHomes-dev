//ckEditor object
productAddEditObj.prototype.ckEditorFieldName = "productCopy";

		
productAddEditObj.prototype.addProdFeatureField = function(){

	$("#productFeatureContainer" + this.priKeyID).append(
		'<div class="featureContainer">\
			<div>\
				<label for="featureLabel">\
				Feature Label</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureLabel"\
					name="featureLabel"\
				/>\
			</div>\
			<div>\
				<label for="featureText">\
				Feature Text</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureText"\
					name="featureText"\
				/>\
			</div>\
			<div>\
				<label for="featureOrdinal">\
				Priority</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureOrdinal"\
					name="featureOrdinal"\
				/>\
			</div>\
			<input\
				type="button"\
				onclick="window[\'<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>\'].removeProdFeature(this)"\
				value=""\
				id=""\
				class="modSubElRem"\
				name=""\
			/>\
		</div>'
	);
}

productAddEditObj.prototype.addProdFeatureField2 = function(){

	$("#productFeatureContainer" + this.priKeyID + "2").append(
		'<div class="featureContainer">\
			<div>\
				<label for="featureLabel2">\
				Restaurant Name</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureLabel2"\
					name="featureLabel2"\
				/>\
			</div>\
			<div>\
				<label for="featureText2">\
				Restaurant Link</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureText2"\
					name="featureText2"\
				/>\
			</div>\
			<div>\
				<label for="featureOrdinal2">\
				Priority</label>\
				<input\
					type="text"\
					value=""\
					id=""\
					class="featureOrdinal2"\
					name="featureOrdinal2"\
				/>\
			</div>\
			<input\
				type="button"\
				onclick="window[\'<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>\'].removeProdFeature(this)"\
				value=""\
				id=""\
				class="modSubElRem"\
				name=""\
			/>\
		</div>'
	);
}

productAddEditObj.prototype.nextFunction = function(){
	var fLabels = $$s("featureLabel");
	var fText = $$s("featureText");
	var fOrd = $$s("featureOrdinal");
	var productID = this.priKeyID;
	var featureAjax = ajaxObj();
	
	//remove featues, re-add all of them. easier this way
	ajaxPost(
		featureAjax,
		"/cmsAPI/ecommerce/products/productFeatures/productFeatures.php",
		"function=removeRecordsByCondition&field=productID&priKeyID=" + productID,
		false,
		1,null,false
	);
	
	//loop through our features and add them
	if(fLabels.length > 0){
		var featureLen = fLabels.length-1;
		var modData = {};
		modData.function = "addRecord";
		
		for(var i = featureLen; i >= 0; i--){
			modData.featureLabel = fLabels[i].value;
			modData.featureText = fText[i].value;
			modData.featureOrdinal = fOrd[i].value;
			modData.productID = productID;
			
			var modJson = "modData=" + encodeURIComponent(JSON.stringify(modData));
			ajaxPost(
				featureAjax,
				"/cmsAPI/ecommerce/products/productFeatures/productFeatures.php",
				modJson,
				false,
				1,
				"application/x-www-form-urlencoded",false
			);
		}
	}
	
	//second set of features
	fLabels = $$s("featureLabel2");
	fText = $$s("featureText2");
	fOrd = $$s("featureOrdinal2");
	
	//remove featues, re-add all of them. easier this way
	ajaxPost(
		featureAjax,
		"/cmsAPI/ecommerce/products/productFeatures/productFeatures2.php",
		"function=removeRecordsByCondition&field=productID&priKeyID=" + productID,
		false,
		1,null,false
	);
	
	//loop through our features and add them
	if(fLabels.length > 0){
		var featureLen = fLabels.length-1;
		var modData = {};
		modData.function = "addRecord";
		
		for(var i = featureLen; i >= 0; i--){
			modData.featureLabel = fLabels[i].value;
			modData.featureText = fText[i].value;
			modData.featureOrdinal = fOrd[i].value;
			modData.productID = productID;
			
			var modJson = "modData=" + encodeURIComponent(JSON.stringify(modData));
			ajaxPost(
				featureAjax,
				"/cmsAPI/ecommerce/products/productFeatures/productFeatures2.php",
				modJson,
				false,
				1,
				"application/x-www-form-urlencoded",false
			);
		}
	}
}

productAddEditObj.prototype.removeProdFeature = function(closeBtn){
		//remove DOM
		$(closeBtn).parent().remove();
}

function addEditPayPalProduct(addEdit){
	var payPalHttp = ajaxObj();
	var fields = getRequestFields("",requestFields);
	ajaxPost(payPalHttp,"/cmsAPI/ecommerce/paypal/paypal.php","function=addEditPayPalProduct&" + fields);
}