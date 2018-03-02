<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class ViewCompiler {

    function __construct() {
        
    }

    public static $i;

    public static function replace($m, $variables) {
        switch ($m[1]) {
            case "layout":
                return View::import($m[2]);
                break;
            case "import":
                return View::import($m[2]);
                break;
            case "trans":
                return Lang::trans($m[2]);
                break;
            case "echo":
                return $variables[$m[2]];
                break;
            case "style":
                return Html::addStyle($m[2]);
                break;
            case "script":
                return Html::addScript($m[2]);
                break;
            case "favicon":
                return Html::addFavicon($m[2]);
                break;
            case "img":
                return Html::addImage($m[2]);
                break;
            case "image":
                return Html::addImage($m[2]);
                break;
            default :
                return $m[0];
                break;
        }
    }

}
