<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Middleware {

    public $class;
    public $csrf_enabled = true;

    function __construct() {
        
    }

    private function process($value) {
        $validator = new Validator();
        if (is_array($value) || is_object($value)) {
            foreach ($value as $val) {
                $this->process($val);
            }
        } else {
            //Comprueba que el nombre de la clase sea válido y que no sea un string vacio...
            if ($validator->required("class", $value)) {
                $this->class[] = $value;
            }
        }
    }

    public function middleware(...$class) {
        $this->process($class);
        return $this;
    }

    public function csrf_disabled() {
        $this->csrf_enabled = false;
        return $this;
    }

    public function run($request) {
        $records = (new MiddlewareRecords())->routerMiddleware;
        $valid = 0;
        foreach ($this->class as $c) {
            $c = $records->routerMiddleware[$c];
            require_once PATH_MIDDLEWARES . $c . ".php";
            $c = new $c();
            $v = $c->handle($request);
            if (!$v) {
                $valid--;
            }
        }
        return $valid == 0;
    }

}
