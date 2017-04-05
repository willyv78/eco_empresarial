<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// variables por defecto
$where_ing = "WHERE i.e3_ing_type = 'Valid_Access'";$card = "";
// Array con los dias de la semana para mostrar en resultados
$dias = array("", "Lun","Mar","Mie","Jue","Vie","Sáb","Dom");

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
// $where_ing .= " AND e3_user.e3_est_id = '1'";
// Verificamos si se envio la variable numero de tarjeta
if(isset($_GET['card'])){
    if($_GET['card'] <> ''){
        $card = $_GET['card'];
        // $where_ing .= " AND i.e3_ing_card = '$card'";
    }
}
$html = '';

$res_reporte = registroCampo("e3_ing i", "i.e3_ing_date", "$where_ing AND (i.e3_ing_date BETWEEN '$finicial' AND '$ffinal')", "GROUP BY i.e3_ing_date", "ORDER BY i.e3_ing_date ASC");

if($res_reporte){
    if(mysql_num_rows($res_reporte) > 0){
        while($row_report = mysql_fetch_array($res_reporte)){
            $icono_perm = '';
            $div_perm = '';
            // obtenemos el numero del dia de la semana
            $dia_sem = date('N', strtotime($row_report[0]));
            // Horas por defecto de entrada y salida a laborar
            $h_ingreso = '07:00:00';
            $h_salida = '17:30:00';
            // puerta que se tomara por defecto para el ingreso de personal
            $puerta = 1;
            // mostrar reporte variable por defecto
            $mostrar = 2;
            $trabaja = 0;
            $festivo = 0;
            $dia_esp = "";
            $vacas = 0;
            $perm = 0;
            // obtenemos las horas de ingreso y salida a labores.
            $res_hinghsal = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, c.e3_cont_door, u.e3_user_hora", "LEFT JOIN e3_cont c ON c.e3_user_id = h.e3_user_id LEFT JOIN e3_user u ON u.e3_user_id = h.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = h.e3_user_id WHERE card.e3_card_nom = '".$card."' AND  h.e3_horario_dia = '".$dia_sem."' AND (c.e3_cont_ffin >= '$finicial' OR c.e3_cont_ffin = '0000-00-00') AND (h.e3_horario_ffin >= '$finicial' OR h.e3_horario_ffin = '0000-00-00')", "", "");
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
            $res_cal = registroCampo("e3_cal", "DATE_FORMAT( `e3_cal_fini` , '%H:%i' ), DATE_FORMAT( `e3_cal_ffin` , '%H:%i' ), e3_cal_nom, e3_cal_id, e3_cal_tipo", "WHERE (e3_cal_tipo = '3' OR e3_cal_tipo = '2') AND DATE_FORMAT( `e3_cal_fini` , '%Y-%m-%d' ) = '".$row_report[0]."'", "", "");
            if($res_cal){
                if(mysql_num_rows($res_cal) > 0){
                    while($row_cal = mysql_fetch_array($res_cal)){
                        if($row_cal[4] == '3'){
                            $h_ingreso = $row_cal[0];
                            $h_salida = $row_cal[1];
                            $dia_esp = $row_cal[2];
                            $perm_id = $row_cal[3];
                            $icono_perm = '<span class="ver-esp" name="'.$perm_id.'" title="Día Especial"> <i class="glyphicon glyphicon-warning-sign"></i></span>';
                            $div_perm = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden esp'.$perm_id.'" id=""></div>';
                        }
                        else{
                            $festivo = 1;
                            $icono_perm = '<span class="ver-festivo" name="" title="Día Festivo"> <i class="glyphicon glyphicon-gift"></i></span>';
                        }
                    }
                }
            }

            // Consultamos si el empleado tiene permiso o vacaciones.
            $res_perm = registroCampo("e3_solic s", "s.e3_solic_id, s.e3_solic_fini, s.e3_solic_ffin, s.e3_solic_rep, s.e3_tsolic_id", "LEFT JOIN e3_card card ON card.e3_user_id = s.e3_user_id WHERE card.e3_card_nom = '".$card."' AND DATE_FORMAT(s.e3_solic_fini, '%Y-%m-%d') <= '".$row_report[0]."' AND DATE_FORMAT(s.e3_solic_ffin, '%Y-%m-%d')  >= '".$row_report[0]."' AND ((s.e3_tsolic_id = '1' OR s.e3_tsolic_id = '2') AND (s.e3_est_id = '1'))", "", "");
            $perm_hora_dif = strtotime("00:00:00");
            if($res_perm){
                if(mysql_num_rows($res_perm) > 0){
                    $row_perm = mysql_fetch_array($res_perm);
                    if($row_perm[4] == '1'){
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
                    else{
                        $vacas = 1;
                    }
                }
            }
            // obtenemos el ingreso menor y mayor de la fecha, carnet , puerta del piso y asensor.
            $res_horasminmax = registroCampo("e3_ing i", "MIN(i.e3_ing_hour) AS mini, MAX(i.e3_ing_hour) AS maxi", "LEFT JOIN e3_card card ON card.e3_card_nom = i.e3_ing_card WHERE i.e3_ing_date = '".$row_report[0]."' AND i.e3_ing_card = '".$card."' AND (i.e3_ing_ndoor = '".$puerta."' OR i.e3_ing_ndoor = '10') AND (card.e3_card_ffin >= '".$row_report[0]."' OR card.e3_card_ffin = '0000-00-00')", "", "");
            if($res_horasminmax){
                if(mysql_num_rows($res_horasminmax) > 0){
                    $row_horasminmax = mysql_fetch_array($res_horasminmax);
                    if(($row_horasminmax[0] <> '')&&($row_horasminmax[1] <> '')){
                        $hora_ingreso = $row_horasminmax[0];
                        $hora_salida = $row_horasminmax[1];
                        // Si NO es festivo hace esto
                        if($festivo == 0){
                            // Inicializo las variables del total y las clases
                            $debe_total = "";
                            $clase_div = "";
                            $dif_ingreso = strtotime("00:00:00");
                            $dif_salida = strtotime("00:00:00");
                            $dif_total = strtotime("00:00:00");

                            // Si el titulo del evento es Emergencia no debe sumar ni restar
                            if($dia_esp == 'Emergencia'){
                                $hora_ingreso = $h_ingreso;
                                $hora_salida = $h_salida;
                            }

                            // si no debe trabajar ese dia no hace operaciones de suma o resta
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
                                // Si no hay datos de ingreso y de salida no asistio ese dia
                                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                    // validamos si se debe mostrar la sumatoria o no

                                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div.'">'.$hora_ingreso.'</div>';
                                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div.'">'.$hora_salida.'</div>';
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.timestamp_a_minutos($dif_total).' m</div>';

                                $html .= "</div>";
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
                                    $debesalida = 2;// Me debe
                                }
                                // se convierte la diferencia en tre las horas reales y las por default en fechas.
                                $dif_entra_date = date('H:i:s', $dif_ingreso);
                                $dif_fuera_date = date('H:i:s', $dif_salida);
                                // si el empleado debe tiempo de entrada y de salida se suman y la deuda en mayor
                                if(($debeing == 1)&&($debesalida == 1)){
                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                    $clase_div = "btn btn-danger";
                                    $debe_total = "-";
                                }
                                // si el empleado tiene tiempo de entrada y de salida de sobra se suman y le deben tiempo mayor
                                elseif(($debeing == 2)&&($debesalida == 2)){
                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                    $clase_div = "btn btn-success";
                                    $debe_total = "+";
                                }
                                // en este caso el empleado lego tarde y salio tarde
                                elseif(($debeing == 1)&&($debesalida == 2)){
                                    // si el tiempo de entrada que debe es menor que el tiempo a su favor en la salida se resta
                                    if($dif_entra_date < $dif_fuera_date){
                                        $dif_total = restaHours($dif_entra_date, $dif_fuera_date);
                                        $clase_div = "btn btn-success";
                                        $debe_total = "+";
                                    }
                                    elseif($dif_entra_date > $dif_fuera_date){
                                        $dif_total = restaHours($dif_fuera_date, $dif_entra_date);
                                        $clase_div = "btn btn-danger";
                                        $debe_total = "-";
                                    }
                                    else{
                                        $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                        $clase_div = "btn btn-success";
                                        $debe_total = "+";
                                    }
                                }
                                // en este caso el empleado llego temprano y salio temprano
                                else{
                                    // si el tiempo de entrada que debe es menor que el tiempo a su favor en la salida se resta
                                    if($dif_entra_date < $dif_fuera_date){
                                        $dif_total = restaHours($dif_entra_date, $dif_fuera_date);
                                        $clase_div = "btn btn-danger";
                                        $debe_total = "-";
                                    }
                                    elseif($dif_entra_date > $dif_fuera_date){
                                        $dif_total = restaHours($dif_fuera_date, $dif_entra_date);
                                        $clase_div = "btn btn-success";
                                        $debe_total = "+";
                                    }
                                    else{
                                        $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                        $clase_div = "btn btn-success";
                                        $debe_total = "+";
                                    }
                                }
                                // Verifico si tiene permiso y es descontable y la hora de entrada es igual a la del permiso, cambio la hora del reporte
                                if($perm > 0){
                                    if($perm_rep == 1){
                                        if(($perm_hora_ini > $hora_ingreso) && ($perm_hora_fin < $hora_salida)){
                                            $perm_hora_dif = date('H:i:s', $perm_hora_dif);
                                            $dif_total = date('H:i:s', $dif_total);
                                            if($clase_div == "btn btn-danger"){
                                                $dif_total = sumarHours($perm_hora_dif, $dif_total);
                                            }
                                            else{
                                                if($perm_hora_dif > $dif_total){
                                                    $dif_total = restaHours($dif_total, $perm_hora_dif);
                                                    $clase_div = "btn btn-success";
                                                    $debe_total = "+";
                                                }
                                                else{
                                                    $dif_total = restaHours($perm_hora_dif, $dif_total);
                                                }
                                            }
                                        }
                                        // elseif(($perm_hora_ini <= $h_ingreso) && ($perm_hora_fin < $h_salida)){
                                        //     if($perm_hora_fin > $hora_ingreso){
                                        //         $dif_total_temp = restaHours($hora_ingreso, $perm_hora_fin);
                                        //         $dif_total_temp = date('H:i:s', $dif_total_temp);
                                        //         echo $dif_total."<br>";
                                        //         $dif_total = restaHours($dif_total_temp, $perm_hora_dif);
                                        //         echo date('H:i:s', $dif_total);
                                        //     }
                                        //     // $hora_salida = $row_horasminmax[1];
                                        // }
                                    }
                                    elseif($perm_rep == 2){
                                        if(($perm_hora_ini <= $hora_ingreso) || ($perm_hora_fin >= $hora_salida)){
                                            $perm_hora_dif = date('H:i:s', $perm_hora_dif);
                                            $dif_total = date('H:i:s', $dif_total);
                                            if($clase_div == "btn btn-success"){
                                                $dif_total = sumarHours($perm_hora_dif, $dif_total);
                                            }
                                            else{
                                                if($perm_hora_dif > $dif_total){
                                                    $dif_total = restaHours($dif_total, $perm_hora_dif);
                                                    $clase_div = "btn btn-success";
                                                    $debe_total = "+";
                                                }
                                                else{
                                                    $dif_total = restaHours($perm_hora_dif, $dif_total);
                                                }
                                            }
                                        }
                                    }
                                    else{
                                        $dif_total = strtotime("00:00:00");
                                    }
                                }
                            }
                            // Si debe trabajar, no tiene solicitud de vacaciones y NO tiene solicitud de permiso hace esto
                            if(($trabaja > 0) && ($vacas == 0) && ($perm == 0)){
                                // Con los datos obtenidos se arma una grilla para colocar la informacion
                                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div.'">'.$hora_ingreso.'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center '.$clase_div.'">'.$hora_salida.'</div>';
                                    // validamos si se debe mostrar la sumatoria o no
                                    if($mostrar == '1'){
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.$debe_total .' '. timestamp_a_minutos($dif_total).'m '.$icono_perm;
                                        $html .= '</div>';
                                    }
                                $html .= '</div>'.$div_perm;
                            }
                            // Si debe trabajar, no tiene solicitud de vacaciones y SI tiene solicitud de permiso (remunerado o NO remunerado) hace esto
                            else if(($trabaja > 0) && ($vacas == 0) && (($perm > 0) && (($perm_rep == 1) || ($perm_rep == 2)))){
                                // Con los datos obtenidos se arma una grilla para colocar la informacion
                                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">'.$hora_ingreso.'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">'.$hora_salida.'</div>';
                                    // validamos si se debe mostrar la sumatoria o no
                                    if($mostrar == '1'){
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$debe_total .' '. timestamp_a_minutos($dif_total).'m '.$icono_perm.'</div>';
                                    }
                                $html .= '</div>'.$div_perm;
                            }
                            // Si debe trabajar, SI tiene solicitud de vacaciones y no tiene solicitud de permiso hace esto
                            else if(($trabaja > 0) && ($vacas > 0) && ($perm == 0)){
                                // Si el usuario esta de vacaciones se coloca esto
                                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-primary">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-primary">'.$hora_ingreso.'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-primary">'.$hora_salida.'</div>';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-primary">Vacaciones</div>';
                                $html .= "</div>";
                            }
                            // Si debe trabajar, no tiene solicitud de vacaciones y SI tiene solicitud de permiso (Licencia o Incapacidad) hace esto
                            else if(($trabaja > 0) && ($vacas == 0) && (($perm > 0) && (($perm_rep == 3) || ($perm_rep == 4)))){
                                if($perm_rep == 3){$tipo_perm = "Licencia";}
                                else{$tipo_perm = "Incapacidad";}
                                // Si el usuario esta de vacaciones se coloca esto
                                $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">'.$hora_ingreso.'</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">'.$hora_salida.'</div>';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$tipo_perm.' '.$icono_perm.'</div>';
                                $html .= '</div>'.$div_perm;
                            }
                        }
                        // SI es festivo hace esto
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
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-success">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-success">'.$hora_ingreso.'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-success">'.$hora_salida.'</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.$debe_total .' '. timestamp_a_minutos($dif_total).'m'.$icono_perm;
                                    $html .= '</div>';
                                }
                            $html .= '</div>';
                        }
                    }
                    else{
                        // Si debe trabajar, no tiene solicitud de vacaciones y no tiene solicitud de permiso hace esto
                        if(($trabaja > 0) && ($vacas == 0) && ($perm == 0) && ($festivo == 0)){
                            // Si no hay datos de ingreso y de salida no asistio ese dia
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                                    $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No se presento</div>';
                                }
                                else{
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No Aplica</div>';
                                }
                            $html .= "</div>";
                        }
                        // Si debe trabajar, SI tiene solicitud de vacaciones y no tiene solicitud de permiso hace esto
                        else if(($trabaja > 0) && ($vacas > 0) && ($perm == 0)){
                            // Si el usuario esta de vacaciones se coloca esto
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-primary">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-primary">00:00:00</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-primary">24:00:00</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-primary">Vacaciones</div>';
                            $html .= "</div>";
                        }
                        // Si debe trabajar, no tiene solicitud de vacaciones y SI tiene solicitud de permiso (Remunerado o NO Remunerado) hace esto
                        else if(($trabaja > 0) && ($vacas == 0) && (($perm > 0) && (($perm_rep == 1) || ($perm_rep == 2)))){
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$dias[$dia_sem].' '.$row_report[0].'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">07:00:00</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">17:30:00</div>';
                                // validamos si se debe mostrar la sumatoria o no
                                if($mostrar == '1'){
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">Permiso '.$icono_perm.'</div>';
                                }
                            $html .= '</div>'.$div_perm;
                        }
                        // Si debe trabajar, no tiene solicitud de vacaciones y SI tiene solicitud de permiso (Licencia o Incapacidad) hace esto
                        elseif(($trabaja > 0) && ($vacas == 0) && (($perm > 0) && (($perm_rep == 3) || ($perm_rep == 4)))){
                            if($perm_rep == 3){$tipo_perm = "Licencia";}
                            else{$tipo_perm = "Incapacidad";}
                            // Si el usuario esta de vacaciones se coloca esto
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">07:00:00</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-info">17:30:00</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-info">'.$tipo_perm.' '.$icono_perm.'</div>';
                            $html .= '</div>'.$div_perm;
                        }
                        // Si debe trabajar, no tiene solicitud de vacaciones y no tiene solicitud de permiso y es dia festivo hace esto
                        if(($trabaja > 0) && ($vacas == 0) && ($perm == 0) && ($festivo > 0)){
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">Día Festivo'.$icono_perm.'</div>';
                            $html .= "</div>";
                        }
                    }
                }
                // Si debe trabajar hace esto
                else{
                    if($trabaja > 0){
                        // Si no hay datos de ingreso y de salida no asistio ese dia
                        $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                            $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No se presento</div>';
                        $html .= "</div>";
                    }
                }
            }
            // Si no hay ingreso minimo ni maximo en las puertas del empleado hace esto
            else{
                // Si debe trabajar y no es festivo
                if(($trabaja > 0) && ($festivo == 0)){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No se presento</div>';
                    $html .= "</div>";
                }
                // Si debe trabajar y SI es dia festivo hace esto 
                else if(($trabaja > 0) && ($festivo > 0)){
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">Día Festivo'.$icono_perm.'</div>';
                    $html .= "</div>";
                }
                // si NO debe trabajar hace esto
                else{
                    $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">'.$dias[$dia_sem].' '.$row_report[0]."</div>";
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">00:00:00</div>';
                        $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center btn btn-danger">24:00:00</div>';
                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center btn btn-danger">No es día laboral</div>';
                    $html .= "</div>";
                }
            }
        }
    }
}
echo $html;
?>
<script>
    detalleEntradas();
</script>















