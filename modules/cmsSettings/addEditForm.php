<div>
	<label for='siteName'>Site Name</label>
	<input
		type="text" 
		name="siteName" 
		maxlength="255"
		id="siteName<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('siteName'); ?>"
		title="Site Name"
	/>
</div>

<div>
	<label for='adminEmail'>Admin Email(s) - (Use comma as separator)</label>
	<input
		type="text" 
		name="adminEmail" 
		maxlength="255"
		id="adminEmail<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('adminEmail'); ?>"
		title="Admin Emails"
	/>
</div>

<div>
	<label for='seoFolderName'>SEO Expression (Use dash instead of space)</label>
	<input
		type="text" 
		name="seoFolderName" 
		maxlength="255"
		id="seoFolderName<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('seoFolderName'); ?>"
		title="SEO Expression"
	/>
</div>

<div>
	<label for='googleAnalyticsCode'>Google Analytics Code</label>
	<input
		type="text" 
		name="googleAnalyticsCode" 
		maxlength="255"
		id="googleAnalyticsCode<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('googleAnalyticsCode'); ?>"
		title="Google Analytics Code"
	/>
</div>

<div>
	<label for='googleSiteVerification'>Google Site Verification</label>
	<input
		type="text" 
		name="googleSiteVerification" 
		maxlength="255"
		id="googleSiteVerification<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('googleSiteVerification'); ?>"
		title="Google Site Verification"
	/>
</div>

<div>
	<label for='googlePublisherLink'>Google Publisher Link</label>
	<input
		type="text" 
		name="googlePublisherLink" 
		maxlength="255"
		id="googlePublisherLink<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('googlePublisherLink'); ?>"
		title="Google Publisher Link"
	/>
</div>

<div>
	<label for='reCAPTCHASiteKey'>reCAPTCHA Site Key</label>
	<input
		type="text" 
		name="reCAPTCHASiteKey" 
		maxlength="255"
		id="reCAPTCHASiteKey<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('reCAPTCHASiteKey'); ?>"
		title="reCAPTCHA Site Key"
	/>
</div>

<div>
	<label for='reCAPTCHASecretKey'>reCAPTCHA Secret key</label>
	<input
		type="text" 
		name="reCAPTCHASecretKey" 
		maxlength="255"
		id="reCAPTCHASecretKey<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('reCAPTCHASecretKey'); ?>"
		title="reCAPTCHA Secret Key"
	/>
</div>

<div>
	<label for='youtubeUser'>Youtube User</label>
	<input
		type="text" 
		name="youtubeUser" 
		maxlength="255"
		id="youtubeUser<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('youtubeUser'); ?>"
		title="Youtube User"
	/>
</div>

<div>
	<label for='zohoAuth'>Zoho Auth</label>
	<input
		type="text" 
		name="zohoAuth" 
		maxlength="255"
		id="zohoAuth<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('zohoAuth'); ?>"
	/>
</div>

<div>
	<label for='zohoLeadOwner'>Zoho Lead Owner</label>
	<input
		type="text" 
		name="zohoLeadOwner" 
		maxlength="255"
		id="zohoLeadOwner<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('zohoLeadOwner'); ?>"
	/>
</div>
<div>
</div>
<div>
	<label for='metaWords'>Meta Words (Use comma as separator)</label>
	 <textarea
		id="metaWords<?php echo $_REQUEST["recordID"]; ?>" 
		name="metaWords" 
		rows="5" 
		columns="100"><?php echo $priModObj[0]->displayInfo('metaWords'); ?></textarea>
</div>

<div>
	<label for='metaDesc'>Meta Description</label>
	 <textarea
		id="metaDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="metaDesc" 
		rows="5" 
		columns="100"><?php echo $priModObj[0]->displayInfo('metaDesc'); ?></textarea>
</div>


