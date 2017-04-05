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
$tipo = $_POST['tipo'];
$ndia = date('N', strtotime($fecha));

$res = registroCampo("e3_cal", "e3_cal_fini", "WHERE e3_cal_tipo = '2' AND date_format(e3_cal_fini, '%Y-%m-%d') = '$fecha'", "", "");
if($res){
    if(mysql_num_rows($res) > 0){
        echo $tipo;
    }
    else{
        if(($ndia <> '0') && ($ndia <> '6')){
            // echo $ndia."<br>";
            if($tipo <> ''){
                $mail = "SELECT e3_mail_id FROM e3_mail WHERE e3_mail_dia = '$fecha' AND e3_mail_tipo = '$tipo'";
                $res_mail = mysql_query($mail, conexion());
                if($res_mail){
                    if(mysql_num_rows($res_mail) < 1){
                        $users = "SELECT u.e3_user_email FROM e3_user u WHERE u.e3_est_id = '1' AND u.e3_tcont_id = '2' AND u.e3_user_email NOT IN (SELECT m.e3_mail_dir FROM e3_mail m WHERE m.e3_mail_tipo = '4') GROUP BY u.e3_user_email";
                        $res_users = mysql_query($users, conexion());
                        if($res_users){
                            if(mysql_num_rows($res_users) > 0){
                                $sw = 0;
                                $dir_email = "";
                                while ($row_users = mysql_fetch_array($res_users)) {
                                    if(($row_users[0] <> '') && ($row_users[0] <> 'lcorredor@tributarasesores.com.co')){
                                        if($sw == 0){
                                            $dir_email .= $row_users[0];
                                        }
                                        else{
                                            $dir_email .= ",".$row_users[0];
                                        }
                                    }
                                    $sw += 1;
                                }
                            }
                        }
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
                                                <img src="http://www.edificioe3.com/img/pausas/'.$tipo.'/inicio.png" alt="Pausa Activa" width="100%">
                                            </div>
                                            <div style="margin:auto;text-align:center;">
                                                Ingrese a <a style="margin:auto;text-align:center;text-decoration:none;color:#21939D" href="http://www.edificioe3.com/intranet/">Edificio E3</a> para hacer la Pausa Activa.
                                            </div>
                                            <div style="width:100%">&nbsp;</div>
                                            <div style="margin:auto;text-align:center;font-size:0.8em;">
                                                Si usted no desea recibir mas correos haga click <a style="margin:auto;text-align:center;text-decoration:none;color:#21939D" href="http://www.edificioe3.com/intranet/unsubscribe.html">AQUí</a>.
                                            </div>
                                        </div>
                                    </div>
                                </body>
                            </html>
                        ';
                        // $dir_email = "willyv78@gmail.com";
                        // $para = "willyv78@hotmail.com";
                        $para = "info@rmasb.com";
                        $asunto = utf8_decode("Recordatorio Pausas Activas");
                        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $cabeceras .= 'From: info@rmasb.com' . "\r\n";
                        // $cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                        $cabeceras .= 'Bcc: ' . $dir_email . "\r\n";
                        // Envio de correo electronico a los involucrados en la solicitud

                        // mail($para, $asunto, $plantilla, $cabeceras);

                        // ingresamos el registro en la tabla e3_mail
                        $ins = "INSERT INTO e3_mail (e3_mail_dir, e3_mail_dia, e3_mail_asu, e3_mail_men, e3_mail_tipo, e3_mail_fecha) VALUES ('$dir_email', '$fecha', '$asunto', '$plantilla', '$tipo', NOW())";
                        $res_ins = mysql_query($ins, conexion());
                        if($res_ins){
                            echo $tipo;
                        }
                    }
                    else{echo $tipo;}
                }
                else{echo $tipo;}
            }
            else{echo $tipo;}
        }
        else{echo $tipo;}
    }
}
else{echo $tipo;}
        
?>