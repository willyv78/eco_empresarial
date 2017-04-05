<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$mensaje = "Seleccione el rango de fecha (inicio y/o final), la empresa y por último seleccione un empleado para filtrar los resultados del reporte.";
$clase_empleado = "";
$empresa = "";
$empleado = "";
if(isset($_GET['emp_id'])){
    $mensaje        = "Seleccione el rango de fecha (inicio y/0 final) para generar el reporte.";
    $clase_empleado = "hidden";
    $empleado = "<input id='e3_user_card' name='e3_user_card' type='hidden' value='".$_GET['emp_id']."'>";
    $empresa = "<input id='e3_emp_id' name='e3_emp_id' type='hidden' value=''>";
}
?>
<div class="panel-body">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Generar Reporte!</strong><?php echo $mensaje;?>
    </div>
    <div id="perm">
        <form id="form_ing_archivo" name="form_ing_archivo" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="ing_reporte">
            <div class="form-group">
                <label for="e3_ing_finicial" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Inicial:</label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="form-control" type="text" id="e3_ing_finicial" name="e3_ing_finicial" value="" pattern="" title="Fecha desde" placeholder="YYYY-MM-DD">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_ing_ffinal" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha final:</label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="form-control" type="text" id="e3_ing_ffinal" name="e3_ing_ffinal" value="" pattern="" title="Fecha hasta" placeholder="YYYY-MM-DD">
                </div>
            </div>
            <div class="form-group <?php echo $clase_empleado;?>">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label" for="e3_emp_id">Empresa: </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><?php 
                    if(isset($_GET['emp_id'])){echo $empresa;}
                    else{echo campoSelect("", "e3_emp");}?>
                </div>
            </div>
            <div class="form-group <?php echo $clase_empleado;?>">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label" for="e3_emp_id">Empleado: </label>
                <div id="ing_empleado" class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><?php echo $empleado;?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="ing_reporte">
                    <button id="btn_generar" type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Generar</button>
                    <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                </div>
            </div>
        </form>
    </div>
    <div id="reporte"></div>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> <!-- Datetimepicker -->
<script>ingresoEdit();</script>
<script type="text/javascript">
    $(function () {
        $('#e3_ing_finicial').datepicker({format: "yyyy-mm-dd", autoclose: true});
        $('#e3_ing_ffinal').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>