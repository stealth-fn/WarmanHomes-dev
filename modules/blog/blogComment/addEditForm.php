<?php
	if(!isset($_SESSION))session_start();

	$commentBlog = $blogObj->getRecordByID($_REQUEST['parentPriKeyID']);
	$blogInfo = mysql_fetch_array($commentBlog);
?>

<div id="moduleContainer">
	<form name="moduleForm" id="moduleForm" action="">
		<p>Leave a Reply:</p>
   		<input 
        	type="hidden" 
            id="blogID"
            name="blogID" 
            value="<?php echo $_REQUEST['parentPriKeyID']; ?>"
        />

        <input 
        	type="hidden" 
            id="blogPageID" 
            name="blogPageID" 
            value="<?php echo $_REQUEST['pageID'];?>" 
        />

        <input
        	type="hidden"
            id="blogParentInstanceID"
            name="blogParentInstanceID"
            value="<?php echo $_REQUEST['parentInstanceID'];?>"
        />
        
       	<input
        	type="hidden"
            id="validateComments"
            name="validateComments"
            value="<?php echo $_REQUEST['validateComments'];?>"
        />
		<input
			type="hidden"
			id="blogParentTitle"
			name="blogParentTitle"
			value="<?php echo $blogInfo['blogName'];?>"
		/>
		<?php
		if($blogInfo["comments"] == 3 || (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0)){
			if(!$_SESSION['loggedIn']){
		?>
        
		
		<input
			maxlength="50"
			name="anonymousName" 
			id="anonymousName"
			value="<?php echo displayInfo('anonymousName'); ?>"
			type="text"
		/>
		<label for="anonymousName" id="anonymousNameLbl">Name (required)</label>
        <br />
		<input
			maxlength="255"
			name="commenterEmail"
			id="commenterEmail"
			value="<?php echo displayInfo('commenterEmail');?>"
			type="text"
		 />
		 <label for="commenterEmail" id="commenterEmail">Email (required, but will not be published)</label>
        <br />
		<input
			maxlength="255"
			name="commenterURL"
			id="commenterURL"
			value="<?php echo displayInfo('commenterURL'); ?>"
			type="text"
		/>
		<label for="commenterURL" id="commenterURL">Website Link</label>
		
		<br />
		<textarea 
			name="postCopy" 
			id="postCopy" 
			rows="9" 
			cols="85"><?php echo displayInfo('postCopy'); ?></textarea>
		<div id="receiveEmailDiv">
			<label for="receiveEmail" id="receiveEmailLbl">Notify me of followup comments via email:</label>
			Yes<input
				name="receiveEmail"
				id="receiveEmail" 
				type="radio"
				value="1"
			 />
			 No<input
				name="receiveEmail"
				id="receiveEmailNo"
				type="radio"
				value="0"
			 />
		 </div>
			
		 
        <?php
			} 
			else if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0){
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/instance/publicLogin/instancePublicLogin.php");
				$blogCommentInstanceLogin = new instancePublicLogin(false);
				$userNameQ = $blogCommentInstanceLogin->getRecordByID($_SESSION['userID']);
				$userNameQ = mysql_fetch_array($userNameQ);
		?>
        <input
        	type="hidden"
            id="anonymousName"
            name="anonymousName"
            value="<?php echo $userNameQ['loginName'];?>"
         />
         <br />
         	<?php
			if(strlen($userNameQ['website']) > 0){
			?>
            <input
                name="commenterURL"
                id="commenterURL"
                value="<?php echo displayInfo('commenterURL'); ?>"
                type="text"
            />
		<?php
			} else{
		?>
        		<label for="commenterURL" id="commenterURLLbl">URL:</label>
                <input
					maxlength="255"
                    name="commenterURL"
                    id="commenterURL"
                    value="<?php echo displayInfo('commenterURL'); ?>"
                    type="text"
                />
        <?php
			}
		}
	}
			#these options aren't available on the public side	
			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 2){			
				/*we need to format the time from 24 to 12 hour, and make the date manually*/
				$editTime = date("g:i a",strtotime(displayInfo('postTime')));
			
				$editDate = date("m/d/Y",strtotime(displayInfo('postDate')));
		?>
			<div>
				<label for='postTime'>Time</label>
                	<input 
                    	name="postTime" 
                        type="text" 
                        maxlength="20" 
                        id="postTime" 
                        value="<?php echo $editTime; ?>" 
                        onblur="validateDatePicker(this)" 
                    />
					<input name="postTimePicker" type="button" class="buttonTimeSmall" title="Pick A Time" onclick="selectTime(this,document.getElementById('postTime'));"/>
                </div>
				<div>
				<label for='postDate'>Date</label>
                	<input
                    	maxlength="20" 
                        name="postDate" 
                        id="postDate" 
                        type="text"
                        value="<?php echo $editDate;?>" 
                    />
                </div>
                <?php
                
				$publicUserInfo = $publicUsersObj->getAllRecords();
				?>
				<div>
					<label for='publicUserID'>User</label>
					<div class='moduleFormStyledSelect'>
	                	<select 
	                    	id='publicUserID' 
	                        name='publicUserID'
	                    >
							<option value='0'>Anonymous</option>
						<?php
		                if(mysql_num_rows($publicUserInfo) > 0){
							while($x = mysql_fetch_array($publicUserInfo)){
								if($x["priKeyID"] == displayInfo('publicUserID')){
									?>
		                            <option value="<?php echo $x["priKeyID"];?>" selected="SELECTED"><?php echo $x["loginName"];?></option>
		                            <?php
								}
								else{
									?>
		                            <option value="<?php echo $x["priKeyID"];?>"><?php echo $x["loginName"];?></option>
		                            <?php
								}
							}
						}
						?>
		                </select>
	                </div>
                </div>
                  <div class='radioGroupBlock'>
					<label for='validatedComment'>Validated</label>
					<span>
					Yes<input 
                        	type="radio" 
                            name="validatedComment" 
                            id="validateYes" 
                            value="1" 
                            checked="<?php echo (displayInfo('validatedComment')==1) ? "checked" : "" ?>" 
                        />
                    </span><span>
					No<input 
                        	type="radio" 
                        	name="validatedComment" 
                            id="validateNo" 
                            value="0"
                            checked="<?php echo (displayInfo('validatedComment')==1) ? "" : "checked" ?>" 
                        /></span>
                </div>
	
			<input 
	        	type="hidden" 
	            id="blogID" 
	            name="blogID" 
	            value="<?php echo $_REQUEST['parentPriKeyID']; ?>"
	        />
	
	        <input 
	        	type="hidden" 
	            id="blogPageID" 
	            name="blogPageID" 
	            value="<?php echo $_REQUEST['pageID'];?>" 
	        />
	
	        <input
	        	type="hidden"
	            id="blogParentInstanceID"
	            name="blogParentInstanceID"
	            value="<?php echo $_REQUEST['parentInstanceID'];?>"
	        />
	        
	       	<input
	        	type="hidden"
	            id="validateComments"
	            name="validateComments"
	            value="<?php echo $_REQUEST['validateComments'];?>"
	        />
            <?php		
			}
			
			
			
			
			$addEditButtonValue = "Add Comment";
			
			if(isset($addEdit)){
				if($addEdit == 1){
					?>
					<input 
                    	name="priKeyID" 
                        id="priKeyID" 
                        value="<?php echo $_POST["recordID"];?>" 
                        type='hidden'
                    />
                    <?php					
					$addEditButtonValue = "Edit Blog Post Comment";	
				}
				else{
					?>
					<input 
                    	name="priKeyID" 
                        id="priKeyID" 
                        value="0" 
                        type="hidden"
                    />
                    <?php
				}
			}

			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0){
				?>
				<input 
                	type="button" 
                    id="moduleAddEditBtn" 
                    name="moduleAddEditBtn" 
                    value="<?php echo $addEditButtonValue;?>" 
                    onclick="blogCommentAddEditObj.addEditModule(this)"
                />
                <?php
			}
			else{
				?>
                <input 
                	type="button" 
                    id="moduleAddEditBtn" 
                    name="moduleAddEditBtn"
                    value="<?php echo $addEditButtonValue;?>" 
                    onclick="blogCommentAddEditObj.addEditModule(this)"
                />
				<?php
            }
		?>
								
	</form>	
</div>