<?php
/*
===============================================================================
*******************************************************************************
Cache-Proxy for PHP Project Framework
*******************************************************************************

Chad Leigh Kluck (chadkluck.net)
github.com/chadkluck

*******************************************************************************

FILE LAST MODIFIED: 2019-12-15 - clkluck

PURPOSE: Extend PHP Project Framework by providing caching functionality to 
backend GET requests sent to remote endpoints. Utilizes Cache-Proxy for AWS 
created by University of St. Thomas Libraries (github.com/ustlibrraies).

REQUIREMENTS: Install Cache=Proxy for AWS by University of St. Thomas 
Libraries on your AWS instance. Then add the include for this file in your 
inc-app.php file.

INSTALLATION:
1. Cache-Proxy for AWS by University of St. Thomas Libraries must be installed 
on your AWS instance first. (github.com/ustlibraries)
2. Then copy the url to your endpoint from your AWS API GateWay Console
(Example: https://gryeuwakjds.execute-api.us-east-1.amazonaws.com/yourpath)
3. In the config.ini.php file create a new header [cacheproxy] and then a
variable endpoint="[paste your endpoint url from aws here]". key= is optional.
4. In your inc-app.php file (if you're developing the app), or 
custom/inc.php file (if you are installing the app) add an include for this
file with the appropriate path.

CUSTOMIZATION: If you want to customize this or implement your own Cache-Proxy
then copy this script into your apps inc or custom directory and instead of
including this file, include your custom file. getData() uses the function
implemented by CacheProxyAWS by accessing it through the $app variable which
is initialized at the end of this script. Aside from that function the rest
is up to you.

*******************************************************************************
*******************************************************************************

    This is a class file from the PHP PROJECT FRAMEWORK library.
    Visit github.com/chadkluck/php-project-framework page for more info.

*******************************************************************************
===============================================================================
*/



/* 
===============================================================================
*******************************************************************************
CLASS
*******************************************************************************
CacheProxy is a required interface that must be implemented by the class
created and stored in $app['obj']['x-cacheProxy'] at the end of this script.
===============================================================================
*/

/**
 * Required interface that needs to be implemented by a CacheProxy class. It 
 * specifies the required function that the final class must contain in order
 * to operate in the PHP Project Framework.
 */
interface CacheProxy {
	public function getURI($uri);
}

/**
 * This class implements the required functionality of CacheProxy. It can be used
 * as a template for creating your own CacheProxy class. If you create your own
 * or use a different class, be sure to update the class in INIT area at the end
 * of this script. Multiple classes may co-exist, but only the one refered to in
 * INIT below will be used.
 */
class CacheProxyAWS implements CacheProxy {
	
    private $cacheProxy = NULL;
    private $useCache = NULL;
    private $key = NULL;
    
    public function __construct() {
        // do a few checks to make sure we're set
        if (getCfg("cacheproxy") && isset(getCfg("cacheproxy")['endpoint'])  && getCfg("cacheproxy")['endpoint'] !== "") {
            // set the proxy info (includes endpoint and key)
            $this->cacheProxy = getCfg("cacheproxy");

            /*
            By default, use the key in the config 
            (but it can be switched out during execution)
            */
            $this->resetKey();

        } else {
            logMsg("['endpoint'] not properly set under ['cacheproxy'] in config.ini.php");
        }
    }

    /**
     * Proxifies the URI passed
     * 
     * @param String $uri The uri we wish to reach through the cache proxy
     * @return String A URI with the proxy as the endpoint and origintal URI as a parameter
     */
	public function getURI($uri) {

        $proxiedURI = $uri; // default, in case cacheproxy isn't config'd

        if ($this->cacheProxy !== NULL) {
            $proxiedURI = $this->cacheProxy['endpoint'] . "?uri=" . urlencode($uri) . $this->getUseCacheParameter() . $this->getKeyParameter();
            logMsg("Cache-Proxy Proxified: ".$uri." to ".$proxiedURI);
        } else {
            logMsg("Check ['cacheproxy'] settings in config.ini.php. URI not proxied");
        }
        
        return $proxiedURI;

    }

    /**
     * Allows overriding of the cache for subsequent Cache Proxy requests.
     * 
     * NULL will allow for normal operation and follow cache expiration
     * FALSE will bypass the cache and request straight from the origin
     * TRUE will use the cache even if it is expired
     * 
     * Setting this will set it for all subsequent requests during app 
     * execution until it is set to a different value. It can be turned on and
     * off as needed.
     * 
     * Note that depending on Cache-Proxy configuration, a key may be needed to 
     * bypass the cached copy using setUseCache(FALSE). However, a cached
     * copy may always be forced using setUseCache(TRUE).
     * 
     * @param Boolean $bool Sets the override for using cache or origin. TRUE, FALSE or NULL
     */
    public function setUseCache($bool = TRUE) {
        $this->useCache = $bool;
    }

    /**
     * Returns the cache parameter key/value pair for the query string 
     * prepended with an ampersand.
     * 
     * Example: "&cache=TRUE"
     * 
     * Returns an empty string under normal cache operation.
     * 
     * @return String A key/value pair for a querystring
     */
    private function getUseCacheParameter() {
        $s = "";

        switch ($this->useCache) {
            case NULL: // otherwise FALSE will take it
                $s = "";
                break;
            case TRUE:
                $s = "&cache=TRUE";
                break;
            case FALSE: 
                $s = "&cache=FALSE";
                break;
        }

        return $s;
    }

    /**
     * Returns the key parameter key/value pair for the query string
     * prepended with an ampersand.
     * 
     * Example: "&key=xhasomekeyexampe2n9"
     * 
     * Returns an empty string if there is no key.
     * 
     * @return String A key/value pair for a querystring
     */
    private function getKeyParameter() {
        $s = "";

        if ($this->key && $this->key !== "") {
            $s = "&key=" . urlencode($this->key);
        }

        return $s;
    }

    /**
     * Sets the key for Cache Proxy back to the default as listed in the config
     * If there is no key it sets it to null
     */
    public function resetKey() {
        if(isset($this->cacheProxy['key'])) {
            $this->setKey($this->cacheProxy['key']);
        } else {
            $this->key = NULL;
        }
    }

    /**
     * If during execution we wish to set the key for Cache Proxy we may do so.
     * Using resetKey() will return it to the default listed in config.ini.php
     * 
     * Passing NULL will supress the addition of the &key= parameter for
     * subsequent calls.
     * 
     * @param String A key to use with the cache-proxy service
     */
    public function setKey($key) {
        if($key === "") { 
            $key = NULL;
        }
        $this->key = $key;
    }

}

/* 
===============================================================================
*******************************************************************************
INIT
*******************************************************************************
This is required, but if you customize this script point to your own class name
===============================================================================
*/

// create the cache proxy object for use in the application
$app['obj']['x-cacheProxy'] = new CacheProxyAWS();

// in your application you can always create an alias:
// $myCacheProxy = &getApp("obj")['x-cacheProxy']; // getApp() returns a reference to the original
// or
// $myCacheProxy = &$app['obj']['x-cacheProxy']; // creates a reference to the original

?>