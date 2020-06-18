<?php
// lock down - turn off errors
ini_set('display_errors', '0'); // Do not modify - error reporting will automatically be turned on for specified hosts and IPs
error_reporting(0); // Do not modify - error reporting will automatically be turned on for specified hosts and IPs
/* 
===============================================================================
*******************************************************************************
PHP PROJECT FRAMEWORK INITIALIZATION SETTINGS
*******************************************************************************

This script file locates the initialization settings to get the app running

Version: 2020-06-16

*******************************************************************************
===============================================================================
*/


/* UNCOMMENT THESE LINES FOR ADDITIONAL ERROR REPORTING BEFORE CONFIG LOADS
   When in production these lines should be commented out. If debug host and IP
   is set in config then they are automatically enabled when running on dev/test
   hosts. This is only if you see errors before config file loads or if you see
   errors in production that you don't see in dev/test. Looking at your server
   error logs is also an option :) Explore your options before uncommenting
   these. You don't want php errors showing to the end user in production.
   You've been warned. */
//ini_set('display_errors',1); // comment out when in production - display errors
//ini_set('display_startup_errors', 1); // comment out when in production - display startup errors
//error_reporting(E_ALL); // comment out when in production - display all errors


/*
*******************************************************************************
1. SET THE APP NAME (Optional)
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

// Uncomment and modify if you are loading in optional php-project-framework extensions
//define("sixtythreeklabs_php_app_enable_optional_ext", ["cache-proxy"]);

// DO NOT MODIFY THIS LINE
require_once sixtythreeklabs_php_app_private_directory_location . "lib/php-project-framework/init.php";

?>