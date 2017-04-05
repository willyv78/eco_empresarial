<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$fini = "";
$ffin = "";
$tcon = "";
$user = "";
$carg = "";
$sal = "";
$emp = "";
$area = "";
$ban = "";
$cta = "";
// $card = "";
$door = "";
$pval = "";
$pent = "";
$pfch = "";
$obs = "";
$exp_id = "";
$accion = "Nuevo Registro";
$term = '';
$actu = 'checked="checked"';
$ver_ffin = "hidden";
$sip = '';
$nop = 'checked="checked"';
$ver_pat = "hidden";
if(isset($_GET["exp_id"]))
{
  $exp_id = $_GET["exp_id"];
  $accion = "Editar Registro";
}

$res_bus = otrosDatos2($exp_id, 'e3_cont');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $fini = $row[1];
        $ffin = $row[2];
        $tcon = $row[3];
        $user = $row[4];
        $carg = $row[5];
        $sal = $row[6];
        $emp = $row[7];
        $area = $row[8];
        $ban = $row[9];
        $cta = $row[10];
        // $card = $row[11];
        $door = $row[11];
        $pval = $row[12];
        $pent = $row[13];
        $pfch = $row[14];
        $obs = $row[15];
    }
}
if(($ffin <> '') && ($ffin <> '0000-00-00')){
    $term = 'checked="checked"';
    $actu = "";
    $ver_ffin = "";
}
if($pval <> ''){
    $sip = 'checked="checked"';
    $nop = "";
    $ver_pat = "";
}
?>
<div class="btblue col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form_cont" name="form_cont" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_contratos">
        </div>

        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_cont_fini" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Inicio:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_cont_fini" id="e3_cont_fini" type="text" placeholder="YYYY-MM-DD" value="<?php echo $fini;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_cont_fin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Terminado:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_cont_fin" id="e3_cont_fini_1" value="1" <?php echo $term;?> > Terminado &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_cont_fin" id="e3_cont_fini_2" value="0" <?php echo $actu;?>> Actual
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_ffin;?>" id="cont_ffin">
            <label for="e3_cont_ffin" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Fecha Terminación:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="form-control" name="e3_cont_ffin" id="e3_cont_ffin" type="text" placeholder="YYYY-MM-DD" value="<?php echo $ffin;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_tcon_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Tipo Contrato:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo campoSelect($tcon, "e3_tcon");?></div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_emp_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Empresa:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo campoSelect($emp, "e3_emp");?></div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_carg_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Cargo:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo campoSelect($carg, "e3_carg");?></div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_area_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Área:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo campoSelect($area, "e3_area");?></div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_cont_sal" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Salario:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input type="text" name="e3_cont_sal" id="e3_cont_sal" class="form-control" placeholder="Valor Salario" value="<?php echo $sal;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_cont_pat" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Patrocinio:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_cont_pat" id="e3_cont_pat_1" value="1" <?php echo $sip;?> > SI &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_cont_pat" id="e3_cont_pat_2" value="0" <?php echo $nop;?>> NO
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_pat;?> patrocinio">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_user_pval">Valor patrocinio: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input id="e3_cont_pval" type="text" name="e3_cont_pval" placeholder="Valor del patrocinio" value="<?php echo $pval;?>" class="cont-group form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_pat;?> patrocinio">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_cont_pent">Entidad patrocinio: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <select name="e3_cont_pent" id="e3_cont_pent" class="form-control">
                    <option value="" <?php if($pent == ''){echo "selected";};?>>Seleccione...</option>
                    <option value="Protección Pensiones y Cesantías S.A."<?php if($pent == 'Protección Pensiones y Cesantías S.A.'){echo "selected";};?>>Protección Pensiones y Cesantías S.A.</option>
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $ver_pat;?> patrocinio">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_cont_pfch">Fecha inicio patrocinio: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input class="cont-group form-control" id="e3_cont_pfch" type="text" name="e3_cont_pfch" placeholder="YYYY-MM-DD" value="<?php echo $pfch;?>" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_ban_id" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">Banco Nómina:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><?php echo campoSelect($ban, "e3_ban");?></div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="e3_cont_cta" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label">No. Cuenta Nómina:</label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <input type="text" name="e3_cont_cta" id="e3_cont_cta" class="form-control" placeholder="Nombre Institución" value="<?php echo $cta;?>">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_cont_door">Puerta de ingreso: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <select name="e3_cont_door" id="e3_cont_door" class="form-control">
                    <option value="" <?php if($door == ''){echo "selected";}?>>Seleccione...</option>
                    <option value="1" <?php if($door == '1'){echo "selected";}?>>Piso 1</option>
                    <option value="2" <?php if($door == '2'){echo "selected";} ?>>Piso 2</option>
                    <option value="3" <?php if($door == '3'){echo "selected";} ?>>Piso 3</option>
                    <option value="4" <?php if($door == '4'){echo "selected";} ?>>Piso 4</option>
                    <option value="5" <?php if($door == '5'){echo "selected";} ?>>Piso 5</option>
                    <option value="6" <?php if($door == '6'){echo "selected";} ?>>Piso 6</option>
                    <option value="7" <?php if($door == '7'){echo "selected";} ?>>Piso 7</option>
                    <option value="8" <?php if($door == '8'){echo "selected";} ?>>Terraza</option>
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="e3_cont_obs">Observación: </label>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <textarea name="e3_cont_obs" id="e3_cont_obs" rows="3" placeholder="Ingrese una observación acerca del contrato, por que se termino, alguna referencia de ese contrato, etc." class="form-control" ><?php echo $obs;?></textarea>
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
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> <!-- Datetimepicker -->
<!-- Libreria java script que realiza la validacion de los formulariosP -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>empEstudiosEdit();</script>
<script>
    $(document).ready(function() {
        // valida si el contrato ha terminado o no pra agregar o quitar la fecha de terminacion a la validacion
        var term = $("input:radio[name='e3_cont_fin']:checked").val();
        if(term == '1'){
            $('#form_cont').bootstrapValidator('addField', 'e3_cont_ffin', {
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
        // valida si los campos de patrocinio se han diligenciado para agregar a la validacion
        $("#e3_cont_pval").on('change', validarPatrocinio);
        $("#e3_cont_pent").on('change', validarPatrocinio);
        $("#e3_cont_pfch").on('change', validarPatrocinio);
        function validarPatrocinio() {
            // valida si se llena algun campo de patrocinio
            var pval = $("#e3_cont_pval").val();
            var pent = $("#e3_cont_pent").val();
            var pfch = $("#e3_cont_pfch").val();
            if((pval.length)||(pent.length)||(pfch.length)){
                $('#form_cont').bootstrapValidator('addField', 'e3_cont_pval', {
                    validators: {
                        notEmpty: {
                            message: 'Digite el valor del patrocinio'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'El valor del patrocinio debe contener solo numeros.'
                        }
                    }
                });
                $('#form_cont').bootstrapValidator('addField', 'e3_cont_pent', {
                    validators: {
                        notEmpty: {
                            message: 'Digite la entidad o forma en que se realiza el pago'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: 'la entidad o forma en que se realiza el pago debe contener de 3 a 255 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'La entidad o forma en que se realiza el pago debe contener letras.'
                        }
                    }
                });
                $('#form_cont').bootstrapValidator('addField', 'e3_cont_pfch', {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione la fecha desde que se realiza el pago'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'El formato de la fecha desde que se realiza el pago no es valida'
                        }
                    }
                });
            }
            else{
                $('#form_cont').bootstrapValidator('removeField', 'e3_cont_pval');
                $('#form_cont').bootstrapValidator('removeField', 'e3_cont_pent');
                $('#form_cont').bootstrapValidator('removeField', 'e3_cont_pfch');
            }
        }

        $('#form_cont').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_cont_fini: {
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
                },
                e3_emp_id: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione la empresa.'
                        }
                    }
                },
                e3_carg_id: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione el cargo.'
                        }
                    }
                },
                e3_cont_sal: {
                    validators: {
                        notEmpty: {
                            message: 'Digite el valor del salario'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'El valor del salario debe contener solo numeros.'
                        }
                    }
                },
                e3_cont_door: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione la puerta de ingreso.'
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
                url:"../php/ins_upd_cont.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#emp_contratos").load("./emp_contratos.php?id_emp="+id_emp);
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
        $('#e3_cont_fini').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_cont_ffin').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_cont_pfch').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>