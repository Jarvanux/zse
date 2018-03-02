<?php

class IndexController extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Mostrar una lista del recurso.
     *
     * @return Response
     */
    public function index() {        
        return view("welcome", ["variable" => "HOLA! :D"]);
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Guardar un nuevo recurso.
     *
     * @param  Request  \$request
     * @return Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  \$id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     *
     * @param  int  \$id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Actualizar el recurso especificado en la bd.
     *
     * @param  int  \$id
     * @param  Request \$request
     * @return Response
     */
    public function update($id, Request $request) {
        
    }

    /**
     * Elimine el recurso especificado de la bd.
     *
     * @param  int  \$id
     * @return Response
     */
    public function destroy($id) {
        
    }

    public function guardar(Request $request) {
        return $request->nombre . " -- Token: " . $request->_token;
    }

}
