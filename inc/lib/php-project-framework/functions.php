<?php

/*  ============================================================================================
    ********************************************************************************************

	PHP PROJECT FRAMEWORK developed by CHAD KLUCK | chadkluck.net
	github.com/chadkluck/php-project-framework

	inc/functions.php
	File Version: 20181011-1847

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
    ********************************************************************************************
0000	APPLICATION VARIABLE GETTER
	********************************************************************************************
*/

function getApp( $index = NULL ) {
	global $app;
	$r = NULL;

	if ( $index ) {
		if ( isset($app[$index]) ) {
			$r = $app[$index];
		}
	} else {
		$r = $app;
	}

	return $r;
}


/*  ============================================================================================
    ********************************************************************************************
0100    ACCESS, SECURITY, and DEBUGGING
	********************************************************************************************
		Use these functions to rapidly create logs, debugging output, and access restrictions

	============================================================================================
*/


/* **************************************************************************
 *  LOGGING
 */

function logMsg($entry) {
	global $app;

	if( debugOn() ) {
		$app['log']['event'][] = ["timestamp"=>microtime(true),"entry"=>$entry];
	}

}

function getLog($type="") {

	$log = array();

	if ($type==="") {
		$log = getApp('log');
	} else if (isset(getApp('log')[$type])) {
		$log = getApp('log')[$type];
	}

	return $log;
}

function logAPIrequest($url, $response="") {
	global $app;

	logMsg("API REQUEST: ".$url);

	if( debugOn() ) {
		$app['log']['api'][] = ["time"=>microtime(true),"url"=>$url,"response"=>$response];
	}
}

/* **************************************************************************
 *  EXECUTION TIME
 */


function setExeStartTime() {
	global $app;

	$app['start_time'] = microtime(true);
	logMsg("Starting app");
}

function setExeEndTime() {
	global $app;

	$app['end_time'] = microtime(true);
	$app['exe_time'] = $app['end_time'] - getApp('start_time');
}

/* **************************************************************************
 *  DEBUG
 */

function setDebugSwitch() {
	global $app;

	// if a user is an admin they are authorized and authenticated (through LMS) otherwise do security checks
	if( userIsAdmin() || (
		   getParameter("debug")
		   && getCfg('security')['allow-debug']
		   && preg_match(getCfg('security')['allow-debug-ip'], getRequestClient() ) === 1
		   && preg_match(getCfg('security')['allow-debug-host'], getRequestHost() ) === 1
		)
	  ) {
		$app['debug'] = true;
	}

	if (debugOn()) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		//getRequestClient(); // should already be set from call in if statement above
		//getRequestHost(); // should already be set from call in if statement above
		getRequestOrigin();
		$app['request']['header'] = apache_request_headers();

	} else {
		$app['log'][] = ["0","Debugging not enabled. To use log enable debugging"];
	}
}

function appExecutionEnd() {

	setExeEndTime();

	echo "<!-- Executed in ".getApp('exe_time')." seconds -->";

	if ( debugOn() ) {

		printDebugHTML();

	}

}

function debugOn() {

	return getApp('debug');
}

function printDebugHTML() {

	echo "<div id=\"debug-info\">\n\n";

	echo "<h3>App Diagnostics</h3>";
	echo "<pre>\n\n";

	echo "\n---------------------\nAPP\n\n";
	sanitized_print_r(getApp());

	echo "\n---------------------\nCFG\n\n";
	sanitized_print_r(getCfg());

	echo "\n---------------------\nPOST\n\n";
	sanitized_print_r($_POST);

	echo "\n---------------------\nGET\n\n";
	sanitized_print_r($_GET);

	echo "\n---------------------\nSESSION\n\n";
	if( isset($_SESSION) ) { sanitized_print_r($_SESSION); }

	echo "</pre>\n</div>\n";
}

/* **************************************************************************
 *  SANITIZE SECRETS WHEN PRINTING OUT IN DEBUG
 *
 *  We don't want to be printing our secret keys out when in debug mode.
 *  We aren't so worried about what is sent to the screen as presumably debug
 *  is locked down to an ip range, test server, etc, but if for troubleshooting
 *  purposes the code is copied and pasted or printed we want to be careful.
 */

