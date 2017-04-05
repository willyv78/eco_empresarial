<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// Verificamos que las variables de fecha inicial y fecha final se han enviado sino se toman por defecto
$finicial = date('Y-m-01');
$ffinal = date('Y-m-d');
$array_total[] = "";
$array_total_bm[] = "";
$array_total_al[] = "";
$array_total_bt[] = "";
$user_exite = 0;

// Si se envia la fecha inicial hace esto
if(isset($_GET['finicial'])){
    if($_GET['finicial'] <> ''){$finicial = $_GET['finicial'];}
}
// si se envia la fecha final hace esto
if(isset($_GET['ffinal'])){
    if($_GET['ffinal'] <> ''){$ffinal = $_GET['ffinal'];}
}
// Si la fecha final es menor a la fecha inicial hace esto
if($finicial > $ffinal){
    $new_fecha = explode("-", $ffinal);
    $finicial = date('Y-m-d', strtotime($new_fecha[0]."-".$new_fecha[1]."-01"));
}
// variables por defecto
$where_user = "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = u.e3_user_id WHERE u.e3_est_id = '1' AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (card.e3_card_ffin >= '$finicial' OR card.e3_card_ffin = '0000-00-00')";
$where_ing = "WHERE i.e3_ing_type = 'Valid_Access'";

// Verificamos que la variable empresa se ha enviado
if(isset($_GET['emp'])){
    $emp = $_GET['emp'];
    if($emp <> ''){
        // hacemos consulta a la tabla de contratos para traer los id de los empleados que tiene o tuvieron contrato con la empresa especifica para luego obtener los numero de carnet para todos los empleados con los contratos encontrados
        $res_cont = registroCampo("e3_cont c", "card.e3_card_nom", "LEFT JOIN e3_card card ON card.e3_user_id = c.e3_user_id WHERE c.e3_emp_id = '$emp' AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (card.e3_card_ffin >= '$finicial' OR card.e3_card_ffin = '0000-00-00')", "", "ORDER BY card.e3_card_nom ASC");
        // echo "SELECT card.e3_card_nom FROM e3_cont c LEFT JOIN e3_card card ON card.e3_user_id = c.e3_user_id WHERE c.e3_emp_id = '$emp' ORDER BY card.e3_card_nom ASC <br>";
        if($res_cont){
            if(mysql_num_rows($res_cont) > 0){
                $sw = 0;
                while($row_cont = mysql_fetch_array($res_cont)){
                    if($sw == 0){$where_ing .= " AND (";}
                    $where_ing .= "i.e3_ing_card = '".$row_cont[0]."'";
                    $sw ++;
                    if($sw < mysql_num_rows($res_cont)){$where_ing .= " OR ";}
                    else{$where_ing .= ")";}
                }
            }
        }
        $where_user = "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = u.e3_user_id WHERE c.e3_emp_id = '$emp' AND u.e3_est_id = '1' AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (card.e3_card_ffin >= '$finicial' OR card.e3_card_ffin = '0000-00-00')";
        
    }
}
// Verificamos si se envio la variable numero de tarjeta
if(isset($_GET['card'])){
    $id_user = $_GET['card'];
    if($id_user <> ''){
        // hacemos una consulta a la tabla de carnet para saber que numeros de carnet existen para un id de empleado.
        $res_user = registroCampo("e3_card card", "card.e3_card_nom", "WHERE card.e3_user_id = '$id_user'", "", "ORDER BY card.e3_card_ffin ASC");
        if($res_user){
            if(mysql_num_rows($res_user) > 0){
                $sw = 0;
                while($row_user = mysql_fetch_array($res_user)){
                    if($sw == 0){$where_ing .= " AND (";}
                    $where_ing .= "i.e3_ing_card = '".$row_user[0]."'";
                    $sw ++;
                    if($sw < mysql_num_rows($res_user)){$where_ing .= " OR ";}
                    else{$where_ing .= ")";}
                }
            }
            else{$user_exite = 1;}
        }
        $where_user .= " AND u.e3_user_id = '$id_user'";
    }
}

