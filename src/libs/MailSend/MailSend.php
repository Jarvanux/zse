<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class MailSend {

    var $config;

    //Para el constructor tenemos dos opciones, importar un archivo 
    //con la configuración del email que usará el sistema, 
    //o por otro lado cargar un objeto con la información necesaria, 
    //para concer la estructura que devemos enviar
    //en el objeto, verificar el archivo /MailSend/config.php
    function __construct($cog = null) {
        if (is_null($cog)) {
//            $cog = include app_path() . '/MailSend/config.php'; => LARAVEL.
            $cog = include PATH_LIBS . 'MailSend/config.php';
        }
        $this->config = $cog;
    }

    /**
     * 
     * @param type $emailAddress = Recibe el email de destino.
     * @param type $subject = Recibe el el asunto del mensaje.
     * @param type $imagesFiles = Recibe un array con las imagenes que usarás para el html.
     * @param type $attachFiles = Recibe un array con las rutas de los archivos que deseas enviar.
     */
    private function sendMail($emailAddress, $subject, $message, $imagesFiles, $attachFiles) {
        try {
            require_once PATH_LIBS . '/MailSend/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->From = $this->config['From'];
            $mail->CharSet = 'UTF-8';
            $mail->FromName = $this->config['FromName'];
            $mail->Subject = $subject;
            $mail->Host = $this->config['Host'];
            $mail->Port = $this->config['Port'];
            $mail->SMTPAuth = $this->config['SMTPAuth'];
            $mail->Username = $this->config['Username'];
            $mail->Password = $this->config['Password'];
            $mail->Sender = $this->config['Sender'];
            $mail->AddReplyTo($this->config['AddReplyTo']);
            if (is_array($emailAddress)) {
                foreach ($emailAddress as $email) {
                    $mail->AddAddress($email);
                }
            } else {
                $mail->AddAddress($emailAddress);
            }
            if (isset($this->config['AddBCC'])) {
                if (is_array($this->config['AddBCC'])) {
                    foreach ($this->config['AddBCC'] as $email) {
                        $mail->AddBCC($email);
                        //$mail->AddCC($email);
                    }
                } else {
                    $mail->AddBCC($this->config['AddBCC']);
                }
            }
            $mail->IsHTML(TRUE);
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Se agregan las imagenes que se van a usar junto a nuestro email.
            if (is_array($imagesFiles)) {
                foreach ($imagesFiles as $valor) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // devuelve el tipo mime de su extensión
                    $type = finfo_file($finfo, $valor);
                    finfo_close($finfo);
                    $nameImage = explode("/", $valor);
                    $nameImage = end($nameImage);
                    //Los valores que resiben se clasifican así:
                    //Ruta del archivo,Nombre del archivo para referenciar en el html, nombre del archivo adjunto en el email, Tipo de compilación,Tipo del archivo(mime/type)
                    $mail->AddEmbeddedImage($valor, $nameImage, $nameImage, "base64", $type);
                }
            }
            //Se agregan los archivos que se hayan cargado junto al correo electronico.
            if (is_array($attachFiles)) {
                foreach ($attachFiles as $valor) {
                    $mail->AddAttachment($valor);
                }
            }
            $mail->Body = $message;

            $response = array("No llegó");
            if ($mail->Send()) {
                $response = array();
                $response['code'] = 1;
                $response['message'] = "Se ha enviado el email correctamente.";
            } else {
                $response = array();
                $response['code'] = -1;
                $response['message'] = "No se pudo enviar el email. " . 'ERROR-' . $mail->ErrorInfo;
            }
        } catch (Exception $exc) {
            $response = array();
            $response['code'] = -1;
            $response['message'] = "No se pudo enviar el email. " . 'ERROR-' . $mail->ErrorInfo;
        }
        return $response;
    }

    /**
     * Recibe un objeto con todos los parámetros necesarios, para crear el correo.
     * 
     * @param type $params ['subject'] = "Asunto", \n
     * ['emailAddress'] = "Destinatario",\n
     * ["message"] = Archivo html con la plantilla para el correo, \n
     * ["replaces"] = Array con fraces a reemplazar en el correo.\n
     * ["images_in_html"] = "Array con la ruta de Imágenes usadas en el archivo html..."\n
     * ["attachFiles"] = "Archivos adjuntos",\n
     * @return type objeto [code,message] code = 1 si se envia el mensaje, y -1 si no lo hace.\n
     */
    private function file_exist($url = NULL) {
        if (empty($url)) {
            return false;
        }

        if (file_exists($url)) {
            return true;
        }
        return false;
    }

    public function send($params) {
        $subject = isset($params['subject']) ? $params['subject'] : NULL;
        $emailAddress = isset($params['address']) ? $params['address'] : NULL;
        $imagesFiles = isset($params['images_in_html']) ? $params['images_in_html'] : NULL;
        $attachFiles = isset($params['attach_files']) ? $params['attach_files'] : NULL;
        $message = "";
        if (isset($params['message'])) {
            if ($this->file_exist($params['message'])) {
                $message = file_get_contents($params['message']);
            } else {
                $message = $params['message'];
            }
        } else {
            $message = "Null";
        }
        if (isset($params['replaces'])) {
            for (reset($params['replaces']); list ($clave, $valor) = each($params['replaces']);
            ) {
                $message = str_replace($clave, $valor, $message); //Se cambia el link del enlace...    
            }
        }
        $message = str_replace('src="', 'src="cid:', $message); //Se reemplaza el src para agregarle un cid que nos permitirá acceder a las imagenes cargadas en el correo.            
        return $this->sendMail($emailAddress, $subject, $message, $imagesFiles, $attachFiles);
    }

}

?>