<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// date_default_timezone_set('America/Bogota');
// Variables por defecto
$exp_id = "";$diast = 0;$diasp = 0;$fact = date("Y-m-d");
if(isset($_GET["id_emp"]))
{
  $exp_id = $_GET["id_emp"];
}
// Consulta de las solicitudes tipo vacaciones por id de usuario.
$res_bus = registroCampo("e3_solic", "e3_solic_id, e3_solic_fsolic, e3_solic_ndias, e3_solic_ndiasp, e3_solic_fini, e3_solic_fint, e3_cont_id, e3_est_id", "WHERE e3_user_id = '$exp_id' AND e3_tsolic_id = 2", "", "ORDER BY e3_solic_fini DESC");

$fecha_hoy = date('Y-m-d');

$class_ver    = " hidden";
$class_editar = " hidden";
$class_borrar = " hidden";
$class_agrega = " hidden";
if(isset($_GET['perm_mod'])){
    $perm_mod     = explode(",", $_GET['perm_mod']);
    $num_perm_mod = count($perm_mod);
    for($i = 0; $i < $num_perm_mod; $i++){
        if($perm_mod[$i] == '1'){
            $class_ver = "";
        }
        elseif($perm_mod[$i] == '2'){
            $class_editar = "";
        }
        elseif($perm_mod[$i] == '3'){
            $class_borrar = "";
        }
        elseif($perm_mod[$i] == '4'){
            $class_agrega = "";
        }
    }
}

