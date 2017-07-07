<?php
#Blog Category Category
if(array_key_exists("bgct",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="blogCategory-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="blogCategory blogCategory-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>"
 >
	<?php echo $priModObj[0]->queryResults['blogCatTitle'];?>
</div>
<?php
	$priModObj[0]->domFields["bgct"] =  ob_get_contents();
	ob_end_clean();
}

#BLOGs BELONG TO A CATEGORY
if(array_key_exists("bged",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["bged"] = '
	<a
		class="bged bged-'. $priModObj[0]->className.' sb"
		href="/index.php?pageID=-150"&amp;blogCategoryID='. $priModObj[0]->queryResults["priKeyID"].'
		id="bged-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
		onclick="atpto_adminTopNav.toggleBlind(\'-150\',true,0,\'upc(-150,\\\'&amp;blogCategoryID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--150\',event);return false"
	>Edit Posts</a>';
}
?>