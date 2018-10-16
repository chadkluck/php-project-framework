# php-project-framework

This is the template I use to quickly get small apis and microsites off the ground. It is scalable as additional functionality can be coded in as needed.

It includes a debug mode (just add ?debug=true) to any page call, debug restrictions (you can set it to only allow the debug parameter when accessed via an ip range, or on a server with a specified test domain, allow the apis to be locked down by requestor, and more.

# Usage

The files are heavily commented to walk you through so visit them in this order:

1. custom/config.ini.php - you can store config variables here - these won't change during execution. Access them by calling getConfig(sectionName)[variablename]
2. index.php and api.php - duplicate, move, and rename as needed. These are templates for the html and api pages you create.
3. inc/app-functions.php - add your functions here
