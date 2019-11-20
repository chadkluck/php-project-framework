<?php
/*  
	===========================================================================
	***************************************************************************

	PHP PROJECT FRAMEWORK developed by CHAD KLUCK | chadkluck.net
	github.com/chadkluck/php-project-framework

	php-project-framework/functions.php
	File Version: 20191118-2230

	***************************************************************************
	===========================================================================
*/

/*
	***************************************************************************
	---------------------------------------------------------------------------
	APPLICATION VARIABLE GETTER
	---------------------------------------------------------------------------
	***************************************************************************
*/

/**
 * There is a global, multi-dimensional, associative array $app in which values
 * essential to execution of the application may be stored. Rather than adding 
 * "global $app" to each function you wish to use it in, and to produce shorter
 * variable names, you can create a reference to the app variable.
 * 
 * Note that using this function creates a _reference_ to the $app variable. 
 * After setting a local variable (such as $c in the examples below) you can
 * update $app by merely updating $c.
 * 
 * $x = getApp() is the same as $x = &$app
 * 
 * Only the index of the top level of the array is passed to the function. 
 * For example, if $app consists of 
 * 	 {"lights": {"livingroom": {}, "kitchen": {}}, "outlets": {}, "fans": {}} 
 * and "lights" is passed to getApp, then a reference to 
 *   {"lights": {"livingroom": {}, "kitchen": {} }}
 * will be passed back. To obtain child or grandchild elements of "lights" the
 * array indicies may be placed after the function: getApp("lights")['kitchen'];
 * 	
 * For example:
 * $x = getApp(); // will create a reference to the whole $app array
 * $a = getApp("lights"); // will create a reference to $app['lights']
 * $b = getApp("lights")['kitchen']; // will create a reference to $app['lights']['kitchen']
 * $c = getApp("lights")['kitchen']['sink']; // will create a reference to $app['lights']['kitchen']['sink']
 * $c = TRUE; // will set $app['lights']['kitchen']['sink'] equal to TRUE as $c is a reference to this.
 * 
 * Watch out!
 * $g = getApp("lights")['bathroom'];
 * $g = getApp("lights")['kitchen']; // will set $app['lights']['bathroom'] to ['kitchen']!
 *  
 * Use unset($g)
 * $g = getApp("lights")['bathroom'];
 * unset($g); // do this before changing what $g references!
 * $g = getApp("lights")['kitchen'];
 * 
 * Make sure you have a proper understanding of references in PHP before
 * setting values.
 * https://www.phpreferencebook.com/samples/php-pass-by-reference/
 * 
 * @param String $index (optional) Name of the top level index you wish to access in $app. If not included a reference to the entire $app will be returned
 * @return Mixed A reference to the element requested. NULL will be returned if the index does not exist
 * 	
 */
function getApp( $index = NULL ) {
	global $app;
	$r = NULL;

	if ( $index ) { // an index was supplied
		if ( isset($app[$index]) ) { // if the index is set, we'll return it
			$r = &$app[$index];
		}
	} else {
		$r = &$app; // we'll return the whole thing
	}

	return $r;
}


/*
	***************************************************************************
	---------------------------------------------------------------------------
	ACCESS, SECURITY, and DEBUGGING
	---------------------------------------------------------------------------

	Use these functions to rapidly create logs, debugging output, and access 
	restrictions

	***************************************************************************
*/

/* 
	***************************************************************************
	LOGGING
	***************************************************************************
 */

/**
 * logMsg($message [, $dataArray])
 *
 * May be used by developers to add messages to a log while in debugging mode.
 * Of all the log options this is the simplist, writing to only the "event"
 * log.
 *
 * A log is only kept while in debug mode (see DEBUG MODE). Each entry is
 * stored as an element in an array and contains a timestamp, text message,
 * and an optional data array.
 *
 * The optional $dataArray is useful when you want to record structured data
 * along with a text string describing it.
 *
 * The log may be accessed using getLog("event")
 *
 * @see getLog()
 * @see logAPIrequest()
 * @see logError()
 * @see logEntry()
 * @see setDebugSwitch()
 *
 * @param String $message The text of the message to log
 * @param Array $dataArray Optional. Any associated array data to log
 */
function logMsg($message, $dataArray = array() ) {

	logEntry($message, "event", $dataArray);

}

/**
 * logAPIrequest($url [, $response])
 *
 * May be used by developers to add API calls to a log while in debugging mode.
 * This also writes a copy to the "event" log.
 *
 * A log is only kept while in debug mode (see DEBUG MODE). Each entry is 
 * stored as an element in an array and contains a timestamp, url, and an 
 * optional response data array. Note that logMsg() does not need to be called 
 * separately. Everything sent to this function is also added to the "event" 
 * log.
 *
 * The log may be accessed using getLog("api")
 *
 * @see getLog()
 * @see logMsg()
 * @see logError()
 * @see logEntry()
 * @see setDebugSwitch()
 *
 * @param string $url The URL of the request
 * @param array $response Optional. Any associated array data to log
 */
function logAPIrequest($url, $response = array()) {
	logMsg("API REQUEST: ".$url, $response);
	logEntry($url, "api", $response);
}

/**
 * logError($message [, $dataArray])
 *
 * May be used by developers to add error logs to the application's log data while in debugging
 * mode. This also writes a copy to the "event" log.
 *
 * A log is only kept while in debug mode (see DEBUG MODE). Each entry is stored as an element
 * in an array and contains a timestamp, message, and an optional data array. Note that
 * logMsg() does not need to be called separately. Everything sent to this function is also
 * added to the "event" log.
 *
 * The log may be accessed using getLog("error")
 *
 * @see getLog()
 * @see logMsg()
 * @see logAPIrequest()
 * @see logEntry()
 * @see setDebugSwitch()
 *
 * @param string $message The text of the message to log
 * @param array $dataArray Optional. Any associated array data to log
 */
function logError($message, $dataArray = array()) {
	logMsg("ERROR: ".$message, $dataArray);
	logEntry($message, "error", $dataArray);
}

