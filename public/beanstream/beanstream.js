$(document).ready(function() {
   $("#order_number").tooltip({ content: '<img src="/images/policyHelp.jpg" width="100%"/> ' }); 
   $("#name").tooltip({ content: '<img src="/images/ClientHelp.jpg" width="100%"/> ' }); 

});

$(":input").inputmask();

$("input[type=tel]").inputmask({"mask": "(999) 999-9999"});
$("#ccNumber").inputmask({"mask": "9999-9999-9999-9999"});

function beanstreamValidate(){
	
	$("#beanstreamForm").validate({
		rules: {
			name:{
				required: true
			},
			order_number:{
				required: true,
				orderNumber: true
			},
			amount:{
				required: true,
				digits: true
			},
			email:{
				required: true,
				email: true
			},
			emailValid:{
				required: true,
				email: true,
				equalTo: '#email'
			},
			phoneNumber:{
				required: true,
				intlphone: true
			},
			ccName:{
				required: true,
			},
			ccNumber:{
				required: true,
				creditcard: true
			},
			ccMonth:{
				required: true,
			},
			ccYear:{
				required: true,
			},
			ccCvv:{
				required: true,
			},
		}
	});	
}

$.validator.addMethod('orderNumber', function (value) { 
    return /[a-zA-Z]{5,10}?\d{1,5}?[a-zA-Z]{2}/.test(value); 
}, "Please enter a valid policy number");
  
 function printDiv(paramString) {
	
	var paramArray = paramString.split("&");
	
	for( var i = 0; i <= paramArray.length - 1; i++){
		var paramArr = paramArray[i].split("=");
		console.log(paramArr);
		
		if (paramArr[0] == 'order_number') {
			var order_number = paramArr[1];
		}
		if (paramArr[0] == 'amount') {
			var amount = paramArr[1];
		}
		if (paramArr[0] == 'name') {
			var name = paramArr[1];
		}
		if (paramArr[0] == 'email') {
			var email = paramArr[1];
		}
		if (paramArr[0] == 'phoneNumber') {
			var phoneNumber = paramArr[1];
		}
		if (paramArr[0] == 'ccName') {
			var ccName = paramArr[1];
		}
		if (paramArr[0] == 'ccNumber') {
			var ccNumber = paramArr[1].substr(paramArr[1].length - 4); 
		}
	
	}
	
	printContents ='<div style="font-family: sans-serif; padding: 30px; font-size: 18px;">';
	printContents +='<h1>Saskatchewan Mutual Insurance Company</h1>';
	printContents +='<p> 279 3rd Avenue North <br>' +
		'Saskatoon, Saskatchewan <br> '+
		'S7K 2H8 <br> ' +
		'Email: <a href="mailto:accounting@saskmutual.com">accounting@saskmutual.com</a> <br>' +
		'Phone: <a href="tel:18006673067">1-800-667-3067</a> <br>' +
		'Website: <a href="http://www.saskmutual.com/" target="_blank">www.saskmutual.com</a> </p>';
	
	printContents += '<p style="font-weight: bold;">Your payment of $' + amount + ' has been processed for policy #' + order_number + '.</p>';
	
	var transaction_id = '10000102';
	
	printContents +='<p>' +
	'Transaction Number: ' + transaction_id + '<br/>' +
	'Cardholder: ' + ccName + '<br/>' +
	'Credit Card #******'+ ccNumber +'</p>';
	
	printContents += '<p>If you have any questions, please contact your broker.</p>';
	
	printContents += '</div>';
	
	var w = window.open();
	w.document.write(printContents);
	w.window.print();
	w.close();
	
}