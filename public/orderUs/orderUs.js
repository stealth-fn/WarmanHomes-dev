//create jquery date picker
$("#dateOfBirth").datepicker(); 

$(":input").inputmask();

$("#contactDayPhone").inputmask({"mask": "(999) 999-9999"});
$("#contactEvePhone").inputmask({"mask": "(999) 999-9999"});

function orderValidate(){
	$("#orderForm").validate({
		rules: {
			contactName:{
				required: true
			},
			contactDayPhone:{
				phoneUS:true,
				required: true			
			},
			contactEvePhone:{
				phoneUS:true,
				required: true			
			},
			contactEmail:{
				email: true,
				required: true,
			},
			contactType:{
				required: true	
			},	
			dateOfBirth:{
				date: true,
				required: true	
			},
			preferredDate:{
				required: true	
			},
			lenseForWhichEye: {
				required: true
			},
			monthsSupply: {
				required: true
			}
		},
		messages: {
		}
	});	
}