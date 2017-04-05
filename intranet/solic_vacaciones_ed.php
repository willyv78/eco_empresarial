<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// Variables por defecto
$fsolic = date('Y-m-d H:i');$fini = "";$ffin = "";$fint = "";$obs = "";$user = "";$ndias = "";$ndiasp = "";$exp_id = "";$emp_nom = "";$emp_ape = "";$emp_carg = "";$emp_doc = "";$emp_fing = "";$cont_id = "";$disabled = "";$sess_perf = $_SESSION['user_perf'];$emp_email = "";$emp_emp = "";$sess_id = $_SESSION['user_id'];
// Valida si se envio la variable id de la solicitud
if(isset($_GET["exp_id"])){
    $exp_id = $_GET["exp_id"];
    // Consulta la solicitud por numero de id
    $res_bus = registroCampo("e3_solic", "e3_solic_id, e3_solic_fsolic, e3_solic_fini, e3_solic_ffin, e3_solic_tperm, e3_solic_fint, e3_solic_ndias, e3_solic_ndiasp, e3_solic_obs, e3_user_id, e3_cont_id, e3_est_id, e3_solic_obs_rrhh, e3_solic_obs_jefe", "WHERE e3_solic_id = '$exp_id'", "", "ORDER BY e3_solic_fini DESC");
    // $res_bus = otrosDatos2($exp_id, 'e3_solic');
    if($res_bus)
    {
        if(mysql_num_rows($res_bus) > 0)
        {
            $row = mysql_fetch_array($res_bus);
            $fsolic = date('Y-m-d H:i', strtotime($row[1]));
            if(($row[2] <> '') && ($row[2] <> '0000-00-00 00:00:00')){$fini = date('Y-m-d', strtotime($row[2]));}
            if(($row[3] <> '') && ($row[3] <> '0000-00-00 00:00:00')){$ffin = date('Y-m-d', strtotime($row[3]));}
            if(($row[5] <> '') && ($row[5] <> '0000-00-00 00:00:00')){$fint = date('Y-m-d', strtotime($row[5]));}
            $ndias = $row[6];
            $ndiasp = $row[7];
            $obs = $row[8];
            $user = $row[9];
            $cont_id = $row[10];
            $est = $row[11];
            $obs_rrhh = $row[12];
            $obs_jefe = $row[13];
        }
    }
}

