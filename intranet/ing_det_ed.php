<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
?>
<div class="panel-group" id="accordion">
    <!-- Cargar Archivo -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#ing_archivo">Subir Archivo</a>
            </h4>
        </div>
        <div id="ing_archivo" class="panel-collapse collapse"></div>
    </div>
    <!-- Generar Reporte -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#ing_reporte">Generar Reporte</a>
            </h4>
        </div>
        <div id="ing_reporte" class="panel-collapse collapse"></div>
    </div>
</div>
<script>det_ing();</script>