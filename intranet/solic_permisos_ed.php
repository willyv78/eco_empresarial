<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// default de variables
$fsolic = date('Y-m-d H:i');$fini = date('Y-m-d H:i');$ffin = "";$tperm = "";$obs = "";$user = "";$det = "";$rep = "";$det_rep = "";$exp_id = "";$accion = "Nuevo Registro";$emp_nom = "";$emp_ape = "";$emp_carg = "";$emp_email = "";$disabled = "";$sess_perf = $_SESSION['user_perf'];$est = 3;$obs_rrhh = "";$obs_jefe = "";
// Si se envia el id de la solicitud
if(isset($_GET["exp_id"]))
{
  $exp_id = $_GET["exp_id"];
  $accion = "Editar Registro";
}
// Hace la consulta de la solicitud por id
$res_bus = registroCampo("e3_solic", "e3_solic_fsolic, e3_solic_fini, e3_solic_ffin, e3_solic_tperm, e3_solic_obs, e3_user_id, e3_solic_det, e3_solic_rep, e3_solic_det_rep, e3_est_id, e3_solic_obs_rrhh, e3_solic_obs_jefe", "WHERE e3_solic_id = '$exp_id'", "", "ORDER BY e3_solic_fini DESC");
// Si la consulta es exitosa
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $fsolic = date('Y-m-d H:i', strtotime($row[0]));
        $fini = date("Y-m-d H:i", strtotime($row[1]));
        $ffin = date("Y-m-d H:i", strtotime($row[2]));
        $tperm = $row[3];
        $obs = $row[4];
        $user = $row[5];
        $det = $row[6];
        $rep = $row[7];
        $det_rep = $row[8];
        $est = $row[9];
        $obs_rrhh = $row[10];
        $obs_jefe = $row[11];
    }
}
// Si se envia el id del empleado hace esto
if(isset($_GET["id_emp"])){
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_email, c.e3_emp_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '".$_GET["id_emp"]."' AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)", "", "");
}
else{
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_email, c.e3_emp_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '$user' AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)", "", "");
}
if($res_emp){
    if(mysql_num_rows($res_emp) > 0){
        $row_emp = mysql_fetch_array($res_emp);
        $emp_nom = $row_emp[0];
        $emp_ape = $row_emp[1];
        $emp_carg = nombreCampo($row_emp[2], "e3_carg");
        $emp_email = $row_emp[3];
        $emp_emp = $row_emp[4];
    }
}
if(isset($_GET['exp_d'])){$disabled = "disabled";}

