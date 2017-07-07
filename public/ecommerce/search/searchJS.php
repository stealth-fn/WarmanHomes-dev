if(!('ecomSearch' in window)) {
	ecomSearch = function(){};
	
	ecomSearch.prototype.eSearch = function(formObj){
		if($("#" + formObj.id).validate().form()){
			upc(
				this.resultPage,
				"searchTerm=" + fieldEscape($("#" + formObj.id + " input[name='eSearchTerm']").val())
			);
		}
	}
}

eSearch_<?php echo $priModObj[0]->className; ?> = new ecomSearch();
eSearch_<?php echo $priModObj[0]->className; ?>.resultPage = <?php echo $priModObj[0]->resultPage; ?>;
