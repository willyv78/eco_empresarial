<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_solic";
$docu = "";
$datenow = date('Y-m-d H:i');
$anterior = "";
// Email RRHH
$email_rrhh = "lcorredor@tributarasesores.com.co";
$email_rrhh .= ",rrhh@tributarasesores.com.co";
// $email_rrhh = "laura.corredor3@gmail.com";
// Con copia a 
$email_copia = "";
$email_envia = "info@rmasb.com";//Desde info
$asunto = utf8_decode("Respuesta a solicitud");
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Si la accion en borrar el registro hace esto
if(isset($_POST['id_sup'])){
	$sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
	$res_borrar = mysql_query($sql_borrar, conexion());
	if($res_borrar){echo "Registro borrado correctamente";}
}
elseif(isset($_POST['id_ignorar'])){
    $sql_ign = "UPDATE ".$tabla." SET e3_est_id = '5', e3_solic_user = ".$_SESSION['user_id'].", e3_solic_fecha = NOW() WHERE ".$tabla."_id = ".$_POST['id_ignorar']."";
    $res_ign = mysql_query($sql_ign, conexion());
    if($res_ign){
        echo $_POST['id_ignorar'];
    }
}
// Si la accion es editar / actualizar o agregar un registro hache esto
else{
    // validamos el tipo de solicitud
    if($_POST['e3_tsolic_id'] == '1'){$tiposolic = "Permiso";}
    elseif($_POST['e3_tsolic_id'] == '2'){$tiposolic = "Vacaciones";}
    else{$tiposolic = "Certificado";}

    // Validamos el tipo de empresa para asignar que correos se envian y que logo se utiliza
    if($_POST['emp_emp'] == '1'){
        // Email Gerente Tributar Asesores
        $email_gerencia = "ocorredo@tributarasesores.com.co";
        $email_copia = "gerencia@covegauditores.com";
        $logo = "logoTributar";
    }
    elseif($_POST['emp_emp'] == '2'){
        // Email Gerente Coveg Auditores
        $email_gerencia = "gerencia@covegauditores.com";
        $logo = "logoCoveg";
    }
    elseif($_POST['emp_emp'] == '3'){
        // Email Gerente R + B
        $email_gerencia = "feliperamos@rmasb.com";
        $logo = "logoRmasB";
    }
    elseif($_POST['emp_emp'] == '4'){
        // Email Gerente Editores Hache
        $email_gerencia = "paolarodriguez@rmasb.com";
        $email_copia = "feliperamos@rmasb.com";
        $logo = "logoHache";
    }
    elseif($_POST['emp_emp'] == '5'){
        // Email Gerente Coveg Auditores
        $email_gerencia = "gerencia@covegauditores.com";
        $logo = "logoInversiones";
    }
    elseif($_POST['emp_emp'] == '6'){
        // Email Gerente Coveg Auditores
        $email_gerencia = "gerencia@lvauditores.com";
        $logo = "logoLVAuditores";
    }
    // Direccion de email de la persona que realiza la actualizacion de la solicitud
    $email_para = $_POST['e3_user_email'];

    // si el perfil es RRHH
    if($_POST['id_perfil'] == '9'){
        $email_para .= ",".$email_rrhh;//Envia a RRHH y a el empleado
        // si se acepto la solictud o fue creada por RRHH
        if(($_POST['e3_est_id'] == '2') || ($_POST['e3_est_id'] == '3')){
            $mensaje = 'APROBADA por RRHH';
            // si el tipo de permiso es Diferente a licencia o a Incapasidad hace esto
            if(($_POST['e3_solic_rep'] <> '4') || ($_POST['e3_solic_rep'] <> '3')){
                //Envia a Gerente, RRHH y a el empleado
                $email_para .= ",".$email_gerencia;
                // si existe informacion en el email con copia oculta agrega la cabecera
                if($email_copia <> ''){$cabeceras .= 'Bcc: '. $email_copia . "\r\n";}
                $_POST['e3_est_id'] = '2';
            }
            elseif(($_POST['e3_solic_rep'] == '4') || ($_POST['e3_solic_rep'] == '3')){
                //Envia a Gerente, RRHH y a el empleado
                $email_para .= ",".$email_gerencia;
                // si existe informacion en el email con copia oculta agrega la cabecera
                if($email_copia <> ''){$cabeceras .= 'Bcc: '. $email_copia . "\r\n";}
                $_POST['e3_est_id'] = '1';
            }
            
        }
        // si la solicitud es nueva
        // elseif($_POST['e3_est_id'] == '3'){
        //     $mensaje = 'Nueva Solictud por RRHH';
        // }
        // si la solicitud ya estaba aprobada o RRHH la aprobo
        elseif($_POST['e3_est_id'] == '1'){
            $mensaje = 'CREADA y APROBADA por RRHH';
        }
        // si se rechazo la solicitud por RRHH
        else{
            $mensaje = 'RECHAZADA por RRHH';
        }
    }
    // si el perfil es gerente
    elseif($_POST['id_perfil'] == '2'){
        $email_para .= ",".$email_rrhh;//Envia a RRHH
        // si se acepto la solictud por GERENTE y RRHH
        if($_POST['e3_est_id'] == '1'){
            $mensaje = 'ACEPTADA por el GERENTE';
        }
        // si se acepto la solictud por GERENTE
        elseif($_POST['e3_est_id'] == '2'){
            $mensaje = 'ACTUALIZADA por el GERENTE';
        }
        // si se acepto la solictud por GERENTE
        elseif($_POST['e3_est_id'] == '3'){
            $mensaje = 'Nueva Solictud por el GERENTE';
        }
        // si se rechazo la solicitud por RRHH
        else{
            $mensaje = 'RECHAZADA por el GERENTE';
        }
    }
    // si el perfil es empleado
    else{
        // si la solicitud ya esta aprobada
        if($_POST['e3_est_id'] == '1'){
            $mensaje = 'ACTUALIZADA por el EMPLEADO';
        }
        // si la solicitud esta aprobada por RRHH
        elseif($_POST['e3_est_id'] == '2'){
            $mensaje = 'ACTUALIZADA por el EMPLEADO';
        }
        // si la solicitud esta creada o ha sido creada
        elseif($_POST['e3_est_id'] == '3'){
            $mensaje = 'NUEVA Solicitud';
            if($_POST['e3_tsolic_id'] == '4'){
                $_POST['e3_est_id'] = '1';
            }
            $cabeceras .= 'Bcc: '. $email_rrhh . "\r\n";
            // $email_para = $email_rrhh;
        }
        // si esta rechazada
        else{ 
            $mensaje = 'ACTUALIZADA por el EMPLEADO';
        }
    }

    // Tipo Permiso
    if($_POST['e3_solic_tperm'] == '1'){$person = "Personal";}
    else{$person = "Médico";}
    // Reposición
    if($_POST['e3_solic_rep'] == '1'){$repone = "Remunerado";}
    elseif($_POST['e3_solic_rep'] == '2'){$repone = "NO Remunerado";}
    elseif($_POST['e3_solic_rep'] == '3'){$repone = "Licencia";}
    elseif($_POST['e3_solic_rep'] == '4'){$repone = "Incapacidad";}
    else{$repone = "NO especificado";}

    $para1 = $email_para;
    $cabeceras .= 'From: '.$email_envia . "\r\n";

    if(isset($_POST['id_upd'])){
    	$sq = 0;
    	$campos = "";
    	foreach($_POST as $key=>$value){
    		if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'e3_user_ape')&&($key != 'e3_carg_id')&&($key != 'e3_user_nom')&&($key != 'e3_user_doc')&&($key != 'e3_user_fing')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')&&($key != 'e3_solic_obs_rrhh')&&($key != 'e3_solic_obs_jefe')&&($key != 'nom_perfil')&&($key != 'e3_user_email')&&($key != 'id_perfil')&&($key != 'emp_emp')&&($key != 'e3_est_id')){
    			if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
    			else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
    			$sq += 1;
    		}
    	}
    	// Verificamos si el tipo de solicitud es diferente a Certificado, hace esto.
    	if($_POST['e3_tsolic_id'] <> '4'){
    		$nuevorespuesta = '<div class="media-body"><h4 class="media-heading">'.$_POST['nom_perfil'].' - '.$datenow.'</h4><div>'.$_POST['e3_solic_obs_rrhh'].'</div></div>'.$_POST['e3_solic_obs_jefe'];

    		if(isset($_POST['e3_solic_obs_jefe'])){
    			$anterior = str_replace("'", "\'", $_POST['e3_solic_obs_jefe']);
    		}
    		$campos .= ", e3_solic_obs_rrhh='<div class=\'media-body\'><h4 class=\'media-heading\'>".$_POST['nom_perfil']." - $datenow</h4><div>".$_POST['e3_solic_obs_rrhh']."</div></div>".$anterior."'";
    	}
        // si el perfil es RRHH
        if($_POST['id_perfil'] == '9'){
            // si se acepto la solictud por RRHH
            if(($_POST['e3_est_id'] == '2')){
                if(($_POST['e3_solic_rep'] == '4') || ($_POST['e3_solic_rep'] == '3')){
                    $campos .= ", e3_est_id = '1'";
                }
                else{
                    $campos .= ", e3_est_id = '".$_POST['e3_est_id']."'";
                }
            }
            else{
                $campos .= ", e3_est_id = '".$_POST['e3_est_id']."'";
            }
        }
        else{
            $campos .= ", e3_est_id = '".$_POST['e3_est_id']."'";
        }
    	$sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = ".$_POST['id_upd']."";
    	$res_upd = mysql_query($sql_upd, conexion());
    	if($res_upd){
    		// Verificamos si el tipo de solicitud es diferente a Certificado, hace esto.
    		if($_POST['e3_tsolic_id'] <> '4'){
    			$plantilla = '
    				<!DOCTYPE html>
    				<html lang="es">
    				    <head>
    				        <meta charset="UTF-8">
    				        <title>Respuesta a solicitud</title>
    				    </head>
    				    <body>
    				        <div style="width:100%;margin:auto;">
    				            <table style="width:80%;margin: 20px auto;border: 1px solid #8E8989;border-radius: 5px;" cellspadding="0" cellspacing="0">
    				                <thead>
    				                    <tr>
    				                        <th style="width:30%;padding: 10px 0px 10px 10px;text-align:left;" rowspan="4">
    				                            <img src="http://www.edificioe3.com/img/empresas/'.$logo.'.jpg" alt="Logo de la empresa" width="80%">
    				                        </th>
    				                        <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
    				                    </tr>
    				                    <tr>
    				                        <th style="width:70%;font-weight: bold;color: #8E8989;">Solicitud '.$tiposolic.' # '.agregaceros($_POST['id_upd'], "6").'</th>
    				                    </tr>
    				                    <tr>
    				                        <th style="width:70%;font-weight: bold;color: #8E8989;">Estado: '.$mensaje.'</th>
    				                    </tr>
    				                    <tr>
    				                        <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
    				                    </tr>
    				                </thead>
    				                <tbody>
    				                	<tr>
    				                	    <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Nombre:</td>
    				                	    <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_user_nom'].' '.$_POST['e3_user_ape'].'</td>
    				                	</tr>
    				                	<tr>
    				                	    <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha solicitud:</td>
    				                	    <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fsolic'].'</td>
    				                	</tr>';
    				                	// si el tipo de solicitud es diferente a Certificado muestra esto
    				                    if($tiposolic <> "Certificado"){
    					                    $plantilla .= '
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha inicio:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fini'].'</td>
    					                    </tr>
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha Final:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ffin'].'</td>
    					                    </tr>';
    				                	}
    				                    // si el tipo de solicitud es permiso muestra esto
    				                    if($tiposolic == "Permiso"){
    					                    $plantilla .= '
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Tipo Permiso:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$repone.'</td>
    					                    </tr>
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Descripción:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det_rep'].'</td>
    					                    </tr>
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Personal / Médico:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$person.'</td>
    					                    </tr>
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Descripción:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det'].'</td>
    					                    </tr>';
    					                }
    					                // Si el tipo de solicitud es vacaciones muestra esto
    					                if($tiposolic == "Vacaciones"){
    					                	$plantilla .= '
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha Reintegro:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fint'].'</td>
    					                    </tr>
    					                    <tr>
    					                	    <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">No. Días disfrute:</td>
    					                	    <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ndias'].'</td>
    					                	</tr>
    					                	<tr>
    					                	    <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">No. Días pagados:</td>
    					                	    <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ndiasp'].'</td>
    					                	</tr>';
    					                }
    					                // si el tipo de solicitud es certificado
    					                if($tiposolic == "Certificado"){
    					                	$plantilla .= '
    					                	<tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">¿A quien va dirigido?:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det'].'</td>
    					                    </tr>';
    					                }

    									$plantilla .= '
    									<tr>
    				                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Observación:</td>
    				                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_obs'].'</td>
    				                    </tr>';
    				                    // si el tipo de solicitud es diferente a Certificado muestra esto
    				                    if($tiposolic <> "Certificado"){
    					                    $plantilla .= '
    					                    <tr>
    					                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Historial Respuestas:</td>
    					                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$nuevorespuesta.'</td>
    					                    </tr>';
    					                }
    					            $plantilla .= '
    				                </tbody>
    				                <tfoot>
    				                	<tr>
    				                        <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">&nbsp;</td>
    				                    </tr>
    				                	<tr>
    				                        <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">Ingrese a <a href="http://www.edificioe3.com/intranet/">Edificio E3</a> para revisar la solicitud.</td>
    				                    </tr>
    				                </tfoot>
    				            </table>
    				        </div>
    				    </body>
    				</html>
    			';
    			// Envio de correo electronico a los involucrados en la solicitud
    			if(mail($para1, $asunto, $plantilla, $cabeceras)){
                    echo $docu . $sql_upd;
                }
    		}
    	}
    }
    else{
        $nex_id = NextID('hache_eco_empresarial', 'e3_solic');
        $sq = 0;
        $campo = "";
        $valor = "";
        foreach($_POST as $key=>$value){
            if(($key != 'tabla')&&($key != 'id_upd')&&($key != 'e3_user_ape')&&($key != 'e3_carg_id')&&($key != 'e3_user_nom')&&($key != 'e3_user_doc')&&($key != 'e3_user_fing')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'div_panel')&&($key != 'e3_solic_obs_rrhh')&&($key != 'e3_solic_obs_jefe')&&($key != 'nom_perfil')&&($key != 'e3_user_email')&&($key != 'id_perfil')&&($key != 'emp_emp')){
                if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
                else{$campo .= ",".$key;$valor .= ",'".mysql_escape_string($value)."'";}
                $sq += 1;
            }
        }
        $sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
        $res_ins = mysql_query($sql_ins, conexion());
        if($res_ins){
            $plantilla = '
                <!DOCTYPE html>
                <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>Respuesta a solicitud</title>
                    </head>
                    <body>
                        <div style="width:100%;margin:auto;">
                            <table style="width:80%;margin: 20px auto;border: 1px solid #8E8989;border-radius: 5px;" cellspadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width:30%;padding: 10px 0px 10px 10px;text-align:left;" rowspan="4">
                                            <img src="http://www.edificioe3.com/img/empresas/'.$logo.'.jpg" alt="Logo de la empresa" width="80%">
                                        </th>
                                        <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th style="width:70%;font-weight: bold;color: #8E8989;">Solicitud '.$tiposolic.' # '.agregaceros($nex_id, "6").'</th>
                                    </tr>
                                    <tr>
                                        <th style="width:70%;font-weight: bold;color: #8E8989;">Estado: '.$mensaje.'</th>
                                    </tr>
                                    <tr>
                                        <th style="width:70%;font-weight: bold;color: #8E8989;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Nombre:</td>
                                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_user_nom'].' '.$_POST['e3_user_ape'].'</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha solicitud:</td>
                                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fsolic'].'</td>
                                    </tr>';
                                    // si el tipo de solicitud es diferente a Certificado muestra esto
                                    if($tiposolic <> "Certificado"){
                                        $plantilla .= '
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha inicio:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fini'].'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha Final:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ffin'].'</td>
                                        </tr>';
                                    }
                                    // si el tipo de solicitud es permiso muestra esto
                                    if($tiposolic == "Permiso"){
                                        $plantilla .= '
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Tipo Permiso:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$repone.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Descripción:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det_rep'].'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Personal / Médico:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$person.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Descripción:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det'].'</td>
                                        </tr>';
                                    }
                                    // Si el tipo de solicitud es vacaciones muestra esto
                                    if($tiposolic == "Vacaciones"){
                                        $plantilla .= '
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Fecha Reintegro:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_fint'].'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">No. Días disfrute:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ndias'].'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">No. Días pagados:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_ndiasp'].'</td>
                                        </tr>';
                                    }
                                    // si el tipo de solicitud es certificado
                                    if($tiposolic == "Certificado"){
                                        $plantilla .= '
                                        <tr>
                                            <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">¿A quien va dirigido?:</td>
                                            <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_det'].'</td>
                                        </tr>';
                                    }

                                    $plantilla .= '
                                    <tr>
                                        <td style="padding: 10px;vertical-align: top;font-weight: bold;color: #8E8989;">Observación:</td>
                                        <td style="padding: 10px;vertical-align: top;color: #8E8989;">'.$_POST['e3_solic_obs'].'</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 10px;vertical-align: top;color: #8E8989;text-align:center;">Ingrese a <a href="http://www.edificioe3.com/intranet/">Edificio E3</a> para revisar la solicitud.</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </body>
                </html>
            ';            
            // Envio de correo electronico a los involucrados en la solicitud
            if(mail($para1, $asunto, $plantilla, $cabeceras)){
                echo "Registro ingresado correctamente";
            }
        }
    }
}
?>