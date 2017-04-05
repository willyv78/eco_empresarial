<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["emp_id"])){$emp_id = $_GET["emp_id"];}
else{$emp_id = "";}
?>
<div class="form-group text-right">
    <input id="id_emp" type="hidden" name="id_emp" value="<?php echo $emp_id;?>">
</div>
<div class="panel-group" id="accordion">
    <!-- Permisos -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#solic_permisos">Permisos</a>
            </h4>
        </div>
        <div id="solic_permisos" class="panel-collapse collapse"></div>
    </div>
    <!-- Vacaciones -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#solic_vacaciones">Vacaciones</a>
            </h4>
        </div>
        <div id="solic_vacaciones" class="panel-collapse collapse"></div>
    </div>
    <!-- Certificado laboral -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#solic_laboral">Certificado Laboral</a>
            </h4>
        </div>
        <div id="solic_laboral" class="panel-collapse collapse"></div>
    </div>
</div>
<script>det_solic();</script>