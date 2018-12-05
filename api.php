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
	// $json["item"] = "Hello World";

	return $json;
}

/* ****************************************************************************
 *  EXECUTE
 */

if ( isApprovedOrigin() ) {

	// call generateResponse from above
	$json = generateResponse();

	if(!debugOn()) {

		httpReturnHeader(getCacheExpire("api"), getRequestOrigin(), "application/json");
		echo json_encode($json);

	} else {
		echo "<h3>JSON RAW</h3>";
		echo "<p>";
		echo json_encode($json);
		echo "</p>";
		echo "<h3>JSON FORMATTED</h3>";
		echo "<pre>";
		print_r($json);
		echo "</pre>";
		appExecutionEnd();
	}

} else {
	returnNotApprovedOrigin();
}

?>