if($user_exite == 0){
    // Consultamos las fecha existentes en el reporte excepto los registros de los vigilantes!= '539'
    $res_report = registroCampo("e3_ing i", "i.e3_ing_date", "$where_ing AND (i.e3_ing_date BETWEEN '$finicial' AND '$ffinal')", "GROUP BY i.e3_ing_date", "ORDER BY i.e3_ing_date ASC");
    // echo "SELECT i.e3_ing_date FROM e3_ing i $where_ing AND (i.e3_ing_date BETWEEN '$finicial' AND '$ffinal') GROUP BY i.e3_ing_date ORDER BY i.e3_ing_date ASC<br>";
    if($res_report){
        if(mysql_num_rows($res_report) > 0){
            while($row_report = mysql_fetch_array($res_report)){
                // obtenemos el numero del dia de la semana
                $dia_sem = date('N', strtotime($row_report[0]));
                $res_card = registroCampo("e3_ing i", "i.e3_ing_card", "$where_ing AND i.e3_ing_date = '".$row_report[0]."'", "GROUP BY i.e3_ing_card", "ORDER BY i.e3_ing_card ASC");
                // echo "SELECT i.e3_ing_card FROM e3_ing i $where_ing AND i.e3_ing_date = '".$row_report[0]."' GROUP BY i.e3_ing_card ORDER BY i.e3_ing_card ASC<br>";
                if($res_card){
                    if(mysql_num_rows($res_card) > 0){
                        while($row_card = mysql_fetch_array($res_card)){
                            // Horas por defecto de entrada y salida a laborar
                            $h_ingreso = '07:00:00';
                            $h_salida = '17:30:00';
                            // puerta que se tomara por defecto para el ingreso de personal
                            $puerta = 1;
                            // mostrar reporte variable por defecto
                            $mostrar = 1;
                            $trabaja = 0;
                            $perm = 0;                     
                            // Inicializo las variables del total y las clases
                            $clase_div = "";
                            $dif_ingreso = strtotime("00:00:00");
                            $dif_salida = strtotime("00:00:00");
                            $dif_total = strtotime("00:00:00");

                            // obtenemos las horas de ingreso y salida a labores.
                            $res_hinghsal = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, c.e3_cont_door, u.e3_user_hora", "LEFT JOIN e3_cont c ON c.e3_user_id = h.e3_user_id LEFT JOIN e3_user u ON u.e3_user_id = h.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = h.e3_user_id WHERE card.e3_card_nom = '".$row_card[0]."' AND h.e3_horario_dia = '".$dia_sem."' AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (h.e3_horario_ffin >= '$finicial' OR h.e3_horario_ffin = '0000-00-00')", "", "");
                            if($res_hinghsal){
                                if(mysql_num_rows($res_hinghsal) > 0){
                                    $row_hinghsal = mysql_fetch_array($res_hinghsal);
                                    // Si tiene hora de ingreso y salida
                                    if($row_hinghsal[0] <> ''){$h_ingreso = $row_hinghsal[0];} 
                                    if($row_hinghsal[1] <> ''){$h_salida = $row_hinghsal[1];}
                                    // Si tiene puerta de ingreso definida
                                    if($row_hinghsal[2] <> ''){$puerta = $row_hinghsal[2];}
                                    // Si tiene mostrar en reporte de ingreso definida
                                    if($row_hinghsal[3] <> ''){$mostrar = $row_hinghsal[3];}
                                    $trabaja = 1;
                                }
                            }

                            // Revisamos si existen dias especiales para la fecha o es festivo
                            $festivo = 0;
                            $dia_esp = "";
                            $res_cal = registroCampo("e3_cal", "DATE_FORMAT( `e3_cal_fini` , '%H:%i' ), DATE_FORMAT( `e3_cal_ffin` , '%H:%i' ), e3_cal_nom, e3_cal_tipo", "WHERE (e3_cal_tipo = '3' OR e3_cal_tipo = '2') AND DATE_FORMAT( `e3_cal_fini` , '%Y-%m-%d' ) = '".$row_report[0]."'", "", "");
                            if($res_cal){
                                if(mysql_num_rows($res_cal) > 0){
                                    while($row_cal = mysql_fetch_array($res_cal)){
                                        if($row_cal[3] == '3'){
                                            $h_ingreso = $row_cal[0];
                                            $h_salida = $row_cal[1];
                                            $dia_esp = $row_cal[2];
                                        }
                                        else{
                                            $festivo = 1;
                                        }
                                    }
                                }
                            }

                            // Consultamos si el empleado tiene permiso.
                            $res_perm = registroCampo("e3_solic s", "s.e3_solic_id, s.e3_solic_fini, s.e3_solic_ffin, s.e3_solic_rep", "LEFT JOIN e3_card card ON card.e3_user_id = s.e3_user_id WHERE card.e3_card_nom = '".$row_card[0]."' AND DATE_FORMAT(s.e3_solic_fini, '%Y-%m-%d') <= '".$row_report[0]."' AND DATE_FORMAT(s.e3_solic_ffin, '%Y-%m-%d')  >= '".$row_report[0]."' AND s.e3_tsolic_id = '1'", "", "");
                            $perm_hora_dif = strtotime("00:00:00");
                            if($res_perm){
                                if(mysql_num_rows($res_perm) > 0){
                                    $row_perm = mysql_fetch_array($res_perm);
                                    $perm = 1;
                                    $perm_id = $row_perm[0];
                                    $perm_fini = $row_perm[1];
                                    $perm_ffin = $row_perm[2];
                                    $perm_rep = $row_perm[3];
                                    $perm_exp_fini = explode(" ", $perm_fini);
                                    $perm_exp_ffin = explode(" ", $perm_ffin);
                                    $perm_hora_ini = $perm_exp_fini[1];
                                    $perm_hora_fin = $perm_exp_ffin[1];
                                    $perm_hora_dif = restaHours($perm_hora_ini, $perm_hora_fin);
                                }
                            }

                            // obtenemos el ingreso menor y mayor de la fecha, carnet , puerta del piso y asensor.
                            $res_horasminmax = registroCampo("e3_ing i", "MIN(i.e3_ing_hour) AS mini, MAX(i.e3_ing_hour) AS maxi", "LEFT JOIN e3_card card ON card.e3_card_nom = i.e3_ing_card WHERE i.e3_ing_date = '".$row_report[0]."' AND i.e3_ing_card = '".$row_card[0]."' AND (i.e3_ing_ndoor = '".$puerta."' OR i.e3_ing_ndoor = '10') AND (card.e3_card_ffin >= '".$row_report[0]."' OR card.e3_card_ffin = '0000-00-00')", "", "");
                            if($res_horasminmax){
                                if(mysql_num_rows($res_horasminmax) > 0){
                                    $row_horasminmax = mysql_fetch_array($res_horasminmax);
                                    if(($row_horasminmax[0] <> '')&&($row_horasminmax[1] <> '')){
                                        $hora_ingreso = $row_horasminmax[0];
                                        $hora_salida = $row_horasminmax[1];
                                        // Si NO es festivo hace esto
                                        if($festivo == 0){
                                            // Si el titulo del evento es Emergencia no debe sumar ni restar
                                            if($dia_esp == 'Emergencia'){
                                                $hora_ingreso = $h_ingreso;
                                                $hora_salida = $h_salida;
                                            }
                                            if($trabaja == 0){
                                                if($hora_salida < $hora_ingreso){
                                                    $dif_total = restaHours($hora_salida, $hora_ingreso);
                                                    $clase_div = "btn btn-success";
                                                    $debe_total = "+";
                                                }
                                                else{
                                                    $dif_total = restaHours($hora_ingreso, $hora_salida);
                                                    $clase_div = "btn btn-success";
                                                    $debe_total = "+";
                                                }
                                            }
                                            else{
                                                // Comparo las dos horas de entrada la que debe entrar y la que entro
                                                if($h_ingreso < $hora_ingreso){
                                                    $dif_ingreso = restaHours($h_ingreso, $hora_ingreso);
                                                    $debeing = 1;// Me debe
                                                }
                                                elseif($h_ingreso > $hora_ingreso){
                                                    $dif_ingreso = restaHours($hora_ingreso, $h_ingreso);
                                                    $debeing = 2;// Le debo
                                                }
                                                else{
                                                    $dif_ingreso = strtotime("00:00:00");
                                                    $debeing = 2;// Le debo
                                                }
                                                // Comparo las dos horas de salida la que debe salir y la que salio
                                                if($h_salida < $hora_salida){
                                                    $dif_salida = restaHours($h_salida, $hora_salida);
                                                    $debesalida = 2;// Le debo
                                                }
                                                elseif($h_salida > $hora_salida){
                                                    $dif_salida = restaHours($hora_salida, $h_salida);
                                                    $debesalida = 1;// Me debe
                                                }
                                                else{
                                                    $dif_salida = strtotime("00:00:00");
                                                    $debesalida = 2;// le debo
                                                }
                                                $dif_entra_date = date('H:i:s', $dif_ingreso);
                                                $dif_fuera_date = date('H:i:s', $dif_salida);
                                                if(($debeing == 1)&&($debesalida == 1)){
                                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                                    $clase_div = "btn btn-danger";
                                                }
                                                elseif(($debeing == 2)&&($debesalida == 2)){
                                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                                    $clase_div = "btn btn-success";
                                                }
                                                elseif(($debeing == 1)&&($debesalida == 2)){
                                                    if($dif_entra_date < $dif_fuera_date){
                                                        $dif_total = restaHours($dif_entra_date, $dif_fuera_date);
                                                        $clase_div = "btn btn-success";
                                                    }
                                                    elseif($dif_entra_date > $dif_fuera_date){
                                                        $dif_total = restaHours($dif_fuera_date, $dif_entra_date);
                                                        $clase_div = "btn btn-danger";
                                                    }
                                                    else{
                                                        $dif_total = strtotime("00:00:00");
                                                        $clase_div = "btn btn-success";
                                                    }
                                                }
                                                else{
                                                    if($dif_entra_date < $dif_fuera_date){
                                                        $dif_total = restaHours($dif_entra_date, $dif_fuera_date);
                                                        $clase_div = "btn btn-danger";
                                                    }
                                                    elseif($dif_entra_date > $dif_fuera_date){
                                                        $dif_total = restaHours($dif_fuera_date, $dif_entra_date);
                                                        $clase_div = "btn btn-success";
                                                    }
                                                    else{
                                                        $dif_total = strtotime("00:00:00");
                                                        $clase_div = "btn btn-success";
                                                    }
                                                }
                                                // Verifico si tiene permiso y es descontable y la hora de entrada es igual a la del permiso, cambio la hora del reporte
                                                if($perm > 0){
                                                    if($perm_rep == 2){
                                                        if(($perm_hora_ini <= $h_ingreso) || ($perm_hora_fin >= $h_salida)){
                                                            $perm_hora_dif = date('H:i:s', $perm_hora_dif);
                                                            $dif_total = date('H:i:s', $dif_total);
                                                            // echo $perm_hora_dif." - ".$dif_total;
                                                            if($clase_div == "btn btn-success"){
                                                                $dif_total = sumarHours($perm_hora_dif, $dif_total);
                                                            }
                                                            else{
                                                                if($perm_hora_dif > $dif_total){
                                                                    $dif_total = restaHours($dif_total, $perm_hora_dif);
                                                                    $clase_div = "btn btn-success";
                                                                }
                                                                else{
                                                                    $dif_total = restaHours($perm_hora_dif, $dif_total);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    elseif(($perm_rep == 3) || ($perm_rep == 4)){
                                                        $dif_total = strtotime("00:00:00");
                                                    }
                                                }
                                            }
                                        }
                                        // Si SI es festivo hace esto
                                        else{
                                            if($hora_salida < $hora_ingreso){
                                                $dif_total = restaHours($hora_salida, $hora_ingreso);
                                                $clase_div = "btn btn-success";
                                                $debe_total = "+";
                                            }
                                            else{
                                                $dif_total = restaHours($hora_ingreso, $hora_salida);
                                                $clase_div = "btn btn-success";
                                                $debe_total = "+";
                                            }
                                        }
                                    }
                                }
                                // si es deuda resta sino suma
                                $nom_array_mas = $row_card[0].'_sum';
                                $nom_array_res = $row_card[0].'_res';
                                // sino existe el array lo inicializamos
                                if(!isset($array_total[$nom_array_mas])){$array_total[$nom_array_mas] = strtotime("00:00:00");}
                                if(!isset($array_total[$nom_array_res])){$array_total[$nom_array_res] = strtotime("00:00:00");}
                                $acumula_sum = date('H:i:s', $array_total[$nom_array_mas]);
                                $acumula_res = date('H:i:s', $array_total[$nom_array_res]);
                                $sum_acumula = date('H:i:s', $dif_total);
                                if($clase_div == "btn btn-success"){
                                    $array_total[$nom_array_mas] = sumarHours($acumula_sum, $sum_acumula);
                                }
                                else{
                                    $array_total[$nom_array_res] = sumarHours($acumula_res, $sum_acumula);
                                }
                            }

                            // Codigo para validar informacion
                            // if($row_card[0] == '505'){
                            //     // echo "Hora de salida default = ".$h_lunch_sal." Hora entrada default = ".$h_lunch_ent."<br />";
                            //     echo "Fecha = ".$row_report[0]." Hora de entrada real = ".$hora_ingreso." Hora salida real = ".$hora_salida." diferencia = ".$sum_acumula." clase = ".$clase_div." total mas = ".$array_total[$nom_array_mas]." total menos = ".$array_total[$nom_array_res]."<br />";
                            // }

                            // si debe trabajar hace esto  
                            if($trabaja > 0){
                                // Horas por defecto de salida y entrada a almorzar
                                $h_lunch_sal = '12:45:00';
                                $h_lunch_ent = '14:15:00';
                                // Horas por defecto de salida y entrada a break mañana
                                $h_breakm_sal = '9:15:00';
                                $h_breakm_ent = '10:15:00';
                                $dif_total_l = "";
                                // Horas por defecto de salida y entrada a break tarde
                                $h_breakt_sal = '15:15:00';
                                $h_breakt_ent = '16:15:00';
                                // obtenemos las horas de salida e ingreso a break y almuerzo.
                                $res_salent = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, h.e3_horario_dia, c.e3_cont_door", "LEFT JOIN e3_cont c ON c.e3_user_id = h.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = h.e3_user_id WHERE card.e3_card_nom = '".$row_card[0]."' AND (h.e3_horario_dia = 8 OR h.e3_horario_dia = 9 OR h.e3_horario_dia = 10) AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (h.e3_horario_ffin >= '$finicial' OR h.e3_horario_ffin = '0000-00-00') AND (card.e3_card_ffin >= '$finicial' OR card.e3_card_ffin = '0000-00-00')", "", "");
                                if($res_salent){
                                    if(mysql_num_rows($res_salent) > 0){
                                        while($row_salent = mysql_fetch_array($res_salent)){
                                            if($row_salent[3] <> ''){$puerta = $row_salent[3];}
                                            // Si el dia del horario es 8 break mañana
                                            if($row_salent[2] == '8'){
                                                // si debe trabajar hace esto
                                                if($trabaja > 0){
                                                    // si NO es festivo hace esto
                                                    if($festivo == 0){
                                                        // Si tiene hora de entrada
                                                        if($row_salent[0] <> ''){
                                                            $h_breakm_sal = date('H:i:s', strtotime('-10 minute', strtotime($row_salent[0])));
                                                            $h_real_sal_bm = $row_salent[0];
                                                        }
                                                        // Si NO tiene hora de entrada
                                                        else{$h_real_sal_bm = $h_breakm_sal;}
                                                        // Si tiene hora de salida
                                                        if($row_salent[1] <> ''){
                                                            $h_breakm_ent = date('H:i:s', strtotime('+10 minute', strtotime($row_salent[1])));
                                                            $h_real_ent_bm = $row_salent[1];
                                                        }
                                                        // si NO tiene hora de salida
                                                        else{$h_real_ent_bm = $h_breakm_ent;}
                                                        $clase_div_bm = "";
                                                        $dif_total_bm = strtotime("00:00:00");

                                                        // Obtenemos la menor salida de la puerta del piso entre un rango de horas para el break de la mañana
                                                        $res_hbmmin = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakm_sal."' AND '".$h_breakm_ent."')", "", "");
                                                        if($res_hbmmin){
                                                            if(mysql_num_rows($res_hbmmin) > 0){
                                                                $row_hbmmin = mysql_fetch_array($res_hbmmin);
                                                                // si hay un dato en la hora de salida al break de la mañana
                                                                if($row_hbmmin[0] <> ''){$hora_sal_bm = $row_hbmmin[0];}
                                                                // si NO hay un dato coloca la hora por default
                                                                else{$hora_sal_bm = $h_breakm_sal;}
                                                            }
                                                            // si NO hay un dato coloca la hora por default
                                                            else{$hora_sal_bm = $h_breakm_sal;}
                                                        }
                                                        // si NO hay un dato o hay un error en la consulta coloca la hora por default
                                                        else{$hora_sal_bm = $h_real_sal_bm;}
                                                        // Obtenemos el mayor ingreso de la puerta del piso entre un rango de horas para el break de la mañana
                                                        $res_hbmmax = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakm_sal."' AND '".$h_breakm_ent."')", "", "");
                                                        if($res_hbmmax){
                                                            if(mysql_num_rows($res_hbmmax) > 0){
                                                                $row_hbmmax = mysql_fetch_array($res_hbmmax);
                                                                // Si hay dato de hora de entrada del break de la mañana
                                                                if($row_hbmmax[0] <> ''){$hora_ent_bm = $row_hbmmax[0];}
                                                                // si NO hay dato de entrada de break mañana coloca la hora por defauld
                                                                else{$hora_ent_bm = $h_breakm_ent;}
                                                            }
                                                            // si NO hay un dato coloca la hora por default
                                                            else{$hora_ent_bm = $h_breakm_ent;}
                                                        }
                                                        // si NO hay un dato o hay un error en la consulta coloca la hora por default
                                                        else{$hora_ent_bm = $h_real_ent_bm;}
                                                        // si las dos horas entrada y salida son iguales
                                                        if($hora_sal_bm == $hora_ent_bm){
                                                            $hora_sal_bm = $h_breakm_sal;
                                                            $hora_ent_bm = $h_breakm_ent;
                                                        }
                                                        // obtenemos la cantidad de minutos diferencia si es mayor a 10 debe.
                                                        if($hora_ent_bm < $hora_sal_bm){
                                                            $minutos_bm = timestamp_a_minutos((strtotime($hora_sal_bm) - strtotime($hora_ent_bm)) + strtotime("00:00:00"));
                                                        }
                                                        else{
                                                            $minutos_bm = timestamp_a_minutos((strtotime($hora_ent_bm) - strtotime($hora_sal_bm)) + strtotime("00:00:00"));
                                                        }
                                                        if($minutos_bm > 11){
                                                            $dif_total_bm = $minutos_bm - 11;
                                                            $clase_div_bm = "btn btn-danger";// Me debe
                                                        }
                                                        else{
                                                            // if($minutos_bm == 0){$minutos_bm = 10;}
                                                            $dif_total_bm =  11 - $minutos_bm;
                                                            $clase_div_bm = "btn btn-success";// Le debo
                                                        }
                                                    }
                                                    else{
                                                        $dif_total_bm =  0;
                                                        $clase_div_bm = "btn btn-success";// Le debo
                                                    }
                                                }
                                                // si no debe trabajar no suma ni hace operaciones
                                                else{
                                                    $dif_total_bm =  0;
                                                    $clase_div_bm = "btn btn-success";// Le debo
                                                }
                                                // si es deuda res sino sum
                                                $nom_array_mas_bm = $row_card[0].'_sum';
                                                $nom_array_res_bm = $row_card[0].'_res';
                                                if(!isset($array_total_bm[$nom_array_mas_bm])){$array_total_bm[$nom_array_mas_bm] = 0;}
                                                if(!isset($array_total_bm[$nom_array_res_bm])){$array_total_bm[$nom_array_res_bm] = 0;}
                                                $acumula_sum_bm = $array_total_bm[$nom_array_mas_bm];
                                                $acumula_res_bm = $array_total_bm[$nom_array_res_bm];
                                                $sum_acumula_bm = $dif_total_bm;
                                                if($clase_div_bm == "btn btn-success"){
                                                    $array_total_bm[$nom_array_mas_bm] = $acumula_sum_bm + $sum_acumula_bm;
                                                }
                                                else{
                                                    $array_total_bm[$nom_array_res_bm] = $acumula_res_bm + $sum_acumula_bm;
                                                }
                                            }
                                            // Si el dia del horario es 9 Almuerzo
                                            elseif($row_salent[2] == '9'){
                                                // si debe trabajar hace esto
                                                if($trabaja > 0){
                                                    // si NO es festivo hace esto
                                                    if($festivo == 0){
                                                        // Si tiene hora de ingreso y salida
                                                        if($row_salent[0] <> ''){
                                                            $h_lunch_sal = date('H:i:s', strtotime('-15 minute', strtotime($row_salent[0])));
                                                            $h_real_sal_lunch = $row_salent[0];
                                                        }
                                                        else{$h_real_sal_lunch = $h_lunch_sal;}
                                                        if($row_salent[1] <> ''){
                                                            $h_lunch_ent = date('H:i:s', strtotime('+15 minute', strtotime($row_salent[1])));
                                                            $h_real_ent_lunch = $row_salent[1];
                                                        }
                                                        else{$h_real_ent_lunch = $h_lunch_ent;}
                                                        // echo "Hora de salida default = ".$h_lunch_sal." Hora entrada default = ".$h_lunch_ent."<br />";
                                                        $clase_div_l = "";
                                                        $dif_ingreso_l = strtotime("00:00:00");
                                                        $dif_salida_l = strtotime("00:00:00");
                                                        $dif_total_l = strtotime("00:00:00");
                                                        // Obtenemos el menor salida de la puerta del piso entre un rengo de horas para la hora de almuerzo
                                                        $res_hlunchmin = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_lunch_sal."' AND '".$h_lunch_ent."')", "", "");
                                                        if($res_hlunchmin){
                                                            if(mysql_num_rows($res_hlunchmin) > 0){
                                                                $row_hlunchmin = mysql_fetch_array($res_hlunchmin);
                                                                if($row_hlunchmin[0] <> ''){$hora_sal_lunch = $row_hlunchmin[0];}else{$hora_sal_lunch = $h_lunch_sal;}
                                                            }
                                                            else{$hora_sal_lunch = $h_lunch_sal;}
                                                        }
                                                        else{$hora_sal_lunch = $h_lunch_sal;}
                                                        // Obtenemos la mayor entrada de la puerta del piso entre un rengo de horas para la hora de almuerzo
                                                        $res_hlunchmax = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_lunch_sal."' AND '".$h_lunch_ent."')", "", "");
                                                        if($res_hlunchmax){
                                                            if(mysql_num_rows($res_hlunchmax) > 0){
                                                                $row_hlunchmax = mysql_fetch_array($res_hlunchmax);
                                                                if($row_hlunchmax[0] <> ''){$hora_ent_lunch = $row_hlunchmax[0];}else{$hora_ent_lunch = $h_lunch_ent;}
                                                            }
                                                            else{$hora_ent_lunch = $h_lunch_ent;}
                                                        }
                                                        else{$hora_ent_lunch = $h_lunch_ent;}
                                                        // obtenemos la cantidad de minutos diferencia si es mayor a 60 debe.
                                                        if($hora_ent_lunch < $hora_sal_lunch){
                                                            $minutos_lunch = timestamp_a_minutos((strtotime($hora_sal_lunch) - strtotime($hora_ent_lunch)) + strtotime("00:00:00"));
                                                        }
                                                        else{
                                                            $minutos_lunch = timestamp_a_minutos((strtotime($hora_ent_lunch) - strtotime($hora_sal_lunch)) + strtotime("00:00:00"));
                                                        }
                                                        if($minutos_lunch > 60){
                                                            $dif_total_l = $minutos_lunch - 60;
                                                            $clase_div_l = "btn btn-danger";// Me debe
                                                        }
                                                        else{
                                                            // if($minutos_lunch == 0){$minutos_lunch = 60;}
                                                            $dif_total_l =  60 - $minutos_lunch;
                                                            $clase_div_l = "btn btn-success";// Le debo
                                                        }
                                                    }
                                                    else{
                                                        $dif_total_l =  0;
                                                        $clase_div_l = "btn btn-success";// Le debo
                                                    }
                                                }
                                                // si no debe trabajar no suma ni hace operaciones
                                                else{
                                                    $dif_total_l =  0;
                                                    $clase_div_l = "btn btn-success";// Le debo
                                                }
                                                // si es deuda res sino sum
                                                $nom_array_mas_l = $row_card[0].'_sum';
                                                $nom_array_res_l = $row_card[0].'_res';

                                                if(!isset($array_total_al[$nom_array_mas_l])){$array_total_al[$nom_array_mas_l] = 0;}
                                                if(!isset($array_total_al[$nom_array_res_l])){$array_total_al[$nom_array_res_l] = 0;}

                                                $acumula_sum_l = $array_total_al[$nom_array_mas_l];
                                                $acumula_res_l = $array_total_al[$nom_array_res_l];
                                                $sum_acumula_l = $dif_total_l;
                                                if($clase_div_l == "btn btn-success"){
                                                    $array_total_al[$nom_array_mas_l] = $acumula_sum_l + $sum_acumula_l;
                                                }
                                                else{
                                                    $array_total_al[$nom_array_res_l] = $acumula_res_l + $sum_acumula_l;
                                                }
                                            }
                                            // Si el dia del horario 10 break tarde
                                            elseif($row_salent[2] == '10'){
                                                // si debe trabajar hace esto
                                                if($trabaja > 0){
                                                    // si NO es festivo hace esto
                                                    if($festivo == 0){
                                                        // Si tiene hora de ingreso y salida
                                                        if($row_salent[0] <> ''){
                                                            $h_breakt_sal = date('H:i:s', strtotime('-10 minute', strtotime($row_salent[0])));
                                                            $h_real_sal_bt = $row_salent[0];
                                                        }
                                                        else{$h_real_sal_bt = $h_breakt_sal;}
                                                        if($row_salent[1] <> ''){
                                                            $h_breakt_ent = date('H:i:s', strtotime('+10 minute', strtotime($row_salent[1])));
                                                            $h_real_ent_bt = $row_salent[1];
                                                        }
                                                        else{$h_real_ent_bt = $h_breakt_ent;}
                                                        // echo "Hora de salida default = ".$h_breakt_sal." Hora entrada default = ".$h_breakt_ent."<br />";
                                                        $clase_div_bt = "";
                                                        $dif_total_bt = strtotime("00:00:00");
                                                        // Obtenemos la menor salida de la puerta del piso entre un rango de horas para la hora de break en la tarde
                                                        $res_hbmmint = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakt_sal."' AND '".$h_breakt_ent."')", "", "");
                                                        if($res_hbmmint){
                                                            if(mysql_num_rows($res_hbmmint) > 0){
                                                                $row_hbmmint = mysql_fetch_array($res_hbmmint);
                                                                if($row_hbmmint[0] <> ''){$hora_sal_bt = $row_hbmmint[0];}
                                                                else{$hora_sal_bt = $h_breakt_sal;}
                                                            }
                                                            else{$hora_sal_bt = $h_breakt_sal;}
                                                        }
                                                        else{$hora_sal_bt = $h_real_sal_bt;}
                                                        // Obtenemos el mayor ingreso de la puerta del piso entre un rango de horas para la hora de break en la tarde
                                                        $res_hbmmaxt = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakt_sal."' AND '".$h_breakt_ent."')", "", "");
                                                        if($res_hbmmaxt){
                                                            if(mysql_num_rows($res_hbmmaxt) > 0){
                                                                $row_hbmmaxt = mysql_fetch_array($res_hbmmaxt);
                                                                if($row_hbmmaxt[0] <> ''){$hora_ent_bt = $row_hbmmaxt[0];}else{$hora_ent_bt = $h_breakt_ent;}
                                                            }
                                                            else{$hora_ent_bt = $h_breakt_ent;}
                                                        }
                                                        else{$hora_ent_bt = $h_real_ent_bt;}
                                                        // si las dos horas entrada y salida son iguales
                                                        if($hora_sal_bt == $hora_ent_bt){
                                                            $hora_sal_bt = $h_breakt_sal;
                                                            $hora_ent_bt = $h_breakt_ent;
                                                        }
                                                        // obtenemos la cantidad de minutos diferencia si es mayor a 60 debe.
                                                        if($hora_ent_bt < $hora_sal_bt){
                                                            $minutos_bt = timestamp_a_minutos((strtotime($hora_sal_bt) - strtotime($hora_ent_bt)) + strtotime("00:00:00"));
                                                        }
                                                        else{
                                                            $minutos_bt = timestamp_a_minutos((strtotime($hora_ent_bt) - strtotime($hora_sal_bt)) + strtotime("00:00:00"));
                                                        }
                                                        if($minutos_bt > 11){
                                                            $dif_total_bt = $minutos_bt - 11;
                                                            $clase_div_bt = "btn btn-danger";// Me debe
                                                        }
                                                        else{
                                                            // if($minutos_bt == 0){$minutos_bt = 10;}
                                                            $dif_total_bt =  11 - $minutos_bt;
                                                            $clase_div_bt = "btn btn-success";// Le debo                      
                                                        }
                                                    }
                                                    else{
                                                        $dif_total_bt =  0;
                                                        $clase_div_bt = "btn btn-success";// Le debo
                                                    }
                                                }
                                                // si no debe trabajar no suma ni hace operaciones
                                                else{
                                                    $dif_total_bt =  0;
                                                    $clase_div_bt = "btn btn-success";// Le debo
                                                }
                                                // si es deuda res sino sum
                                                $nom_array_mas_bt = $row_card[0].'_sum';
                                                $nom_array_res_bt = $row_card[0].'_res';
                                                if(!isset($array_total_bt[$nom_array_mas_bt])){$array_total_bt[$nom_array_mas_bt] = 0;}
                                                if(!isset($array_total_bt[$nom_array_res_bt])){$array_total_bt[$nom_array_res_bt] = 0;}
                                                $acumula_sum_bt = $array_total_bt[$nom_array_mas_bt];
                                                $acumula_res_bt = $array_total_bt[$nom_array_res_bt];
                                                $sum_acumula_bt = $dif_total_bt;
                                                if($clase_div_bt == "btn btn-success"){
                                                    $array_total_bt[$nom_array_mas_bt] = $acumula_sum_bt + $sum_acumula_bt;
                                                }
                                                else{
                                                    $array_total_bt[$nom_array_res_bt] = $acumula_res_bt + $sum_acumula_bt;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


$html = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">';
$ver_rep = 1;
// Consultamos los empleados registrados
$res_user = registroCampo("e3_user u", "c.e3_emp_id, c.e3_carg_id, u.e3_user_img, u.e3_user_nom, u.e3_user_ape, card.e3_card_nom, u.e3_user_hora", "$where_user", "", "ORDER BY u.e3_user_ape ASC");
// echo "SELECT c.e3_emp_id, c.e3_carg_id, u.e3_user_img, u.e3_user_nom, u.e3_user_ape, card.e3_card_nom, u.e3_user_hora FROM e3_user u $where_user ORDER BY u.e3_user_ape ASC";
if($res_user){
    if(mysql_num_rows($res_user) > 0){
        while($row_user = mysql_fetch_array($res_user)){
            $ver_rep = $row_user[6];
            $new_array_mas = $row_user[5].'_sum';
            $new_array_res = $row_user[5].'_res';
            $total_time_debe_mas = strtotime("00:00:00");
            $total_time_debe_res = strtotime("00:00:00");
            $clase_div = "btn btn-success";
            $total_time_debe = 0;

            $total_time_debe_mas_l = strtotime("00:00:00");
            $total_time_debe_res_l = strtotime("00:00:00");
            $clase_div_l = "btn btn-success";
            $total_time_debe_l = 0;

            $total_time_debe_mas_bm = strtotime("00:00:00");
            $total_time_debe_res_bm = strtotime("00:00:00");
            $clase_div_bm = "btn btn-success";
            $total_time_debe_bm = 0;

            $total_time_debe_mas_bt = strtotime("00:00:00");
            $total_time_debe_res_bt = strtotime("00:00:00");
            $clase_div_bt= "btn btn-success";
            $total_time_debe_bt = 0;

            $total_time_debe_bmt = strtotime("00:00:00");
            $clase_div_bmt = "btn btn-success";

            // inicio calculo total de tiempo a recuperar o a cobrar
            if((isset($array_total[$new_array_mas]))&&(isset($array_total[$new_array_res]))){
                $total_time_debe_mas = $array_total[$new_array_mas];
                $total_time_debe_res = $array_total[$new_array_res];
                if($total_time_debe_res < $total_time_debe_mas){
                    $dif_total_debe = (($total_time_debe_mas - $total_time_debe_res) + strtotime("00:00:00"));
                    $clase_div = "btn btn-success";
                }
                else{
                    $dif_total_debe = (($total_time_debe_res - $total_time_debe_mas) + strtotime("00:00:00"));
                    $clase_div = "btn btn-danger";
                }
                $total_time_debe = timestamp_a_minutos($dif_total_debe);
                // fin calculo de tiempo total entradas

                // total de horas para almuerzos
                if(!isset($array_total_al[$new_array_mas])){$array_total_al[$new_array_mas] = 0;}
                if(!isset($array_total_al[$new_array_res])){$array_total_al[$new_array_res] = 0;}
                $total_time_debe_mas_l = $array_total_al[$new_array_mas];
                $total_time_debe_res_l = $array_total_al[$new_array_res];
                if($total_time_debe_res_l < $total_time_debe_mas_l){
                    $dif_total_debe_l = ($total_time_debe_mas_l - $total_time_debe_res_l);
                    $clase_div_l = "btn btn-success";
                }
                else{
                    $dif_total_debe_l = ($total_time_debe_res_l - $total_time_debe_mas_l);
                    $clase_div_l = "btn btn-danger";
                }
                $total_time_debe_l = $dif_total_debe_l;
                // fin calculo de tiempo total almuerzos

                // if($row_rep[0] == '559'){
                //     echo "Total mas almuerzo = ".$total_time_debe_mas_l." clase = ".$clase_div_l."<br />";
                //     echo "Total menos almuerzo = ".$total_time_debe_res_l." clase = ".$clase_div_bt."<br />";
                // }

                // total de horas para break en la mañana
                if(!isset($array_total_bm[$new_array_mas])){$array_total_bm[$new_array_mas] = 0;}
                if(!isset($array_total_bm[$new_array_res])){$array_total_bm[$new_array_res] = 0;}
                $total_time_debe_mas_bm = $array_total_bm[$new_array_mas];
                $total_time_debe_res_bm = $array_total_bm[$new_array_res];
                if($total_time_debe_res_bm < $total_time_debe_mas_bm){
                    $dif_total_debe_bm = ($total_time_debe_mas_bm - $total_time_debe_res_bm);
                    $clase_div_bm = "btn btn-success";
                }
                else{
                    $dif_total_debe_bm = ($total_time_debe_res_bm - $total_time_debe_mas_bm);
                    $clase_div_bm = "btn btn-danger";
                }
                // total de horas para break en la tarde
                if(!isset($array_total_bt[$new_array_mas])){$array_total_bt[$new_array_mas] = 0;}
                if(!isset($array_total_bt[$new_array_res])){$array_total_bt[$new_array_res] = 0;}
                $total_time_debe_mas_bt = $array_total_bt[$new_array_mas];
                $total_time_debe_res_bt = $array_total_bt[$new_array_res];
                if($total_time_debe_res_bt < $total_time_debe_mas_bt){
                    $dif_total_debe_bt = ($total_time_debe_mas_bt - $total_time_debe_res_bt);
                    $clase_div_bt = "btn btn-success";
                }
                else{
                    $dif_total_debe_bt = ($total_time_debe_res_bt - $total_time_debe_mas_bt);
                    $clase_div_bt = "btn btn-danger";
                }
                
                // validamos si son iguales las dos clases para sumarlas o restarlas
                if($clase_div_bt == $clase_div_bm){
                    $total_time_debe_bmt = $dif_total_debe_bt + $dif_total_debe_bm;
                    $clase_div_bmt = $clase_div_bt;  
                }
                else{
                    if($dif_total_debe_bm < $dif_total_debe_bt){
                        $total_time_debe_bmt = $dif_total_debe_bt - $dif_total_debe_bm;
                        $clase_div_bmt = $clase_div_bt;
                    }
                    else{
                        $total_time_debe_bmt = $dif_total_debe_bm - $dif_total_debe_bt;
                        $clase_div_bmt = $clase_div_bm;
                    }
                }
                // si el resultado final es igual a 0 hace esto
                if($total_time_debe_bmt == 0){
                    $clase_div_bmt = "btn btn-success";
                }
                // fin calculo de tiempo total break

                if($ver_rep > 1){
                    $total_entradas = "OK";
                    $total_almuerzos = "OK";
                    $total_breaks = "OK";
                    $clase_div = "btn btn-success";
                    $clase_div_l = "btn btn-success";
                    $clase_div_bmt = "btn btn-success";
                }
                else{
                    $total_entradas = $total_time_debe."m";
                    $total_almuerzos = $total_time_debe_l."m";
                    $total_breaks = $total_time_debe_bmt."m";
                }

                // Armamos los divs de salida de información
                $html .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-left cam_ing">';
                    if($row_user[2] <> ''){$src = $row_user[2];}
                    else{$src = "../img/fotos/man.jpeg";}
                    $html .= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 center-block img-thumbnail' style='background-image:url(\"".$src."\"); background-size:contain; background-repeat:no-repeat; background-position:center; height:100px; border-radius:5px;'></div>";

                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_user[4])."</div>";
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_user[3])."</div>";
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.nombreCampo($row_user[0], "e3_emp").'</div>';
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.nombreCampo($row_user[1], "e3_carg").'</div>';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <div class="text-left '.$clase_div.' id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_ent">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">'.$total_entradas.'</div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="bottom:0px;"><img src="../img/entrada.png" style="padding:0px; width:100%;"/></div>
                                </div>
                                <div class="text-center '.$clase_div_l.' id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_alm">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">'.$total_almuerzos.'</div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><img src="../img/almuerzo.png" style="padding:0px; width:100%;"/></div>
                                </div>
                                <div class="text-right '.$clase_div_bmt.' id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_bre">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">'.$total_breaks.'</div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><img src="../img/breake.png" style="padding:0px; width:100%;"/></div>
                                </div>
                    </div>';
                $html .= "</div>";
                $html .= '<div id="detalle_ing_'.$row_user[5].'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left hidden detalle_ingreso"></div>';
            }
            else{
                // Armamos los divs de salida de información
                $html .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-left cam_ing">';
                    if($row_user[2] <> ''){$src = $row_user[2];}
                    else{$src = "../img/fotos/man.jpeg";}
                    $html .= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 center-block img-thumbnail' style='background-image:url(\"".$src."\"); background-size:contain; background-repeat:no-repeat; background-position:center; height:100px; border-radius:5px;'></div>";

                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_user[4])."</div>";
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_user[3])."</div>";
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.nombreCampo($row_user[0], "e3_emp").'</div>';
                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.nombreCampo($row_user[1], "e3_carg").'</div>';
                    $html .= '
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <div class="text-left btn btn-warning id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_ent">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">N/A</div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="bottom:0px;"><img src="../img/entrada.png" style="padding:0px; width:100%;"/></div>
                        </div>
                        <div class="text-center btn btn-warning id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_alm">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">N/A</div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><img src="../img/almuerzo.png" style="padding:0px; width:100%;"/></div>
                        </div>
                        <div class="text-right btn btn-warning id_detalle" name="'.$row_user[5].'" div_carga="#detalle_ing_'.$row_user[5].'" pag="ing_detalle_bre">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">N/A</div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><img src="../img/breake.png" style="padding:0px; width:100%;"/></div>
                        </div>
                    </div>';

                $html .= "</div>";
                $html .= '<div id="detalle_ing_'.$row_user[5].'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left hidden detalle_ingreso"></div>';
            }
        }
    }
    else{
        // Armamos los divs de salida de información
        $html .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-left cam_ing">';
            $src = "../img/fotos/man.jpeg";
            $html .= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 center-block img-thumbnail' style='background-image:url(\"".$src."\"); background-size:contain; background-repeat:no-repeat; background-position:center; height:100px; border-radius:5px;'></div>";

            $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">Usuario no tiene carnets registrados</div>';
            $html .= '
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left btn btn-default">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="bottom:0px;height:126px;">
                    No hay información
                </div>
            </div>';
        $html .= "</div>";
    }
}

$html .= '</div>';
echo $html;
?>
<script>detalleIng();</script>






