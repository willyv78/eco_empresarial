<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="conf_lista"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_area" type="button" class="btn btn-success btn-block btn-config">Áreas Laborales</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_ban" type="button" class="btn btn-primary btn-block btn-config">Entidades Bancarias</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_carg" type="button" class="btn btn-warning btn-block btn-config">Cargos Empleados</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_emp" type="button" class="btn btn-danger btn-block btn-config">Empresas</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_est" type="button" class="btn btn-info btn-block btn-config">Estados</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_perf" type="button" class="btn btn-success btn-block btn-config">Perfiles</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_perm" type="button" class="btn btn-primary btn-block btn-config">Permisos por perfil</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_door" type="button" class="btn btn-warning btn-block btn-config">Puertas de acceso</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tcont" type="button" class="btn btn-danger btn-block btn-config">Tipos de Contacto</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tcon" type="button" class="btn btn-info btn-block btn-config">Tipos de Contrato</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tstd" type="button" class="btn btn-success btn-block btn-config">Tipos de Estudio</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_the" type="button" class="btn btn-primary btn-block btn-config">Tipos de Horas Extra</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tper" type="button" class="btn btn-warning btn-block btn-config">Tipos de Naturaleza Persona</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tsolic" type="button" class="btn btn-danger btn-block btn-config">Tipos de Solicitud</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_user" type="button" class="btn btn-info btn-block btn-config">Usuarios</button>
    </div>

    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_mod" type="button" class="btn btn-success btn-block btn-config">Módulos Aplicación</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_tdoc" type="button" class="btn btn-primary btn-block btn-config">Tipos de Documento</button>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <button name="e3_docs" type="button" class="btn btn-warning btn-block btn-config">Documentos</button>
    </div>
</div>

<script>cargaConfig();</script>