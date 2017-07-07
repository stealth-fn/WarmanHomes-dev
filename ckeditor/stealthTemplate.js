// Register a template definition set named "default".
CKEDITOR.addTemplates( 'default',
{
	// Template definitions.
	templates :
		[
			{
				title: 'Contact Form',
				description: 'Contact Form with Zoho Lead Generation Support.',
				html: 
					'<form action="return%20false">' + 
						'<fieldset>	' + 
							'<div class="mainContactField mainCompany">' + 
								'<label class="requiredLabel">Company</label>' + 
								'<input type="text" name="Company" value="" maxlength="75" title="Company">' + 
							'</div>' + 
							
							'<div id="mainFirstName" class="mainContactField mainFirstName">' + 
								'<label class="requiredLabel">First Name</label>' + 
								'<input type="text" required="required" name="First_Name" value="[pmpmID-11]" maxlength="75" title="First Name">' + 		
							'</div>' + 
							
							'<div id="mainLastName" class="mainContactField mainLastName">' + 
								'<label class="requiredLabel">Last Name</label>' + 
								'<input type="text" required="required" name="Last_Name" value="" maxlength="75" title="Last Name">' + 
							'</div>' + 
							
							'<div class="mainContactField mainDesignation">' + 
								'<label class="requiredLabel">Designation</label>' + 
								'<input type="text" name="Designation" value="" maxlength="75" title="Designation">' + 
							'</div>' + 
							
							'<div class="mainContactField mainEmail">' + 
								'<label class="requiredLabel">Email</label>' + 
								'<input type="email" data-rule-email="true" required="required" name="Email" value="" maxlength="75" title="Email">' + 
							'</div>' + 
							
							'<div class="mainContactField mainPhone">' + 
								'<label class="requiredLabel">Phone</label>' + 
								'<input type="tel" required="required" name="Phone" value="" maxlength="75" title="Phone">' + 
							'</div>' + 
							
							'<div class="mainContactField mainFax">' + 
								'<label class="requiredLabel">Fax</label>' + 
								'<input type="tel" name="Fax" value="" maxlength="75" title="Fax">' + 
							'</div>' + 
							
							'<div class="mainContactField mainMobile">' + 
								'<label class="requiredLabel">Mobile</label>' + 
								'<input type="tel" name="Mobile" value="" maxlength="75" title="Mobile">' + 
							'</div>' + 
							
							'<div class="mainContactField mainWebsite">' + 
								'<label class="requiredLabel">Website</label>' + 
								'<input type="text" name="Website" value="" maxlength="255" title="Website">' + 
							'</div>' + 
														
							'<div class="mainContactField mainLeadSource">' + 
								'<input type="hidden" name="Lead_Source" value="Website Form" title="Lead Source">' + 
							'</div>' + 
														
							'<div class="mainContactField mainIndustry">' + 
								'<label class="requiredLabel">Industry</label>' + 
								'<input type="text" name="Industry" value="" maxlength="255" title="Industry">' + 
							'</div>' + 
							
							'<div class="mainContactField mainNoOfEmp">' + 
								'<label class="requiredLabel">No of Employees</label>' + 
								'<input type="number" data-rule-number="true" name="No_of_Employees" value="" title="No of Employees">' + 
							'</div>' + 
							
							'<div class="mainContactField mainAnnualRevenue">' + 
								'<label class="requiredLabel">Annual Revenue</label>' + 
								'<input type="number" data-rule-number="true" name="Annual_Revenue" value="" title="Annual Revenue">' + 
							'</div>' + 
							
							'<div class="mainContactField mainEmailOptOut">' + 
								'<label class="requiredLabel">Email Opt Out</label>' + 
								'<span>Yes</span><input type="radio" required="required" name="Email_Opt_Out" value="Yes" title="Email Opt Out">' + 
								'<span>No</span><input type="radio" required="required" name="Email_Opt_Out" value="No" title="Email Opt Out">' + 
							'</div>' + 
							
							'<div class="mainContactField mainSkypeID">' + 
								'<label class="requiredLabel">Skype ID</label>' + 
								'<input type="text" name="Skype_ID" value="" maxlength="255" title="Skype ID">' + 
							'</div>' + 
							
							'<div class="mainContactField mainSalutation">' + 
								'<label class="requiredLabel">Salutation ID</label>' + 
								'<input type="text" name="Salutation" value="" maxlength="255" title="Salutation">' + 
							'</div>' + 
							
							'<div class="mainContactField mainStreet">' + 
								'<label class="requiredLabel">Street</label>' + 
								'<input type="text" name="Street" value="" maxlength="255" title="Street">' + 
							'</div>' + 
							
							'<div class="mainContactField mainCity">' + 
								'<label class="requiredLabel">City</label>' + 
								'<input type="text" name="City" value="" maxlength="255" title="City">' + 
							'</div>' + 
							
							'<div class="mainContactField mainState">' + 
								'<label class="requiredLabel">Province/State</label>' + 
								'<input type="text" name="State" value="" maxlength="255" title="State">' + 
							'</div>' + 
							
							'<div class="mainContactField mainZipCode">' + 
								'<label class="requiredLabel">Postal/Zip Code</label>' + 
								'<input type="text" name="Zip_Code" value="" maxlength="255" title="Zip Code">' + 
							'</div>' + 
							
							'<div class="mainContactField mainCountry">' + 
								'<label class="requiredLabel">Country</label>' + 
								'<input type="text" name="Country" value="" maxlength="255" title="Country">' + 
							'</div>' + 
									
							'<div>' + 
								'<label class="requiredLabel" id="contacatMsgLabel">Description</label>' + 
								'<textarea placeholder="What can we do for you?" name="Description" rows="5" cols="20"></textarea>' + 
							'</div>' + 
													
							'<input type="button" onclick="sendFormValues($(this.form));return false" id="contactmainSub" value="SUBMIT"/>' + 
						'</fieldset>' + 
					'</form>'	
			},
			{
				title: 'Full Size Link',
				description: 'An empty link that will fill up the entire container.',
				html: '<a href="" style="display:block ;position:absolute; width:100%; height:100%; background-image:url(/js/blank.gif);font-size:0px;"></a>'
			},
			{
				title: 'Display User Info - Div Shortcode',
				description: 'Displays information that the user submitted. Wraps text in spans for styling.',
				html: '<div id="pmpmID-10">DISPLAY USER INFO</div>'
			},
			{
				title: 'Display User Info - Plain Shortcode',
				description: 'Displays information that the user submitted. Plain Text. Can be used in forms.',
				html: '[pmpmID-11]'
			}
		]
});