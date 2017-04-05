<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$nom = "";$ape = "";$ndoc = "";$dir = "";$ind = "";$areat = "";$telf = "";$ext = "";$telc = "";$emailc = "";$emailp = "";$fnac = "";$obs = "";$pub = "";$pad = "";$nome = "";$tele = "";$user = "";$tdoc = "";$tcont = "";$emp = "";$est = "";$carg = "";$area = "";$ciu = "";$perf = "";$tpers = "";$userp = "";$gen = "";$fing = "";$hora = "";$img = "";$rh = "";$tel2 = "";$cont_id = "";$accion = "Nuevo Registro";
if(isset($_GET["cont_id"]))
{
  $cont_id = $_GET["cont_id"];
  $accion = "Editar Registro";
}
$res_bus = contactoBuscarId($cont_id);
$res_busc = contactoBuscarContactoId($cont_id);
if($res_bus)
{
  if(mysql_num_rows($res_bus) > 0)
  {
    $row = mysql_fetch_array($res_bus);
    $nom = $row[1];
    $ape = $row[2];
    $ndoc = $row[3];
    $dir = $row[4];
    $ind = $row[5];
    $areat = $row[6];
    $telf = $row[7];
    $ext = $row[8];
    $telc = $row[9];
    $emailc = $row[10];
    $emailp = $row[11];
    $fnac = $row[12];
    $obs = $row[13];
    $pub = $row[14];
    $pad = $row[15];
    $nome = $row[17];
    $tele = $row[18];
    $user = $row[20];
    $tdoc = $row[21];
    $perf = $row[22];
    $est = $row[23];
    $ciu = $row[24];
    $tcont = $row[25];
    $tpers = $row[26];
    $userp = $row[27];
    $emp = $row[28];
    $gen = $row[29];
    $fing = $row[30];
    $hora = $row[31];
    $img = $row[32];
    $rh = $row[33];
    $tel2 = $row[34];
  }
}
?>
<!-- columna izquierda del contenido contactos -->
<form id="form_cont" name="form_cont" action="" method="post" class="form-horizontal">
  <div class="panel-group" id="accordion">

    <!-- Datos Basicos -->
    <div class="panel panel-default">

        <!-- Inicio Datos Básicos -->
        <div id="content_basic" class="panel-collapse btblue">
          <div class="clearfix">&nbsp;</div>
          <legend class="clearfix"><span class="btblue">Datos Básicos</span></legend>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_id">Asignar contacto a?: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelectPadre($pad, "e3_user");?></div>
            <br>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_tcont_id">Tipo de contacto: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($tcont, "e3_tcont");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_tper_id">Naturaleza jurídica: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($tpers, "e3_tper");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_nom">Nombre(s): </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
              <input id="e3_user_nom" type="text" name="e3_user_nom" placeholder="Nombre(s)" value="<?php echo $nom;?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_ape">Apellido(s): </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_ape" type="text" name="e3_user_ape" placeholder="Apellido(s)" value="<?php echo $ape;?>" class="form-control" /></div>
          </div>
          <?php 
          if($tcont == '2'){?>
            <div class="form-group">
              <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_tel2">Telefono + Ext: </label>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_tel2" type="text" name="e3_user_tel2" placeholder="Número + Ext." value="<?php echo $telf2;?>" class="cont-group ntel form-control" />
                <i class="mensaje-box">Num + Ext</i>
              </div>
            </div><?php 
          }
          else{?>
            <div class="form-group">
              <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_tel">Telefono fijo: </label>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_ind" type="text" name="e3_user_ind" placeholder="+57" value="<?php echo $ind;?>" class="cont-group indareaext form-control" />
                <input id="e3_user_area" type="text" name="e3_user_area" placeholder="(1)" value="<?php echo $areat;?>" class="cont-group indareaext form-control" />
                <input id="e3_user_tel" type="text" name="e3_user_tel" placeholder="Número." value="<?php echo $telf;?>" class="cont-group ntel form-control" />
                <input id="e3_user_ext" type="text" name="e3_user_ext" placeholder="Ext." value="<?php echo $ext;?>" class="cont-group indareaext form-control" />
                <i class="mensaje-box">Ind. País + Área + Num + Ext</i>
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_cel">Teléfono Celular: </label>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_cel" type="text" name="e3_user_cel" placeholder="Número celular" value="<?php echo $telc;?>" class="cont-group form-control" /></div>
            </div><?php 
          }?>

          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_email">Email Principal: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_email" type="email" name="e3_user_email" placeholder="Email Principal" value="<?php echo $emailc;?>" class="cont-group form-control" /></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_obs">Observación: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><textarea name="e3_user_obs" id="e3_user_obs" rows="4" placeholder="Ingrese una observación del contacto, algo que le ayude a recordar de quien se trata, o tambien puede colocar el horario en que el contacto esta disponible, si cree que no es necesario deje el campo en blanco." class="form-control" ><?php echo $obs;?></textarea></div>
          </div>
          <div class="clearfix">&nbsp;</div>
        </div>
        <!-- fin datos básicos -->
        <!-- Inicio Otros Datos -->
        <div id="content_other" class="panel-collapse btblue">
          <legend class="clearfix"><span class="btblue">Otros Datos</span></legend>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_email2">Email Secundario: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_email2" type="email" name="e3_user_email2" placeholder="email@secundario.com" value="<?php echo $emailp;?>" class="cont-group form-control" /></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_dir">Dirección: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_dir" type="text" name="e3_user_dir" placeholder="Dirección correspondencia" value="<?php echo $dir;?>" class="cont-group form-control" /></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_tdoc_id">Tipo de Documento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($tdoc, "e3_tdoc");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_doc">Número de Documento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><input id="e3_user_doc" type="text" name="e3_user_doc" placeholder="Número de Documento" value="<?php echo $ndoc;?>" class="form-control" /></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_perf_id">Perfil Contacto: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($tcont, "e3_perf");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_emp_id">Contacto para: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php 
              $dat_emp = explode(",", $emp);
              $num_emp = count($dat_emp);
              // echo count($emp_even);
              $res_emp = registroCampo("e3_emp", "e3_emp_id, e3_emp_nom", "", "", "");
              if($res_emp){
                if(mysql_num_rows($res_emp) > 0){?>
                  <div class="checkbox-emp">
                    <label>
                      <input id="e3_cal_emp_0" type="checkbox" <?php if($num_emp >= mysql_num_rows($res_emp)){echo "checked";}?> name="e3_cal_todos" value="0">Todas
                    </label>
                  </div><?php 
                  while($row_emp = mysql_fetch_array($res_emp)){
                    $checke = "";
                    for($i = 0; $i < $num_emp; $i++){
                      if($dat_emp[$i] == $row_emp[0]){$checke = "checked";}
                    }?>
                    <div class="checkbox-emp">
                      <label>
                        <input id="e3_cal_emp_<?php echo $row_emp[0]; ?>" type="checkbox" <?php echo $checke;?> name="e3_cal_emp[]" value="<?php echo $row_emp[0]; ?>">
                          <?php echo substr($row_emp[1],0,26); ?>
                      </label>
                    </div><?php 
                  }
                }
              }?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_pub">Visualizar: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">

              <div class="radio">
                <label>
                  <input id="e3_user_public" type="radio" name="e3_user_pub" value="1" <?php if(($pub == 1) || ($pub == '')){echo "checked='checked'";}?>>Público 
                </label>
              </div>
              <div class="radio">
                <label>
                  <input id="e3_user_privad" type="radio" name="e3_user_pub" value="0" <?php if(($pub == 0) && ($pub <> '')){echo "checked='checked'";}?>>Privado
                </label>
              </div>

            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_est_id">Estado: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($est, "e3_est");?></div>
          </div><?php 
          $paisdptociu = explode(",", idCiudadDptoPais($ciu));
          $pais = $paisdptociu[0];
          $dpto = $paisdptociu[1];
          $ciu = $paisdptociu[2];?>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_pais_id">País: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($pais, "e3_pais");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_dpto_id">Departamento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($dpto, "e3_dpto");?></div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_ciu_id">Ciudad: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php echo campoSelect($ciu, "e3_ciu");?></div>
          </div>
          <div class="clearfix">&nbsp;</div>
        </div>
        <!-- fin otros datos -->
        <!-- inicio Contactos Asociados -->
        <!-- si el contacto tiene otros sub contactos muestra este bloque -->
        <?php 
        // si el tipo de contacto es diferente a empleado ve esto
        if($tcont <> '2'){
          if($res_busc){
            if(mysql_num_rows($res_busc) > 0){?>
              <div id="content_other2" class="panel-collapse btblue">
                <legend class="clearfix"><span class="btblue">Otros Contactos</span></legend>
                <div class="clearfix">&nbsp;</div>
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>
                        <div class="title_cont"><strong>Nombre / Razón Social</strong></div>
                        <div class="opc_cont">
                          <a id="new_contxxx"></a>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="contenido_edit">
                    <!-- Contenido de la tabla --><?php 
                    while($row_busc = mysql_fetch_array($res_busc))
                    {?>
                      <!-- Otros contactos del contacto original aplica para contacto tipo empresa -->
                      <tr>
                        <td>
                          <div class="title_cont"><?php echo $row_busc[1]."  ".$row_busc[2]; ?></div>
                          <div id="cont_<?php echo $row_busc[0];?>" class="opc_cont">
                            <a>ver</a> | 
                            <a>editar</a> | 
                            <a>eliminar</a>
                          </div>
                        </td>
                      </tr><?php 
                    }?>
                  </tbody>
                  </table>
                <br>
              </div><?php 
            }
          }
        }?>
        <!-- Fin Contactos Asociados -->

    </div>
    <div class="clearfix">&nbsp;</div>
    <!-- Bloque de botones actualizar agregar -->
    <div class="text-center">
      <div class="sidebar-search">
        <button id="botton-ins-upd" class="btn-lg btn-success" type="submit"><?php 
          if(isset($_GET["cont_id"]))
          {?>
            <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $_GET['cont_id'];?>">
            <i class="glyphicon glyphicon-save"></i> Actualizar<?php 
          }
          else
          {?>
            <i class="glyphicon glyphicon-save"></i> Agregar<?php
          }?>              
        </button>
        <button type="button" class="btn-lg btn-default" id="cancelar"><i class="glyphicon glyphicon-save"></i> Cancelar</button>
      </div>
    </div>
  </div>

