<?php

/**
 * <b>Deplyn Class</b>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Controller {

    protected $view;
    protected $request;

    function __construct() {
        $this->view = new View();
    }

    public function setRequest($req) {
        $this->request = $req;
        $request = $req;
    }

    public function view($file) {
        if (empty($this->view)) {
            $this->view = new View();
        }
        $this->view->render($file);
    }

}

function response($response = null) {
    if ($response == null) {
        $response = new Response();
    }
    return $response;
}

function redirect($url = null) {
    if (empty($url)) {
        return new Redirect();
    }
    header("Location: $url");
}
