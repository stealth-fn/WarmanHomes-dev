<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class publicUsers extends common{
		public $moduleTable = "public_users";
		public $instanceTable = "instance_public_users";
		protected $addDefault = array();
		protected $updateDefault = array();
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax, $pmpmID);
			
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "publicUserID";
			$this->mappingArray[0]["fieldName"] = "publicUserGroupID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php";
			
			if(isset($this->isGuestInstance) && $this->isGuestInstance == 1) {
				$this->addDefault['isGuest'] = 1;
				$this->updateDefault['isGuest'] = 1;
			}
			
			$this->addDefault['memberSince'] = "dateStamp";
			$this->updateDefault['lastLogin'] = "dbSet";
			
			#determine which field list to use based on if its an admin or not making changes
			if(isset($_SESSION['sessionSecurityLevel']) && 
				$_SESSION['sessionSecurityLevel'] == 3
			){}
			else{
				$this->addDefault["priKeyID"] = "publicUser";
				$this->updateDefault["priKeyID"] = "publicUser";
				
				$this->addDefault["isAdmin"] = "dbSet";
				$this->updateDefault["isAdmin"] = "dbSet";
								
				#check to see if users are allowed to create profiles without admin approval
				#$this->selfAddPubUser is only set if we are using an instance object
				if(isset($this->selfAddPubUser) &&  $this->selfAddPubUser == 1){
					$this->addDefault["isActive"] = "defaultOn";
					$this->updateDefault["isActive"] = "defaultOn";
				}
				else {
					$this->addDefault["isActive"] = "dbSet";
					$this->updateDefault["isActive"] = "dbSet";
				}
			}
			
			if(isset($this->defaultGalleryID)) {
				$this->addDefault["imageGalleryID"] = $this->defaultGalleryID;
				$this->updateDefault["imageGalleryID"] = $this->defaultGalleryID;
			}
			
			if(isset($this->autoLogin)) {
				$this->addDefault['lastLogin'] = "dateStamp";
				$this->updateDefault['lastLogin'] = "dateStamp";
			}
		}
		
		#check the account parameters are available, ex user/pass	
		public function checkAccountAvail($field, $val){
			#need object without ajax return				
			$this->ajax = false;
			$avail = $this->getConditionalRecord(
				array($field,$val,true)
			);
				
			if(mysqli_num_rows($avail) > 0) {
				echo "1";
			}
			else { 
				echo "0";
			}
		}
		
		public function notifyAdmin($newUserID){			
			include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/cmsSettings.php');
			$publicUsersObj = new publicUsers(false);
			$userInfo = $publicUsersObj->getRecordByID($newUserID);
			$x = mysqli_fetch_assoc($userInfo);
			
			#If not guest
			if ($x["isGuest"] != 1 ) {	
				$message = "
				<html>
					<head>
						<title>Public User Registration</title>
					</head>
					<body>
						<p>A new user has requested to be added. The information is provided below</p>
						<table>
							<tbody>
								<tr><td>Public User ID</td><td>" . $x["priKeyID"] . "</td></tr>
								<tr><td>User Name</td><td>" . $x['loginName'] . "</td></tr>
								<tr><td>First Name</td><td>" . $x["firstName"] . "</td></tr>
								<tr><td>Last Name</td><td>" . $x["lastName"] . "</td></tr>
								<tr><td>Home Phone</td><td>" . $x["homePhone"] . "</td></tr>
								<tr><td>Cell Phone</td><td>" . $x["cellPhone"] . "</td></tr>
								<tr><td>Work Phone</td><td>" . $x["workPhone"] . "</td></tr>
								<tr><td>Fax</td><td>" . $x["fax"] . "</td></tr>
								<tr><td>Email</td><td>" . $x["email"] . "</td></tr>
								<tr><td>Address</td><td>" . $x["address"] . "</td></tr>
								<tr><td>City</td><td>" . $x["city"] . "</td></tr>
								<tr><td>Province/State</td><td>" . $x["provState"] . "</td></tr>
								<tr><td>Postal/Zip</td><td>" . $x["postalZip"] . "</td></tr>
								<tr><td>Country</td><td>" . $x["country"] . "</td></tr>
								<tr><td>Company</td><td>" . $x["company"] . "</td></tr>
							</tbody>
						</table>
					</body>
				</html>";			

				$to = $_SESSION["adminEmail"];
				$siteName =  $_SESSION["siteName"];

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= "From: " . $siteName;

				$subject = "Public User Notification From " . $siteName;

				mail($to, $subject, $message, $headers);

				$publicUsersObj->notifyUser($newUserID);	
			}
		}
		
		public function notifyUser($publicUserID){		
			include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/cmsSettings.php');
			$publicUsersObj = new publicUsers(false,NULL);
			$userInfo = $publicUsersObj->getRecordByID($publicUserID);
			$x = mysqli_fetch_assoc($userInfo);
				
			#If not guest
			if ($x["isGuest"] != 1 ) {	
				$message = "
				<html>
					<head>
						<title>" . $_SESSION["siteName"] . " Registration</title>
					</head>
					<body>
						<p>You have become a registered member on " . $_SESSION["siteName"] . "</p>
						<table>
							<tbody>
								<tr><td>Public User ID</td><td>" . $x["priKeyID"] . "</td></tr>
								<tr><td>User Name</td><td>" . $x['loginName'] . "</td></tr>
								<tr><td>First Name</td><td>" . $x["firstName"] . "</td></tr>
								<tr><td>Last Name</td><td>" . $x["lastName"] . "</td></tr>
								<tr><td>Home Phone</td><td>" . $x["homePhone"] . "</td></tr>
								<tr><td>Cell Phone</td><td>" . $x["cellPhone"] . "</td></tr>
								<tr><td>Work Phone</td><td>" . $x["workPhone"] . "</td></tr>
								<tr><td>Fax</td><td>" . $x["fax"] . "</td></tr>
								<tr><td>Email</td><td>" . $x["email"] . "</td></tr>
								<tr><td>Address</td><td>" . $x["address"] . "</td></tr>
								<tr><td>City</td><td>" . $x["city"] . "</td></tr>
								<tr><td>Province/State</td><td>" . $x["provState"] . "</td></tr>
								<tr><td>Postal/Zip</td><td>" . $x["postalZip"] . "</td></tr>
								<tr><td>Country</td><td>" . $x["country"] . "</td></tr>
								<tr><td>Company</td><td>" . $x["company"] . "</td></tr>
							</tbody>
						</table>
					</body>
				</html>";
				$siteName = $_SESSION["siteName"];
				$to = $x["email"];

				$subject = "Registration Notification from " . $siteName;			
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= "From: " . $siteName;

				mail($to, $subject, $message, $headers);
			}
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new publicUsers(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new publicUsers(true, $_REQUEST["pmpmID"]);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>