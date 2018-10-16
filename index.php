<?php
// web page example - for an api returning json data see api.php

require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

$myParam = getParameter("myparam"); // This is an example of accessing get/post parameters, returns NULL if particular param wasn''t passed - use this anywhere in your code

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Template Example of HTML Page</title>
	</head>

	<body>

		<!-- an example of including a script from your Application Include Path -->
		<?php include getPathIncApp() . "template/body.php"; ?>

		<!-- an example of including a script from one of the libraries in your application -->
		<?php require_once getPathIncApp() . "somelib/display.php"; ?>

		<!-- an example of including a script from your web assets -->
		<script src="<?php echo getPathAssets(); ?>js/main.js"></script>

	</body>
</html>
<!-- optional, but sets debug info and will display if debug mode is enabled -->
<?php appExecutionEnd(); ?>