/**
 * logEntry($message, $type [, $dataArray])
 *
 * May be used by developers to add custom logs to the application's log data while in debugging
 * mode.
 *
 * A log is only kept while in debug mode (see DEBUG MODE). Each entry is stored as an element
 * in an array and contains a timestamp, message, and an optional data array.
 *
 * Three default sets of logs may be kept: "event", "api", and "error". This function allows for
 * custom log types to be kept as well. However, it is advised that the main 3 types be used
 * instead as over-customization can lead to confusing code.
 *
 * Also, since this function is used by logMsg(), logAPIrequest(), and logError() to log their
 * events this does not create an entry for "event" and by directly using this function you will
 * loose the double entry capability.
 *
 * However...
 *
 * _If you do code_ for custom types it is recommended that you use logError() and logAPIrequest()
 * as a template and place your custom logging function in your functions-app.php or functions-custom.php file:
 *
 *  // code from logError() function
 *	function logError($message, $dataArray = array()) {
 *		logMsg("ERROR: ".$message, dataArray);
 *		logEntry($message, "error", $dataArray);
 *	}
 *
 * For example, if you were logging foo:
 *
 *  // example code to log foo
 *	function logFoo($message, $dataArray = array()) {
 *		logMsg("FOO: ".$message, dataArray);
 *		logEntry($message, "foo", $dataArray);
 *	}
 *
 * Or if you were logging something complex:
 *
 *  // example code to log a foo bar request and the data array to organize multiple pieces of data
 *	function logFooBarRequest($requestID, $foo, $bar, $ack) {
 *		$dataArray = array();
 *		$dataArray['foo'] = $foo;
 *		$dataArray['bar'] = $bar;
 *		$dataArray['ack'] = $ack;
 *
 * 		logMsg("Foo Bar for Request ID: ".$requestID, $dataArray);
 *		logEntry($requestID, "foobar", $dataArray);
 *	}
 *
 * In the above example note that you could keep a running log which you can then come back
 * and match IDs with corresponding entries.
 *
 * The log may be accessed using getLog($type)
 *
 * @see getLog()
 * @see logMsg()
 * @see logError()
 * @see logAPIrequest()
 * @see logEntry()
 * @see setDebugSwitch()
 *
 * @param String $message The text of the message to log
 * @param String $type The log to add the entry to
 * @param Array $data Optional. Any associated data to log
 */
function logEntry($message, $type, $data = "" ) {

	global $app;

	if( debugOn() ) {
		$entry = ["timestamp" => microtime(true), "message"=>$message];
		if ($data !== "") {
			$entry['data'] = $data;
		}
		$type = preg_replace("/[^a-z0-9\-_]/", "", strtolower($type));
		$app['log'][$type][] = $entry;
	}

}

/* *********************************************************************************************
 *  getLog([$type])
 *
 *  May be used by developers to get the application's logs while in debug mode.
 *
 *  A log is only kept while in debug mode (see DEBUG MODE). Each entry is stored as an element
 *  in an array and contains a timestamp, message, and an optional data array. This function will
 *  retrieve the logs for processing.
 *
 *  For example, to get error logs use: getLog("error")
 *
 *  @see getLog()
 *  @see logMsg()
 *  @see logAPIrequest()
 *  @see logError()
 *  @see logEntry()
 *  @see setDebugSwitch()
 *
 *  @param string $type Optional. The type of entries to return. If not included then all logs are returned. (Possible values: "event", "api", "error")
 *  @return array Either all log entries or just the entries for a specified type
 */
