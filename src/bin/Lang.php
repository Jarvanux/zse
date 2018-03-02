<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Lang {

    private static $words;

    private function getWords() {
        $lang = App::lang();
        $file = PATH_LANGS . $lang . ".php";
        if (file_exists($file)) {
            self::$words = require $file;
            return true;
        } else {
            return false;
        }
    }

    public static function trans($word) {
        if (self::$words || self::getWords()) {
            $traduction = isset(self::$words[$word]) ? self::$words[$word] : $word;
            if ($word == $traduction) {
                //Hay que buscar más a fondo...
                $parts = explode(".", $word);
                $finding = true;
                $temp = self::$words;
                $i = 0;
                while ($finding) {
                    $temp = isset($temp[$parts[$i]]) ? $temp[$parts[$i]] : $word;
                    if (is_string($temp) || is_null($temp)) {
                        $finding = false;
                    } else {
                        $i++;
                    }
                }
                $traduction = $temp;
            }
            return $traduction;
        }
        return $word;
    }

}
