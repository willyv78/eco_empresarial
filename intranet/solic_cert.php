<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");?>
<div class="panel-body">
    <ul class="nav nav-tabs">
        <li class="dropdown active">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Solicitudes <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#perm" data-toggle="tab">Permisos</a></li>
                <li><a href="#vacas" data-toggle="tab">Vacaciones</a></li>
                <li><a href="#rete" data-toggle="tab">Retenciones</a></li>
                <!-- <li><a href="#cdoc" data-toggle="tab">Copia de documentos</a></li> -->
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Certificados <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#lab" data-toggle="tab">Laboral</a></li>
                <!-- <li><a href="#crete" data-toggle="tab">Retenciones</a></li> -->
            </ul>
        </li>
    </ul>
    <div class="panel panel-default tab-content">
        <!-- Solicitar Permisos -->
        <div id="perm" class="panel-body tab-pane fade active in">           
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Permisos!</strong> Los permisos se deben tramitar con tres(3) días de antelación y soportados con los documentos que confirmen su cita (en caso de permisos médicos). Los pérmisos deben estar compensados en su jornada laboral ó descontados por nómina, según Reglamento Interno de Trabajo.
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">                        
                    <!-- <img src="../img/LogoHache.png" class="img-responsive" alt="Image"> -->
                    <legend>Solicitud de Permiso</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Nombre Completo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input id="" type="text" name="" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $_SESSION['user_nom'].' '.$_SESSION['user_ape'];?>" class="cont-group form-control" readonly/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Cargo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_cargo'], 'e3_carg');?>" class="cont-group form-control" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción del permiso -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Descripción del permiso</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Fecha Inicio</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" class="form-control datetimepicker" value="<?php echo date('Y-m-d H:i');?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Fecha Terminación</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" class="form-control datetimepicker" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 text-left">
                                    <div class="radio">
                                        <label>
                                            <input name="forma-repone" type="radio"> Reposición
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="forma-repone" type="radio"> Descontable
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                <label for="">Tipo</label>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="radio">
                                            <label>
                                                <input name="forma-repone" type="radio"> Personal
                                            </label>
                                        </div>
                                    </div>
                                </div>                     
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="radio">
                                            <label>
                                                <input name="forma-repone" type="radio"> Médico
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <label for="">Descripción</label>                                    
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <label for="">Observaciones</label>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- solicitud de Vacaciones -->
        <div id="vacas" class="panel-body tab-pane fade">           
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Vacaciones!</strong> Las solicitudes de vacaciones se deben tramitar con treinta (30) días de antelación.
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">                        
                    <!-- <img src="../img/LogoHache.png" class="img-responsive" alt="Image"> -->
                    <legend>Solicitud de Vacaciones</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Nombre Completo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $_SESSION['user_nom'].' '.$_SESSION['user_ape'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">No. Documento</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo $_SESSION['user_doc'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Fecha de Ingreso</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="date" name="" placeholder="Fecha de Ingreso" value="<?php echo $_SESSION['user_fing'];?>" class="cont-group form-control" <?php if(isset($_SESSION['user_fing'])){echo "readonly";} ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Cargo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_cargo'], 'e3_carg');?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción de la solicitud de vacaciones disfrutadas -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Vacaciones Disfrutadas</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                        <label for="">Fecha Inicio</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                                        <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                        <label for="">Fecha Reintegro</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                                        <input type="date" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label for="">Fecha Fin</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <input type="date" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label for="">No. Días Solicitados</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <input type="number" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <!-- Descripción de la solicitud de vacaciones disfrutadas -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Vacaciones en Dinero</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <label for="">No. Días a pagar</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <input type="number" class="form-control" value="">
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <label for="">Observaciones</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Solicitar Certificado de retencion en la fuente -->
        <div id="rete" class="panel-body tab-pane fade">           
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Retenciones!</strong> Las solicitudes de retenciones se debe realizar con tres días de antelación, debe indicar el año o rango de años que desee generar.
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">
                    <legend>Solicitud de Retenciones</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Nombre Completo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $_SESSION['user_nom'].' '.$_SESSION['user_ape'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">No. Documento</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo $_SESSION['user_doc'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Fecha de Ingreso</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="date" name="" placeholder="Fecha de Ingreso" value="<?php echo $_SESSION['user_fing'];?>" class="cont-group form-control" <?php if(isset($_SESSION['user_fing'])){echo "readonly";} ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Cargo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_cargo'], 'e3_carg');?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción de la solicitud de Retenciones -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Años Retenciones</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                        <label for="">Año desde</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                                        <select name="" id="" class="form-control"><?php 
                                            $year = date('Y');
                                            for ($i=2000; $i <= $year; $i++) {?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option><?php
                                            }?>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                        <label for="">Año Hasta</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                                        <select name="" id="" class="form-control"><?php 
                                            for ($i=2000; $i <= $year; $i++) {?>
                                                <option value="<?php echo $i;?>" <?php if($i == $year){echo "selected";}?>><?php echo $i;?></option><?php
                                            }?>                                            
                                        </select>
                                    </div>
                                </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                <label for="">Observaciones</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Solicitar Copia de Documentos -->
        <div id="cdoc" class="panel-body tab-pane fade">           
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Copia de documentos!</strong> Las solicitudes de copias de documentos se debe realizar con tres días de antelación, debe indicar el nombre del documento (ejemplo: copia de afiliacion eps Cruz Blanca).
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">
                    <legend>Solicitud Copia Documentos</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Nombre Completo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $_SESSION['user_nom'].' '.$_SESSION['user_ape'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">No. Documento</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo $_SESSION['user_doc'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Fecha de Ingreso</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="date" name="" placeholder="Fecha de Ingreso" value="<?php echo $_SESSION['user_fing'];?>" class="cont-group form-control" <?php if(isset($_SESSION['user_fing'])){echo "readonly";} ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Cargo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_cargo'], 'e3_carg');?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción de la solicitud de Retenciones -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Detalle del Documento</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                                <label for="">Nombre Documento</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" placeholder="Nombre Documento"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                                <label for="">Observaciones</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                                <textarea class="form-control" rows="3" placeholder="¿Para que? y/o ¿Por que requiere el documento?"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Generar Certificado Laboral -->
        <div id="lab" class="panel-body tab-pane fade">           
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Certificado Laboral!</strong> Genere su certificado laboral automaticamente, indique a quien va dirigido, tenga mucho cuidado en este campo ya que de acuerdo a como diligencie el mismo se verá reflejado en la impresión.
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">
                    <legend>Certificado Laboral</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Nombre Completo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Nombre(s) y Apellido(s)" value="<?php echo $_SESSION['user_nom'].' '.$_SESSION['user_ape'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Cargo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_cargo'], 'e3_carg');?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Tipo Documento</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo nombreCampo($_SESSION['user_tdoc'], 'e3_tdoc');?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">No. Documento</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Cargo" value="<?php echo $_SESSION['user_doc'];?>" class="cont-group form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Fecha de Ingreso</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="date" name="" placeholder="Fecha de Ingreso" value="<?php echo $_SESSION['user_fing'];?>" class="cont-group form-control" <?php if(isset($_SESSION['user_fing'])){echo "readonly";} ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Salario</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input id="" type="text" name="" placeholder="Salario" value="<?php echo $_SESSION['user_sal'];?>" class="cont-group form-control" <?php if(isset($_SESSION['user_sal'])){echo "readonly";} ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción de la solicitud de Retenciones -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Detalle del Documento</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                <label for="">¿Dirigido A?</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
                                <input type="text" class="form-control" placeholder="¿Dirigido a?"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Generar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Generar Certificados de retefuente -->
        <div id="crete" class="panel-body tab-pane fade">           
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Certificado Retenciones!</strong> Genere su certificado de retenciones, debe indicar el año o rango de años que desee generar.
            </div>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="form-group text-right">                        
                    <!-- <img src="../img/LogoHache.png" class="img-responsive" alt="Image"> -->
                    <legend>Generar Certificado Retenciones</legend>
                </div>
                <!-- Fecha de la solicitud -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Fecha Solicitud: </label>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i');?>" readonly>
                    </div>
                </div>
                <!-- Informacion del contacto -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Información del empleado</legend>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Nombre Completo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input id="e3_user_email2" type="email" name="e3_user_email2" placeholder="email@secundario.com" value="<?php echo '';?>" class="cont-group form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Cargo</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input id="e3_user_email2" type="email" name="e3_user_email2" placeholder="email@secundario.com" value="<?php echo '';?>" class="cont-group form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Descripción del permiso -->
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend>Descripción del permiso</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Fecha Inicio</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" class="form-control datetimepicker" value="<?php echo date('Y-m-d H:i');?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="">Fecha Terminación</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" class="form-control datetimepicker" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 text-left">
                                    <div class="radio">
                                        <label>
                                            <input name="forma-repone" type="radio"> Reposición
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="forma-repone" type="radio"> Descontable
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                <label for="">Tipo</label>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="radio">
                                            <label>
                                                <input name="forma-repone" type="radio"> Personal
                                            </label>
                                        </div>
                                    </div>
                                </div>                     
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="radio">
                                            <label>
                                                <input name="forma-repone" type="radio"> Médico
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <label for="">Descripción</label>                                    
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <label for="">EPS</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <label for="">Motivo</label>
                                        <textarea class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <label for="">Observaciones</label>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <textarea class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>eventSolic();</script>
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(".datetimepicker").datetimepicker({
        format: "dd-mm-yyyy H:ii P",
        showMeridian: true,
        autoclose: true,
        todayBtn: true,
        pickerPosition: "top-right",
        startDate: "<?php echo date('Y-m-d');?>",
        minuteStep: 30
    });
</script> 