<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["id_emp"]))
{
  $exp_id = $_GET["id_emp"];
}
else
{
  $exp_id = "";
}
$res_bus = otrosDatos($exp_id, "e3_card");

?>
<div class="panel-body">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    <div name="<?php echo $exp_id;?>" class="input-group input-group-md btn_est">
                        <h4>Número / Fecha de Inicio / Fecha Final</h4>
                        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_carnet">
                        <input type="hidden" name="input-pagina" id="input-pagina" class="form-control" value="ins_upd_car">
                        <span class="input-group-addon" title="Nuevo registro"><i class="glyphicon glyphicon-plus"></i></span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody><?php 
        if($res_bus){
            if(mysql_num_rows($res_bus) > 0){
                while ($row_bus = mysql_fetch_array($res_bus)) {
                    if(($row_bus[3] <> "0000-00-00") && ($row_bus[3] <> "")){$ffin = $row_bus[3];}
                    else{$ffin = "Actual";}?>
                    <tr>
                        <td>
                            <div name="<?php echo $row_bus[0];?>" class="input-group input-group-md btn_est">
                                <?php echo $row_bus[1] . " / " . $row_bus[2] . " / " . $ffin;?>
                                <span class="input-group-addon" title="Ver Estudio"><i class="glyphicon glyphicon-eye-open"></i></span> 
                                <span class="input-group-addon" title="Editar Estudio"> <i class="glyphicon glyphicon-pencil"></i></span>
                                <span class="input-group-addon" title="Eliminar Estudio"> <i class="glyphicon glyphicon-remove"></i></span>
                            </div>
                        </td>
                    </tr><?php 
                }
            }
            else{?>
                <tr>
                    <td>
                        <div class="input-group input-group-md btn_est">
                            No se encontró información
                        </div>
                    </td>
                </tr><?php 
            }
        }
        else{?>
            <tr>
                <td>
                    <div class="input-group input-group-md btn_est">
                        No se encontró información
                    </div>
                </td>
            </tr><?php 
        }?>
        </tbody>
    </table>
</div>
<script>empEstudios();</script>