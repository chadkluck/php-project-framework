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
;		FRAMEWORK FILE VERSION: 2019-02-16

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


allow-origin = ""
; FORMAT:      Regular Expression (eg "/foo/i")
; DESCRIPTION: What websites should be allowed to embed these pages? Typical for CORS for pulling the page into an iframe or javascripts accessing the api. Leave blank if you want to allow any website
; RECOMMENDED: "/^https?:\/\/(?:(?:[a-z0-9]+\.)*yourdomain\.com)$/i"
; DEFAULT:     ""


bad-origin-allow-ip = "/^10\./"
; FORMAT:      Regular Expression e.g. "/^10\.9\.104\.5/" (for IP 10.9.104.5)
; DESCRIPTION: If the request is made by a site not allowed to embed, what IP range is allowed to override?
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are)
; DEFAULT:     "/^10\./" (as example)


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

; NOTE: In order to show a page in debug mode the debug parameter must be passed and set to "true" in either a POST or GET
; For example when accessing via link (get) yourdomain.com/somepage/?debug=true


allow-debug = 1
; FORMAT:      1|0
; DESCRIPTION: Will we allow debugging which captures logs and outputs data to user at end of script run
; NOTE:        This does not turn debugging on, a debug param debug=true must be sent with the page request
; RECOMMENDED: Set to 1 (true) when implementing/troubleshooting, 0 (false) when in production
; DEFAULT:     1 (just because of implementing. When not troubleshooting set to 0 (false) )


allow-debug-ip = "/^10\./"
; FORMAT:      Regular Expression e.g. "/^10\.9\.104\.5/" (for IP 10.9.104.5)
; DESCRIPTION: If we allow debugging what IPs are allowed to switch into debugging mode?
; NOTE:        allow-debug must still be set to 1 (true)
; RECOMMENDED: "/^10\./" (or whatever ip range your local workstation, or a range of servers are in) I recommend taking it down all the way to your actual IP or at least subnet
; DEFAULT:     "/^10\./" (as example)


allow-debug-host = "/^https:\/\/dev\.63klabs\.net$/i"
; FORMAT:      Regular Expression (eg "/^https:\/\/yourtestserver\.yourdomain\.com$/i")
; DESCRIPTION: If we allow debugging what servers can we debug on? So if you have a separate test and production server debug will only be able to be switched on when in test environment
; NOTE:        allow-debug must still be set to 1 (true). This is typically just your domain with regex escape "\" in front of each / and .
; RECOMMENDED: If you have access to a test server, use it and put the domain here and use HTTPS only in the regex! "^https:\/\/" (requires https: at start) and NOT "^https?\/\/:" (http or https)
; DEFAULT:     "/^https:\/\/dev\.63klabs\.net$/i" (as example)


require-ssl = 1
; FORMAT:      1|0
; DESCRIPTION: Should HTTPS be forced?
; DEFAULT:     1


ip-restrict-allow-ip = ""
; FORMAT:      Regular Expression (eg "/^10\./" )
; DESCRIPTION: Should access be restricted by IP? If this is set then access will only be granted to clients from a specific IP or IP range.
; NOTE:        This is site level which executes on all script executions.
; 			   If you want to restrict certain pages then set a zone-restrict-allow-ip[zone-name] and add restrictByIpForZone("zone-name") to your page
;			   If you want to restrict API access then set api-restrict-access-ip below
; NOTE:        This will restrict access to the ENTIRE application (pages and apis). If you want to grant fine grained access, use the api-restrict-access-allow-ip for
;              just the IP or zone-restrict-allow-ip[] settings.
; DEFAULT:     ""


ip-restrict-allow-admin = 0
; FORMAT:      1|0
; DESCRIPTION: Even if ip-restrict is set, can a logged in admin override it? If you always want the IP to be locked, then this is 0.
; DEFAULT:     0


ip-restrict-allow-user = 0
; FORMAT:      1|0
; DESCRIPTION: Even if ip-restrict is set, can a logged in user override it? If you always want the IP to be locked, then this is 0.
; DEFAULT:     0


