<div id="moduleContainer">

	<form name="moduleForm" id="moduleForm" action="">	

		<div>

		<label for='tagText'>Blog Tag</label>

		<input 

					type="text"

					id="tagText" 

					name="tagText" 

					value="<?php echo htmlspecialchars(displayInfo('tagText')); ?>"

					/>	

		</div>

     

		<?php

		

			include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");

			$blogObj = new blog(false);

			$blogPosts = $blogObj->getAllRecords();

			

			include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTagMap.php");

			$blogTagMapObj = new blogTagMap(false);

			

						

			if(mysqli_num_rows($blogPosts) > 0){

				echo "<div class='moduleSubElement'><h3  onclick=\"$('#taggedPosts').toggle()\" class=\"adminShowHideParent\">Posts With This Tag" .

						" <span>&lt; click to toggle visibility</span></h3><div id='taggedPosts' class='adminShowHideChild'>";

				while($x = mysqli_fetch_array($blogPosts)){

					/*check to see if this one is mapped already, if it is, check it off*/

					if(isset($_POST["recordID"])){

						$catMapped = $blogTagMapObj->getConditionalRecord(

										array("blogTagID",$_POST["recordID"],true,"blogID",$x["priKeyID"],true)

									 );

					}

					if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){

						echo  "<div><input type='checkbox' checked='checked' name='blogID' class='blogPost" . $x["priKeyID"] . "' value='" . $x["priKeyID"] . "'/><span>" . $x["blogName"] . "</span></div>";

					}

					else{

						echo "<div><input type='checkbox' name='blogID' class='blogPost" . $x["priKeyID"] . "' value='" . $x["priKeyID"] . "'/><span>" . $x["blogName"] . "</span></div>";

					}

				}

				echo "</div></div>";

			}

			

			$addEditButtonValue = "Create Tag";

			

			if(isset($addEdit)){

				if($addEdit == 1){

					echo "<input name='priKeyID' id='priKeyID' value='" .$_POST["recordID"]. "' type='hidden'/>";					

					$addEditButtonValue = "Save Changes";	

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

            value="<?php echo $addEditButtonValue; ?>" 

            onclick="blogTagAddEditObj.addEditModule(this)"

        />									

	</form>	

</div>

<div id='moduleHelp'>

<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>

<p id='helpText'><?php displayInfo('moduleHelp')?></p>

</div>