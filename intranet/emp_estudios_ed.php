<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["exp_id"]))
{
  $exp_id = $_GET["exp_id"];
  $accion = "Editar Registro";
}
else
{
  $exp_id = "";
  $accion = "Nuevo Registro";
}
$res_bus = otrosDatos2($exp_id, 'e3_std');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $tstd = $row[2];
        $titulo = $row[3];
        $fini = $row[4];
        $ffin = $row[5];
        $file = $row[6];
        $tprof = $row[7];
        $file_tprof = $row[8];
        $fin = $row[9];
        $fecha = $row[10];
        $user = $row[11];
    }
    else
    {
        $nom = "";
        $tstd = "";
        $titulo = "";
        $fini = "";
        $ffin = "";
        $file = "";
        $tprof = "";
        $file_tprof = "";
        $fin = "";
        $fecha = "";
        $user = "";
    }
}
else
{
    $nom = "";
    $tstd = "";
    $titulo = "";
    $fini = "";
    $ffin = "";
    $file = "";
    $tprof = "";
    $file_tprof = "";
    $fin = "";
    $fecha = "";
    $user = "";
}
?>
<div class="btblue">
    <form id="form_std" name="form_std" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <!-- <legend><?php echo $accion; ?></legend> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_estudios">
        </div>

        <div class="form-group">
            <label for="e3_std_nom" class="col-sm-4 control-label">Nombre Institución:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_std_nom" id="e3_std_nom" class="form-control" placeholder="Nombre Institución" value="<?php echo $nom;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_tstd_id" class="col-sm-4 control-label">Tipo estudio:</label>
            <div class="col-sm-8"><?php echo campoSelect($tstd, "e3_tstd");?></div>
        </div>
        <div class="form-group">
            <label for="e3_std_titulo" class="col-sm-4 control-label">Titulo Obtenido:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_std_titulo" id="e3_std_titulo" class="form-control" placeholder="Titulo Obtenido" value="<?php echo $titulo;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_std_fini" class="col-sm-4 control-label">Fecha inicio:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_std_fini" id="e3_std_fini" class="form-control" placeholder="Fecha inicio" value="<?php echo $fini;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_std_fini" class="col-sm-4 control-label">Terminado:</label>
            <div class="col-sm-8">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_std_fin" id="e3_std_fini_1" value="1" checked="checked"> Terminado &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_std_fin" id="e3_std_fini_2" value="2"> No terminado &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_std_fin" id="e3_std_fini_3" value="3"> Actual
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="e3_std_ffin" class="col-sm-4 control-label">Fecha finalización:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_std_ffin" id="e3_std_ffin" class="form-control" placeholder="Fecha finalización" value="<?php echo $ffin;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="e3_std_file" class="col-sm-4 control-label">Certificado / Diploma:</label>
            <div class="col-sm-8"><?php 
            if($file <> ''){?>
                <a href="<?php echo $file;?>" title="Ver Certificado" target="blank">Ver certificado</a><?php
            }
            else{echo $file;?>
                <input type="file" name="e3_std_file" id="e3_std_file" class="form-control" placeholder="Certificado / Diploma" value=""><?php 
            }?>
            </div>
        </div>
        <!-- Número de tarjeta profesional -->
        <div id="n_tarj_prof" class="form-group" style="display:none;">
            <label for="e3_std_tprof" class="col-sm-4 control-label">No. Tarjeta Profesional:</label>
            <div class="col-sm-8">
                <input type="text" name="e3_std_tprof" id="e3_std_tprof" class="form-control" placeholder="No. Tarjeta Profesional" value="<?php echo $tprof;?>">
            </div>
        </div>
        <!-- Archivo de la tarjeta profesional -->
        <div id="a_tarj_prof" class="form-group" style="display:none;">
            <label for="e3_std_file_tprof" class="col-sm-4 control-label">Archivo Tarjeta Profesional:</label>
            <div class="col-sm-8"><?php 
            if($file_tprof <> ''){?>
                <a href="<?php echo $file_tprof;?>" title="Ver Certificado" target="blank">Ver Tarjeta Profesional</a><?php
            }
            else{?>
                <input type="file" name="e3_std_file_tprof" id="e3_std_file_tprof" class="form-control" placeholder="Tarjeta profesional" value=""><?php 
            }?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <input id="e3_user_id" type="hidden" name="e3_user_id" value=""><?php 
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
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
    </form>
</div>
<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script> <!-- Datepicker -->
<script src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>
    $(document).ready(function() {
        var tipostd = $("#e3_tstd_id").val();
        var term = $("input:radio[name='e3_std_fin']:checked").val();
        if(tipostd == '3'){
            $('#form_std').bootstrapValidator('addField', 'e3_std_tprof');
            $('#form_std').bootstrapValidator('addField', 'e3_std_file_tprof');
        }
        if(term == '1'){
            $('#form_std').bootstrapValidator('addField', 'e3_std_ffin');
        }
        $('#form_std').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_std_nom: {
                    message: 'El nombre de la institución no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El nombre de la intitución es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El nombre de la institución debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El nombre de la institución debe contener letras, números y barra al piso'
                        }
                    }
                },
                e3_tstd_id: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione un tipo de estudio.'
                        }
                    }
                },
                e3_std_titulo: {
                    message: 'El título no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El título es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El título debe contener de 6 a 40 caractéres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El título debe contener letras, números and barra al piso'
                        }
                    }
                },
                e3_std_tprof: {
                    message: 'El número de tarjeta profesional no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El número de tarjeta profesional es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El número de tarjeta profesional debe contener de 3 a 40 caractéres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_ .]+$/,
                            message: 'El número de tarjeta profesional debe contener letras, números y barra al piso'
                        }
                    }
                },
                e3_std_file_tprof: {
                    message: 'El archivo de la tarjeta profesional no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El archivo de la tarjeta profesional es requerido',
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: 10*1024*1024,
                            message: 'Please choose a pdf file with a size less than 10M.'
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
            var datos_form = new FormData($("#form_std")[0]);
            $.ajax({
                url:"../php/ins_upd_std.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#emp_estudios").load("./emp_estudios.php?id_emp="+id_emp);
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
        $('#e3_std_fini').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_std_ffin').datepicker({format: "yyyy-mm-dd", autoclose: true});
        empEstudiosEdit();
    });
</script>