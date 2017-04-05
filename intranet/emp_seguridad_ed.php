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
$res_bus = otrosDatos2($emp_id, 'e3_segsoc');
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $fini = $row[2];
    }
    else
    {
        $nom = $row[1];
        $fini = $row[2];
    }
}
else
{
    $nom = $row[1];
    $fini = $row[2];
}
?>
<div class="btblue">
    <form  id="form_seg" name="form_seg" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group text-right">
            <!-- <legend><?php echo $accion; ?></legend> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_seguridad">
        </div>
        <div class="form-group">
            <label for="e3_segsoc_nom" class="col-sm-4 control-label">Nombre de la Entidad:</label>
            <div class="col-sm-8">
                <select name="e3_segsoc_nom" id="e3_segsoc_nom" class="form-control">
                    <option <?php if($nom == ''){echo "selected";}?> value="">Seleccione...</option>
                    <optgroup label="ARL">
                        <option <?php if($nom == 'ARL - Positiva Compañía de Seguros S.A.'){echo "selected";}?> value="ARL - Positiva Compañía de Seguros S.A.">Positiva S.A.</option>
                        <option <?php if($nom == 'ARL - COLMENA vida y riesgos laborales'){echo "selected";}?> value="ARL - COLMENA vida y riesgos laborales">COLMENA</option>
                    </optgroup>
                    <optgroup label="Caja de Compensación familiar">
                        <option <?php if($nom == 'Caja de Compensación familiar - COMPENSAR'){echo "selected";}?> value="Caja de Compensación familiar - COMPENSAR">COMPENSAR</option>
                    </optgroup>
                    <optgroup label="Cesantías">
                        <option <?php if($nom == 'Cesantías - Colfondos S.A.'){echo "selected";}?> value="Cesantías - Colfondos S.A.">COLFONDOS S.A.</option>
                        <option <?php if($nom == 'esantías - COLPENSIONES'){echo "selected";}?> value="Cesantías - COLPENSIONES">COLPENSIONES</option>
                        <option <?php if($nom == 'Cesantías - Fondo Nacional del AHORRO'){echo "selected";}?> value="Cesantías - Fondo Nacional del AHORRO">FONDO NACIONAL DE AHORRO</option>
                        <option <?php if($nom == 'Cesantías - OLD MUTUAL(SKANDIA)'){echo "selected";}?> value="Cesantías - OLD MUTUAL(SKANDIA)">OLD MUTUAL(SKANDIA)</option>
                        <option <?php if($nom == 'Cesantías - Porvenir S.A.'){echo "selected";}?> value="Cesantías - Porvenir S.A.">PORVENIR S.A.</option>
                        <option <?php if($nom == 'Cesantías - Protección'){echo "selected";}?> value="Cesantías - Protección">PROTECCIÓN</option>
                    </optgroup>
                    <optgroup label="Pensiones">
                        <option <?php if($nom == 'Pensiones - Colfondos S.A.'){echo "selected";}?> value="Pensiones - Colfondos S.A.">COLFONDOS S.A.</option>
                        <option <?php if($nom == 'Pensiones - COLPENSIONES'){echo "selected";}?> value="Pensiones - COLPENSIONES">COLPENSIONES</option>
                        <option <?php if($nom == 'Pensiones - OLD MUTUAL(SKANDIA)'){echo "selected";}?> value="Pensiones - OLD MUTUAL(SKANDIA)">OLD MUTUAL(SKANDIA)</option>
                        <option <?php if($nom == 'Pensiones - Porvenir S.A.'){echo "selected";}?> value="Pensiones - Porvenir S.A.">PORVENIR S.A.</option>
                        <option <?php if($nom == 'Pensiones - Protección'){echo "selected";}?> value="Pensiones - Protección">PROTECCIÓN</option>
                    </optgroup>
                    <optgroup label="Pensiones Voluntarias">
                        <option <?php if($nom == 'Pensiones Voluntarias - Protección'){echo "selected";}?> value="Pensiones Voluntarias - Protección">PROTECCIÓN</option>
                    </optgroup>
                    <optgroup label="Salud POS">
                        <option <?php if($nom == 'Salud POS - Cafesalud'){echo "selected";}?> value="Salud POS - Cafesalud">CAFESALUD</option>
                        <option <?php if($nom == 'Salud POS - Compensar'){echo "selected";}?> value="Salud POS - Compensar">COMPENSAR</option>
                        <option <?php if($nom == 'Salud POS - Coomeva'){echo "selected";}?> value="Salud POS - Coomeva">COOMEVA</option>
                        <option <?php if($nom == 'Salud POS - Cruz Blanca'){echo "selected";}?> value="Salud POS - Cruz Blanca">CRUZ BLANCA</option>
                        <option <?php if($nom == 'Salud POS - Famisanar'){echo "selected";}?> value="Salud POS - Famisanar">FAMISANAR</option>
                        <option <?php if($nom == 'Salud POS - Saludcoop'){echo "selected";}?> value="Salud POS - Saludcoop">SALUDCOOP</option>
                        <option <?php if($nom == 'Salud POS - Salud Total'){echo "selected";}?> value="Salud POS - Salud Total">SALUD TOTAL</option>
                        <option <?php if($nom == 'Salud POS - Sanitas'){echo "selected";}?> value="Salud POS - Sanitas">SANITAS</option>
                        <option <?php if($nom == 'Salud POS - Sura'){echo "selected";}?> value="Salud POS - Sura">SURA</option>
                    </optgroup>
                    <optgroup label="Salud Plan Complementario">
                        <option <?php if($nom == 'Salud Plan Complementario - Compensar'){echo "selected";}?> value="Salud Plan Complementario - Compensar">COMPENSAR</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="e3_segsoc_fini" class="col-sm-4 control-label">Fecha Ingreso:</label>
            <div class="col-sm-8">
                <input type="date" name="e3_segsoc_fini" id="e3_segsoc_fini" class="form-control" value="<?php echo $fini;?>" pattern="" title="Fecha de ingreso o afiliación" placeholder="DD/MM/YYYY">
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
        $('#form_seg').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_segsoc_nom: {
                    message: 'El nombre de la entidad no es válido',
                    validators: {
                        notEmpty: {
                            message: 'El nombre de la entidad es requerido'
                        }
                    }
                },
                e3_segsoc_fini: {
                    message: 'La fecha de afiliación no es válido',
                    validators: {
                        date: {
                            format: 'DD/MM/YYYY',
                            message: 'La fecha de afiliación no es válido'
                        },
                        notEmpty: {
                            message: 'La fecha de afiliación es requerida'
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
            var datos_form = new FormData($("#form_seg")[0]);
            $.ajax({
                url:"../php/ins_upd_seg.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        $("#emp_seguridad").load("./emp_seguridad.php?id_emp="+id_emp);
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