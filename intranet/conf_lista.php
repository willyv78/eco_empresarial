<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$tabla = "";
$titulo = "";
$where = "";
if(isset($_GET['tbl_db'])){$tabla = $_GET['tbl_db'];}
if($tabla == "e3_perm"){
    $where = "LEFT JOIN e3_mod ON e3_mod.e3_mod_id = e3_perm.e3_mod_id";
    $orden = "ORDER BY e3_perf_id ASC, e3_mod_nom ASC";
}
elseif($tabla == "e3_est"){$orden = "ORDER BY e3_mod_id ASC";}
elseif($tabla == "e3_door"){$orden = "ORDER BY e3_door_noming ASC";}
elseif($tabla == "e3_user"){$orden = "ORDER BY e3_perf_id ASC, e3_user_ape ASC";}
else{$orden = "ORDER BY ".$tabla."_nom ASC";}
if(isset($_GET['tbl_title'])){$titulo = $_GET['tbl_title'];}
$res = registroCampo($tabla, "*", $where, "", $orden);
?>
<div class="table-responsive">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <div class="btn_regresar">
                <button name="" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</button>
                <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nuevo </button>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <div class="page-title">
                <input type="hidden" name="tabla" id="tabla" class="form-control" value="<?php echo $tabla;?>">
                <input type="hidden" name="titulo" id="titulo" class="form-control" value="<?php echo $titulo;?>">
                <h3><?php echo $titulo; ?></h3>
                <span>Tabla Afectada = <?php echo $tabla; ?></span>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th><?php 
                    if($tabla == 'e3_est'){?>
                        <th>Módulo</th><?php 
                    }
                    if($tabla == 'e3_perm'){?>
                        <th>Módulo</th><?php 
                    }
                    if($tabla == 'e3_door'){?>
                        <th>Nom. Archivo</th><?php 
                    }
                    if($tabla == 'e3_user'){?>
                        <th>Perfil</th><?php 
                    }?>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody><?php 
            if($res){
                if(mysql_num_rows($res) > 0){
                    while ($row_tabla = mysql_fetch_array($res)) {?>
                        <tr>
                            <td><?php echo $row_tabla[0];?></td><?php 
                            if($tabla == 'e3_est'){?>
                                <td><?php echo nombreCampo($row_tabla[2], 'e3_mod');?></td><?php 
                            }
                            if($tabla == 'e3_perm'){?>
                                <td><?php echo nombreCampo($row_tabla[1], 'e3_mod');?></td><?php 
                            }
                            if($tabla == 'e3_door'){?>
                                <td><?php echo $row_tabla[3];?></td><?php 
                            }
                            if($tabla == 'e3_user'){?>
                                <td><?php echo nombreCampo($row_tabla[22], 'e3_perf');?></td><?php 
                            }?>
                            <td>
                                <div id="<?php echo $tabla.'-'.$row_tabla[0];?>" class="input-group input-group-md opc_cont"><?php 
                                    if($tabla == 'e3_perm'){
                                        echo nombreCampo($row_tabla[2], 'e3_perf');
                                    }
                                    elseif($tabla == 'e3_user'){
                                        echo $row_tabla[2]." ".$row_tabla[1];
                                    }
                                    else{echo $row_tabla[1];}?>
                                    <span class="input-group-addon" title="Ver Contacto"><i class="glyphicon glyphicon-eye-open"></i></span> 
                                    <span class="input-group-addon" title="Editar Contacto"> <i class="glyphicon glyphicon-pencil"></i></span>
                                    <span class="input-group-addon" title="Eliminar Contacto"> <i class="glyphicon glyphicon-remove"></i></span>
                                </div>
                            </td>
                        </tr><?php 
                    }
                }
                else{?>
                    <tr>
                        <td colspan="2">
                            <div class="alert alert-danger">
                                <strong>Atención!</strong> No se encontraron registros ...
                            </div>
                        </td>
                    </tr><?php 
                }
            }
            else{?>
                <tr>
                    <td colspan="2">
                        <div class="alert alert-danger">
                            <strong>Atención!</strong> No se encontraron registros ...
                        </div>
                    </td>
                </tr><?php 
            }?>
            </tbody>
        </table>
    </div>
</div>

<script>editarConfig();</script>