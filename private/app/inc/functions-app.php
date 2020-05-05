<?php
/*
===============================================================================
*******************************************************************************
[NAME OF APPLICATION]: Application Functions
*******************************************************************************

FILE LAST MODIFIED: YYYY-MM-DD - [dev name]

PURPOSE: Initialize the Application

-------------------------------------------------------------------------------

[ place your comments about this script file here ]

[ place your comments about this script file here ]

-------------------------------------------------------------------------------

This is a function template file from the PHP PROJECT FRAMEWORK library.
Visit github.com/chadkluck/php-project-framework page for more information.
FRAMEWORK FILE: private/app/inc/functions-app.php
FRAMEWORK FILE VERSION: 2020-04-20

*******************************************************************************
===============================================================================
*/

/*
===============================================================================
*******************************************************************************
APP FUNCTIONS
*******************************************************************************

Add any app-wide functions below.
Add any app-wide runtime init routines in inc-app.php

*******************************************************************************
*/


// function someAppFunction() {}


/*
===============================================================================
*******************************************************************************
REQUIRED APP FUNCTIONS
*******************************************************************************

These functions are required for use with inc/lib/php-project-framework but 
are up to you to develop and extend for your needs

*******************************************************************************
*/


/**
 * Is the user an admin?
 * 
 * Logic may be included to determine if the user is an admin. This is a 
 * required function because it directly interacts with php-project-framework
 * 
 * @return Boolean
 */

function userIsAdmin() {
	return false;
}

/**
 * Is the user authorized as user?
 * 
 * Logic may be included to determine if the user is authorized to perform
 * basic user level actions. This is a required function because it directly
 * interacts with php-project-framework
 * 
 * @return Boolean
 */

function userIsUser() {
	return false;
}


?>