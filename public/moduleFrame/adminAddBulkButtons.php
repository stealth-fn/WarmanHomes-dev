<?php
	if(isset($_REQUEST["parentPriKeyID"])){
		$parentParams = "&amp;parentPriKeyID=" . $_REQUEST["parentPriKeyID"];
	}
	else{
		$parentParams = "";
	}

	#$requestString is set in requestString.php
	#add our archived property to the parameter

	#clicked "Archived" button
	if(isset($priModObj[0]->archived) && $priModObj[0]->archived == 1) {
		
		if(strpos($requestString,'"archived":"1"') !== false) {
			$requestArchiveString = urlencode(str_replace('"archived":"1"','"archived":"0"',$requestString));
		}
		else{
			$requestArchiveString = str_replace('%22archived%22:%221%22','%22archived":%220%22',$requestString);
		}
		
		$archiveBtn = "Unarchived";
	}
	#clicked "Unarchived" button
	elseif(isset($priModObj[0]->archived) && $priModObj[0]->archived == 0){
		
		if(strpos($requestString,'"archived":"0"') !== false) {
			$requestArchiveString = urlencode(str_replace('"archived":"0"','"archived":"1"',$requestString));
		}
		else{
			$requestArchiveString = str_replace('%22archived%22:%220%22','%22archived":%221%22',$requestString);
		}
		
		$archiveBtn = "Archived";
	}
	#original record listing
	else{
		$requestArchiveString = str_replace("ppToken%22","ppToken%22,%22archived%22:%221%22",$requestString);

		$archiveBtn = "Archived";
	}
?>

<a
	class="moduleItemAdd"
	href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?><?php echo $parentParams; ?>"
	id="moduleItemAdd1"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->addEditPageID; ?>,&#34;<?php echo $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 
	title="Add"
>
	Add +
</a>

<a 
	class="moduleItemBulk"
	href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>&amp;bulkMod=1<?php echo $parentParams; ?>"
	id="moduleItemBulk1"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->addEditPageID; ?>,&#34;bulkMod=1<?php echo $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 
	title="Bulk Edit"
>
	Bulk Edit
</a>

<?php
	#only show the archive button if there is an active field for this table/module
	if(strpos($priModObj[0]->tableRecords,"isActive") !== false) {
?>
<a 
	class="moduleItemArchived"
	href='/index.php?pageID=<?php echo $priModObj[0]->pageID; ?>&amp;<?php echo $requestArchiveString . $parentParams; ?>'
	id="moduleItemArchived1"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->pageID; ?>,&#34;<?php echo $requestArchiveString . $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 
	title="Archived"
>
	<?php echo $archiveBtn; ?>
</a>
<?php
	}
?>

<a
	class="moduleItemAdd"
	href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?><?php echo $parentParams; ?>"
	id="moduleItemAdd2"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->addEditPageID; ?>,&#34;<?php echo $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 
	title="Add"
>
	Add +
</a>

<a 
	class="moduleItemBulk"
	href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>&amp;bulkMod=1<?php echo $parentParams; ?>"
	id="moduleItemBulk2"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->addEditPageID; ?>,&#34;bulkMod=1<?php echo $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 	
	title="Bulk Edit"
>
	Bulk Edit
</a>

<?php
	#only show the archive button if there is an active field for this table/module
	if(strpos($priModObj[0]->tableRecords,"isActive") !== false) {
?>
<a 
	class="moduleItemArchived"
	href='/index.php?pageID=<?php echo $priModObj[0]->pageID; ?>&amp;<?php echo $requestArchiveString . $parentParams; ?>'
	id="moduleItemArchived2"
	onclick="
		atpto_adminTopNav.toggleBlind('<?php echo $priModObj[0]->addEditPageID; ?>',0,
		'upc(<?php echo $priModObj[0]->pageID; ?>,&#34;<?php echo $requestArchiveString . $parentParams; ?>&#34;);'
		,'ntid_adminTopNav<?php echo $priModObj[0]->pageID; ?>',event
	);return false" 	title="Archived"
>
	<?php echo $archiveBtn; ?>
</a>
<?php
	}
?>