<?php
	#build add/edit adding a new record, we don't need the whole module frame
	if(isset($_GET["pmpmID"]) && isset($priModObj[0]->bulkMod)){
		#data items for this module
		include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrameItems.php");
	}
	#most other situations, load in the module frame
	else{
		
		/*recursively make a class name for this module based
		off of its own class name and its parents, this is useful
		for when we're trying to access modules > level 1, ex. a
		gallery in a product
		*/
		$mfmcClassName = "mfmc-" . $priModObj[0]->originalClassName;

		for($x = 1; isset($priModObj[$x]); $x++){
			$mfmcClassName .= "-" . $priModObj[$x]->originalClassName;
		}
?>
<div 
	class="mfmc mfmc <?php echo $mfmcClassName; ?>" 
	id="mfmc-<?php echo $priModObj[0]->className;?>"
>
	
	<?php
		#only show the header text if there's header text to show. its not w3 valid if empty
		if(strlen($priModObj[0]->headerText) > 0){
	?>
	<h2 class="mfh" id="mfh-<?php echo $priModObj[0]->className;?>">
    	<?php echo $priModObj[0]->headerText;?>
    </h2>
	<?php
		}
	?>

    <div
		class="mfmcc mfmcc-<?php echo $priModObj[0]->className;?>"
		id="mfmcc-<?php echo $priModObj[0]->className;?>" 
	>
		<?php
			#data items for this module
			include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrameItems.php");
		?>
    </div>
	
	<?php 
		#we don't need a bulk save button for every form, just once
		#also don't show when we're adding a record to the bulk add/edit
		if(isset($priModObj[0]->bulkMod) && !isset($_GET["pmpmID"])){  
	?>
		<input 
			class="bulkAll"
			id="bulkAll" 
			name="bulkAll"
			onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].bulkMassAddEdit()"
			type="button" 
			value="Save All Records" 
		/>
		
		<input 
			class="addRec"
			type="button" 
			id="addRec" 
			name="addRec"
			value="Add + "
			onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].setupRecord(false,this)"
		/>

		<?php
			if(isset($_REQUEST["parentPriKeyID"])){
		?>
			<input
				id='parentPriKeyIDBlk'
				name='parentPriKeyID'
				type='hidden'
				value='<?php echo $_REQUEST["parentPriKeyID"]; ?>'
			/>
		<?php
			}
		?>
	<?php } ?>
	
	<?php 
	#include pagination contents if included
	if(
		($priModObj[0]->isTemplate == 0 && isset($_REQUEST["bulkMod"]))||
		($priModObj[0]->isTemplate == 1 && $priModObj[0]->instanceDisplayType == 2)
	){
	?>
        <div class="mfp" id="mfp-<?php echo $priModObj[0]->className;?>">
			<?php include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/modulePaginate.php");?>
        </div>
		<div class="modDspQtyContainer" id="modDspQtyContainer-<?php echo $priModObj[0]->className;?>">
			<?php include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFramePaginateQty.php");?>
		</div>
    <?php
	}

	#storage element for click slides, fades, etc
	include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrameEffectStorage.php");
	
	#COMMENTS
	if($priModObj[0]->hasComments == 1 ) {
	?>
		<div id="disqus_thread"></div>
	<?php
		}
	?>
	
	<?php 
		if ($priModObj[0]->csvExport == 1) {
	?>
		<div class="modCSVDumpContainer">
			<a href="#" onclick='<?php echo $priModObj[0]->className; ?>.getCSVDump(&#39;<?php echo $requestString; ?>&#39;);return false'>
				Save As CSV...
			</a>
		</div>	
	<?php			
		}
	?>
</div>
<?php
	}
?>