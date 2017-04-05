<?php  session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$emp="1";
// traemos la empresa del usuario registrado
$res_emp = registroCampo("e3_cont", "e3_emp_id", "WHERE e3_user_id = '".$_SESSION['user_id']."' AND (e3_cont_ffin ='0000-00-00' OR e3_cont_ffin IS NULL)", "", "");
if($res_emp){
    if(mysql_num_rows($res_emp) > 0){
        $row_emp = mysql_fetch_array($res_emp);
        $emp = $row_emp[0];
    }
}
// consulta para obtener los eventos del dia o posteriores y colocarlos en las notificaciones en la parte izquierda debajo del menu en las pantallas grandes
$fechahoy = date('Y-m-d');
$res_cal = registroCampo("e3_cal", "e3_cal_id, e3_cal_nom, e3_cal_tipo, e3_cal_fini, e3_cal_user", "WHERE ((e3_cal_pub <> '1') AND  e3_cal_user = '".$_SESSION['user_id']."' AND e3_cal_fini >= '$fechahoy' AND e3_cal_tipo <> '2') OR (e3_cal_pub = '1' AND e3_cal_fini >= '$fechahoy' AND e3_cal_tipo <> '2' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$emp%' OR e3_cal_emp = '')) OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND ('".$_SESSION['user_perf']."' = 9 OR '".$_SESSION['user_perf']."' = 1))))", "", "ORDER BY e3_cal_fini ASC LIMIT 8");
// SELECT e3_cal_id, e3_cal_nom, e3_cal_tipo, e3_cal_fini, e3_cal_emp FROM e3_cal WHERE e3_cal_pub = '1' AND e3_cal_fini > '2015-07-28' AND e3_cal_tipo <> '2' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%3%' OR e3_cal_emp = ''))) ORDER BY e3_cal_fini ASC LIMIT 6
// Notifications debajo del menu izquierdo
if($res_cal){
    if(mysql_num_rows($res_cal) > 0){
        while($row_cal = mysql_fetch_array($res_cal)){
            if($row_cal[2] == 1){
                $tipo = "Notificacion";
                $label = "label-info";
                $icono = "fa fa-bullhorn";
            }
            if($row_cal[2] == 2){
                $tipo = "Festivo";
                $label = "label-danger";
                $icono = "fa fa-bed";
            }
            if($row_cal[2] == 3){
                $tipo = "Día Especial";
                $label = "label-warning";
                $icono = "fa fa-bicycle";
            }
            if($row_cal[2] == 4){
                $tipo = "Permiso";
                $label = "label-violet";
                $icono = "fa fa-heartbeat";
            }
            if($row_cal[2] == 5){
                $tipo = "Vacaciones";
                $label = "label-success";
                $icono = "fa fa-plane";
            }
            if($row_cal[2] == 6){
                $tipo = "Cumpleaños";
                $label = "label-cumple";
                $icono = "fa fa-birthday-cake";
            }?>
            
            <li name="<?php echo $row_cal[0];?>" li-user="<?php echo $row_cal[4];?>">
                <div class="col-left">
                    <span class="label <?php echo $label;?>">
                        <i class="<?php echo $icono; ?>"></i>
                    </span>
                </div>
                <div class="col-right with-margin">
                    <span class="message">
                        <?php echo getSubString($row_cal[1], 25);?>
                    </span>
                    <span class="time"><?php echo $tipo." ".substr($row_cal[3], 0, 10);?></span>
                </div>
            </li><?php 
        }
    }
}?>
<script>cargaNotificaciones();</script>