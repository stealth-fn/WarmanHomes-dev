<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class purolator extends common{
		
		public $moduleTable = "settings_purolator";
		public $settingTable = "settings_purolator";

		public function __construct($isAjax){
			parent::__construct($isAjax);
			$this->setModuleSettings();
			
			#set properties depending if systme is dev or live
			if($this->isLive){
				$this->loginKey = $this->liveKey;
				$this->pass = $this->livePass;
				$this->location = "https://webservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx";
				$this->wsdlPath = $_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/ecommerce/shipping/purolator/Production/EstimatingService.wsdl";
				$this->billingAccount = $this->billingAccountLive;
				$this->senderPostalZip = $this->senderPostCodeLive;
				$this->senderName = $this->senderNameLive;
				$this->senderStreetNumber = $this->senderStreetNumberLive;
				$this->senderStreet = $this->senderStreetNameLive;
				$this->senderCity = $this->senderCityLive;
				$this->senderProvState = $this->senderProvStateLive;
				$this->senderCounty = $this->senderCountyLive;
				$this->senderPhoneNumber = $this->senderPhoneNumberLive;
				$this->defaultItemWeight = $this->defaultItemWeightLive;
			}
			else{
				$this->loginKey = $this->devKey;
				$this->pass = $this->devPass;
				$this->location = "https://devwebservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx";
				$this->wsdlPath = $_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/ecommerce/shipping/purolator/Development/EstimatingService.wsdl";
				$this->billingAccount = $this->billingAccountDev;
				$this->senderPostalZip = $this->senderPostCodeDev;
				$this->senderName = $this->senderNameDev;
				$this->senderStreetNumber = $this->senderStreetNumberDev;
				$this->senderStreet = $this->senderStreetNameDev;
				$this->senderCity = $this->senderCityDev;
				$this->senderProvState = $this->senderProvStateDev;
				$this->senderCounty = $this->senderCountyDev;
				$this->senderPhoneNumber = $this->senderPhoneNumberDev;
				$this->defaultItemWeight = $this->defaultItemWeightDev;
			}
		}
		
		public function createPWSSOAPClient() {
			/*Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
          	header information
			Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials*/
			$client = new soapclient(
				$this->wsdlPath, 
				array(
					'trace'	=>	true,
					'location' => $this->location,
					'uri' => "http://purolator.com/pws/datatypes/v1",
					'login' => $this->loginKey,
					'password' => $this->pass
				)
			);
			
			//Define the SOAP Envelope Headers
			$headers[] = new soapheader ( 
				'http://purolator.com/pws/datatypes/v1', 
				'RequestContext', 
				array(
					'Version'           =>  '1.3',
					'Language'          =>  'en',
					'GroupID'           =>  'xxx',
					'RequestReference'  =>  'Rating Example'
				)
			); 
			//Apply the SOAP Header to your client                            
			$client->__setSoapHeaders($headers);
			
			return $client;
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new purolator(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>