# PHP-project-framework Changelog

## 2020-04-18

Updated directory paths for easier installation and separation.

## 2020-06-09

If debug IP and debug HOST is set in config, and the app is running on a server that allows debug, then PHP error reporting is automatically turned on.

With this, error reporting is commented out in public/inc/inc.php. However, debugging won't be turned on until after app init. If you need to find errors before config loads, uncomment in public/inc/inc.php.