<?php
/*  ============================================================================================
    ********************************************************************************************

	APPLICATION CONFIGURATION
	[NAME OF APPLICATION] | [github url for your application if applicable]
	[your name/company name]
	[your website]
	Last Modified: [date/version]
	[ any copyright or other info ]

	********************************************************************************************

	[ NOTE: this is a template file for "Application Developers," the ones who create the
	  application and distribute it. "End User" is the individual you are developing for, the one
	  who will ultimately download and install your code. You will find comments both for the
	  Application Developer as well as the End User in this custom directory. Try to keep them
	  straight. The "End User" should only be asked to maintain their code and variables in the
	  custom directory as it will not be overwritten during updates. Also, it is advised that the
	  application developer not modify anything in the php-project-framework directory. ]

	[ place your comments about this script file here ]

	[ place your comments about this script file here ]


	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: custom/inc.php
		FRAMEWORK FILE VERSION: 2018-10-22

		NOTE: This application WILL work out of the box without any modifications to this file

		This file allows custom modifications and since it is in the custom/ directory of this
		php application it will not be overriden by Git requests.

		Very little if anything needs to be changed (beyond the strong recommendation of
		changing the ERROR REPORTING section. Beyond that it''s only if you want to lock down
		some code to meet best practices or add your own custom code at the end.

		In the unlikely event that there is a new base template for this file available from
		the git repository, the $inc_config_version will be flagged with instructions to
		manually update this file. However, we will strive for backwards compatibility to make
		sure nothing breaks while waiting for a manual update.

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