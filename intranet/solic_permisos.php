<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$exp_id = "";
if(isset($_GET["id_emp"]))
{
  $exp_id = $_GET["id_emp"];
}
$res_bus = registroCampo("e3_solic", "e3_solic_id, e3_solic_fsolic, e3_est_id, e3_solic_fini, e3_solic_ffin", "WHERE e3_user_id = '$exp_id' AND e3_tsolic_id = 1", "", "ORDER BY e3_solic_fini DESC");

$class_ver    = " hidden";
$class_editar = " hidden";
$class_borrar = " hidden";
$class_agrega = " hidden";
if(isset($_GET['perm_mod'])){
    $perm_mod     = explode(",", $_GET['perm_mod']);
    $num_perm_mod = count($perm_mod);
    for($i = 0; $i < $num_perm_mod; $i++){
        if($perm_mod[$i] == '1'){
            $class_ver = "";
        }
        elseif($perm_mod[$i] == '2'){
            $class_editar = "";
        }
        elseif($perm_mod[$i] == '3'){
            $class_borrar = "";
        }
        elseif($perm_mod[$i] == '4'){
            $class_agrega = "";
        }
    }
}
?>
<div class="panel-body">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class='col-xs-7 col-sm-4 col-md-2 col-lg-2 text-center'>Fecha solicitud</th>
                <th class='hidden-xs col-sm-4 col-md-3 col-lg-3 text-center'>Fecha inicio</th>
                <th class='hidden-xs hidden-sm col-md-3 col-lg-3 text-center'>Fecha fin</th>
                <th class='col-xs-5 col-sm-4 col-md-4 col-lg-4 text-center'>
                    <div name="<?php echo $exp_id;?>" class="input-group input-group-md btn_est">
                        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_permisos">
                        <input type="hidden" name="input-pagina" id="input-pagina" class="form-control" value="ins_upd_perm"><?php 
                        if($class_agrega == ''){?>
                            <span class="btn btn-warning input-group-addon" title="Nuevo registro"><i class="glyphicon glyphicon-plus"></i></span><?php 
                        }?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody><?php 
        if($res_bus){
            if(mysql_num_rows($res_bus) > 0){
                while ($row_bus = mysql_fetch_array($res_bus)) {
                    if($row_bus[2] == '1'){$clase_fila = "bgrey";}
                    elseif($row_bus[2] == '2'){$clase_fila = "borange";}
                    elseif($row_bus[2] == '4'){$clase_fila = "bred";}
                    elseif($row_bus[2] == '5'){$clase_fila = "bviolet";}
                    else{$clase_fila = "";}?>
                    <tr class="<?php echo $clase_fila;?>">
                        <td class='col-xs-7 col-sm-4 col-md-2 col-lg-2 text-center'><?php echo $row_bus[1];?></td>
                        <td class='hidden-xs col-sm-4 col-md-3 col-lg-3 text-center'><?php echo $row_bus[3];?></td>
                        <td class='hidden-xs hidden-sm col-md-3 col-lg-3 text-center'><?php echo $row_bus[4];?></td>
                        <td class='col-xs-5 col-sm-4 col-md-4 col-lg-4 text-center'>
                            <div name="<?php echo $row_bus[0];?>" class="input-group input-group-md btn_est"><?php 
                                if($class_ver == ''){?>
                                    <span class="btn btn-info input-group-addon" title="Ver Solicitud"><i class="glyphicon glyphicon-eye-open"></i></span><?php 
                                }
                                if($class_editar == ''){
                                    if((($_SESSION['user_perf'] == '3') || ($_SESSION['user_perf'] == '4') || ($_SESSION['user_perf'] == '5') && (($row_bus[2] == '3') || ($row_bus[2] == '4'))) || (($_SESSION['user_perf'] == '1') || (($_SESSION['user_perf'] == '2') && ($row_bus[2] == '2')) || (($_SESSION['user_perf'] == '7') && ($row_bus[2] == '2')) || (($_SESSION['user_perf'] == '9') && (($row_bus[2] == '2') || ($row_bus[2] == '3') || ($row_bus[2] == '1'))))){?>
                                            <span class="btn btn-success input-group-addon" title="Editar Solicitud"> <i class="glyphicon glyphicon-pencil"></i></span><?php 
                                    }
                                }
                                if($class_borrar == ''){?>
                                    <span class="btn btn-danger input-group-addon" name="perm" title="Eliminar Solicitud"> <i class="glyphicon glyphicon-remove"></i></span><?php 
                                }?>
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