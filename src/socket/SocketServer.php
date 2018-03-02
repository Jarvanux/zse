<?php

//Evita que el servidor caduque...
set_time_limit(0);
require_once './src/bin/Roots.php';
require_once PATH_BIN . "Response.php";
require_once PATH_BIN . "EMessages.php";
require_once './src/socket/class.PHPWebSocket.php';

// Cuando el cliente envia data al servidor.
function wsOnMessage($clientID, $message, $messageLength, $binary) {
    global $Server;
    $ip = long2ip($Server->wsClients[$clientID][6]);

    //Verifica que la longitud del mensaje sea mayor a 0
    if ($messageLength == 0) {
        $Server->wsClose($clientID);
        return;
    }
    //Verifica si solo hay un conectado en la sala.
    if (sizeof($Server->wsClients) == 1) {
        $Server->wsSend($clientID, (new Response(EMessages::SOCKET_NO_FOUND_USERS))->toString());
    } else {
        //De lo contrario enviará el mensaje a todos los presentes...
        foreach ($Server->wsClients as $id => $client) {
            if ($id != $clientID) {
                $response = new Response(EMessages::SOCKET_MESSAGE);
                $response->setData([
                    "clientID" => $clientID,
                    "IP" => $ip,
                    "message" => $message
                ]);
                $Server->wsSend($id, $response->toString());
            }
        }
    }
}

//Cuando alguien se conecta.
function wsOnOpen($clientID) {
    global $Server;
    $ip = long2ip($Server->wsClients[$clientID][6]);

//    $Server->log("$ip ($clientID) has connected.");
    //Envia una notificación a todos los presentes para informar sobre el nuevo conectado.
    foreach ($Server->wsClients as $id => $client) {
        if ($id != $clientID) {
            $response = new Response(EMessages::SOCKET_OPEN);
            $response->setData([
                "clientID" => $clientID,
                "IP" => $ip
            ]);
            $Server->wsSend($id, $response->toString());
        }
    }
}

//Cuando el cliente pierde o cierra la conexión
function wsOnClose($clientID, $status) {
    global $Server;
    $ip = long2ip($Server->wsClients[$clientID][6]);

//    $Server->log("$ip ($clientID) has disconnected.");
    //Notifica a todos sobre dicho cliente desconectado.
    foreach ($Server->wsClients as $id => $client) {
        $response = new Response(EMessages::SOCKET_CLOSED);
        $response->setData([
            "clientID" => $clientID,
            "IP" => $ip
        ]);
        $Server->wsSend($id, $response->toString());
    }
}

//Inicia el servidor..
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');

//Para que otras computadoras se conecten, es probable necesitar cambiar la IP LAN o la IP externa.
//alternativamente puede usar: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$cogs = require PATH_CONFIG . 'socket.php';
$host = $cogs["host"];
$port = $cogs["port"];
$Server->wsStartServer($host, $port);
?>
