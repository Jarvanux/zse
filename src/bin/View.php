<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class View {

    private static $variables;
    private static $sections = [];
    private static $output;

    function __construct() {
        
    }

    public static function make($file, $variables = null) {
        return self::render($file, $variables);
    }

    public static function renderAbsolute($filename) {
        $this->includeFile($file = PATH_VIEWS . $filename);
    }

    private function includeFile($file) {
        if (is_array(self::$variables)) {
            if (isset(self::$variables)) {
                foreach (self::$variables as $key => $value) {
                    global ${$key};
                    ${$key} = $value;
                }
            }
        }
        if (file_exists($file . ".php")) {
            return include $file . ".php";
        } else if (file_exists($file . ".html")) {
            return include $file . ".html";
        } else if (file_exists($file)) {
            return include $file;
        } else {
            echo "<h2>NO EXISTE EL FICHERO: " . $file . "</h2><br/>";
        }
    }

    public function render($filename, $variables = null) {
        if (isset($variables)) {
            self::$variables = $variables;
        }
        $file = PATH_VIEWS . $filename;
        ob_start();
        self::includeFile($file);
        $_output = ob_get_contents();
        ob_end_clean();
        $_output = self::execTags($_output);
        $_output = preg_replace('/(@yield([^\s])+)/', '', $_output);

        $_output = self::translate($_output);
        $_output = self::evals($_output);
        return $_output;
    }

    public static function import($file) {
        ob_start();
        self::includeFile(PATH_VIEWS . $file);
        $output = ob_get_contents();
        $output = self::execTags($output);
        ob_end_clean();
        return $output;
    }

    private static function translate($output) {
        $output = preg_replace_callback('/##(.*?)##/', function($m) {
            return Lang::trans($m[1]);
        }, $output);
        return $output;
    }

    private static function evals($output) {
        $output = preg_replace_callback('/{{(.*?)}}/', function($m) {
            if (is_array(self::$variables)) {
                if (isset(self::$variables)) {
                    foreach (self::$variables as $key => $value) {
                        global ${$key};
                        ${$key} = $value;
                    }
                }
            }

            $code = $m[1];
            return eval("return " . $code . ";");
        }, $output);
        return $output;
    }

    private static function execTags($output) {
        self::$output = preg_replace_callback('/@(.+).*\("([^)]*)"\)/', function($m) {
            return ViewCompiler::replace($m, self::$variables);
        }, $output);
        self::$output = View::findSections();
        return self::$output;
    }

    public static function findSections() {
        $parts = explode("@section", self::$output);
        if (count($parts) > 1) {
            foreach ($parts as $value) {
                //Se completa la seccion...
                $value = "@section" . $value;
                //Se limpia la seccion...
                self::$output = str_replace($value, "", self::$output);
                //Se busca en la seccion, los datos...
                preg_replace_callback('/@section\s*\("([^"]*)..(.*?)((?>(?!@(?:end)?section).|(?0))*)@endsection/s', function($m) {
                    self::$sections[] = $m;
                    return "";
                }, $value);
            }
        }
        self::$output = View::findYields();
        return self::$output;
    }

    public static function findYields() {
        foreach (self::$sections as $section) {
            self::$output = str_replace('@yield("' . $section[1] . '")', $section[3], self::$output);
        }
        return self::$output;
    }

}

function view($file, $variables = null) {
    $view = new View();
    return $view->render($file, $variables);
}
