<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["emp_id"])){$emp_id = $_GET["emp_id"];}
else{$emp_id = "";}

$res_bus = empleadoBuscarId($emp_id);
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $accion = $row[1]." ".$row[2];
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
        $tcont = $row[22];
        $emp = $row[23];
        $est = $row[24];
        $carg = $row[25];
        $area = $row[26];
        $ciu = $row[27];
        $tipoc = $row[28];
        $tpers = $row[29];
        $perf = $row[30];
        $empp = $row[31];
        $gen = $row[32];
        $sal = $row[33];
        $fing = $row[34];
        $card = $row[35];
        $fent = $row[36];
        $fsal = $row[37];
        $img = $row[38];
    }
    else
    {
        $accion = "Nuevo Empleado";
        $nom = "";
        $ape = "";
        $ndoc = "";
        $dir = "";
        $ind = "";
        $areat = "";
        $telf = "";
        $ext = "";
        $telc = "";
        $emailc = "";
        $emailp = "";
        $fnac = "";
        $obs = "";
        $pub = "";
        $pad = "";
        $nome = "";
        $tele = "";
        $user = "";
        $tdoc = "";
        $tcont = "";
        $emp = "";
        $est = "";
        $carg = "";
        $area = "";
        $ciu = "";
        $tipoc = "";
        $tpers = "";
        $perf = "";
        $empp = "";
        $gen = "";
        $sal = "";
        $fing = "";
        $card = "";
        $fent = "";
        $fsal = "";
        $img = "";
    }
}
else
{
    $accion = "Nuevo Empleado";
    $nom = "";
    $ape = "";
    $ndoc = "";
    $dir = "";
    $ind = "";
    $areat = "";
    $telf = "";
    $ext = "";
    $telc = "";
    $emailc = "";
    $emailp = "";
    $fnac = "";
    $obs = "";
    $pub = "";
    $pad = "";
    $nome = "";
    $tele = "";
    $user = "";
    $tdoc = "";
    $tcont = "";
    $emp = "";
    $est = "";
    $carg = "";
    $area = "";
    $ciu = "";
    $tipoc = "";
    $tpers = "";
    $perf = "";
    $empp = "";
    $gen = "";
    $sal = "";
    $fing = "";
    $card = "";
    $fent = "";
    $fsal = "";
    $img = "";
}
$res_std = registroCampo("e3_std", "e3_std_nom, e3_tstd_nom, e3_std_titulo, e3_std_fini, e3_std_fin, e3_std_ffin, e3_std_file, e3_std_tprof, e3_std_file_tprof", "LEFT OUTER JOIN e3_tstd ON e3_std.e3_tstd_id = e3_tstd.e3_tstd_id WHERE e3_user_id = $emp_id", "", "ORDER BY e3_std_ffin DESC");

$res_lab = registroCampo("e3_lab", "e3_lab_nom, e3_lab_carg, e3_lab_fini, e3_lab_ffin, e3_lab_jefe, e3_lab_tel, e3_lab_email, e3_lab_mot, e3_lab_file", "WHERE e3_user_id = $emp_id", "", "ORDER BY e3_lab_ffin DESC");

$res_seg = registroCampo("e3_segsoc", "e3_segsoc_nom, e3_segsoc_fini", "WHERE e3_user_id = $emp_id", "", "ORDER BY e3_segsoc_fini DESC");
?>
<div class="alert alert-info align-center">
    <input id="id_emp" type="hidden" name="id_emp" value="<?php echo $emp_id;?>">
    <h2><?php echo $accion;?></h2>
