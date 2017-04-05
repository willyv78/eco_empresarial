<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
// id de la session del usuario es diferente para cada equipo donde se inicie session por usuario
$session_id = session_id();
// inicializo variable para controlar el id session
$sw = 0;
$email = "";
if(isset($_POST["email"])){
    $email = $_POST["email"];
}

if($email <> ''){
    $emp_id = "";
    $email_envia = "info@rmasb.com";//Desde info
    $asunto = utf8_decode("Nueva Contraseña Edificio E3");
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From: Edificio E3 <'.$email_envia.'>' . "\r\n";
    // valido si existe un usuario registrado con los datos enviados
    $res_user = registroCampo("e3_user u", "u.e3_user_id, u.e3_user_nom, u.e3_user_ape, c.e3_emp_id", "LEFT JOIN e3_cont c USING(e3_user_id) WHERE u.e3_user_email = '$email' AND u.e3_est_id = 1", "GROUP BY u.e3_user_id", "LIMIT 1");
    if($res_user){
        if(mysql_num_rows($res_user) > 0){
            $row_user = mysql_fetch_array($res_user);
            $emp_id = $row_user[3];
            $empl_nom = $row_user[1];
            $empl_ape = $row_user[2];
            // Validamos el tipo de empresa para asignar que correos se envian y que logo se utiliza
            if($emp_id == '1'){
                $logo = "logoTributar";
            }
            elseif($emp_id == '2'){
                $logo = "logoCoveg";
            }
            elseif($emp_id == '3'){
                $logo = "logoRmasB";
            }
            elseif($emp_id == '4'){
                $logo = "logoHache";
            }
            elseif($emp_id == '5'){
                $logo = "logoInversiones";
            }
            // obtenemos una contraseña aleatoria
            $pass = generaPass();
            $sql = "UPDATE e3_user SET e3_user_pass = '$pass' WHERE e3_user_id = '".$row_user[0]."'";
            $res_ins = mysql_query($sql, conexion()); 
            if($res_ins){
                $plantilla = '
                    <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="UTF-8">
                            <title>Nueva Contraseña Edificio E3</title>
                        </head>
                        <body>
                            <div style="width:100%;margin:auto;">
                                <table style="width:80%;margin: 20px auto;border: 1px solid #8E8989;border-radius: 5px;" cellspadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width:30%;padding: 10px 0px 10px 10px;text-align:left;" rowspan="3">
                                                <img src="http://www.edificioe3.com/img/empresas/'.$logo.'.jpg" alt="Logo de la empresa" width="80%">
                                            </th>
                                            <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <th style="width:70%;font-weight: bold;color: #8E8989;">Nueva Contraseña</th>
                                        </tr>
                                        <tr>
                                            <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha solicitud:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.date('Y-m-d H:i').'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Nombre:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$empl_nom.' '.$empl_ape.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Email:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$email.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Contraseña:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;"><h3>'.$pass.'</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Observación:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">Por  seguridad, recuerde cambiar la contraseña generada una vez ingrese a la aplicación.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">Ingrese a <a href="http://www.edificioe3.com/intranet/">Edificio E3</a> para cambiar su clave.</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </body>
                    </html>
                ';
                mail($email, $asunto, $plantilla, $cabeceras);
                echo $row_user[0];
            }           
        }
        else{
            session_destroy();
        }
    }
    else{
        session_destroy();
    }
}
else{
    session_destroy();
}
?>