<?php
// api example
require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init
authorizeAPIcall(); // make sure the call to this script is authorized (if restricted to IP or apikey) - this is required if you want to authorize api requests by key or ip

/* ****************************************************************************
 *  GENERATE RESPONSE
 *
 *  All code to generate the the response array goes here. This function
 *  returns an array that is later encoded into json format when the script
 *  executes below.
 */

function generateResponse() {

	// code to generate a response goes here

	$json = array();

	// add items to the json array
	$json['title'] = "Example"; // create an array to be structured how you want the JSON data to be structured
	$json['your-ip'] = getRequestClient();
	$json['item'][] = "Hello World"; 
	$json['item'][] = "What's New?";
	$json['count'] = count($json['item']);

	return $json;
}

/* ****************************************************************************
 *  EXECUTE
 */

if ( isApprovedOrigin() ) {

	// call generateResponse from above
	$json = generateResponse();

	if(!debugOn()) {
		displayJSON($json);
	} else {
		displayHTMLdebugInfo($json);
	}
} else {
    displayJSONnotApprovedOrigin();
}

?>