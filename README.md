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

1. /private/lib/php-project-framework: These files shouldn't be modified unless you wish to ignore any future updates of the PHP Project Framework. These are maintained by chadkluck.
2. /public/api.php, /public/index.php, and /private/app/: These files are yours to develop as well as any other file you create. Add access to data sources such as AWS, MySQL, other APIs, etc.
3. /public/assets/custom/, /private/app/custom/: These directories are where you can invite those who install your application to make modifications to customize the config and add their own functions to extend your application. Any changes you make as the application developer should not affect any customizations made by the end user.

# Install

1. Upload contents of private into a private directory
2. Upload contents of public into a public (web facing directory)
3. Update {public}/inc/inc.php with the location of your private directory
4. Update {private}/app/custom/config.ini.php

The default the following file structure is assumed:
- {serverpath}/private/ (directory not accessible to the web)
- {serverpath}/public/ (directory accessible to the web-sometimes called web, www, etc)

If you only have access to a public directory (no access to directories below it) then the private directory CAN be placed inside the Public directory. See options below.

Assumed paths:

- /home/var/you/
    - public/ (web/www/public - where you put your http accessible files)
        - inc/ 
            - (only has the inc.php file which all pages first include)
        - assets/
            - custom/ (a place for your client to install own custom assets such as js, css, fonts, etc)
            - (additional directories/files for your application: css, js, fonts, etc)
    - private/
        - lib/
            - php-project-framework
            - (other libraries)
        - app/
            - (all of your php files to make the script run)

It is important to note, if you change the location of private/, lib/, or rename app/, additional configuration needs to take place. See Advanced Configuration.

