<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["cont_id"])){
  $cont_id = $_GET["cont_id"];
}
else{
  $cont_id = "";
}
$res_bus = contactoBuscarId($cont_id);
$res_busc = contactoBuscarContactoId($cont_id);

if($res_bus){
  if(mysql_num_rows($res_bus) > 0){
    while($row_bus = mysql_fetch_array($res_bus)){?>
      <!-- contenido contactos -->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <input id="cont_id" type="hidden" name="cont_id" value="<?php echo $cont_id; ?>">
            <legend>
              <div class="clearfix">&nbsp;</div>
              <?php echo $row_bus[1]." ".$row_bus[2]; ?>
              <div class="clearfix">&nbsp;</div>
            </legend>
          </div>
          <?php if ($row_bus[25] == "2"){
            $direccion = "Calle 106 No. 57 - 46 Puente Largo";
            $telefono = $row_bus[34];
          }
          else{
            $indp = "";$indc = "";$tel = "";$ext = "";
            if(($row_bus[5] <> '')&&($row_bus[5] <> 0)){$indp = $row_bus[5];}
            if(($row_bus[6] <> '')&&($row_bus[6] <> 0)){$indc = "(".$row_bus[6].")";}
            if(($row_bus[7] <> '')&&($row_bus[7] <> 0)){$tel = $row_bus[7];}
            if(($row_bus[8] <> '')&&($row_bus[8] <> 0)){$ext = "Ext. ".$row_bus[8];}
            $telefono = $indp." ".$indc." ".$tel." ".$ext;
            $direccion = $row_bus[4];
          }?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Dirección: </dt></div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $direccion;?>&nbsp;</div>
          </div>
          <?php if ($telefono <> ""){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Telefono + Ext. Oficina: </dt></div>
              <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $telefono;?>&nbsp;</div>
            </div>
          <?php }?>
          <?php if ($row_bus[25] <> "2"){ ?>
            <?php if ($row_bus[9] <> ""){ ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Celular: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[9];?>&nbsp;</div>
              </div>
            <?php }?>
          <?php }?>
          <?php if ($row_bus[10] <> ""){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Email: </dt></div>
              <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[10];?>&nbsp;</div>
            </div>
          <?php }?>
          <?php if ($row_bus[25] <> "2"){ ?>
            <?php if ($row_bus[11] <> ""){ ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Email secundario: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[11];?>&nbsp;</div>
              </div>
            <?php }?>
          <?php }?>
        </div>
        <!-- Muestra datos adicionales del contacto -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <legend>
              <div class="clearfix">&nbsp;</div>
              Otros Datos
              <div class="clearfix">&nbsp;</div>
            </legend>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php if ($row_bus[25] <> "2"){ ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Tipo de Documento: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo nombreCampo($row_bus[21], "e3_tdoc"); ?>&nbsp;</div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Número de Documento: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[3];?>&nbsp;</div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Perfil Contacto: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo nombreCampo($row_bus[22], "e3_perf"); ?>&nbsp;</div>
              </div>
            <?php }?>
            <?php if ($row_bus[13] <> ""){ ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Observación: </dt></div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[13]; ?>&nbsp;</div>
              </div>
            <?php }?>
            <?php 
              $paisdptociu = explode(",", nombreCiudadDptoPais($row_bus[24]));
              $pais = $paisdptociu[0];
              $dpto = $paisdptociu[1];
              $ciu = $paisdptociu[2];
            ?>
            <?php if ($row_bus[25] <> "2"){?>
              <?php if ($pais <> ""){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>País: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $pais; ?>&nbsp;</div>
                </div>
              <?php }?>
              <?php if ($dpto <> ""){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Departamento: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $dpto; ?>&nbsp;</div>
                </div>
              <?php }?>
              <?php if ($ciu <> ""){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Ciudad: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $ciu; ?>&nbsp;</div>
                </div>
              <?php }?>
            <?php }?>
            <?php if ($row_bus[25] == "2"){
              $res_cargo = registroCampo("e3_cont", "e3_carg_id, e3_area_id", "WHERE e3_user_id = '".$row_bus[0]."'", "", "");
              if($res_cargo){
                if (mysql_num_rows($res_cargo) > 0) {
                  $row_cargo = mysql_fetch_array($res_cargo);?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Cargo: </dt></div>
                      <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo nombreCampo($row_cargo[0], "e3_carg"); ?>&nbsp;</div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Área: </dt></div>
                      <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo nombreCampo($row_cargo[1], "e3_area"); ?>&nbsp;</div>
                    </div>
                  <?php }
              }?>
              <?php if ($row_bus[17] <> ""){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>En caso de Emergencia: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[17]; ?>&nbsp;</div>
                </div>
              <?php }?>
              <?php if ($row_bus[18] <> ""){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Teléfono: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_bus[18]; ?>&nbsp;</div>
                </div>
              <?php }?>
            <?php }?>
          </div>
        </div>

        <!-- si el contacto tiene otros sub contactos muestra este bloque -->
        <?php 
        if($res_busc){
          if(mysql_num_rows($res_busc) > 0){?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <legend>
                  <div class="clearfix">&nbsp;</div>
                  Otros Contactos
                  <div class="clearfix">&nbsp;</div>
                </legend>
              </div><?php 
              while($row_busc = mysql_fetch_array($res_busc)){?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Nombre / Razón Social: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_busc[1]."  ".$row_busc[2]; ?>&nbsp;</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Dirección: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_busc[4]; ?>&nbsp;</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2"><dt>Telèfono: </dt></div>
                  <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10"><?php echo $row_busc[5] ." ". $row_busc[6] ." ". $row_busc[7] ." ". $row_busc[8]; ?>&nbsp;</div>
                </div><?php 
              }?>
            </div><?php 
            }
          }?>
          <div class="clearfix">&nbsp;</div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="clearfix">&nbsp;</div>
            <button type="button" class="btn btn-default">Regresar</button>
            <div class="clearfix">&nbsp;</div>
          </div>
      </div>
    <?php 
    }
  }
}?>
<!-- JS -->
<script>ver_cont();</script><!-- Mi funcion jquery -->