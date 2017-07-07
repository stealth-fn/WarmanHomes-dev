<?php
	$priModObj[0]->domFields["pgn"] = 
	'<div 
		class="pgn_'. $priModObj[0]->className .'"
		id="pgn_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
	>' . $priModObj[0]->queryResults["pageName"] . '</div>';
?>

<?php
	#CHILD PAGE LINK
	$priModObj[0]->domFields["chpg"] = '
	<a
		class="chpg chpg-'. $priModObj[0]->className.' adminLstLnk sb"
		href="/index.php?pageID=-101"&amp;parentPageID='. $priModObj[0]->queryResults["priKeyID"].'
		id="chpg-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
		onclick="atpto_adminTopNav.toggleBlind(\'-101\',0,\'upc(-101,\\\'&amp;parentPageID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--101\',event);return false"
	>Sub Pages</a>';
?>