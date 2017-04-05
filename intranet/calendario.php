<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$where = "";
$fecha_ini_mes = date('Y-m-01 H:i:s');
if(isset($_GET['emp_id'])){
    $empleado = $_GET['emp_id'];
    // si el usurio tiene perfil diferente a RRHH hace esto
    if($_SESSION['user_perf'] <> '9'){
        // SQL que trae la empresa a la que esta asignado
        $res_emp = registroCampo("e3_cont", "e3_emp_id", "WHERE e3_user_id = '$empleado' AND (e3_cont_ffin = '0000-00-00' OR e3_cont_ffin IS NULL)", "", "");
        // Si se realiza la consulta correctamente hace esto
        if($res_emp){
            // validamos si hay resultados de la consulta
            if(mysql_num_rows($res_emp) > 0){
                // cargamos los resultados en una variable
                $row_emp = mysql_fetch_array($res_emp);
                $empresa = $row_emp[0];
                // si la empresa es tributar
                if($empresa == '1'){
                    $where = "WHERE (e3_cal_pub = '1' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$empresa%' OR e3_cal_emp LIKE '%2%' OR e3_cal_emp = '')))) OR (e3_cal_pub = '0' AND e3_cal_user = '$empleado')";
                }
                // si la empresa es coveg
                elseif($empresa == '2'){
                    $where = "WHERE (e3_cal_pub = '1' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$empresa%' OR e3_cal_emp LIKE '%1%' OR e3_cal_emp LIKE '%5%' OR e3_cal_emp = '')))) OR (e3_cal_pub = '0' AND e3_cal_user = '$empleado')";
                }
                // si la empresa es R + B
                elseif($empresa == '3'){
                    $where = "WHERE (e3_cal_pub = '1' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$empresa%' OR e3_cal_emp LIKE '%4%' OR e3_cal_emp = '')))) OR (e3_cal_pub = '0' AND e3_cal_user = '$empleado')";
                }
                // si la empresa es Editores
                elseif($empresa == '4'){
                    $where = "WHERE (e3_cal_pub = '1' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$empresa%' OR e3_cal_emp LIKE '%3%' OR e3_cal_emp = '')))) OR (e3_cal_pub = '0' AND e3_cal_user = '$empleado')";
                }
                else{
                    $where = "WHERE (e3_cal_pub = '1' AND ((e3_cal_tipo = '6') OR ((e3_cal_tipo = '1' OR e3_cal_tipo = '2' OR e3_cal_tipo = '3' OR e3_cal_tipo = '4' OR e3_cal_tipo = '5') AND (e3_cal_emp LIKE '%$empresa%' OR e3_cal_emp LIKE '%1%' OR e3_cal_emp LIKE '%2%' OR e3_cal_emp = '')))) OR (e3_cal_pub = '0' AND e3_cal_user = '$empleado')";
                }
            }
        }
    }
    // si el perfil de usuario es RRHH hace esto
    else{
        $where = "WHERE e3_cal_pub = '1'";
    }
}

// Este bloque lista los usuarios registrados como empleados en la aplicacion y valida si ya hay un registro en el calendario con la fecha de su cumpleaños, sino lo agrega para que este visible en el calendario.

// sql de cumpleaños empleados registrados en base de datos tabla usuarios
$res_cumple = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, u.e3_user_fnac, e.e3_emp_nom, u.e3_user_id", "LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE u.e3_est_id = '1' AND (e3_perf_id != '1' AND e3_perf_id != '6') AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)", "GROUP BY u.e3_user_id", "ORDER BY MONTH(u.e3_user_fnac) ASC, DAY(u.e3_user_fnac) ASC");

// SELECT u.e3_user_nom, u.e3_user_ape, u.e3_user_fnac, u.e3_user_emp, u.e3_user_img, u.e3_est_id, e.e3_emp_nom, u.e3_perf_id FROM e3_user u LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE u.e3_est_id = '1' AND (e3_perf_id != '1' AND e3_perf_id != '6') AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL) GROUP BY u.e3_user_id ORDER BY MONTH(u.e3_user_fnac) ASC, DAY(u.e3_user_fnac) ASC

