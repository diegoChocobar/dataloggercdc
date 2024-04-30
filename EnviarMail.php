<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Argentina/Salta');


function EnviarMail_Prueba($email,$user_name){

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $data = array();
    $confirmacion_email_url = "https://dataloggercdc.com/confirmacionemail.php?user=".$user_name."&email=".$email;

    $mail = new PHPMailer(true);

    $email_admin1 = 'd.r.chocobar@gmail.com';
    $name_admin1 = 'Chocobar Diego';

        try {
          ////////////////////////////CONFIGURACION MAIL HOSTINGER //////////////////
          ///*
          $mail->SMTPDebug = 0;                          // Enable verbose debug output
          $mail->isSMTP();                              // Send using SMTP
          $mail->Host       = 'smtp.hostinger.com';     // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                     // Enable SMTP authentication
          $mail->Username   = 'chocobar@cdcelectronics.com';     // SMTP username
          $mail->Password   = 'ChDi0106!';               // SMTP password
          $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
          //Recipients
          $mail->setFrom('chocobar@cdcelectronics.com', 'CDC ELECTRONICS ');
          
          //$mail->addAddress($email);                      // Email del usuario. Es a quien se envia el mail
          $mail->addAddress($email_admin1);


          // Content
          $mail->isHTML(true);// Set email format to HTML
            
            $cuerpo = '
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                    <title>CDC ELECTRONICS - CONFIRMACION DE EMAIL</title>
                    <style>
                        .boton {
                            border: 5px solid #3FFF33; /*anchura, estilo y color borde*/
                            padding: 15px; /*espacio alrededor texto*/
                            background-color: #3FFF33; /*color botón*/
                            color: #FFFFFF; /*color texto*/
                            text-decoration: none; /*decoración texto*/
                            text-transform: uppercase; /*capitalización texto*/
                            font-family: "Helvetica", sans-serif; /*tipografía texto*/
                            border-radius: 50px; /*bordes redondos*/
                            }
                    </style>
                </head>'.
                '<body>'
                    .'<h2>CONFIRMACION DE EMAIL</h2>'
                    .'<br>Buenos días estimado <strong>'. $user_name .'</strong>, este es un email de confirmacion.'
                    .'<br>Por favor hacer click en siguiente boton para confirmar su email.'
                    .'<br><br><p><a class="boton" href='.$confirmacion_email_url.' target="_blank">VALIDAR</a></p><br><br>'
                    .'<br>Desde ya muchas gracias y cualquier consulta estamos a su disposicion.'
                    .'<p>
                        <br>Saludos cordiales.
                     </p>'.

                '<p>'.
                  '<br><br><i>CDC ELECTRONICS</i>'.
                  '<br><i>Diego Chocobar - chocobar@cdcelectronics.com</i>'.
                '</p>'.

                '</body>
                </html>
            ';
            

            $mail->Subject = 'CDC ELECTRONICS - CONFIRMACION DE EMAIL';
            $mail->Body    = $cuerpo;

            $mail->send();
            $data_email['status_email'] = true;
            return $data_email;

        } catch (Exception $e) {
            $data_email['status_email'] = false;
            return $data_email;
        }


}


?>
