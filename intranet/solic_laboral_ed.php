<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$fsolic = date('Y-m-d H:i');$obs = "";$user = "";$det = "";$emp_nom = "";$emp_ape = "";$emp_carg = "";$emp_doc = "";$emp_fing = "";$exp_id = "";
if(isset($_GET["exp_id"])){$exp_id = $_GET["exp_id"];}
$res_bus = registroCampo("e3_solic", "e3_solic_fsolic, e3_solic_obs, e3_user_id, e3_solic_det, e3_solic_rep", "WHERE e3_solic_id = '$exp_id'", "", "");
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $fsolic = date('Y-m-d H:i', strtotime($row[0]));
        $obs = $row[1];
        $user = $row[2];
        $det = $row[3];
        $rep = $row[4];
    }
}
if(isset($_GET["id_emp"])){
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_doc, u.e3_user_fing, u.e3_user_id, u.e3_user_email, c.e3_emp_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '".$_GET["id_emp"]."'", "", "");
}
else{
    $res_emp = registroCampo("e3_user u", "u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_doc, u.e3_user_fing, u.e3_user_id, u.e3_user_email, c.e3_emp_id", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_user_id = '$user'", "", "");
    
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
$sess_perf = $_SESSION['user_perf'];
?>
<div class="btblue">
    <div class="form-group text-right">
        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_laboral">
    </div>
    <!-- Solicitar Permisos -->
    <div id="perm" class="panel-body tab-pane fade active in">           
        <form id="form_solic_cert" name="form_solic_cert" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="widget">
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Certificado Laboral!</strong> Las solicitudes de certificado laboral deben llevar a quien va dirigido y el motivo de la solictud.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fecha de la solicitud -->
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                <div class="input-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <input id="e3_solic_fsolic" name="e3_solic_fsolic" type="text" class="form-control" value="<?php echo $fsolic;?>" placeholder="YYYY-MM-DD HH:MM">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
            <!-- Informacion del contacto -->
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <legend class="text-right"><span class="hidden-xs btblue">Información del </span><span class="btblue">Empleado</span></legend>
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
            <!-- Detalle de la solicitud -->
            <div class="form-group text-left">
                <legend class="text-right"><span class="hidden-xs btblue">Detalle de la </span><span class="btblue">Solicitud</span></legend>
            </div>
            <div class="form-group">
                <label for="e3_solic_rep" class="col-sm-4 control-label">¿Tipo de Certificado?:</label>
                <div class="col-sm-8">
                    <select name="e3_solic_rep" id="e3_solic_rep" class="form-control">
                        <option <?php if($rep == ''){echo "selected='selected'";}?> value="">Seleccione...</option>
                        <option <?php if($rep == '2'){echo "selected='selected'";}?> value="2">Embajada</option>
                        <option <?php if($rep == '1'){echo "selected='selected'";}?> value="1">Otro</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_solic_det" class="col-sm-4 control-label">A quien va dirigido?:</label>
                <div class="col-sm-8">
                    <input id="e3_solic_det" type="text" name="e3_solic_det" class="form-control" value="<?php echo $det;?>" placeholder="¿A quien va dirigido?">
                </div>
            </div>
            <div class="form-group hidden">
                <label for="e3_solic_obs" class="col-sm-4 control-label">Para que la necesita?:</label>
                <div class="col-sm-8">
                    <textarea id="e3_solic_obs" name="e3_solic_obs" class="form-control" rows="3" placeholder="Registre el motivo de la solicitud."><?php echo $obs;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <input id="e3_user_id" type="hidden" name="e3_user_id" value="">
                    <input id="nom_perfil" type="hidden" name="nom_perfil" value="<?php echo nombreCampo($sess_perf, 'e3_perf') ?>">
                    <input id="id_perfil" type="hidden" name="id_perfil" value="<?php echo $sess_perf;?>">
                    <input id="e3_user_email" type="hidden" name="e3_user_email" value="<?php echo $emp_email;?>">
                    <input id="emp_emp" type="hidden" name="emp_emp" value="<?php echo $emp_emp;?>">
                    <input id="e3_est_id" type="hidden" name="e3_est_id" value="3">
                    <input id="e3_tsolic_id" type="hidden" name="e3_tsolic_id" value="4"><?php 
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
<script>
    $(document).ready(function() {
        solicVacaciones();
        $('#form_solic_cert').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_solic_rep: {
                    message: 'El tipo de certificado no es válida',
                    validators: {
                        notEmpty: {
                            message: 'El tipo de certificado es requerida'
                        }
                    }
                },
                e3_solic_fsolic: {
                    message: 'La fecha de solicitud no es válida',
                    validators: {
                        date: {
                            format: 'YYYY-MM-DD h:m',
                            message: 'La fecha de solicitud no es válido'
                        },
                        notEmpty: {
                            message: 'La fecha de solicitud es requerida'
                        }
                    }
                },
                e3_solic_det: {
                    message: '¿A quien va dirigido? no es válido',
                    validators: {
                        notEmpty: {
                            message: '¿A quien va dirigido? es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: '¿A quien va dirigido? debe contener de 3 a 255 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .,:;]+$/,
                            message: '¿A quien va dirigido? pueder contener letras, números y signos de puntuación'
                        }
                    }
                },
                e3_solic_obs: {
                    message: '¿Para que la necesita? no es válido',
                    validators: {
                        notEmpty: {
                            message: '¿Para que la necesita? es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: '¿Para que la necesita? debe contener de 3 a 255 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .,:;]+$/,
                            message: '¿Para que la necesita? pueder contener letras, números y signos de puntuación'
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
            var datos_form = new FormData($("#form_solic_cert")[0]);
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
                        $("#solic_laboral").load("./solic_laboral.php?id_emp="+id_emp+"&perm_mod="+sess_mod_1);
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
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#e3_solic_fsolic').datetimepicker();
    });
</script>