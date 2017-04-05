<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["exp_id"])){$exp_id = $_GET["exp_id"];}
else{$exp_id = "";}
$res_bus = otrosDatos2($exp_id, 'e3_solic');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $fsolic = $row[1];
        $fini = date('Y-m-d', strtotime($row[2]));
        $ffin = date('Y-m-d', strtotime($row[3]));
        $fint = date('Y-m-d', strtotime($row[5]));
        $ndias = $row[6];
        $ndiasp = $row[7];
        $obs = $row[8];
        $user = $row[9];
    }
    else
    {
        $fsolic = date('Y-m-d');
        $fini = "";
        $ffin = "";
        $fint = "";
        $obs = "";
        $user = "";
        $ndias = "";
        $ndiasp = "";
    }
}
else
{
    $fsolic = date('Y-m-d H:i');
    $fini = date('Y-m-d H:i');
    $ffin = "";
    $fint = "";
    $obs = "";
    $user = "";
    $ndias = "";
    $ndiasp = "";
}
if(isset($_GET["id_emp"])){
    $res_emp = otrosDatos3($_GET["id_emp"], 'e3_user', 'e3_user_nom, e3_user_ape, e3_carg_id, e3_user_doc, e3_user_fing');
    if($res_emp){
        if(mysql_num_rows($res_emp) > 0){
            $row_emp = mysql_fetch_array($res_emp);
            $emp_nom = $row_emp[0];
            $emp_ape = $row_emp[1];
            $emp_carg = nombreCampo($row_emp[2], "e3_carg");
            $emp_doc = $row_emp[3];
            $emp_fing = $row_emp[4];
        }
        else{
            $emp_nom = "";
            $emp_ape = "";
            $emp_carg = "";
            $emp_doc = "";
            $emp_fing = "";
        }
    }
    else{
        $emp_nom = "";
        $emp_ape = "";
        $emp_carg = "";
        $emp_doc = "";
        $emp_fing = "";
    }
}
else{
    $res_emp = otrosDatos3($user, 'e3_user', 'e3_user_nom, e3_user_ape, e3_carg_id, e3_user_doc, e3_user_fing');
    if($res_emp){
        if(mysql_num_rows($res_emp) > 0){
            $row_emp = mysql_fetch_array($res_emp);
            $emp_nom = $row_emp[0];
            $emp_ape = $row_emp[1];
            $emp_carg = nombreCampo($row_emp[2], "e3_carg");
            $emp_doc = $row_emp[3];
            $emp_fing = $row_emp[4];
        }
        else{
            $emp_nom = "";
            $emp_ape = "";
            $emp_carg = "";
            $emp_doc = "";
            $emp_fing = "";
        }
    }
    else{
        $emp_nom = "";
        $emp_ape = "";
        $emp_carg = "";
        $emp_doc = "";
        $emp_fing = "";
    }
}
?>
<div class="btblue">
    <div class="form-group text-right">
        <!-- <legend><?php echo $accion; ?></legend> -->
        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_retenciones">
    </div>
    <!-- Solicitar Permisos -->
    <div id="perm" class="panel-body tab-pane fade active in">           
        <form id="form_solic_vac" name="form_solic_vac" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="widget">
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Retenciones!</strong> Las solicitudes de retenciones se realizan por año vencido.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fecha de la solicitud -->
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                <div class="input-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <input id="e3_solic_fsolic" name="e3_solic_fsolic" type="datetime" class="form-control" value="<?php echo $fsolic;?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
            <!-- Informacion del contacto -->
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <legend>Información del empleado</legend>
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="e3_user_nom">Nombre Completo</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input id="e3_user_nom" type="text" name="e3_user_nom" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $emp_nom.' '.$emp_ape;?>" class="cont-group form-control" <?php if($emp_nom <> ''){echo "readonly";}?>/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="e3_user_doc">No. Documento</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input id="e3_user_doc" type="text" name="e3_user_doc" placeholder="Número de documento" value="<?php echo $emp_doc;?>" class="cont-group form-control" <?php if($emp_doc <> ''){echo "readonly";}?>/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="e3_user_fing">Fecha de Ingreso</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input id="e3_user_fing" type="text" name="e3_user_fing" placeholder="Fecha de Ingreso" value="<?php echo $emp_fing;?>" class="cont-group form-control" <?php if($emp_fing <> ''){echo "readonly";}?>/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="">Cargo</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input id="e3_carg_id" type="text" name="e3_carg_id" placeholder="Cargo" value="<?php echo $emp_carg;?>" class="cont-group form-control" <?php if($emp_carg <> ''){echo "readonly";}?>/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vacaciones disfrutadas -->
            <div class="form-group text-left">
                <legend>Vacaciones Disfrutadas</legend>
                <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_vacaciones">
            </div>
            <div class="form-group">
                <label for="e3_solic_fini" class="col-sm-4 control-label">Fecha Inicio:<?php echo $fini;?></label>
                <div class="col-sm-8">
                    <input id="e3_solic_fini" type="text" name="e3_solic_fini" class="form-control" value="<?php echo $fini;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_ffin" class="col-sm-4 control-label">Fecha Terminación:</label>
                <div class="col-sm-8">
                    <input id="e3_solic_ffin" type="text" name="e3_solic_ffin" class="form-control" value="<?php echo $ffin;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_fint" class="col-sm-4 control-label">Fecha Reintegro:</label>
                <div class="col-sm-8">
                    <input id="e3_solic_fint" type="text" name="e3_solic_fint" class="form-control" value="<?php echo $fint;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_ndias" class="col-sm-4 control-label">No. días:</label>
                <div class="col-sm-8">
                    <input id="e3_solic_ndias" type="text" name="e3_solic_ndias" class="form-control" value="<?php echo $ndias;?>">
                </div>
            </div>
            <!-- Vacaciones pagadas -->
            <div class="form-group text-left">
                <legend>Vacaciones en Dinero</legend>
            </div>
            <div class="form-group">
                <label for="e3_solic_ndiasp" class="col-sm-4 control-label">No. días a pagar:</label>
                <div class="col-sm-8">
                    <input id="e3_solic_ndiasp" type="text" name="e3_solic_ndiasp" class="form-control" value="<?php echo $ndiasp;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_obs" class="col-sm-4 control-label">Observaciones:</label>
                <div class="col-sm-8">
                    <textarea id="e3_solic_obs" name="e3_solic_obs" class="form-control" rows="3" placeholder="Realice una observación acerca de la solicitud de vacaciones"><?php echo $obs;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                    <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="3"><?php 
                    if(isset($_GET["exp_id"])){?>
                        <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $exp_id;?>">
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Actualizar</button><?php 
                    }
                    else{?>
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button><?php 
                    }?>
                    <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script> <!-- Datetimepicker -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>solicVacaciones();</script>
