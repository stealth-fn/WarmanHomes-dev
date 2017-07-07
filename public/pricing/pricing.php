	<div id="priceContain">
		<form id="moduleForm" name="moduleForm" method="post" action="">
		<div id="formContain">
		
			<div id="textFieldHeader" class="moduleHeader">
				<p>1. Contact Information</p>
			</div>
			<div id="textFieldContain">
				<p>Contact Name</p>
				<input type="text" id="priceContactName" name="priceContactName" />
				
				<p>Company or Organization</p>
				<input type="text" id="priceCompany" name="priceCompany" />
				
				<p>Address</p>
				<input type="text" id="priceAddress" name="priceAddress" />
				
				<p>Email</p>
				<input type="text" id="priceEmail" name="priceEmail" />
				
				<p>Phone</p>
				<input type="text" id="pricePhone" name="pricePhone" />
				
				<p class="paddedP">How Did You Hear About Us?</p>
				<select id="priceHear" name="priceHear">
					<option value=" ">Pick One...</option>
					<option value="Advertisement">Advertisement</option>
					<option value="Article-Print">Article-Print</option>
					<option value="Article-Web">Article-Web</option>
					<option value="Company Website">Company Website</option>
					<option value="Facebook">Facebook</option>
					<option value="Friend / Colleague">Friend / Colleague</option>
					<option value="Linked-In">Linked-In</option>
					<option value="Referral">Referral</option>
					<option value="Search Engine">Search Engine</option>
					<option value="Twitter">Twitter</option>
					<option value="Other">Other</option>
				</select>
				
			</div>
			
			<div id="checkboxHeader" class="moduleHeaderMedium">
				<p>2. What Services Would you Like?</p>
			</div>
				
			<div id="serviceCheckContain">	
				<input type="checkbox" name="serviceType" id="serviceWebDev" value="Web Development"/> Web Development<br />
				<input type="checkbox" name="serviceType" id="serviceLogoDev" value="Logo Development"/> Logo Development<br />
				<input type="checkbox" name="serviceType" id="serviceSocialMedia" value="Social Media Strategies"/> Social Media Strategies<br />
				<input type="checkbox" name="serviceType" id="serviceSelfEdit" value="Self Editing Capabilities (Content Management System (CMS))"/> Self Editing Capabilities (Content Management System (CMS))<br />
				<input type="checkbox" name="serviceType" id="serviceNewsletter" value="Newsletter (RSS, News Services, etc.)"/> Newsletter (RSS, News Services, etc.)<br />
				<input type="checkbox" name="serviceType" id="serviceBlog" value="Blog"/>Blog<br />
				<input type="checkbox" name="serviceType" id="serviceFlashAnimation" value="Flash Animation"/>Flash Animation<br />
				<input type="checkbox" name="serviceType" id="serviceWebStrat" value="Web Strategy Consultation"/>Web Strategy Consultation<br />
				<input type="checkbox" name="serviceType" id="serviceEcom" value="e-commerce solutions"/>e-commerce solutions<br />
				<input type="checkbox" name="serviceType" id="serviceSEO" value="Search Engine Optimization (SEO)"/>Search Engine Optimization (SEO)<br />
				<input type="checkbox" name="serviceType" id="serviceHosting" value="Hosting"/>Hosting<br />
				<input type="checkbox" name="serviceType" id="serviceOther" value="Other"/>Other<br /><br />
				<textarea name="otherService" id="otherService" onclick="clearInput(this)" rows="10" cols="5">Brief Description</textarea>
			</div>
			
			<div id="projectHeader" class="moduleHeader">
				<p>3. Project Description</p>
			</div>
			
			<div id="detailsContain">
				Tell Us About Your Project, We Would Love To Hear It!
				<textarea name="projectDesc" id="projectDesc" onclick="clearInput(this)" rows="10" cols="5">Brief Description</textarea>
			</div>
			
			<div id="priceSubBtn" class="sb" onclick="sendFormValues(document.getElementById('moduleForm'),moduleFormObj)">
				<p>Send</p>
			</div>
							
		</div>
		
		<div id="priceText" class="mainPadding">
			<h1>Your Search Is Over</h1>
			<p>Call today for all your web design, logo design, social media and branding needs. Together we can make greath
			 things happen!</p>
			<p class="pContact">(306) 978-9018</p>
			<p class="pContact"><a href="mailto:info@stealthwd.ca">info@stealthwd.ca</a></p>
		</div>
		</form>
	</div>