</form>

<!-- JS -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<!-- Libreria java script que realiza la validacion de los formulariosP -->
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>

<!-- librerias javascript para dar formato a los inputs -->
<script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../js/additional-methods.min.js"></script>
<!-- Validacion del formulario, campos requeridos y formato de campos -->
<script>ver_cont();</script>
<script>
  jQuery(function($)
  {
    $("#e3_user_ind").mask("(+99)");
    $("#e3_user_area").mask("(9999)");
    $("#e3_user_tel").mask("999 9999");
    $("#e3_user_ext").mask("99999");
    $("#e3_user_cel").mask("(999) 999-9999");
  });
  // just for the demos, avoids form submit
  $.validator.setDefaults({
    debug: true,
    success: "valid"
  });
  $("#form_cont").validate({
    // Specify the validation rules
    rules: {
      e3_tcont_id: {
        required: true
      },
      e3_tper_id: {
        required: true
      },
      e3_user_nom:{
        required: true,
        minlength: 3,
        maxlength: 100
      },
      e3_user_tel: {
        require_from_group: [1, ".cont-group"]
      },
      e3_user_cel: {
        require_from_group: [1, ".cont-group"]
      },
      e3_user_email: {
        require_from_group: [1, ".cont-group"],
        email: true
      },
      e3_perf_id: {
        required: function(element) {
          return $("#e3_tcont_id").val() == 2;
        }
      },
      e3_emp_id: {
        required: true
      },
      e3_est_id: {
        required: true
      },
      e3_carg_id: {
        required: function(element) {
          return $("#e3_tcont_id").val() == 2;
        }
      },
      e3_area_id: {
        required: function(element) {
          return $("#e3_tcont_id").val() == 2;
        }
      },
      e3_user_emerg_nom: {
        required: function(element) {
          return $("#e3_tcont_id").val() == 2;
        }
      },
      e3_user_emerg_tel: {
        required: function(element) {
          return $("#e3_tcont_id").val() == 2;
        }
      }
    },
    messages: {
      e3_tcont_id: {
        required: "Seleccione un tipo de contacto"
      },
      e3_tper_id: {
        required: "Seleccione un tipo de naturaleza jurídica"
      },
      e3_user_nom: {
        required: "Campo Requerido",
        minlength: "Se requiere mínimo 3 caracteres",
        maxlength: "El máximo de caracteres es 100."
      },
      e3_user_email: {
        email: "Digite un email válido."
      },
      e3_perf_id: {
        required: "Seleccione el perfil"
      },
      e3_emp_id: {
        required: "Seleccione la empresa"
      },
      e3_est_id: {
        required: "Seleccione el estado"
      },
      e3_carg_id: {
        required: "Seleccione el cargo"
      },
      e3_area_id: {
        required: "Seleccione el área"
      },
      e3_user_emerg_nom: {
        required: "Digite un nombre"
      },
      e3_user_emerg_tel: {
        required: "Digite un número"
      }
    },
    submitHandler: function(form) {      
      var datos_form = new FormData($("#form_cont")[0]);
      //Trer los datos de la shema de la tabla seleccionada
      $.ajax({
        url:"../php/ins_upd_user.php",
        cache:false,
        type:"POST",
        contentType:false,
        data:datos_form,
        processData:false,
        success: function(datos){
          if(datos !== ''){
            $("#contenido_tabla").load("./cont_list.php");
            $("#col_der").load("./cont_det_ed.php");
            $("#col-md-12").load("./contactos.php??emp_id=" + sess_id + "&perm_mod=" + sess_mod_3);
            swal({
                title: "Felicidades!",
                text: "El " + datos + "!",
                type: "success",
                confirmButtonText: "Continuar",
                confirmButtonColor: "#94B86E"
            });
          }
          else{
            swal({
                title: "Ha ocurrido un error!",
                text: "No se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                type: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#E25856"
            });
            return;
          }
        }
      });
    }
  });
</script>