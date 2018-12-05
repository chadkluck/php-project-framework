<?php
/*  ============================================================================================
    ********************************************************************************************
	[NAME OF APPLICATION]: Application Configuration Initialization
    ********************************************************************************************

	[your name/company name] ([your website])
	[github url for your application if applicable]

	********************************************************************************************

	FILE LAST MODIFIED: YYYY-MM-DD - [dev name]

	PURPOSE: Brings in the config file

	********************************************************************************************

	********************************************************************************************
	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: custom/inc.php
		FRAMEWORK FILE VERSION: 2018-10-30

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
	********************************************************************************************

	THE ONLY THING THAT IS CUSTOMIZABLE IN THIS FILE IS ERROR REPORTING!
	Do not update anything else!

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
    ********************************************************************************************
    ERROR REPORTING - CUSTOMIZABLE
	********************************************************************************************

		These 2 lines should be commented out after installation in a production environment

		This is the only customizable part of this file.

	============================================================================================
*/

ini_set('display_errors',1); // comment out when in production
error_reporting(E_ALL); // comment out when in production

/*  ============================================================================================
    ********************************************************************************************
    CONFIG VARIABLE - Now compatible with PHP 7.x and above only
	********************************************************************************************

		Since PHP 5.x is reaching end of life the template will use 7.x methods and not
		be backwards compatible. This will simplify the setup process.

		7.x allows arrays to be declared as CONSTANTS so we will get rid of the 5.x ways of doing
		things. If you, for what ever reason, need the 5.x way of doing things then refer to an
		older repository.

	============================================================================================
*/

// calls in the config.ini.php file and places it in the CONSTANT variable CFG
define('CFG', parse_ini_file("config.ini.php", true, INI_SCANNER_NORMAL ));

// getCfg() is the function used to access the constant variable CFG
function getCfg( $index = NULL ) {
	return ( $index ? (isset( CFG[$index] ) ? CFG[$index] : NULL ) : CFG );
}

/*  ============================================================================================
    ********************************************************************************************
    APP LEVEL INCLUDES - DO NOT MODIFY
	********************************************************************************************

		Do not modify this part, it is the engine that brings in files and include paths.

		However, if you were to modify it, it is here so that you may do so.... with the
		understanding that doing so may break things and it is best practice to just update the
		paths section in the config.ini.php file.

	============================================================================================
*/

// do not modify without good reason
function getPathIncApp() { return ( getCfg("paths")["inc_app"] ? getCfg("paths")["inc_app"] . "inc/"     : __DIR__."/../inc/" ) ; }
function getPathIncLib() { return ( getCfg("paths")["inc_lib"] ? getCfg("paths")["inc_lib"] . "inc/lib/" : __DIR__."/../inc/lib/" ) ; }
function getPathAssets() { return ( getCfg("paths")["assets"]  ? getCfg("paths")["assets"]  . "assets/"  : "assets/" ) ; }

// do not modify without good reason
$inc_config_version = "1.2"; // in the unlikely event this file needs to be manually updated from the repository
								// this will let you know if you need to replace this file with a new version
								// If you do, be sure to copy over your modifications!

// do not modify without good reason
require_once( getPathIncLib()."php-project-framework/functions.php" ); // php-project-framework functions
require_once( getPathIncApp()."functions-app.php" ); // this app''s functions
require_once( getPathIncApp()."inc-app.php" ); // this app''s initialization


/*  ============================================================================================
    ********************************************************************************************
    CUSTOM VARS AND FUNCTIONS
	********************************************************************************************

		functions-custom.php is where the end user (the one who installed the application)
		can place custom code and functions to extend the application. The application developer
		can create template functions and place them in functions-custom.php for the installer
		to modify without worry of being overwritten during updates.

		See comments in functions-custom.php for more information.

	============================================================================================
*/

require_once( "functions-custom.php" );

?>