// si se realiza la consulta sql correctamente hace esto
if($res_cumple){
    // Si se encuentran datos hace esto
    if(mysql_num_rows($res_cumple) > 0){
        // para cada dato hace esto
        while($row_cumple = mysql_fetch_array($res_cumple)){
            $empresa_cumple = "";
            $nom_cumple = $row_cumple[0] . " " . $row_cumple[1];
            if($row_cumple[3] <> ''){
                $empresa_cumple = " (" . $row_cumple[3] . ")";
            }  
            $obs_cumple = "Felicita a " . $row_cumple[0] . " " . $row_cumple[1] . $empresa_cumple . " porque hoy es su día de cumpleaños.";
            $exp_fecha = explode("-", $row_cumple[2]);
            $anio_hoy = date('Y');
            $fecha_hoy = date('Y-m-d H:i:s');
            $fch_cumple_ini = $anio_hoy . "-" . $exp_fecha[1] . "-" . $exp_fecha[2] . " 00:00:00";
            $fch_cumple_fin = $anio_hoy . "-" . $exp_fecha[1] . "-" . $exp_fecha[2] . " 23:59:59";
            $tip_cumple = "6";
            $img_cumple = "../img/calendario/cumple.jpg";
            $emp_cumple = $row_cumple[4];

            // sql que valida si ya existe un registro de cumpleaños para ese año de ese usuario
            $res_existe = registroCampo("e3_cal", "e3_cal_id", "WHERE e3_cal_nom = '$nom_cumple' AND e3_cal_fini = '$fch_cumple_ini' AND e3_cal_ffin = '$fch_cumple_fin' AND e3_cal_tipo = '$tip_cumple'", "", "ORDER BY e3_cal_fini ASC");
            if($res_existe){
                if(mysql_num_rows($res_existe) <= 0){
                    $sql = "INSERT INTO e3_cal (e3_cal_nom, e3_cal_tipo, e3_cal_fini, e3_cal_ffin, e3_cal_emp, e3_cal_file, e3_cal_obs, e3_cal_fecha, e3_cal_user, e3_cal_pub) VALUES ('$nom_cumple', '$tip_cumple', '$fch_cumple_ini', '$fch_cumple_fin', '$emp_cumple', '$img_cumple', '$obs_cumple', '$fecha_hoy', '1', '1')";
                    $query = mysql_query($sql, conexion());
                }
            }
        }
    }
}

// SQL para traer las solicitudes de permisos y vacaciones de los empleados aprobadas
$res_solic = registroCampo("e3_solic s", "s.e3_tsolic_id, e.e3_emp_id, e.e3_emp_nom, u.e3_user_nom, u.e3_user_ape, s.e3_solic_fini, s.e3_solic_ffin, s.e3_solic_fint, s.e3_solic_ndias, s.e3_solic_ndiasp, s.e3_solic_obs, s.e3_solic_det, s.e3_solic_rep, s.e3_solic_det_rep, s.e3_solic_obs_rrhh, s.e3_solic_tperm, s.e3_user_id", "LEFT JOIN e3_user u USING(e3_user_id) LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE s.e3_est_id <= 3 AND (s.e3_tsolic_id = '1' OR s.e3_tsolic_id = '2') AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL) AND s.e3_solic_fini != '0000-00-00 00:00:00'", "", "ORDER BY s.e3_solic_fini ASC");
// SELECT s.e3_tsolic_id, e.e3_emp_id, e.e3_emp_nom, u.e3_user_nom, u.e3_user_ape, s.e3_solic_fini, s.e3_solic_ffin, s.e3_solic_fint, s.e3_solic_ndias, s.e3_solic_ndiasp, s.e3_solic_obs, s.e3_solic_det, s.e3_solic_rep, s.e3_solic_det_rep, s.e3_solic_obs_rrhh, s.e3_solic_tperm FROM `e3_solic` s LEFT JOIN e3_user u USING(e3_user_id) LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE s.e3_est_id = '1' AND (s.e3_tsolic_id = '1' OR s.e3_tsolic_id = '2') AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL) AND s.e3_solic_fini != '0000-00-00 00:00:00' ORDER BY s.e3_solic_fini ASC

