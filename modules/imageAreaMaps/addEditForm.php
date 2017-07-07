<div id="moduleContainer">

	<form name="moduleForm" id="moduleForm" action="" >

		<div>

			<label for='imageAreaMapName'>Image Area Map Name</label>

			<input 

	        	name="imageAreaMapName" 

	            id="imageAreaMapName"

	            type="text"

	            value="<?php echo trim($moduleObj->displayInfo('imageAreaMapName')); ?>"

	       	/>

		</div>

		<div id="photoContainer">

        	<?php if($moduleObj->displayInfo('galleryImageID')>0){

				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/galleryImages.php");

				$galImgObj = new galleryImage(false);

				$galImgQuery = $galImgObj->getRecordByID($moduleObj->displayInfo('galleryImageID'));

				$galImgResult = mysqli_fetch_array($galImgQuery);

			?>

            	<img alt="imgDesc" src="/images/galleryImages/<?php echo $_REQUEST['moduleID'];?>imageAreaMap/medium/<?php echo $galImgResult["fileName"];?>" />

			<?php } ?>

		</div>

		<div>

			<input

				class="uploadImg adminBtn"

				id="uploadImg"

				name="uploadImg"

				<?php

				if($moduleObj->displayInfo('galleryImageID') > 0){

					echo "value='Change Image'";

				} else{

					echo "value='Add Image'";

				}

				?>

				type="button"

				onclick="window.open(

										'/modules/moduleWindow.php?moduleID=10'

										+ '&amp;addWin=1' 

										+ '&amp;parentModuleID=85'

										+ '&amp;parentPriKeyID=<?php echo $_REQUEST["recordID"];?>'

                                        + '&amp;pageID=-1'

                                        + '&amp;parentModuleName=imageAreaMap',

										'Upload_ImageAreaMap_Image',

										'width=700,height=680'

									)"

			/>

		</div>

		<input

			type="hidden"

			name="moduleName"

			id="moduleName"

			value="imageAreaMap"

		/>

	

	<?php

		$hotspots = $hotspotObj->getConditionalRecord(array("imageAreaMapID",$_REQUEST["recordID"],true));

	?>

	<div id="imageAreaMapHotspotsContainer">

		<h3 class="adminShowHideParent" onclick="$('#imageAreaMapHotspotsContainerInner').toggle()">Hotspots

			<span>&lt; click to toggle visibility</span>

		</h3>

		<div id="imageAreaMapHotspotsContainerInner" class="adminShowHideChild boxLvl1">

		<?php

			if(mysqli_num_rows($hotspots) > 0){

				$hotspotsCounter = 0;

				while($x = mysqli_fetch_assoc($hotspots)){

			?>

				<div id="hotspotFirstContainer<?php echo $hotspotsCounter;?>" class="hotspotFirstContainer">

					<h3 class="hotspotsTitle">Hotspot <?php echo $hotspotsCounter;?></h3>

					<input

						type="button"

						class="modSubElRem"

						value="Delete Hotspot"

						onclick="imageAreaMapAddEditObj.removeHotspot(<?php echo $hotspotsCounter;?>)"

					/>	

					<div class="hotspotSecondContainer boxLvl2">

						<label>Name</label>

						<input

							type="text"

							class="hotspotName"

							value="<?php echo $x['hotspotName'];?>"

						/>

						<br />

						<label>Coordinates</label>

						<input

							type="text"

							class="coordinates"

							value="<?php echo $x['coordinates'];?>"

						/>

						<input

							type="hidden"

							name="hotspotID"

							class="hotspotID"

							value="<?php echo $x['priKeyID'];?>"

						/>

						<input 

							type="hidden"

							class="hotspotsCounter"

							name="hotspotsCounter"

							value="<?php echo $hotspotsCounter;?>"

						/>

						<?php

						#groups for this hotspot

						$groups = $hotspotGroupObj->getAllRecords();

						

						#categories mapped to this product

						$mappedGroups = $hotspotGroupMapObj->getConditionalRecord(array("hotspotID",$x['priKeyID'],true));

						$mappedGroupsIDList = $hotspotGroupMapObj->getQueryValueString($mappedGroups,"hotspotGroupID",",");

						$mappedGroupArray = explode(",",$mappedGroupsIDList);

						?>

						<div class="hotspotGroupsContainer">

							<h3>Groups For This Hotspot</h3>

						<?php

							while($y = mysqli_fetch_assoc($groups)){

								$checked = "";

								if(in_array($y["priKeyID"],$mappedGroupArray) !== false){

									$checked = "checked='checked'";

								}

						?>

								<div class="hotspotGroup<?php echo $hotspotsCounter;?> hotspotGroup">

									<label>

										<span style="background-color:<?php echo $y['color'];?>"></span>

										<?php echo $y['hotspotGroupName'];?>

									</label>

									<input

										<?php echo $checked;?>

										type="checkbox"

										name="hotspotGroupID"

										id="hotspotGroupID<?php echo $hotspotsCounter."-".$y['priKeyID'];?>"

										class="hotspotGroupID<?php echo $hotspotsCounter;?> hotspotGroupID"

										value="<?php echo $y["priKeyID"];?>"

									/>

								</div>

							<?php

								}

							?>

						</div>

						

						<div class="hotspotDataContainer">

							<h3>Hotspot Data</h3>

							<?php

							#data values for each hotspot

							$mappedDataFields = 

							$hotspotDataImageAreaMapObj->getCheckQuery(

							"SELECT hotspot_data_image_area_map.*,hotspot_data.*,hotspot_data_map.*, hotspot_data_image_area_map.hotspotDataID as hotspotDataID FROM hotspot_data_image_area_map 

							LEFT JOIN hotspot_data ON hotspot_data.priKeyID = hotspot_data_image_area_map.hotspotDataID  

							LEFT JOIN hotspot_data_map ON hotspot_data_map.hotspotDataID = hotspot_data_image_area_map.hotspotDataID

							WHERE hotspot_data_image_area_map.imageAreaMapID = ".$_REQUEST["recordID"]." AND hotspot_data_map.hotspotID = ".$x['priKeyID']

							);

							while($z = mysqli_fetch_assoc($mappedDataFields)){

							?>

								<div class="hotspotData<?php echo $hotspotsCounter;?> hotspotData">

									<label>

										<?php echo $z['hotspotDataName'];?>

									</label>

									<input

										type="text"

										name="hotspotDataValue"

										class="hotspotDataValue<?php echo $hotspotsCounter;?> hotspotDataValue"

										value="<?php echo $z['hotspotDataValue'];?>"

									/>

									<input

										type="hidden"

										name="hotspotDataID"

										class="hotspotDataID<?php echo $hotspotsCounter;?> hotspotDataID"

										value="<?php echo $z['hotspotDataID'];?>"

									/>

								</div>

							<?php

							}

							?>

						</div>	

					</div>

				</div>

				<?php

						$hotspotsCounter++;

					}

				}

				else{

					$hotspotsCounter = 0;

			?>

					<div id="hotspotFirstContainer<?php echo $hotspotsCounter;?>" class="hotspotFirstContainer">

						<h3 class="hotspotsTitle">Hotspot <?php echo $hotspotsCounter;?></h3>

						<input

							type="button"

							class="modSubElRem"

							value="Delete Hotspot"

							onclick="imageAreaMapAddEditObj.removeHotspot(<?php echo $hotspotsCounter;?>)"

						/>	

						<div class="hotspotSecondContainer boxLvl2">

							<label>Name</label>

							<input

								type="text"

								class="hotspotName"

								value="<?php echo $x['hotspotName'];?>"

							/>

							<br />

							<label>Coordinates</label>

							<input

								type="text"

								class="coordinates"

								value=""

							/>

							<input

								type="hidden"

								name="hotspotID"

								class="hotspotID"

								value=""

							/>

							<input 

								type="hidden"

								class="hotspotsCounter"

								name="hotspotsCounter"

								value="<?php echo $hotspotsCounter;?>"

							/>

							<?php

							#groups for this hotspot

							$groups = $hotspotGroupObj->getAllRecords();

							?>

							<div class="hotspotGroupsContainer">

								<h3>Groups For This Hotspot</h3>

							<?php

								while($y = mysqli_fetch_assoc($groups)){

							?>

									<div class="hotspotGroup<?php echo $hotspotsCounter;?> hotspotGroup">

										<label>

											<span style="background-color:<?php echo $y['color'];?>"></span>

											<?php echo $y['hotspotGroupName'];?>

										</label>

										<input

											type="checkbox"

											name="hotspotGroupID"

											id="hotspotGroupID<?php echo $hotspotsCounter."-".$y['priKeyID'];?>"

											class="hotspotGroupID<?php echo $hotspotsCounter;?> hotspotGroupID"

											value="<?php echo $y["priKeyID"];?>"

										/>

									</div>

								<?php

									}

								?>

							</div>

							

							<div class="hotspotDataContainer">

								<h3>Hotspot Data</h3>

								<?php

								#data values for each hotspot

								$mappedDataFields = 

								$hotspotDataImageAreaMapObj->getCheckQuery(

								"SELECT * FROM hotspot_data_image_area_map 

								LEFT JOIN hotspot_data ON hotspot_data.priKeyID = hotspot_data_image_area_map.hotspotDataID  

								WHERE hotspot_data_image_area_map.imageAreaMapID = ".$_REQUEST["recordID"]

								);

								while($z = mysqli_fetch_array($mappedDataFields)){

								?>

									<div class="hotspotData<?php echo $hotspotsCounter;?> hotspotData">

										<label>

											<?php echo $z['hotspotDataName'];?>

										</label>

										<input

											type="text"

											name="hotspotDataValue"

											class="hotspotDataValue<?php echo $hotspotsCounter;?> hotspotDataValue"

											value=""

										/>

										<input

											type="hidden"

											name="hotspotDataID"

											class="hotspotDataID<?php echo $hotspotsCounter;?> hotspotDataID"

											value="<?php echo $z['hotspotDataID'];?>"

										/>

									</div>

								<?php

								}

								?>

							</div>	

						</div>

					</div>



			<?php

				}

			?>			

			<input

				type="button"

				name="addHotspot"

				class="buttonAddSmall"

				id="addHotspot"

				value="Add Hotspot"

				onclick="imageAreaMapAddEditObj.addHotspot()"

			/>

		</div>

	</div>



		

	<?php

	$moduleObj->addEditButtonValue = "Add Image Area Map";

	

	if(isset($moduleObj->addEdit)){

		if($moduleObj->addEdit){

			echo "<input 

					name='priKeyID' 

					id='priKeyID' 

					value='" .$_REQUEST["recordID"]. "' 

					type='hidden'

				/>";

			$moduleObj->addEditButtonValue = "Save Changes";

		}

		else{

			echo "<input name='priKeyID' id='priKeyID' value='0' type='hidden'/>";

		}

	}

	?>

        

		<input 

        	type="button" 

            id="moduleAddEditBtn" 

            name="moduleAddEditBtn" 

            value="<?php echo $moduleObj->addEditButtonValue; ?>" 

            onclick="imageAreaMapAddEditObj.addEditModule(this)"

        />				

	</form>	

</div>

<div id='moduleHelp'>

<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>

<p id='helpText'><?php $moduleObj->displayInfo('moduleHelp')?></p>

</div>