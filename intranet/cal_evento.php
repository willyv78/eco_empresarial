<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$id_even = "";
$nom_even = "";
$tipo_even = "";
$tip_even = "";
$fini_even = "";
$ffin_even = "";
$emp_even = "";
$file_even = "";
$obs_even = "";
$fecha_even = "";
$user_even = "";
$pub_even = "";
if(isset($_GET['id'])){
    $res = registroCampo("e3_cal", "*", "WHERE e3_cal_id = '".$_GET['id']."'", "", "");
    if($res){
        if(mysql_num_rows($res) > 0){
            $row = mysql_fetch_array($res);
            $id_even = $row[0];
            $nom_even = $row[1];
            $tipo_even = $row[2];
            if($tipo_even == '1'){$tip_even = "Notificación";}
            elseif($tipo_even == '2'){$tip_even = "Festivo";}
            elseif($tipo_even == '3'){$tip_even = "Día Especial";}
            elseif($tipo_even == '4'){$tip_even = "Permiso";}
            elseif($tipo_even == '5'){$tip_even = "Vacaciones";}
            else{$tip_even = "Cumpleaños";}
            $fini_even = date('Y-m-d H:i', strtotime($row[3]));
            $ffin_even = date('Y-m-d H:i', strtotime($row[4]));
            $emp_even = $row[5];
            $file_even = $row[6];
            $obs_even = $row[7];
            $fecha_even = $row[8];
            $user_even = $row[9];
            $pub_even = $row[10];
        }
    }
}
if((isset($_GET['tipo'])) && (isset($_GET['start']))){
    if($_GET['tipo'] == '1'){$tip_even = "Notificación";}
    elseif($_GET['tipo'] == '2'){$tip_even = "Festivo";}
    elseif($_GET['tipo'] == '3'){$tip_even = "Día Especial";}
    elseif($_GET['tipo'] == '4'){$tip_even = "Permiso";}
    elseif($_GET['tipo'] == '5'){$tip_even = "Vacaciones";}
    else{$tip_even = "Cumpleaños";}
    $tipo_even = $_GET['tipo'];
    // $fini_even = $_GET['start'];
    $fini_even = date('Y-m-d 07:00', strtotime($_GET['start']));
    // $fecha_date = new DateTime('now', 'America/Bogota');
    // $ffecha_date = $fecha_date->format('c');
    $ffin_even = date('Y-m-d 17:30', strtotime($_GET['start']));;
    // $fini_even = date('m-d-Y H:i', strtotime($_GET['start']));
}
// echo $ffecha_date;
?>
<div class="col-xs-11 col-sm-10 col-md-8 col-lg-6">
    <form class="form-horizontal" id="form_cal" action="" method="POST" role="form" enctype="multipart/form-data">
        <div class="form-group text-left">
            <legend><?php echo $tip_even; ?></legend>
            <!-- <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_vacaciones"> -->
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_nom">Título:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <input id="e3_cal_nom" type="text" name="e3_cal_nom" class="form-control" value="<?php echo $nom_even; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_fini">Fecha Inicio:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 input-group date">
                <input class="form-control" id="e3_cal_fini" type="text" name="e3_cal_fini" value="<?php echo $fini_even; ?>">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_ffin">Fecha Final:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 input-group date">
                <input class="form-control" id="e3_cal_ffin" type="text" name="e3_cal_ffin" value="<?php echo $ffin_even; ?>">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_emp">Empresa(s):</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 text-left">
                <?php 
                $dat_emp = explode(",", $emp_even);
                $num_emp = count($dat_emp);
                // echo count($emp_even);
                $res_emp = registroCampo("e3_emp", "e3_emp_id, e3_emp_nom", "", "", "");
                if($res_emp){
                    if(mysql_num_rows($res_emp) > 0){?>
                        <div class="checkbox-emp">
                            <label>
                                <input id="e3_cal_emp_0" type="checkbox" <?php if($num_emp >= mysql_num_rows($res_emp)){echo "checked";}?> name="e3_cal_todos" value="0">
                                Todas
                            </label>
                        </div><?php 
                        while($row_emp = mysql_fetch_array($res_emp)){
                            $checke = "";
                            for($i = 0; $i < $num_emp; $i++){
                                if($dat_emp[$i] == $row_emp[0]){$checke = "checked";}
                            }?>
                            <div class="checkbox-emp">
                                <label>
                                    <input id="e3_cal_emp_<?php echo $row_emp[0]; ?>" type="checkbox" <?php echo $checke;?> name="e3_cal_emp[]" value="<?php echo $row_emp[0]; ?>">
                                    <?php echo substr($row_emp[1],0,26); ?>
                                </label>
                            </div>
                        <?php 
                        }
                    }
                }?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_file">Imagen:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><?php 
            if($file_even <> ''){?>
                <img class="img-responsive" src="<?php echo $file_even; ?>" alt="Image" width="60%" style="margin: auto;"><?php
            }?>
            <input class="form-control" type="file" name="e3_cal_file" id="e3_cal_file" placeholder="Imagen para mostrar en la notificación" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_obs">Observación:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <textarea id="e3_cal_obs" name="e3_cal_obs" class="form-control" rows="3" placeholder="Realice una observación en 250 caractéres"><?php echo $obs_even; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label" for="e3_cal_pub">Visibilidad:</label>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div class="checkbox-emp">
                    <label>
                        <input id="e3_cal_pub_pub" type="radio" <?php if(($pub_even == '1') || ($pub_even == '')){echo "checked='checked'";}?> name="e3_cal_pub" value="1"> Público
                    </label>
                </div>
                <div class="checkbox-emp">
                    <label>
                        <input id="e3_cal_pub_pri" type="radio" <?php if($pub_even == '0'){echo "checked='checked'";}?> name="e3_cal_pub" value="0"> Privado
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <input class="form-control" type="hidden" name="e3_cal_tipo" id="e3_cal_tipo" value="<?php echo $tipo_even; ?>"><?php 
            if(isset($_GET['id'])){?>
                <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $_GET['id'];?>">
                <button type="submit" class="btn btn-success">Actualizar</button><?php 
            }
            else{?>
                <button type="submit" class="btn btn-success">Guardar</button><?php

            }?>
            <button type="buttom" class="btn btn-default">Cancelar</button>
        </div>
    
    </form>
