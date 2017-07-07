function subNewsLetter(){
	//form validation
	$("#newLetterForm").validate({ rules: { newsEmail: {required:true,email:true} } });

	if($("#newLetterForm").validate().form()){
		var letterAjax = ajaxObj();//ajax object
		var emailAddy = escape($s("newsEmail").value.replace(/\'/g,"\\'"));//escape email
		
		letterAjax.onreadystatechange=function(){
			if(letterAjax.readyState===4) alert("Your e-mail address has been submitted!");
		}
		
		//send ajax request
		ajaxPost(
			letterAjax,
			"/public/newsLetter/newsSend.php?emailAddress=" + emailAddy,
			"",null,null,null,false
		);
	}

}