// Valida si se envio el id del empleado para traer la informacion.
if(isset($_GET["id_emp"])){
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_doc, u.e3_user_fing, u.e3_user_id, u.e3_user_email, c.e3_emp_id, u.e3_perf_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '".$_GET["id_emp"]."'", "", "");
}
else{
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_doc, u.e3_user_fing, u.e3_user_id, u.e3_user_email, c.e3_emp_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '$user' AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)", "", "");
}
if($res_emp){
    if(mysql_num_rows($res_emp) > 0){
        $row_emp = mysql_fetch_array($res_emp);
        $emp_nom = $row_emp[0];
        $emp_ape = $row_emp[1];
        $emp_carg = nombreCampo($row_emp[2], "e3_carg");
        $emp_doc = $row_emp[3];
        $emp_fing = $row_emp[4];
        $user = $row_emp[5];
        $emp_email = $row_emp[6];
        $emp_emp = $row_emp[7];
    }
}
if(isset($_GET['exp_d'])){$disabled = "disabled";}
?>
<div class="btblue">
    <div class="form-group text-right">
        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_vacaciones">
    </div>
    <!-- Solicitar Vacaciones -->
    <div id="perm" class="panel-body tab-pane fade active in">           
        <form id="form_solic_vac" name="form_solic_vac" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <div class="widget">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Vacaciones!</strong> Las solicitudes de vacaciones se deben tramitar con quince (15) días de antelación.
                            </div>
                        </div>
                    </div>
                </div><?php 
            }?>
            <!-- Fecha de la solicitud -->
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">&nbsp;</div>
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                <div class="input-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <input id="e3_solic_fsolic" name="e3_solic_fsolic" type="text" class="form-control" value="<?php echo $fsolic;?>" <?php echo $disabled;?>>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                            <legend><span class="hidden-xs btblue text-right">Información del </span><span class="btblue">Empleado</span></legend>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="e3_user_nom">Nombre Completo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="cont-group form-control" id="e3_user_nom" type="text" name="e3_user_nom" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $emp_nom.' '.$emp_ape;?>" <?php echo $disabled;?> <?php if($emp_nom <> ''){echo "readonly";}?>/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="e3_user_doc">No. Documento</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="cont-group form-control" id="e3_user_doc" type="text" name="e3_user_doc" placeholder="Número de documento" value="<?php echo $emp_doc;?>" <?php echo $disabled;?> <?php if($emp_doc <> ''){echo "readonly";}?>/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="e3_user_fing">Fecha de Ingreso</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="cont-group form-control" id="e3_user_fing" type="text" name="e3_user_fing" placeholder="Fecha de Ingreso" value="<?php echo $emp_fing;?>" <?php echo $disabled;?> <?php if($emp_fing <> ''){echo "readonly";}?>/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Cargo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="cont-group form-control" id="e3_carg_id" type="text" name="e3_carg_id" placeholder="Cargo" value="<?php echo $emp_carg;?>" <?php echo $disabled;?> <?php if($emp_carg <> ''){echo "readonly";}?>/>
                            </div>
                        </div>
                    </div>
                </div><?php 
            }?>

            <!-- Vacaciones disfrutadas -->
            <div class="form-group text-left">
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <legend><span class="btblue hidden-xs">Vacaciones </span><span class="btblue">Disfrutadas</span></legend>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_fini" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Fecha Inicio:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <input id="e3_solic_fini" type="text" name="e3_solic_fini" class="form-control" value="<?php echo $fini;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_ffin" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Fecha Terminación:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <input id="e3_solic_ffin" type="text" name="e3_solic_ffin" class="form-control" value="<?php echo $ffin;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_fint" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Fecha ingreso:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <input id="e3_solic_fint" type="text" name="e3_solic_fint" class="form-control" value="<?php echo $fint;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_ndias" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">No. días:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <input id="e3_solic_ndias" type="number" name="e3_solic_ndias" class="form-control" value="<?php echo $ndias;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <!-- Vacaciones pagadas -->
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <legend><span class="btblue hidden-xs">Vacaciones en </span><span class="btblue">Dinero</span></legend>
            </div>
            <div class="form-group">
                <label for="e3_solic_ndiasp" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">No. días a pagar:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <input id="e3_solic_ndiasp" type="number" name="e3_solic_ndiasp" class="form-control" value="<?php echo $ndiasp;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <!-- Campos generales -->
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <legend><span class="btblue hidden-xs">Datos </span><span class="btblue">Generales</span></legend>
            </div>
            <div class="form-group">
                <label for="e3_cont_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Contrato:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <?php echo campoSelectMaster("e3_cont", "$cont_id", "*", "WHERE e3_user_id = '$user'", "", "ORDER BY e3_cont_fini ASC");?>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_obs" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Observaciones:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <textarea id="e3_solic_obs" name="e3_solic_obs" class="form-control" rows="3" placeholder="Realice una observación acerca de la solicitud de vacaciones" <?php echo $disabled;?>><?php echo $obs;?></textarea>
                </div>
            </div>

            <!-- Si el estado de la solicitud es 3 el empleado puede editar y RRHH ve esta parte -->
            <?php if((($est == '3') || ($est == '2')) && (($sess_perf == '2') || ($sess_perf == '9'))){
                if($sess_perf == '9'){$val_aprobar = '2';$val_rechaza = '4';}
                else{$val_aprobar = '1';$val_rechaza = '4';}?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="e3_est_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Respuesta Solicitud:</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                        <div class="radio">
                            <label>
                                <input id="e3_est_id1" name="e3_est_id" type="radio" value="<?php echo $val_aprobar;?>" <?php echo $disabled;?>> Aprobar &nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input id="e3_est_id2" name="e3_est_id" type="radio" value="<?php echo $val_rechaza;?>" <?php echo $disabled;?>> Rechazar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="e3_solic_obs_rrhh" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Observacion Respuesta:</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                        <textarea class="form-control" id="e3_solic_obs_rrhh" name="e3_solic_obs_rrhh" rows="3" placeholder="Realice una observación acerca de la aprobación o no del permiso" <?php echo $disabled;?>></textarea>
                    </div>
                </div>
            <?php }
            else{?>
                <input id="e3_est_id" name="e3_est_id" type="hidden" value="3">
                <input id="e3_solic_obs_rrhh" name="e3_solic_obs_rrhh" type="hidden" value="Actualización de Solicitud.">
            <?php }?>
            <!-- Si ya se a realizado una aceptación y/o respuesta a una solicitud, muestra el historial de esta -->
            <?php if($obs_rrhh <> ''){?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="e3_solic_obs_jefe" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label">Historial Respuestas:</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                        <input id="e3_solic_obs_jefe" name="e3_solic_obs_jefe" type="hidden" value="<?php echo $obs_rrhh;?>">
                        <?php echo $obs_rrhh;?>
                    </div>
                </div>
            <?php } ?>
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                        <input id="nom_perfil" type="hidden" name="nom_perfil" value="<?php echo nombreCampo($sess_perf, 'e3_perf') ?>">
                        <input id="id_perfil" type="hidden" name="id_perfil" value="<?php echo $sess_perf;?>">
                        <input id="e3_user_email" type="hidden" name="e3_user_email" value="<?php echo $emp_email;?>">
                        <input id="emp_emp" type="hidden" name="emp_emp" value="<?php echo $emp_emp;?>">
                        <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="2"><?php 
                        if(isset($_GET["exp_id"])){?>
                            <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $exp_id;?>">
                            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Actualizar</button><?php 
                        }
                        else{?>
                            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button><?php 
                        }?>
                        <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                    </div>
                </div><?php 
            }
            else{?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                        <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="1">
                        <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</button>
                    </div>
                </div><?php 
            }?>
        </form>
    </div>
