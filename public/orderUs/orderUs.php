<div id="contactPageOutter">
	<div id="contactPageInner">
    <h1>Contact Us</h1>
    <h3>Order Contact Lenses</h3>
    <p>* required fields</p>
		<div id="contactFormContainer">
			<form name="orderForm" id="orderForm" action="return%20false">
				<fieldset>
	            	<input type="hidden" name="formName" value="Order Contact Lenses" />			
					<div class="field">
						<label class="requiredLabel" for="contactName">Full Name:*</label>
						<input type="text" value="" name="contactName" id="contactName"
						data-inputmask="'mask': '99-9999999'" onfocus="clearField($s('contactName'))" onblur="backToDefault($s('contactName'))" class="invalid"
						title = "my full name"/>
					</div>
                   <div class="field">
						<label class="requiredLabel" for="contactName">Full Name:*</label>
						<input type="text" value="" name="contactName" id="contactName"
						data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : true" onfocus="clearField($s('contactName'))" onblur="backToDefault($s('contactName'))" class="invalid"/>
					</div>
                    
                    <div class="field">
						<label class="requiredLabel" for="contactDayPhone">Daytime Phone:*</label>
						<input type="tel" value="" name="contactDayPhone" id="contactDayPhone" onfocus="clearField($s('contactDayPhone'))" onblur="backToDefault($s('contactDayPhone'))" class="invalid"/>
					</div>
                    
                    <div class="field">
						<label class="requiredLabel" for="contactEvePhone">Evening Phone:*</label>
						<input type="tel" value="" name="contactEvePhone" id="contactEvePhone" onfocus="clearField($s('contactEvePhone'))" onblur="backToDefault($s('contactEvePhone'))" class="invalid"/>
					</div>
                    
                    
                    <div class="field">
						<label class="requiredLabel" for="contactEmail">Email:*</label>
						<input type="email" value="" name="contactEmail" id="contactEmail" onfocus="clearField($s('contactEmail'))" onblur="backToDefault($s('contactEmail'))" class="invalid"/>
					</div>
                    
                    <div class="field typeFieldContainer">
							<label class="requiredLabel contactTypeLabel">How would you like to be contacted?*</label>
							<div id="contactByContainer">
								<div> 
									<input value="via Email" type="radio" name="contactType" class="Contact via"/>
                                    <span>Email</span>
								</div>
								<div> 
									<input value="via phone" type="radio" name="contactType" class="Contact via"/>
                                    <span>Phone</span>
								</div>
							</div>
					</div>
                    
                    <div class="field" id="dateOfBirthContainer">
                    	<label class="requiredLabel" for="dateOfBirth">Date of Birth (MM/DD/YYYY):*</label>
                        <input type="date" name="dateOfBirth" id="dateOfBirth" value="" onfocus="clearField($s('dateOfBirth'))" onblur="backToDefault($s('dateOfBirth'))" class="invalid" />
                    </div>
                    
                    <div class="field">
    <label for="cc">Credit Card</label>
    <!-- Set via HTML -->
    <input id="cc" type="text" data-inputmask="'mask': '9999 9999 9999 9999'" />
  </div>
                   
                   <div class="field">
    <label for="date">Date</label>
    <input id="date" data-inputmask="'alias': 'date'" />
  </div>
                    
                    
                    <div class="field">
    <label for="czc">Canadian Zip Code</label>
    <input id="czc" placeholder="XXX XXX" pattern="\w\d\w \d\w\d" class="masked" 
        data-charset="_X_ X_X" id="zipca" type="text" name="zipcodeca" 
        title="Zip Code" />
  </div>
                   <div class="field">
  <input type="file" accept=".pdf" aria-label="select file to upload">
  <button type="submit">Submit</button>
</div>
                   
                   
                    <div id="msgSubject" class="field">
						<label class="requiredLabel" >Have you had an appointment at our office within the last year?</label>
						<input type="text" value="" name="hadAnAppointmentBefore" id="contactMessageSubject" onfocus="clearField($s('contactMessageSubject'))" onblur="backToDefault($s('contactMessageSubject'))" class="invalid"/>
					</div>
                    
                    <div class="field" id="patientFieldContainer">
							<label class="requiredLabel contactTypeLabel">Which eye do you need lenses for?*</label>
							<div id="patientTypeContainer">
								<div> 
									<input value="Left" type="checkbox" name="lenseForWhichEye" class="Which eye do you need lenses for"/>
                                    <span>Left</span>
								</div>
								<div> 
									<input value="Right" type="checkbox" name="lenseForWhichEye" class="Which eye do you need lenses for"/>
                                    <span>Right</span>
								</div>
							</div>
					</div>
                    
                    <div class="field" id="monthsSupplyContainer">
							<label class="requiredLabel contactTypeLabel">How many months' supply?*</label>
							<div class="monthsSupplyContainer">
								<div> 
									<input value="6 months" type="radio" name="monthsSupply" class="How many months supply" onclick="$s('otherMonthsSupply').disabled=true"/>
                                    <span>Six Months</span>
								</div>
								<div> 
									<input value="1 Year" type="radio" name="monthsSupply" class="How many months supply" onclick="$s('otherMonthsSupply').disabled=true"/>
                                    <span>One Year</span>
								</div>
                                <div> 
									<input value="other" type="radio" name="monthsSupply" class="How many months supply" onclick="$s('otherMonthsSupply').disabled=false" />Other
                                    
                                    <input type="text" name="otherMonthsSupply" id="otherMonthsSupply" size="1" disabled="disabled"/>
								</div>
							</div>
					</div>
                			
					
					<div class="field" id="msgContainer">
						<label class="requiredLabel" for="contactMessage">Any other information for us?</label>
						<textarea 
							rows="1" cols="1" name="contactMessage" 
							id="contactMessage"
							onblur="backToDefault($s('contactMessage'))" onfocus="clearField($s('contactMessage'))" 
						></textarea>
					</div>			
					
						<input
							type="button" 
							value="Submit" 
							name="formSub" 
							id="formSub"
							onclick="sendFormValues($('#orderForm'))"
						/>
				</fieldset>
			</form>
		</div>
	</div>
</div>
