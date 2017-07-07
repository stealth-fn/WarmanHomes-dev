<?
require_once( "./include.php" );

$cp = new CanadaPost() ;
$cp->addItem( $quantity = 1 , $weight = 1.5 , $length = 30 , $width = 30 , $height = 30 , $description = "Item Testing" ) ;
$cp->getQuote( $city = "Vancouver", $provstate = "British Columnbia", $country = "Canada", $postal_code = "V5Y2K2" );

//var_dump( $cp );

if( ISDEBUG ){
	print "<form action='http://" . CP_SERVER . ":" . CP_PORT . "' method='post' target='_blank' >\n" ;
	print "<h1>Request XML</h1>" ;
	print "<textarea name='XMLRequest' style='width:100%;height:400px;background-color:#f2f2f2'>\n" . htmlspecialchars($cp->xml_request) . "\n\n</textarea><br><input type='submit' value='Send to Canada Post'>" ;
	print "</form>\n" ;

	print "<hr>\n\n\n" ;
	print "Return XML From Canada Post:<br><form><textarea style='width:100%;height:400px;background-color:#f2f2f2'>\n" . htmlspecialchars($cp->xml_response) . "\n\n</textarea></form>";
	
}	


?>