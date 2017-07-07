<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/pages/pageSearch.php');
	$pageSearchObj = new pageSearch(false);
	$pageSearchObj->setInstance($_GET["instanceID"]);
?>

<div id="searchContainer">
	<form name="searchForm" id="searchForm" action="" onsubmit="pageSearch();return false">
		<input 
			id="searchTerm" 
			name="searchTerm"
			type="text" 
			value="<?php echo $pageSearchObj->searchFieldText;?>" 
			maxlength="100"
			onfocus="clearField(this)" 
			onblur="backToDefault(this)"
		/>
		<input
			id="searchPageID"
			name="searchPageID"
			type="hidden"
			value="<?php echo $pageSearchObj->searchPageID;?>"
		/>
		<div
			id="searchBtn"
			onclick="pageSearch()"
		>
			<?php echo $pageSearchObj->searchBtnText;?>
		</div>
	</form>
</div>
