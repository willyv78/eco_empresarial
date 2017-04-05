<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$emp_id = "";
if(isset($_GET['emp_id'])){$emp_id = $_GET['emp_id'];}
?>
<div class="form-group text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <legend>Cambiar Contraseña</legend>
    <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="calendario">
</div>
<div class="btblue col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form_std" name="form_std" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <label for="e3_user_pass" class="col-xs-12 col-sm-4 col-md-4 col-lg-6 control-label"><span class="hidden-md">Contraseña </span><span>Actual</span>:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <input type="password" name="e3_user_pass" id="e3_user_pass" class="form-control" placeholder="Contraseña Actual" value="">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <label for="e3_user_pass_new" class="col-xs-12 col-sm-4 col-md-4 col-lg-6 control-label"><span class="hidden-md">Contraseña </span><span>Nueva</span>:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <input type="password" name="e3_user_pass_new" id="e3_user_pass_new" class="form-control" placeholder="Nueva contraseña" value="<?php echo $nom;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <label for="e3_user_pass_conf" class="col-xs-12 col-sm-4 col-md-4 col-lg-6 control-label"><span>Confirmar </span><span class="hidden-md">Contraseña Nueva</span>:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <input type="password" name="e3_user_pass_conf" id="e3_user_pass_conf" class="form-control" placeholder="Confirmar contraseña Nueva" value="<?php echo $nom;?>">
            </div>
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><?php 
                if(isset($_GET["emp_id"])){?>
                    <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $emp_id;?>">
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Actualizar</button><?php 
                }
                else{?>
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button><?php 
                }?>
                <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
    </form>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<!-- Libreria java script que realiza la validacion de los formulariosP -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form_std').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_user_pass: {
                    message: 'La contraseña no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'La contraseña debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ@#$%&*-_.]+$/,
                            message: 'La contraseña puede contener letras, números y alguno de los siguientes caracteres (@#$%&*-_.)'
                        },
                        different: {
                            field: 'e3_user_pass_new',
                            message: 'La contraseña debe ser diferente a la actual'
                        }
                    }
                },
                e3_user_pass_new: {
                    validators: {
                        identical: {
                            field: 'e3_user_pass_conf',
                            message: 'La nueva contraseña y confirmar contraseña no son iguales'
                        },
                        different: {
                            field: 'e3_user_pass',
                            message: 'La contraseña debe ser diferente a la actual'
                        }
                    }
                },
                e3_user_pass_conf: {
                    validators: {
                        identical: {
                            field: 'e3_user_pass_new',
                            message: 'La nueva contraseña y confirmar contraseña no son iguales'
                        },
                        different: {
                            field: 'e3_user_pass',
                            message: 'La contraseña debe ser diferente a la actual'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            var datos_form = new FormData($("#form_std")[0]);
            $.ajax({
                url:"../php/ins_upd_pass.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        $("#col-md-12").load("./calendario.php?emp_id="+sess_id+"&div_panel=calendario&perm_mod="+sess_mod_2);
                        swal({
                            title: "Felicidades!",
                            text: "La contraseña ha cambiado correctamente!",
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
    cambioContrasena();
</script>






