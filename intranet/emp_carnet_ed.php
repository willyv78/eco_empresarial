<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$nom = "";
$fini = "";
$ffin = "";
$user = "";
$obs = "";
$exp_id = "";
$accion = "Nuevo Registro";
$term = '';
$actu = 'checked="checked"';
$ver_ffin = "hidden";
if(isset($_GET["exp_id"]))
{
  $exp_id = $_GET["exp_id"];
  $accion = "Editar Registro";
}

$res_bus = otrosDatos2($exp_id, 'e3_card');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $fini = $row[2];
        $ffin = $row[3];
        $user = $row[4];
        $obs = $row[7];
    }
}
if(($ffin <> '') && ($ffin <> '0000-00-00')){
    $term = 'checked="checked"';
    $actu = "";
    $ver_ffin = "";
}
else{$ffin = "";}
?>
<div class="btblue col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form_cont" name="form_cont" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <!-- <legend><?php echo $accion; ?></legend> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_carnet">
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_card_fini" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Inicio:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_card_fini" id="e3_card_fini" type="text" placeholder="YYYY-MM-DD" value="<?php echo $fini;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_card_fin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Terminado:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_card_fin" id="e3_card_fini_1" value="1" <?php echo $term;?> > Terminado &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_card_fin" id="e3_card_fini_2" value="0" <?php echo $actu;?>> Actual
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_ffin;?>" id="cont_ffin">
            <label for="e3_card_ffin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Terminación:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_card_ffin" id="e3_card_ffin" type="text" placeholder="YYYY-MM-DD" value="<?php echo $ffin;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_card_nom" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Número de carnet:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input type="text" name="e3_card_nom" id="e3_card_nom" class="form-control" placeholder="Número de carnet" value="<?php echo $nom;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_card_obs">Observación: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <textarea name="e3_card_obs" id="e3_card_obs" rows="3" placeholder="Ingrese una observación acerca de la entrega del carnet o por que ya no lo usa." class="form-control" ><?php echo $obs;?></textarea>
            </div>
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
        <div class="widget"></div>
    </form>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> <!-- Datepicker -->
<!-- Libreria java script que realiza la validacion de los formulariosP -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>empEstudiosEdit();</script>
<script>
    $(document).ready(function() {
        // valida si el contrato ha terminado o no pra agregar o quitar la fecha de terminacion a la validacion
        var term = $("input:radio[name='e3_card_fin']:checked").val();
        if(term == '1'){
            $('#form_cont').bootstrapValidator('addField', 'e3_card_ffin', {
                validators: {
                    notEmpty: {
                        message: 'Seleccione la fecha de uso del carnet'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'El formato de la fecha de uso del carnet no es valida'
                    }
                }
            });
        }

        $('#form_cont').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_card_fini: {
                    message: 'La fecha de inicio de uso del carnet no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La fecha de inicio de uso del carnet es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de inicio de uso del carnet no es valida'
                        }
                    }
                },
                e3_card_nom: {
                    validators: {
                        notEmpty: {
                            message: 'Digite el valor del salario'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'El número de carnet debe contener solo numeros.'
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
            var datos_form = new FormData($("#form_cont")[0]);
            $.ajax({
                url:"../php/ins_upd_car.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        $("#emp_carnet").load("./emp_carnet.php?id_emp="+id_emp);
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
        $('#e3_card_fini').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_card_ffin').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>