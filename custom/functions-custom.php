<?php
/*	============================================================================================
	********************************************************************************************
	[NAME OF APPLICATION]: Custom Functions for Application
	********************************************************************************************

	FILE LAST MODIFIED: YYYY-MM-DD - [dev name]

	PURPOSE: Custom functions for application

	********************************************************************************************

	Place your custom functions in this file so they won''t be over written by git requests.

	[ application developer: place your comments about any template functions here ]

	********************************************************************************************
	********************************************************************************************

		This is function template file from the PHP PROJECT FRAMEWORK library.
		Visit github.com/chadkluck/php-project-framework page for more information.
		FRAMEWORK FILE: inc/inc-app.php
		FRAMEWORK FILE VERSION: 2018-10-30

	********************************************************************************************
	============================================================================================
*/


/*	============================================================================================
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

/* [ application developer: you can add function templates here. For example, if your application
     makes use of a foo() function that the end user is able to customize without worry of being
     over written in an application update, place the template for foo() here along with comments
     to document how the end user can update it ]
*/

/* *********************************************************************************************
 * foo()
 *
 * A function that does something custom
 *
 */

function foo() {
	/* do something custom */
}

/* *********************************************************************************************
 * bar()
 *
 * A function that does something custom, and uses the $app variable
 *
 */

function bar() {
	global $app; // we are going to change app variables so we need to call it from global

	$app['bar'] = "42"; // we change the app variable "bar" to "42"

	return getApp("bar"); // we return the value of bar using the safe getApp function
}

?>