<?php
// api example
require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

function generateResponse() {

	$json = array();

	// add items to the json array
	// $json["item"] = "Hello World";

	return $json;
}

/* **********************************************
 *  START
 */

// begin JSON output

if(isApprovedOrigin()) {

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
	echo (getRequestOrigin()." not an allowed origin");
}

?>