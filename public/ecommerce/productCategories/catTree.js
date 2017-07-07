aTPCO = new accordionTree("catChildren");

/*gets all the vendor for a certain product category*/
function getVendGalByCatID(catID){
	var vendorModule = ajaxObj();
	
	try{
	vendorModule.onreadystatechange=function(){
		if(vendorModule.readyState==4){
			populateGallery(vendorModule.responseText,6,0);
		}
	}
	
	ajaxPost(vendorModule,"/cmsAPI/ecommerce/vendors/vendor.php","function=getVendGalByCatID&categoryID=" + catID);
	}
	catch(e){
		alert(e);
	}	
}

function vendorLink(clickDiv){		
	/*get the number of this div*/
	var divNum = clickDiv.id.substr(11,clickDiv.id.length-1);
	
	/*get the vendor image object*/
	var vendImg = document.getElementById("galleryImage" + divNum);
	
	/*using the src attribute as a string, get the galleryID*/
	var vendGalArray = vendImg.src.split("/");
	var vendGalleryID = vendGalArray[5];
	
	var vendURL = "http://" + getVendorURL(vendGalleryID);	
	/*we need to window.open from this function.... if its done in a second 
	function (like an ajax readyState), then safari blocks it*/
	window.open(vendURL);
}

function getVendorURL(vendGalleryID){	
	var vendorModule = ajaxObj();	
	/*has to be a synchronous or we can't return it from this function*/
	ajaxPost(
			 	vendorModule,
				"/cmsAPI/ecommerce/vendors/vendor.php",
				"function=getConditionalRecord&fp=galleryID&galID=" + vendGalleryID + "&negPos=true",
				false
			);	
	var ajaxVendFunction = new Function(vendorModule.responseText);
	var ajaxReturn = ajaxVendFunction();
	return ajaxReturn[0]["url"];	
}

function getCategoryProducts(categoryID,productInstanceID){
	
	var productCat = ajaxObj();
	var pagPage = ajaxObj();
	
	//update products in product list
	productCat.onreadystatechange=function(){
		if(productCat.readyState==4){
			document.getElementById("homeProductContainer").innerHTML = productCat.responseText;
		}
	}
	
	//update pagination pages
	pagPage.onreadystatechange=function(){
		if(pagPage.readyState==4){
			document.getElementById("homeProductsPagination").innerHTML = pagPage.responseText;
		}
	}
	
	ajaxPost(
			 productCat,
			 "/public/ecommerce/products/home-Page-Products.php",
			 "instanceID=" + productInstanceID + "&prodCatID=" + categoryID + "&pagPage=1",
			 true,
			 0
			 );
	
	ajaxPost(
			 pagPage,
			 "/public/ecommerce/products/homePageProdPagination.php",
			 "instanceID=" + productInstanceID + "&ajaxRefresh=1" + "&prodCatID=" + categoryID,
			 true,
			 0
		 );
}