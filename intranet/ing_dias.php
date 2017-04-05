<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
?>
<div class="panel-body">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>¿Días Especiales?</strong> En este módulo puede ingresar los días festivos del año y los días que la empresa da a los empleados para que NO asistan o para que salgan antes de su hora habitual.
    </div>
    <div id="perm">           
        <form id="form_ing_archivo" name="form_ing_archivo" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="ing_reporte">
            <div class="form-group">
                <label for="e3_segsoc_nom" class="col-sm-4 control-label">¿Tipo de día?:</label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label>
                            <input id="e3_solic_rep1" name="e3_solic_rep" type="radio" <?php if(($rep == 1)||($rep == '')){echo "checked";}?> value="1" <?php echo $disabled;?>> Festivo &nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input id="e3_solic_rep2" name="e3_solic_rep" type="radio" <?php if($rep == 2){echo "checked";}?> value="2" <?php echo $disabled;?>> Laboral &nbsp;&nbsp;&nbsp;
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_ing_finicial" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Día:</label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="date" name="e3_ing_finicial" id="e3_ing_finicial" class="form-control" value="" pattern="" title="Fecha desde" placeholder="DD/MM/YYYY">
                </div>
            </div>
            <div class="form-group">
                <label for="e3_ing_finicial" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label">Horario:</label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="col-xs-6 col-sm-8 col-md-5 col-lg-4 control-label" for="">Hora entrada:</label>
                        <div class="col-xs-6 col-sm-4 col-md-7 col-lg-8">
                            <input class="text-left form-control" type="hour" name="e3_ing_finicial" id="e3_ing_finicial" value="" pattern="" title="Hora Ingreso" placeholder="HH:ME">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="col-xs-6 col-sm-8 col-md-5 col-lg-4 control-label" for="">Hora salida:</label>
                        <div class="col-xs-6 col-sm-4 col-md-7 col-lg-8">
                            <input class="text-left form-control" type="hour" name="e3_ing_finicial" id="e3_ing_finicial" value="" pattern="" title="Hora Ingreso" placeholder="HH:MS">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_segsoc_nom" class="col-sm-4 control-label">¿Empresa(s)?:</label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label>
                            <input id="e3_solic_rep1" name="e3_solic_rep" type="checkbox" <?php if(($rep == 1)||($rep == '')){echo "checked";}?> value="1" <?php echo $disabled;?>> R + B &nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input id="e3_solic_rep2" name="e3_solic_rep" type="checkbox" <?php if($rep == 2){echo "checked";}?> value="2" <?php echo $disabled;?>> Editores Hache &nbsp;&nbsp;&nbsp;
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="e3_segsoc_nom" class="col-sm-4 control-label">Observación:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="e3_solic_det_rep" name="e3_solic_det_rep" rows="3" placeholder="Digite la forma en que repone el tiempo de permiso" <?php echo $disabled;?>><?php echo $det_rep;?></textarea>
                </div>
            </div>
            <!-- Calendario de google embebido -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <iframe src="https://www.google.com/calendar/embed?src=es.co%23holiday%40group.v.calendar.google.com&ctz=America/Bogota" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
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


<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script> <!-- Datetimepicker -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>ingresoEdit();</script>