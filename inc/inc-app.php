<?php
/*  ============================================================================================
    ********************************************************************************************
	[NAME OF APPLICATION]: Application Initialization
    ********************************************************************************************

	FILE LAST MODIFIED: YYYY-MM-DD - [dev name]

	PURPOSE: Initialize the Application

	********************************************************************************************

	[ place your comments about this script file here ]

	[ place your comments about this script file here ]

	********************************************************************************************
	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: inc/inc-app.php
		FRAMEWORK FILE VERSION: 2019-02-16

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
    ********************************************************************************************
    INITIALIZE APP
	********************************************************************************************
*/

// check site-level access - is https required? is access restricted by ip?
// this is for site level access, individual pages/zones are set by zone-restrict-allow-ip[zone-name] in config and restrictedZone("zone-name") added to respective pages
checkSiteLevelAccess(); 

// Initialize the $app variable
$app = array();
$app['debug'] = false; //true|false - enables logging and output, can be overriden by ?debug=true in query string. server and ip locks can be put in place
$app['log']['event'] = array();
$app['log']['api'] = array();
$app['start_time'] = 0;
$app['end_time'] = 0;
$app['exe_time'] = -1;
$app['phpversion'] = phpversion();

// if your app sometimes receives a get/post param with a prefix put that prefix here. For example, xforward_debug=true will be treated same as if debug=true were passed in query
$app['param_prefix'] = ""; //EXAMPLE: $app['param_prefix'] = "xforward_";

// checks param sent, config settings, etc to see if we switch to debug mode
setDebugSwitch();

// start script execution timer for troubleshooting
setExeStartTime();

// [ place additional initialization code here ]

?>