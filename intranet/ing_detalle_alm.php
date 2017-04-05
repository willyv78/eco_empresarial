<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// Variables por defecto
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
            $icono_perm = "";
            $div_perm = "";
            // obtenemos el numero del dia de la semana
            $dia_sem = date('N', strtotime($row_report[0]));
            $dia_esp = "";
            // puerta que se tomara por defecto para el ingreso de personal
            $puerta = 1;
            // mostrar reporte variable por defecto
            $mostrar = 2;
            $trabaja = 0;
            $festivo = 0;
            $dia_esp = "";
            $vacas = 0;
            $perm = 0;

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
                        // Horas por defecto de salida y entrada a almorzar
                        $h_lunch_sal = '12:45:00';
                        $h_lunch_ent = '14:15:00';
                        $dif_total_l = "";
                        // puerta que se tomara por defecto para el ingreso de personal
                        $puerta = 1;
                        // mostrar reporte variable por defecto
                        $mostrar = 1;
                        // obtenemos las horas de salida e ingreso a almuerzo.
                        $res_salent = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, c.e3_cont_door, u.e3_user_hora", "LEFT JOIN e3_cont c ON c.e3_user_id = h.e3_user_id LEFT JOIN e3_user u ON u.e3_user_id = h.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = h.e3_user_id WHERE card.e3_card_nom ='".$card."' AND (h.e3_horario_dia = 9) AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (h.e3_horario_ffin >= '$finicial' OR h.e3_horario_ffin = '0000-00-00') AND (card.e3_card_ffin >= '$finicial' OR card.e3_card_ffin = '0000-00-00')", "", "");
                        if($res_salent){
                            if(mysql_num_rows($res_salent) > 0){
                                while($row_salent = mysql_fetch_array($res_salent)){
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
                                    if($row_salent[2] <> ''){$puerta = $row_salent[2];}
                                    if($row_salent[3] <> ''){$mostrar = $row_salent[3];}
                                    // echo "Hora de salida default = ".$h_lunch_sal." Hora entrada default = ".$h_lunch_ent."<br />";
                                    $clase_div_l = "";
                                    $dif_ingreso_l = strtotime("00:00:00");
                                    $dif_salida_l = strtotime("00:00:00");
                                    $dif_total_l = strtotime("00:00:00");
                                    // Obtenemos el menor salida de la puerta del piso entre un rengo de horas para la hora de almuerzo
                                    $res_hlunchmin = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_lunch_sal."' AND '".$h_lunch_ent."')", "", "");
                                    if($res_hlunchmin){
                                        if(mysql_num_rows($res_hlunchmin) > 0){
                                            $row_hlunchmin = mysql_fetch_array($res_hlunchmin);
                                            if($row_hlunchmin[0] <> ''){$hora_sal_lunch = $row_hlunchmin[0];}else{$hora_sal_lunch = $h_lunch_sal;}
                                        }
                                        else{$hora_sal_lunch = $h_lunch_sal;}
                                    }
                                    else{$hora_sal_lunch = $h_lunch_sal;}
                                    // Obtenemos la mayor entrada de la puerta del piso entre un rengo de horas para la hora de almuerzo
                                    $res_hlunchmax = registroCampo("e3_ing", "MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$card."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10') AND (e3_ing_hour BETWEEN '".$h_lunch_sal."' AND '".$h_lunch_ent."')", "", "");
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
                                        $debe_total_l = "-";
                                    }
                                    else{
                                        // if($minutos_lunch == 0){$minutos_lunch = 60;}
                                        $dif_total_l =  60 - $minutos_lunch;
                                        $clase_div_l = "btn btn-success";// Le debo
                                        $debe_total_l = "+";
                                    }

                                    // if($card == '559'){
                                    //     // echo "Hora de salida default = ".$h_lunch_sal." Hora entrada default = ".$h_lunch_ent."<br />";
                                    //     echo "Hora de salida real = ".$hora_sal_lunch." Hora entrada real = ".$hora_ent_lunch." diferencia = ".$dif_total_l." clase = ".$clase_div_l."<br />";
                                    // }
                                }
                            }
                            if($festivo > 0){$clase_div_l = "btn btn-danger";$debe_total_l = "";$dif_total_l = "Festivo";}
                            elseif($dia_esp <> ''){
                                if($dia_esp == 'Emergencia'){$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Emergencia";}
                                else{$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Dia especial";}
                            }
                            elseif($perm > 0){$clase_div_l = "btn btn-info";$debe_total_l = "";$dif_total_l = "Permiso";}
                            elseif($vacas > 0){$clase_div_l = "btn btn-primary";$debe_total_l = "";$dif_total_l = "Vacaciones";}
                            else{$dif_total_l .= " m";}
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">'.$hora_sal_lunch.'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">'.$hora_ent_lunch.'</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$debe_total_l .' '.$dif_total_l.' '.$icono_perm.'</div>';
                                }
                            $html .= "</div>".$div_perm;
                        }
                        else{
                            if($festivo > 0){
                                $clase_div_l = "btn btn-danger";
                                $debe_total_l = "";
                                $dif_total_l = "Festivo";
                            }
                            elseif($dia_esp <> ''){
                                if($dia_esp == 'Emergencia'){
                                    $clase_div_l = "btn btn-warning";
                                    $debe_total_l = "";
                                    $dif_total_l = "Emergencia";
                                }
                                else{
                                    $clase_div_l = "btn btn-warning";
                                    $debe_total_l = "";
                                    $dif_total_l = "Dia especial";
                                }
                            }
                            elseif($perm > 0){
                                $clase_div_l = "btn btn-info";
                                $debe_total_l = "";
                                $dif_total_l = "Permiso";
                            }
                            elseif($vacas > 0){
                                $clase_div_l = "btn btn-primary";
                                $debe_total_l = "";
                                $dif_total_l = "Vacaciones";
                            }
                            else{
                                $clase_div_l = "btn btn-success";$debe_total_l = "+";$dif_total_l = "0 m";
                            }
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">13:00</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">14:00</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$debe_total_l .' '.$dif_total_l.' '.$icono_perm.'</div>';
                            $html .= "</div>".$div_perm;
                        }
                    }
                }
                // else{
                //     if($festivo > 0){$clase_div_l = "btn btn-danger";$debe_total_l = "";$dif_total_l = "Festivo";}
                //     elseif($dia_esp <> ''){
                //         if($dia_esp == 'Emergencia'){$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Emergencia";}
                //         else{$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Dia especial";}
                //     }
                //     elseif($perm > 0){$clase_div_l = "btn btn-info";$debe_total_l = "";$dif_total_l = "Permiso";}
                //     elseif($vacas > 0){$clase_div_l = "btn btn-primary";$debe_total_l = "";$dif_total_l = "Vacaciones";}
                //     else{$clase_div_l = "btn btn-success";$debe_total_l = "+";$dif_total_l = "0";}
                //     // Con los datos obtenidos se arma una grilla para colocar la informacion
                //     $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                //         $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                //         $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">13:00</div>';
                //         $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">14:00</div>';
                //         $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$debe_total_l .' '.$dif_total_l.'m '.$icono_perm.'</div>';
                //     $html .= "</div>".$div_perm;
                // }
            }
            else{
                if($festivo > 0){$clase_div_l = "btn btn-danger";$debe_total_l = "";$dif_total_l = "Festivo";}
                elseif($dia_esp <> ''){
                    if($dia_esp == 'Emergencia'){$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Emergencia";}
                    else{$clase_div_l = "btn btn-warning";$debe_total_l = "";$dif_total_l = "Dia especial";}
                }
                elseif($perm > 0){$clase_div_l = "btn btn-info";$debe_total_l = "";$dif_total_l = "Permiso";}
                elseif($vacas > 0){$clase_div_l = "btn btn-primary";$debe_total_l = "";$dif_total_l = "Vacaciones";}
                else{$clase_div_l = "btn btn-success";$debe_total_l = "+";$dif_total_l = "0";}
                // Con los datos obtenidos se arma una grilla para colocar la informacion
                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">13:00</div>';
                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div_l.'">14:00</div>';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div_l.'">'.$debe_total_l .' '.$dif_total_l.'m '.$icono_perm.'</div>';
                $html .= "</div>".$div_perm;
            }
        }
    }
    else{
        // Con los datos obtenidos se arma una grilla para colocar la informacion
        $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No definido</div>';
            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">13:00</div>';
            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">14:00</div>';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No hay datos</div>';
        $html .= "</div>";
    }
}
else{
    // Con los datos obtenidos se arma una grilla para colocar la informacion
    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No definido</div>';
        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">13:00</div>';
        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">14:00</div>';
        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No hay datos</div>';
    $html .= "</div>";
}
echo $html;
?>
<script>detalleEntradas();</script>






