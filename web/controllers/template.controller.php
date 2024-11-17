<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class templateController
{
    /** * Traemos la vista principal del plantilla
     * @return void
     */
    public function index()
    {
        include "views/template.php";
    }
    /** * Ruta Principal o Dominio del sitio
     * @return string*/
    static public function path()
    {
        if (!empty($_SERVER["HTTPS"]) && ("on" == $_SERVER["HTTPS"])) {
            return "https://" . $_SERVER["SERVER_NAME"] . "/";
        } else {
            return "http://" . $_SERVER["SERVER_NAME"] . "/";
        }
    }

    //FUNCION PARA CREAR CORREOS ELECTRONICOS
    static public function sendEmail($subjet, $email, $messages, $title, $link)
    {
        date_default_timezone_set("America/Bogota");
        $mail = new PHPMailer;
        $mail->CharSet = "utf-8";
        // $mail->Encoding = "base64"; //Habilitar al subir el sistema a un hosting
        $mail->isMail();
        $mail->UseSendmailOptions = 0;
        $mail->setFrom("noreply@ecommerce.com", "Cielo Rosa MakepShop");
        $mail->Subject = $subjet;
        $mail->addAddress($email);
        $mail->msgHTML('    <div
        style="width: 100%; background: #eee;position: relative; font-family: sans-serif;  padding-top: 40px; padding-bottom: 40px;">
        <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
            <center>
                <img src="'.TemplateController::path() .'/views/assets/img/template/1/logo.png" alt="Logo"
                    style="padding: 20px; width: 30%;">

                <h3 style="font-weight: 100; color: #999;">'.$title.'</h3>

                <hr style="border: 1px solid #ccc;width: 80%;">

                '.$messages.'

                <a href="'.$link .'" target="_blank" style="text-decoration: none;">
                    <div
                        style="line-height: 25px; background: #000; width: 60%; padding: 10px; color:white ; border-radius: 5px;">
                        Haz click aqui
                    </div>
                </a>


                <hr style="border: 1px solid #ccc;width: 80%;">
                <h5 style="font-weight: 100; color: #999;">Si no solicito el envio de este correo, comuniquese con
                    nosotros de inmediato</h5>
            </center>

        </div>



    </div>');
        $send = $mail->Send();


        if (!$send) {
            return $mail->ErrorInfo;
        } else {
            return "OK";
        }
    }
}