// si se realiza la consulta sql correctamente hace esto
if($res_solic){
    // Si se encuentran datos hace esto
    if(mysql_num_rows($res_solic) > 0){
        // $sql_delete = "DELETE FROM e3_cal WHERE (e3_cal_tipo = '4' OR e3_cal_tipo = '5')";
        // $res_delete = mysql_query($sql_delete, conexion());
        // para cada dato hace esto
        while($row_solic = mysql_fetch_array($res_solic)){
            $nom_solic = "";
            $empresa_solic = "";
            $observa_permiso = "";
            $descrip_permiso = "";
            $tipo_permiso = "";
            $repone_permiso = "";
            $historial_permiso = "";
            $personal_permiso = "";
            $obs_solic = "";
            $fint_permiso = "";
            $diasd_permiso = "";
            $diasp_permiso = "";
            // Nombres y apellidos del empleado
            $nom_solic = $row_solic[3] . " " . $row_solic[4];
            // Nombre de la empresa del empleado
            if($row_solic[2] <> ''){
                $empresa_solic = " (" . $row_solic[2] . ")";
            }
            // empresa que visualizara el registro
            if(($row_solic[1] <> '') && ($row_solic[1] <> NULL)){$emp_solic = $row_solic[1];}
            else{$emp_solic = "3";}
            
            // fecha en que se ingresa el registro
            $fecha_hoy = date('Y-m-d H:i:s');

            // si el tipo de la solicitud es permiso (1) hace esto
            if($row_solic[0] == '1'){
                $tip_solic = "4";
                // fecha de inicio permiso o vacaciones
                $fch_solic_ini = $row_solic[5];
                // fecha final de permiso o vacaciones
                $fch_solic_fin = $row_solic[6];
                $img_solic = "../img/calendario/permiso.jpg";
                if($row_solic[10] <> ''){$observa_permiso = "Observación: " . $row_solic[10] . "<br>";}
                if($row_solic[11] <> ''){$descrip_permiso = "Descripción: " . $row_solic[11] . "<br>";}
                if($row_solic[12] <> ''){
                    if($row_solic[12] == '1'){$val_permiso = "Remunerado";}
                    elseif($row_solic[12] == '2'){$val_permiso = "NO Remunerado";}
                    elseif($row_solic[12] == '3'){$val_permiso = "Licencia";}
                    else{$val_permiso = "Incapacidad";}
                    $tipo_permiso = "Tipo de permiso: " . $val_permiso . "<br>";
                }
                if($row_solic[13] <> ''){$repone_permiso = "Repone: " . $row_solic[13] . "<br>";}
                if($row_solic[14] <> ''){$historial_permiso = "Historial: " . $row_solic[14] . "<br>";}
                if($row_solic[15] <> ''){
                    if($row_solic[15] == '1'){$val_personal = "Personal";}
                    else{$val_personal = "Médico";}
                    $personal_permiso = "Persona / Médico: " . $val_personal . "<br>";
                }
                
                $obs_solic = $tipo_permiso;
                // $obs_solic = $tipo_permiso . $repone_permiso . $personal_permiso . $descrip_permiso . $observa_permiso . $historial_permiso;
            }
            // si el tipo de solicitud es vacaciones (2) hace esto
            else{
                $tip_solic = "5";
                // fecha de inicio permiso o vacaciones
                $fch_solic_ini = date('Y-m-d H:i:s', strtotime($row_solic[5] . '+ 7 hours'));
                // fecha final de permiso o vacaciones
                $fch_solic_fin = date('Y-m-d H:i:s', strtotime($row_solic[6] . '+ 17 hours + 30 minutes'));
                $img_solic = "../img/calendario/vacas.jpg";
                if($row_solic[7] <> ''){$fint_permiso = "Fecha de Reintegro: " . $row_solic[7] . "<br>";}
                if($row_solic[8] <> ''){$diasd_permiso = "No. Días Disfrutados: " . $row_solic[8] . "<br>";}
                if($row_solic[9] <> ''){$diasp_permiso = "No. Días Pagados: " . $row_solic[9] . "<br>";}
                if($row_solic[10] <> ''){$observa_permiso = "Observación: " . $row_solic[10] . "<br>";}
                if($row_solic[14] <> ''){$historial_permiso = "Historial: " . $row_solic[14] . "<br>";}
                
                $obs_solic = $fint_permiso;
                // $obs_solic = $fint_permiso . $diasd_permiso . $diasp_permiso . $observa_permiso . $historial_permiso;
            }

            // sql que valida si ya existe un registro de permiso o vaciones para ese año de ese usuario en el calendario
            $res_existe_solic = registroCampo("e3_cal", "e3_cal_id", "WHERE e3_cal_nom = '$nom_solic' AND e3_cal_fini = '$fch_solic_ini' AND e3_cal_ffin = '$fch_solic_fin' AND e3_cal_tipo = '$tip_solic'", "", "ORDER BY e3_cal_fini ASC");
            if($res_existe_solic){
                if(mysql_num_rows($res_existe_solic) <= 0){
                    $sql = "INSERT INTO e3_cal (e3_cal_nom, e3_cal_tipo, e3_cal_fini, e3_cal_ffin, e3_cal_emp, e3_cal_file, e3_cal_obs, e3_cal_fecha, e3_cal_user, e3_cal_pub) VALUES ('$nom_solic', '$tip_solic', '$fch_solic_ini', '$fch_solic_fin', '$emp_solic', '$img_solic', '$obs_solic', '$fecha_hoy', '1', '1')";
                    // if($row_solic[16] == '32'){
                    //     echo "XXX ".$sql." XXX";
                    // }
                    $query = mysql_query($sql, conexion());
                }
            }
        }
    }
}