// Takes a secret and returns the secret as well as an obfuscated version
function obfuscate_secret($secret) {
	$arr['secret'] = $secret;

	$x = 6;
	if(strlen($secret) <= $x) { // i would hope not...
		$x = round(strlen($secret) / 2);
	}

	$arr['obfuscated'] = "*******".substr($secret, -$x);

	return $arr;
}

// takes pre-established secrets and replaces their occurance
// now, we assume, and this could be bad, that all of our secrets are long
// random strings that wouldn''t naturally occur. For example if a secret
// key was "test" then whereever the string "test" occured it would replace
// it.
// Not only will this function replace things like [apiKey] => *******k9le1n
// but also if it shows up in places like urls:
// [url] => https://example.com/1.1/subjects/212?&key=*******k9le1n
// This only affects debug print_r, it does not really change any of the urls sent to apis and the like
// Of course, sanitized_print_r needs to be used instead of print_r for this to sanitize

function sanitized_print_r($param) {

	$sanitized = array(); // this will hold the value we print_r

	// if in the config obfuscate-secrets is true then perform sanitization
	if ( getCfg("security")['obfuscate-secrets']) {

		// establish secrets, what are we looking to redact?
		$secrets = getSecrets();


		// str_replace can take arrays for find/replace. find[0] will be replaced with replace[0], find[1] w/ replace[1], etc
		$find = array();
		$replace = array();

		// build our find/replace arrays
		$len = count($secrets); // how many secrets do we have?
		// we do a for instead of for each because we need an index anyway to keep find and replace array in sync
		for ($i=0; $i < $len; $i++) {
			if ( strlen($secrets[$i]) > 1 ) {
				$temp = obfuscate_secret($secrets[$i]);
				$find[$i] = $temp['secret']; // put the secret (what we are finding) into the find array
				$replace[$i] = $temp['obfuscated']; // put the sanitiezed secret into the replaace array
			}
		}

		// here's a neat trick: http://php.net/manual/en/function.str-replace.php#100871
		// convert array to string (in json format), do find/replace, then convert back to array
		$sanitized = json_decode(str_replace($find, $replace,  json_encode($param)), true);

	} else {
		// config obfuscate-secrets is set to false, so don't sanitize, pass it through
		$sanitized = $param;
	}

	print_r($sanitized);
}


/* **************************************************************************
 *  BROWSER CACHE AND ORIGIN
 */

function getCacheExpire($type = "page") {

	$t = 1; // we need an initial val so we set it debug mode's

	if(!debugOn()) {
		$t = getCfg('header')[$type.'-cache'];
	}

	return $t;
}

function isApprovedOrigin() {

	$originOK = false;
	$originOverride = false;
	$requestOK = false;

	$http_origin = getRequestOrigin();
	$client_ip = getRequestClient();

	if ( !isset(getCfg('header')['allow-origin']) || getCfg('header')['allow-origin'] === "" || ( preg_match(getCfg('header')['allow-origin'], $http_origin) === 1 ) ) {
		$originOK = true;
		logMsg("Origin OK");
	} else {
		logMsg("Origin NOT OK");
	}

	if ( getCfg('header')['bad-origin-allow-ip'] && ( preg_match(getCfg('header')['bad-origin-allow-ip'], $client_ip ) === 1 ) ) {
		$originOverride = true;
		logMsg("Origin CAN be overridden from this IP");
	} else {
		logMsg("Origin CANNOT be overridden from this IP");
	}

	if ($originOK || $originOverride) {
		$requestOK = true;
		logMsg("The request is OK");
	} else {
		logMsg("Request NOT OK");
	}

	return $requestOK;

}

function getRequestOrigin() {

	global $app;

	if( !isset($app['request']['origin'])) {
		$o = "";

		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "" ) {
			$url = $_SERVER['HTTP_REFERER'];
			$o = parse_url($url, PHP_URL_SCHEME) ."://".parse_url($url, PHP_URL_HOST);
			logMsg("HTTP_REFERER: ".$o);
		} else if (isset($_SERVER['HTTP_ORIGIN'])) {
			$o = $_SERVER['HTTP_ORIGIN'];
			logMsg("HTTP_ORIGIN: ".$o);
		} else   {
			logMsg("HTTP_ORIGIN: [not set]");
		}

		$app['request']['origin'] = $o;
	}

	return $app['request']['origin'];
}