function getLog($type = "") {

	$log = array();

	if( debugOn() ) {
		if ($type==="") { // get all the logs
			$log = getApp('log');
		} else if (isset(getApp('log')[strtolower($type)])) { // get only logs of type
			$log = getApp('log')[strtolower($type)];
		}
	}

	return $log;

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

	// if a user is an admin they are authorized and authenticated otherwise do security checks
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
		error_reporting(E_ALL);

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

// go to the app and cfg array and check to see what secrets we need to keep.
function getSecrets() {

	$secrets = array();

	// go through each of the areas in getApp and getCfg where we store secret values

	// start with config secrets
	if ( getCfg("secrets") ) {
		$secrets = followSecrets( getCfg("secrets") );
	}

	// then go for the app config secrets
	if ( getCfg("app-secrets") ) {
		$secrets = array_merge($secrets, followSecrets( getCfg("app-secrets") ) );
	}

	// finally go for the application runtime secrets
	if ( getApp("secrets") ) {
		$secrets = array_merge($secrets, followSecrets( getApp("secrets") ) );
	}

	return $secrets;
}

function followSecrets($element) {
	$innerSecrets = array();

	foreach ($element as $key => $value) {
		if ( is_array($value) ) {
			$innerSecrets = array_merge( $innerSecrets, followSecrets($value) );
		} else {
			$innerSecrets[] = $value;
		}
	}

	return $innerSecrets;
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

	$sanitized = array(); // this will hold the value we hand over to print_r

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


/* 
	***************************************************************************
	BROWSER CACHE AND ORIGIN (CORS)
	***************************************************************************
 */

 /**
  * We can set the amount of time in seconds to cache the response returned
  * to the requestor. The types and their allotted cache time are set in the
  * config.ini.php file under the "header" section
  *
  * If no $type is present, "page" is used. If debug mode is switched on, then
  * a time of 1 second is used no matter the type.
  *
  * @param String $type (optional) A type corresponding with a type set in config.ini.php under the "header" section
  * @return Integer Representation of the number of seconds to cache
  */
function getCacheExpire($type = "page") {

	$ttl = 1; // we need an initial val so we set it debug mode's of 1 second

	if(!debugOn()) {
		$ttl = getCfg('header')[$type.'-cache'];
	}

	return $ttl;
}

/**
 * Check to see if the request was from an approved origin. Approved origins
 * may be set in the config.ini.php file.
 * 
 * Upon determining that it is not an approved origin, the script can die
 * and respond with a 403 error if the parameter $die is set to TRUE
 * 
 * @param Boolean $die Should the script halt and respond with a 403 if it is not an approved origin?
 * @return Boolean TRUE if it is an approved origin, FALSE if not
 */
function isApprovedOrigin($die = FALSE) {

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
		if($die) {
			// we can evenually do better by matching the accept header (if JSON was requested return that)
			header(getServerProtocol()." 403 Forbidden");
			die("Not an approved origin: ".$http_origin);
		}
	}

	return $requestOK;

}

/**
 * Get the origin of the request. By default $_SERVER['HTTP_REFERER'] is
 * returned. If not set then $_SERVER['HTTP_ORIGIN'] is used.
 * 
 * Upon first call the return value is set in $app['request']['origin']
 * 
 * @return String Origin of the request
 */
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

/**
 * Get the client IP of the request. By default $_SERVER['REMOTE_ADDR'] is
 * returned. If the application is behind a load balancer it checks for
 * a ['X-Forwarded-For'] header.
 * 
 * Upon first call the return value is set in $app['request']['client']
 * 
 * @return String IP of the requesting client
 */
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

/**
 * Get the host the application is running on. This is useful if we are running
 * the application on multiple environments, such as development and
 * production.
 * 
 * Upon first call the return value is set in $app['request']['host']
 * 
 * @return String The host
 */
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

//  Added 2019-11-13 - chadkluck
/**
 * A helper function that returns the client's user agent obtained from $_SERVER['HTTP_USER_AGENT'].
 * 
 * This function utilizes the getServer() method which will return "" if the
 * index is not defined. It also caches the value in the global variable
 * $app as $app['request']['user-agent'].
 * 
 * Same as calling getApp("request")['user-agent']
 *  
 * @return String User Agent as obtained from $_SERVER['HTTP_USER_AGENT'] NULL if not set, "" if set but empty
 */
function getRequestUserAgent() {

	global $app;

	if( !isset(getApp('request')['user-agent'])) {
		$app['request']['user-agent'] = getServer("HTTP_USER_AGENT");
	}

	return getApp('request')['user-agent'];
}

//  Added 2019-11-13 - chadkluck
/**
 * A helper function that returns values from $_SERVER. If a provided index is not set
 * (doesn't have a value) then the value passed for $v is returned (or null if $v is not passed)
 * 
 * Uses: 
 * $valFromServ = getServer('HTTP_USER_AGENT');
 * Will return the user agent, an empty string, or if $_SERVER['HTTP_USER_AGENT'] is not set, null
 * Useful if you need to tell the difference between an index not being set or an empty value for the index.
 * 
 * $valFromServ = getServer('HTTP_USER_AGENT', "");
 * Will return the user agent, or if $_SERVER['HTTP_USER_AGENT'] is not set, ""
 * Useful if you DON'T care about the difference between index not set or an empty value for the index
 * 
 * $valFromServ = getServer('HTTP_USER_AGENT', "none");
 * Will return the user agent, or if $_SERVER['HTTP_USER_AGENT'] is not set, "none"
 * 
 * @param String $index The index value to return from the $_SERVER associative array
 * @param String $v What should the value be if the index is not set? 
 */
function getServer($index, $v = NULL) {
	return isset($_SERVER[$index]) ? $_SERVER[$index] : $v;
}

function getServerProtocol() {
	return (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
}

// Added 2019-11-14 - chadkluck
/**
 * 	Format an error code and message that can be as an API response body and passed
 *  on to the client publicly. This allows for a consistent error response via API.
 * 	
 * 	Passing errors to this function has a cumlative effect and may be used if multiple
 * 	errors may be passed back to the client.
 * 
 * 	@see api_getErrorBody()
 * 
 * 	@param String $code An appropriate error code to display to the client
 * 	@param String $message An appropriate error message to display to the client
 *  @param Boolean $all In the return value, should all accumulated errors be returned, or just this one? TRUE will return all, FALSE will return just this one
 * 	@return Array A formatted error message ready for JSON output to the client
 */
function api_formatErrorBody($code, $message, $all = FALSE) {

	global $app;

	if ( !isset($app['output'])) {
		$app['output'] = array();
	}

	if ( !isset($app['output']['errors'])) {
		$app['output']['errors'] = array();
	}

	$item = array("code" => $code, "message" => $message);
	$app['output']['errors'][] = $item;

	return $all ? getAPIerrorBody() : array("errors" => [ $item ] );

}

// Added 2019-11-14 - chadkluck
/**
 * 	Return all errors accumulated by format_API_ErrorBody(). This can be added
 *  to an API response body or sent as a stand alone API response body.
 * 
 * 	@see api_formatErrorBody()
 * 
 * 	@return Array All errors formatted for an API response back to the client
 */
function api_getErrorBody() {
	global $app;
	$e = NULL;

	if ( isset($app['output']) && isset($app['output']['errors'])) {
		$e = array("errors" => $app['output']['errors']);
	}

	return $e;
}

// display json data
function displayJSON($json = array() ) {
	httpReturnHeader(getCacheExpire("api"), getRequestOrigin(), "application/json");
	echo json_encode($json);
}

// DEPRECATED
/**
 * This is deprecated. If we wish to halt execution we can send TRUE as a
 * parameter to isAllowedOrigin(TRUE). If we wish to handle the error on our
 * own we can use api_formatErrorBody() to create a response.
 */
function displayJSONnotApprovedOrigin() {
	displayJSONerror("400", getRequestOrigin()." not an allowed origin","");
}

// DEPRECATED - possibly
/**
 * This is deprecated. If we wish to halt execution we can send TRUE as a
 * parameter to isAllowedOrigin(TRUE). If we wish to handle the error on our
 * own we can use api_formatErrorBody() to create a response.
 */
function displayJSONerror($code, $message, $status = 400) {

	$error = api_formatErrorBody($code, $message, FALSE);
	
	header(getServerProtocol()." ".$status." ".$message);
	displayJSON($error);
	die();

}

// return debug info if debug is on
function displayHTMLdebugInfo($json) {
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


/**
 * Generate headers to return to the requestor.
 * 
 * @param Integer $cache in seconds
 * @param String $origin (optional) Deprecated. If "" then request variables are used
 * @param String $contentType (optional) What is the return type? Default is text/html; charset=utf-8
 * @param Array $returnHeaders (optional) Not yet implemented
 */

function httpReturnHeader($cache, $origin = "", $contentType = "text/html; charset=utf-8") {

	// cache code from: https://www.electrictoolbox.com/php-caching-headers/
	$ts = gmdate("D, d M Y H:i:s", time() + $cache) . " GMT";
	header("expires: ".$ts);
	header("pragma: cache");
	header("cache-control: max-age=".$cache);

	header("access-control-allow-origin: *"); // see note below
	header("content-type: ".$contentType);

	if ( $origin === "" ) {
		$origin = getRequestOrigin();
	}
	header("x-origin: ".$origin);

	/*
		We allow all origins because if a referer/origin check was necessary
		for access, we already performed it and wouldn't be returning
		any data anyway. 

		While most helpful tips on the internet recommend something like
		header("Access-Control-Allow-Origin: ".$originDomain);
		this ignores the fact that if the page is cached, so is the domain
		of the allowed origin.

		This is great if you have only 1 referer to expect, but if you have
		sub domains, or multiple domains, this poses a problems as the header
		does not allow for wild card subdomains or multiple domains.

		Someone who first goes to my.example.com and has the header set to
		allow my.example.com will have the browser deny the asset from loading
		if they then go to account.example.com.

		So, we let the referer/origin check filter out the bad requests and
		allow ANY that passed that check be an allowed origin.
		
		This code change was implemented in php-project-framework 
		November of 2019
	*/
}


/* *********************************************************************************************
 *  checkSiteLevelAccess()
 *
 *  Called in inc/inc-app.php which puts it in every page and api request
 *
 *  1. Checks if require_ssl is set to 1 in config.ini.php
 *  2. Checks if ip-restrict-allow-ip is set in config.ini.php
 *
 *  Since this is called in inc/inc-app.php it is application-wide. Granular control of ip restrictions may
 *  be used by using zone-restrict-allow-ip[zone-name] in config.ini.php and calling restrictByIpForZone("zone-name")
 *  at the top of restricted pages
 *  api-restrict-access-allow-ip may also be used to restrict all apis
 *
 *  For example, to get error logs use: getLog("error")
 *
 *  @see requireSSL()
 *  @see restrictByIp()
 *  @see restrictByIpForZone()
 *  @see authorizeAPIcall()
 */
function checkSiteLevelAccess() {
	requireSSL();
	restrictByIp();
}


/* *********************************************************************************************
 *  requireSSL()
 *
 *  Redirect to https if it is http and https is required. Called by checkSiteLevelAccess()
 *
 *  This is set in the config.ini.php file under require_ssl
 *  Note that even with a redirect, the initial request was sent insecurely. It also uses a redirect which does not resubmit POST data,
 *  it is for a user typing and not form or post data. Do not rely on the redirect, always link to https, or set up your server or
 *  .htaccess to require SSL.
 *  This is only optimal when a user is typing links
 *
 *  If this application sits behind a load balancer, have the load balancer server admin set up
*   X-Forwarded-Port ("443") or X-Forwarded-Proto ("https") to pass along the protocol
 *
 *  ADDED 2018-10-31 chadkluck
 *  MODIFIED 2019-02-16 chadkluck - fixed where server https and server server_port may not be set
 *
 *  @see checkSiteLevelAccess()
 */

function requireSSL() {

	if( getCfg('security')['require-ssl'] ) {
		$isHTTPS = false;

		$h = apache_request_headers();
		if ( isset( $h['X-Forwarded-Port'] )) {
			$isHTTPS = $h['X-Forwarded-Port'] === "443" ? true : false;
		} else if ( isset( $h['X-Forwarded-Proto'] ) ) {
			$isHTTPS = $h['X-Forwarded-Proto'] === "https" ? true : false;
		} else if ( isset( $_SERVER["HTTPS"] ) && strtolower($_SERVER["HTTPS"]) === "on" ) {
			$isHTTPS = true;
		} else if ( isset( $_SERVER["SERVER_PORT"] ) && $_SERVER['SERVER_PORT'] === 443 ) {
			$isHTTPS = true;
		}

		// if it is not https then redirect to https
		if( !$isHTTPS )
		{
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			exit();
		}
	}

}


/* *********************************************************************************************
 *  restrictByIp()
 *
 *  Check ip restrictions. Called by checkSiteLevelAccess()
 *
 *  This is set in the config.ini.php file under [security] ip-restrict-allow-ip
 *  Also, admins and users can override if they are logged in (if override is set)
 *  This is application wide. (API and pages) as it is called on all requests. If a more granular
 *  approach is warranted see authorizeAPIcall() for just locking down APIs or segmenting each
 *  API or page into it's own zone by using restrictByIpForZone()
 *
 *  ADDED 2018-10-31 chadkluck
 *
 *  @see checkSiteLevelAccess()
 *  @see restrictByIpForZone()
 */

function restrictByIp() {

	if( isset( getCfg('security')['ip-restrict-allow-ip'] ) && getCfg('security')['ip-restrict-allow-ip'] ) {

		// see if there is an admin or user override
		if  (
				 ( getCfg('security')['ip-restrict-allow-admin'] && userIsAdmin() )
			|| ( getCfg('security')['ip-restrict-allow-user']  && userIsUser()  )
			|| ( preg_match( getCfg('security')['ip-restrict-allow-ip'], getRequestClient() ) === 1 )
			)
		{
			logMsg("IP Restriction is ON: Access Allowed");
		} else {
			header(getServerProtocol()." 403 Forbidden");
			die('Access Forbidden');
		}
	} else {
		logMsg("IP Restriction is not set in config.ini.php. To enable add ip-restrict-allow-ip = 1 to the [security] section in config.ini.php");
	}
}


/* *********************************************************************************************
 *  restrictByIpForZone($zone)
 *
 *  If the page is restricted by IP then we check access here. If the IP is not allowed then the
 *  application dies.
 *
 *  The IP is set in the config.ini.php file under [security] zone-restrict-allow-ip where multiple
 *  zones and IP ranges may be defined.
 *
 *  For example you may have an intranet zone (accessible only via an internal network) and a secure
 *  zone (accessible only via IPs in your admin office).
 *
 *  Unlike restrcitByIp (which locks down the whole application) this can be placed on individual
 *  pages. Also unlike restrictByIp there is no override by admins or users.
 *
 *  ADDED: 2019-01-23 chadkluck
 *
 *  @see restrictByIp()
 *
 *  @param string/int $zone Zone id that matches key in associatve array defined in config.ini.php
 */

function restrictByIpForZone($zone = 0) {

	$zones = array();

	// check to see if zone-restrict-allow-ip exists,
	if( isset(getCfg('security')['zone-restrict-allow-ip']) ) {
		$zones = getCfg('security')['zone-restrict-allow-ip'];
	}

	// check to see if there are zones
	if( count($zones) ) {

		// check to see if the requested zone exists
		if ( array_key_exists( $zone, $zones ) ) {

			$ip = $zones[$zone];

			// if the zone has an ip restriction then check
			if ( $ip !== "" ) {

				if  ( preg_match( $ip, getRequestClient() ) === 1 ) {
					logMsg("Zone IP Restriction is ON for '".$zone."': Access Allowed");
				} else {
					header(getServerProtocol()." 403 Forbidden");
					die('Access Forbidden'); // zone exists but IP is not in the range to receive access
				}
			} else {
				// zone is defined but not currently restricted
				logMsg("Zone IP Restriction is OFF for '".$zone."': Access Allowed");
			}

		} else {
			header(getServerProtocol()." 403 Forbidden");
			die('Access Forbidden - Zone Undefined'); // restrictByIpForZone() was put in by a developer but points to a zone never defined in config.ini.php
		}

	} else {
		header(getServerProtocol()." 403 Forbidden");
		die('Access Forbidden - No Zones Defined'); // restrictByIpForZone() was put in by a developer but zones are never defined in config.ini.php
	}

}

/* *********************************************************************************************
 * authorizeAPIcall()         - added 2018-11-06 chadkluck
 *
 * If calls to this application's api service is restricted by IP or apikey, then make sure
 * they are present.
 * The api access IP is set in the config.ini.php file under [security] api-restrict-access-by-ip
 * The api access key is set in the config.ini.php file under [secrets] api-restrict-access-by-key
 * The default behavior when requests are unauthorized is to throw a request error 403. Otherwise passing
 * false in the parameter will cause it to return false if not authorized. Useful if you want a different
 * course of action rather than a 403.
 *
 */

function authorizeAPIcall($die = true) {

    /*
    This uses threshold logic.

    Each requirement increases the threshold that must be met.

    threshold starts at 0, so does the status.

    If no IP or key requirements, then threshold is 0 and status is 0 (0 === 0) and it returns true
    If ip requirement, then threshold is increased by 1 and the ip is checked. If met status is increased by 1
    If key requirement, then threshold is increased by 1 and the key is checked. If met status is increased by 1

    In the end, the status must equal the threshold set, otherwise it is not authorized.
    */

	$threshold = 0; // number of requirements we must meet
	$status = 0; // number of requirements we met
	$r = false; // return value

    // gather these settings to make them easy to process
	$keys = (isset(getCfg("secrets")['api-restrict-allow-key'])) ? getCfg("secrets")['api-restrict-allow-key'] : array();
	$ip = getCfg("security")['api-restrict-allow-ip'];


    // see if there are keys set. If so increase the threshold and evaluate the key
	if( count($keys) > 0 ) {
		$threshold++; // increase the number of requirements we must meet
		$apikey = getParameter("apikey", "GET");
		if ($apikey) {
			$id = explode("-", $apikey)[0];
			if ( array_key_exists($id, $keys) && $keys[$id] === $apikey ) {
				$status++; // we found a matching key - this requirement is met
			}
		}
	}


    // see if there is an IP requirement. If so, increase the threshold and evaluate the IP
	if ( $ip !== "" ) {
		$threshold++; // increase the number of requirements we must meet
		if ( preg_match( $ip, getRequestClient() ) === 1 ) {
			$status++; // The IP is a match - this requirement is met
		}
	}

	// Check to see if we met the requirement threshold
	if ( $status === $threshold ) {
		$r = true;
	} else {
        logMsg("No Key/Ip Match", $keys);
        if ($die) {
            header(getServerProtocol()." 403 Forbidden");
			die('Access Forbidden');
        }
	}

	return $r;
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
    
	Functions to help with requesting data from remote endpoints such as APIs

	============================================================================================
*/


/*	********************************************************************************************
	Generate Requst functions
	--------------------------------------------------------------------------------------------
*/

/*	--------------------------------------------------------------------------------------------
	generateRequest()
	Modified 2019-11-15 - chadkluck
*/

/**
 *	Same as getData() but accepts the endpoint (protocol, domain, path) as a string, and the 
 *  query string parameters as an array of key/value pairs.
 * 
 *	This function takes the array of query string parameters, combines them with the endpoint url
 *  and submits it to getData() for processing the request.
 *
 * 	If you plan to already have an endpoint url complete with a query string, use getData() 
 * 	or one of it's related functions. This function is optimized for submitting endpoint and
 *  params separately.
 * 
 *	@see generateJSONrequest()	Same function, but makes an explicit request for JSON
 *	@see generateXMLrequest()	Same function, but makes an explicit request for XML
 *	@see getData()				For more detailed information as this function calls getData()
 *	@see generateQueryStringFromParameterArray()	For information on how the query string is generated from the array passed to $parameters
 *
 *  @param String $endpoint A url such as https://api.example.com/v1/ but without a query string. Query string parameters are passed as key/value pairs in $parameters
 *  @param Array $parameters (optional) An array of key/value pairs to pass as a query string to the endpoint
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed.
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if XML or JSON data is returned and detected from the endpoint. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */

function generateRequest($endpoint = "", $parameters = NULL, $headers = NULL, $returnResponseHeaders = FALSE) {
	$results = array();

	if($endpoint !== "") {

		// formulate request url. If there is a query string, add it
		$url = $endpoint . generateQueryStringFromParameterArray($parameters);


		$results = getData($url, $headers, $returnResponseHeaders);

	}

	return $results;
}

/*	--------------------------------------------------------------------------------------------
	generateJSONrequest()
	Modified 2019-11-15 - chadkluck
*/

/**
 *	Same as generateRequest() but explicitly for requesting data from a JSON endpoint.
 *	This function automatically sets the request content type to JSON and calls generateRequest()
 *	which ultimately calls getData()
 *	
 *	To explicitly request XML data use generateXMLrequest()
 * 
 *	@see generateRequest()		For more detailed information as this function calls generateRequest()
 *	@see generateXMLrequest()	Same function, but makes an explicit request for XML
 *	@see getData()				For more detailed information as this function calls generateRequest() which calls getData()
 *	@see generateQueryStringFromParameterArray()	For information on how the query string is generated from the array passed to $parameters
 *
 *  @param String $endpoint A url such as https://api.example.com/v1/ but without a query string. Query string parameters are passed as key/value pairs in $parameters
 *  @param Array $parameters (optional) An array of key/value pairs to pass as a query string to the endpoint
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed.
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if JSON data is returned and detected from the endpoint. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */

function generateJSONrequest($endpoint = "", $parameters = NULL, $headers = NULL, $returnResponseHeaders = FALSE) {
	return generateRequest($endpoint, $parameters, getDataSetHeaderAccept($headers, "JSON", TRUE), $returnResponseHeaders);
}

/*	--------------------------------------------------------------------------------------------
	generateJSONrequest()
	Modified 2019-11-15 - chadkluck
*/

/**
 *	Same as generateRequest() but explicitly for requesting data from an XML endpoint.
 *	This function automatically sets the request content type to XML and calls generateRequest()
 *	which ultimately calls getData()
 *	
 *	To explicitly request JSON data use generateJSONrequest()
 * 
 *	@see generateRequest()		For more detailed information as this function calls generateRequest()
 *	@see generateJSONrequest()	Same function, but makes an explicit request for JSON
 *	@see getData()				For more detailed information as this function calls generateRequest() which calls getData()
 *	@see generateQueryStringFromParameterArray()	For information on how the query string is generated from the array passed to $parameters
 *
 *  @param String $endpoint A url such as https://api.example.com/v1/ but without a query string. Query string parameters are passed as key/value pairs in $parameters
 *  @param Array $parameters (optional) An array of key/value pairs to pass as a query string to the endpoint
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed.
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if XML data is returned and detected from the endpoint. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */

function generateXMLrequest($endpoint = "", $parameters = NULL, $headers = NULL, $returnResponseHeaders = FALSE) {
	return generateRequest($endpoint, $parameters, getDataSetHeaderAccept($headers, "XML", TRUE), $returnResponseHeaders);
}

/*	********************************************************************************************
	Get Data functions
	--------------------------------------------------------------------------------------------
*/

/*	--------------------------------------------------------------------------------------------
	getData()
	Added 2019-11-15 - chadkluck
*/

/**
 * 	Using curl GET, request non-binary data from a remote service.
 * 	This function is called by getDataFromJSON() and getDataFromXML()
 * 	If the data is requested in JSON or XML format, the body will be an array. Otherwise
 *  it will be returned in the format received.
 * 
 *  You can provide a hint for the format of the data by providing "application/json" or
 *  "application/xml" in the accept request header. (This is done by passing 
 *  "accept" => "application/json" in the $headers parameter for json as an example.).
 * 
 * 	However, if no hint is passed then the reponse header "content-type" is used to determine the format.
 *  If the "accept" or "content-type" is not xml or json, then the body is raw data and not an array.
 * 
 *  The parameter $returnResponseHeaders when set to TRUE will return an associative 
 * 	array with 3 indices: "info", "headers", and "body"
 * 	If set to FALSE only the response body from the remote endpoint will be returned
 *  (without the parent index of "body")
 * 
 *  @see getDataFromJSON()		For a similar function, but for explicitly requesting JSON data
 *	@see getDataFromXML()		For a similar function, but for explicitly requesting XML data
 * 	
 *  @param String $url Endpoint such as https://api.example.com/v1/?q=asdf (complete with protocol, domain, path, and query)
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed. If 'accept' is not provided then it is set to "text/html"
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if XML or JSON data is detected. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */

function getData($url, $headers = NULL, $returnResponseHeaders = FALSE) {

	global $app;

	$results = array(); // what we'll eventually pass back

    $response = array("raw" => "", "info" => "", "headers" => "", "body" => ""); // our messy work area

	// cacheProxy is a php-project-framework add on
	if (isset($app['obj']) && isset($app['obj']['x-cacheProxy']) ) {
		$url = $app['obj']['x-cacheProxy']->getURI($url);
	}

	// we can pass on headers required by the api, or additional headers such as origin, referer, user agent, etc.
	// either headers were passed, or they weren't. If they were, normalize all the keys to lower-case so we can do easy comparisons
	$headers = (is_array($headers)) ? array_change_key_case($headers, CASE_LOWER) : array();

	// if accept request header wasn't set, set the content type to text/html
	if ( !isset($headers['accept']) ) {
		$headers['accept'] = "text/html";
	}

	try {

        // set up curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		/* We have a few special headers we need to sort out separately from the rest.
		We'll find them, separate them out, and then loop through the rest.
		
		NOTE that the keys are using lower-casing. While there is great debate, and 
		headers are case insensitive, we're just going to lower-case them as it 
		reduces the overhead of controling for mixed or upper case. 

		Google, CloudFlare, and (some) AWS all use lower-case header keys
		*/

		// Check for the referer header
		if ( array_key_exists('referer', $headers) ) {
			if ( $headers['referer'] === "" || $headers['referer'] === NULL) {
				$headers['referer'] = $_SERVER['HTTP_REFERER'];
			}
			curl_setopt($ch, CURLOPT_REFERER, $headers['referer']);
			unset($headers['referer']); // we're done with this special header, avoid the loop
		}

		// Check for the user-agent header
		if ( array_key_exists('user-agent', $headers) ) {
			if ( $headers['user-agent'] === "" || $headers['user-agent'] === NULL) {
				$headers['user-agent'] = $_SERVER['HTTP_USER_AGENT'];
			}
			curl_setopt($ch, CURLOPT_USERAGENT, $headers['user-agent']);
			unset($headers['user-agent']); // we're done with this special header, avoid the loop
		}
		
		// Check for the origin header
		if ( array_key_exists('origin', $headers) ) {
			if ( $headers['origin'] === "" || $headers['origin'] === NULL) {
				$headers['origin'] = $_SERVER['HTTP_ORIGIN'];
			}
			/* unlike referer and user-agent, there is no special curl_setopt, so
			we just set the header and add the origin just like other headers. */
		}

		// loop through remaining headers and put them in a format for curl_setopt
		$requestHeaders = array();
		foreach ($headers as $key => $value) {
			$requestHeaders[] = strtolower($key).": ".$value;
		}

		// set the headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE); // include our submitted request headers in the info
		curl_setopt($ch, CURLOPT_HEADER, TRUE); // we always get the headers even if we don't return them

        // make the request
		$response['raw'] = curl_exec($ch);
        $response['info'] = curl_getinfo($ch);

        //logMsg("Response so far...", $response);

        /* Now that we have processed the request, make sure it was successful.
            If not, send an error. */
		if ( curl_errno($ch)  ) {
			$msg = curl_error($ch);
			logMsg("GET Request Error: ".$msg);
            $response['body'] = api_formatErrorBody("ERR", $msg);
            $response['headers'] = array();
		} else {

			// so we have the contents, now we need to separate header data from body data
			// https://stackoverflow.com/questions/13384658/remove-curlopt-header-return-data
			$header_size = $response['info']['header_size'];
			$response['headers'] = trim(substr($response['raw'], 0, $header_size)); //Get the header and trim it to remove \r\n
			$response['body'] = substr($response['raw'], $header_size); //Get the body

			// extract responseHeaders
			// https://beamtic.com/curl-response-headers
            $response['headers'] = explode("\r\n", $response['headers']); // The seperator used in the Response Header is CRLF (Aka. \r\n) 
            $response['headers'] = array_filter($response['headers']);
            
            //logMsg("Response so far before separating header keys...", $response);

			if ( is_array($response['headers']) && count($response['headers']) > 0 ) {
				// get rid of the first line which contains HTTP 1.x and http status code
                array_shift($response['headers']);
                
                $temp = array();

				foreach ($response['headers'] as &$value) {
                    $pos = strpos($value, ":");
                    $key = strtolower(substr($value, 0, $pos));
					$val = trim(substr($value, $pos + 1));
                    $temp[$key] = $val;
                    logMsg("Header Key: ".$key." Value: ".$val);
                }
                
                $response['headers'] = $temp;
            }
            
            //logMsg("Response so far after separating header keys...", $response);

            /* We now need to convert the raw body to the requested format.
                XML or JSON will be returned as an array. Anything else
                will be returned as the requested content type */
			$contentType = "";
			if ( array_key_exists('content-type', $response['info'] ) ) {
				$contentType = $response['info']['content-type']; // use what the response from endpoint says it is
			} else if ( array_key_exists('accept', $headers ) ) {
				$contentType = $headers['accept']; // use what we requested
			}

			if ( strpos($contentType, "json") !== FALSE ) {
				$contentType = 'application/json'; // it's JSON
			} else if (strpos($contentType, "xml") !== FALSE) {
				$contentType = 'application/xml'; // it's XML
			} // else it is neither and we won't convert to an array (leave up to other logic)

			switch ($contentType) {
				case 'application/json':
					$response['body'] = json_decode($response['body'], true);
					break;
				
				case 'application/xml':
					$xml = simplexml_load_string($response['body']);
					$response['body'] = json_encode($xml);
					break;

				default:
					// leave body as is
					break;
            }
            
            //logMsg("Response so far...", $response);

        }
        
        curl_close($ch);


	} catch (Exception $e) {
        logMsg("Caught exception: ". $e->getMessage());
        $response['body'] = api_formatErrorBody("ERR", "Application error processing request");
        if ( !is_array($response['headers']) ) { $response['headers'] = array(); }
    }
    
	logAPIrequest($url, $response);

    // Were response headers requested?
	if ( $returnResponseHeaders ) {
        // we return data from info, headers
        $results['info'] = $response['info'];
		$results['headers'] = $response['headers'];
		$results['body'] = $response['body'];
	} else {
        // we just return the body
		$results = $response['body'];
	}

	return $results;
}

/*	--------------------------------------------------------------------------------------------
	getDataFromJSON()
	Modified 2019-11-15 - chadkluck
*/

/**
 *  Request JSON formatted data from a remote service. Sibling of getDataFromXML(),
 *  child of getData()
 * 
 *  This function differs from generateJSONrequest() as the $url endpoint is fully
 *  parsed together with the query string (generateJSONrequest() accepts query string
 * 	parameters as an array). This function is called by generateJSONrequest() with 
 * 	the $format parameter set to "JSON"
 * 
 * 	If an "accept" key/value pair is passed in the $headers array then it is overwritten
 *  by the default "application/json"
 * 
 *  The parameter $returnResponseHeaders when set to TRUE will return an associative 
 * 	array with 3 indices: "info", "headers", and "body"
 * 	If set to FALSE only the response body from the remote endpoint will be returned
 *  (without the parent index of "body")
 * 
 * 	@see generateJSONrequest()	For a similar function but for submitting query string parameters as an array
 * 	@see getData()				The function this function ultimatly calls to process the request
 *  @see getDataFromXML()		For a similar function, but for requesting XML data
 * 
 *  @param String $url Endpoint such as https://api.example.com/v1/?q=asdf (complete with protocol, domain, path, and query)
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed.
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if JSON data is detected. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */

 function getDataFromJSON($url, $headers = NULL, $returnResponseHeaders = FALSE) {
	return getData($url, getDataSetHeaderAccept($headers, "JSON", TRUE), $returnResponseHeaders);
}

/*	--------------------------------------------------------------------------------------------
	getDataFromXML()
	Modified 2019-11-15 - chadkluck
*/

/**
 *  Request XML formatted data from a remote service. Sibling of getDataFromJSON(),
 *  child of getData()
 * 
 *  This function differs from generateXMLrequest() as the $url endpoint is fully
 *  parsed together with the query string (generateXMLrequest() accepts query string
 * 	parameters as an array). This function is called by generateXMLrequest() with 
 * 	the $format parameter set to "XML"
 * 
 *  If an "accept" key/value pair is passed in the $headers array then it is overwritten
 *  by the default "application/xml"
 * 
 *  The parameter $returnResponseHeaders when set to TRUE will return an associative 
 * 	array with 3 indices: "info", "headers", and "body"
 * 	If set to FALSE only the response body from the remote endpoint will be returned
 *  (without the parent index of "body")
 * 
 * 	@see generateJSONrequest()	For a similar function but for submitting query string parameters as an array
 * 	@see getData()				The function this function ultimatly calls to process the request
 *  @see getDataFromJSON()		For a similar function, but for requesting JSON data
 * 
 *  @param String $url Endpoint such as https://api.example.com/v1/?q=asdf (complete with protocol, domain, path, and query)
 *  @param Array $headers (optional) An array of key/value pairs to send in the header along with the request. An empty array or null may be passed.
 *  @param Boolean $returnResponseHeaders (optional) Should the return value contain the response headers? Default is FALSE.
 * 
 * 	@return Mixed Typically an array if XML data is detected. By default only the reponse body data is returned, if $returnResponseHeaders is set to TRUE then curl info, response headers and body are returned in an associative array
 */
//  Modified 2019-11-13 - chadkluck
function getDataFromXML($url, $headers = NULL, $returnResponseHeaders = FALSE) {
	return getData($url, getDataSetHeaderAccept($headers, "XML", TRUE), $returnResponseHeaders);
}

/*	********************************************************************************************
	Remote data request helper functions
	--------------------------------------------------------------------------------------------
*/

/*	--------------------------------------------------------------------------------------------
	generateQueryStringFromParameterArray()
	Added 2019-11-15 - chadkluck
*/

/**
 * 	Given an array of key/value pairs, it will return a query string pre-pended
 *  with a "?". If passed an empty array it will return an empty string ""
 * 
 *  If an element contains a nested array, it will add multiple parameter keys
 *  with [] appended to the key.
 *  
 * 	For example, {"q": "popcorn", ids": ["45", "57", "87"]}
 *  Will return: ?q=popcorn&ids[]=45&ids[]=57&ids[]=87
 * 
 *  {"q": "popcorn", "flavor": "caramel" }
 *  Will return: ?q=popcorn&flavor=caramel
 *  
 *  {}, [], NULL, or any non Array will return ""
 * 
 * 	Query string parameter values will be urlencoded
 * 
 * 	@param Array $parameters An associative array with key/value pairs to generate into a query string.
 * 
 * 	@return String A query string generated from the passed parameters. If no parameters, or a non-array was supplied, an empty string.
 */

function generateQueryStringFromParameterArray($parameters = NULL) {

	if ( !is_array($parameters) ) {
		$parameters = array();
	}

	$query = "";

	// add each parameter as a key and value to the query string
	foreach ($parameters as $key => $value) {

		// check to see if the value contains a nested array
		if (is_array($value)) {
			// param contains an array so we format like: &ids[]=45&ids[]=57&ids[]=87
			foreach ($value as $v) {
				$query .= "&".$key."[]=".urlencode($v);
			}
		} else {
			// regular key value pair like: id=57
			$query .= "&".$key."=".urlencode($value);
		}
	}

	// remove the first & in the query
	$query = ltrim($query,"&");

	// if it isn't empty, prepend a ?, otherwise we'll return an empty string
	$query = ($query !== "") ? "?".$query : "";

	logMsg("Generated query string: ".$query, $parameters);
	
	return $query;

}

function getDataSetHeaderAccept($headers = NULL, $format = "JSON", $overwrite = TRUE) {

	// if we don't have an array established, establish it
	if (!is_array($headers)) {
		$headers = array();
	}

	// if accept request header wasn't set, or if we are going to overwrite...
	if ( !isset($headers['accept']) || $overwrite) {

		switch ($format) {
			case 'JSON':
				$headers['accept'] = "application/json";
				break;
			
			case 'XML':
				$headers['accept'] = "application/xml";
				break;
				
			default:
				$headers['accept'] = "text/html";
				break;
		}

	}

	return $headers;
}

/* *************************************************************
 *  GET DATA from JSON FORMAT and RETURN AS ARRAY
 *  For APIs that return JSON data
 */

function getDataFromJSON_old($url) {
	$results = array();

	try {
		$contents = @file_get_contents($url); // @ means suppress warnings
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
 *  For APIs that return XML data and you'd prefer JSON
 */

function getDataFromXML_old($url) {

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


/*  ============================================================================================
		********************************************************************************************
0600    UTILITIES
	********************************************************************************************
*/

/* *********************************************************************************************
 *	util_decodeCfgStrData( $data )
 *
 * 	Sometimes you need to nest arrays in the config file beyond what the syntax allows and there
 *  are various ways of accomplishing this.
 *
 *  First method is to use comma deliminated double brackets containing data:
 *  variableName = "[[some-data]],[[more-data]],[[even more \"data\" in the string]]"
 *
 *  Second method is to store json data:
 *  variableName = "{ \"id\": \"24601\", \"fname\": \"Jean\", \"lname\": \"Valjean\" }"
 *
 *  Another json example:
 *  variableName = "[\"some-data\",\"more-data\",\"even more \\\"data\\\" in the string\"]
 *
 *  Another json example (a multidimentional array not to be confused with a bracket):
 *  variableName = "[[1,2,3],[4,5,6]]"
 *
 *  Third method is to store comma delimited data:
 *  variableName = "the,a,an"
 *
 *  The method used depends on readability. As you can see, the json data requires extensive
 *  use of escaped double quotes, even doublely so when quotes are in the data.
 *
 *  This will take any of the three (as long as they aren't too complicated) and parse it out into an array.
 *
 *  NOTE: This is "on-demand" meaning that it is not automatically parsed out when it is ingested
 *  into the CFG variable. This will need to be used on the data in the CFG variable when it is
 *  needed.
 *
 *  @param string $data The string to convert to an array
 */

function util_decodeCfgStrData( $data ) {

	$r = array();
	$format = "";

	// determine if it is a double bracket delimited or json format
	// if [[]] but not [[],[]] then bracket
	// if {} or [] then json
	// else comma

	if ( preg_match('/^\[\[.*\]\]$/', $data ) === 1 && substr_count($data, "]],[[") === substr_count($data, "],[") ) { $format = "brackets"; }
	else if ( preg_match('/^\{.*\}$/', $data ) === 1 || preg_match('/^\[.*\]$/', $data ) === 1 ) { $format = "json"; }
	else { $format = "comma"; }

	if ( $format === "json" ) {
		$r = json_decode($data, true);
	} else if ( $format === "brackets" ) {
		$r = explode("]],[[", $data);

		$r[0] = preg_replace('/^\[\[/', '', $r[0]);

		$last = count($r) - 1;
		$r[$last] = preg_replace('/\]\]$/', '', $r[$last]);
	} else {
		$r = explode(",", $data);
	}

	return $r;
}


 /* *********************************************************************************************
 *	getCustomHTML( $data )
 *
 *  For HTML we can either bring in a file from the custom folder on the server, or use
 *  the html text already in the variable
 *  Essentially we check to see if we are using a file, if not we just send back the code
 *  sent to us
 *
 *  [[FILE:blah-blah.html]]
 *
 *  @param string $data The string to convert to an array
 */

function getCustomHTML($data) {
	$html = "";

	$regex = "/(?<=^\[\[FILE:)[A-Za-z0-9_-]+\.html(?=\]\]$)/"; // positive, non capturing lookahead and behind strips "[[FILE:" and "]]" in one shot

	// if [[FILE:somefile.html]] then read in the file
	if ( preg_match($regex, $data, $matches) === 1 ) { // if a match found (===1) then put the match in $matches array
		$filename = array_pop($matches); // matches is an array with (presumably) 1 element, but we're just cautious

		try { // read the file contents from the custom folder
			$html = file_get_contents ( __DIR__."/../../../custom/html/".$filename );
		} catch (Exception $e) {
			logMsg($e);
		}

	} else { // it's just plain html text
		$html = $data;
	}

	return $html;
}

?>