?>
<div class="btblue">
    <div class="form-group text-right">
        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_permisos">
    </div>
    <!-- Solicitar Permisos -->
    <div id="perm" class="panel-body tab-pane fade active in">           
        <form id="form_solic_perm" name="form_solic_perm" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <div class="widget">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>ATENCIÓN!</strong> Los permisos se deben tramitar con tres(3) días de antelación y soportados con los documentos que confirmen su cita (en caso de permisos médicos). Los pérmisos deben estar compensados en su jornada laboral ó descontados por nómina, según Reglamento Interno de Trabajo.
                            </div>
                        </div>
                    </div>
                </div><?php 
            }?>
            <!-- Fecha de la solicitud -->
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">&nbsp;</div>
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                <div class="input-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <input class="form-control" id="e3_solic_fsolic" name="e3_solic_fsolic" type="datetime" value="<?php echo $fsolic;?>" <?php echo $disabled;?>>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <!-- Informacion del contacto -->
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group text-right">
                            <legend><span class="btblue hidden-xs">Información del </span><span class="btblue">Empleado</span></legend>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Nombre Completo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="form-control" id="e3_user_nom" type="text" name="e3_user_nom" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $emp_nom.' '.$emp_ape;?>" <?php echo $disabled;?>>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Cargo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input class="form-control" id="e3_carg_id" type="text" name="e3_carg_id" placeholder="Cargo" value="<?php echo $emp_carg;?>" <?php echo $disabled;?>>
                            </div>
                        </div>
                    </div>
                </div><?php 
            }?>
            <!-- Descripción del permiso -->
            <div class="form-group text-right">
                <legend><span class="btblue hidden-xs">Descripción del </span><span class="btblue">Permiso</span></legend>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_fini" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Inicio:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <input class="form-control" id="e3_solic_fini" type="text" name="e3_solic_fini" value="<?php echo $fini;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_ffin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Terminación:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <input class="form-control" id="e3_solic_ffin" type="text" name="e3_solic_ffin" value="<?php echo $ffin;?>" <?php echo $disabled;?>>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_rep" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">¿Tipo de permiso?:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="radio">
                        <label class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <input id="e3_solic_rep1" name="e3_solic_rep" type="radio" <?php if(($rep == 1)||($rep == '')){echo "checked";}?> value="1" <?php echo $disabled;?>> Remunerado &nbsp;&nbsp;&nbsp;
                        </label>
                        <label class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                            <input id="e3_solic_rep2" name="e3_solic_rep" type="radio" <?php if($rep == 2){echo "checked";}?> value="2" <?php echo $disabled;?>> NO Remunerado &nbsp;&nbsp;&nbsp;
                        </label>
                        <label class="col-xs-6 col-sm-6 col-md-2 col-lg-3">
                            <input id="e3_solic_rep3" name="e3_solic_rep" type="radio" <?php if($rep == 3){echo "checked";}?> value="3" <?php echo $disabled;?>> Licencia &nbsp;&nbsp;&nbsp;
                        </label>
                        <label class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <input id="e3_solic_rep4" name="e3_solic_rep" type="radio" <?php if($rep == 4){echo "checked";}?> value="4" <?php echo $disabled;?>> Incapacidad
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_det_rep" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Describa como va a reponer el tiempo:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <textarea class="form-control" id="e3_solic_det_rep" name="e3_solic_det_rep" rows="3" placeholder="Digite la forma en que repone el tiempo de permiso" <?php echo $disabled;?>><?php echo $det_rep;?></textarea>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_tperm" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Personal / Médico:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="radio">
                        <label>
                            <input id="e3_solic_tperm1" name="e3_solic_tperm" type="radio" <?php if(($tperm == 1)||($tperm == '')){echo "checked";}?> value="1" <?php echo $disabled;?>> Personal &nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input id="e3_solic_tperm2" name="e3_solic_tperm" type="radio" <?php if($tperm == 2){echo "checked";}?> value="2" <?php echo $disabled;?>> Médico
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_det" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Descripción:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <textarea class="form-control" id="e3_solic_det" name="e3_solic_det" rows="3" placeholder="Describa para qué requiere el permiso" <?php echo $disabled;?>><?php echo $det;?></textarea>
                </div>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="e3_solic_obs" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Observaciones:</label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <textarea class="form-control" id="e3_solic_obs" name="e3_solic_obs" rows="3" placeholder="Realice una observación acerca de la solicitud de permiso" <?php echo $disabled;?>><?php echo $obs;?></textarea>
                </div>
            </div>
            <!-- Si el estado de la solicitud es 3 o 2 y el perfil es Gerente o RRHH estos ven esta parte -->
            <?php if((($est <> 1)) && (($sess_perf == 2) || ($sess_perf == 9))){
                if(($est == 3) && ($sess_perf == 9) && (($rep == 3) || ($rep == 4))){?>
                    <input type="hidden" name="e3_est_id" id="e3_est_id" class="form-control" value="1">
                    <input type="hidden" name="e3_solic_obs_rrhh" id="e3_solic_obs_rrhh" class="form-control" value="Creado y aprobado por RRHH"><?php 
                }
                else{
                    if($sess_perf == 9){$val_aprobar = 2;$val_rechaza = 4;}
                    else{$val_aprobar = 1;$val_rechaza = 4;}?>
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="e3_est_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Respuesta Solicitud:</label>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
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
                        <label for="e3_solic_obs_rrhh" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Observacion Respuesta:</label>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <textarea class="form-control" id="e3_solic_obs_rrhh" name="e3_solic_obs_rrhh" rows="3" placeholder="Realice una observación acerca de la aprobación o no del permiso" <?php echo $disabled;?>></textarea>
                        </div>
                    </div><?php 
                }
            }
            // (Si el estado es diferente a 3 o 2 y el perfil es Gerente o RRHH) o (si el perfil es 3 o 2 y el perfil es diferente a Gerente o RRHH) o (Si las dos validaciones son falsas) hace esto 
            else{
                if(!isset($_GET["exp_id"])){?>
                    <input type="hidden" name="e3_est_id" id="e3_est_id" class="form-control" value="3"><?php 
                }
                else{?>
                    <input type="hidden" name="e3_est_id" id="e3_est_id" class="form-control" value="<?php echo $est;?>"><?php 
                }
            }?>
            <!-- Si ya se a realizado una aceptación y/o respuesta a una solicitud, muestra el historial de esta -->
            <?php if($obs_rrhh <> ''){?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="e3_solic_obs_jefe" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Historial Respuestas:</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <input id="e3_solic_obs_jefe" name="e3_solic_obs_jefe" type="hidden" value="<?php echo $obs_rrhh;?>">
                        <?php echo $obs_rrhh;?>
                    </div>
                </div>
            <?php } ?>
            <!-- si se hace la consulta desde el reporte de ingreso esto no se muestra -->
            <?php if(!isset($_GET['exp_d'])){?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                        <input id="nom_perfil" type="hidden" name="nom_perfil" value="<?php echo nombreCampo($sess_perf, 'e3_perf') ?>">
                        <input id="id_perfil" type="hidden" name="id_perfil" value="<?php echo $sess_perf;?>">
                        <input id="e3_user_email" type="hidden" name="e3_user_email" value="<?php echo $emp_email;?>">
                        <input id="emp_emp" type="hidden" name="emp_emp" value="<?php echo $emp_emp;?>">
                        <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="1"><?php 
                        if(isset($_GET["exp_id"])){
                            if($est == '1'){?>
                                <button id="ignorar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-floppy-disk"></i> Ignorado</button>
                            <?php }?>
                            <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $exp_id;?>">
                            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Actualizar</button><?php 
                        }
                        else{?>
                            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button><?php 
                        }?>
                        <button id="btn_cancelar" type="button" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                    </div>
                </div><?php 
            }
            else{?>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                        <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="1">
                        <input id="perm_id" type="hidden" name="perm_id" value="<?php echo $_GET['exp_id'];?>">
                        <button id="btn_regresar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</button>
                    </div>
                </div><?php 
            }?>
        </form>
    </div>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script> <!-- Datetimepicker -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>
    $(document).ready(function() {
        solicPermisos();
        function agregarValidacion(argument) {
            var est = '<?php echo $est;?>';
            var session_id = '<?php echo $sess_perf;?>';
            var tperm = '<?php echo $rep;?>';
            if(((tperm !== '3') && (tperm !== '4')) && ((session_id === '2') || (session_id === '9')) && (est !== '1')){
                $('#form_solic_perm').bootstrapValidator('addField', 'e3_est_id', {
                    message: 'La respuesta a la solicitud no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La respuesta a la solicitud es requerida'
                        }
                    }
                });
            }
            else{
                $('#form_solic_perm').bootstrapValidator('removeField', 'e3_est_id');
            }
        }
        $('#form_solic_perm').bootstrapValidator({
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
                            format: 'YYYY-MM-DD h:m',
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
                            format: 'YYYY-MM-DD h:m',
                            message: 'La fecha final no es válido'
                        },
                        notEmpty: {
                            message: 'La fecha final es requerida'
                        }
                    }
                },
                e3_solic_det: {
                    message: 'El detalle no es valida',
                    validators: {
                        notEmpty: {
                            message: 'El detalle es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: 'El detalle debe contener de 3 a 255 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .,:;()//-]+$/,
                            message: 'El detalle pueder contener letras, números y signos de puntuación'
                        }
                    }
                },
                e3_solic_det_rep: {
                    message: 'La forma de reponer el tiempo no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La forma de reponer el tiempo es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'La forma de reponer el tiempo debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .,:;()]+$/,
                            message: 'La forma de reponer el tiempo pueder contener letras, números y signos de puntuación'
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
            if(id_emp != ''){
                $("#e3_user_id").val(id_emp);
            }
            var datos_form = new FormData($("#form_solic_perm")[0]);
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
                        $("#solic_permisos").load("./solic_permisos.php?id_emp="+id_emp+"&perm_mod="+sess_mod_1);
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
        $("#e3_solic_rep").on("change", agregarValidacion);
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#e3_solic_fini').datetimepicker({autoclose: true});
        $('#e3_solic_ffin').datetimepicker({autoclose: true});
    });
</script>