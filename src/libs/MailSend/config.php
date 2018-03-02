<?php

/*
 * Configuración MailSend
 * @author = jhonjaider1000.
 * @author = John Jaider Vanegas - .
 */
//
$email = "contacto@starlly.com";
$pass = "jhon151221";
return [
    'From' => "contacto@starlly.com", //Email que usará para enviar los correos del sistema.
    'FromName' => "Starlly", //Nombre personalizado que aparecerá del remitente.
    'Host' => "	mx1.hostinger.co", //Servidor que se usará para el enviar los correos electrónicos.
    'Port' => 587, //Puerto del servidor de correo electrónico.      

    /* Identificación en SMTP - IMPORTANTE!! */
    //Información de ingreso/login - email, debe especificarse para logear con el servidor de correo.
    'SMTPAuth' => TRUE,
    'Username' => $email, //Correo de logeo/acceso.
    'Password' => $pass, //Clave correo                        
//Direcciones destino        
    'Sender' => "contacto@starlly.com", //Remitente - Nuevamente quien envía el csorreo electrónico.
    'AddReplyTo' => "contacto@starlly.com", //Responder a, email para recibir las respuestas.
//    'AddBCC' => array("jjvanegas67@misena.edu.co"), //Email para replicar los mensajes enviados, si no se desea es necesario poner FALSE.
//Edición del contenido.
    'IsHTML' => TRUE,
];
