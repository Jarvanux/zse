<?php

class Process {

    private $command;
    private $args;

    function __construct($command, $args) {
        $this->command = $command;
        $this->args = $args;
    }

    public function run() {
        $this->startAction();
    }

    private function startAction() {
        switch ($this->command) {
            case "make:auth":
                echo "Módulo no disponible en el momento.";
                break;
            case "make:controller":
                $this->createController();
                break;
            case "make:validation":
                $this->createValidation();
                break;
            case "make:middleware":
                $this->createMiddleware();
                break;
            case "make:model":
                $this->createModel();
                break;
            case "make:delegate":
                $this->createDelegate();
                break;
            case "make:dao":
                $this->createDao();
                break;
            case "make:socket":
                $this->launchSocket();
                break;
            default :
                echo "Error: Comando no encontrado.\n";
                break;
        }
    }

    private function createModel() {
        $name_table = $this->args[0];
        require_once PATH_UTILS . "artisan/bin/CamelTypes.php";
        $path = PATH_MODELS;
        $className = CamelTypes::camelCase($name_table);
        $file = new File($path . "$className.php");
        $fileModel = PATH_UTILS . "artisan/source/Model.dpy";
        if (isset($this->args[1])) {
            //Nombre personalizado...
            $file = new File($path . $this->args[1] . ".php");
        }
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $className, $content);
        //Ahora consultamos los parámetros...
        require_once PATH_UTILS . "artisan/bin/ModelProcessor.php";
        $process = new ModelProccessor();
        $res = $process->getFields($name_table);
        $dbconfig = require PATH_CONFIG . "database.php";
        $sqlLang = $dbconfig["connections"][$dbconfig["default"]]["driver"];
        $atributes = "";
        $getterandsetters = "";
        foreach ($res as $value) {
            $field = EQueries::getQuery(EQueries::FIELD_NAME, $sqlLang);
            $field = $value->{$field};
            $atributes .= "protected $$field;
    ";
            $fieldCS = CamelTypes::camelCase($field);
            $getterandsetters .= "    public function set$fieldCS($$field) {
        \$this->$field = $$field;
    }
";
            $getterandsetters .= "    public function get$fieldCS() {
        return \$this->$field;
    }
";
        }
        $content = str_replace("ATTRIBUTES", $atributes, $content);
        $content = str_replace("NAME_TABLE", $name_table, $content);
        $content = str_replace("GETTERANDSETTERS", $getterandsetters, $content);
        echo $content;
        $file->write($content);
        echo $className . " --> Creado correctamente.";
    }

    private function createMiddleware() {
        $className = $this->args[0];
        $path = PATH_MIDDLEWARES;
        $file = new File($path . "$className.php");
        $fileModel = PATH_UTILS . "artisan/source/Middleware.dpy";
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $className, $content);
        $file->write($content);
        echo $className . " --> Creado correctamente.\n";
    }

    private function createValidation() {
        $className = $this->args[0];
        $path = PATH_VALIDATIONS;
        $file = new File($path . "$className.php");
        $content = null;
        $fileModel = PATH_UTILS . "artisan/source/Validation.dpy";
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $className, $content);
        $file->write($content);
        echo $className . " --> Creado correctamente.\n";
    }

    private function createController() {
        $nameController = $this->args[0];
        $path = PATH_CONTROLLERS;
        $file = new File($path . "$nameController.php");
        $content = null;
        $fileModel = null;
        if ((isset($this->args[1])) ? $this->args[1] == "-r" : false) {
            $fileModel = PATH_UTILS . "artisan/source/FullController.dpy";
        } else {
            $fileModel = PATH_UTILS . "artisan/source/SimpleController.dpy";
        }
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $nameController, $content);
        $file->write($content);
        echo $nameController . " --> Creado correctamente.\n";
    }

    public function createDelegate() {
        $className = $this->args[0];
        $path = PATH_DELEGATES;
        $file = new File($path . "$className.php");
        $content = null;
        $fileModel = PATH_UTILS . "artisan/source/Delegate.dpy";
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $className, $content);
        $file->write($content);
        echo $className . " --> Creado correctamente.\n";
    }

    public function createDao() {
        $modelClassName = $this->args[0];
        $path = PATH_DAO;
        var_dump($this->args);
        $fileName = $modelClassName . "DAO";
        if (isset($this->args[1])) {
            echo "HAY OTRO";
            $fileName = $this->args[0];
            $modelClassName = $this->args[1];
        }
        $file = new File($path . "$fileName.php");
        $content = null;
        $fileModel = PATH_UTILS . "artisan/source/Dao.dpy";
        $content = file_get_contents($fileModel);
        $content = str_replace("ClassName", $fileName, $content);
        $content = str_replace("ModelClass", $modelClassName, $content);
        $file->write($content);
        echo $fileName . " --> Creado correctamente.\n";
    }

    public function launchSocket() {
        try {
            $cogs = require PATH_CONFIG . 'socket.php';
            $host = $cogs["host"];
            $port = $cogs["port"];
            echo "Se ha ejecutado el socket en $host:$port correctamente...\n";
            shell_exec("php ./src/socket/SocketServer.php");
            echo "Se ha detenido el socket.";
        } catch (Exception $exc) {
            echo "Error: No se pudo ejecutar el socket correctamente.\n";
        }
    }

}
