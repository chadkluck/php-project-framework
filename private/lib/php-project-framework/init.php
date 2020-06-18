<?php

/*
	***************************************************************************

	***************************************************************************
	***************************************************************************

	This is function template file from the PHP PROJECT FRAMEWORK library.
	Visit github.com/chadkluck/php-project-framework page for more information.
	FRAMEWORK FILE: php-project-framework/init.php
	FRAMEWORK FILE VERSION: 2019-11-18

	***************************************************************************
	===========================================================================
*/

/* 
    ***************************************************************************
    FRAMEWORK LOADTIME
	---------------------------------------------------------------------------

	Capture the start time to see how long it takes to init the framework.
    
    At the end of this script a calculation is performed and the amount of time
    in micro seconds is stored in $app['loadtime']
    
    This is different than the app execution start/end and execution time

	===========================================================================
*/

$phpProjectFramework_loadstart = microtime(true);

/* 
    ***************************************************************************
    CONFIG VARIABLE - Compatible with PHP 7.x and above only
	---------------------------------------------------------------------------

	We call in the config.ini.php file which is in ini format and put all the 
	settings into a constant variable named CFG. However we never request CFG 
	directly in code, we always	use the function defined next: getCfg()

	===========================================================================
*/

// Location of Config File
$config_ini_file = sixtythreeklabs_php_app_private_directory_location . sixtythreeklabs_php_app_name . "/custom/config.ini.php";

// calls in the config.ini.php file and places it in the CONSTANT variable CFG
define('CFG', parse_ini_file($config_ini_file, true, INI_SCANNER_NORMAL ));
unset($config_ini_file);

/**
 * getCfg() is the function used to access the constant variable CFG which is 
 * initialized using the config.ini.php file.
 * 
 * It is a CONST, multi-dimensional, associative array in which values 
 * essential to configuration of the application may be stored. Since it is a 
 * constant it cannot be changed during execution.
 * 
 * $x = getCfg() is the same as $x = CFG
 * 
 * Only the index of the top level of the array can be passed to the function.
 * For example, if CFG consists of 
 * 		{"menu": {"pizza": {}, "pasta": {}},  "locations": {} }
 * and "menu" is passed to getCfg, then {"menu": {"pizza": {}, "pasta": {} }}
 * will be passed back. To obtain child or grandchild elements of "menu" the 
 * array indicies may be placed after the function: getCfg("menu")['pasta'];
 * 
 * For example:
 * $x = getCfg(); // will return the while CFG array
 * $a = getCfg("menu"); // will return CFG['menu']
 * $b = getCfg("menu")['pasta']; // will return CFG['menu']['pasta']
 * $c = getCfg("menu")['pasta']['rigatoni']; // will return CFG['menu']['pasta']['rigatoni']
 * 
 * @param String $index (optional) Name of the top level index you wish to access in CFG. If not included a reference to the entire CFG will be returned
 * 
 * @return Mixed A reference to the element requested. NULL will be returned if the index does not exist
 * 	
 */
function getCfg( $index = NULL ) {
	return ( $index ? (isset( CFG[$index] ) ? CFG[$index] : NULL ) : CFG );
}

/* 
	===========================================================================
    ***************************************************************************
    APP LEVEL INCLUDES
	***************************************************************************

	Do not modify this part, it is the engine that brings in files and 
	include paths.

	Update the paths section in the config.ini.php file.

	===========================================================================
*/

/**
 * Undocumented
 * 
 * Helper function to return the default path or optionally configured inc path 
 * from the config.ini.php file.
 * 
 * @return String Path of the inc directory.
 */
function getPathIncApp() { return ( isset (getCfg("paths")['inc_app']) && getCfg("paths")['inc_app'] ? getCfg("paths")['inc_app'] : sixtythreeklabs_php_app_private_directory_location . sixtythreeklabs_php_app_name."/" . "inc/" ) ; }

/**
 * Undocumented
 * 
 * Helper function to return the default path or optionally configured custom 
 * directory path from the config.ini.php file.
 * 
 * @return String Path of the directory containing the app's custom files
 */
