<?php

require PATH_LIBS . 'GeoIP/geoip.php';

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * Permite obtener la IP del visitante y determinar 
 * el país en el que se encuentra.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Geolocation {

    function __construct() {
        
    }

    public static function getIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public static function getCountry() {
        $ip = GeoIP2::getIP();
        if ((strpos($ip, ":") === false)) {
            //ipv4
            $gi = geoip_open(PATH_LIBS . "GeoIP/GeoIP.dat", GEOIP_STANDARD);
            $country = geoip_country_code_by_addr($gi, $ip);
        } else {
            //ipv6
            $gi = geoip_open(PATH_LIBS . "GeoIP/GeoIPv6.dat", GEOIP_STANDARD);
            $country = geoip_country_code_by_addr_v6($gi, $ip);
        }
        return $country;
    }

}
