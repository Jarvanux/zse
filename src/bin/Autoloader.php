<?php

/**
 * <b>Deplyn class</b><br/>
 * ------------<br/>
 * Esta clase registrará el método de autocarga de las clases del proyecto.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Autoloader {

    public static function register() {
        if (function_exists('__autoload')) {
            spl_autoload_register('__autoload');
        }

        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            return spl_autoload_register(array('Autoloader', 'load'), true, true);
        } else {
            return spl_autoload_register(array('Autoloader', 'load'));
        }
    }

    public static function load($className) {
        $file = $className . ".php";
        $folders = [
            PATH_BIN, PATH_DELEGATES, PATH_MODELS,
            PATH_DAO, PATH_VALIDATIONS,
            PATH_MIDDLEWARES, PATH_LIBS
        ];
        $imported = 0;
        foreach ($folders as $folder) {
            $path = $folder . $file;
            if (file_exists($path)) {
                require_once $path;
                $imported++;
                break;
            }
        }
        if ($imported == 0) {
            return false;
        }
    }

}