api-restrict-access-allow-ip = ""
; FORMAT:      Regular Expression e.g. "/^10\.9\.104\.5/" (for IP 10.9.104.5)
; DESCRIPTION: If this application will be accessed by other servers (not client-side scripts such as JavaScript running in the browser)
;			   You may restrict access by requiring the requesting server be from a designated ip address or range of ip addresses
; NOTE:        This will restrict access to ALL apis. If you want to grant fine grained access for multiple APIs, use the zone-restrict-allow-ip[] settings.
; DEFAULT:     "" (open/no restriction)


zone-restrict-allow-ip[admin-zone] = ""
zone-restrict-allow-ip[public-zone] = ""
zone-restrict-allow-ip[zone0] = ""
; FORMAT:      Regular Expression e.g. "/^10\.9\.104\.5/" (for IP 10.9.104.5)
; DESCRIPTION: You may restrict access to specific zones by requiring the requesting client or server be from a designated ip address or range of ip addresses.
;              Add multiple zones, and add restrictByIpForZone("zone0"), for example, to the top of your php script.
; NOTE:        Rename these within the [] to anything descriptive. If you don''t need these in your application you can remove these lines from the config
;              and not present them to the admin installing your application.
; DEFAULT:     "" (open/no restriction)


obfuscate-secrets = 1
; FORMAT:      1|0
; DESCRIPTION: If in debug mode, should we sanitize data before we use sanitized_print_r() to display, obfuscating secret keys, api keys, etc.
;              (e.g. *********dj7ixJ). Just in case you copy/paste/print/share while debugging
; NOTE:        This does not turn debugging on
; RECOMMENDED: Always set to 1 (true). Up to last 6 chars are shown so you can id key (half if key length is fewer than 6). Can''t think of a reason why you wouldn''t want this
; DEFAULT:     1


[secrets]
; =======================================================================================
; ROOT USER AND SERVER TO SERVER SECRETS
; For single user applications or server to server communications
; Anything under [secrets] and [app-secrets] (in the app section below) will be obfuscated when [secrets][obfuscate-secrets] is set to 1
; This will also help when a future release of the project framework incorporates the option to use a secure key store (so that they do not need to be managed in this flat file)


password-hash = ""
; FORMAT:      string
; DESCRIPTION: Place the password-hash blob (not the password) generated by password_hash() function here. This can be a root password (for single user systems).
; NOTE:        Be sure to keep the password generated by the tool in a safe place, it will be needed when accessing the tools
;              This will be generated for you the first time you go to use the tools and will continue to generate until this value is set in this config file
;              If you forget the password just reset the string above to ""
; ALSO NOTE:   If you are security conscience you will be happy to know that the salt is contained in the blob, so there is salt but no pepper.
;              https://www.owasp.org/index.php/Password_Storage_Cheat_Sheet
; DEFAULT:     "" (to force password setup)


google-authenticator = ""
; FORMAT:      string
; DESCRIPTION: For a single user system enter the Google authenticator key for the root user.
;              Why use Google Authenticator on a root password? To prevent brute force login and to add an additional factor
;              of authentication, we provide Google Authenticator https://en.wikipedia.org/wiki/Google_Authenticator
; NOTE:        You must download and install the Google Authenticator app on a mobile device in order to use.
; RECOMMENDED: While not required, it is recommended that as soon as system is up and running you set up Google Authenticator
; DEFAULT:     ""


key-store[] = ""
key-store[] = ""
key-store[] = ""
key-store[] = ""
; FORMAT:      string
; DESCRIPTION: A keychain of randomly generated keys you can use for various security functions such as signing hashes.
; DEFAULT:     ""


oauth_clientid = ""
oauth_secret = ""
; FORMAT:      string
; DESCRIPTION: If this app needs to authenticate via oauth to another service enter the information here.
; NOTE:        At this time oauth is not coded in the framework.


