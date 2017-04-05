<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["emp_id"])){$emp_id = $_GET["emp_id"];}
else{$emp_id = "";}
?>
<div class="panel-group" id="accordion">
    <div class="widget"><input id="id_emp" type="hidden" name="id_emp" value="<?php echo $emp_id;?>"></div>
    <!-- Datos Básicos -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_basicos">Datos Básicos</a>
            </h4>
        </div>
        <div id="emp_basicos" class="panel-collapse collapse"></div>
    </div>
    <!-- Contratos -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_contratos">Contratos</a>
            </h4>
        </div>
        <div id="emp_contratos" class="panel-collapse collapse"></div>
    </div>
    <!-- Horarios -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_horarios">Horarios</a>
            </h4>
        </div>
        <div id="emp_horarios" class="panel-collapse collapse"></div>
    </div>
    <!-- Carnets -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_carnet">Carnets</a>
            </h4>
        </div>
        <div id="emp_carnet" class="panel-collapse collapse"></div>
    </div>
    <!-- Estudios Realizados -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_estudios">Estudios Realizados</a>
            </h4>
        </div>
        <div id="emp_estudios" class="panel-collapse collapse"></div>
    </div>
    <!-- experiencia Laboral -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_laboral">Experiencia laboral</a>
            </h4>
        </div>
        <div id="emp_laboral" class="panel-collapse collapse"></div>
    </div>
    <!-- Seguridad Social -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_seguridad">Seguridad Social</a>
            </h4>
        </div>
        <div id="emp_seguridad" class="panel-collapse collapse"></div>
    </div>
</div>
<script>det_emp();</script>