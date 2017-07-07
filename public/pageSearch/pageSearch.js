function pageSearch(){
	if($("#searchForm").validate().form()) {
		upc($s("searchPageID").value,"searchTerm=" + fieldEscape($s("searchTerm").value));
	}
}