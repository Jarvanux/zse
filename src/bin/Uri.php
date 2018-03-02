<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Uri {

    var $uri;
    var $method;
    var $function;
    var $matches;
    var $middleware;
    protected $request;
    protected $response;

    function __construct($uri, $method, $function, $middleware) {
        $this->uri = $uri;
        $this->method = $method;
        $this->function = $function;
        $this->middleware = $middleware;
    }

    public function match($url) {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->uri);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        if ($this->method != $_SERVER['REQUEST_METHOD'] && $this->method != "ANY") {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function checkMiddleware() {
        if (isset($this->middleware->class)) {
            return $this->middleware->run($this->request);
        }
        return true;
    }

    private function getParts() {
        $parts = array();
        if (strpos($this->function, "@")) {
            $methodparts = explode("@", $this->function);
            $parts["class"] = $methodparts[0];
            $parts["method"] = $methodparts[1];
        } else {
            $parts["class"] = $this->function;
            $parts["method"] = "index";
        }
        return $parts;
    }

    private function importController($class) {
        $file = PATH_CONTROLLERS . $class . ".php";
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!file_exists($file)) {
            throw new Exception("El controlador($file) no existe");
            return false;
        }
        require_once $file;
        return true;
    }

    private function function_from_controller() {
        $parts = $this->getParts();
        //Importamos el controlador...
        if (!$this->importController($parts["class"])) {
            return;
        }
        //Preparamos la ejecución...
        $class = new $parts["class"]();
        $launch = array($class, $parts["method"]);
        $this->parseRequest([$parts["class"], $parts["method"]]);
        $class->setRequest($this->request);
        //Lanzamos la función...
        if (is_callable($launch)) {
            $this->response = call_user_func_array($launch, $this->matches);
        } else {
            if ($parts["method"] == "index") {
                return;
            }
            throw new Exception("El método " . $parts["method"] . " no existe.", -1);
        }
    }

    public function parseRequest($launch = null) {
        $reflectionFunc = null;
        if ($launch != null) {
            $reflectionFunc = new ReflectionMethod($launch[0], $launch[1]);
        } else {
            $reflectionFunc = new ReflectionFunction($this->function);
        }
        $reflectionParams = $reflectionFunc->getParameters();
        $param = null;
        if (count($reflectionParams) > 0) {
            $param = $reflectionParams[0]->getClass();
        }
        if ($param != null) {
            if ($param->getName() != "Request") {
                if ($param->getParentClass()->getName() === "Validator") {
                    $name = $param->getName();
                    $this->request = new $name($this->request);
                    $this->matches[] = $this->request;
                };
                return;
            }
        }
        $this->request = new Request($this->request);
        $this->matches[] = $this->request;
    }

    public function call() {
        $this->request = $_REQUEST;
        $requestTemp = new Request($this->request);

        $middlewareResponse = $this->checkMiddleware();

        $mr = new MiddlewareRecords();
        $middlewares = $mr->routerMiddleware;
        if (isset($middlewares['csrf'])) {
            $csrfTokenMiddleware = new CsrfTokenMiddleware();
            $csrfTokenMiddleware->csrf_enabled = $this->middleware->csrf_enabled;
            if ($csrfTokenMiddleware->csrf_enabled) {
                if (!$csrfTokenMiddleware->handle($requestTemp)) {
                    return;
                }
            }
        }

        if (($middlewareResponse !== true)) {
            echo $middlewareResponse;
            return;
        }

        //Detectamos si es un llamado a un controlador, de lo contrario lanzamos la función...
        $response = null;
        if (is_string($this->function)) {
            $this->function_from_controller();
        } else {
            $this->parseRequest();
            $this->response = call_user_func_array($this->function, $this->matches);
        }
        if (is_string($this->response)) {
            echo $this->response;
        } else if (is_object($this->response) || is_array($this->response)) {
            $res = new Response();
            echo $res->json($this->response);
        }
    }

    public function getUri() {
        return $this->uri;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

}