// sql eventos registrados en base de datos tabla calendario
$res = registroCampo("e3_cal", "e3_cal_id, e3_cal_nom, e3_cal_tipo, e3_cal_fini, e3_cal_ffin, e3_cal_emp, e3_cal_user", "$where", "", "ORDER BY e3_cal_tipo DESC");
// Iniciamos la variable que alamcenara los eventos tipo array
$array_events = "";
// si se ejecuta correctamente el sql hace esto
if($res){
    // si existen registros en la tabla hace esto
	if(mysql_num_rows($res) > 0){
        // inicializamos un contador para manejar la separacion de los registros
		$sq = 1;
        // para cada registro hace esto
		while($row = mysql_fetch_array($res)){
			$id = $row[0];
			$nom = $row[1];
			$tipo = $row[2];
			$fini = str_replace(" ", "T", $row[3]);
			$ffin = str_replace(" ", "T", $row[4]);;
			$emp = $row[5];
            $user = $row[6];
            // si el tipo de evento es notificacion hace esto
			if($tipo == '1'){
				$array_events .= "{id:".$id.", title:'".$nom."', start:'".$fini."', end:'".$ffin."', className:'".$user."', color:'#257e4a', backgroundColor:'#2F96B4'}";

			}
            // si el tipo de evento es día festivo hace esto
			elseif($tipo == '2'){
				$array_events .= "{id:".$id.", title:'".$nom."', start:'".date('Y-m-d', strtotime($fini))."', end:'".date('Y-m-d', strtotime($ffin))."', className:'".$user."', overlap:false, rendering:'background', color:'#BD362F', allDay: true}";
			}
            // si el tipo de evento es permisos hace esto
            elseif($tipo == '4'){
                $array_events .= "{id:".$id.", title:'".$nom."', start:'".$fini."', end:'".date('Y-m-d H:i:s', strtotime($ffin . '+ 1 days'))."', className:'".$user."', color:'#257e4a', backgroundColor:'#591FFF', allDay: true}";

            }
            // si el tipo de evento es vacaciones hace esto
            elseif($tipo == '5'){
                $array_events .= "{id:".$id.", title:'".$nom."', start:'".$fini."', end:'".date('Y-m-d H:i:s', strtotime($ffin . '+ 1 days'))."', className:'".$user."', color:'#257e4a', backgroundColor:'#5cb85c', allDay: true}";

            }
            // si el tipo de evento es cunpleaños hace esto
            elseif($tipo == '6'){
                $array_events .= "{id:".$id.", title:'".$nom."', start:'".$fini."', end:'".$ffin."', className:'".$user."', color:'#257e4a', backgroundColor:'#B42F94', allDay: true}";

            }
            // si el tipo de evento es día especial hace esto
			else{
				$array_events .= "{id:".$id.", title:'".$nom."', start:'".$fini."', end:'".$ffin."', className:'".$user."', color:'#257e4a', backgroundColor:'#F89406', allDay: true}";
			}
			if($sq < mysql_num_rows($res)){$array_events .= ",";}
			$sq++;
		}
	}
}

