<?php

class MiddlewareRecords {

    public $routerMiddleware;

    function __construct() {
        $this->routerMiddleware = [
            "csrf" => CsrfTokenMiddleware::class,
        ];
    }

}
