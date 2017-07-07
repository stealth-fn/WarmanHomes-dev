<?php
#FAQ Category
if(array_key_exists("fct",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="faqCategory-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="faqCategory faqCategory-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>"
 >
	<?php echo $priModObj[0]->queryResults['faqCategory'];?>
</div>
<?php
	$priModObj[0]->domFields["fct"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#FAQ's for this category
if(array_key_exists("fctaq",$priModObj[0]->domFields)){
	
	#put child module into output buffer
	ob_start();
	$recursivePmpmID = $priModObj[0]->faqPmpmID;
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
	$priModObj[0]->domFields["fctaq"] = ob_get_contents();
	ob_end_clean();
}	
elseif(array_key_exists("fctaq",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["fctaq"] = '<div class="mfmc"></div>';
}
?>

<?php

	#FAQs BELONG TO A CATEGORY
	if(array_key_exists("fctaqs",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["fctaqs"] = '
		<a
			class="fctaqs fctaqs-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID=-171"&amp;faqCatID='. $priModObj[0]->queryResults["priKeyID"].'
			id="fctaqs-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
			onclick="atpto_adminTopNav.toggleBlind(\'-171\',0,\'upc(-171,\\\'&amp;faqCatID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--171\',event);return false"
		>Edit FAQs</a>';
	}
?>