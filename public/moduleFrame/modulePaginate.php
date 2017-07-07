<?php
	if(!isset($_SESSION)) session_start();
	
	#do a setInstanceModuleParams if we're changing the pagination through ajax
	if(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false){	
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
		$moduleObj = new module(false);
	}

	$selPage = isset($priModObj[0]->currentPagPage) ? $priModObj[0]->currentPagPage : 1;

	if($priModObj[0]->pageCounter > 1){
?>
		<a
			class="mfpp mfprvp"
			id="mfprvp-<?php echo $priModObj[0]->className;?>"
			onclick='<?php echo $priModObj[0]->className; ?>.nextPrevPagPage(0,&#39;<?php echo $requestString; ?>&#39;)'
		>
		</a>
		<a
			class="mfpi mfprvi"
			style="display:
			<?php					
				#Only show the quantity of pages declared in the pageLinkQty setting
				if($selPage < $priModObj[0]->paginateLinkQty || $selPage == 1){
					echo "none;";
				}
				else{
					#this class is used as a marker in our javascript function nextPrevPages
					echo "inline-block;";
				}
			?>"
			id="mfprvi-<?php echo $priModObj[0]->className;?>"
			onclick='<?php echo $priModObj[0]->className; ?>.nextPrevPages(0)'
		>
		</a>
	<?php
		#what group of pagination pages we're currently on
		$pageGroup = 1;
		
		#how many groups of pagination pages there are
		if($priModObj[0]->paginateLinkQty > 0){
			$groupQty = ceil($priModObj[0]->pageCounter/$priModObj[0]->paginateLinkQty);
		}
		else{
			$groupQty = 0;
		}
		
		#what group of pages our selected page is in
		if($priModObj[0]->paginateLinkQty > 0){
			$selPageGroup = ceil($selPage/$priModObj[0]->paginateLinkQty);
		}
		else{
			$selPageGroup = 0;
		}
		
		for($pagPageCnt=1;$pagPageCnt<=$priModObj[0]->pageCounter;$pagPageCnt++){
 
			#put the pagPage number into our JSON instance params
			$requestPPString = str_replace("ppToken",$pagPageCnt,$requestString);
	?>
			<a
				class="
					pgc 
					pgc-<?php echo $priModObj[0]->className; ?> 
					<?php
						#Class for selected page 
						if($selPage == $pagPageCnt || ($selPage == 1 && $pagPageCnt == 1)){
							echo 'pgcClicked';
						}
						
						#Only show the quantity of pages declared in the pageLinkQty setting
						if($selPageGroup != $pageGroup){
							echo " pgcHidden";
						}
						else{
							#this class is used as a marker in our javascript function nextPrevPages
							echo " pgcVisible";
						}
					?>
				"
				href='/<?php echo urlencode($_GET["pageName"]) . "?" . $requestPPString; ?>'
				id="pgc-<?php echo $priModObj[0]->className . "-" . $pagPageCnt; ?>"
				onclick='<?php echo $priModObj[0]->className; ?>.paginateModule(&#39;<?php echo $requestPPString; ?>&#39;,this,<?php echo $pagPageCnt; ?>);return false'
			>
				<?php echo $pagPageCnt; ?>
			</a>
	<?php
			
			#if we are moving onto the next group of pages, increment
			if($pagPageCnt+1 > $pageGroup * $priModObj[0]->paginateLinkQty){
				$pageGroup++;
			}
		}
	?>
	<a
		class="mfpi mfni"
		id="mfni-<?php echo $priModObj[0]->className;?>"
		onclick='<?php echo $priModObj[0]->className; ?>.nextPrevPages(1)'
		style="display:
		<?php					
			#only show more pagination pages if there is more to show
			if($pagPageCnt < $priModObj[0]->paginateLinkQty){
				echo "none;";
			}
			else{
				echo "inline-block;";
			}
		?>"
	>
	</a>
	<a
		class="mfpp mfnp"
		id="mfnp-<?php echo $priModObj[0]->className;?>"
		onclick='<?php echo $priModObj[0]->className; ?>.nextPrevPagPage(1,&#39;<?php echo $requestString; ?>&#39;)'
	>
	</a>
<?php	
	}
?>