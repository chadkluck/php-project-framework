;<?php
;die(); // contents of this file shouldn''t be seen on the web.
;/*
; This is your configuration file
; Comments start with ';' as in php.ini

;   ============================================================================================
;   ********************************************************************************************

;	APPLICATION CONFIG FILE
;	[NAME OF APPLICATION] | [github url for your application if applicable]
;	[your name/company name]
;	[your website]
;	Last Modified: [date/version]
;	[ any copyright or other info ]

;	********************************************************************************************

;		This is function template file from the PHP PROJECT FRAMEWORK library.
;		Visit github.com/chadkluck/php-project-framework page for more information.
;		FRAMEWORK FILE: config/config.ini.php
;		FRAMEWORK FILE VERSION: 2020-04-18

;	********************************************************************************************
;	============================================================================================


; NOTE: plain text and numbers can be entered without quotes.
;       For more on editing ini files visit: http://php.net/manual/en/function.parse-ini-file.php

; NOTE: Regular Expressions are used. I recommend one of these testers:
;       https://regex101.com/
;       https://www.regextester.com/



[header]
; =======================================================================================
; HTTP HEADER SETTINGS
; These are values that configure the way requests are received and responded to


timezone = "UTC"
; FORMAT:      String
; DESCRIPTION: What timezone should be used? For a list of acceptable values see: http://php.net/manual/en/timezones.php
; DEFAULT:     "UTC"


allow-origin = ""
; FORMAT:      Regular Expression (eg "/foo/i")
; DESCRIPTION: What websites should be allowed to embed these pages? Typical for CORS for pulling the page into an iframe or javascripts accessing the api. Leave blank if you want to allow any website
; RECOMMENDED: "/^https?:\/\/(?:(?:[a-z0-9]+\.)*yourdomain\.com)$/i"
; DEFAULT:     ""


bad-origin-allow-ip = "/^10\./"
; FORMAT:      Regular Expression e.g. "/^10\./"
; DESCRIPTION: If the request is made by a site not allowed to embed, what IP range is allowed to override?
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are)
; DEFAULT:     ""


api-cache = 120
page-cache = 3600
; FORMAT:      Integer 0 through whatever
; DESCRIPTION: The number of seconds the browser should hold an api/page call in it''s cache
; RECOMMENDED: 3600 (1 hour) is good but adjust to your taste (NOTE: These are overriden with the value of 1 when DEBUG mode is invoked)
; DEFAULT:     3600


[security]
; =======================================================================================
; SECURITY SETTINGS
; Debugging, what''s allowed, etc.

; NOTE: In order to show a page in debug mode the debug parameter must be passed and set to 1 (true) in either a POST or GET
; For example when accessing via link (get) yourdomain.com/somepage/?debug=true


allow-debug = 1
; FORMAT:      1|0
; DESCRIPTION: Will we allow debugging which captures logs and outputs data to user at end of script run
; NOTE:        This does not turn debugging on, a debug param POST['debug']=1 or GET['debug']=1 must be sent with the page request
; RECOMMENDED: Set to 1 (true) when implementing/troubleshooting, 0 (false) when in production
; DEFAULT:     1 (just because of implementing. When not troubleshooting set to 0 (false) )


allow-debug-ip = "/^10\./"
; FORMAT:      Regular Expression (eg "/^10\./"
; DESCRIPTION: If we allow debugging what IPs are allowed to switch into debugging mode?
; NOTE:        allow-debug must still be set to 1 (true)
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are in) I recommend taking it down all the way to your actual IP or at least subnet
; DEFAULT:     ""


allow-debug-host = ""
; FORMAT:      Regular Expression (eg "/^https:\/\/yourtestserver\.yourdomain\.com$/i")
; DESCRIPTION: If we allow debugging what servers can we debug on? So if you have a separate test and production server debug will only be able to be switched on when in test environment
; NOTE:        allow-debug must still be set to 1 (true). This is typically just your domain with regex escape "\" in front of each / and .
; RECOMMENDED: If you have access to a test server, use it and put the domain here and use HTTPS only in the regex! "^https:\/\/" (requires https: at start) and NOT "^https?\/\/:" (http or https)
; DEFAULT:     ""


require-ssl = 1
; FORMAT:      1|0
; DESCRIPTION: Should HTTPS be forced?
; DEFAULT:     1


obfuscate-secrets = 1
; FORMAT:      1|0
; DESCRIPTION: If in debug mode, should we sanitize data before display, obfuscating secret keys, api keys, etc (e.g. *********dj7ixJ). Just in case you copy/paste/print/share while debugging
; NOTE:        This does not turn debugging on
; RECOMMENDED: Always set to 1 (true). Up to last 6 chars are shown so you can id key (half if key length is fewer than 6). Can''t think of a reason why you wouldn''t want this
; DEFAULT:     1


api_ipaccess = ""
; FORMAT:      regex
; DESCRIPTION: If this application will be accessed by other servers (not client-side scripts such as JavaScript running in the browser)
;			   You may restrict access by requiring the requesting server be from a designated ip address or range of ip addresses
; NOTE:        Code to check the api_key and IP address are not built into the framework, you will have to perform your own validation.
;              to authenticate access via client side scripts or applications. Hard coded tokens are a bad, bad, bad idea.
; DEFAULT:     ""




[paths]
; =======================================================================================
; FILE PATHS AND STORAGE

assets = ""
; FORMAT:      string
; DESCRIPTION: This is the path returned when getPathAssets() is called
;              "" will return "/assets/" (https://yourdomain.com/assets/)
;			   "https://cdn.yourdomain.com/yourapp/" will return "https://cdn.yourdomain.com/yourapp/"
; NOTE:        This directory path must be publicly accessible and have the proper CORS settings
; DEFAULT:     "" to use default assets/ directory within the application folder
; USAGE:       $f = getPathAssets() . "js/main.js"; will set $f to "/assets/js/main.js" or
;              "https://cdn.yourdomain.com/youapp/js/main.js"


; =======================================================================================
; =======================================================================================
; CACHE-PROXY
; =======================================================================================

[cacheproxy]

endpoint = ""

; =======================================================================================
; =======================================================================================
; Keep all custom app settings above these two lines

;*/

;?>