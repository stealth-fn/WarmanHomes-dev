//ckEditor object
propertiesAddEditObj.prototype.ckEditorFieldName = "propertyDesc,amenities,leasing";

propertiesAddEditObj.prototype.updateCoordinate = function(frmBtn){
	
	var thisForm = frmBtn.form;
	
	var tempAddress = $(thisForm).find("input[name='completeAddress']").val();
	
	if (tempAddress == "") {
		$(thisForm).find("input[name='latitude']").val("0");
		$(thisForm).find("input[name='longitude']").val("0");
	}
	else {
		$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+tempAddress+'&sensor=false', null, function (data) {
			var p = data.results[0].geometry.location;
			
			$(thisForm).find("input[name='latitude']").val(p.lat);
			$(thisForm).find("input[name='longitude']").val(p.lng);
		});
	}
};