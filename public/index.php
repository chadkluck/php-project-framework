<?php
// html example
require_once __DIR__."/inc/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

/* **********************************************
 *  START
 */

// begin any pre-processing

$pageTitle = "Hello World";

?><!DOCTYPE html><html>
<head>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo getPathAssets(); ?>main.css">
</head>
</body>

<h1>Hello World!</h1>

<p><a href="api.php">Check Raw API</a></p>

<p><a href="https://github.com/chadkluck/php-project-framework">Check out php-project-framework on GitHub</a></p>

<h2>Demo Call to API</h2>
<p>The list below is created by a JavaScript API call to the <a href="api.php">api.php</a> file on this site.
<div id="demo-call-to-api"></div>

<script src="<?php echo getPathAssets(); ?>example-api-call.js"></script>

<?php
if(debugOn()) {
    appExecutionEnd();
}

?></body></html>