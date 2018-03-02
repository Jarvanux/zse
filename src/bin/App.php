<?php

/**
 * <b>Deplyn class</b><br/>
 * ------------<br/>
 * Puedes obtener y actualizar toda la configuración de la aplicación usando esta clase.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class App {

    private static $lang;
    private static $time_zone;
    private static $csrf_token;
    private static $csrf_token_time;
    private static $csrf_token_methods;
    private static $debug;
    private static $version;
    private static $pages;
    private static $storage;
    private static $loaded = false;

    static function init() {
        if (self::$loaded) {
            return;
        }        
        $appcogs = require PATH_CONFIG . 'app.php';
        self::$loaded = true;
        self::$lang = $appcogs["lang"];
        self::$time_zone = $appcogs["time_zone"];
        self::$csrf_token = $appcogs["csrf_token"];
        self::$csrf_token_time = $appcogs["csrf_token_time"];
        self::$csrf_token_methods = $appcogs["csrf_token_methods"];
        self::$debug = $appcogs["debug"];
        self::$version = $appcogs["version"];
        self::$pages = $appcogs["pages"];
        self::$storage = $appcogs["storage"];
    }

    static function lang($lang = null) {
        self::init();
        if ($lang != null) {
            self::$lang = $lang;
        }
        return self::$lang;
    }

    static function time_zone($time_zone = null) {
        self::init();
        if ($time_zone != null) {
            self::$time_zone = $time_zone;
        }
        return self::$time_zone;
    }

    static function csrf_token($csrf_token = null) {
        self::init();
        if ($csrf_token != null) {
            self::$csrf_token = $csrf_token;
        }
        return self::$csrf_token;
    }

    static function csrf_token_time($csrf_token_time = null) {
        self::init();
        if ($csrf_token_time != null) {
            self::$csrf_token_time = $csrf_token_time;
        }
        return self::$csrf_token_time;
    }

    static function csrf_token_methods($csrf_token_methods = null) {
        self::init();
        if ($csrf_token_methods != null) {
            self::$csrf_token_methods = $csrf_token_methods;
        }
        return self::$csrf_token_methods;
    }

    static function debug($debug = null) {
        self::init();
        if ($debug != null) {
            self::$debug = $debug;
        }
        return self::$debug;
    }

    static function version($version = null) {
        self::init();
        if ($version != null) {
            self::$version = $version;
        }
        return self::$version;
    }

    static function pages($pages = null) {
        self::init();
        if ($pages != null) {
            self::$pages = $pages;
        }
        return self::$pages;
    }

    static function storage($storage = null) {
        self::init();
        if ($storage != null) {
            self::$storage = $storage;
        }
        return self::$storage;
    }

}
