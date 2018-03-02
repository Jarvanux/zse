<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Html {

    /**
     * 
     * @param type $url
     * @param type $isURL
     */
    public static function addStyle($url) {
        $isURL = strpos($url, "//") != false;
        if (strpos($url, "?") === false) {
            $url .= "?v=" . App::version();
        } else {
            $url .= "v=" . App::version();
        }
        $cmd = "<link href=\"" . ((!$isURL) ? URL::to($url) : $url) . "\" rel=\"stylesheet\" type=\"text/css\"/>";
        return $cmd;
    }

    /**
     * 
     * @param type $url
     * @param type $isURL
     */
    public static function addScript($url) {
        $isURL = strpos($url, "//") != false;
        if (strpos($url, "?") === false) {
            $url .= "?v=" . App::version();
        } else {
            $url .= "&v=" . App::version();
        }
        $cmd = "<script type=\"text/javascript\" src=\"" . ((!$isURL) ? URL::to($url) : $url) . "\"></script>";
        return $cmd;
    }

    /**
     * 
     * @param type $url
     * @param type $isURL
     */
    public static function addFavicon($url) {
        $isURL = strpos($url, "//") != false;
        if (strpos($url, "?") === false) {
            $url .= "?v=" . App::version();
        } else {
            $url .= "&v=" . App::version();
        }
        $cmd = "<link rel=\"shortcut icon\" href=\"" . ((!$isURL) ? URL::to($url) : $url) . "\" />";
        return $cmd;
    }

    /**
     * 
     * @param type $url
     * @param type $alt
     * @param type $isURL
     */
    public static function addImage($url, $alt) {
        $isURL = strpos($url, "//") != false;
        if (strpos($url, "?") === false) {
            $url .= "?v=" . App::version();
        } else {
            $url .= "&v=" . App::version();
        }
        $cmd = "<img alt=\"$alt\" src=\"" . ((!$isURL) ? URL::to($url) : $url) . "\" />";
        return $cmd;
    }

    /**
     * 
     * @param type $type
     * @param type $name
     * @param type $id
     * @param type $class
     */
    public static function addInput($type, $name, $id, $class = array()) {
        $class = implode(" ", $class);
        $cmd = "<input type=\"$type\" id=\"$id\" class=\"$class\" />";
        return $cmd;
    }

}