// consulta de contratos del usuario
$res_cont = registroCampo("e3_cont c", "c.e3_cont_id, c.e3_cont_fini, c.e3_cont_ffin", "WHERE c.e3_user_id = '".$exp_id."'", "", "ORDER BY c.e3_cont_fini ASC");
?>
<div class="panel-body"><?php 
    if($res_cont){?>
        <div class="table-responsive">
            <legend>Historial</legend>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class='hidden-xs text-center'>Período</th>
                        <th class='text-center'>Total</th>
                        <th class='text-center'>Disfrutados</th>
                        <th class='text-center'>Pagados</th>
                        <th class='text-center'>Pendientes</th>
                    </tr>
                </thead>
                <tbody><?php 
                if(mysql_num_rows($res_cont) > 0){
                    $total_dias_vac = 0;
                    $total_diast_vac = 0;
                    $total_diasp_vac = 0;
                    $total_pend_vac = 0;
                    while($row_cont = mysql_fetch_array($res_cont)){
                        // Consulta la suma de los dias tomados y los dias pagados de las solicitudes por vacaciones realizadas por el empleado y fecha de ingreso del empleado.
                        $res_fing = registroCampo("e3_solic s", "SUM(s.e3_solic_ndias), SUM(s.e3_solic_ndiasp)", "WHERE s.e3_user_id = '".$exp_id."' AND s.e3_cont_id = '".$row_cont[0]."' AND s.e3_tsolic_id = 2 AND s.e3_est_id = '1' AND s.e3_solic_fini <= '$fecha_hoy'", "GROUP BY s.e3_cont_id, s.e3_est_id", "ORDER BY s.e3_solic_fini ASC");
                        // SELECT SUM(s.e3_solic_ndias), SUM(s.e3_solic_ndiasp), c.e3_cont_fini, c.e3_cont_ffin FROM `e3_cont` c LEFT JOIN e3_solic s USING(e3_cont_id) WHERE c.e3_user_id = '32' AND s.e3_tsolic_id = 2 AND s.e3_est_id = 1 GROUP BY s.e3_cont_id ORDER BY c.e3_cont_fini ASC
                        $diast = 0;
                        $diasp = 0;
                        if($res_fing){
                            if(mysql_num_rows($res_fing) > 0){
                                while($row_fing = mysql_fetch_array($res_fing)){
                                    $fact_anio = date("Y");
                                    if($row_fing[0] <> ''){$diast = $row_fing[0];}else{$diast = 0;}
                                    if($row_fing[1] <> ''){$diasp = $row_fing[1];}else{$diasp = 0;}
                                }
                            }
                        }
                        $fing_ini = $row_cont[1];
                        if(($row_cont[2] <> '') && ($row_cont[2] <> '0000-00-00')){$fing_fin = $row_cont[2];}
                        else{$fing_fin = $fact;}
                        $num_diast = 0;
                        $num_diasp = 0;
                        $num_diaspend = 0;
                        $pen_diast = 0;
                        $pen_diasp = 0;
                        $total_dias = $diast + $diasp;
                        $fing_ini = date('Y-m-d', strtotime($fing_ini));
                        $fing_fin = date('Y-m-d', strtotime($fing_fin));
                        $fing_fin2 = date('Y-m-d', strtotime ('+1 day' , strtotime($fing_fin)));
                        // fecha inicial del contrato
                        $from = new DateTime($fing_ini);
                        // fecha final de contrato
                        $to = new DateTime($fing_fin2);
                        // diferencia entre la fecha inicial y la fecha final
                        $resultado = date_diff($from, $to);
                        // total años entre las dos fechas
                        $anyos_total = $resultado->format('%y');
                        // echo "Años=".$anyos_total." ";
                        // meses parciales diferencia entre las dos fechas excluyendo los años
                        $meses_total = $resultado->format('%m');
                        // echo "Meses=".$meses_total." ";
                        // dias parciales diferencia entre las dos fechas excluyendo los años y los meses
                        $dias_total = $resultado->format('%d');
                        // echo "Dias=".$dias_total." ";
                        // total vacaciones por años entre las dos fechas
                        $temp_anyos = $anyos_total * 15;
                        // echo "Total años=".$temp_anyos." ";
                        // total vacaciones parciales por meses entre las dos fechas
                        $temp_meses = ((($meses_total * 30) * 15) / 360);
                        // echo "Total meses=".$temp_meses." ";
                        // total vacaciones parciales por dias entre las dos fechas
                        $temp_dias = (($dias_total * 15) / 360);
                        // echo "Total dias=".$temp_dias." ";
                        // total vacaciones entre las dos fechas
                        $ndias = round($temp_anyos + $temp_meses + $temp_dias);

                        // echo $diast." - ".$diasp."<br>";
                        // echo $total_dias."<br>";
                        // echo $ndias."<br>";
                        if($total_dias > $ndias){
                            // Si los dias tomados son mayores a los dias a pagar
                            if($diast >= $ndias){
                                $num_diast = $ndias;
                                $num_diasp = 0;
                                $diast = $diast - $ndias;
                                $diasp = $diasp;
                                $num_diaspend = $ndias - $total_dias;
                            }
                            // si los dias pagados son mayores a los que se deben pagar
                            elseif($diasp >= $ndias){
                                $num_diast = $diast;
                                $num_diasp = $diasp;
                                $diast = 0;
                                $diasp = $diasp - ($ndias - $diast);
                                if($diasp > 0){
                                    $num_diaspend = $ndias - $total_dias;
                                }
                                else{
                                    $num_diaspend = $total_dias - $ndias;
                                }
                            }
                            // si ningunos de los valores es mayor a el numero de dias que se deben pagar
                            else{
                                $num_diast = $diast;
                                $num_diasp = $ndias - $diast;
                                $num_diaspend = $ndias - $total_dias;
                                $diast = 0;
                                if($num_diasp > $diasp){
                                    $diasp = $num_diasp - $diasp;
                                }
                                else{
                                    $diasp = $diasp - $num_diasp;
                                }   
                            }
                        }
                        else{
                            $num_diast = $diast;
                            $num_diasp = $diasp;
                            $num_diaspend = $ndias - $total_dias;
                            $diast = 0;
                            $diasp = 0;
                        }
                        $total_dias_vac += $ndias;
                        $total_diast_vac += $num_diast;
                        $total_diasp_vac += $num_diasp;
                        $total_pend_vac += $num_diaspend;
                        echo "
                            <tr>
                                <td class='hidden-xs align-center'>".$fing_ini." - ".$fing_fin."</td>
                                <td class='align-center'>".$ndias."</td>
                                <td class='align-center'>".$num_diast."</td>
                                <td class='align-center'>".$num_diasp."</td>
                                <td class='align-center'>".$num_diaspend."</td>
                            </tr>";
                        $fing = date('Y-m-d', strtotime('+1 year', strtotime($fing_ini)));
                        if($total_pend_vac >= 0){
                            $class_total = "bblack";
                        }
                        else{
                            $class_total = "bred";
                        }

                    }
                    echo "
                        <tr>
                            <td class='hidden-xs col-sm-4 col-md-4 col-lg-4 text-center'><label>Totales</label></td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>".$total_dias_vac."</td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>".$total_diast_vac."</td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>".$total_diasp_vac."</td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center $class_total'>".$total_pend_vac."</td>
                        </tr>";
                }?>
                </tbody>
            </table>
        </div><?php 
    }?>
    <div class="table-responsive">
        <legend>Solicitudes</legend>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class='hidden-xs col-sm-2 col-md-2 col-lg-2 text-center'>Contrato</th>
                    <th class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>Fecha solicitud</th>
                    <th class='hidden-xs col-sm-2 col-md-2 col-lg-2 text-center'>Fecha inicia</th>
                    <th class='hidden-xs col-sm-3 col-md-3 col-lg-3 text-center'>Ingreso</th>
                    <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center'>Días</th>
                    <th class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>
                        <div name="<?php echo $exp_id;?>" class="input-group input-group-sm btn_est">
                            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_vacaciones">
                            <input type="hidden" name="input-pagina" id="input-pagina" class="form-control" value="ins_upd_perm"><?php 
                            if($class_agrega == ''){?>
                                <span class="btn btn-warning input-group-addon" title="Nuevo registro"><i class="glyphicon glyphicon-plus"></i></span><?php 
                            }?>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody><?php 
            if($res_bus){
                if(mysql_num_rows($res_bus) > 0){
                    while ($row_bus = mysql_fetch_array($res_bus)){
                        $no_cont = "N/E";
                        $clase_fila = "";
                        if($row_bus[6] <> ""){$no_cont = $row_bus[6];}
                        if($row_bus[7] == '1'){
                            if((strtotime(date('Y-m-d', strtotime($row_bus[4])))) > (strtotime($fecha_hoy))){
                                $clase_fila = "bblue";
                                // echo $row_bus[7]." - ".strtotime(date('Y-m-d', strtotime($row_bus[4])))." - ".strtotime($fecha_hoy)."<br>";
                            }
                            else{$clase_fila = "bgrey";}
                        }
                        elseif($row_bus[7] == '2'){$clase_fila = "borange";}
                        elseif($row_bus[7] == '4'){$clase_fila = "bred";}
                        else{$clase_fila = "";}?>
                        <tr class="<?php echo $clase_fila;?>">
                            <td class='hidden-xs col-sm-2 col-md-2 col-lg-2 text-center'><?php echo $no_cont;?></td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'><?php echo date('d-m-Y', strtotime($row_bus[1]));?></td>
                            <td class='hidden-xs col-sm-2 col-md-2 col-lg-2 text-center'><?php 
                                if($row_bus[4] <> '0000-00-00 00:00:00'){echo date('d-m-Y', strtotime($row_bus[4]));}
                                else{echo " - o - ";}?>
                            </td>
                            <td class='hidden-xs col-sm-3 col-md-3 col-lg-3 text-center'><?php 
                                if($row_bus[5] <> '0000-00-00 00:00:00'){echo date('d-m-Y', strtotime($row_bus[5]));}
                                else{echo " - o - ";}?>
                            </td>
                            <td class='col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center'><?php echo round($row_bus[2]) + round($row_bus[3]);?></td>
                            <td class='col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center'>
                                <div name="<?php echo $row_bus[0];?>" class="input-group input-group-sm btn_est"><?php 
                                    if($class_ver == ''){?>
                                        <span class="btn btn-info input-group-addon" title="Ver Solicitud"><i class="glyphicon glyphicon-eye-open"></i></span><?php 
                                    }
                                    if($class_editar == ''){
                                        if((($_SESSION['user_perf'] == '3') || ($_SESSION['user_perf'] == '4') || ($_SESSION['user_perf'] == '5') && (($row_bus[7] == '3') || ($row_bus[7] == '4'))) || (($_SESSION['user_perf'] == '1') || (($_SESSION['user_perf'] == '2') && ($row_bus[7] == '2')) || (($_SESSION['user_perf'] == '7') && ($row_bus[7] == '2')) || (($_SESSION['user_perf'] == '9') && (($row_bus[7] == '2') || ($row_bus[7] == '3'))))){?>
                                                <span class="btn btn-success input-group-addon" title="Editar Solicitud"> <i class="glyphicon glyphicon-pencil"></i></span><?php 
                                        }
                                    }
                                    if($class_borrar == ''){?>
                                        <span class="btn btn-danger input-group-addon" title="Eliminar Solicitud"> <i class="glyphicon glyphicon-remove"></i></span><?php 
                                    }?>
                                </div>
                            </td>
                        </tr><?php 
                    }
                }
                else{?>
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="text-center">
                                No se encontró información
                            </div>
                        </td>
                    </tr><?php 
                }
            }
            else{?>
                <tr>
                    <td colspan="5" class="text-center">
                        <div class="text-center">
                            No se encontró información
                        </div>
                    </td>
                </tr><?php 
            }?>
            </tbody>
        </table>
    </div>
</div>
<script>empEstudios();</script>