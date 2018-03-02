<?php


/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */

class Redirect {

    private $uri;

    function __construct() {
        $this->uri = self::getReferer();
    }

    public function saveUri() {
        
    }

    public function to($uri) {
        header("Location: $uri");
    }

    public function back() {
        if (empty($this->uri)) {
            return;
        }
        $this->to($this->uri);
    }

    private static function getReferer() {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URL::to("");
        return $referer;
    }

}
