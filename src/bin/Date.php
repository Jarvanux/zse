<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Date {

    function __construct() {
        
    }

    private static function init() {
        date_default_timezone_set(App::time_zone());
    }

    public static function getDateForView() {
        self::init();
        return date("d/m/Y h:i A");
    }

    public static function getTimeStamp($date) {
        self::init();
        $date = date_create($date);
        $date = date_format($date, "Y-m-d H:i:s");
        return strtotime($date) * 1000;
    }

    public static function getTime() {
        self::init();
        $date = Hash::getDate();
        $date = date_create($date);
        $date = date_format($date, "Y-m-d H:i:s");
        return strtotime($date);
    }

    public static function timeStampToDate($timestamp) {
        self::init();
        $date = Hash::getTimeStamp(Hash::getDate());
        return date("Y-m-d H:i:s", $timestamp / 1000);
    }

    public static function getDate() {
        self::init();
        return date("Y-m-d H:i:s");
    }

    public static function addMinutes($date, $minutes) {
        self::init();
        $nuevafecha = strtotime('+' . $minutes . ' minute', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function subtractMinutes($date, $hours) {
        $nuevafecha = strtotime('-' . $minutes . ' minute', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function addHours($date, $hours) {
        self::init();
        $nuevafecha = strtotime('+' . $hours . ' hour', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function subtractHours($date, $hours) {
        self::init();
        $nuevafecha = strtotime('-' . $hours . ' hour', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function addDay($date, $day) {
        self::init();
        $nuevafecha = strtotime('+' . $day . ' day', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function subtractDay($date, $day) {
        self::init();
        $nuevafecha = strtotime('-' . $day . ' day', strtotime($date));
        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
        return $nuevafecha;
    }

    public static function betweenHoras($hms_inicio, $hms_fin, $hms_referencia = NULL) {
        self::init();
        if (is_null($hms_referencia)) {
            $hms_referencia = date('G:i:s');
        }
        list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_inicio), 3, 0);
        $s_inicio = 3600 * $h + 60 * $m + $s;
        list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_fin), 3, 0);
        $s_fin = 3600 * $h + 60 * $m + $s;
        list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_referencia), 3, 0);
        $s_referencia = 3600 * $h + 60 * $m + $s;
        if ($s_inicio <= $s_fin) {
            return $s_referencia >= $s_inicio && $s_referencia <= $s_fin;
        } else {
            return $s_referencia >= $s_inicio || $s_referencia <= $s_fin;
        }
    }

}
