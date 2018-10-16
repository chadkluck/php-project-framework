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
;		FRAMEWORK FILE VERSION: 2018-10-15

;	********************************************************************************************
;	============================================================================================


; NOTE: double apostrophes ('') are used in comments only because of the way certain code editors highlight text between ' and '
; NOTE: plain text and numbers can be entered without quotes.
;       For more on editing ini files visit: http://php.net/manual/en/function.parse-ini-file.php

; NOTE: Regular Expressions are used. I recommend one of these testers:
;       https://regex101.com/
;       https://www.regextester.com/



[header]
; =======================================================================================
; HTTP HEADER SETTINGS
; These are values that configure the way requests are received and responded to


allow-origin = "/^https?:\/\/(?:(?:[a-z0-9]+\.)*63klabs\.com)$/i"
; FORMAT:      Regular Expression (eg "/foo/i")
; DESCRIPTION: What websites should be allowed to embed these pages? Typical for CORS for pulling the page into an iframe or javascripts accessing the api. Leave blank if you want to allow any website
; RECOMMENDED: "/^^https?:\/\/(?:(?:[a-z0-9]+\.)*yourdomain\.com)/i"
; DEFAULT:     ""


bad-origin-allow-ip = "/^5\.9\./"
; FORMAT:      Regular Expression e.g. "/^5\./"
; DESCRIPTION: If the request is made by a site not allowed to embed, what IP range is allowed to override?
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are)
; DEFAULT:     ""


api-cache = 3600
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


allow-debug-ip = "/^10\.1\./"
; FORMAT:      Regular Expression (eg "/^10\./"
; DESCRIPTION: If we allow debugging what IPs are allowed to switch into debugging mode?
; NOTE:        allow-debug must still be set to 1 (true)
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are in) I recommend taking it down all the way to your actual IP or at least subnet
; DEFAULT:     ""


allow-debug-host = "/^https:\/\/dev\.63klabs\.com$/i"
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


password-hash = ""
; FORMAT:      string
; DESCRIPTION: Place the password-hash blob (not the password) generated by /lti/tools/setup.php into here
; NOTE:        Be sure to keep the password generated by the tool in a safe place, it will be needed when accessing the tools
;              This will be generated for you the first time you go to use the tools and will continue to generate until this value is set in this config file
;              If you forget the password just reset the string above to ""
; ALSO NOTE:   If you are security conscience you will be happy to know that the salt is contained in the blob, so there is salt but no pepper.
;              https://www.owasp.org/index.php/Password_Storage_Cheat_Sheet
; DEFAULT:     "" (to force password setup)


google-authenticator = ""
; FORMAT:      string
; DESCRIPTION: This is a single user system, therefore no username, just a password that can be shared among trusted staff. Access to the tools area only provides config set up,
;              no private data. However, even if there was a username brute force login would still be an issue. So to prevent brute force login and to add an additional factor
;              of authentication, we provide Google Authenticator https://en.wikipedia.org/wiki/Google_Authenticator
; NOTE:        You must download and install the Google Authenticator app on a mobile device in order to use.
; RECOMMENDED: While not required, it is recommended that as soon as system is up and running you set up Google Authenticator
; DEFAULT:     ""


key-store[] = ""
key-store[] = ""
key-store[] = ""
key-store[] = ""
; FORMAT:      string
; DESCRIPTION: A keychain of randomly generated keys used for various security functions. These are obtained from the tools/setup.php page under Key Store
; DEFAULT:     "" (to force key setup)


oauth_clientid = ""
oauth_secret = ""
; FORMAT:      string
; DESCRIPTION: If this app needs to authenticate via oauth to another service enter the information here.
; NOTE:        At this time oauth is not coded in the framework.


api_key = ""
; FORMAT:      string
; DESCRIPTION: If this application will be accessed by other servers (not client-side scripts such as JavaScript running in the browser)
;			   You may restrict access by requiring the requesting server to provide an API key (or token), as if it were a password.
;              API keys should only be used for server to server communication. For greater security add the ip address or range of ip addresses
;              of expected requesting servers to api_ipaccess
; NOTE:        This is a single, shared key and should not be used for multiple, untrusted, systems. Also note that code to check the api_key
;              and api_ipaccess are not built into the framework, you will have to perform your own validation. Also note this should never be used
;              to authenticate access via client side scripts or applications. Hard coded tokens are a bad, bad, bad idea.
; DEFAULT:     ""


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

; Where are the scripts and assets stored?
; For security purposes it is beneficial to move the inc/ and assets/ folders outside
; of the application''s public web directory.
; It is recommended you get the application installed and running first before messing with
; these.
;
; RECOMENDATION: Get the app working first, then move the inc/ directory to a location under
; 	the public web directory (typically /home/yourspace/resources/inc where /home/yourspace/www is your web directory)
;   Then update this file with the location and upload it to test it out.
;   For now inc_app and inc_lib should point to the same location.
;   If you want to move or point to a central lib once you get the app working then update inc_lib
;   Finally, as long as inc_app and inc_lib are working, if you want to store your assets elsewhere (Amazon S3 bucket for example)
;   in order to separate the application''s code from the content. Then point to it.


inc_app = ""
; FORMAT:      string
; DESCRIPTION: Where the "inc/" directory is located (without inc/ in the string)
;              "" will return "inc/" (default location within app folder)
;              "/home/asdf/" will return "/home/asdf/inc/" (such as a server path if moved below public web directory)
;			   "/home/asdf/resources/digital-display/" will return "/home/asdf/resources/digital-display/inc" (server path below public web directory)
; DEFAULT:     "" to use default inc/ directory within the application folder


inc_lib = ""
; FORMAT:      string
; DESCRIPTION: Where the "inc/lib/" directory is located (without inc/lib/ in the string)
;              "" will return "inc/lib/" (default location within app folder)
;              "/home/asdf/" will return "/home/asdf/inc/lib/" (such as a server path if moved below public web directory)
;			   "/home/asdf/resources/shared/" will return "/home/asdf/resources/shared/inc/lib/" (server path below public web directory where multiple apps share a library - in case you wish to maintain a single common library)
; DEFAULT:     "" to use default inc/lib/ directory within the application folder


assets = ""
;assets = ""
; FORMAT:      string
; DESCRIPTION: "" will return "assets/"
;			   "https://assets.yourdomain.com/yourapp/" will return "https://assets.yourdomain.com/yourapp/assets/"
; NOTE:        Unlike inc_app and inc_lib, this directory path must be publicly accessible and have the proper CORS settings
; DEFAULT:     "" to use default assets/ directory within the application folder


; =======================================================================================
; =======================================================================================
; SETTINGS FOR APPLICATION
; Add configuration variables for your application below
; =======================================================================================






; =======================================================================================
; =======================================================================================
; Keep all custom app settings above these two lines

;*/

;?>