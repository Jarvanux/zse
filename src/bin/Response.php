<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Response {

    var $code;
    var $message;
    var $data;

    function __construct($code = null, $message = null, $data = null) {
        if (isset($code) && empty($message)) {
            $response = EMessages::getResponse($code);
            $this->code = $response->code;
            $this->message = $response->message;
            $this->data = $response->data;
            return;
        }
        if (is_string($code)) {
            $temp = EMessages::getResponse($code);
            $code = $temp->getCode();
        }
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function header($tag, $value) {
        header("$tag: $value");
        return $this;
    }

    public function json($obj = null) {
        $this->header("Content-Type", "application/json");
        if (is_array($obj) || is_object($obj)) {
            return json_encode($obj);
        } else {
            return json_encode($this);
        }
    }

    public function toString($obj = null) {
        if (is_array($obj) || is_object($obj)) {
            return json_encode($obj);
        } else {
            return json_encode($this);
        }
    }

    public function printJSON() {
        echo $this->json();
    }

    public function set($code) {
        return $this->json(EMessages::getResponse($code));
    }

    public function get() {
        return $this->json($this);
    }

    function getCode() {
        return $this->code;
    }

    function getMessage() {
        return $this->message;
    }

    function getData() {
        return $this->data;
    }

    function setCode($code) {
        $this->code = $code;
        return $this;
    }

    function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

}
