<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$res_bus = registroCampo("e3_user", "e3_user_id, e3_user_nom, e3_user_ape, e3_user_dir, e3_user_tel, e3_user_cel, e3_tcont_id, e3_user_email, e3_user_tel2", "WHERE e3_perf_id <> '1'", "", "ORDER BY e3_user_ape ASC, e3_user_nom ASC");

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
  <!-- Columna izquierda - Tabla lista de contactos -->
  <div class="widget">
    <div class="widget-content_table"><?php
    if(mysql_num_rows($res_bus) > 0){?>
      <table class="table table-hover table-striped" id="table_cont" data-page-length='10'>
        <thead>
          <tr>
            <th class="col-xs-8 col-sm-5 col-md-3 col-lg-3" data-class-name="priority">Nombre</th>
            <th class="hidden-xs hidden-sm col-md-3 col-lg-3">Dirección</th>
            <th class="hidden-xs col-sm-2 col-md-2 col-lg-2">Teléfono</th>
            <th class="hidden-xs col-sm-2 col-md-2 col-lg-2">Perfil</th>
            <th class="col-xs-4 col-sm-3 col-md-3 col-lg-2">
              <div name="" class="input-group input-group-md btn_est"><?php 
                  if($class_agrega == ''){?>
                    <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_permisos">
                    <input type="hidden" name="input-pagina" id="input-pagina" class="form-control" value="ins_upd_perm">
                    <span class="btn btn-warning input-group-addon" id="new_cont" style="position:relative;" title="Nuevo registro">
                      <i class="glyphicon glyphicon-plus"></i>
                    </span><?php 
                  }?>
              </div>
            </th>
          </tr>
        </thead>
        <!-- Contenido de la tabla -->
        <tbody><?php
        while($row_bus = mysql_fetch_array($res_bus)){
          if($row_bus[6] == '2'){
                $direccion = $row_bus[7];
                $telefono = $row_bus[8];
              }
              else{
                $direccion = $row_bus[3];
                $telefono = $row_bus[4];
              }?>
          <tr class="tr_cont">
            <td class="col-xs-8 col-sm-5 col-md-3 col-lg-3">
              <div class="input-group input-group-md"><?php echo $row_bus[2]." ".$row_bus[1]; ?>
              </div>
            </td>
            <td class="hidden-xs hidden-sm col-md-3 col-lg-3"><?php echo $direccion;?>
            </td>
            <td class="hidden-xs col-sm-2 col-md-2 col-lg-2"><?php echo $telefono;?></td>
            <td class="hidden-xs col-sm-2 col-md-2 col-lg-2"><?php echo nombreCampo($row_bus[6], "e3_tcont");?></td>
            <td class="col-xs-4 col-sm-3 col-md-3 col-lg-2 text-center opc_cont">
              <div id="cont_<?php echo $row_bus[0];?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php 
                if($class_ver == ''){?>
                  <span class="btn btn-info" title="Ver Contacto"><i class="glyphicon glyphicon-eye-open"></i></span><?php 
                }
                if(($class_editar == '') && ($row_bus[6] <> '2')){?>
                  <span class="btn btn-success" title="Editar Contacto"><i class="glyphicon glyphicon-pencil"></i></span><?php 
                }
                if(($class_borrar == '') && ($row_bus[6] <> '2')){?>
                  <span class="btn btn-danger" title="Eliminar Contacto"><i class="glyphicon glyphicon-remove"></i></span><?php 
                }?>
              </div>
            </td>
          </tr><?php 
        }?>
        </tbody>
      </table><?php 
    }
    else{?>
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Atención!</strong> No se encontraron resultados...
      </div><?php 
    }?>
    </div>
  </div>
<!-- DataTables -->
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.tableTools.min.js"></script>
<script src="../js/dataTables.jqueryui.min.js"></script>
<script>ed_cont();</script>
<script>
  $(document).ready(function(){
    var table = $('#table_cont').DataTable(
      {
        "lengthChange": true,
        "autoWidth": true,
        "language": {
          "emptyTable":     "No se encontraron registros",
          "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
          "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
          "infoFiltered":   "(filtrado de _MAX_ total registros)",
          "infoPostFix":    "",
          "thousands":      ",",
          "lengthMenu":     "Ver _MENU_ registros",
          "loadingRecords": "Cargando...",
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "zeroRecords":    "No se encontraron registros",
          "paginate": {
              "first":      "Primero",
              "last":       "Ultimo",
              "next":       "Siguiente",
              "previous":   "Anterior"
          },
          "aria": {
              "sortAscending":  ": activar ordenar columnas ascendente",
              "sortDescending": ": activar ordenar columnas descendente"
          }
        }
      }
      );
  });
</script>