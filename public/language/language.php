<?php
	if($priModObj[0]->displayType==0){
?>

	<div id="lngContainer">
		<label for="siteLng">
			<?php 
				if(abs($_SESSION["domainID"])==1) {
					echo "Language"; 
				}
				elseif(abs($_SESSION["domainID"])==2){
					echo "言語";
				}
			?>
		</label>
		<select id="siteLng" name="siteLng" onchange="changeSiteLng($('#siteLng').val())">
			<option value="en" <?php if(abs($_SESSION["domainID"])==1) echo 'selected="selected"'; ?>>English</option>
			<option value="jp" <?php if(abs($_SESSION["domainID"])==2) echo 'selected="selected"'; ?>>日本語</option>
		</select>
	</div>

<?php
	}
	elseif($priModObj[0]->displayType==1){
?>
	<div id="lngContainer">
		<a 
			class="lngLink <?php if(abs($_SESSION["domainID"])==2) echo 'lngPg'; ?>"
			id="lngJP" 
			href="#"
			onclick="changeSiteLng('jp');return false"
		>JP</a>
		<a 
			class="lngLink <?php if(abs($_SESSION["domainID"])==1) echo 'lngPg'; ?>"
			id="lngEN"
			href="#"
			onclick="changeSiteLng('en');return false"
		>ENG</a>
	</div>
<?php
	}
?>