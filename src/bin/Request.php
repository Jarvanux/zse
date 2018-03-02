<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Request {

    protected $request;
    protected $data;
    public $method;

    public function __construct($request) {
        new Redirect();
        $this->request = $request;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = array();
        $this->data["referer"] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        foreach ($request as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $this->data[$key] = new Request($value);
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    public function __get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function getParam($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function all() {
        return $this->data;
    }

}
