<?php
/*  ============================================================================================
    ********************************************************************************************
	[NAME OF APPLICATION]: Functions for Application
    ********************************************************************************************

	[your name/company name] ([your website])
	Version: 0.0.1-YYYYMMDD-HHMM
	[github url for your application if applicable]

	[ any copyright or other info ]

	********************************************************************************************

	FILE LAST MODIFIED: YYYY-MM-DD - [dev name]

	PURPOSE: Core functions for application

	********************************************************************************************

	[ place your comments about this script file here ]

	[ place your comments about this script file here ]

	********************************************************************************************
	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: inc/inc-app.php
		FRAMEWORK FILE VERSION: 2018-08-10

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
    ********************************************************************************************
    INITIALIZE APP
	********************************************************************************************
*/

// [ place code in this area ]

// require an ssl connection (if required as set in config). If request was sent via http, redirect to https
requireSSL(); // note that even with a redirect, the initial request was sent insecurly
			  // also note that this is primarily for the admin tools section, module/getlink, and module/display
			  // It uses a redirect which does not resubmit POST data
			  // Do not rely on the redirect, always link to https. This is only optimal when a user is typing links directly


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

?>