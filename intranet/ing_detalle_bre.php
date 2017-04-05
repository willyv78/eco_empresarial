<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// variables por defecto
$where = "WHERE e3_ing_type = 'Valid_Access'";

// Verificamos que las variables de fecha inicial y fecha final se han enviado sino se toman por defecto
$finicial = date('Y-m-01');
$ffinal = date('Y-m-d');
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

$where .= " AND (e3_ing_date BETWEEN '$finicial' AND '$ffinal')";

if(isset($_GET['card'])){
    $card = $_GET['card'];
    // if($card <> ''){$where .= " AND e3_ing_card = '$card'";}
}
// Array con los dias de la semana para mostrar en resultados
$dias = array("", "Lun","Mar","Mie","Jue","Vie","Sáb","Dom");
$html = '';
$res_reporte = registroCampo("e3_ing", "e3_ing_date", "$where", "GROUP BY e3_ing_date", "ORDER BY e3_ing_date ASC");
if($res_reporte){
    if(mysql_num_rows($res_reporte) > 0){
        while($row_report = mysql_fetch_array($res_reporte)){
            // obtenemos el numero del dia de la semana
            $dia_sem = date('N', strtotime($row_report[0]));
            $dia_esp = "";
            $festivo = 0;
            $vacas = 0;
            $perm = 0;
            $icono_perm = "";
            $div_perm = "";

            // Revisamos si existen dias especiales para la fecha
            $res_cal = registroCampo("e3_cal", "DATE_FORMAT( `e3_cal_fini` , '%H:%i' ), DATE_FORMAT( `e3_cal_ffin` , '%H:%i' ), e3_cal_nom, e3_cal_id", "WHERE e3_cal_tipo = '3' AND DATE_FORMAT( `e3_cal_fini` , '%Y-%m-%d' ) = '".$row_report[0]."'", "", "");
            if($res_cal){
                if(mysql_num_rows($res_cal) > 0){
                    $row_cal = mysql_fetch_array($res_cal);
                    $h_ingreso = $row_cal[0];
                    $h_salida = $row_cal[1];
                    $dia_esp = $row_cal[2];
                    $perm_id = $row_cal[3];
                    $icono_perm = '<span class="ver-esp" name="'.$perm_id.'" title="Día Especial"> <i class="glyphicon glyphicon-warning-sign"></i></span>';
                    $div_perm = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden esp'.$perm_id.'" id=""></div>';
                    // echo "Titulo: ".$dia_esp." Hora de entrada: ".$h_ingreso." Hora salida: ".$h_salida."<br>";
                }
            }

            // Revisamos si es festivo
            $res_cal_fes = registroCampo("e3_cal", "DATE_FORMAT( `e3_cal_fini` , '%H:%i' ), DATE_FORMAT( `e3_cal_ffin` , '%H:%i' )", "WHERE e3_cal_tipo = '2' AND DATE_FORMAT( `e3_cal_fini` , '%Y-%m-%d' ) = '".$row_report[0]."'", "", "");
            if($res_cal_fes){
                if(mysql_num_rows($res_cal_fes) > 0){
                    $row_cal_fes = mysql_fetch_array($res_cal_fes);
                    $festivo = 1;
                    $icono_perm = '<span class="ver-festivo" name="" title="Día Festivo"> <i class="glyphicon glyphicon-gift"></i></span>';
                    // echo "Titulo: ".$festivo." Hora de entrada: ".$h_ingreso." Hora salida: ".$h_salida."<br>";
                }
            }

            // Consultamos si el empleado se encuentra en vacaciones.
            $res_vacas = registroCampo("e3_solic s", "s.e3_solic_id", "LEFT JOIN e3_card c ON c.e3_user_id = s.e3_user_id WHERE c.e3_card_nom = '".$card."' AND s.e3_solic_fini <= '".$row_report[0]."' AND e3_solic_ffin >= '".$row_report[0]."' AND s.e3_tsolic_id = '2' AND (c.e3_card_ffin = '0000-00-00' OR c.e3_card_ffin IS NULL)", "", "");
            if($res_vacas){
                if(mysql_num_rows($res_vacas) > 0){
                    $vacas = 1;
                }
            }

            // Consultamos si el empleado tiene permiso.
            $res_perm = registroCampo("e3_solic s", "s.e3_solic_id, s.e3_solic_fini, s.e3_solic_ffin, s.e3_solic_rep", "LEFT JOIN e3_card c ON c.e3_user_id = s.e3_user_id WHERE c.e3_card_nom = '".$card."' AND DATE_FORMAT(s.e3_solic_fini, '%Y-%m-%d') <= '".$row_report[0]."' AND DATE_FORMAT(s.e3_solic_ffin, '%Y-%m-%d')  >= '".$row_report[0]."' AND s.e3_tsolic_id = '1' AND (c.e3_card_ffin = '0000-00-00' OR c.e3_card_ffin IS NULL)", "", "");
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
                    $icono_perm = '<span class="ver-perm" name="'.$perm_id.'" title="Ver solicitud"> <i class="glyphicon glyphicon-file"></i></span>';
                    $div_perm = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden perm'.$perm_id.'" id=""></div>';
                }
            }

            $res_card = registroCampo("e3_horario h", "h.e3_horario_id", "LEFT JOIN e3_card c ON c.e3_user_id = h.e3_user_id WHERE c.e3_card_nom = '".$card."' AND h.e3_horario_dia = '".$dia_sem."' AND (c.e3_card_ffin = '0000-00-00' OR c.e3_card_ffin IS NULL)", "GROUP BY c.e3_card_nom", "");
            if($res_card){
                if(mysql_num_rows($res_card) > 0){
                    while($row_card = mysql_fetch_array($res_card)){
                        // Horas por defecto de salida y entrada a break mañana y tarde
                        $h_breakm_sal = '9:30:00';
                        $h_breakm_ent = '10:15:00';
                        $h_breakt_sal = '15:30:00';
                        $h_breakt_ent = '16:15:00';
                        $dif_total_bm = "";
                        $dif_total_bt = "";
                        // puerta que se tomara por defecto para el ingreso de personal
                        $puerta = 1;
                        $mostrar = 1;
                        // obtenemos las horas de salida e ingreso a break y almuerzo.
                        $res_salent = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, h.e3_horario_dia, c.e3_cont_door, u.e3_user_hora", "LEFT JOIN e3_cont c ON c.e3_user_id = h.e3_user_id LEFT JOIN e3_user u ON u.e3_user_id = h.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = h.e3_user_id WHERE card.e3_card_nom ='".$card."' AND (h.e3_horario_dia = 8 OR h.e3_horario_dia = 10) AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL) AND (card.e3_card_ffin = '0000-00-00' OR card.e3_card_ffin IS NULL)", "", "");
                        if($res_salent){
                            if(mysql_num_rows($res_salent) > 0){
                                while($row_salent = mysql_fetch_array($res_salent)){
                                    // Si tiene numero de puerta asignada
                                    if($row_salent[3] <> ''){$puerta = $row_salent[3];}
                                    // Mostrar o no sumatoria en el reporte
                                    if($row_salent[4] <> ''){$mostrar = $row_salent[4];}
                                    // si es el horario de break de la mañana
                                    if($row_salent[2] == '8'){
                                        $clase_div_bm = "btn btn-danger";
                                        // Si tiene hora de ingreso y salida
                                        if($row_salent[0] <> ''){
                                            $h_breakm_sal = date('H:i:s', strtotime('-10 minute', strtotime($row_salent[0])));
                                            $h_real_sal_bm = $row_salent[0];
                                        }
                                        else{$h_real_sal_bm = $h_breakm_sal;}
                                        if($row_salent[1] <> ''){
                                            $h_breakm_ent = date('H:i:s', strtotime('+10 minute', strtotime($row_salent[1])));
                                            $h_real_ent_bm = $row_salent[1];
                                        }
                                        else{$h_real_ent_bm = $h_breakm_ent;}
                                        // echo "Hora de salida default = ".$h_breakm_sal." Hora entrada default = ".$h_breakm_ent."<br />";
                                        $dif_total_bm = strtotime("00:00:00");
                                        // Obtenemos la menor salida de la puerta del piso entre un rango de horas para el break de la mañana
                                        $res_hbmmin = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakm_sal."' AND '".$h_breakm_ent."')", "", "");
                                        if($res_hbmmin){
                                            if(mysql_num_rows($res_hbmmin) > 0){
                                                $row_hbmmin = mysql_fetch_array($res_hbmmin);
                                                if($row_hbmmin[0] <> ''){$hora_sal_bm = $row_hbmmin[0];}else{$hora_sal_bm = $h_breakm_sal;}
                                            }
                                            else{$hora_sal_bm = $h_breakm_sal;}
                                        }
                                        else{$hora_sal_bm = $h_real_sal_bm;}
                                        // Obtenemos el mayor ingreso de la puerta del piso entre un rango de horas para el break de la mañana
                                        $res_hbmmax = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakm_sal."' AND '".$h_breakm_ent."')", "", "");
                                        if($res_hbmmax){
                                            if(mysql_num_rows($res_hbmmax) > 0){
                                                $row_hbmmax = mysql_fetch_array($res_hbmmax);
                                                if($row_hbmmax[0] <> ''){$hora_ent_bm = $row_hbmmax[0];}else{$hora_ent_bm = $h_breakm_ent;}
                                            }
                                            else{$hora_ent_bm = $h_breakm_ent;}
                                        }
                                        else{$hora_ent_bm = $h_real_ent_bm;}
                                        // si las dos horas entrada y salida son iguales
                                        if($hora_sal_bm == $hora_ent_bm){
                                            $hora_sal_bm = $h_breakm_sal;
                                            $hora_ent_bm = $h_breakm_ent;
                                        }
                                        // obtenemos la cantidad de minutos diferencia si es mayor a 60 debe.
                                        if($hora_ent_bm < $hora_sal_bm){
                                            $minutos_bm = timestamp_a_minutos((strtotime($hora_sal_bm) - strtotime($hora_ent_bm)) + strtotime("00:00:00"));
                                        }
                                        else{
                                            $minutos_bm = timestamp_a_minutos((strtotime($hora_ent_bm) - strtotime($hora_sal_bm)) + strtotime("00:00:00"));
                                        }
                                        if($minutos_bm > 11){
                                            $dif_total_bm = $minutos_bm - 11;
                                            $clase_div_bm = "btn btn-danger";// Me debe
                                            $debe_total_bm = "-";
                                        }
                                        else{
                                            // if($minutos_bm == 0){$minutos_bm = 10;}
                                            // elseif($minutos_bm == 10){$minutos_bm = 0;}
                                            $dif_total_bm =  11 - $minutos_bm;
                                            $clase_div_bm = "btn btn-success";// Le debo 
                                            $debe_total_bm = "+";                                               
                                        }
                                        // echo "Diferencia = " . $debe_total_bm . $dif_total_bm ." Minutos bm = " . $minutos_bm . " Fecha = " . $row_report[0] . "<br>";
                                    }
                                    // si es el horario del break de la tarde
                                    elseif($row_salent[2] == '10'){
                                        $clase_div_bt = "btn btn-danger";
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
                                        $dif_total_bt = strtotime("00:00:00");
                                        // Obtenemos la menor salida de la puerta del piso entre un rango de horas para la hora de almuerzo
                                        $res_hbmmint = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakt_sal."' AND '".$h_breakt_ent."')", "", "");
                                        if($res_hbmmint){
                                            if(mysql_num_rows($res_hbmmint) > 0){
                                                $row_hbmmint = mysql_fetch_array($res_hbmmint);
                                                if($row_hbmmint[0] <> ''){$hora_sal_bt = $row_hbmmint[0];}else{$hora_sal_bt = $h_breakt_sal;}
                                            }
                                            else{$hora_sal_bt = $h_breakt_sal;}
                                        }
                                        else{$hora_sal_bt = $h_real_sal_bt;}
                                        // Obtenemos el mayor ingreso de la puerta del piso entre un rango de horas para la hora de almuerzo
                                        $res_hbmmaxt = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_breakt_sal."' AND '".$h_breakt_ent."')", "", "");
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
                                            $debe_total_bt = "-";
                                        }
                                        else{
                                            // if($minutos_bt == 0){$minutos_bt = 10;}
                                            $dif_total_bt =  11 - $minutos_bt;
                                            $clase_div_bt = "btn btn-success";// Le debo 
                                            $debe_total_bt = "+";                                               
                                        }
                                    }

                                }
                            }
                            if($festivo > 0){
                                $clase_div_bm = "btn btn-danger";$debe_total_bm = "";$dif_total_bm = "Festivo";
                                $clase_div_bt = "btn btn-danger";$debe_total_bt = "";$dif_total_bt = "Festivo";
                            }
                            elseif($dia_esp <> ''){
                                if($dia_esp == 'Emergencia'){
                                    $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Emergencia";
                                    $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Emergencia";
                                }
                                else{
                                    $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Día especial";
                                    $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Día especial";
                                }
                            }
                            elseif($perm > 0){
                                $clase_div_bm = "btn btn-info";$debe_total_bm = "";$dif_total_bm = "Permiso";
                                $clase_div_bt = "btn btn-info";$debe_total_bt = "";$dif_total_bt = "Permiso";
                            }
                            elseif($vacas > 0){
                                $clase_div_bm = "btn btn-primary";$debe_total_bm = "";$dif_total_bm = "Vacaciones";
                                $clase_div_bt = "btn btn-primary";$debe_total_bt = "";$dif_total_bt = "Vacaciones";
                            }
                            else{
                                $dif_total_bm .= " m";
                                $dif_total_bt .= " m";
                            }
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">Break Mañana</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">'.$hora_sal_bm.'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">'.$hora_ent_bm.'</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$debe_total_bm.' '.$dif_total_bm.' '.$icono_perm.'</div>';
                                }
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">Break Tarde</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">'.$hora_sal_bt.'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">'.$hora_ent_bt.'</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">'.$debe_total_bt.' '.$dif_total_bt.' '.$icono_perm.'</div>';
                                }
                            $html .= "</div>";
                        }
                        else{
                            if($festivo > 0){
                                $clase_div_bm = "btn btn-danger";$debe_total_bm = "";$dif_total_bm = "Festivo";
                                $clase_div_bt = "btn btn-danger";$debe_total_bt = "";$dif_total_bt = "Festivo";
                            }
                            elseif($dia_esp <> ''){
                                if($dia_esp == 'Emergencia'){
                                    $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Emergencia";
                                    $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Emergencia";
                                }
                                else{
                                    $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Día especial";
                                    $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Día especial";
                                }
                            }
                            elseif($perm > 0){
                                $clase_div_bm = "btn btn-info";$debe_total_bm = "";$dif_total_bm = "Permiso";
                                $clase_div_bt = "btn btn-info";$debe_total_bt = "";$dif_total_bt = "Permiso";
                            }
                            elseif($vacas > 0){
                                $clase_div_bm = "btn btn-primary";$debe_total_bm = "";$dif_total_bm = "Vacaciones";
                                $clase_div_bt = "btn btn-primary";$debe_total_bt = "";$dif_total_bt = "Vacaciones";
                            }
                            else{
                                $clase_div_bm = "btn btn-success";$debe_total_bm = "+";$dif_total_bm = "0 m";
                                $clase_div_bt = "btn btn-success";$debe_total_bt = "+";$dif_total_bt = "0 m";
                            }
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">Break Mañana</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">09:30</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">10:00</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$debe_total_bm.' '.$dif_total_bm.' '.$icono_perm.'</div>';
                                }
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">Break Tarde</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">15:30</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">16:00</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">'.$debe_total_bt.' '.$dif_total_bt.' '.$icono_perm.'</div>';
                                }
                            $html .= "</div>";
                        }
                    }
                }
            }
            else{
                if($festivo > 0){
                    $clase_div_bm = "btn btn-danger";$debe_total_bm = "";$dif_total_bm = "Festivo";
                    $clase_div_bt = "btn btn-danger";$debe_total_bt = "";$dif_total_bt = "Festivo";
                }
                elseif($dia_esp <> ''){
                    if($dia_esp == 'Emergencia'){
                        $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Emergencia";
                        $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Emergencia";
                    }
                    else{
                        $clase_div_bm = "btn btn-warning";$debe_total_bm = "";$dif_total_bm = "Día especial";
                        $clase_div_bt = "btn btn-warning";$debe_total_bt = "";$dif_total_bt = "Día especial";
                    }
                }
                elseif($perm > 0){
                    $clase_div_bm = "btn btn-info";$debe_total_bm = "";$dif_total_bm = "Permiso";
                    $clase_div_bt = "btn btn-info";$debe_total_bt = "";$dif_total_bt = "Permiso";
                }
                elseif($vacas > 0){
                    $clase_div_bm = "btn btn-primary";$debe_total_bm = "";$dif_total_bm = "Vacaciones";
                    $clase_div_bt = "btn btn-primary";$debe_total_bt = "";$dif_total_bt = "Vacaciones";
                }
                else{
                    $clase_div_bm = "btn btn-success";$debe_total_bm = "+";$dif_total_bm = "0 m";
                    $clase_div_bt = "btn btn-success";$debe_total_bt = "+";$dif_total_bt = "0 m";
                }
                // Con los datos obtenidos se arma una grilla para colocar la informacion
                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">Break Mañana</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">09:30</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bm.'">10:00</div>';
                    // validamos si se debe mostrar la sumatoria o no
                    if($mostrar == '1'){
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bm.'">'.$debe_total_bm.' '.$dif_total_bm.' '.$icono_perm.'</div>';
                    }
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">Break Tarde</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">15:30</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_bt.'">16:00</div>';
                    // validamos si se debe mostrar la sumatoria o no
                    if($mostrar == '1'){
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_bt.'">'.$debe_total_bt.' '.$dif_total_bt.' '.$icono_perm.'</div>';
                    }
                $html .= "</div>";
            }
        }
    }
    else{
        // Con los datos obtenidos se arma una grilla para colocar la informacion
        $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No definido</div>';
            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">09:30</div>';
            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">10:00</div>';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No hay datos</div>';
        $html .= "</div>";
    }
}
else{
    // Con los datos obtenidos se arma una grilla para colocar la informacion
    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No definido</div>';
        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">09:30</div>';
        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">10:00</div>';
        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No hay datos</div>';
    $html .= "</div>";
}
echo $html;
?>
<script>setTimeout(esperehide, 300);</script>






