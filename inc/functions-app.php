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
		FRAMEWORK FILE: inc/functions-app.php
		FRAMEWORK FILE VERSION: 2018-03-19

	********************************************************************************************
	============================================================================================
*/

/*  ============================================================================================
    ********************************************************************************************
    APP FUNCTIONS
	********************************************************************************************
*/




	// [place all of your core functions and code here]
	// [code]
	// [code]
	// [code]




/*  ============================================================================================
    ********************************************************************************************
    REQUIRED FUNCTIONS
	********************************************************************************************

	These functions are required for use with inc/lib/php-project-framework but are up to you
	to develop and extend for your needs

	********************************************************************************************
*/

/* **************************************************************************
 *  userIsAdmin()
 *
 */

function userIsAdmin() {
	return false;
}

/* **************************************************************************
 *  userIsUser()
 *
 */

function userIsUser() {
	return false;
}

/* **************************************************************************
 *  getSecrets()
 *
 *  Modify code to list any application variables that contain secrets which
 *  should not be divulged during debug print outs.
 *
 *  Powerful, indeed, but someone has to know what to redact
 */

function getSecrets() {

	// these are examples, replace them with your own
	$secrets[] = getCfg("security")['oauth_secret'];
	$secrets[] = getCfg("security")['oauth_clientid'];
	$secrets[] = getCfg("security")['api_key'];
	$secrets[] = getCfg("someApiService1")['apiKey'];
	$secrets[] = getCfg("someApiService2")['apiKey'];
	$secrets[] = getCfg("security")['password-hash'];
	$secrets[] = getCfg("security")['google-authenticator'];
	$secrets[] = getCfg("security")['key-store'][0];
	$secrets[] = getCfg("security")['key-store'][1];
	$secrets[] = getCfg("security")['key-store'][2];
	$secrets[] = getCfg("security")['key-store'][3];
	$secrets[] = getApp("user")['password-hash'];

	// if new secrets are added during development, place them here

	return $secrets;
}

?>