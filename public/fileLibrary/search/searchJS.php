if(!('ps' in window)) {
	ps = function(){};
	
	ps.prototype.lessonSearch = function(formObj){	
	
		if($("#lessonSearch").validate()){
			var searchParams = {};
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>] = {};
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"] = {};
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].Keyword = document.getElementById("Keyword").value;
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].Subject = document.getElementById("Subject").value;
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].Grade = document.getElementById("Grade").value;
			
			searchParams[<?php echo $priModObj[0]->ListPmpmID ?>]["searchParams"].Age = document.getElementById("Age").value;
			
			}			
			
			var requestParams = 'pmpm=' + encodeURIComponent(JSON.stringify(searchParams));
			
			upc(this.resultPage, requestParams, true, "historyBreak");
		}
	}



lessonSearch_<?php echo $priModObj[0]->className; ?> = new ps();
lessonSearch_<?php echo $priModObj[0]->className; ?>.resultPage = <?php echo $priModObj[0]->resultPage; ?>;