$evetos_base = json_encode($array_events);
if(isset($_GET['tipo'])){$tipo = $_GET['tipo'];}
else{$tipo = 1;}
if(isset($_GET['date'])){$dates = date('m-d-Y H:i', strtotime($_GET['date']));}
else{$dates = "";}
// echo $evetos_base;
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Tenga en cuenta!</strong> Seleccione el tipo de Notificación, Festivo o Día Especial que agregará al calendario si no hace click en ninguna de las opciones por defecto creará una notificación.
	</div>
</div>
<div class="widget hidden-xs hidden-sm hidden-md">
    <!-- tipo de calendario por default o el enviado por get -->
    <input class="form-control" type="hidden" id="tipo_cal" value="<?php echo $tipo;?>">
</div>
<!-- Botones para tipo de calendario a ingresar, editar o eliminar -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 btn_tipo hidden">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
		<button class="btn-cal btn btn-info" name="1" type="button" disabled="disabled">
            <span class="hidden-xs">Nuevo </span>
            <span>Evento</span>
        </button>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center text-center">
		<button class="btn-cal btn btn-danger" name="2" type="button" disabled="disabled">
            <span class="hidden-xs">Nuevo </span>
            <span>Festivo</span>
        </button>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
		<button class="btn-cal btn btn-warning" name="3" type="button" disabled="disabled">
            <span class="hidden-xs">Nuevo Día </span>
            <span>Especial</span>
        </button>
	</div>
</div>
<!-- espacio superior del calendario entre botones y calendario -->
<div class="widget hidden-xs hidden-sm hidden-md"></div>
<!-- contenedor del calendario -->
<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-8">
	<div class="widget hidden-xs hidden-sm"></div>
	<div id='calendar'></div>
    <div class="widget"></div>
</div>
<!-- nomenglatura con iconos de colores calendario -->
<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-2">
    <div class="widget visible-lg">&nbsp;</div>
    <div class="widget visible-lg">&nbsp;</div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-info" style="font-size: 1.5em;">&nbsp;<i class="fa fa-bullhorn"></i>&nbsp;</span>
        <span class="message">
            <strong>Notificaciones</strong>
        </span>
        <div class="widget"></div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-danger" style="font-size: 1.5em;">&nbsp;<i class="fa fa-bed"></i>&nbsp;</span>
        <span class="message">
            <strong>Festivos</strong>
        </span>
        <div class="widget"></div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-warning" style="font-size: 1.5em;">&nbsp;<i class="fa fa-bicycle"></i>&nbsp;</span>
        <span class="message">
            <strong>Días Especiales</strong>
        </span>
        <div class="widget"></div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-success" style="font-size: 1.5em;">&nbsp;<i class="fa fa-plane"></i>&nbsp;</span>
        <span class="message">
            <strong>Vacaciones</strong>
        </span>
        <div class="widget"></div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-violet" style="font-size: 1.5em;">&nbsp;<i class="fa fa-heartbeat"></i>&nbsp;</span>
        <span class="message">
            <strong>Permisos</strong>
        </span>
        <div class="widget"></div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-12">
        <span class="nomenglatura label label-cumple" style="font-size: 1.5em;">&nbsp;<i class="fa fa-birthday-cake"></i>&nbsp;</span>
        <span class="message">
            <strong>Cumpleaños</strong>
        </span>
        <div class="widget"></div>
    </div>
