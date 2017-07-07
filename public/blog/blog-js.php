function searchBlogs(){
	var searchTerm = fieldEscape(document.getElementById("blogSearchTerm").value);	
	var searchPageID = parseInt(document.getElementById("blogSearchPageID").value);
	upc(searchPageID,"blogSearchTerm=" + searchTerm);
}