</div>
<!-- Datetimepicker -->
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
<!-- Libreria java script que realiza la validacion de los formularios -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function() {
        var tipocal = $("#e3_cal_tipo").val();
        $('#form_cal').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_cal_nom: {
                    message: 'El título del evento no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El título del evento es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El título del evento debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .:,#@%]+$/,
                            message: 'El título del evento debe contener letras.'
                        }
                    }
                },
                e3_cal_fini: {
                    message: 'La fecha de inicio del evento no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La fecha de inicio del evento es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD h:m',
                            message: 'La fecha de inicio del evento no es valida'
                        }
                    }
                },
                e3_cal_ffin: {
                    message: 'La fecha final del evento no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La fecha final del evento es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD h:m',
                            message: 'La fecha final del evento no es valida'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            espereshow ();
            // Prevent form submission
            e.preventDefault();
            var dates = $("#e3_cal_fini").val();
            dates = dates.split(' ');
            dates = dates[0].replace(/\-/g, ',');
            dates = new Date(dates);
            dates = dates.getFullYear() + "-" + (dates.getMonth() + 1) + "-" + dates.getDate();
            dateString = dates;
            var datos_form = new FormData($("#form_cal")[0]);
            $.ajax({
                url:"../php/ins_upd_cal.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    $(".ing-cal").html("");
                    $(".ing-cal").addClass('hidden');
                    setTimeout(esperehide, 500);
                    if(datos !== ''){
                        swal({
                            title: "Felicidades!",
                            text: "El registro se ha guardado correctamente!",
                            type: "success",
                            confirmButtonText: "Continuar",
                            confirmButtonColor: "#94B86E"
                        },
                        function(){
                            $("#col-md-12").load("./calendario.php?tipo="+tipocal+"&date="+dateString+"&emp_id="+sess_id);
                            $(".notifications").load("notificaciones.php");
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
    });
</script>
<script>
    $(function () {
        $('#e3_cal_fini').datetimepicker();
        $('#e3_cal_ffin').datetimepicker();
    });
    editEvento();
</script>