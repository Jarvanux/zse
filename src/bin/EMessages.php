<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class EMessages {

    const SUCCESS = "SUCCESS";
    const INSERT = "INSERT";
    const UPDATE = "UPDATE";
    const DELETE = "DELETE";
    const ERROR = "ERROR";
    const WARNING = "WARNING";
    const ERROR_CSRF_TOKEN = "ERROR_CSRF_TOKEN";
    const ERROR_QUERY = "ERROR_QUERY";
    const ERROR_INSERT = "ERROR_INSERT";
    const ERROR_UPDATE = "ERROR_UPDATE";
    const ERROR_DELETE = "ERROR_DELETE";
    const ERROR_ACTION = "ERROR_ACTION";
    const ERROR_FATAL = "ERROR_FATAL";
    const SOCKET_OPEN = "SOCKET_OPEN";
    const SOCKET_CLOSED = "SOCKET_CLOSED";
    const SOCKET_NO_FOUND_USERS = "SOCKET_NO_FOUND_USER";
    const SOCKET_MESSAGE = "SOCKET_NEW_USER";

    public static function getResponse($code) {
        switch ($code) {
            case EMessages::SUCCESS:
                return new Response(1, "Se ha consultado con éxito.");
            case EMessages::INSERT:
                return new Response(1, "Se ha insertado el registro con éxito.");
            case EMessages::UPDATE:
                return new Response(1, "Se ha actualizado el registro con éxito.");
            case EMessages::DELETE:
                return new Response(1, "Se ha eliminado el registro con éxito.");
            case EMessages::WARNING:
                return new Response(0, "Warning");
            case EMessages::ERROR:
                return new Response(-1, "Error");
            case EMessages::ERROR_CSRF_TOKEN:
                return new Response(-1, "Error, el csrf_token no es válido.");
            case EMessages::ERROR_QUERY:
                return new Response(-1, "Error al consultar.");
            case EMessages::ERROR_INSERT:
                return new Response(-1, "Error al insertar.");
            case EMessages::ERROR_UPDATE:
                return new Response(-1, "Error al actualizar.");
            case EMessages::ERROR_DELETE:
                return new Response(-1, "Error al eliminar.");
            case EMessages::ERROR_ACTION:
                return new Response(-1, "Error al ejecutar la acción solicitada.");
            case EMessages::ERROR_FATAL:
                return new Response(-99, "Error fatal.");
            case EMessages::SOCKET_OPEN:
                return new Response(100, "Se ha conectado un nuevo usuario al socket.");
            case EMessages::SOCKET_CLOSED:
                return new Response(-100, "Se ha desconectado del socket.");
            case EMessages::SOCKET_MESSAGE:
                return new Response(150, "Se ha recibido un nuevo mensaje.");
            case EMessages::SOCKET_NO_FOUND_USERS:
                return new Response(-100, "No se han encontrado más usuarios conectados al socket.");
        }
    }

}
