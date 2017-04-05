<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

if(isset($_GET['emp'])){
    $emp = $_GET['emp'];
    if($emp <> ''){$where .= "LEFT OUTER JOIN `e3_user` ON e3_ing.e3_ing_card = e3_user.e3_user_card WHERE e3_user.e3_emp_id = '$emp' AND e3_ing_type = 'Valid_Access'";}
    else{
        $where = "WHERE e3_ing_type = 'Valid_Access'";
    }
}
else{
    $where = "WHERE e3_ing_type = 'Valid_Access'";
}

if((isset($_GET['finicial']))&&(isset($_GET['ffinal']))){
    $finicial = $_GET['finicial'];
    $ffinal = $_GET['ffinal'];
    if(($finicial <> '')&&($ffinal <> '')){
        $where .= " AND (e3_ing_date BETWEEN '$finicial' AND '$ffinal')";
    }
    elseif(($finicial == '')&&($ffinal <> '')){
        $finicial = date('2000-01-01');
        $where .= " AND (e3_ing_date BETWEEN '$finicial' AND '$ffinal')";
    }
    elseif(($finicial <> '')&&($ffinal == '')){
        $ffinal = date('Y-m-d');
        $where .= " AND (e3_ing_date BETWEEN '$finicial' AND '$ffinal')";
    }
}

if(isset($_GET['card'])){
    $card = $_GET['card'];
    if($card <> ''){$where .= " AND e3_ing_card = '$card'";}
}

$html = '';
$res_reporte = registroCampo("e3_ing", "e3_ing_date", "$where", "GROUP BY e3_ing_date", "ORDER BY e3_ing_date ASC");
if($res_reporte){
    if(mysql_num_rows($res_reporte) > 0){
        while($row_report = mysql_fetch_array($res_reporte)){
            // $res_minmax = registroCampo("e3_ing", "e3_ing_date, MIN(e3_ing_hour) AS mini, MAX(e3_ing_hour) AS maxi, e3_ing_card, e3_ing_pers, e3_ing_door", "$where AND e3_ing_date = '".$row_rep[0]."'", "GROUP BY e3_ing_card, e3_ing_door", "ORDER BY e3_ing_hour ASC");
            $res_card = registroCampo("e3_ing", "e3_ing_card", "$where AND e3_ing_date = '".$row_report[0]."'", "GROUP BY e3_ing_card", "ORDER BY e3_ing_hour ASC");
            if($res_card){
                if(mysql_num_rows($res_card) > 0){
                    while($row_card = mysql_fetch_array($res_card)){
                        // obtenemos el numero del dia de la semana
                        $dia_sem = date('N', strtotime($$row_report[0]));
                        // Horas por defecto de entrada y salida a laborar
                        $h_ingreso = '07:00:00';
                        $h_salida = '17:30:00';

                        // Horas por defecto de salida y entrada a break mañana y tarde
                        $h_breakm_sal = '9:15:00';
                        $h_breakm_ent = '10:15:00';
                        $h_breakm_dsal = '9:30:00';
                        $h_breakm_dent = '10:00:00';

                        $h_breakt_sal = '15:15:00';
                        $h_breakt_ent = '16:15:00';
                        $h_breakt_dsal = '15:30:00';
                        $h_breakt_dent = '16:00:00';

                        // Horas por defecto de salida y entrada a almorzar
                        $h_lunch_sal = '12:45:00';
                        $h_lunch_ent = '14:15:00';
                        $h_lunch_dsal = '13:00:00';
                        $h_lunch_dent = '14:00:00';

                        // puerta que se tomara por defecto para el ingreso de personal
                        $puerta = 1;

                        // obtenemos las horas de ingreso y salida a labores.
                        $res_hinghsal = registroCampo("e3_horario h", "h.e3_horario_hent, h.e3_horario_hsal, u.e3_user_door", "LEFT OUTER JOIN e3_user u ON u.e3_user_id = h.e3_user_id WHERE u.e3_user_card = '".$row_card[0]."' AND  h.e3_horario_dia = '".$dia_sem."'", "", "");
                        if($res_hinghsal){
                            if(mysql_num_rows($res_hinghsal) > 0){
                                $row_hinghsal = mysql_fetch_array($res_hinghsal);
                                // Si tiene hora de ingreso y salida
                                if($row_hinghsal[0] <> ''){$h_ingreso = $row_hinghsal[0];} 
                                if($row_hinghsal[1] <> ''){$h_salida = $row_hinghsal[1];}
                                // Si tiene puerta de ingreso definida
                                if($row_hinghsal[2] <> ''){$puerta = $row_hinghsal[2];}
                            }
                        }
                        // Inicializo las variables del total y las clases
                        $debe_total = "";
                        $clase_div = "";
                        $dif_ingreso = strtotime("00:00:00");
                        $dif_salida = strtotime("00:00:00");
                        $dif_total = strtotime("00:00:00");
                                
                        // obtenemos el ingreso menor y mayor de la fecha, carnet , puerta del piso y asensor.
                        $res_horasminmax = registroCampo("e3_ing", "MIN(e3_ing_hour) AS mini, MAX(e3_ing_hour) AS maxi", "WHERE e3_ing_date = '".$row_report[0]."' AND e3_ing_card = '".$row_card[0]."' AND (e3_ing_ndoor = '".$puerta."' OR e3_ing_ndoor = '10')", "", "");
                        if($res_horasminmax){
                            if(mysql_num_rows($res_horasminmax) > 0){
                                $row_horasminmax = mysql_fetch_array($res_horasminmax);
                                if($row_horasminmax[0] == ''){$hora_ingreso = $h_ingreso;}else{$hora_ingreso = $row_horasminmax[0];}
                                if($row_horasminmax[1] == ''){$hora_salida = $h_salida;}else{$hora_salida = $row_horasminmax[1];}
                            }
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
                            // Con los datos obtenidos se arma una grilla para colocar la informacion
                            $html .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 text-left cam_ing">';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center blightblue">'.$row_report[0]."</div>";
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center bblue">'.$hora_ingreso.'</div>';
                                $html .= '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center borange">'.$hora_salida.'</div>';
                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center '.$clase_div.'">'.$debe_total ." ". date('H:i:s', $dif_total)."</div>";
                            $html .= "</div>";
                        }
                        else{
                            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
                        }
                    }
                }
                else{
                    // $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
                }
            }
            else{
                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
            }
        }
    }
    else{
        // $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
    }
}
else{
    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
}
echo $html;
?>
<script>setTimeout(esperehide, 300);</script>






