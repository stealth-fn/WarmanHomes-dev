<?php

#Postal Code
if ( array_key_exists( "Postal Code", $priModObj[ 0 ]->domFields ) ) {

	$priModObj[ 0 ]->domFields[ "postalCode" ] =
		'<div 
			class="postalCode' . $priModObj[ 0 ]->className . '"
			id="postalCode' . $priModObj[ 0 ]->className . '_' . $priModObj[ 0 ]->queryResults[ "priKeyID" ] . '"

		>' . $priModObj[ 0 ]->queryResults[ "postalCode" ] . '</div>';

}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["postalCode"] = "";
}

?>