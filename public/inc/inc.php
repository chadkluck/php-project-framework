<?php
// lock down - turn off errors
ini_set('display_errors', '0'); // Do not modify - see below
error_reporting(0); // Do not modify - see below
/* 
===============================================================================
*******************************************************************************
PHP PROJECT FRAMEWORK INITIALIZATION SETTINGS
*******************************************************************************

This script file locates the initialization settings to get the app running

*******************************************************************************
===============================================================================
*/


/*
*******************************************************************************
1. TURN ON ERROR REPORTING FOR DEVELOPMENT AND DEBUG
-------------------------------------------------------------------------------

When in production, these lines should be commented out
Uncomment these lines when in development/troubleshooting

*******************************************************************************
*/

// UNCOMMENT THESE LINES FOR ADDITIONAL ERROR REPORTING
ini_set('display_errors',1); // comment out when in production - display errors
ini_set('display_startup_errors', 1); // comment out when in production - display startup errors
error_reporting(E_ALL); // comment out when in production - display all errors


/*
*******************************************************************************
2. SET THE APP NAME (Optional)
	Default is "app"
-------------------------------------------------------------------------------

This will correspond to the app directory in the private directory
For example "app-news" will point to private/app-news
By default "app" points to private/app

This allows you to have several apps using the framework installed on one
server and all can utilize the same php-project-framework library and other
libraries.

Set the location of the private directory where app and library files 
are located. If you are using a private/public or private/web folder
structure (where your base directory for you public site is located in
web or public) then there is no need to modify 
sixtythreeklabs_php_app_private_directory_location

*******************************************************************************
*/

// Modify the values if needed
CONST sixtythreeklabs_php_app_private_directory_location = __DIR__."/../../private/"; // by default assumes there is a private directory up two directories from this one. (../../private/)
CONST sixtythreeklabs_php_app_name = "app"; // Corresponds to the app directory in /{path-to-private}/app - you can rename this if you have mulitple apps that such as "app-8ball"

// DO NOT MODIFY THIS LINE
require_once sixtythreeklabs_php_app_private_directory_location . "lib/php-project-framework/init.php";

/*
*******************************************************************************
3. ENABLE/DISABLE PHP-PROJECT-FRAMEWORK EXTENSIONS (Optional)
-------------------------------------------------------------------------------

In the future there may be additional modules included in php-project-framework

They may be enabled/disabled by including or commenting out their inclusion

*******************************************************************************
*/

// Cache-Proxy - Provides caching for api and curl requests (github.com/USTLibraries/cache-proxy)
//require_once getPathIncLib() . "php-project-framework/cache-proxy.php"; 

?>