<script>
    $(document).ready(function() {
        var disfrute = $("#e3_solic_ndias").val();
        var pagadas = $("#e3_solic_ndiasp").val();
        if((pagadas == '')&&(disfrute == '')){
            $('#form_solic_vac').bootstrapValidator('addField', 'e3_solic_fini', {
                validators: {
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'La fecha de inicio no es válida'
                    },
                    notEmpty: {
                        message: 'Seleccione una fecha inicial'
                    }
                }
            });
            $('#form_solic_vac').bootstrapValidator('addField', 'e3_solic_ffin', {
                validators: {
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'La fecha final no es válida'
                    },
                    notEmpty: {
                        message: 'Seleccione una fecha final'
                    }
                }
            });
            $('#form_solic_vac').bootstrapValidator('addField', 'e3_solic_fint', {
                validators: {
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'La fecha de reintegro no es válida'
                    },
                    notEmpty: {
                        message: 'Seleccione una fecha de reintegro'
                    }
                }
            });
        }
        // else{
        //     $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_fini');
        //     $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_ffin');
        //     $('#form_solic_vac').bootstrapValidator('removeField', 'e3_solic_fint');            
        // }
        $('#form_solic_vac').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }
        })
        .on('change', '#e3_solic_ndiasp', function() {
            var $row    = $(this).val();
            alert($row);
        })
        .on('error.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
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
                        $("#solic_vacaciones").load("./solic_vacaciones.php?id_emp="+id_emp);
                        swal({
                            title: "Felicidades!",
                            text: "El registro se ha guardado correctamente!",
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
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#e3_solic_fini').datetimepicker();
        $('#e3_solic_ffin').datetimepicker();
        $('#e3_solic_fint').datetimepicker();
    });
</script>