function getRequestClient() {

	global $app;

	if( !isset(getApp('request')['client'])) {
		$c = "";

		// Get the public IP address of the client (browser)
		// if this service sits behind a load balancer,
		// have the load balencer server admin set up
		// X-Forwarded-For to pass along the IP address
		$h = apache_request_headers();
		if ( isset( $h['X-Forwarded-For'] )) {
			$c = $h['X-Forwarded-For'];
			logMsg("REMOTE_ADDR (FORWARDED FOR): ".$c);
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
			$c = $_SERVER['REMOTE_ADDR'];
			logMsg("REMOTE_ADDR: ".$c);
		} else {
			logMsg("REMOTE_ADDR: [not set]");
		}

		$app['request']['client'] = $c;
	}

	return getApp('request')['client'];
}

function getRequestHost() { //$_SERVER['REQUEST_URI'] $_SERVER['HTTP_HOST'] $_SERVER['SERVER_NAME']
	global $app;

	if( !isset(getApp('request')['host'])) {
		$c = "";

		if (isset($_SERVER['HTTP_HOST'])) {
			//https://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			$c = $protocol.$_SERVER['HTTP_HOST'];
			logMsg("HTTP_HOST: ".$c);

		} else {
			logMsg("HTTP_HOST: [not set]");
		}

		$app['request']['host'] = $c;
	}

	return getApp('request')['host'];
}




/* **************************************************************************
 *  SEND PAGE HEADERS
 */

function httpReturnHeader($cache, $origin = "", $contentType = "text/html; charset=utf-8") {

	// cache code from: https://www.electrictoolbox.com/php-caching-headers/
	$ts = gmdate("D, d M Y H:i:s", time() + $cache) . " GMT";
	header("Expires: ".$ts);
	header("Pragma: cache");
	header("Cache-Control: max-age=".$cache);

	// CORS
	if ($origin == "") {
		$origin = getRequestOrigin();
	}

	header("Access-Control-Allow-Origin: ".$origin);
	header("Content-type: ".$contentType);
}

/* **************************************************************************
 *  FORCE HTTPS - updated 2018-10-11
 *
 *  If the page wasn't requested via https, redirect to https
 *  
 */

function requireSSL() {

	$isHTTPS = false;

	// if this service sits behind a load balancer,
	// have the load balencer server admin set up
	// X-Forwarded-Port ("443") or X-Forwarded-Proto ("https") to pass along the protocal
	$h = apache_request_headers();
	if ( isset( $h['X-Forwarded-Port'] )) {
		$isHTTPS = $h['X-Forwarded-Port'] === "443" ? true : false;
	} else if ( isset( $h['X-Forwarded-Proto'] ) ) {
		$isHTTPS = $h['X-Forwarded-Proto'] === "https" ? true : false;
	} else if ( strtolower($_SERVER["HTTPS"]) === "on" ) {
		$isHTTPS = true;
	} else if ( $_SERVER['SERVER_PORT'] === 443 ) {
		$isHTTPS = true;
	}

	if( !$isHTTPS )
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}

}

/*  ============================================================================================
    ********************************************************************************************
0300    PARAMETER HANDLING FROM GET/POST/SESSION
	********************************************************************************************
*/

/* **************************************************************************
 *  GET/POST/SESSION PARAMETERS
 */

function getParameter($param, $method = "") {

	$method = strtoupper($method);

	//$p = "";
	$p = NULL;

	// order is important, we want to use any new values passed (GET/POST) before going into saved (SESSION) values

	if       ( ( $method === "GET"     || $method === "") && isset($_GET[$param]) ) {

		$p = $_GET[$param];

	} elseif ( ( $method === "POST"    || $method === "") && ( getApp('param_prefix') && isset($_POST[getApp('param_prefix').$param]) ) ) {

		$p = $_POST[getApp('param_prefix').$param];

	} elseif ( ( $method === "POST"    || $method === "") && isset($_POST[$param]) ) {

		$p = $_POST[$param];

	} elseif ( ( $method === "SESSION" || $method === "") && isset($_SESSION[$param]) ) {

		$p = $_SESSION[$param];

	}

	return $p;
}

