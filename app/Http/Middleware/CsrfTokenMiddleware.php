<?php

class CsrfTokenMiddleware extends Middleware {

    public function handle($request) {
        if (in_array($request->method, CsrfToken::methods())) {
            if (!CsrfToken::verifyToken($request)) {
                $response = new Response(EMessages::ERROR_CSRF_TOKEN);
                $response->printJSON();
                return false;
            }
        }
        return true;
    }

}
