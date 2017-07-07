<div id="prodCatTree">
	<h2 class="prodCatHeader mfh">
		<?php echo $priModObj[0]->headerText; ?>
	</h2>
	<?php
		if($priModObj[0]->instanceID == 1 || $priModObj[0]->instanceID == 4) {
			if(isset($_REQUEST["vendID"])){
				$treeArray = $priModObj[0]->getProdCatTreeArray(0,149,0,"",$_REQUEST["vendID"]);
				$prodCatTree = $priModObj[0]->getProdCatTree($treeArray,$_REQUEST["vendID"]);
			}
			else {
				$treeArray = $priModObj[0]->getProdCatTreeArray(0,149,0,"");	
				$prodCatTree = $priModObj[0]->getProdCatTree($treeArray);
			}
		}
		else {
			if(isset($_REQUEST["vendID"])){
				$treeArray = $priModObj[0]->getProdCatTreeArray(0,148,0,"",$_REQUEST["vendID"]);
				$prodCatTree = $priModObj[0]->getProdCatTree($treeArray,$_REQUEST["vendID"]);
			}
			else {
				$treeArray = $priModObj[0]->getProdCatTreeArray(0,148,0,"");	
				$prodCatTree = $priModObj[0]->getProdCatTree($treeArray);
			}
		}
		echo $prodCatTree;
	?>
</div>