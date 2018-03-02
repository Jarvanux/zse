<?php

/**
 * Si requiere el uso de sockets en su aplicación, solo bastará con ejecutar la
 * opción make:socket para lanzar el socket en el servidor & puerto que 
 * configure a continuación.
 * 
 * A continuación, algunos comandos útiles:
 * 
 * Comprobar estado de un puerto, donde 9500 será el puerto que desea verificar.
 * $ sudo netstat -ap | grep :9500
 */
return [
    "host" => "localhost",
    "port" => 9505,
];
