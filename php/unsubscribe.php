<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación WEB usando HTML5, CSS3, javascript, jquery y MYSQL - Edificio E3      //
// Copyright 2015 Wilson Giovanny Velandia Barreto 3165879350 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////

$user = $_SESSION['user_id'];
$fecha = date('Y-m-d');
$hora = date('H:i');
$email = $_POST['email'];
$tipo = 4;
// tipo de email en tabla e3_mail 4 = unsubscribe

$mail = "SELECT e3_mail_id FROM e3_mail WHERE e3_mail_dir = '$email' AND e3_mail_tipo = '$tipo'";
$res_mail = mysql_query($mail, conexion());
if($res_mail){
    if(mysql_num_rows($res_mail) < 1){
        $users = "SELECT e3_user_nom, e3_user_ape, e3_user_email FROM e3_user WHERE e3_est_id = '1' AND e3_tcont_id = '2' AND e3_user_email = '$email'";
        $res_users = mysql_query($users, conexion());
        if($res_users){
            if(mysql_num_rows($res_users) > 0){
                $row_users = mysql_fetch_array($res_users);
                $dir_email .= $row_users[2];
                $user_nombre = strtoupper($row_users[0]).' '.strtoupper($row_users[1]);

                $plantilla = '
                    <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="UTF-8">
                            <title>Recordatorio Pausas Activas</title>
                        </head>
                        <body>
                            <div style="width:100%;margin:auto;">
                                <div style="width:80%;margin: 20px auto;border: 1px solid #8E8989;border-radius: 5px;">
                                    <div style="margin:auto;text-align:center;">
                                        <h1>Edificio E3 - Pausas Activas</h1>
                                        <h3>Sr(a) '.$user_nombre.' a partir de este momento dejará de recibir notificaciones a la cuenta de correo: "'.$dir_email.'"</h3>
                                        <h2>Sentimos las molestias ocasionadas</h2>
                                    </div>
                                    <div style="margin:auto;text-align:center;">
                                        <h5><div>Contacto: info@rmasb.com Tel: 7446168</div>
                                            Copyright &copy;
                                            <span id="year" class="mr5">2015</span>
                                            <span>R + B Diseño Experimental S.A.S.</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </html>
                ';
                // $dir_email = "willyv78@gmail.com";
                // $para = "willyv78@hotmail.com";
                $para = $dir_email;
                $asunto = utf8_decode("Unsubscribe Recordatorio Pausas Activas");
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $cabeceras .= 'From: info@rmasb.com' . "\r\n";
                // $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                $cabeceras .= 'Bcc: info@rmasb.com' . "\r\n";
                // Envio de correo electronico a los involucrados en la solicitud
                mail($para, $asunto, $plantilla, $cabeceras);
                // ingresamos el registro en la tabla e3_mail
                $ins = "INSERT INTO e3_mail (e3_mail_dir, e3_mail_dia, e3_mail_asu, e3_mail_men, e3_mail_tipo, e3_mail_fecha) VALUES ('$dir_email', '$fecha', '$asunto', '$plantilla', '$tipo', NOW())";
                $res_ins = mysql_query($ins, conexion());
                if($res_ins){
                    echo $tipo;
                }
            }
        }
    }
    else{echo $tipo;}
}
?>