api-restrict-allow-key[keyid] = ""
; FORMAT:      string
; DESCRIPTION: For server to server communication you can require servers requesting API data from your app to provide an API key.
;              Note: These should be used for server to server communication and should never be used where code is placed on a
;              client computer (javascript in the browser or mobile app). Server to server only.
;			   You may restrict access of outside parties using your apis by requiring the requesting server to provide an API key
;              as if it were a password.
;              API keys should only be used for server to server communication. For greater security add the ip address or range of ip addresses
;              of expected requesting servers to api-restrict-access-ip
; NOTE:        This is a single, shared key and should not be used for multiple, untrusted, systems. If you are developing a 3rd party
;              platform you will need to code your own key management.
;              Notes of what each key is used for may be placed in the [api-key-assignment] section.
; USAGE:       api-restrict-allow-key[keyid] = "keyid-somekey" where keyid is an alpha id and somekey is the key
;              The requestor would add ?apikey=keyid-somekey to their request
; EXAMPLE:     api-restrict-allow-key[ucede] = "ucede-hbM9yVEmvChangeToYourOwnUniqueAlphaNumericRandomKeyThatIsAbout63CharInLength"
;              You can grab a 63 character random key from https://www.grc.com/passwords.htm (it is a reputable source!)
; DEFAULT:     ""


[api-key-assignment]
; =======================================================================================
ucede = "[[short descriptive name]],[[some text for notes describing what it is for]]"
; FORMAT:      string in the format "[[short, descriptive name]],[[some text for notes describing what it is for]]"
; DESCRIPTION: Add additional lines, one for each key you will be creating. The variable name used should match the "keyid" used in api-restrict-allow-key[keyid] above.
; EXAMPLE:     sect7g = "[[Sector 7G]],[[Key used by OpSec Application to remotely monitor core temperature for Sector 7G]]"


[paths]
; =======================================================================================
; FILE PATHS AND STORAGE

; Install the application first, get it working in default directories, then move directories around!
; Just skip over changing the paths around until you have an understanding.

