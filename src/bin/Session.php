<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Session {

    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function instance() {
        self::init();
        return $_SESSION;
    }

    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        self::init();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function destroy($key) {
        self::init();
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value) {
        self::init();
        self::set($key, $value);
    }

    public static function getFlash($key) {
        self::init();
        $value = self::get($key);
        self::destroy($key);
        return $value;
    }

}