function getPathCustom() { return ( isset (getCfg("paths")['custom']) && getCfg("paths")['custom'] ? getCfg("paths")['custom'] : sixtythreeklabs_php_app_private_directory_location . sixtythreeklabs_php_app_name."/" . "custom/" ) ; }

/**
 * Undocumented
 * 
 * Helper function to return the default path or optionally configured 
 * inc_lib path from the config.ini.php file.
 * 
 * @return String Path of the directory containing libraries shared among apps
 */
function getPathIncLib() { return ( isset (getCfg("paths")['inc_lib']) && getCfg("paths")['inc_lib'] ? getCfg("paths")['inc_lib'] : sixtythreeklabs_php_app_private_directory_location . "lib/" ) ; }

/**
 * Helper function to return the default path or optionally configured assets 
 * path from the config.ini.php file.
 * 
 * @return String Path of the directory containing publicly accessible assets (images, js, etc)
 */
function getPathAssets() { return ( isset (getCfg("paths")['assets']) && getCfg("paths")['assets'] ? getCfg("paths")['assets']  : "/" . "assets/" ) ; }

/*
    ***************************************************************************
    BRING IN THE VARIOUS INCLUDES FOR THE APP
	***************************************************************************
*/
require_once getPathIncLib()."php-project-framework/functions.php"; // php-project-framework functions (all other app specific includes should be in functions-app.php)
require_once getPathIncApp()."functions-app.php"; // this app's functions (custom functions that extend the app should be in functions-custom.php)
require_once getPathIncApp()."init-app.php"; // this app's initialization routine
require_once getPathCustom()."functions-custom.php"; // this app's custom functions created by the org that installed it

/*
    ***************************************************************************
    CHECK SITE LEVEL ACCESS
	***************************************************************************
*/

// check site-level access - is https required? is access restricted by ip?
// this is for site level access, individual pages/zones are set by zone-restrict-allow-ip[zone-name] in config and restrictedZone("zone-name") added to respective pages
checkSiteLevelAccess(); 

/*
    ***************************************************************************
    SET DEFAULT TIMEZONE
	***************************************************************************
*/

// if timezone is provided in the config, use it
if( isset( getCfg("header")['timezone'])) {
	date_default_timezone_set(getCfg("header")['timezone']);
}

/*
    ***************************************************************************
    INITIALIZE THE $app VARIABLE
	***************************************************************************
*/

$app = array();
$app['debug'] = false; //true|false - enables logging and output, can be overriden by ?debug=true in query string. server and ip locks can be put in place
$app['log']['event'] = array();
$app['log']['api'] = array();
$app['start_time'] = 0;
$app['end_time'] = 0;
$app['exe_time'] = -1;
$app['load_time'] = 0;
$app['phpversion'] = phpversion();

/*
    ***************************************************************************
	CHECK DEBUG FLAG
	---------------------------------------------------------------------------

	Checks if the debug param was sent and then the config settings, etc to see
	if a switch to debug mode can be authorized based upon ip and host.

	***************************************************************************
*/

setDebugSwitch();

/*
    ***************************************************************************
	LOAD IN OPTIONAL LIBRARIES
	---------------------------------------------------------------------------

	If sixtythreeklabs_php_app_enable_optional_libs was defined, then load them
	in.

	***************************************************************************
*/

if ( defined("sixtythreeklabs_php_app_enable_optional_ext") ) {
	foreach (sixtythreeklabs_php_app_enable_optional_ext as $ext) {
		require_once getPathIncLib()."php-project-framework/".$ext.".php";
	}
}

/*
    ***************************************************************************
	SET EXECUTION START TIME
	---------------------------------------------------------------------------

	This is used to determine the length of time this script ran. It does not
	take into account the init of this script which that happened at the start
	of this (such as the read in of	config.ini.php). That is all overhead and 
	could in the future be counted separately. This should capture the
	execution time of the application.

	***************************************************************************
*/

// capture the framework load time first
$app['load_time'] = microtime(true) - $phpProjectFramework_loadstart;
unset($phpProjectFramework_loadstart);

// begin the app execution stopwatch
setExeStartTime();

?>