</div>
<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script> <!-- Datepicker -->
<script src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>
    $(document).ready(function() {
        solicVacaciones();
        function agregarValidacion(){
            var disfrute = $("#e3_solic_ndias").val();
            var pagadas = $("#e3_solic_ndiasp").val();

            var est = '<?php echo $est;?>';
            var session_id = '<?php echo $sess_perf;?>';
            if(((session_id === '2') || (session_id === '9')) && (est !== '1')){
                $('#form_solic_vac').bootstrapValidator('addField', 'e3_est_id', {
                    message: 'La respuesta a la solicitud no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La respuesta a la solicitud es requerida'
                        }
                    }
                });
            }
            else{
                $('#form_solic_vac').bootstrapValidator('removeField', 'e3_est_id');
            }

            if((!pagadas.length || pagadas === '0') && (!disfrute.length || disfrute === '0')){
                $("#e3_solic_ndias").val('');
                $("#e3_solic_ndiasp").val('');
                $('#form_solic_vac').bootstrapValidator('addField', 'e3_solic_ndias', {
                    validators: {
                        notEmpty: {
                            message: 'Digite el número de días a disfrutar'
                        }
                    }
                });
                $('#form_solic_vac').bootstrapValidator('addField', 'e3_solic_ndiasp', {
                    validators: {
                        notEmpty: {
                            message: 'Digite el número de días a pagar'
                        }
                    }
                });
            }
            else if((!pagadas.length || pagadas === '0')&&(disfrute.length && disfrute > '0')){
                $("#e3_solic_ndiasp").val('0');
                $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_ndiasp');
            }
            else if((pagadas.length && pagadas > '0')&&(!disfrute.length || disfrute === '0')){
                $("#e3_solic_ndias").val('0');
                $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_ndias');
            }
            else{
                $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_ndiasp');
                $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_ndias');
            }
        }
        $('#form_solic_vac').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_solic_fini: {
                    message: 'La fecha de inicio no es válida',
                    validators: {
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de inicio no es válida'
                        },
                        notEmpty: {
                            message: 'La fecha de inicio es requerida'
                        }
                    }
                },
                e3_solic_ffin: {
                    message: 'La fecha final no es válida',
                    validators: {
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha final no es válido'
                        },
                        notEmpty: {
                            message: 'La fecha final es requerida'
                        }
                    }
                },
                e3_solic_fint: {
                    message: 'La fecha de ingreso no es válida',
                    validators: {
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de ingreso no es válido'
                        },
                        notEmpty: {
                            message: 'La fecha de ingreso es requerida'
                        }
                    }
                },
                e3_cont_id: {
                    message: 'El contrato no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El contrato es requerido'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            espereshow();
            var id_emp = $("#id_emp").val();
            if(id_emp !== ''){
                $("#e3_user_id").val(id_emp);
            }
            var datos_form = new FormData($("#form_solic_vac")[0]);
            $.ajax({
                url:"../php/ins_upd_perm.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#solic_vacaciones").load("./solic_vacaciones.php?id_emp="+id_emp+"&perm_mod="+sess_mod_1);
                        $(".notifications").load("notificaciones.php");
                        swal({
                            title: "Felicidades!",
                            text: "El registro se ha guardado correctamente!",
                            type: "success",
                            confirmButtonText: "Continuar",
                            confirmButtonColor: "#94B86E"
                        });
                    }
                    else{
                        setTimeout(esperehide, 1000);
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
        agregarValidacion();
        $("#e3_solic_ndias").on("change", agregarValidacion);
        $("#e3_solic_ndiasp").on("change", agregarValidacion);
    });
    $(function () {
        $('#e3_solic_fini').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_solic_ffin').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_solic_fint').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>