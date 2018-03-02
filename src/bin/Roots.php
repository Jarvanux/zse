<?php

//Configuración de carga.
define('PROJECT_NAME', 'Deplyn');
define('VERSION', '1.0');
define('PATH_ROUTES', './routes/');
define('ASSETS', './assets/');
define('PATH_APP', './app/');
define('PATH_VIEWS', './resources/views/');
define('PATH_LANGS', './resources/langs/');
define('PATH_CONTROLLERS', PATH_APP . 'Http/Controllers/');
define('PATH_VALIDATIONS', PATH_APP . 'Http/Validations/');
define('PATH_MODELS', PATH_APP . 'Models/');
define('PATH_DELEGATES', PATH_APP . 'Delegates/');
define('PATH_DAO', PATH_APP . 'Dao/');
define('PATH_SRC', './src/');
define('PATH_BIN', PATH_SRC . 'bin/');
define('PATH_SOCKET', PATH_SRC . 'socket/');
define('PATH_LIBS', PATH_SRC . 'libs/');
define('PATH_UTILS', PATH_SRC . 'utils/');
define('PATH_MIDDLEWARES', PATH_APP . 'Http/Middleware/');
define('MAILSEND', PATH_SRC . 'libs/MailSend/MailSend.php');
define('FACEBOOK', 'https://www.facebook.com/StarllyOfficial');
define('TWITTER', 'https://www.twitter.com/StarllyOfficial');
define('GOOGLEPLUS', 'https://www.googleplus.com/StarllyOfficial');
define('YOUTUBE', 'https://www.youtube.com/Starlly');

//Configuración URL y DEBUG de la aplicación.
define('PATH_CONFIG', './config/');
require PATH_BIN . "App.php";
define('DEBUG', App::debug());
//Configuración de la aplicación.
define("DATE_LONG", "Y-m-d H:i:s");
define("DATE_SHORT", "Y-m-d");
define("DATE_HOUR", "H:i:s");
