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

	[ place your comments about this script file here ]

	[ place your comments about this script file here ]


	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: custom/inc.php
		FRAMEWORK FILE VERSION: 2018-03-19

		NOTE: This application will work out of the box without any modifications to this file

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
    ERROR REPORTING - CUSTOMIZABLE PART 1
	********************************************************************************************

		These 2 lines should be commented out after installation in a production environment

		This is the first customizable part of this file. Part 2 is in the next section below
		and Part 3 is located at the end.

	============================================================================================
*/

ini_set('display_errors',1); // comment out when in production
error_reporting(E_ALL); // comment out when in production

/*  ============================================================================================
    ********************************************************************************************
    CONFIG VARIABLE - CUSTOMIZABLE PART 2
	********************************************************************************************

		The default method is to have $CFG declared as a global variable which is accessed via
		the getCfg() function. This works in all versions of PHP but doesn't adhere to the
		practice of declaring it as a CONSTANT variable (as CFG shouldn't be editable)

		However, if you are using PHP 7+ AND you want to protect $CFG from being modified,
		you can change it to a proper CONSTANT variable.

		CFG should only be accessed using getCfg() as that is a central point to change between
		referencing a proper CFG Constant and $CFG global.

		The only benefit of changing from global $CFG to a CONSTANT CFG is just a best practice.

		Find the line(s) in this code section preceded by "** CODE CHANGE: **"
		Followed by the comment "// php <7" or "// php 7+" and then
		follow the instructions of commenting out, or uncommenting

		When done skip to "CUSTOM VARS AND FUNCTIONS - CUSTOMIZABLE PART 2" below

	============================================================================================
*/

/* ** CODE CHANGE (choose 1): ** */
$CFG = parse_ini_file("config.ini.php", true, INI_SCANNER_NORMAL ); // php <7 (uncomment if using <7 || comment out if using php 7+)
//define('CFG', parse_ini_file("config.ini.php", true, INI_SCANNER_NORMAL )); // php 7+ (uncomment if using +7 || comment out if using php <7)

function getCfg( $index = NULL ) {

	/* ** CODE CHANGE (leave for <7): ** */
	global $CFG; // php <7 (uncomment if using <7 || comment out if using php 7+)

	/* ** CODE CHANGE (choose 1): ** */
	return ( $index ? (isset( $CFG[$index] ) ? $CFG[$index] : NULL ) : $CFG ); // php <7 (uncomment if using <7 || comment out if using php 7+)
	//return ( $index ? (isset( CFG[$index] ) ? CFG[$index] : NULL ) : CFG ); // php 7+ (uncomment if using +7 || comment out if using php <7)

}

/*  ============================================================================================
    ********************************************************************************************
    APP LEVEL INCLUDES - DO NOT MODIFY
	********************************************************************************************

		Do not modify this part, it is the engine that brings in files and include paths.

		However, if you were to modify it, it is here so that you may do so.... with the
		understanding that doing so may break things and it is best practice to just update the
		paths section in the config.ini.php file.

		Skip to "CUSTOM VARS AND FUNCTIONS - CUSTOMIZABLE PART 3" below

	============================================================================================
*/

// do not modify without good reason
function getPathIncApp() { return ( getCfg("paths")["inc_app"] ? getCfg("paths")["inc_app"] . "inc/"     : __DIR__."/../inc/" ) ; }
function getPathIncLib() { return ( getCfg("paths")["inc_lib"] ? getCfg("paths")["inc_lib"] . "inc/lib/" : __DIR__."/../inc/lib/" ) ; }
function getPathAssets() { return ( getCfg("paths")["assets"]  ? getCfg("paths")["assets"]  . "assets/"  : "assets/" ) ; }

// do not modify without good reason
$inc_config_version = "1.1"; // in the unlikely event this file needs to be manually updated from the repository
								// this will let you know if you need to replace this file with a new version
								// If you do, be sure to copy over your modifications!

// do not modify without good reason
require_once( getPathIncLib()."php-project-framework/functions.php" ); // php-project-framework functions
require_once( getPathIncApp()."functions-app.php" ); // this app''s functions
require_once( getPathIncApp()."inc-app.php" ); // this app''s initialization


/*  ============================================================================================
    ********************************************************************************************
    CUSTOM VARS AND FUNCTIONS - CUSTOMIZABLE PART 3
	********************************************************************************************

		This is where you can place custom code such as variables, functions, includes, and php

		Why is this allowed? Suppose you want to override app functions or add a logging
		mechinism. These can be "safely" added here. "safely" meaning they won't be overriden
		by Git updates. You're on your own for security.

		Anything in the custom dir will not be updated/replaced on git requests (in theory) so
		anything you add to these files should remain untouched during updates.

		Use it wisely, though. Any code you place here should be self contained within this file.
		While you can include some of your own includes with functions you should be careful
		about updating any other application file outside of the custom directory if you are
		planning on updating from the public git repository.

	============================================================================================
*/

// custom code here:
// NOTE: This is not for application functions - this is for the end user to place own custom code
// if you are developing an application based upon the php-project-framework place all code in
// inc/functions-app.php


?>