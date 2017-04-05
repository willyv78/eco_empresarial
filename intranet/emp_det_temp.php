<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["emp_id"])){$emp_id = $_GET["emp_id"];}
else{$emp_id = "";}
$accion = "Nuevo Empleado";
$nom = "";$ape = "";$ndoc = "";$dir = "";$ind = "";$areat = "";$tel = "";$telf = "";$ext = "";$telc = "";$emailc = "";$emailp = "";$fnac = "";$obs = "";$pub = "";$pad = "";$nome = "";$tele = "";$user = "";$tdoc = "";$tcont = "";$emp = "";$est = "";$carg = "";$area = "";$ciu = "";$tipoc = "";$tpers = "";$perf = "";$empp = "";$gen = "";$sal = "";$fing = "";$card = "";$fent = "";$fsal = "";$img = "";$cta = "";$ban = "";$pval = "";$pent = "";$pfch = "";$tcon = "";$rh = "";$res_bus = empleadoBuscarId($emp_id);$res_hor = false;$res_seg = false;$res_std = false;$res_lab = false;$empr_nom = "";$empr_doc = "";$empr_dir = "";$empr_tel = "";$empr_fax = "";$src = "";$empr_web = "";$emp_sal = "";$div_panel = "rrhh";
if(isset($_GET['div_panel'])){$div_panel = $_GET['div_panel'];}
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $id = $row[0];
        $nom = $row[1];
        $ape = $row[2];
        $ndoc = $row[3];
        $dir = $row[4];
        $ind = $row[5];
        $areat = $row[6];
        if($areat <> ''){$tel .= $areat." ";}
        $telf = $row[7];
        if($telf <> ''){$tel .= $telf." ";}
        $ext = $row[8];
        if(($ext <> '')&&($ext <> 0)){$tel .= "Ext. ".$ext." ";}
        $telc = $row[9];
        if($telc <> ''){$tel .= "Cel. ".$telc." ";}
        $emailc = $row[10];
        $emailp = $row[11];
        $fnac = $row[12];
        $obs = $row[13];
        $pub = $row[14];
        $pad = $row[15];
        $nome = $row[16];
        $tele = $row[17];
        $user = $row[19];
        $tdoc = nombreCampo($row[20], "e3_tdoc");
        $tcont = nombreCampo($row[21], "e3_perf");
        $perf = $row[22];
        $est = nombreCampo($row[23], "e3_est");
        $ciu = nombreCampo($row[24], "e3_ciu");
        $tpers = nombreCampo($row[25], "e3_tper");
        $emp = $row[26];
        $gen = $row[27];
        $fing = $row[28];
        $hora = $row[29];
        $img = $row[30];
        $rh = $row[31];
        $carg = nombreCampo($row[32], "e3_carg");
        $area = nombreCampo($row[33], "e3_area");
        $tipoc = nombreCampo($row[34], "e3_tcont");

        $sal = $row[36];
        $card = $row[37];
        $door = $row[38];
        $cta = $row[39];
        $ban = nombreCampo($row[40], "e3_ban");;
        $pval = $row[41];
        $pent = $row[42];
        $pfch = $row[43];
        $tcon = nombreCampo($row[44], "e3_tcon");
        
        $res_emp = registroCampo('e3_emp', 'e3_emp.*, e3_cont.e3_cont_sal', 'LEFT JOIN e3_cont ON e3_cont.e3_emp_id = e3_emp.e3_emp_id WHERE e3_cont.e3_user_id = "'.$id.'" AND (e3_cont.e3_cont_ffin = "0000-00-00" OR e3_cont.e3_cont_ffin IS NULL)', '', '');
        if($res_emp){
            if(mysql_num_rows($res_emp) > 0){
                $row_emp = mysql_fetch_array($res_emp);
                $empr_nom = $row_emp[1];
                $empr_doc = $row_emp[2];
                $empr_dir = $row_emp[3];
                $empr_tel = $row_emp[4];
                $empr_fax = $row_emp[5];
                $empr_img = base64_decode($row_emp[6]);
                $src = $empr_img;
                $empr_web = $row_emp[7];
                $emp_sal = $row_emp[8];
            }
        }
        $res_hor = registroCampo('e3_horario', 'MIN(e3_horario_dia) AS min, MAX(e3_horario_dia) AS max, e3_horario_hent, e3_horario_hsal', 'WHERE e3_user_id = "'.$emp_id.'" AND e3_horario_dia < 8', 'GROUP BY e3_horario_hent, e3_horario_hsal', 'ORDER BY e3_horario_fini DESC, e3_horario_dia ASC LIMIT 1');
        $res_seg = registroCampo('e3_segsoc', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_segsoc_nom DESC');
        $res_std = registroCampo('e3_std', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_std_fini DESC');
        $res_lab = registroCampo('e3_lab', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_lab_fini DESC');?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-9 text-center h5" style="margin:auto;float:none">
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="">
                        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="<?php echo $div_panel;?>">
                        <input id="id_emp" type="hidden" name="id_emp" value="<?php echo $emp_id;?>">
                    </div>
                </div>
            </div><?php 
            if($emp <> ''){
                if($src <> ''){?>
                    <div class="hidden-xs hidden-sm col-md-12 col-lg-12 text-left">
                        <img src="<?php echo $src;?>" class="img-responsive hidden-print" alt="Logo" style="max-height:200px;">
                    </div><?php 
                }
            }?>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center-block text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <legend class="text-right" style="color:#fff !important;">Datos Personales</legend>
                </div>
                <!-- Datos Personales -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left pull-right">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Nombre: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo strtoupper($nom." ".$ape);?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for=""><?php echo $tdoc.": ";?></label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $ndoc;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Dirección: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $dir;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Teléfono(s): </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $tel;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Email Corporativo: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $emailc;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Email Personal: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $emailp;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Fecha de Nacimiento: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $fnac;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Grupo Sanguíneo y RH: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $rh;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">En caso de emergencia: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $nome;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label" for="">Telefono contacto: </label>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8"><?php echo $tele;?></div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <!-- Datos Contrato -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <legend class="text-right" style="color:#fff !important;">Datos Contrato</legend>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Empresa: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $empr_nom;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha de ingreso: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $fing;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Tipo contrato: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $tcon;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Cargo: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $carg;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Área: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $area;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Salario: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo number_format($sal);?></div>
                        </div>
                        <?php if(($pval <> '')&&($pval > 0)){?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Val Ahorro Vol.: </label>
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $pval;?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Entidad Ahorro: </label>
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $pent;?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha Ahorro: </label>
                                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $pefch;?></div>
                            </div>
                        <?php }?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">No. Carnét: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $card;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Puerta ingreso: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo "Piso ".$door;?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Cuenta Nomina: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php if($cta <> ''){echo $cta." - ".$ban;}else{echo " - o - ";}?></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Horario: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php 
                                if($res_hor){
                                    if(mysql_num_rows($res_hor) > 0){
                                        $nreg = mysql_num_rows($res_hor);
                                        $sq = 1;
                                        while($row_hor = mysql_fetch_array($res_hor)){
                                            $hor_min = diasTres($row_hor[0]);
                                            $hor_max = diasTres($row_hor[1]);
                                            $hor_ent = date("h:i", strtotime($row_hor[2]));
                                            $hor_sal = date("h:i", strtotime($row_hor[3]));
                                            // if($sq == $nreg){echo " y ";}
                                            if($hor_min <> $hor_max){
                                                echo $hor_min." a ".$hor_max." de ".$hor_ent." AM a ".$hor_sal." PM<br>";
                                            }
                                            else{
                                                echo $hor_min." de ".$hor_ent." AM. a ".$hor_sal." PM<br>";
                                            }
                                            $sq += 1;
                                            if($sq > $nreg){echo "<br>";}
                                        }
                                    }
                                    else{echo "No tiene horario";}
                                }?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Afiliaciones: </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php 
                                if($res_seg){
                                    if(mysql_num_rows($res_seg) > 0){
                                        while($row_seg = mysql_fetch_array($res_seg)){
                                            echo $row_seg[1]." - ".$row_seg[2]."<br>";
                                        }
                                    }
                                    else{echo "No tiene afiliaciones";}
                                }?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                    <!-- Estudios Realizados -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend class="text-right" style="color:#fff !important;">Estudios Realizados</legend>
                        <?php 
                        if($res_std){
                            if(mysql_num_rows($res_std) > 0){
                                while($row_std = mysql_fetch_array($res_std)){?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Institución: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_std[1];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Tipo: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo nombreCampo($row_std[2], "e3_tstd");?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Titulo: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_std[3];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha inicio: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_std[4];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha finalización: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_std[5];?></div>
                                    </div>
                                    <?php if($row_std[7] <> ''){?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">No. Tarj. Prof.: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_std[7];?></div>
                                    </div><?php 
                                    }
                                }?>
                                <div class="widget"></div><?php 
                            }
                            else{echo "No tiene estudios realizados";}
                        }?>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                    <!-- Experiencia Laboral -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <legend class="text-right" style="color:#fff !important;">Experiencia Laboral</legend>
                        <?php 
                        if($res_lab){
                            if(mysql_num_rows($res_lab) > 0){
                                while($row_lab = mysql_fetch_array($res_lab)){?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Empresa: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[1];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Cargo: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[2];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha ingreso: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[3];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Fecha retiro: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[4];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Jefe inmediato: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[5];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Teléfono: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[6];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Email: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[7];?></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left div_info">
                                        <label class="col-xs-12 col-sm-5 col-md-5 col-lg-4 control-label pull-left" for="">Motivo retiro: </label>
                                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-right"><?php echo $row_lab[8];?></div>
                                    </div><?php 
                                }
                            }
                            else{echo "No tiene experiencia laboral";}
                        }?>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="widget"></div>
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
                    <div class="widget"></div>
                </div>
            </div><?php 
            if($emp <> ''){?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-warning h6 hidden-print">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;"><?php 
                    if($empr_nom <> ''){
                        echo $empr_nom."  -  NIT ".$empr_doc."  -   ".$empr_dir."  - PBX ".$empr_tel."  - FAX ".$empr_fax;
                    }?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                        <?php echo $empr_web;?>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="widget"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <a href="./emp_det_print.php?emp_id=<?php echo $emp_id;?>" target="_blank">
                        <button id="btn_print" type="button" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
                    </a>
                    <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="widget"></div>
                </div>
            </div>
        </div><?php 
    }
}
?>
<script>
    empTemporal();
</script>