</div>
<script src="../js/jquery.min.js"></script>
<script src='../js/moment.min.js'></script>
<script src='../js/fullcalendar.js'></script>
<script src='../js/lang-all.js'></script>
<script src='../js/gcal.js'></script>
<script>
    $(document).on('ready', dibujaCalendario);
    var eventos = [<?php echo $array_events;?>];
    function dibujaCalendario() {
        var dates = '<?php echo $dates;?>';
        if(dates.length < 1){
            var dates = new Date();
        }
        else{
            dates = dates.replace(/\-/g, ',');
            dates = new Date(dates);
            
        }
        dateString = dates;
        // (date.getMonth() + 1) + "-" + date.getDate() + "-" + date.getFullYear().toString().substr(2,2);
        var currentLangCode = 'es';
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: dateString,
            lang: currentLangCode,
            buttonIcons: true, // show the prev/next text
            weekNumbers: false,
            businessHours: true, // display business hours
            displayEventStart: true,
            displayEventEnd: true,
            eventLimit: true,
            editable: false,
            events: eventos,
            // googleCalendarApiKey: 'AIzaSyApzprYqb-1QoZA90Tnwc8_BvYbR_OmhXg',
            // eventSources: [
            //     {
            //         googleCalendarId: 'info@editoreshache.com'
            //     }
            // ],
            dayClick: function(date, jsEvent, view) {
                var tipocal = $("#tipo_cal").val();
                var si = "";
                // si el tipo de calendario es festivo hace esto
                if(tipocal === '2'){
                    if(eventos.length > 0){
                        for(var i = 0; i < eventos.length; i++){
                            if((eventos[i]['title'] === 'Festivo') && (eventos[i]['start'] === date.format())){
                                si = i;
                            }
                        }
                    }
                    // si ya existe un evento de dia festivo en la fecha indicada puede borrarlo
                    if(si !== ''){
                        si += 0;
                        var id_evento = eventos[si]['id'];
                        var ini_evento = eventos[si]['start'];
                        var className = eventos[si]['className'];
                        // si el usuario lo creo puede borrarlo
                        if(className === sess_id){
                            swal({
                                title: "¿Esta Seguro?",
                                text: "Se borrará el Festivo del día "+ini_evento,
                                type: "error",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonColor: "#BD362F",
                                confirmButtonText: "Eliminar!",
                                closeOnConfirm: true
                            },
                            function(){
                                $.ajax({
                                    url:"../php/ins_upd_cal.php",
                                    cache:false,
                                    type:"POST",
                                    data:"id_sup="+id_evento,
                                    success: function(datos){
                                        if(datos !== ''){
                                            swal({
                                                title: "Felicidades!",
                                                text: "El registro se ha eliminado correctamente!",
                                                type: "success",
                                                confirmButtonText: "Continuar",
                                                confirmButtonColor: "#94B86E"
                                            });
                                        }
                                        else{
                                            swal({
                                                title: "Error!",
                                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                                type: "error",
                                                confirmButtonText: "Aceptar",
                                                confirmButtonColor: "#E25856"
                                            });
                                            return;
                                        }
                                        $("#col-md-12").load("calendario.php?tipo="+tipocal+"&date="+ini_evento);
                                    }
                                });
                            });
                        }
                        // si no fue quien lo creo se mostrara este mensaje
                        else{
                            swal({
                                title: "Atención!",
                                text: "No puede editar o borrar este evento",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                        }
                    }
                    else{
                        // solo el perfil de RRHH o MASTER puede borrar un festivo
                        if((sess_perf === '9') || (sess_perf === '1')){
                            var ini_evento = date.format();
                            var nom_evento = "Festivo";
                            var tip_evento = tipocal;
                            swal({
                                title: "¿Esta Seguro?",
                                text: "Se marcará el día "+ini_evento+" como Festivo",
                                type: "warning",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonColor: "#F89406",
                                confirmButtonText: "Agregar!",
                                closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url:"../php/ins_upd_cal.php",
                                    cache:false,
                                    type:"POST",
                                    data:"e3_cal_nom="+nom_evento+"&e3_cal_tipo="+tip_evento+"&e3_cal_fini="+ini_evento+"&e3_cal_ffin="+ini_evento,
                                    success: function(datos){
                                        if(datos !== ''){
                                            $("#col-md-12").load("calendario.php?tipo="+tipocal+"&date="+ini_evento);
                                            swal({
                                                title: "Felicidades!",
                                                text: "El registro se ha agregado correctamente!",
                                                type: "success",
                                                confirmButtonText: "Continuar",
                                                confirmButtonColor: "#94B86E"
                                            });
                                        }
                                        else{
                                            swal({
                                                title: "Error!",
                                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                                type: "error",
                                                confirmButtonText: "Aceptar",
                                                confirmButtonColor: "#E25856"
                                            });
                                            return;
                                        }
                                    }
                                });
                            });
                        }
                        // si es un perfil diferente a master o RRHH vera esto 
                        else{
                            swal({
                                title: "Atención!",
                                text: "No puede agregar días festivos, comuniquese con el administrador del sistema",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                        }
                    }
                    $(this).toggleClass('fc-event');
                }
                // si el tipo de evento no es dia festivo hace esto
                else{
                    var tip_evento = tipocal;
                    var ini_evento = date.format();
                    $(".ing-cal").load("cal_evento.php?tipo="+tip_evento+"&start="+ini_evento);
                    $(".ing-cal").removeClass('hidden');
                }
            },
            eventClick: function(calEvent, jsEvent, view) {
                // alert('Id: ' + calEvent.id);
                // alert('Title: ' + calEvent.title);
                // alert('Start: ' + calEvent.start.format());
                // alert('End: ' + calEvent.end.format());

                var tipocal = $("#tipo_cal").val();
                var si = "";
                // Si el tipo de calendario es festivo
                if(tipocal === '2'){
                    if(eventos.length > 0){
                        for(var i = 0; i < eventos.length; i++){
                            if((eventos[i]['title'] === 'Festivo') && (eventos[i]['start'] === calEvent.start.format())){
                                si = i;
                            }
                        }
                    }
                    // si existe un evento de dia festivo en la fechga indicada hace esto
                    if(si !== ''){
                        var id_evento = eventos[si]['id'];
                        var ini_evento = eventos[si]['start'];
                        var className = eventos[si]['className'];
                        // si el usuario fue quien lo creo puede borrarlo
                        if(className === sess_id){
                            swal({
                                title: "¿Esta Seguro?",
                                text: "Se borrará el Festivo del día "+ini_evento,
                                type: "error",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonColor: "#BD362F",
                                confirmButtonText: "Eliminar!",
                                closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url:"../php/ins_upd_cal.php",
                                    cache:false,
                                    type:"POST",
                                    data:"id_sup="+id_evento,
                                    success: function(datos){
                                        if(datos !== ''){
                                            swal({
                                                title: "Felicidades!",
                                                text: "El registro se ha eliminado correctamente!",
                                                type: "success",
                                                confirmButtonText: "Continuar",
                                                confirmButtonColor: "#94B86E"
                                            });
                                        }
                                        else{
                                            swal({
                                                title: "Error!",
                                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                                type: "error",
                                                confirmButtonText: "Aceptar",
                                                confirmButtonColor: "#E25856"
                                            });
                                            return;
                                        }
                                        $("#col-md-12").load("calendario.php?tipo="+tipocal+"&date="+calEvent.start.format());
                                    }
                                });
                            });
                        }
                        // si no fue quien lo creo vera esto
                        else{
                            swal({
                                title: "Atención!",
                                text: "No puede agregar, editar y/o borrar días festivos, comuníquese con el administrador del sistema",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                        }
                    }
                    // si no existe un evento de dia festivo en la fecha indicada podra crear uno nuevo
                    else{
                        // solo los perfiles de RRHH y MASTER puede agregar dias festivos
                        if((sess_perf === '9') || (sess_perf === '1')){
                            var ini_evento = calEvent.start.format();
                            var nom_evento = "Festivo";
                            var tip_evento = tipocal;
                            swal({
                                title: "¿Esta Seguro?",
                                text: "Se marcará el día "+ini_evento+" como Festivo",
                                type: "warning",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonColor: "#F89406",
                                confirmButtonText: "Agregar!",
                                closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    url:"../php/ins_upd_cal.php",
                                    cache:false,
                                    type:"POST",
                                    data:"e3_cal_nom="+nom_evento+"&e3_cal_tipo="+tip_evento+"&e3_cal_fini="+ini_evento+"&e3_cal_ffin="+ini_evento,
                                    success: function(datos){
                                        if(datos !== ''){
                                            swal({
                                                title: "Felicidades!",
                                                text: "El registro se ha agregado correctamente!",
                                                type: "success",
                                                confirmButtonText: "Continuar",
                                                confirmButtonColor: "#94B86E"
                                            });
                                        }
                                        else{
                                            swal({
                                                title: "Error!",
                                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                                type: "error",
                                                confirmButtonText: "Aceptar",
                                                confirmButtonColor: "#E25856"
                                            });
                                            return;
                                        }
                                        $("#col-md-12").load("calendario.php?tipo="+tipocal+"&date="+calEvent.start.format());
                                    }
                                });
                            });
                        }
                        // si es un perfil diferente a master y RRHH vera esto 
                        else{
                            swal({
                                title: "Atención!",
                                text: "No puede agregar, editar y/o borrar días festivos, comuníquese con el administrador del sistema",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                        }
                    }
                }
                // si el tipo de calendario es diferente a dia festivo hace esto
                else{
                    var tip_evento = tipocal;
                    var className = calEvent.className;
                    // si el usuario que esta consultando es el mismo que lo creo puede editar o eliminar el evento
                    if(parseInt(className) === parseInt(sess_id)){
                        var ini_evento = calEvent.start.format();
                        swal({
                            title: "¿Que desea hacer?",
                            text: "Eliminar el evento o editarlo",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: "Eliminar",
                            confirmButtonColor: "#F89406",
                            confirmButtonText: "Editar!",
                            closeOnConfirm: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $(".ing-cal").load("cal_evento.php?id="+calEvent.id);
                                $(".ing-cal").removeClass('hidden');
                            }
                            else {
                                $.ajax({
                                    url:"../php/ins_upd_cal.php",
                                    cache:false,
                                    type:"POST",
                                    data:"id_sup="+calEvent.id,
                                    success: function(datos){
                                        if(datos !== ''){
                                            swal({
                                                title: "Felicidades!",
                                                text: "El registro se ha eliminado correctamente!",
                                                type: "success",
                                                confirmButtonText: "Continuar",
                                                confirmButtonColor: "#94B86E"
                                            });
                                        }
                                        else{
                                            swal({
                                                title: "Error!",
                                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                                type: "error",
                                                confirmButtonText: "Aceptar",
                                                confirmButtonColor: "#E25856"
                                            });
                                            return;
                                        }
                                        $("#col-md-12").load("calendario.php?tipo="+tipocal+"&date="+calEvent.start.format());
                                    }
                                });
                            }
                        });
                    }
                    // si el usuario no lo creo solo puede consultar la información
                    else{
                        $(".ing-cal").load("cal_ver_evento.php?id="+calEvent.id);
                        $(".ing-cal").removeClass('hidden');
                    }
                }
            }
        });
    }
</script>
<script>cargarCalendario()</script>