; Where are the scripts and assets stored?
; For security purposes it is beneficial to move the php function and include files outside
; of the application''s public web directory.
; It is recommended you get the application installed and running first before messing with
; these.
;
; If you question why you''d want to do complicated forms of this, then you probably don''t have a use case
;
; RECOMENDATION: Get the app working first, then move the inc/ directory to a location outside
; 	the public web directory. Then update this file with the location and upload it to test it out.
;   For example, if your public web directory is /home/user/www or /home/user/public (where all publicly accessible content is stored,
;   then create a directory such as /home/user/private/ to store scripts that shouldn''t be accessible on the public web
;   For now inc_app and inc_lib should point to the same location.
;   If you want to move or point to a central lib once you get the app working then update inc_lib
;   Finally, as long as inc_app and inc_lib are working, if you want to store your assets elsewhere (Amazon S3 bucket for example)
;   in order to separate the application''s code from the content. Then point to it.
;
; Default Installation:
; /home/user/public/
;                |- custom/
;                |- assets/
;                |- inc/
;                |  |- lib/
;                |- allpublicfilesandirectories
;
; Possible installation
; /home/user/public/
;                |- app-1/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-1
;                |- app-2/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-2
;                |- app-3/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-3
;                |- allpublicfilesandirectories
; /home/user/private/
;                |- libraries/ (used by app-1, app-2, and app-3)
;                |- app-1/
;                |    |- custom/ (functions-custom.php and all custom files for app-1)
;                |    |- inc/
;                |- app-2/
;                |    |- custom/ (functions-custom.php and all custom files for app-2)
;                |    |- inc/
;                |- app-3/
;                |    |- custom/ (functions-custom.php and all custom files for app-3)
;                |    |- inc/
;
; Another Possible (complex) installation where 1 app has 3 custom settings (such as a microsite app running 3 micro sites
; /home/user/public/
;                |- microsite-1/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-1
;                |- microsite-2/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-1
;                |- microsite-3/
;                |    |- custom/ (only inc.php and custom.ini.php, functions-custom.php moved to private)
;                |    |- allpublicfilesanddirectoriesforapp-1
;                |- allpublicfilesandirectories
; /home/user/private/
;                |- libraries/ (used by microsite and other apps)
;                |- inc-microsite-app/
;                |- inc-someother-app/
;                |- custom-site-1/ (functions-custom.php and all custom files for microsite 1)
;                |- custom-site-2/ (functions-custom.php and all custom files for microsite 2)
;                |- custom-site-3/ (functions-custom.php and all custom files for microsite 3)
;                |- custom-someother/ (functions-custom.php and all custom files for some other app)


inc_app = ""
; FORMAT:      string
; DESCRIPTION: Where contents of default "inc/" directory are located
;              "" will return "inc/" (default location within install folder)
; EXAMPLE:     "/home/user/private/inc/" (server path outside the public web directory but retains the default inc label)
;              "/home/user/private/appname/" (server path outside the public web directory but inc has been renamed to appname)
; DEFAULT:     "" to use default inc/ directory within the application folder


inc_lib = ""
; FORMAT:      string
; DESCRIPTION: Where contents of default "inc/lib/" directory are located
;              This is useful if you develop multiple applications based on php-project-framework using many of the same libraries
;              For example five custom apps (all pointing to their own app''s /inc directories) that all use the /php-project-framework library
;              "" will return "inc/lib/" or, if inc_app is set above, "[inc_app/]lib/" (default location within installed inc folder)
; EXAMPLE:     "/home/user/private/libraries/" (server path outside public web directory)
; DEFAULT:     "" to use default inc/lib/ directory within the application folder


custom = ""
; FORMAT:      string
; DESCRIPTION: Where contents of default "custom/" directory is located. config.ini.php and inc.php will need to stay in the public directory but everything else may be moved out of public view
;              "" will return "custom/" (default location within install folder)
; EXAMPLE:     "/home/user/private/custom/"
;              "/home/user/private/custom-microsite-1/"
; NOTE:        config.ini.php and inc.php will need to stay in the public directory. functions-custom.php and any added files may be moved here
; DEFAULT:     "" to use default custom/ directory within the application folder


assets = ""
;assets = ""
; FORMAT:      string
; DESCRIPTION: "" will return "assets/"
;			   "https://assets.yourdomain.com/yourapp/" will return "https://assets.yourdomain.com/yourapp/assets/"
; NOTE:        Unlike inc_app and inc_lib, this directory path must be publicly accessible and have the proper CORS settings
; DEFAULT:     "" to use default assets/ directory within the application folder


; =======================================================================================
; =======================================================================================
; ADDITIONAL SETTINGS FOR APPLICATION
; Add configuration variables for your application below. Create your own [sections].
; =======================================================================================


[app-secrets]
; =======================================================================================
; APP SECRETS
; You can store server to server secrets in the [app-secrets] section of the config array ( getCfg("app-secrets") )
; so they are obfuscated when sanitized_print_r() is called
; Do not rename this heading as it is used by sanitized_print_r(). However, if it is removed or renamed the
; code is resiliant enough to continue working but won''t find, and therefore won''t sanitize, these particular secrets
; NOTE: Secrets generated during execution of the application should be stored in $app['secrets'] ( getApp('secrets') so they
; may be afforded the same level of obfuscation.


example-key = "ffhtvldvjherijijledbf"
; FORMAT:      string
; DESCRIPTION: An example secret key stored in the config [app-secrets] section. Access by calling getCfg("app-secrets")[example-key]
; DEFAULT:     "ffhtvldvjherijijledbf" (to show an example)


[app]
; =======================================================================================
; rename this [app] section heading if you want and feel free to add others


app-var = ""
; FORMAT:      anything
; DESCRIPTION: An example variable stored in the config [app] section. Access by calling getCfg("app")[app-var]
; DEFAULT:     ""


; =======================================================================================
; =======================================================================================
; Keep all custom app settings above these two lines

;*/

;?>