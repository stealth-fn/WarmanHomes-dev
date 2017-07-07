if(!('ps' in window)) {
	ps = function(){};
	
	ps.prototype.propertySearch = function(formObj){	
	
		if($("#propertySearch").validate()){
			var searchParams = {};
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>] = {};
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"] = {};
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].Keyword = document.getElementById("Keyword").value;
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].City = document.getElementById("city").value;
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].propertyType = document.getElementById("propertyType").value;
			
			if (document.getElementById("minPrice").value) {
				searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].minPrice = document.getElementById("minPrice").value;
			}
			else {
				searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].minPrice = 0;
			}
			
			if(document.getElementById("maxPrice").value) {
				searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].maxPrice = document.getElementById("maxPrice").value;
			}
			else {
				searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].maxPrice = 3000;
			}			
			
			var allVals = [];
			$('#bedroom :checked').each(function() {
				allVals.push($(this).val());
			});
			
			if (allVals.length == 0) {
				allVals = ["1","2","3","4"];
			}
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].bedroom = allVals;
			
			var requestParams = 'pmpm=' + encodeURIComponent(JSON.stringify(searchParams));
			
			upc(this.resultPage, requestParams, true, "historyBreak");
		}
	}
}

$(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 3000,
      values: [ 0, 3000 ],
	  step: 50,
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$( "#minPrice" ).val(ui.values[ 0 ]);
		$( "#maxPrice" ).val(ui.values[ 1 ]);
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
});

propertySearch_<?php echo $priModObj[0]->className; ?> = new ps();
propertySearch_<?php echo $priModObj[0]->className; ?>.resultPage = <?php echo $priModObj[0]->resultPage; ?>;