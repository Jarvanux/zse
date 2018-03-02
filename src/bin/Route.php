<?php

require_once PATH_BIN . 'Uri.php';
require_once PATH_BIN . 'CsrfToken.php';

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Route {

    function __construct() {
        
    }

    private static $_uri = array();
    private static $_errors = array();
    private static $actual_group;
    private static $actual_middleware;

    /**
     * GET
     * @param type $uri
     * @param type $function
     */
    public static function get($uri, $function = null) {
        return Route::add("GET", $uri, $function);
    }

    /**
     * POST
     * @param type $uri
     * @param type $function
     */
    public static function post($uri, $function = null) {
        return Route::add("POST", $uri, $function);
    }

    /**
     * PUT
     * @param type $uri
     * @param type $function
     */
    public static function put($uri, $function = null) {
        return Route::add("PUT", $uri, $function);
    }

    /**
     * DELETE
     * @param type $uri
     * @param type $function
     */
    public static function delete($uri, $function = null) {
        return Route::add("DELETE", $uri, $function);
    }

    public static function any($uri, $function = null) {
        return Route::add("ANY", $uri, $function);
    }

    public static function group($name = null) {
        $name = (isset($name)) ? $name : uniqid(rand());
        Route::$actual_middleware = new Middleware();
        return Route::$actual_middleware;
    }

    public static function groupEnd() {
        Route::$actual_group = null;
        Route::$actual_middleware = null;
    }

    public static function resource($uri, $controller = null) {
        $middleware = new Middleware();
        Route::add("GET", trim($uri, "/") . "/", $controller . "@index")->middleware($middleware->class);
        Route::add("GET", trim($uri, "/") . "/create", $controller . "@create")->middleware($middleware->class);
        Route::add("POST", trim($uri, "/") . "/store", $controller . "@store")->middleware($middleware->class);
        Route::add("GET", trim($uri, "/") . "/show/:id", $controller . "@show")->middleware($middleware->class);
        Route::add("GET", trim($uri, "/") . "/edit/:id", $controller . "@edit")->middleware($middleware->class);
        Route::add("PUT", trim($uri, "/") . "/update/:id", $controller . "@update")->middleware($middleware->class);
        Route::add("DELETE", trim($uri, "/") . "/destroy/:id", $controller . "@destroy")->middleware($middleware->class);
        return $middleware;
    }

    /**
     * ADD
     * @param $method : Method Http
     * @param type $uri
     * @param type $function
     */
    public static function add($method, $uri, $function) {
        $middleware = new Middleware();
        Route::$_uri[] = new Uri(self::parseUri($uri), $method, $function, $middleware);
        if (Route::$actual_middleware != null) {
            $middleware->middleware(Route::$actual_middleware->class);
        }
        return $middleware;
    }

    public function parseUri($uri) {
        $uri = trim($uri, '/');
        $uri = (strlen($uri) > 0) ? $uri : '/';
        return $uri;
    }

    public static function submit() {
        new View();
        $methodIv = $_SERVER['REQUEST_METHOD'];
        $uriGetParam = isset($_GET['uri']) ? $_GET['uri'] : '/';
        $uriGetParam = self::parseUri($uriGetParam);
        $methodparts = null;
        foreach (Route::$_uri as $key => $uri) {
            if ($uri->match($uriGetParam)) {
                $uri->call();
                return;
            }
        }
        if (DEBUG) {
            header("Content-Type: text/html");
            echo View::make("errors/error.php", [
                "title" => "No se encontró la URI",
                "description" => "La uri(<span class=\"uri\">/$uriGetParam</span>) no se encuentra registrada en el método $methodIv"
            ]);
        } else {
            $file = App::pages()["404"];
            if (file_exists($file)) {
                include $file;
            } else {
                echo "Página no encontrada.";
            }
        }
    }

}
