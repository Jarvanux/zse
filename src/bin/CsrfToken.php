<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * Controla los CSRF_TOKENS.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class CsrfToken {

    private static $time = 0; //Secounds

    private static function init() {
        self::$time = App::csrf_token_time();
        return App::csrf_token();
    }

    public static function methods() {
        return App::csrf_token_methods();
    }

    public static function generate() {
        if (!self::init()) {
            return "csrf_token_disabled";
        }
        $token = null;
        if (($token = Session::get("csrf_token"))) {
            $token = $token["token"];
        } else {
            $token = Hash::sha1(uniqid(microtime(), true));
            $time = time();
            Session::set("csrf_token", ["token" => $token, "time" => $time]);
        }
        return $token;
    }

    public static function verifyToken(Request $request) {
        if (!self::init()) {
            return true;
        }
        $token = Session::get("csrf_token");
        if (!$token) {
            return false;
        }
        if ($token["token"] !== $request->_token) {
            return false;
        }
        if (self::$time > 0) {
            $token_age = time() - $token["time"];
            if ($token_age >= self::$time) {
                self::deleteToken();
                return false;
            }
        }
        return true;
    }

    public static function deleteToken() {
        Session::destroy("csrf_token");
    }

}

function csrf_token() {
    $token = CsrfToken::generate();
    return $token;
}

function csrf_field() {
    return '<input type="hidden" value="' . csrf_token() . '" name="_token" />';
}
