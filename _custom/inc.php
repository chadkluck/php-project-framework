<?php
/* 
	===========================================================================
	***************************************************************************
	PHP PROJECT FRAMEWORK INITIALIZATION
	***************************************************************************

	This script file handles how errors should be displayed and where the 
	config.ini.php and init.php files are located before the application
	has a chance to init (in case they were moved outide of the app's path).

	***************************************************************************
	===========================================================================
*/

/*
	***************************************************************************
	DISPLAY ERRORS
	---------------------------------------------------------------------------

	Comment out these two lines when in production! It is best to leave these
	commented out and only uncomment when debugging. These two lines will
	display errors to visitors which is bad practice. Since they are called
	before debug mode can be verified and enabled, they function without
	reguards to debug settings.

	While developing and troubleshooting you can set error settings here.

	Again, NOTE! debug=true has no effect on these during init! So if you
	have errors during init and the below is set to not display errors, then
	debug param will have no effect! Debug is only for application runtime,
	not init! Once the application is loaded after init, then and only then
	will debug turn on error reporting.

	***************************************************************************
*/

/* 	
	PRODUCTION - No Error Reporting
	You can leave these two lines uncommented and only uncomment/comment out 
	the lines in the DEVELOPMENT AND DEBUG section when in production. 
*/
ini_set('display_errors', '0'); // Do not display errors step 1
error_reporting(0); // Do not display errors step 2

/*	
	DEVELOPMENT AND DEBUG - Turn on Error Reporting
	Uncomment these two lines when in development/troubleshooting, comment out 
	when in production.
*/
ini_set('display_errors',1); // comment out when in production
ini_set('display_startup_errors', 1); // comment out when in production
error_reporting(E_ALL); // comment out when in production

/*
	***************************************************************************
	CONFIG and INITIONALIZATION FILES
	---------------------------------------------------------------------------

	init.php calls in the config.ini.php file and all the additional framework
	includes necessary to run the application. Since the config file has not
	yet been loaded the locations are only assumed by the application.

	If the application's /custom and /inc directories were moved outside of
	the applications public web install directory, these need to be updated
	below.

	Set the location of the config and project-framework files to where they 
	were moved. If using the default location (/custom and /inc/lib) then there
	is no need to set.

	----------------------------------------------------------------------------

	App specific includes that extend the framework should be included in
	inc/inc-app.php, not here.

	***************************************************************************
*/
// Replace these with the exact server path to these files
$config_ini_file = __DIR__."/config.ini.php"; // default = __DIR__."/config.ini.php"; // (/custom/config.ini.php)
$php_project_framework_dir = __DIR__."/../inc/lib/php-project-framework/init.php"; // default = __DIR__."/../inc/lib/php-project-framework/init.php"

require_once $php_project_framework_dir;

?>