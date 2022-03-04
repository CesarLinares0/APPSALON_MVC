<?php
namespace Layout;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        //Crear instancia de PHPMailer - Para enviar correos
        $mail = new PHPMailer();
        $mail->isSMTP();                        //Usamos el protocolo SMTP
        $mail->Host = 'smtp.mailtrap.io';       //Servidor de correo (mailtrap)
        $mail->SMTPAuth = true;                 //Activamos la autentificación
        $mail->Port = 2525; 
        $mail->Username = '1e709bda459039';
        $mail->Password = 'd716a2692e4c65';
        // $mail->SMTPSecure = 'tls';              //Metodo de incriptación - tls es un metodo más seguro y recomendado que ssl

        //Configurar contendido del mail
        $mail->setFrom('cuentas@appsalon.com');                     //Quien envia el mail
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');      //A quien se lo envias
        $mail->Subject = 'Confirma tu cuenta';                      //Titulo del mensaje

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';   //Habilitar caracteres especiales

        //Definir el contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . ".</strong> Has creado tu cuenta en AppSalon, para confirmar tu cuenta presiona el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es un texto alternativo, sin HTML';  //Contenido alternativo, en caso de no soportar HTML

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones() {

        //Crear instancia de PHPMailer - Para enviar correos
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525; 
        $mail->Username = '1e709bda459039';
        $mail->Password = 'd716a2692e4c65';
        // $mail->SMTPSecure = 'tls';              //Metodo de incriptación - tls es un metodo más seguro y recomendado que ssl

        //Configurar contendido del mail
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu contraseña';

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //Definir el contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . ".</strong> Has solicitado reestablecer tu contraseña, presiona el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=". $this->token ."'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es un texto alternativo, sin HTML';

        //Enviar el email
        $mail->send();
    }
}