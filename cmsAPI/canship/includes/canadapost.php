<?

/*

	require : MiniXMLDoc 

*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/minixml-1.3.8/minixml.inc.php" );



class CanadaPost extends common

{

	var

		$debug = false ,

		$error = false,
		$err_msg = "",
		$xml_request = "",
		$xml_response = "",
		$fp,  // socket handle

		$xml_response_tree = array(),
		$shipping_methods = array(),
		$shipping_comment = "" ,

		$to_city = "",
		$to_provState = "",
		$to_country = "",
		$to_postal_code = "";
	
	public $handlingFee = "";
	
public function __construct($isAjax){
		parent::__construct($isAjax);
	
		#front end module settings
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/settings/ecommerce/canadaPost/canadaPostSettings.php');
		$canadaPostSettingsObj = new canadaPostSettings(false);
		
		#get setting options and option values
		$canadaPostSettings= $canadaPostSettingsObj->getTableColumns();	
		$canadaPostSettingsValues = $canadaPostSettingsObj->getAllRecords();
		$y = mysqli_fetch_array($canadaPostSettingsValues);
		
		#dynamically create object properties based off our settings table
		while($x = mysqli_fetch_array($canadaPostSettings)) $this->$x["Field"] = $y[$x["Field"]];

		$this->_initRequestXML();

	}

	public function addItem( $quantity, $weight, $length, $width, $height, $description )	{

		#determine if the item is "ready to ship", or we need to determine what box to use
		if($this->readyToShip == 1){
			$readyToShip = "<readyToShip />";
		}
		else{
			$readyToShip = "";
		}

		$this->xml_request .= 
		"
		<item>
			<quantity>" . htmlspecialchars($quantity) . "</quantity>
			<weight>" . htmlspecialchars($weight) . "</weight>
			<length>" . htmlspecialchars($length) . "</length>
			<width>" . htmlspecialchars($width) . "</width>
			<height>" . htmlspecialchars($height) . "</height>
			<description>" . htmlspecialchars($description) . "</description>
			" . $readyToShip . "
		</item>
		";

	}
	
	public function	getQuote( $city, $provstate, $country, $postal_code ){
		$this->_shipTo( $city, $provstate, $country, $postal_code ) ;
		$this->_sendRequestXML();
		$this->_getResponseXML();
		return $this->_xmlToQuote() ;
	}

	

	public function _initRequestXML(){

		$this->xml_request = 

"<?xml version=\"1.0\" ?>

<eparcel>

	<language>en</language>

	<ratesAndServicesRequest>

		<merchantCPCID>" . $this->merchant_cpcid . "</merchantCPCID>

		<lineItems>" ;

#					<itemsPrice>" . $p->price * $qty . "</itemsPrice>

	}

	

	# if no Postal Code input, Canada Post will return statusCode 5000 and statusMessage "XML parsing error ".

	public function _shipTo( $city, $provstate, $country, $postal_code ){

		$this->to_city = $city ;

		$this->to_provState = $provstate;

		$this->to_country = $country ;

		$this->to_postal_code = $postal_code ;



		$this->xml_request .= 

"

		</lineItems>

"	.

( strlen($this->to_city) > 0  ? "<city>" . htmlspecialchars($this->to_city) . "</city>\n" : "" ) . 

( strlen($this->to_provState) > 0  ? "		<provOrState>" . htmlspecialchars($this->to_provState) . "</provOrState>\n" : "		<provOrState> </provOrState>\n" ) . 

( strlen($this->to_country) > 0  ? "		<country>" . htmlspecialchars($this->to_country) . "</country>\n" : "" ) . 

( strlen($this->to_postal_code) > 0  ? "		<postalCode>" . htmlspecialchars($this->to_postal_code) . "</postalCode>\n" : "		<postalCode> </postalCode>\n" ) . 

"

	</ratesAndServicesRequest>

</eparcel>

" ;

	}



	public function _sendRequestXML(){

		$this->fp = fsockopen ( $this->server, $this->port, $errno, $errstr, 30 );

		if (!$this->fp) {
    			die("Open Socket Error: $errstr ($errno)<br>\n");
				$this->error = true ;
				$this->error_msg = $errstr ;

		} else {
			fwrite( $this->fp, $this->xml_request );
		}

	}

	

	public function _getResponseXML(){

		if (!$this->fp) return ;
		while(!feof ($this->fp))
			$this->xml_response .= fgets( $this->fp, 4096 );
   		fclose($this->fp);

	}

	

	public function _xmlToQuote(){

		$startTag = 'eparcel/ratesAndServicesResponse/';
		$xd = new MiniXMLDoc( $this->xml_response );
		$this->statusCode = $this->fetchValue( $xd, $startTag . 'statusCode' ) ; 
		$this->statusMessage = $this->fetchValue( $xd, $startTag . 'statusMessage' ) ;
		$this->handlingFee = $this->fetchValue( $xd, $startTag . 'handling');

		$this->error = ( 'OK' == $this->statusCode ) ;
		$this->error_msg = $this->error ? $this->statusMessage : "" ;

		if( ! $this->error ) {
			$this->shipping_comment = $this->fetchValue( $xd, $startTag . 'comment' )  ;
			$shipping_fields = array( 

										"name", 
										"rate", 
										"shippingDate", 
										"deliveryDate", 
										"deliveryDayOfWeek",  
										"nextDayAM", 
										"packingID"
									);

			return $this->shipping_methods = $this->fetchArray( 

																$xd, 
																$startTag, 
																'product', 
																$shipping_fields 
															   ) ;

		}

	}

	

	function	fetchArray( &$xmldoc, $path, $tag, $fields ){

		$response =& $xmldoc->getElementByPath( $path );
		$children =& $response->getAllChildren();

		$count = 0 ;

		$array = array();
		for( $i = 0; $i < $response->numChildren(); $i++){
			if( $tag == $children[$i]->name() ){;
				foreach( $fields as $field ){
					$name = $children[$i]->getElement($field) ;
					$array[$count][$field] =$name->getValue();
				}
				$count ++ ;
			}
		}

		return $array ;

	}	

	

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

	function fetchValue( &$xmldoc, $path ){

			$e = $xmldoc->getElementByPath( $path );

			if(is_object($e)){

				return $e->getValue();

			}

			else{

				#could be bad shipping information, or products needs weights and dimensions

				die("Invalid shipping information. Please try again.");

			}

	}

}



	if(isset($_REQUEST["function"])){	

		$moduleObj = new CanadaPost(true);

		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}

?>