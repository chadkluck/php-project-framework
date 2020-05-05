<?php
// api example
require_once __DIR__."/inc/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

function generateResponse() {
    $response = array();
    $response['status'] = "OK";
    $response['items'] = array( "hello world", "HELLO WORLD!", "Hello, World!");

    return $response;
}

/* **********************************************
 *  START
 */

// begin JSON output

if(isApprovedOrigin(TRUE)) {

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

}

?>