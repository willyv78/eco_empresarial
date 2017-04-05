<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
// Variables por defecto
for($i = 1; $i <= 10; $i++){
    $hing[$i] = "";
    $hsal[$i] = "";
}
$user = "";
$fini = "";
$ffin = "";
$obs = "";
$exp_id = "";
$accion = "Nuevo Registro";
$term = '';
$actu = 'checked="checked"';
$ver_ffin = "hidden";
// Si se va a editar un registro hace esto
if(isset($_GET["exp_id"]))
{
    $exp = explode("|", $_GET["exp_id"]);
    if(($exp[1] <> '') && ($exp[1] <> '0000-00-00')){$fecha_fin = $exp[1];$ffin = $exp[1];}
    else{$fecha_fin = date('Y-m-d');}
    $exp_id = $_GET["exp_id"];
    $accion = "Editar Registro";
    $fini = $exp[0];
    $user = $exp[2];
    $res_ing = registroCampo("e3_horario", "e3_horario_dia, e3_horario_hent, e3_horario_hsal, e3_horario_obs", "WHERE (e3_horario_fini >= '".$fini."' AND e3_horario_ffin <= '".$fecha_fin."') AND e3_user_id = '".$user."'", "", "ORDER BY e3_horario_dia ASC");
    //  SELECT e3_horario_dia, e3_horario_hent, e3_horario_hsal, e3_horario_obs FROM e3_horario WHERE (e3_horario_fini >= '2014-10-01' AND e3_horario_ffin <= '2015-03-04') AND e3_user_id = '32' ORDER BY e3_horario_dia ASC
    if($res_ing)
    {
        if(mysql_num_rows($res_ing) > 0)
        {
            while($row_ing = mysql_fetch_array($res_ing)){
                $hing[$row_ing[0]] = $row_ing[1];
                $hsal[$row_ing[0]] = $row_ing[2];
                $obs = $row_ing[3];
            }
        }
    }
}
// Si es nuevo registro hace esto
if(isset($_GET["id_emp"]))
{
  $user = $_GET["id_emp"];
}
// si es nuevo registro y la fecha esta vacia o es 000-00-00 hace esto
if(($ffin <> '') && ($ffin <> '0000-00-00')){
    $term = 'checked="checked"';
    $actu = "";
    $ver_ffin = "";
}
?>
<div class="btblue col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form_cont" name="form_cont" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <!-- <legend><?php echo $accion; ?></legend> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_horarios">
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_horario_fini" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Inicio:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_horario_fini" id="e3_horario_fini" type="text" placeholder="YYYY-MM-DD" value="<?php echo $fini;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_horario_fin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Terminado:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_horario_fin" id="e3_horario_fini_1" value="1" <?php echo $term;?> > Terminado &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_horario_fin" id="e3_horario_fini_2" value="0" <?php echo $actu;?>> Actual
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_ffin;?>" id="cont_ffin">
            <label for="e3_horario_ffin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Terminación:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_horario_ffin" id="e3_horario_ffin" type="text" placeholder="YYYY-MM-DD" value="<?php echo $ffin;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_user_hing">Horario: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_1" type="checkbox" <?php if($hing[1] <> ''){echo "checked";}?> name="e3_user_dia[]" value="1" data-bv-choice="true" data-bv-choice-min="1" data-bv-choice-max="10" data-bv-choice-message="Seleccione mínimo 1 de los 7 días.">
                            Lunes
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_1"><?php 
                        if($hing[1] <> ''){?><input id="e3_user_hing_1" type="time" name="e3_user_hing_1" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[1];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_1"><?php 
                        if($hsal[1] <> ''){?><input id="e3_user_hsal_1" type="time" name="e3_user_hsal_1" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[1];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_2" type="checkbox" <?php if($hing[2] <> ''){echo "checked";}?> name="e3_user_dia[]" value="2">
                            Martes
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_2"><?php 
                        if($hing[2] <> ''){?><input id="e3_user_hing_2" type="time" name="e3_user_hing_2" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[2];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_2"><?php 
                        if($hsal[2] <> ''){?><input id="e3_user_hsal_2" type="time" name="e3_user_hsal_2" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[2];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_3" type="checkbox" <?php if($hing[3] <> ''){echo "checked";}?> name="e3_user_dia[]" value="3">
                            Miercoles
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_3"><?php 
                        if($hing[3] <> ''){?><input id="e3_user_hing_3" type="time" name="e3_user_hing_3" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[3];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_3"><?php 
                        if($hsal[3] <> ''){?><input id="e3_user_hsal_3" type="time" name="e3_user_hsal_3" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[3];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_4" type="checkbox" <?php if($hing[4] <> ''){echo "checked";}?> name="e3_user_dia[]" value="4">
                            Jueves
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_4"><?php 
                        if($hing[4] <> ''){?><input id="e3_user_hing_4" type="time" name="e3_user_hing_4" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[4];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_4"><?php 
                        if($hsal[4] <> ''){?><input id="e3_user_hsal_4" type="time" name="e3_user_hsal_4" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[4];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_5" type="checkbox" <?php if($hing[5] <> ''){echo "checked";}?> name="e3_user_dia[]" value="5">
                            Viernes
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_5"><?php 
                        if($hing[5] <> ''){?><input id="e3_user_hing_5" type="time" name="e3_user_hing_5" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[5];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_5"><?php 
                        if($hsal[5] <> ''){?><input id="e3_user_hsal_5" type="time" name="e3_user_hsal_5" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[5];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_6" type="checkbox" <?php if($hing[6] <> ''){echo "checked";}?> name="e3_user_dia[]" value="6">
                            Sabado
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_6"><?php 
                        if($hing[6] <> ''){?><input id="e3_user_hing_6" type="time" name="e3_user_hing_6" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[6];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_6"><?php 
                        if($hsal[6] <> ''){?><input id="e3_user_hsal_6" type="time" name="e3_user_hsal_6" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[6];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_7" type="checkbox" <?php if($hing[7] <> ''){echo "checked";}?> name="e3_user_dia[]" value="7">
                            Domingo
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_7"><?php 
                        if($hing[7] <> ''){?><input id="e3_user_hing_7" type="time" name="e3_user_hing_7" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[7];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_7"><?php 
                        if($hsal[7] <> ''){?><input id="e3_user_hsal_7" type="time" name="e3_user_hsal_7" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[7];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_8" type="checkbox" <?php if($hing[8] <> ''){echo "checked";}?> name="e3_user_dia[]" value="8">
                            Break Mañana
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_8"><?php 
                        if($hing[8] <> ''){?><input id="e3_user_hing_8" type="time" name="e3_user_hing_8" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[8];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_8"><?php 
                        if($hsal[8] <> ''){?><input id="e3_user_hsal_8" type="time" name="e3_user_hsal_8" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[8];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_9" type="checkbox" <?php if($hing[9] <> ''){echo "checked";}?> name="e3_user_dia[]" value="9">
                            Almuerzo
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_9"><?php 
                        if($hing[9] <> ''){?><input id="e3_user_hing_9" type="time" name="e3_user_hing_9" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[9];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_9"><?php 
                        if($hsal[9] <> ''){?><input id="e3_user_hsal_9" type="time" name="e3_user_hsal_9" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[9];?>" class="form-control" /><?php }?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label>
                            <input id="e3_user_dia_10" type="checkbox" <?php if($hing[10] <> ''){echo "checked";}?> name="e3_user_dia[]" value="10">
                            Break Tarde
                        </label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_ing_10"><?php 
                        if($hing[10] <> ''){?><input id="e3_user_hing_10" type="time" name="e3_user_hing_10" placeholder="Ingreso HH:MM:SS" value="<?php echo $hing[10];?>" class="form-control" /><?php }?></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 div_sal_10"><?php 
                        if($hsal[10] <> ''){?><input id="e3_user_hsal_10" type="time" name="e3_user_hsal_10" placeholder="Ingreso HH:MM:SS" value="<?php echo $hsal[10];?>" class="form-control" /><?php }?></div>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_horario_obs">Observación: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <textarea name="e3_horario_obs" id="e3_horario_obs" rows="3" placeholder="Ingrese una observación acerca del cambio de horario." class="form-control" ><?php echo $obs;?></textarea>
            </div>
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <input id="e3_user_id" type="hidden" name="e3_user_id" value="<?php echo $user;?>"><?php 
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
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> <!-- Datetimepicker -->
<!-- Libreria java script que realiza la validacion de los formulariosP -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>empEstudiosEdit();</script>
<script>
    $(document).ready(function() {
        // funcion que se ejecuta cuando se checkea un dia de la semana
        function agregarCampo(datos) {
            var obj = $(this).val();
            var nom_obj_ing = 'e3_user_hing_'+obj;
            var nom_obj_sal = 'e3_user_hsal_'+obj;
            if($(this).prop('checked')){
                // Si marca el break de la mañana
                if(obj === '8'){
                    var div_ing = '<input id="e3_user_hing_'+obj+'" type="time" name="e3_user_hing_'+obj+'" placeholder="Ingreso HH:MM:SS" value="09:30:00" class="form-control" />';
                    var div_sal = '<input id="e3_user_hsal_'+obj+'" type="time" name="e3_user_hsal_'+obj+'" placeholder="Salida HH:MM:SS" value="10:00:00" class="form-control" />';
                }
                // Si marca el almuerzo
                else if(obj === '9'){
                    var div_ing = '<input id="e3_user_hing_'+obj+'" type="time" name="e3_user_hing_'+obj+'" placeholder="Ingreso HH:MM:SS" value="13:00:00" class="form-control" />';
                    var div_sal = '<input id="e3_user_hsal_'+obj+'" type="time" name="e3_user_hsal_'+obj+'" placeholder="Salida HH:MM:SS" value="14:00:00" class="form-control" />';
                }
                // Si marca el break de la tarde
                else if(obj === '10'){
                    var div_ing = '<input id="e3_user_hing_'+obj+'" type="time" name="e3_user_hing_'+obj+'" placeholder="Ingreso HH:MM:SS" value="15:30:00" class="form-control" />';
                    var div_sal = '<input id="e3_user_hsal_'+obj+'" type="time" name="e3_user_hsal_'+obj+'" placeholder="Salida HH:MM:SS" value="16:00:00" class="form-control" />';
                }
                // Si marca un día a la semana
                else{
                    var div_ing = '<input id="e3_user_hing_'+obj+'" type="time" name="e3_user_hing_'+obj+'" placeholder="Ingreso HH:MM:SS" value="07:00:00" class="form-control" />';
                    var div_sal = '<input id="e3_user_hsal_'+obj+'" type="time" name="e3_user_hsal_'+obj+'" placeholder="Salida HH:MM:SS" value="17:30:00" class="form-control" />';
                }
                $(".div_ing_"+obj).append(div_ing);
                $(".div_sal_"+obj).append(div_sal);

                $('#form_bas').bootstrapValidator('addField', nom_obj_ing, {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione hora de ingreso'
                        }
                    }
                });
                $('#form_bas').bootstrapValidator('addField', nom_obj_sal, {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione hora de salida'
                        }
                    }
                });
            }
            else{
                $(".div_ing_"+obj).html("");
                $(".div_sal_"+obj).html("");
                $('#form_bas').bootstrapValidator('removeField', nom_obj_ing);
                $('#form_bas').bootstrapValidator('removeField', nom_obj_sal);
            }
        }
        // agrega o quita los campos de hora de ingreso y salida si hace click en el checkbox
        $("input[type=checkbox]").on("click", agregarCampo);
        // valida si el contrato ha terminado o no pra agregar o quitar la fecha de terminacion a la validacion
        var term = $("input:radio[name='e3_horario_fin']:checked").val();
        if(term == '1'){
            $('#form_cont').bootstrapValidator('addField', 'e3_horario_ffin', {
                validators: {
                    notEmpty: {
                        message: 'Seleccione la fecha de terminación del contrato'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'El formato de la fecha de terminación del contrato no es valida'
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
                e3_horario_fini: {
                    message: 'La fecha de inicio del contrato no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La fecha de inicio del contrato es requerida'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de inicio del contrato no es valida'
                        }
                    }
                },
                e3_tcon_id: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione un tipo de contrato.'
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
                url:"../php/ins_upd_hor.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        $("#emp_horarios").load("./emp_horarios.php?id_emp="+id_emp);
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
        $('#e3_horario_fini').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_horario_ffin').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>