$(":input").inputmask();
$("input[type=tel]").inputmask("(9{3}) 9{3}-9{4}");

if($('#reCAPTCHA').length){
	var recaptchaScript = document.createElement('script');
	recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js?onload=recaptchaLoad&render=explicit');
	//recaptchaScript.setAttribute('async','true');
	document.head.appendChild(recaptchaScript);

	var recaptchaLoad = function() {
	   grecaptcha.render('reCAPTCHA', {
		  'sitekey' : '<?php echo $_SESSION["reCAPTCHASiteKey"];?>'
		});
  	};
}

