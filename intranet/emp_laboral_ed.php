<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["exp_id"]))
{
  $emp_id = $_GET["exp_id"];
  $accion = "Editar Registro";
}
else
{
  $emp_id = "";
  $accion = "Nuevo Registro";
}
$res_bus = otrosDatos2($emp_id, 'e3_lab');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $carg = $row[2];
        $fini = $row[3];
        $ffin = $row[4];
        $jefe = $row[5];
        $tel = $row[6];
        $email = $row[7];
        $mot = $row[8];
        $file = $row[9];
    }
    else
    {
        $nom = $row[1];
        $carg = $row[2];
        $fini = $row[3];
        $ffin = $row[4];
        $jefe = $row[5];
        $tel = $row[6];
        $email = $row[7];
        $mot = $row[8];
        $file = $row[9];
    }
}
else
{
    $nom = $row[1];
    $carg = $row[2];
    $fini = $row[3];
    $ffin = $row[4];
    $jefe = $row[5];
    $tel = $row[6];
    $email = $row[7];
    $mot = $row[8];
    $file = $row[9];
}
?>
<div class="btblue">
    <form id="form_lab" name="form_lab" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <!-- <legend><?php echo $accion; ?></legend> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_laboral">
        </div>

        <div class="form-group">
            <label for="e3_lab_nom" class="col-sm-4 control-label">Nombre de la Empresa:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_lab_nom" id="e3_lab_nom" class="form-control" value="<?php echo $nom;?>" placeholder="Razón social">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_carg" class="col-sm-4 control-label">Cargo Desempeñado:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_lab_carg" id="e3_lab_carg" class="form-control" value="<?php echo $carg;?>" placeholder="Nombre del Cargo">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_fini" class="col-sm-4 control-label">Fecha Ingreso:</label>
            <div class="col-sm-8">
                <input type="date" name="e3_lab_fini" id="e3_lab_fini" class="form-control" value="<?php echo $fini;?>" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_ffin" class="col-sm-4 control-label">Fecha Salida:</label>
            <div class="col-sm-8">
                <input type="date" name="e3_lab_ffin" id="e3_lab_ffin" class="form-control" value="<?php echo $ffin;?>" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_jefe" class="col-sm-4 control-label">Jefe inmediato:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_lab_jefe" id="e3_lab_jefe" class="form-control" value="<?php echo $jefe;?>" placeholder="Nombre de su jefe / superior">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_tel" class="col-sm-4 control-label">Teléfono:</label>
            <div class="col-sm-8">
                <input type="phone" name="e3_lab_tel" id="e3_lab_tel" class="form-control" value="<?php echo $tel;?>" placeholder="Teléfono de contato jefe">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_email" class="col-sm-4 control-label">Correo Electrónico:</label>
            <div class="col-sm-8">
                <input type="email" name="e3_lab_email" id="e3_lab_email" class="form-control" value="<?php echo $email;?>" placeholder="Email contacto jefe inmediato">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_mot" class="col-sm-4 control-label">Motivo Retiro:</label>
            <div class="col-sm-8">
                <textarea name="e3_lab_mot" id="e3_lab_mot" class="form-control" col="3"  placeholder="Digite el motivo por el cual termino labores en la empresa."><?php echo $mot;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="e3_lab_file" class="col-sm-4 control-label">Archivo Certificado:</label>
            <div class="col-sm-8"><?php 
            if($file <> ''){?>
                <a href="<?php echo $file;?>" title="Ver Certificado" target="blank">Ver Certificado</a><?php
            }
            else{?>
                <input type="file" name="e3_lab_file" id="e3_lab_file" class="form-control" placeholder="Certificado" value=""><?php 
            }?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <input id="e3_user_id" type="hidden" name="e3_user_id" value=""><?php 
                if(isset($_GET["exp_id"])){?>
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
<script>empEstudiosEdit();</script>
<script>
    $(document).ready(function() {
        $('#form_lab').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_lab_nom: {
                    message: 'El nombre de la empresa no es válido',
                    validators: {
                        notEmpty: {
                            message: 'El nombre de la empresa es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El nombre de la empresa debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_ .&]+$/,
                            message: 'El nombre de la empresa debe contener letras, números y barra al piso'
                        }
                    }
                },
                e3_lab_carg: {
                    message: 'El cargo no es válido',
                    validators: {
                        notEmpty: {
                            message: 'El cargo es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El cargo debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El cargo debe contener letras, números y barra al piso'
                        }
                    }
                },
                e3_lab_jefe: {
                    message: 'El nombre del jefe inmediato no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El nombre del jefe inmediato es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El nombre del jefe inmediato debe contener de 6 a 40 caractéres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El nombre del jefe inmediato debe contener letras, números and barra al piso'
                        }
                    }
                },
                e3_lab_tel: {
                    message: 'El número de teléfono no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El número de teléfono es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El número de teléfono debe contener de 3 a 40 caractéres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ .]+$/,
                            message: 'El número de teléfono debe contener letras, números y barra al piso'
                        }
                    }
                },
                e3_lab_mot: {
                    message: 'El motivo de retiro no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El motivo de retiro es requerido',
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El número de teléfono debe contener de 3 a 255 caractéres'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            var id_emp = $("#id_emp").val();
            if(id_emp != ''){
                $("#e3_user_id").val(id_emp);
            }
            var datos_form = new FormData($("#form_lab")[0]);
            $.ajax({
                url:"../php/ins_upd_lab.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#emp_laboral").load("./emp_laboral.php?id_emp="+id_emp);
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