function setSessionParam( $pName, $value ) {
	if ( session_id() !== "" ) {
		$_SESSION[$pName] = $value;
	}
}



/*  ============================================================================================
    ********************************************************************************************
0400    GET DATA FROM JSON OR XML and RETURN AS ARRAY
	********************************************************************************************

		Functions to help with JSON data

	============================================================================================
*/

/* *************************************************************
 *  GET DATA from JSON FORMAT and RETURN AS ARRAY
 *  For APIs that return JSON data
 *  LibGuide API and Alma API functions use this
 */

function getDataFromJSON($url) {
	$results = array();

	try {
		$contents = @file_get_contents($url); // suppress warnings
		$results = json_decode($contents, true);
		logAPIrequest($url,$results);
	} catch (Exception $e) {
		logMsg("Caught exception: ". $e->getMessage());
		logAPIrequest($url,["Exception Caught"]);
	}

	return $results;
}

/* *************************************************************
 *  GET DATA from XML FORMAT and RETURN AS ARRAY
 *  For APIs that return XML data
 *  Alma API functions use this
 */

function getDataFromXML($url) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$response = curl_exec($ch);
	curl_close($ch);

	$xml = simplexml_load_string($response);
	$json = json_encode($xml);
	$results = json_decode($json,TRUE);

	logAPIrequest($url,$results);

	return $results;
}

/*  ============================================================================================
    ********************************************************************************************
0500    VARIABLE EVALUATORS
	********************************************************************************************
*/

/* **************************************************************************
 *  DOES THE VARIABLE HAVE DATA?
 *
 *  Can be used as if (hasData($v)) rather than if ($v !== NULL && $v !== "" )
 *  also handles arrays
 */
function hasData( $var ) {

	$r = false;

	if ( is_array( $var )  ) {
		if ( count($var) > 0 ) {
			$r = true;
		}
	} else if ( $var !== NULL && $var !== "" ) {
		$r = true;
	}

	return $r;
}

/* **************************************************************************
 *  Is it a valid URL?
 */

function isURL($var) {
	return preg_match("/^(?>http(?>s)?:)?\/\//i", $var);
}

/* *************************************************************
 *  Evaluate Bool Parameter
 *
 *  A parameter from a GET or POST or even form could be true or empty
 *  which doesn't give room for true, false, or empty as when a variable
 *  in PHP is set to false, it is set to empty. How do we distinguish a
 *  variable that is empty (not passed) from one that is false?
 *  So any parameter that could be true, false, or empty should use this
 *  method.
 *
 *  Just remember, in PHP 0, 0.0, "", "0", NULL are false. Everything else is true
 *
 *  Returns -1 (not set), 0 (false), 1 (true)
 */

function boolParamEval( $param, $method = "" ) {
	$r = -1; // not set === ""

	$pVal = getParameter( $param, $method ); // get the value of the parameter

	if ( $pVal !== NULL && $pVal !== "" ) {
		if ( $pVal && strtolower($pVal) !== "false") { // if it evaluates as TRUE
			$r = 1; // true
		} else {
			$r = 0; // false
		}
	}

	return $r; // returns -1|0|1
}

/* *************************************************************
 *  Evaluate the parameter as True, False, or Empty
 */
function boolParamIsTrue( $param, $method = "" ) {
	return (boolParamEval( $param, $method ) === 1); // returns true/false
}

function boolParamIsFalse( $param, $method = "" ) {
	return (boolParamEval( $param, $method ) === 0); // returns true/false
}

function boolParamIsEmpty( $param, $method = "" ) {
	return (boolParamEval( $param, $method ) === -1); // returns true/false
}

function boolParamIsEqualTo( $param, $value, $method = "") {
	$rVal = false;
	$pVal = boolParamEval( $param, $method );

	if ( $pVal !== -1 ) {
		$rVal = ( (boolean) $pVal === (boolean) $value );
	}

	return $rVal;

}

?>