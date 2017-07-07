function googleCustomSearch() {	
	try{
		$(".pageText").after("<gcse:search></gcse:search>");
		var cx = '013330965036270604992:p-45tk4utc0';
		var gcse = document.createElement('script'); 
		gcse.type = 'text/javascript'; 
		gcse.async = true;		
		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//www.google.com/cse/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
	}
	catch(e)
		{alert(e);};
 }