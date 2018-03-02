<?php

return [
    "lang" => "es",
    "time_zone" => "America/Bogota",
    "csrf_token" => true,
    "csrf_token_time" => 0, //Secounds
    "csrf_token_methods" => ["POST", "PUT", "DELETE"],
    "debug" => true,
    //Utiliza time() como "version" para que el navegador no cache tus archivos css, js, img, etc.
    "version" => time(),
    "pages" => [
        "404" => 'errors/404.php'
    ],
    "storage" => [
        "upload_folder" => "uploads",
    ]
];