If you maintain the public/private folder structure (public can be renamed web, www, public, etc without add'l config) installation is pretty straight forward and you can use the Basic Installation.

## Basic Installation

This installation assumes you have a private and a public directory. The public directory is the directory that is exposed and accessible to the web and may be named www, web, public, etc. It does not matter what the public directory is named. In this documentation whenever "public" is mentioned, it should be assumed that it is whatever you have your "public" directory named.

The private directory is a sibling to the public directory. For example, you SFTP to your site and the base shows two directories, public and private. The private directory can be moved or renamed, but you'll need to update some additional settings (see Advanced Installation)

The files are heavily commented to walk you through so visit them in this order:

1. Visit yourdomain.com/index.php to see a Hello World web page. Then click on the link to see api.php return sample JSON data. If you see these pages correctly, you're ready to continue and develop it into your own application.
2. /private/app/custom/config.ini.php - you can store config variables here - these won't change during execution and you can expect your end user to update them for their own installation. Access these variables by calling getConfig(sectionName)\[variablename\] All other config variables contained within are commented on. Feel free to add your own as neccessary for your application.
3. /public/index.php and /public/api.php - duplicate, move, and rename as needed. These are templates for the html and api pages you create for your application.
4. /private/app/inc/app-functions.php - add the functions for your application

## Advanced Installation

Follow the steps under Basic Installation with the following exceptions.

### Private

If you only have access to a folder that is exposed to the web, then you may need to place your private folder within your publicly accessible public folder.

There is already an .htaccess file in the private folder that will prevent access to the contents of the private folder. Go to yourdomain.com/private or yourdomain.com/pathto/private and test it out. If you do not receive a 400 error then you may need to explore other security options.

If you have moved or renamed the private folder from the default option, you will need to update the following line in /public/inc/inc.php with the correct path.

`sixtythreeklabs_php_app_private_directory_location = __DIR__."../../private/";`

Change to:

`sixtythreeklabs_php_app_private_directory_location = {directpath}/";`

Don't forget the final /

### App Directory

By default the app's code is stored in /private/app/

You may wish to have several apps installed and rename "app" to "myawesomeapp"

Rename the folder and then update the following line in /public/inc/inc.php with the correct name.

`CONST sixtythreeklabs_php_app_name = "app"; `

Change to:

`CONST sixtythreeklabs_php_app_name = "myawesomeapp"; `

And rename /private/app/ to /private/myawesomeapp/

### Moving the public assets folder.

Got a CDN to serve your app's assets? Update the path for assets to point to the web address. (https://cdn.example.com)

This happens in the /private/app/custom/config.ini.php  under \[paths\]

`assets = ""`

## Your first application

### index.php

This is an example of an HTML web page. You'll notice the following:

`require_once __DIR__."/inc/inc.php"; `

Needs to go at the top of every page, this brings in all of your application's functionality. If you move, or create another index page, in say, /public/about/index.php
you will need to update this to: `require_once __DIR__."/../inc/inc.php";`

Be sure to leave the \_\_DIR\_\_ but append `/..` to the path. Think of it as `cd ..` where you need to go up one directory (exit out of about/) and switch over to the inc directory.

You'll also notice a php code section for processing any data before displaying the page. Right now it has a simple title variable.

Next you'll see a call to a function `getPathAssets();`. By default this will return /assets/ but if you were to set a CDN or other location in config.ini.php you can certainly do so if the assets are not located on the current domain. Note that `getPathAssets()` only lists the path of the assets folder. You will have to add anything like `css/site.css` or `custom/custom.css` as like in the example.

Finally, at the very bottom, you'll see some debug script. It is currently a little bit of a hack, but future development should move this into a single function call. We'll get to this in more depth in the next section.

### api.php

This file can be moved to another directory and renamed index.php if that directory serves the api. You can also delete index.php if you are not serving web pages and rename api.php to index.php and serve apis that way. (calling yourdomain.com/ will then invoke it as the api file is now index.php)

Just like in index.php you'll see an include to get the party started with the app. Be sure you have the correct path to inc/ by adding the right number of /..

Next you'll see the function `generateResponse()`. This is called by the body of the script. You can place all your code in here, or separate it out into smaller functions. You should store your common application functions in /private/app/inc/functions-app.php. This file is automatically included during init so no need to add an include.

Next you'll see an if block with `if(isApprovedOrigin(TRUE))`. This function performs a CORS check. TRUE means the function should handle any CORS errors. If set to FALSE you could do an else and provide a custom message.

There are additional functions to add if you want to restrict access to the api (or any page) based on IP or API Key. That is beyond the scope of this README. Refer to function documentation.

Finally, at the very bottom, you'll see some debug script. It is currently a little bit of a hack, but future development should move this into a single function call.

In config.ini.php, if you have `allow-debug = 1` and `allow-debug-ip = /^10\./` and `allow-debug-host = "/dev\.yourdomain\.com$/i"` (where allow-debug-ip is an authorized IP range and allow-debug-host is one of your development servers) you can append ?debug=true to your page/api request and receive a lot of debugging information.

To add debug info to your code just use `logMsg($message [, $dataArray])` where $message is your message and $dataArray is an optional array of data you can pass on to log.

By default since allow-debug-host = "" upon first install, you are not able to run the debug command unless you add the current domain to the config.ini.php file as an allowable
debug host. It is not recommended adding publicly available servers (especially production) to the list of allowable hosts. However, setting an IP range can help.

### Creating new files

The one requirement is that `require_once __DIR__."/inc/inc.php";` be located at the top with the correct path.

Assuming public/inc/inc.php:

- public/checkmyip/index.php would require: `require_once __DIR__."/../inc/inc.php";`
- public/checkmyip/byregion/index.php would require: `require_once __DIR__."/../../inc/inc.php";`
- public/api/v1/index.php would require: `require_once __DIR__."/../../inc/inc.php";`
- public/api/index.php would require: `require_once __DIR__."/../inc/inc.php";`
- public/mypage.php would require: `require_once __DIR__."/inc/inc.php";`

For api pages use api.php as a tempalte. Remember, you can use whatever filename you want, including index.php so you can call your api like this:

https://example.com/api/v1/

### public/assets

As mentioned earlier, you can use the function to keep your asset path up to date if you (or your client) moves the location of the asset folder (such as to a CDN)

`<?php echo getPathAssets(); ?>main.css` by default will echo `/assets/main.css` but if config.ini.php `\[paths\] assets` was set to `https://cdn.example.com/` then it would echo `https://cdn.example.com/main.css`. (Be sure to include the final / when setting `\[paths\] assets` !)

Walk through the following steps to see how public/assets works.

Modify /public/assets/example-api-call.js

1. Change `apiURL: "/api.php",` to `apiURL: "https://api.chadkluck.net/games/",` (around line 55)
2. Change `data.items.forEach(function(element)` to `data.gamechoices.forEach(function(element)` (around line 208)

Test it out.

Modify /public/assets/main.css

1. Add `#demo-call-to-api { color: #339933; font-weight: 900; background-color: black; }`

Test it out.

Make a copy of main.css and place it in /public/assets/custom/

Then in index.php change `<link rel="stylesheet" type="text/css" href="<?php echo getPathAssets(); ?>main.css">` to `<link rel="stylesheet" type="text/css" href="<?php echo getPathAssets(); ?>custom/main.css">` (by adding custom/ in front of main.css)

Test it out.

You can use the custom folder in Assets to allow your clients the ability to provide their own JS and CSS. Be sure you either implement link and script tags that call default files in custom or provide a way that they can be included by your application. (You can add additional variables to the config.ini.php file and add functions that use them)

### private/app/inc/


### private/app/custom/


### private/app/custom/config.ini.php

# Need inspiration?

The following repositories were built using this framework:

1. https://github.com/chadkluck/8ball-api
2. https://github.com/USTLibraries/exlibris-api-example
3. https://github.com/USTLibraries/eluna-2019
4. https://github.com/USTLibraries/library-help-lti
5. https://github.com/USTLibraries/umwug-2018