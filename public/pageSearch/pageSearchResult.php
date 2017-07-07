<?php
	#when users copy and paste from a word processor, some fancy characters
	#cannot be rendered in the browser these are the replacements
	$badChars = array();
	$badChars[0] = '/%u2019/';
	$badChars[1] = '/%u2022/';
	$badChars[2] = '/%u2013/';
	$badChars[3] = '/%u201C/';
	
	$goodChars = array();
	$goodChars[0] = "'";
	$goodChars[1] = "-";
	$goodChars[2] = "-";
	$goodChars[3] = '"';
?>

<div 
	class="mi mi-<?php echo $oddEven;?> mi-<?php echo $_GET['className']; ?>"
	id="searchResult-<?php echo $_GET['className']; echo $_GET['queryResults']['priKeyID']; ?>"
>
	<div class="searchResult searchResult-<?php echo $oddEven;?>">
		<div class="pageTitleSearchResult">
			<a 
				href="index.php?pageID=<?php echo $_GET['queryResults']['priKeyID'];?>"
				onclick="upc(<?php echo $_GET['queryResults']['priKeyID'];?>);return false"
			>
				<?php echo $_GET["queryResults"]["pageTitle"];?>
			</a>
		</div>
		<div class="pageContentSearchResult">
			<?php  
				if($pageSearchObj->contentTrim == 0 || $pageSearchObj->contentTrim == NULL) { 
					echo $_GET["queryResults"]["pageCode"];
				}
				else{
					$pageText = substr(strip_tags($_GET["queryResults"]["pageCode"]),0,$pageSearchObj->contentTrim);
						
					if(strlen($_GET["queryResults"]["pageCode"]) > $pageSearchObj->contentTrim){
						$pageText = $pageText . "...";
					}
					else{
						$pageText = $_GET["queryResults"]["pageCode"];
					}
					
					#replace ckeditor bad characters
					$pageTextReplace = preg_replace($badChars,$goodChars,$pageText);
					
					echo $pageTextReplace;
				}
			?>
		</div>
		<div class="viewPage">
			<a 
				href="index.php?pageID=<?php echo $_GET['queryResults']['priKeyID'];?>"
				onclick="upc(<?php echo $_GET['queryResults']['priKeyID'];?>);return false"
			>
				View Page
			</a>
		</div>
	</div>
</div>