<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$res = registroCampo("e3_emp", "e3_emp_nom", "", "", "ORDER BY e3_emp_nom ASC");
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="widget"><input type="hidden" id="nom_div_pag" class="form-control" value="emp_det"></div>
    <!-- Search formulario -->
    <div class="input-group input-group-md">
        <span id="search_cont_icon" class="input-group-addon" title="Buscar Empleado"><i class="glyphicon glyphicon-search"></i></span>
        <input id="search_cont" list="search_cont2" name="search_cont2" class="form-control" placeholder="Buscar Empleado">
        <datalist id="search_cont2"><?php 
            if($res){
                if(mysql_num_rows($res) > 0){
                    while($row = mysql_fetch_array($res)){?>
                        <option value="<?php echo $row[0];?>">
                            <?php echo $row[0];?>
                        </option><?php 
                    }
                }
            }?>
        </datalist>
        <span id="new_emp" class="input-group-addon" title="Agregar Nuevo Empleado"><i class="glyphicon glyphicon-plus"></i></span>
    </div>
    <div class="widget"></div>
    <div id="emp_list" class="widget">
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Búsqueda!</strong> Realice una búsqueda del empleado para consultar su información, esta búsqueda se realiza por palabra clave en los campos nombre, correo electrónico, observación y número de documento.
        </div>
    </div>
</div>
<div id="emp_det" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
<script>cargaListEmp();</script>