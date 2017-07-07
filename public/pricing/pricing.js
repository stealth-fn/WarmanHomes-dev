
function pricingQforms(){
	moduleFormObj = new qForm("moduleForm");
	moduleFormObj.required("priceContactName,priceEmail,pricePhone");
	
	moduleFormObj.priceContactName.description = "Contact Name";
	moduleFormObj.priceEmail.description = "Email";
	moduleFormObj.priceCompany.description = "Company or Organization";
	moduleFormObj.priceAddress.description = "Address";
	moduleFormObj.priceEmail.description = "Email";
	moduleFormObj.pricePhone.description = "Phone Number";
	moduleFormObj.priceHear.description = "How Did you Year About Us?";
	moduleFormObj.serviceType.description = "Service Types";
	moduleFormObj.otherService.description = "Other Brief Description";
	moduleFormObj.projectDesc.description = "Project Brief Description";
	
	moduleFormObj.pricePhone.validatePhoneNumber();
	moduleFormObj.priceEmail.validateEmail();
}