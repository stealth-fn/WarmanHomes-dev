<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class login extends common{
		public $moduleTable = "login";
		public $instanceTable = "instance_login";
		
		public function __construct($isAjax,$pmpmID=1){		
			
			#when we setup the login forms....
			if(gettype($pmpmID) === "array"){
				$tempPmpmID = $pmpmID["priKeyID"];
			}
			#when a user signs in....
			else{
				$tempPmpmID = $pmpmID;
			}
			
			#in this case, the pmpmID is hashed
			if(isset($_SESSION["loginInstances"][$tempPmpmID])) {
				parent::__construct(
					$isAjax,$_SESSION["loginInstances"][$tempPmpmID]["loginInstance"]
				);
			}
			else{
				parent::__construct($isAjax,$pmpmID);
			}
				
			$this->moduleSettings["formValidationCode"] = $this->generateFormValidation(
				"moduleForm",$this->moduleSettings["validateFields"]
			);

			if(!$this->ajax){
				$this->loginInstance = $this->createLoginInstance();
			}
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
			$this->publicUsersObj = new publicUsers(false,NULL);
			
		}
		
		#Create a unique challenge value for challenge/response form validation (login, etc.) Default expiry is 1 year...(
		public function createLoginInstance($expires=null,$expireOld=false){
			if(is_null($expires))$expires = 60*60*24*7*52;
			#unset any expired instances (older than $expires)
			if(isset($_SESSION["loginInstances"])){
				foreach($_SESSION["loginInstances"] as $key => $value){
					if(time() > $value["expires"]){
						unset($_SESSION["challenge"][$key]);
					}
				}
			}
			$instance =  hash("sha256",session_id() . rand(0,10));
			#store it
			$_SESSION["loginInstances"][$instance] = array(
				"expires"=>time() + $expires,
				"loginInstance"=>$this->priKeyID
			); 
			return $instance;
		}
		
		public function checkUser($user, $response, $loginInstance){
			if(!isset($_SESSION))session_start();
			
			if($this->ajax){
				$this->priKeyID = $_SESSION["loginInstances"][$loginInstance]["loginInstance"];

				//$this->getMapSettings(); //Need to refetch the settings for the right instance.
				$this->loginInstance = $this->createLoginInstance();
			}
			
			$pageID = $this->loginPageID;
			#Check to see if a challenge exists for the response
			if(isset($_SESSION["loginInstances"][$loginInstance])){
			
				$result = $this->publicUsersObj->getConditionalRecord(
					array("loginName",$user,true, "isActive","1",true)
				);
				
				# If we found an active user with the specified username	
				if(mysqli_num_rows($result) > 0){ 
					$x = $this->publicUsersObj->processRecord($result);
					#What to expect if the password is hashed in the db
					$expectedEnc = strtolower($x['loginName']).":".$x['loginPassword']; 
					#What to expect if the password is not hashed in the db
					$expected = strtolower($x['loginName']).":".$this->encString('',$x['loginPassword']); 

					#Check to see if the response matches.
					if(
						$response ==  $this->encString('',$expected) || 
						$response ==  $this->encString('',$expectedEnc)
					){ 
						#If the password currently stored is stored in plaintext, hash it for security purposes.
						if($response ==  $this->encString('',$expected)){ 
							#Hash the password
							$x['loginPassword'] = $this->encString('',$x['loginPassword']); 
							#Update the record in the db
							$this->publicUsersObj->updateRecord($x); 
						}
						$_SESSION['loggedIn'] = 1;
						$_SESSION['sessionSecurityLevel'] = ($x['isAdmin']) ? 3 : 1;
						
						#put user info into session variables to pre-populate fields
						$_SESSION["userID"] = $x["priKeyID"];
						$_SESSION["loginName"] = $x["loginName"];	
						$_SESSION["firstName"] = $x["firstName"];
						$_SESSION["lastName"] = $x["lastName"];
						$_SESSION["homePhone"] = $x["homePhone"];
						$_SESSION["cellPhone"] = $x["cellPhone"];
						$_SESSION["workPhone"] = $x["workPhone"];
						$_SESSION["fax"] = $x["fax"];
						$_SESSION["email"] = $x["email"];
						$_SESSION["address"] = $x["address"];
						$_SESSION["city"] = $x["city"];
						$_SESSION["provState"] = $x["provState"];
						$_SESSION["postalZip"] = $x["postalZip"];
						$_SESSION["country"] = $x["country"];
						$_SESSION["company"] = $x["company"];
						$_SESSION["jobTitle"] = $x["jobTitle"];
						$_SESSION["isGuest"] = $x["isGuest"];
						
						#determine what user group this user belongs to, and the login page for it
						$userGroupMappingArray = array(
							array("INNER JOIN","public_user_group_map","public_users","publicUserID","priKeyID"),
							array("INNER JOIN","public_user_groups","public_user_group_map","priKeyID","publicUserGroupID")
						);
						
						$tempUserGroup = $this->publicUsersObj->getConditionalRecord(
							array("public_users.priKeyID", $_SESSION['userID'], true),
							$userGroupMappingArray
						);
						$tug = mysqli_fetch_assoc($tempUserGroup);
						
						#if they were trying to go a memebers only page, go there after login
						if(isset($_SESSION["desiredPage"]) && is_numeric($_SESSION["desiredPage"])){
							$loginPageID = $_SESSION["desiredPage"];
						}
						#otheruse go to the default login page
						else{
							$loginPageID = $tug["loginPageID"];
						}

						unset($_SESSION["desiredPage"]);
						
						#put our user group ID's into a session variable as an array
						$groupStr = $this->getQueryValueString($tempUserGroup,"publicUserGroupID",",");
						$_SESSION['userGroupIDs'] = explode(",",$groupStr);

						$result = array(
							"login_status"=>"1",
							"instance"=>$this->priKeyID,
							"loginPageID"=>$loginPageID
						);
						
						if($x["isGuest"]) {
							$this->publicUsersObj->removeRecordByID($x["priKeyID"]);
						}
					}
					else{
						#Password/Username combination incorrect
						$result = array("login_status"=>"-1"); 
					}
				}
				else{
					#Username not found
					$result = array("login_status"=>"-1"); 
				}
			}
			else{
				#Instance has expired/does not exist
				$result = array("login_status"=>"-2");
			}
			if($this->ajax) echo json_encode($result);										
			else return $result;		
		}
				
		public function createLoginForm($urlParams="",$clearChallenges=false){		
			$loginForm = '
			<form
				action="#"
				class="lf lif lif-' . $this->className . $this->queryResults["priKeyID"] . '"
				id="lif-' . $this->className . $this->queryResults["priKeyID"] . '" 
				name="lif-' . $this->className . $this->queryResults["priKeyID"] . '"  
				onsubmit="' . $this->className . $this->queryResults["priKeyID"] . '.publicLogin(\'' . $urlParams . '\',$s(\'lbp-' . $this->className . $this->queryResults["priKeyID"] . '\'));return false;"
			>
				<div>
					<label for="username_'.$this->className . $this->queryResults["priKeyID"].'"></label>
					<input 
						value="Username" 
						type="text" 
						id="username_'.$this->className . $this->queryResults["priKeyID"].'" 
						onfocus="clearField(this)" 
						onblur="backToDefault(this)" 
						name="username" 
						size="40" 
						maxlength="40"
					/>
				</div>
				<div>
					<label 
						for="password_' . $this->className . $this->queryResults["priKeyID"] . '"
					>
					</label>
					<input 
						type="password" 
						id="password_' . $this->className . $this->queryResults["priKeyID"] . '"
						name="password" 
						size="40" 
						maxlength="64"
						placeholder="' . $this->languageLabels[$_SESSION["lng"]]['passwordPlaceholder'] . '"
					/>
				</div>
				<input
					class="sb lbp"
					id="lbp-' . $this->className . $this->queryResults["priKeyID"] . '" 
					onclick="'.$this->className . $this->queryResults["priKeyID"].'.publicLogin(\'' . $urlParams . '\',this);"
					type="button"
					value="'.$this->loginBtnText.'"
				/>
				<input 
					type="submit" 
					style="display: none;position: absolute;z-index: -1;" 
				/>
                <input 
                	type="hidden" 
                	name="pmpmID" 
                	value="'.$this->loginInstance.'" 
                />
			</form>';
			
			#Password reset field
			if(array_key_exists("pswdrst",$this->domFields)){ 
				#put child module into output buffer
				ob_start();
				#we just have this permanently set in the public_module_page_map
				$recursivePmpmID = -25;
				include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
				$loginForm .= ob_get_contents();
				ob_end_clean();
			}
 					
			return $loginForm;	
		}
		
		public function createSignOutForm($username=null){
			$username || $username = $_SESSION['firstName'];
			$signOutBox = '
			<form
				action=""
				class="lf lof lof-' . $this->className . $this->queryResults["priKeyID"] . '"
				id="lof-' . $this->className . $this->queryResults["priKeyID"] . '" 
				name="lof-' . $this->className . $this->queryResults["priKeyID"] . '"  
				onsubmit="'.$this->className . $this->queryResults["priKeyID"].'publicLogOut(\''.$this->loginInstance.'\');return false;"
			>
				<div class="lw" id="lw-'.$this->className . $this->queryResults["priKeyID"].'">'.$username.'</div>
				<input
					class="sb lbp"
					id="lbp-' . $this->className . $this->queryResults["priKeyID"] . '" 
					onclick="'.$this->className . $this->queryResults["priKeyID"].'.publicLogOut();"
					type="button"
					value="'.$this->logoutBtnText.'"
				/>
				<input type="submit" style="display: none;position: absolute;z-index: -1;" />
			</form>';
			return $signOutBox;				
		}
		
		public function logOut($loginInstance){
			if(!isset($_SESSION)) session_start();

			if($this->ajax){
				//$this->getMapSettings(); //Need to refetch the settings for the right instance.
				$this->loginInstance = $this->createLoginInstance();
			}
			
			try{
				//Unset logged in variable to ensure that they are completely logged out	
				$_SESSION['loggedIn'] = 0;
				unset($_SESSION['loggedIn']);
				
				$_SESSION['sessionSecurityLevel'] = 0;
	
				unset($_SESSION['userID']);
				unset($_SESSION['loginName']);
				unset($_SESSION['firstName']);
				unset($_SESSION['lastName']);
				unset($_SESSION['homePhone']);
				unset($_SESSION['cellPhone']);
				unset($_SESSION['workPhone']);
				unset($_SESSION['fax']);
				unset($_SESSION['email']);
				unset($_SESSION['address']);
				unset($_SESSION['city']);
				unset($_SESSION['provState']);
				unset($_SESSION['postalZip']);
				unset($_SESSION['country']);
				unset($_SESSION['company']);
				unset($_SESSION['jobTitle']);
				unset($_SESSION['userGroupIDs']);
				
				#if an order was in the middle of being edited and the user logs out 
				#unset the edit
				if(isset($_SESSION["editOrder"])){
					unset($_SESSION['editOrder']);
				}
				 
				$loginBox = array(
					"login_status"=>1
				);
			}
			catch (Exception $e){
				$loginBox = array("login_status"=>-1);
			}
			if($this->ajax) echo json_encode($loginBox);
			else return $loginBox;
		}

	}

	#requires and instanceID when we're doing and add/edit, for now this is retrieved from the form
	if(isset($_REQUEST["function"])){
		$moduleObj = isset($_REQUEST["pmpmID"]) ? new login(true,$_REQUEST["pmpmID"]) : new login(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = isset($_REQUEST["pmpmID"]) ? new login(true,$_REQUEST["pmpmID"]) : new login(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>