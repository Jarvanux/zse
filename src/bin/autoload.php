<?php

require './src/bin/Roots.php';
require PATH_BIN . 'Autoloader.php';

Autoloader::register();

$files = scandir(PATH_ROUTES);
foreach ($files as $file) {
    if (is_file(PATH_ROUTES . $file)) {
        require PATH_ROUTES . $file;
    }
}

Route::submit();
