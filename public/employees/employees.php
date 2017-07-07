<?php
#employee name
if(array_key_exists("Name",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="employeeName-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="employeeName-<?php echo $priModObj[0]->className;?>" 
	itemprop="name"
>
	<?php echo $priModObj[0]->queryResults['employeeName'];?>
</div>
<?php
	$priModObj[0]->domFields["Name"] =  ob_get_contents();
	ob_end_clean();
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Name"] = "";
}
?>

<?php
#employee title
if(array_key_exists("Title",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="employeeTitle-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="employeeTitle-<?php echo $priModObj[0]->className;?>" 
	itemprop="jobtitle"
>
	<?php echo $priModObj[0]->queryResults['employeeTitle'];?>
</div>
<?php
	$priModObj[0]->domFields["Title"] =  ob_get_contents();
	ob_end_clean();
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Title"] = "";
}
?>

<?php
#employee copy
if(array_key_exists("Content",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="employee-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="employee-<?php echo $priModObj[0]->className; ?>"
		itemprop="description"
	 >
		<?php echo $priModObj[0]->queryResults['employeeBio'];?>
	</div>
<?php
	$priModObj[0]->domFields["Content"] =  ob_get_contents();
	ob_end_clean();
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Content"] = "";
}
?>

<?php
#employee view more link
if(array_key_exists("Link to Page",$priModObj[0]->domFields)){
	$showViewMore = true;
	if(isset($priModObj[0]->employeeKeyID)){
		if($priModObj[0]->employeeKeyID == $priModObj[0]->queryResults["priKeyID"]){
			$showViewMore = false;
		}
	}

	if($showViewMore){
		$priModObj[0]->domFields["Link to Page"] =
		'<a 
			class="sb empviewlink empviewlink-' . $priModObj[0]->className . '"
			href="index.php?pageID=' . $priModObj[0]->linkPageID . '&amp;pmpm=%7B\'' . $priModObj[0]->empToQueryPmpmID . '\'%3A%7B\'employeeKeyID\'%3A\''. $priModObj[0]->queryResults["priKeyID"] . '\'%7D%7D"
			onclick="upc(' . $priModObj[0]->linkPageID . ',&quot;pmpm=%7B\''.$priModObj[0]->empToQueryPmpmID.'\'%3A%7B\'employeeKeyID\'%3A\''.$priModObj[0]->queryResults["priKeyID"].'\'%7D%7D&quot;); return false"
		>' . $priModObj[0]->empButtonText . '</a>';
	}
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Link to Page"] = "";
}
?>


