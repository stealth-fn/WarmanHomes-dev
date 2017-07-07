<?php
$cmsSettings = $cmsSettingsObj->getRecordByID(1);
if(mysqli_num_rows($cmsSettings) > 0){
	$x = mysqli_fetch_assoc($cmsSettings);
}
?>


<div>
	<label for='formName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['formName']; ?>
	</label>
	<input
		type="text" 
		name="formName" 
		maxlength="255"
		id="sentTo<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('formName'); ?>"
	/>
</div>
<div>
	<label>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['defParm']; ?>
	</label>
	<input
		type="text" 
		maxlength="255"
		readonly="readonly"
		value="contactKeyID=<?php echo $priModObj[0]->displayInfo('priKeyID'); ?>"
	/>
</div>


<div>
	<label for='sentTo'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['sentTo']; ?>
	</label>
	<input
		type="text" 
		name="sentTo" 
		maxlength="255"
		id="sentTo<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('sentTo'); ?>"
		placeholder = "<?php echo $x["adminEmail"]?>"
	/>
</div>

<div>
	<label for='subject'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subject']; ?>
	</label>
	<input
		type="text" 
		name="subject" 
		maxlength="255"
		id="subject<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('subject'); ?>"
		placeholder = "<?php echo $x["siteName"] ?> Website Form"
	/>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='firstName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['fname']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="firstName"
				id="firstName<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('firstName')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="firstName"
				id="firstName<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('firstName')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='firstNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="firstNameReq"
				id="firstNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('firstNameReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="firstNameReq"
				id="firstNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('firstNameReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='lastNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['lname']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="lastName"
				id="lastName<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('lastName')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="lastName"
				id="lastName<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('lastName')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='lastNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="lastNameReq"
				id="lastNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('lastNameReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="lastNameReq"
				id="lastNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('lastNameReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='fullNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['fullName']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="fullName"
				id="fullName<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('fullName')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="fullName"
				id="fullName<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('fullName')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='fullNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="fullNameReq"
				id="fullNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('fullNameReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="fullNameReq"
				id="fullNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('fullNameReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='companyName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['compName']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="companyName"
				id="companyName<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('companyName')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="companyName"
				id="companyName<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('companyName')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='companyNameReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="companyNameReq"
				id="companyNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('companyNameReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="companyNameReq"
				id="companyNameReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('companyNameReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='phoneNumber'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['phone']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="phoneNumber"
				id="phoneNumber<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('phoneNumber')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="phoneNumber"
				id="phoneNumber<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('phoneNumber')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='phoneNumberReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="phoneNumberReq"
				id="phoneNumberReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('phoneNumberReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="phoneNumberReq"
				id="phoneNumberReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('phoneNumberReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='email'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['email']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="email"
				id="email<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('email')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="email"
				id="email<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('email')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='emailReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="emailReq"
				id="emailReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('emailReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="emailReq"
				id="emailReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('emailReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>

<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='howToContact'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['contactPref']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="howToContact"
				id="howToContact<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('howToContact')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="howToContact"
				id="howToContact<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('howToContact')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='howToContactReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="howToContactReq"
				id="howToContactReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('howToContactReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="howToContactReq"
				id="howToContactReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('howToContactReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='fileUpload'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['file']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="fileUpload"
				id="fileUpload<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('fileUpload')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="fileUpload"
				id="fileUpload<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('fileUpload')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='fileUploadReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="fileUploadReq"
				id="fileUploadReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('fileUploadReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="fileUploadReq"
				id="fileUploadReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('fileUploadReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='comments'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['comments']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="comments"
				id="comments<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('comments')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="comments"
				id="comments<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('comments')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
	<label for='commentsReq'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['required']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="commentsReq"
				id="commentsReq<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('commentsReq')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="commentsReq"
				id="commentsReq<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('commentsReq')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
</div>
</div>
<div>
<div class="borderWrapper">
<div class='radioGroupBlock'>
	<label for='comments'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['reCap']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="reCAPTCHA"
				id="reCAPTCHA<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('reCAPTCHA')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="reCAPTCHA"
				id="reCAPTCHA<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('reCAPTCHA')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
<div class='radioGroupBlock'>
<?php
	if (strlen($x["reCAPTCHASecretKey"]) > 0 && strlen($x["reCAPTCHASiteKey"]) > 0) {
		echo "<label>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['reCapReady'] . "</label>";
	}
	else {
		echo "<label>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['reCapNotReady'] . "</label>";
	}
	?>
	
</div>
</div>
</div>
<div>
		<label for='autoResponseBody'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['autoResponseSubject']; ?>
	</label>
	<input
		type="text" 
		name="autoResponseSubject" 
		maxlength="255"
		id="autoResponseSubject<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('autoResponseSubject'); ?>"
	/>
</div>

<div	
	<?php 
		if(isset($priModObj[0]->bulkMod)) {
			echo '
				class="bulkCKEditor ckEditContainer"
				id="bulkCKEditor' . $_REQUEST["recordID"] . '"
			'; 
		}
		else{
			echo 'class="ckEditContainer"';
		}
	?>
>
	<label for='autoResponseBody'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['autoResponseBody']; ?>
	</label>
	<textarea 
		name="autoResponseBody" 
		id="autoResponseBody<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('autoResponseBody'); ?>
	</textarea>
</div>
<div class='radioGroupBlock'>
	<label for='autoResponseBody'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['autoResponseActive']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
			<input
				type="radio"
				name="autoResponseActive"
				id="autoResponseActive<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('autoResponseActive')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
			<input
				type="radio"
				name="autoResponseActive"
				id="autoResponseActive<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('autoResponseActive')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
