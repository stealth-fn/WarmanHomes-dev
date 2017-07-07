<?php
if(array_key_exists("ln",$priModObj[0]->domFields)){
	ob_start();
?>
	<div>
		<label for="lastName">
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['lastName']; ?>
		</label>

		 <input 
				type="text" 
				id="lastName<?php echo $_REQUEST["recordID"]; ?>" 
				name="lastName" 
				size="45" 
				maxlength="50" 
				value="<?php echo $priModObj[0]->displayInfo("lastName"); ?>"
			/>
	</div>
<?php
	$priModObj[0]->domFields["ln"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
if(array_key_exists("fn",$priModObj[0]->domFields)){
	ob_start();
?>		
<div>
	<label for='firstName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['firstName']; ?>
	</label>

	<input 
		type="text" 
		id="firstName<?php echo $_REQUEST["recordID"]; ?>" 
		name="firstName" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('firstName'); ?>"
	/>
</div>

<?php
	$priModObj[0]->domFields["fn"] =  ob_get_contents();
	ob_end_clean();

}
?>

<?php
if(array_key_exists("em",$priModObj[0]->domFields)){
	ob_start();
?>			

<div>
	<label for='email'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['email']; ?>
	</label>
	<input 
		type="email" 
		id="email<?php echo $_REQUEST["recordID"]; ?>" 
		name="email" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('email'); ?>"
	/>

	<input 
		type="hidden" 
		id="emailCompare<?php echo $_REQUEST["recordID"]; ?>" 
		name="emailCompare" 
		value="<?php echo $priModObj[0]->displayInfo('email'); ?>"
	/>
</div>

<?php
	$priModObj[0]->domFields["em"] =  ob_get_contents();
	ob_end_clean();
}
?>	

<?php
if(array_key_exists("lgn",$priModObj[0]->domFields)){
	ob_start();
?>			
<div>
	<label for='loginName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['loginName']; ?>
	</label>

	<input 
		type="text" 
		id="loginName<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginName" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('loginName');  ?>"
	/>

	<input 
		type="hidden" 
		id="loginNameCompare<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginNameCompare" 
		value="<?php echo $priModObj[0]->displayInfo('loginName'); ?>"
	/>
</div>

<?php
	$priModObj[0]->domFields["lgn"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
if(array_key_exists("pw",$priModObj[0]->domFields)){
	ob_start();
?>			
<div>
	<label for='loginPassword'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['loginPassword']; ?>
	</label>

	<input 
		type="<?php echo ($GLOBALS['isPublic']) ? "password" : "text"; ?>"
		id="loginPassword<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginPassword" 
		size="45" 
		maxlength="64"
		value=""
	/>
</div>

<?php
	$priModObj[0]->domFields["pw"] =  ob_get_contents();
	ob_end_clean();
}

?>

<?php
if(array_key_exists("guest",$priModObj[0]->domFields)){
	ob_start();
?>	
	<input 
		type="hidden" 
		id="loginName<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginName" 
		size="45" 
		maxlength="50" 
		value="<?php echo uniqid();?>"
	/>
	<input 
		type="hidden" 
		id="loginNameCompare<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginNameCompare" 
		value=""
	/>
	<?php $pass = uniqid();?>
	<input 
		type="hidden" 
		id="loginPassword<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginPassword" 
		size="45" 
		maxlength="64"
		value="<?php echo $pass;?>"
	/>
	<input
		type="hidden" 
		id="loginPasswordVeri<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginPasswordVeri" 
		size="45" 
		maxlength="64" 
		value="<?php echo $pass;?>"
	/>
<?php
	$priModObj[0]->domFields["guest"] =  ob_get_contents();
	ob_end_clean();
}

?>

<?php

if(array_key_exists("vp",$priModObj[0]->domFields)){
	ob_start();
?>				

<div>
	<label for='loginPasswordVeri'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['loginPasswordVeri']; ?>
	</label>

	<input
		type="password" 
		id="loginPasswordVeri<?php echo $_REQUEST["recordID"]; ?>" 
		name="loginPasswordVeri" 
		size="45" 
		maxlength="64" 
		value=""
	/>
</div>

<?php
	$priModObj[0]->domFields["vp"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
if(array_key_exists("hp",$priModObj[0]->domFields)){
	ob_start();
?>							

<div>
	<label for='homePhone'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['homePhone']; ?>
	</label>
	
	<input
		type="text" 
		id="homePhone<?php echo $_REQUEST["recordID"]; ?>" 
		name="homePhone" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('homePhone'); ?>"
	/>
</div>

<?php
	$priModObj[0]->domFields["hp"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
if(array_key_exists("cp",$priModObj[0]->domFields)){
	ob_start();
?>		

<div>
	<label for='cellPhone'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['cellPhone']; ?>
	</label>

	<input 
		type="text" 
		id="cellPhone<?php echo $_REQUEST["recordID"]; ?>" 
		name="cellPhone" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('cellPhone'); ?>"
	/>
</div>

<?php
	$priModObj[0]->domFields["cp"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
if(array_key_exists("wp",$priModObj[0]->domFields)){
	ob_start();
?>			

<div>
	<label for='workPhone'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['workPhone']; ?>
	</label>

	 <input
		type="text" 
		id="workPhone<?php echo $_REQUEST["recordID"]; ?>" 
		name="workPhone" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('workPhone'); ?>"
	/>

</div>

<?php
	$priModObj[0]->domFields["wp"] =  ob_get_contents();
	ob_end_clean();
}
?>



<?php
if(array_key_exists("fx",$priModObj[0]->domFields)){
	ob_start();
?>	

<div>
	<label for='fax'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['fax']; ?>
	</label>
	 <input 
		type="text" 
		id="fax<?php echo $_REQUEST["recordID"]; ?>" 
		name="fax" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('fax'); ?>"
	/>

</div>

<?php

	$priModObj[0]->domFields["fx"] =  ob_get_contents();

	ob_end_clean();

}

?>

<?php

if(array_key_exists("ad",$priModObj[0]->domFields)){

	ob_start();

?>			

<div>

	<label for='address'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['address']; ?>
	</label>

	 <input 

		type="text" 
		id="address<?php echo $_REQUEST["recordID"]; ?>" 
		name="address" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('address'); ?>"

	/>
</div>

<?php
	$priModObj[0]->domFields["ad"] =  ob_get_contents();
	ob_end_clean();
}

?>



<?php

if(array_key_exists("ct",$priModObj[0]->domFields)){
	ob_start();
?>					

<div>
	<label for='city'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['city']; ?>
	</label>
	 <input 
		type="text" 
		id="city<?php echo $_REQUEST["recordID"]; ?>" 
		name="city" 
		size="45" 
		maxlength="50" 
		value="<?php echo $priModObj[0]->displayInfo('city'); ?>"
	/>

</div>

<?php
	$priModObj[0]->domFields["ct"] =  ob_get_contents();
	ob_end_clean();
}

?>

	

<?php

if(array_key_exists("cty",$priModObj[0]->domFields)){
	ob_start();

?>			

<div>
	<label for='country'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['country']; ?>
	</label>
	<div class="moduleFormStyledSelect">
		<select 
			id="country<?php echo $_REQUEST["recordID"]; ?>" 
			name="country"
			onchange="getProvStates('provState<?php echo $_REQUEST["recordID"]; ?>','country<?php echo $_REQUEST["recordID"]; ?>')" 
		>
			<option value="">Select a Country</option>
			<?php
				#we use country codes instead of the pricey ID so that we can pass it to paypal
				while($x = mysqli_fetch_assoc($countries)){
			?>
				<option 
					id="countryID<?php echo $x["priKeyID"]; ?>" 
					value="<?php echo $x["priKeyID"]; ?>"
					<?php
						if($priModObj[0]->displayInfo('country') == $x["priKeyID"])
							echo 'selected="selected"';
					?>
				>
					<?php echo $x["country"]; ?>
				</option>
			<?php
				}
			?>
		</select>
	</div>
</div>

<?php

	$priModObj[0]->domFields["cty"] =  ob_get_contents();
	ob_end_clean();

}

?>



<?php

if(array_key_exists("prv",$priModObj[0]->domFields)){
	ob_start();

?>			

<div>

	<label for='provState'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['provState']; ?>
	</label>
	<div class="moduleFormStyledSelect">
		<select id="provState<?php echo $_REQUEST["recordID"]; ?>"  name="provState">
			<option value="" >First Choose A Country</option>
			<?php
				if(strlen($priModObj[0]->displayInfo('country')) > 0){
					$provStates = $provStateObj->getConditionalRecord(
						array("countryID", $priModObj[0]->displayInfo('country'),true)
					);
					while($x = mysqli_fetch_assoc($provStates)){
			?>
					<option 
						value="<?php echo $x["priKeyID"]; ?>"
						id="provState<?php echo $x["priKeyID"]; ?>"
						<?php
							if($priModObj[0]->displayInfo('provState') == $x["priKeyID"])
								echo 'selected="selected"';
						?>
					>
						<?php echo $x["provState"]; ?>
					</option>
		<?php
				}
			}
		?>
		</select>
	</div>
</div>

<?php
	$priModObj[0]->domFields["prv"] =  ob_get_contents();
	ob_end_clean();
}

?>



<?php

if(array_key_exists("pz",$priModObj[0]->domFields)){
	ob_start();
?>						

<div>
	<label for='postalZip'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['postalZip']; ?>
	</label>
	 <input 
		type="text" 
		id="postalZip<?php echo $_REQUEST["recordID"]; ?>" 
		name="postalZip" 
		size="45" 
		maxlength="15" 
		value="<?php echo $priModObj[0]->displayInfo('postalZip'); ?>"
	/>
</div>

<?php

	$priModObj[0]->domFields["pz"] =  ob_get_contents();
	ob_end_clean();

}

?>



<?php

if(array_key_exists("cpy",$priModObj[0]->domFields)){

	ob_start();

?>	

<div>
	<label for='company'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['company']; ?>
	</label>
	 <input
		type="text" 
		id="company<?php echo $_REQUEST["recordID"]; ?>" 
		name="company" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('company'); ?>"
	/>

</div>	

<?php

	$priModObj[0]->domFields["cpy"] =  ob_get_contents();
	ob_end_clean();

}

?>	

<?php
if(array_key_exists("jt",$priModObj[0]->domFields)){
	ob_start();
?>	
<div>
	<label for='jobTitle'>
		Position
	</label>
	 <input
		type="text" 
		id="jobTitle<?php echo $_REQUEST["recordID"]; ?>" 
		name="jobTitle" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('jobTitle'); ?>"
	/>
</div>	
<?php
	$priModObj[0]->domFields["jt"] =  ob_get_contents();
	ob_end_clean();
}
?>	

<?php

if(array_key_exists("nts",$priModObj[0]->domFields)){

	ob_start();

?>		

<div>
	<label for='notes'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['notes']; ?>
	</label>

	 <textarea
		id="notes<?php echo $_REQUEST["recordID"]; ?>" 
		name="notes" 
		rows="5" 
		columns="100"><?php echo $priModObj[0]->displayInfo('notes'); ?></textarea>
</div>

<?php

	$priModObj[0]->domFields["nts"] =  ob_get_contents();
	ob_end_clean();

}
?>	

<?php
if(array_key_exists("ru",$priModObj[0]->domFields)){
	ob_start();
?>			

<div class='radioGroupBlock'>

	<label for='receiveUpdates'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['receiveUpdates']; ?>
	</label>

	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
		<input 
			type="radio" 
			name="receiveUpdates" 
			id="receiveUpdatesYes<?php echo $_REQUEST["recordID"]; ?>" 
			value="1" 
			<?php 
				if($priModObj[0]->displayInfo('receiveUpdates')==1) echo "checked='checked'";
			?> 
		/>
	</span>

	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
		<input 
			type="radio" 
			name="receiveUpdates" 
			id="receiveUpdatesNo<?php echo $_REQUEST["recordID"]; ?>" 
			value="0" 
			<?php 
				if($priModObj[0]->displayInfo('receiveUpdates')==0) echo "checked='checked'";
			?> 
		/>
	</span>
</div>

<?php
	$priModObj[0]->domFields["ru"] =  ob_get_contents();
	ob_end_clean();
}
?>	

<?php
if(array_key_exists("isAd",$priModObj[0]->domFields)){
	ob_start();
?>			

<div class='radioGroupBlock'>

	<label for='isAdmin'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isAdmin']; ?>
	</label>

	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
		<input 
			type="radio" 
			name="isAdmin" 
			id="isAdminYes<?php echo $_REQUEST["recordID"]; ?>" 
			value="1" 
			<?php 
				if($priModObj[0]->displayInfo('isAdmin')==1) echo "checked='checked'";
			?> 
		/>
	</span>

	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
		<input 
			type="radio" 
			name="isAdmin" 
			id="isAdminNo<?php echo $_REQUEST["recordID"]; ?>" 
			value="0" 
			<?php 
				if($priModObj[0]->displayInfo('isAdmin')==0) echo "checked='checked'";
			?> 
		/>
	</span>
</div>

<?php
	$priModObj[0]->domFields["isAd"] =  ob_get_contents();
	ob_end_clean();
}
?>	

<?php
if(array_key_exists("pa",$priModObj[0]->domFields)){

	ob_start();

	/*we use this field to determine if the account was already created and active
	if its not created, we don't create it in the DOM because we create it with JS
	after the account is created. if the account was created we put it here so that
	we don't send out any notification emails*/
	if(is_numeric($priModObj[0]->displayInfo("priKeyID"))){
?>					
		<input 
			id="preActive<?php echo $_REQUEST["recordID"]; ?>" 
			name="preActive"
			type="hidden" 
			value="<?php echo $priModObj[0]->displayInfo('isActive');?>"
		/>
<?php
	}
	$priModObj[0]->domFields["pa"] =  ob_get_contents();
	ob_end_clean();

}
?>
<?php
if(array_key_exists("userGroupMap",$priModObj[0]->domFields)){

	#Get all of the user groups
	$publicUserGroups = $publicUserGroupObj->getAllRecords();
	
	if(mysqli_num_rows($publicUserGroups) > 0){
		
		$priModObj[0]->domFields["userGroupMap"] = "
		<div class='moduleSubElement'>
			<h3 onclick=\"$('#publicUserGroups" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
				Public User Groups<span>&lt; click to toggle visibility</span>
			</h3>
			<div 
				id='publicUserGroups" . $_REQUEST["recordID"] . "' 
				class='adminShowHideChild'
			>";
			while($x = mysqli_fetch_array($publicUserGroups)){
			#check to see if this one is mapped already, if it is, check it off
			if(isset($_REQUEST["recordID"])){
				$groupMapped = $publicUserGroupMapObj->getConditionalRecord(
					array("publicUserID",$_REQUEST["recordID"],true,"publicUserGroupID",$x["priKeyID"],true)
				);
			}
			
			if(isset($groupMapped) && mysqli_num_rows($groupMapped) > 0){
				$priModObj[0]->domFields["userGroupMap"] .= "
					<div>
						<input 
							id='publicUserGroupID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							type='checkbox' 
							checked='checked' 
							name='publicUserGroupID' 
							class='categorisedPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/>
						<span>" . htmlentities(html_entity_decode($x["groupDesc"],ENT_QUOTES),ENT_QUOTES) . "</span>
					</div>";
			}
			else{
				$priModObj[0]->domFields["userGroupMap"] .= "
					<div>
						<input 
							id='publicUserGroupID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							type='checkbox' 
							name='publicUserGroupID' 
							class='categorisedPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/>
						<span>" . htmlentities(html_entity_decode($x["groupDesc"],ENT_QUOTES),ENT_QUOTES) . "</span>
					</div>";
			}
		}
		$priModObj[0]->domFields["userGroupMap"] .= "
			</div>
		</div>";
	}
}
?>	