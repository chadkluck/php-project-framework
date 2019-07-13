# php-project-framework

This is the template I use to quickly get small apis and microsites off the ground. It is scalable as additional functionality can be coded in as needed. It is also very modular and can quickly be developed into a web application that is easily shared.

It includes a debug mode (just add ?debug=true) to any page call, debug restrictions (you can set it to only allow the debug parameter when accessed via an ip range, or on a server with a specified test domain), allow the apis to be locked down by requestor, and more.

Demo: https://demo.63klabs.net/php-project-framework

The demo shows what you should see right after uploading to a web server. It can be customized from there.

# Who is this for?

Anyone developing a simple web application that needs to return a web page or JSON data. I have used it to develop several apps including micro sites, simple Restful APIs that access a backend datasource, simple web service utilities, and more.

## Built in features with security in mind

1. Restrict access to all pages/apis by IP range, or certain pages/apis by IP range
2. Restrict access to API by origin, IP, or key
3. Debug mode that can detect difference between production and development server (so debug can't be accessed when deployed to production) and debug can be restricted to certain IPs
4. Core framework is separated from custom code and comes with many utility functions to assist with rapid development
5. Built in functions to safely store and access config variables and application variables.

# Templates

There are 3 template areas. Some are a library, some are used by you, the developer, and some are updated by the end user you are developing the application for. Note that "end user" is the person installing the application you created onto their own server and configuring it to run on their server. If you are developing this application for your own use then you are your own end user.

1. /inc/lib/php-project-framework: These files shouldn't be modified unless you wish to ignore any future updates of the PHP Project Framework. These are maintained by chadkluck.
2. api.php, index.php, and /inc/: These files are yours to develop as well as any other file you create. Add access to data sources such as AWS, MySQL, other APIs, etc.
3. /custom/: This directory is where you can invite those who install your application to make modifications to customize the config and add their own functions to extend your application. Any changes you make as the application developer should not affect any customizations made by the end user.

# Usage

The files are heavily commented to walk you through so visit them in this order:

1. After uploading, copy/rename the "\_custom" directory to "custom" (This will prevent overwrites from the repository) It is recommended that if you plan on releasing your application in it's own git repository that you rename the "custom" directory to "\_custom" so you don't overwrite your users' data.
2. Visit yourdomain.com/path/index.php to see a Hello World web page. Then click on the link to see api.php return sample JSON data. If you see these pages correctly, you're ready to continue and develop it into your own application.
3. custom/config.ini.php - you can store config variables here - these won't change during execution and you can expect your end user to update them for their own installation. Access these variables by calling getConfig(sectionName)[variablename] All other config variables contained within are commented. Feel free to add your own as neccessary for your application.
4. index.php and api.php - duplicate, move, and rename as needed. These are templates for the html and api pages you create for your application.
5. inc/app-functions.php - add the functions for your application

# Need inspiration?

The following repositories were built on this framework:

1. https://github.com/chadkluck/8ball-api
2. https://github.com/USTLibraries/exlibris-api-example
3. https://github.com/USTLibraries/eluna-2019
4. https://github.com/USTLibraries/library-help-lti
5. https://github.com/USTLibraries/umwug-2018