</div>
<div class="panel-group" id="accordion">
    <!-- Datos Básicos -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_basicos">Datos Básicos</a>
            </h4>
        </div>
        <div id="emp_basicos" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_tdoc_id">Tipo de Documento: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($tdoc, "e3_tdoc");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_doc">Número de Documento: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $ndoc;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_nom">Nombre(s): </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $nom;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_ape">Apellido(s): </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $ape;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_tel">Telefono fijo: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $ind." ".$areat."".$telf."".$ext;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_cel">Teléfono Celular: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $telc;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_email">Email Principal: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $emailc;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_email2">Email Secundario: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $emailp;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_emp_id">Empresa: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($emp, "e3_emp");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_fing">Fecha de  Ingreso: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $fing;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_carg_id">Cargo: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($carg, "e3_carg");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_area_id">Área: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($area, "e3_area");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_sal">Salario: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $sal;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_card">Número de carnét: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $card;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_hing">Hora de Ingreso / Salida: </label>
                    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3"><div class="form-control"><?php echo $fent;?></div></div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4"><div class="form-control"><?php echo $fsal;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_img">Foto carnét:</label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php 
                        if($img <> ''){$src = $img;}
                        else{$src = "../img/fotos/man.jpeg";}?>
                        <img src="<?php echo $src;?>" class="img-responsive" alt="Image" width="20%">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_perf_id">Perfil Contacto: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($tcont, "e3_perf");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_dir">Dirección: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $dir;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_fnac">Fecha de Nacimiento: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $fnac;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_est_id">Estado: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($est, "e3_est");?></div></div>
                </div><?php 
                    $paisdptociu = explode(",", idCiudadDptoPais($ciu));
                    $pais = $paisdptociu[0];
                    $dpto = $paisdptociu[1];
                    $ciu = $paisdptociu[2];?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_pais_id">País: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($pais, "e3_pais");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_dpto_id">Departamento: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($dpto, "e3_dpto");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_ciu_id">Ciudad: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo nombreCampo($ciu, "e3_ciu");?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_emerg_nom">En caso de Emergencia: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $nome;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_emerg_tel">Teléfono: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $tele;?></div></div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label text-right" for="e3_user_obs">Observación: </label>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><div class="form-control"><?php echo $obs;?></div></div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="widget"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Estudios Realizados -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_estudios">Estudios Realizados</a>
            </h4>
        </div>
        <div id="emp_estudios" class="panel-collapse collapse">
            <div class="panel-body"><?php 
                if($res_std){
                    if(mysql_num_rows($res_std) > 0){
                        while ($row_std = mysql_fetch_array($res_std)) {?>
                            <div class="form-group text-right">
                                <legend><?php echo $row_std[2]; ?></legend>
                                <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_estudios">
                            </div>
                            <div class="form-group"><?php 
                                if($row_std[0] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Institución:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_std[0];?></div></div>
                                <?php }
                                if($row_std[2] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Tipo estudio:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_std[1];?></div></div>
                                <?php }
                                if($row_std[3] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Terminado:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php if($row_std[4] == '1'){echo "Terminado";}elseif($row_std[4] == '2'){echo "NO Terminado";}else{echo "Actual";}?></div></div>
                                <?php }
                                if($row_std[4] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Fecha inicio:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_std[3];?></div></div>
                                <?php }
                                if(($row_std[5] <> '')&&($row_std[4] == '1')){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Fecha fin:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_std[5];?></div></div>
                                <?php }
                                if($row_std[6] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Certificado:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><a href="<?php echo $row_std[6];?>" target="_blank">Ver Certificado</a></div></div>
                                <?php }
                                if($row_std[7] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">No. Tarj. Prof.:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_std[7];?></div></div>
                                <?php }
                                if($row_std[8] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Archivo Tarj. Prof.:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><a href="<?php echo $row_std[8];?>" target="_blank">Ver Tarjeta Profesional</a></div></div>
                                <?php }?>
                            </div><?php 
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
            </div>
        </div>
    </div>
    <!-- experiencia Laboral -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_laboral">Experiencia laboral</a>
            </h4>
        </div>
        <div id="emp_laboral" class="panel-collapse collapse">
            <div class="panel-body"><?php 
                if($res_lab){
                    if(mysql_num_rows($res_lab) > 0){
                        while ($row_lab = mysql_fetch_array($res_lab)) {?>
                            <div class="form-group text-right">
                                <legend><?php echo $row_lab[1]; ?></legend>
                                <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_estudios">
                            </div>
                            <div class="form-group"><?php 
                                if($row_lab[0] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Empresa:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[0];?></div></div>
                                <?php }
                                if($row_lab[2] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Fecha inicio:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[2];?></div></div>
                                <?php }
                                if($row_lab[3] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Fecha fin:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[3];?></div></div>
                                <?php }
                                if($row_lab[4] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Jefe inmediato:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[4];?></div></div>
                                <?php }
                                if($row_lab[5] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Teléfono:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[5];?></div></div>
                                <?php }
                                if($row_lab[6] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Email:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[6];?></div></div>
                                <?php }
                                if($row_lab[7] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Motivo Retiro:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_lab[7];?></div></div>
                                <?php }
                                if($row_lab[8] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Certificación:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><a href="<?php echo $row_lab[8];?>" target="_blank">Ver Certificado</a></div></div>
                                <?php }?>
                            </div><?php 
                        }
                    }
                    else{?>
                        <tr>
                            <td>
                                <div class="input-group input-group-md btn_est">No se encontró información</div>
                            </td>
                        </tr><?php 
                    }
                }
                else{?>
                    <tr>
                        <td>
                            <div class="input-group input-group-md btn_est">No se encontró información</div>
                        </td>
                    </tr><?php 
                }?>
            </div>
        </div>
    </div>
    <!-- Seguridad Social -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#emp_seguridad">Seguridad Social</a>
            </h4>
        </div>
        <div id="emp_seguridad" class="panel-collapse collapse">
            <div class="panel-body"><?php 
                if($res_seg){
                    if(mysql_num_rows($res_seg) > 0){
                        while ($row_seg = mysql_fetch_array($res_seg)) {?>
                            <div class="form-group text-right">
                                <legend><?php echo $row_seg[0];?></legend>
                                <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_estudios">
                            </div>
                            <div class="form-group"><?php 
                                if($row_seg[0] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Entidad:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_seg[0];?></div></div>
                                <?php }
                                if($row_seg[1] <> ''){?>
                                    <label class="col-xs-12 col-sm-4 col-md-2 col-lg-2 control-label">Fecha afiliación:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4"><div class="form-control"><?php echo $row_seg[1];?></div></div>
                                <?php }?>
                            </div><?php 
                        }
                    }
                    else{?>
                        <tr>
                            <td>
                                <div class="input-group input-group-md btn_est">No se encontró información</div>
                            </td>
                        </tr><?php 
                    }
                }
                else{?>
                    <tr>
                        <td>
                            <div class="input-group input-group-md btn_est">No se encontró información</div>
                        </td>
                    </tr><?php 
                }?>
            </div>
        </div>
    </div>
</div>
<script>det_emp_ver();</script>