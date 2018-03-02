<?php

class Artisan {

    protected $args;

    function __construct($args) {
        $this->args = $args;
    }

    function run() {
        if (count($this->args) > 1) {
            $type = $this->args[1];
            //Obtenemos el comando.
            $command = $this->args[1];
            $args = [];
            $i = 0;
            //Obtenemos los argumentos (parámetros).
            foreach ($this->args as $arg) {
                if ($i > 1) {
                    $args[] = $arg;
                }
                $i++;
            }
            $p = new Process($command, $args);
            $p->run();
        } else {
            $lines = "Use:\n"
                    . " command [options] [arguments]\n\n"
                    . " Opciones:\n"
                    . " -h --help               \tMuestra el mensaje de ayuda\n"
                    . " -V --version            \tMuestra la version de deplyn\n\n\n"
                    . "Comandos:\n"
                    . " make:\n"
                    . "     make:auth           \tGenera el modulo del login, el registro y la \n"
                    . "                         \trecuperacion de clave.\n\n"
                    . "     make:controller     \tCrear un controlador.\n"
                    . "     make:middleware     \tCrear un middleware (no lo registra, el \n"
                    . "                         \tregistro es manual).\n\n"
                    . "     make:validation     \tCrear una capa de validacion.\n"
                    . "     make:model          \tCrea un modelo(clase) desde la(s) tabla(s)\n"
                    . "                         \tde la base de datos.\n\n"
                    . "     make:dao            \tCrea un modelo DAO (Generalmente sirven \n"
                    . "                         \tpara extender de un modelo y agregar/crear\n"
                    . "                         \tconsultas personalizadas).\n\n"
                    . "     make:delegate       \tCrea un delegado (Generalmente llevarán\n"
                    . "                         \tToda la lógica de programación que usarán\n"
                    . "                         \tlos controladores para realizar una operación\n"
                    . "                         \ty comunicar a la vista su respuesta).\n\n"
                    . "     make:socket         \tLanzar el servicio de sockets.\n";
            echo $lines;
        }
    }

}
